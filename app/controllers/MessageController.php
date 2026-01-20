<?php

namespace Controllers;

use Core\Controller;
use Models\Message;
use Models\User;

class MessageController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $messageModel = new Message();
        $userModel = new User();
        $messages = $messageModel->findUserMessages($_SESSION['user_id']);

        $selectedConversation = [];
        $selectedUser = null;

        // s'il y a des messages charger la première conversation par défaut
        if (!empty($messages)) {
            $firstMessage = reset($messages);
            $otherUserId = $firstMessage['other_user_id'];

            // Marquer les messages comme lus
            $messageModel->markAsRead($_SESSION['user_id'], (int)$otherUserId);

            // Recuperer la conversation
            $selectedConversation = $messageModel->findConversation($_SESSION['user_id'], (int)$otherUserId);
            $selectedUser = $userModel->findById((int)$otherUserId);
        }

        $this->render('messages/index', [
            'messages' => $messages,
            'selectedConversation' => $selectedConversation,
            'selectedUser' => $selectedUser
        ]);
    }

    // Page de conversation entre deux utilisateurs seulement contrairement à index
    public function conversation(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $otherUserId = $_GET['user_id'] ?? null;
        if (!$otherUserId) {
            $this->redirect(BASE_URL . '/messages');
        }

        $messageModel = new Message();
        $userModel = new User();

        $otherUser = $userModel->findById((int)$otherUserId);
        if (!$otherUser) {
            $this->redirect(BASE_URL . '/messages');
        }

        // Marquer les messages comme lus
        $messageModel->markAsRead($_SESSION['user_id'], (int)$otherUserId);

        $conversation = $messageModel->findConversation($_SESSION['user_id'], (int)$otherUserId);

        $this->render('messages/conversation', ['conversation' => $conversation, 'otherUser' => $otherUser]);
    }

    public function send(): void
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->verifyCsrfToken()) {
                http_response_code(403);
                echo json_encode(['error' => 'Invalid CSRF token']);
                return;
            }

            $receiverId = $_POST['receiver_id'] ?? '';
            $content = $_POST['content'] ?? '';

            if (empty($content)) {
                http_response_code(400);
                echo json_encode(['error' => 'Content is required']);
                return;
            }

            $messageModel = new Message();
            $data = [
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => (int)$receiverId,
                'content' => $content
            ];

            if ($messageModel->create($data)) {
                $this->redirect(BASE_URL . '/messages');
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to send message']);
            }
        } else {
            $this->redirect(BASE_URL . '/messages');
        }
    }

    public function delete(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $messageId = $_GET['id'] ?? null;

        if (!$messageId) {
            $this->redirect(BASE_URL . '/messages');
        }

        $messageModel = new Message();
        if ($messageModel->softDelete((int)$messageId, $_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/messages');
        } else {
            $this->redirect(BASE_URL . '/messages');
        }
    }

    // MAJ conversation
    public function poll(): void
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $otherUserId = $_GET['user_id'] ?? null;
        $lastMessageId = $_GET['last_id'] ?? 0;

        if (!$otherUserId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing user_id']);
            return;
        }

        $messageModel = new Message();
        $newMessages = $messageModel->getNewMessages($_SESSION['user_id'], (int)$otherUserId, (int)$lastMessageId);

        header('Content-Type: application/json');
        echo json_encode(['messages' => $newMessages]);
    }

}
