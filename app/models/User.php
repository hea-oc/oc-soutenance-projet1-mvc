<?php

namespace Models;

use Core\Model;
use PDO;

class User extends Model
{
    public function create(array $data): bool
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (firstname, lastname, pseudo, email, password) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['firstname'], $data['lastname'], $data['pseudo'], $data['email'], $hashedPassword]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByPseudo(string $pseudo): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE pseudo = ?");
        $stmt->execute([$pseudo]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function updateProfile(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET firstname = ?, lastname = ?, pseudo = ?, bio = ? WHERE id = ?");
        return $stmt->execute([$data['firstname'], $data['lastname'], $data['pseudo'], $data['bio'], $id]);
    }

    public function updateAvatar(int $id, string $avatar): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        return $stmt->execute([$avatar, $id]);
    }

    public function updateUser(int $id, array $data): bool
    {
        $fields = [];
        $values = [];

        if (isset($data['email'])) {
            $fields[] = 'email = ?';
            $values[] = $data['email'];
        }

        if (isset($data['pseudo'])) {
            $fields[] = 'pseudo = ?';
            $values[] = $data['pseudo'];
        }

        if (isset($data['password'])) {
            $fields[] = 'password = ?';
            $values[] = $data['password'];
        }

        if (empty($fields)) {
            return false;
        }

        $values[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function findAllWithAvatars(): array
    {
        $stmt = $this->pdo->query("SELECT id, avatar FROM users WHERE avatar IS NOT NULL");
        return $stmt->fetchAll();
    }
}
