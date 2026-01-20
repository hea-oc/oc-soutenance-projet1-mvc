<!-- Vue de la conversation entre deux utilisateurs dans la messagerie -->
<div class="conversation-wrapper" data-user-id="<?php echo htmlspecialchars($otherUser['id'], ENT_QUOTES, 'UTF-8'); ?>" data-last-message-id="<?php echo htmlspecialchars(end($conversation)['id'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>">
    <div class="conversation-header">
        <a href="<?php echo BASE_URL; ?>/messages" class="back-button">← Retour</a>
        <div class="conversation-header-info">
            <div class="conversation-header-avatar">
                <?php if (isset($otherUser['avatar']) && $otherUser['avatar']) : ?>
                    <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($otherUser['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar">
                <?php else : ?>
                    <div class="avatar-placeholder-lg">
                        <?php echo strtoupper(substr($otherUser['pseudo'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="conversation-header-details">
                <h1 class="conversation-header-name"><?php echo htmlspecialchars($otherUser['pseudo'], ENT_QUOTES, 'UTF-8'); ?></h1>
            </div>
        </div>
    </div>

    <div class="conversation-container">
        <div class="chat-messages">
            <?php if (!empty($conversation)) : ?>
                <?php foreach ($conversation as $message) : ?>
                    <div class="message <?php echo $message['sender_id'] == $_SESSION['user_id'] ? 'sent' : 'received'; ?>">
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
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="messages-empty">
                    <div class="empty-icon">💬</div>
                    <p>Aucun message dans cette conversation</p>
                    <p class="text-muted">Envoyez le premier message !</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="chat-input-area">
            <form action="<?php echo BASE_URL; ?>/messages/send" method="post" class="message-form">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($otherUser['id'], ENT_QUOTES, 'UTF-8'); ?>">

                <div class="input-wrapper">
                    <textarea
                        id="message-content"
                        name="content"
                        class="message-input"
                        placeholder="Écrivez votre message..."
                        required
                    ></textarea>
                    <button type="submit" class="btn-send">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
