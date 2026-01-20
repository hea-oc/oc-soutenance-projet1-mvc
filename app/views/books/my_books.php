<!-- Page de gestion des livres personnels de l'utilisateur -->
<div class="container">
    <div class="my-books-wrapper">

        <div class="my-books-header">
            <div class="header-content">
                <h1 class="page-title">Mes Livres</h1>
                <p class="page-subtitle">Gérez votre bibliothèque personnelle</p>
            </div>
            <a href="<?php echo BASE_URL; ?>/books/create" class="btn btn-primary btn-lg"> + Ajouter un livre</a>
        </div>

        <?php if (!empty($books)) : ?>
            <div class="books-grid">
                <?php foreach ($books as $book) : ?>
                    <article class="card">
                        <a href="<?php echo BASE_URL; ?>/books/show?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" class="card-image">
                            <img src="<?php echo $book['image'] ? BASE_URL . '/' . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') : BASE_URL . '/public/img/book-placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>">
                        </a>
                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="<?php echo BASE_URL; ?>/books/show?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h3>
                            <p class="card-subtitle"><?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <div class="status-badge">
                                <?php if ($book['status'] === 'available') : ?>
                                    <span class="badge badge-available">✓ Disponible</span>
                                <?php else : ?>
                                    <span class="badge badge-unavailable">✗ Indisponible</span>
                                <?php endif; ?>
                            </div>
                            <div class="book-actions">
                                <a href="<?php echo BASE_URL; ?>/books/show?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-secondary btn-sm">Voir</a>
                                <a href="<?php echo BASE_URL; ?>/books/edit?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline btn-sm">Éditer</a>
                                <?php if ($book['status'] === 'available') : ?>
                                    <a href="<?php echo BASE_URL; ?>/books/toggle-status?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>&status=unavailable" class="btn btn-warning btn-sm" onclick="return confirm('Marquer ce livre comme indisponible ?')">Non dispo</a>
                                <?php else : ?>
                                    <a href="<?php echo BASE_URL; ?>/books/toggle-status?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>&status=available" class="btn btn-success btn-sm" onclick="return confirm('Marquer ce livre comme disponible ?')">Disponible</a>
                                <?php endif; ?>
                                <a href="<?php echo BASE_URL; ?>/books/delete?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">Supprimer</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="empty-state">
                <h2>Vous n'avez pas encore ajouté de livres</h2>
                <p>Commencez à partager votre bibliothèque avec la communauté TomTroc</p>
                <a href="<?php echo BASE_URL; ?>/books/create" class="btn btn-primary btn-lg">Ajouter votre premier livre</a>
            </div>
        <?php endif; ?>
    </div>
</div>
