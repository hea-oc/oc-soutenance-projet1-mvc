<?php

namespace Models;

use Core\Model;
use PDO;

class Book extends Model
{
    public function create(array $data): int|false
    {
        $stmt = $this->pdo->prepare("INSERT INTO books (user_id, title, author, image, description) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$data['user_id'], $data['title'], $data['author'], $data['image'] ?? null, $data['description'] ?? null])) {
            return (int)$this->pdo->lastInsertId();
        }
        return false;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT books.*, users.pseudo FROM books JOIN users ON books.user_id = users.id WHERE status = 'available' ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function findByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT books.*, users.pseudo, users.avatar, users.created_at as user_created_at FROM books JOIN users ON books.user_id = users.id WHERE books.id = ?");
        $stmt->execute([$id]);
        $book = $stmt->fetch();
        return $book ?: null;
    }

    public function search(string $query): array
    {
        $stmt = $this->pdo->prepare("SELECT books.*, users.pseudo FROM books JOIN users ON books.user_id = users.id WHERE (title LIKE ? OR author LIKE ?) AND status = 'available'");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    public function updateStatus(int $id, int $userId, string $status): bool
    {
        $validStatuses = ['available', 'unavailable'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $stmt = $this->pdo->prepare("UPDATE books SET status = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$status, $id, $userId]);
    }

    public function update(int $id, int $userId, array $data): bool
    {
        $stmt = $this->pdo->prepare("UPDATE books SET title = ?, author = ?, description = ?, status = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([
            $data['title'],
            $data['author'],
            $data['description'] ?? null,
            $data['status'] ?? 'available',
            $id,
            $userId
        ]);
    }

    public function updateImage(int $id, string $image): bool
    {
        $stmt = $this->pdo->prepare("UPDATE books SET image = ? WHERE id = ?");
        return $stmt->execute([$image, $id]);
    }

    public function findAllWithImages(): array
    {
        $stmt = $this->pdo->query("SELECT id, user_id, image FROM books WHERE image IS NOT NULL");
        return $stmt->fetchAll();
    }

    public function delete(int $id, int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function getByUserId(int $userId): array
    {
        return $this->findByUser($userId);
    }
}
