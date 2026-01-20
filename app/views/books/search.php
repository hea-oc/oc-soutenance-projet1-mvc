<!-- Page de recherche de livres avec affichage des résultats -->
<div class="container">
    <div class="search-wrapper">

        <div class="search-header">
            <h1 class="search-title">Rechercher des livres</h1>
            <p class="search-subtitle">Trouvez le livre que vous cherchez parmi notre collection</p>
        </div>

        <div class="search-form-wrapper">
            <form action="<?php echo BASE_URL; ?>/books/search" method="get" class="search-form">
                <div class="search-input-group">
                    <input
                        type="text"
                        name="q"
                        value="<?php echo htmlspecialchars($query ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        placeholder="Titre ou auteur..."
                        class="form-control search-input-small"
                    >
                    <button type="submit" class="btn btn-primary search-button-small">🔍</button>
                </div>
            </form>
        </div>

        <?php if ($query) : ?>
            <div class="results-header">
                <h2>Résultats pour "<strong><?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?></strong>"</h2>
                <p class="results-count"><?php echo count($books); ?> livre<?php echo count($books) > 1 ? 's' : ''; ?> trouvé<?php echo count($books) > 1 ? 's' : ''; ?></p>
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
                                <p class="card-text">Proposé par
                                    <a href="<?php echo BASE_URL; ?>/user?id=<?php echo htmlspecialchars($book['user_id'], ENT_QUOTES, 'UTF-8'); ?>" style="color: var(--color-primary); text-decoration: none;">
                                        <?php echo htmlspecialchars($book['pseudo'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="no-results-container">
                    <p class="no-results">😞 Aucun livre trouvé pour "<strong><?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?></strong>"</p>
                    <p class="no-results-tip">Essayez une autre recherche ou <a href="<?php echo BASE_URL; ?>/books">voir tous les livres disponibles</a></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

