<?php

namespace Controllers;

use Core\Controller;
use Models\Book;

class BookController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $query = trim($_GET['q'] ?? '');

        // Validdation de la longueur de la requête de recherche pour éviter les problèmes de perf
        if (strlen($query) > 100) {
            $query = substr($query, 0, 100);
        }

        $bookModel = new Book();

        if ($query !== '') {
            $books = $bookModel->search($query);
        } else {
            $books = $bookModel->findAll();
        }

        $this->render('books/index', ['books' => $books, 'query' => $query]);
    }

    public function show(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect(BASE_URL . '/books');
        }

        $bookModel = new Book();
        $book = $bookModel->findById((int)$id);
        if (!$book || $book['status'] !== 'available') {
            $this->redirect(BASE_URL . '/books');
        }

        $this->render('books/show', ['book' => $book]);
    }

    public function create(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->verifyCsrfToken()) {
                $this->render('books/create', ['error' => 'Invalid CSRF token']);
                return;
            }

            $data = [
                'user_id' => $_SESSION['user_id'],
                'title' => $_POST['title'] ?? '',
                'author' => $_POST['author'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];

            $bookModel = new Book();
            $bookId = $bookModel->create($data);
            if ($bookId) {
                // Upload d'image si fournie
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    $fileSize = $_FILES['image']['size'];

                    // verification du type MIME en utilisant une inspection côté serveur (et non les données fournies par le client)
                    $finfo = new \finfo(FILEINFO_MIME_TYPE);
                    $fileType = $finfo->file($_FILES['image']['tmp_name']);

                    if (!in_array($fileType, $allowedTypes)) {
                        // Supprimer le livre créé en cas d'erreur d'upload
                        $bookModel->delete($bookId, $_SESSION['user_id']);
                        $this->render('books/create', ['error' => 'Format d\'image non supporté. Utilisez JPG, PNG ou GIF.']);
                        return;
                    }

                    if ($fileSize > 2 * 1024 * 1024) { // 2MB
                        $bookModel->delete($bookId, $_SESSION['user_id']);
                        $this->render('books/create', ['error' => 'Image trop grande (max 2MB)']);
                        return;
                    }

                    $uploadDir = __DIR__ . '/../../public/storage/uploads/' . $_SESSION['user_id'] . '/books/' . $bookId . '/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $filename = uniqid() . '_' . basename($_FILES['image']['name']);
                    $uploadFile = $uploadDir . $filename;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        $imagePath = 'storage/uploads/' . $_SESSION['user_id'] . '/books/' . $bookId . '/' . $filename;
                        $bookModel->updateImage($bookId, $imagePath);
                    } else {
                        $bookModel->delete($bookId, $_SESSION['user_id']);
                        $this->render('books/create', ['error' => 'Erreur lors de l\'upload de l\'image']);
                        return;
                    }
                }

                $this->redirect(BASE_URL . '/my-books');
            } else {
                $this->render('books/create', ['error' => 'Failed to add book']);
            }
        } else {
            $this->render('books/create');
        }
    }

    public function edit(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect(BASE_URL . '/profil');
        }

        $bookModel = new Book();
        $book = $bookModel->findById((int)$id);

        if (!$book || (int)$book['user_id'] !== (int)$_SESSION['user_id']) {
            $this->redirect(BASE_URL . '/profil');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->verifyCsrfToken()) {
                $this->render('books/edit', ['book' => $book, 'error' => 'Invalid CSRF token']);
                return;
            }

            $updateData = [
                'title' => $_POST['title'] ?? $book['title'],
                'author' => $_POST['author'] ?? $book['author'],
                'description' => $_POST['description'] ?? $book['description'],
                'status' => $_POST['status'] ?? $book['status']
            ];

            if (!$bookModel->update((int)$id, $_SESSION['user_id'], $updateData)) {
                $this->render('books/edit', ['book' => $book, 'error' => 'Erreur lors de la mise à jour du livre']);
                return;
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileSize = $_FILES['image']['size'];

                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $fileType = $finfo->file($_FILES['image']['tmp_name']);

                if (!in_array($fileType, $allowedTypes)) {
                    $this->render('books/edit', ['book' => $book, 'error' => 'Format d\'image non supporté. Utilisez JPG, PNG ou GIF.']);
                    return;
                }

                if ($fileSize > 2 * 1024 * 1024) {
                    $this->render('books/edit', ['book' => $book, 'error' => 'Image trop grande (max 2MB)']);
                    return;
                }

                $uploadDir = __DIR__ . '/../../public/storage/uploads/' . $_SESSION['user_id'] . '/books/' . $id . '/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $filename = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imagePath = 'storage/uploads/' . $_SESSION['user_id'] . '/books/' . $id . '/' . $filename;
                    $bookModel->updateImage($id, $imagePath);
                } else {
                    $this->render('books/edit', ['book' => $book, 'error' => 'Erreur lors de l\'upload de l\'image']);
                    return;
                }
            }

            $this->redirect(BASE_URL . '/profil');
        } else {
            $this->render('books/edit', ['book' => $book]);
        }
    }

    public function myBooks(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $bookModel = new Book();
        $books = $bookModel->findByUser($_SESSION['user_id']);
        $this->render('books/my_books', ['books' => $books]);
    }

    public function search(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $query = trim($_GET['q'] ?? '');
        // Validdation de la longueur de la requête de recherche
        if (strlen($query) > 100) {
            $query = substr($query, 0, 100);
        }

        $books = [];

        if ($query) {
            $bookModel = new Book();
            $books = $bookModel->search($query);
        }

        $this->render('books/search', ['books' => $books, 'query' => $query]);
    }

    public function delete(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect(BASE_URL . '/my-books');
        }

        $bookModel = new Book();
        if ($bookModel->delete((int)$id, $_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/my-books');
        } else {
            $this->redirect(BASE_URL . '/my-books');
        }
    }
    // Changer le statut du livre
    public function toggleStatus(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;

        if (!$id || !$status) {
            $this->redirect(BASE_URL . '/my-books');
        }

        // Validation du statut
        $allowedStatuses = ['available', 'borrowed', 'unavailable'];
        if (!in_array($status, $allowedStatuses)) {
            $this->redirect(BASE_URL . '/my-books');
        }

        $bookModel = new Book();
        if ($bookModel->updateStatus((int)$id, $_SESSION['user_id'], $status)) {
            $this->redirect(BASE_URL . '/my-books');
        } else {
            $this->redirect(BASE_URL . '/my-books');
        }
    }
}
