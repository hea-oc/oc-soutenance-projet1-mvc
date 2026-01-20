<!-- Page principale affichant la liste des livres disponibles à l'échange -->
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Nos livres à l'échange</h1>
        <div class="books-search-wrapper">
            <form action="<?php echo BASE_URL; ?>/books" method="get" class="books-search-form">
                <div class="input-group">
                    <input
                        type="text"
                        name="q"
                        class="form-control search-input-small"
                        placeholder="Rechercher un livre"
                        value="<?php echo isset($query) ? htmlspecialchars($query, ENT_QUOTES, 'UTF-8') : ''; ?>"
                    />
                </div>
            </form>
        </div>
    </div>


    <?php if (isset($query) && $query !== '') : ?>
        <div style="max-width: 600px; margin: 0 auto var(--spacing-md); text-align: center;">
            <h2>Résultats pour « <?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?> »</h2>
            <p class="text-secondary"><?php echo count($books); ?> livre<?php echo count($books) > 1 ? 's' : ''; ?> trouvé<?php echo count($books) > 1 ? 's' : ''; ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($books)) : ?>
        <div class="books-grid">
            <?php foreach ($books as $book) : ?>
                <article class="card">
                    <a href="<?php echo BASE_URL; ?>/books/show?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" class="card-image">
                        <img
                            src="<?php echo $book['image'] ? BASE_URL . '/' . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') : BASE_URL . '/public/img/book-placeholder.jpg'; ?>"
                            alt="<?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>"
                        />
                    </a>
                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="<?php echo BASE_URL; ?>/books/show?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h3>
                        <p class="card-subtitle"><?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="card-text mb-3">Vendu par :
                            <a href="<?php echo BASE_URL; ?>/user?id=<?php echo htmlspecialchars($book['user_id'], ENT_QUOTES, 'UTF-8'); ?>" style="color: var(--color-primary); text-decoration: none;">
                                <?php echo htmlspecialchars($book['pseudo'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </p>

                        
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="text-center" style="padding: 4rem 0;">
            <?php if (isset($query) && $query !== '') : ?>
                <p class="text-secondary" style="font-size: 1.125rem;">Aucun livre trouvé pour « <?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?> »</p>
                <a href="<?php echo BASE_URL; ?>/books" class="btn btn-secondary mt-4">Voir tous les livres</a>
            <?php else : ?>
                <p class="text-secondary" style="font-size: 1.125rem;">Aucun livre disponible pour le moment.</p>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <a href="<?php echo BASE_URL; ?>/books/create" class="btn btn-primary mt-4">Ajouter le premier livre</a>
                <?php else : ?>
                    <a href="<?php echo BASE_URL; ?>/register" class="btn btn-primary mt-4">Inscrivez-vous pour ajouter un livre</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
