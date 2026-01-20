<!--- Affichage des détails d'un livre spécifique --->
<div class="book-detail-wrapper">
    <div class="container" style="color:gray;padding-top:1rem;">
        <a href="../books">Nos livres</a> > <?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>
    </div>
    <div class="book-detail-container">
        <div class="book-detail-image">
            <img
                src="<?php echo $book['image'] ? BASE_URL . '/' . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') : BASE_URL . '/public/img/book-placeholder.jpg'; ?>"
                alt="<?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>"
            />
        </div>

        <div class="book-detail-content">
            <h1 class="book-detail-title"><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></h1>

            <p class="book-detail-author">par <?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?></p>

            <hr class="book-detail-divider">

            <?php if ($book['description']) : ?>
                <div class="book-detail-section">
                    <h3 class="book-detail-section-label">DESCRIPTION</h3>
                    <p class="book-detail-description"><?php echo nl2br(htmlspecialchars($book['description'], ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
            <?php endif; ?>

            <div class="book-detail-section">
                <h3 class="book-detail-section-label">PROPRIÉTAIRE</h3>

                <a href="<?php echo BASE_URL; ?>/user?id=<?php echo htmlspecialchars($book['user_id'], ENT_QUOTES, 'UTF-8'); ?>" class="book-detail-owner">
                    <div class="book-detail-owner-avatar">
                        <?php if (isset($book['avatar']) && $book['avatar']) : ?>
                            <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($book['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar">
                        <?php else : ?>
                            <div class="avatar-placeholder">
                                <?php echo strtoupper(substr($book['pseudo'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="book-detail-owner-info">
                        <p class="book-detail-owner-name"><?php echo htmlspecialchars($book['pseudo'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </a>
            </div>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php if ($_SESSION['user_id'] != $book['user_id']) : ?>
                    <a href="<?php echo BASE_URL; ?>/messages/conversation?user_id=<?php echo htmlspecialchars($book['user_id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-message-full">
                        Envoyer un message
                    </a>
                <?php else : ?>
                    <div class="book-detail-actions">
                        <a href="<?php echo BASE_URL; ?>/books/edit?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-secondary">Modifier</a>
                        <a href="<?php echo BASE_URL; ?>/books/delete?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">Supprimer</a>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary btn-message-full">
                    Connectez-vous pour contacter le propriétaire
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

