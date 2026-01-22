<!-- Page principale de la messagerie avec liste des conversations et chat -->
<div class="messagerie-wrapper">
    <?php if (!empty($messages)) : ?>
        <div class="messaging-container">

        <div class="conversations-list">
                <div class="conversations-list-header">
                    <h2>Messagerie</h2>
                </div>
                <?php $firstConversation = reset($messages); ?>
                <?php foreach ($messages as $message) : ?>
                    <a href="#" class="conversation-item <?php echo ($message['unread_count'] > 0) ? 'has-unread' : ''; ?>" data-user-id="<?php echo htmlspecialchars($message['other_user_id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="conversation-avatar">
                            <?php if (isset($message['avatar']) && $message['avatar']) : ?>
                                <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($message['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar">
                            <?php else : ?>
                                <div class="avatar-placeholder">
                                    <?php echo strtoupper(substr($message['firstname'] ?? 'U', 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="conversation-info">
                            <div class="conversation-name">
                                <?php echo htmlspecialchars($message['pseudo'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="conversation-preview">
                                <?php echo htmlspecialchars(substr($message['content'], 0, 50), ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>
                        <div class="conversation-meta">
                            <div class="conversation-time">
                                <?php echo date('H:i', strtotime($message['created_at'])); ?>
                            </div>
                            <?php if ($message['unread_count'] > 0) : ?>
                                <span class="unread-badge"><?php echo $message['unread_count']; ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="chat-pane" id="chatPane">
                <?php if (!empty($selectedConversation)) : ?>
                    <div class="conversation-header">
                        <div class="conversation-header-info">
                            <div class="conversation-header-details">
                                <div class="conversation-avatar">
                                    <?php if (isset($selectedUser['avatar']) && $selectedUser['avatar']) : ?>
                                        <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($selectedUser['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar">
                                    <?php else : ?>
                                        <div class="avatar-placeholder">
                                            <?php echo strtoupper(substr($selectedUser['firstname'] ?? 'U', 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h1 class="conversation-header-name"><?php echo htmlspecialchars($selectedUser['pseudo'], ENT_QUOTES, 'UTF-8'); ?></h1>
                            </div>
                        </div>
                    </div>

                    <div class="chat-messages" id="chatMessages" data-user-id="<?php echo htmlspecialchars($selectedUser['id'], ENT_QUOTES, 'UTF-8'); ?>" data-last-message-id="<?php echo htmlspecialchars(end($selectedConversation)['id'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php foreach ($selectedConversation as $message) : ?>
                            <div class="message <?php echo $message['sender_id'] == $_SESSION['user_id'] ? 'sent' : 'received'; ?>" data-message-id="<?php echo htmlspecialchars($message['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="message-bubble">
                                    <?php if ($message['content'] === '[MESSAGE_SUPPRIME]') : ?>
                                        <em class="deleted-message">Ce message a été supprimé</em>
                                    <?php else : ?>
                                        <div class="message-content">
                                            <?php echo nl2br(htmlspecialchars($message['content'], ENT_QUOTES, 'UTF-8')); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="message-time">
                                        <?php echo date('d/m H:i', strtotime($message['created_at'])); ?>
                                    </div>
                                </div>
                                    <?php if ($message['sender_id'] == $_SESSION['user_id'] && isset($canDeleteMessage) && $message['content'] !== '[MESSAGE_SUPPRIME]') : ?>
                                        <div style="text-align: right; margin-top: 4px;">
                                        <a href="#" class="message-delete" data-message-id="<?php echo htmlspecialchars($message['id'], ENT_QUOTES, 'UTF-8'); ?>" data-user-id="<?php echo htmlspecialchars($selectedUser['id'], ENT_QUOTES, 'UTF-8'); ?>" title="Supprimer">Supprimer</a>
                                        </div>
                                    <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="chat-input-area">
                        <form action="<?php echo BASE_URL; ?>/messages/send" method="post" class="message-form" id="messageForm">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($selectedUser['id'], ENT_QUOTES, 'UTF-8'); ?>" id="receiverId">

                            <div class="input-wrapper">
                                <textarea
                                    id="message-content"
                                    name="content"
                                    class="message-input"
                                    placeholder="Écrivez votre message..."
                                    aria-label="Contenu du message"
                                    required
                                ></textarea>
                                <button type="submit" class="btn-send">Envoyer</button>
                            </div>
                        </form>
                    </div>
                <?php else : ?>
                    <div class="conversations-empty">
                        <div class="empty-state-icon"></div>
                        <p>Sélectionnez une conversation pour commencer à discuter</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else : ?>
        <div class="empty-state">
            <div class="empty-state-icon"></div>
            <h2>Vous n'avez pas encore de messages</h2>
            <p>Commencez une conversation en contactant un propriétaire de livre !</p>
            <a href="<?php echo BASE_URL; ?>/books" class="btn btn-primary">Découvrir les livres</a>
        </div>
    <?php endif; ?>
</div>



<script>
// JavaScript pour gérer la messagerie en temps réel
    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionner le premier élément de conversation par défaut
        const conversationItems = document.querySelectorAll('.conversation-item');
        if (conversationItems.length > 0) {
            conversationItems[0].classList.add('active');
        }
        // Gérer le clic sur une conversation
        conversationItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.getAttribute('data-user-id');
                const userName = this.querySelector('.conversation-name').textContent;

                conversationItems.forEach(conv => conv.classList.remove('active'));

                this.classList.add('active');

                const headerName = document.querySelector('.conversation-header-name');
                if (headerName) {
                    headerName.textContent = userName;
                }

                loadConversation(userId);
            });
        });
        // Gérer l'envoi de messages
        const messageForm = document.getElementById('messageForm');
        if (messageForm) {
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const chatMessages = document.getElementById('chatMessages');

                fetch('<?php echo BASE_URL; ?>/messages/send', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {

                        document.getElementById('message-content').value = '';

                        const userId = chatMessages.getAttribute('data-user-id');
                        loadConversation(userId);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        }
        // Gérer la suppression de messages
        document.addEventListener('click', function(e) {
            const deleteLink = e.target.closest('.message-delete');
            if (deleteLink) {
                e.preventDefault();
                const messageId = deleteLink.getAttribute('data-message-id');
                const userId = deleteLink.getAttribute('data-user-id');

                if (confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
                    fetch('<?php echo BASE_URL; ?>/messages/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + messageId + '&user_id=' + userId
                    })
                    .then(response => {
                        if (response.ok) {
                            const userId = deleteLink.getAttribute('data-user-id');
                            loadConversation(userId);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        });
        // Fonction de polling pour vérifier les nouveaux messages
        function pollMessages() {
            const chatMessages = document.getElementById('chatMessages');
            if (!chatMessages) return;

            const userId = chatMessages.getAttribute('data-user-id');
            const lastMessageId = chatMessages.getAttribute('data-last-message-id');

            fetch('<?php echo BASE_URL; ?>/messages/poll?user_id=' + userId + '&last_id=' + lastMessageId)
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        loadConversation(userId);
                    }
                })
                .catch(error => console.error('Polling error:', error));
        }
        // Lancer le polling toutes les 3 secondes
        setInterval(pollMessages, 3000);

        function loadConversation(userId) {
            fetch('<?php echo BASE_URL; ?>/messages/conversation?user_id=' + userId)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const chatMessagesElement = doc.querySelector('.chat-messages');
                    const chatInputArea = doc.querySelector('.chat-input-area');

                    if (chatMessagesElement && chatInputArea) {
                        const chatPane = document.getElementById('chatPane');

                        const messagesContainer = chatPane.querySelector('.chat-messages');
                        const inputContainer = chatPane.querySelector('.chat-input-area');

                        if (messagesContainer) {
                            messagesContainer.innerHTML = chatMessagesElement.innerHTML;
                            messagesContainer.setAttribute('data-user-id', chatMessagesElement.getAttribute('data-user-id'));
                            messagesContainer.setAttribute('data-last-message-id', chatMessagesElement.getAttribute('data-last-message-id'));
                        }

                        if (inputContainer) {
                            inputContainer.innerHTML = chatInputArea.innerHTML;
                        }

                        const newForm = document.getElementById('messageForm');
                        if (newForm) {
                            newForm.addEventListener('submit', function(e) {
                                e.preventDefault();
                                const formData = new FormData(this);
                                const chatMessages = document.getElementById('chatMessages');

                                fetch('<?php echo BASE_URL; ?>/messages/send', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => {
                                    if (response.ok) {
                                        document.getElementById('message-content').value = '';
                                        const userId = chatMessages.getAttribute('data-user-id');
                                        loadConversation(userId);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                            });
                        }

                        const messagesContainer2 = document.getElementById('chatMessages');
                        if (messagesContainer2) {
                            messagesContainer2.scrollTop = messagesContainer2.scrollHeight;
                        }
                    }
                })
                .catch(error => console.error('Error loading conversation:', error));
        }

        const messagesContainer = document.getElementById('chatMessages');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    });
</script>
