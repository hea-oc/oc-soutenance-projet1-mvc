<!-- Page d'accueil avec présentation et derniers livres ajoutés -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <h1>Rejoignez nos lecteurs passionnés</h1>
                <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</p>
                <a href="<?php echo BASE_URL; ?>/books" class="btn btn-primary">Découvrir</a>
            </div>

            <figure class="hero-image">
                <img src="<?php echo BASE_URL; ?>/public/img/hero-books.jpg" alt="Livres empilés" />
                <figcaption>Hamza</figcaption>
            </figure>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Les derniers livres ajoutés</h2>

        <div class="books-grid">
            <?php if (!empty($books)) : ?>
                <?php foreach (array_slice($books, 0, 4) as $book) : ?>
                    <article class="card">
                        <div class="card-image">
                            <img
                                src="<?php echo $book['image'] ? BASE_URL . '/' . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') : BASE_URL . '/public/img/book-placeholder.jpg'; ?>"
                                alt="<?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>"
                            />
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p class="card-subtitle"><?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="card-text">Vendu par :
                                <a href="<?php echo BASE_URL; ?>/user?id=<?php echo htmlspecialchars($book['user_id'], ENT_QUOTES, 'UTF-8'); ?>" style="color: var(--color-primary); text-decoration: none;">
                                    <?php echo htmlspecialchars($book['pseudo'] ?? 'Anonyme', ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </p>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center text-secondary" style="grid-column: 1 / -1;">Aucun livre disponible pour le moment.</p>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?php echo BASE_URL; ?>/books" class="btn btn-primary">Voir tous les livres</a>
        </div>
    </div>
</section>

<section class="section how-it-works">
    <div class="container">
        
        <div class="how-it-works-grid">
            
            <div class="how-it-works-content">
                <h2 class="section-title">Comment ça marche ?</h2>
                <p class="section-subtitle">Échanger des livres avec TomTroc c'est simple et amusant ! Suivez ces étapes pour commencer :</p>

                <div class="steps-grid">
                    <div class="step-card">
                        <h3>Inscrivez-vous</h3>
                        <p>Créez votre compte gratuitement en quelques clics</p>
                    </div>
                    <div class="step-card">
                        <h3>Ajoutez vos livres</h3>
                        <p>Partagez les livres que vous souhaitez échanger</p>
                    </div>
                    <div class="step-card">
                        <h3>Parcourez</h3>
                        <p>Découvrez les livres disponibles chez d'autres membres</p>
                    </div>
                    <div class="step-card">
                        <h3>Échangez</h3>
                        <p>Proposez un échange et discutez avec les passionnés</p>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="<?php echo BASE_URL; ?>/books" class="btn btn-outline">Voir tous les livres</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="how-it-works-image">
                <img src="<?php echo BASE_URL; ?>/public/img/how-it-works.png" alt="Bibliothèque" />
    </div>
</section>
<section class="section values-section">
    <div class="container">
        <div class="values-grid">
            <div class="values-content">
                <h2>Nos valeurs</h2>
                <p>Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.</p>
                <p>Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.</p>
                <p>Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>
                <p style="margin-top: 2rem; font-style: italic; color: var(--color-text-secondary);">L'équipe Tom Troc</p>
            </div>
            <div class="values-art">
                <img src="<?php echo BASE_URL; ?>/public/img/Vector 2@2x.png" alt="Valeurs Tom Troc" />
            </div>
        </div>
    </div>
</section>
