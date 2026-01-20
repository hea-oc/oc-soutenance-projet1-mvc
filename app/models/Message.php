<?php

namespace Models;

use Core\Model;
use PDO;

class Message extends Model
{
    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$data['sender_id'], $data['receiver_id'], $data['content']]);
    }

    public function findConversation(int $userId1, int $userId2): array
    {
        $stmt = $this->pdo->prepare("SELECT messages.*, u1.firstname as sender_firstname, u1.lastname as sender_lastname, u2.firstname as receiver_firstname, u2.lastname as receiver_lastname FROM messages JOIN users u1 ON messages.sender_id = u1.id JOIN users u2 ON messages.receiver_id = u2.id WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at ASC");
        $stmt->execute([$userId1, $userId2, $userId2, $userId1]);
        return $stmt->fetchAll();
    }

    public function findUserMessages(int $userId): array
    {
        // Récupère le dernier message de chaque conversation avec les infos de l'autre utilisateur
        $stmt = $this->pdo->prepare("
            SELECT
                m.id,
                m.sender_id,
                m.receiver_id,
                m.content,
                m.created_at,
                m.is_read,
                u.firstname,
                u.lastname,
                u.pseudo,
                u.avatar,
                CASE WHEN m.sender_id = ? THEN m.receiver_id ELSE m.sender_id END as other_user_id,
                (SELECT COUNT(*) FROM messages
                 WHERE receiver_id = ?
                 AND sender_id = CASE WHEN m.sender_id = ? THEN m.sender_id ELSE m.receiver_id END
                 AND is_read = 0
                 AND content != '[MESSAGE_SUPPRIME]') as unread_count
            FROM messages m
            JOIN users u ON (CASE WHEN m.sender_id = ? THEN m.receiver_id ELSE m.sender_id END) = u.id
            WHERE m.id IN (
                SELECT MAX(id) FROM messages
                WHERE (sender_id = ? OR receiver_id = ?)
                GROUP BY LEAST(sender_id, receiver_id), GREATEST(sender_id, receiver_id)
            )
            ORDER BY m.created_at DESC
        ");
        $stmt->execute([$userId, $userId, $userId, $userId, $userId, $userId]);
        return $stmt->fetchAll();
    }
    
    public function softDelete(int $messageId, int $userId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE messages SET content = '[MESSAGE_SUPPRIME]' WHERE id = ? AND sender_id = ?");
        return $stmt->execute([$messageId, $userId]);
    }

    public function getNewMessages(int $userId1, int $userId2, int $lastMessageId): array
    {
        $stmt = $this->pdo->prepare("SELECT messages.*, u1.firstname as sender_firstname, u1.lastname as sender_lastname, u2.firstname as receiver_firstname, u2.lastname as receiver_lastname FROM messages JOIN users u1 ON messages.sender_id = u1.id JOIN users u2 ON messages.receiver_id = u2.id WHERE ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) AND messages.id > ? ORDER BY created_at ASC");
        $stmt->execute([$userId1, $userId2, $userId2, $userId1, $lastMessageId]);
        return $stmt->fetchAll();
    }

    public function getUnreadCount(int $userId): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM messages WHERE receiver_id = ? AND is_read = 0 AND content != '[MESSAGE_SUPPRIME]'");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return (int)$result['count'];
    }

    public function markAsRead(int $userId, int $otherUserId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE messages SET is_read = 1 WHERE receiver_id = ? AND sender_id = ? AND is_read = 0");
        return $stmt->execute([$userId, $otherUserId]);
    }

    public function getUnreadCountByConversation(int $userId, int $otherUserId): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM messages WHERE ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) AND receiver_id = ? AND is_read = 0 AND content != '[MESSAGE_SUPPRIME]'");
        $stmt->execute([$userId, $otherUserId, $otherUserId, $userId, $userId]);
        $result = $stmt->fetch();
        return (int)$result['count'];
    }
}
