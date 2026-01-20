<?php

$unreadCount = 0;
if (isset($_SESSION['user_id'])) {
    $messageModel = new \Models\Message();
    $unreadCount = $messageModel->getUnreadCount($_SESSION['user_id']);
}
?>
<!-- Mise en page principale de l'application avec en-tête, pied de page et contenu dynamique -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tom Troc - Partagez vos livres</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style-min.css">
</head>
<body>

    <header>
        <div class="header-container">

            <a href="<?php echo BASE_URL; ?>/" class="logo">
                <img src="<?php echo BASE_URL; ?>/public/img/logo.png" alt="Tom Troc">
            </a>

            <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="nav-main" id="navMain">
                <ul class="nav-links">
                    <li><a href="<?php echo BASE_URL; ?>/">Accueil</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/books">Nos livres à l'échange</a></li>
                </ul>

                <div class="nav-actions">
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <a href="<?php echo BASE_URL; ?>/messages" class="nav-action-link">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span>Messagerie</span>
                            <?php if ($unreadCount > 0) : ?>
                                <span class="notification-badge"><?php echo $unreadCount; ?></span>
                            <?php endif; ?>
                        </a>

                        <a href="<?php echo BASE_URL; ?>/profil" class="nav-action-link">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Mon compte</span>
                        </a>

                        <a href="<?php echo BASE_URL; ?>/logout" class="nav-action-link">
                            <span>Déconnexion</span>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo BASE_URL; ?>/login" class="nav-action-link">
                            <span>Connexion</span>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <?php echo $content; ?>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-left"></div>
            <div class="footer-right">
                <div class="footer-links">
                    <a href="<?php echo BASE_URL; ?>">Politique de confidentialité</a>
                    <a href="<?php echo BASE_URL; ?>">Mentions légales</a>
                    <span>Tom Troc©</span>
                    <div class="footer-logo">
                        <img src="<?php echo BASE_URL; ?>/public/img/logo-footer.png" alt="Tom Troc" style="height: 30px; width: auto;">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const BASE_URL = '<?php echo BASE_URL; ?>';

        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const navMain = document.getElementById('navMain');

            if (menuToggle && navMain) {
                menuToggle.addEventListener('click', function() {
                    navMain.classList.toggle('active');
                    this.classList.toggle('active');
                });
            }
        });
        /*
        function insertEmoji(emoji) {
            const textarea = document.getElementById('message-content');
            if (textarea) {
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const text = textarea.value;
                const before = text.substring(0, start);
                const after = text.substring(end, text.length);
                textarea.value = before + emoji + after;
                textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
                textarea.focus();
            }
        }

        function saveSendOnEnterPreference(enabled) {
            fetch(BASE_URL + '/messages/save-preference', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ send_on_enter: enabled })
            }).catch(error => console.log('Preference save error:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('message-content');
            const checkbox = document.getElementById('send-on-enter');

            if (textarea && checkbox) {
                checkbox.addEventListener('change', function() {
                    saveSendOnEnterPreference(this.checked);
                });

                textarea.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey && checkbox.checked) {
                        e.preventDefault();
                        const form = this.closest('form');
                        if (form) {
                            form.submit();
                        }
                    }
                });
            }
        });*/

        function pollForMessages() {
            const container = document.querySelector('.conversation-container');
            if (!container) return;

            const userId = container.dataset.userId;
            const lastMessageId = container.dataset.lastMessageId;

            fetch(`${BASE_URL}/messages/poll?user_id=${userId}&last_id=${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        const messagesList = document.querySelector('.chat-messages');
                        data.messages.forEach(message => {
                            const messageDiv = createMessageElement(message);
                            messagesList.appendChild(messageDiv);
                            container.dataset.lastMessageId = message.id;
                        });
                        messagesList.scrollTop = messagesList.scrollHeight;
                    }
                })
                .catch(error => console.log('Polling error:', error));
        }

        function createMessageElement(message) {
            const messageDiv = document.createElement('div');
            const isSent = message.sender_id == <?php echo json_encode($_SESSION['user_id'] ?? 0); ?>;
            messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;

            const contentDiv = document.createElement('div');
            contentDiv.className = 'message-content';

            if (message.content === '[MESSAGE_SUPPRIME]') {
                const em = document.createElement('em');
                em.className = 'deleted-message';
                em.textContent = 'Ce message a été supprimé';
                contentDiv.appendChild(em);
            } else {
                contentDiv.textContent = message.content;
            }

            const timeSpan = document.createElement('span');
            timeSpan.className = 'message-time';
            timeSpan.textContent = new Date(message.created_at).toLocaleString('fr-FR');

            messageDiv.appendChild(contentDiv);
            messageDiv.appendChild(timeSpan);
            return messageDiv;
        }

        if (document.querySelector('.conversation-container')) {
            const messagesList = document.querySelector('.chat-messages');
            if (messagesList) {
                messagesList.scrollTop = messagesList.scrollHeight;
            }
            setInterval(pollForMessages, 3000);
        }
    </script>
</body>
</html>
