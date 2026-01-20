# TomTroc - Plateforme d'échange de livres

Une application web permettant aux utilisateurs d'échanger des livres entre eux.

## Fonctionnalités

- Inscription et authentification des utilisateurs
- Ajout et gestion de livres personnels
- Recherche de livres disponibles
- Système de messagerie entre utilisateurs
- Gestion de profil utilisateur
- Tableau de bord personnel

## Prérequis

- PHP >= 8.0
- MySQL/MariaDB
- Apache/XAMPP
- Composer

## Installation

1. Cloner le projet dans votre répertoire web

2. Installer les dépendances
```bash
composer install
```

3. Créer la base de données
- Importer le fichier `database/tomtroc.sql` dans phpMyAdmin

4. Configurer la base de données
- Éditer [config/Database.php](config/Database.php) avec vos identifiants

5. Démarrer le serveur
- Accéder à l'application via `http://localhost/project/tomtroc_oc/public/`

## Structure du projet

```
tomtroc_oc/
├── app/
│   ├── controllers/     # Contrôleurs MVC
│   ├── models/          # Modèles de données
│   ├── views/           # Vues HTML/PHP
│   └── core/            # Classes système (Router, Model, Controller)
├── config/              # Configuration (Database, Config)
├── database/            # Scripts SQL
└── public/              # Point d'entrée (index.php, assets)
```

## Technologies

- PHP 8+ (POO, MVC)
- MySQL
- Architecture MVC personnalisée
- PSR-4 Autoloading
