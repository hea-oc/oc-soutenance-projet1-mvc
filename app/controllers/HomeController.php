<?php

namespace Controllers;

use Core\Controller;
use Models\Book;

class HomeController extends Controller
{
    public function index(): void
    {
        // Récupérer les derniers livres pour la page d'accueil
        $bookModel = new Book();
        $books = $bookModel->getAll();

        $this->render('home/index', ['books' => $books]);
    }
}
