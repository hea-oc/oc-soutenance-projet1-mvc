<!-- Vue du profil public d'un utilisateur avec sa bibliothèque de livres -->
<div class="public-profile-wrapper">
    <div class="profile-container">

        <div class="profile-left-column">
            <div class="profile-card">
                <div class="profile-avatar">
                    <?php if ($user['avatar']) : ?>
                        <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($user['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar">
                    <?php else : ?>
                        <div class="avatar-placeholder">
                            <?php echo strtoupper(substr($user['pseudo'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <h1 class="profile-name"><?php echo htmlspecialchars($user['pseudo'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="profile-meta">Membre depuis <?php
                    $created = new DateTime($user['created_at']);
                    $now = new DateTime();
                    $diff = $created->diff($now);

                if ($diff->y > 0) {
                    echo $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
                } elseif ($diff->m > 0) {
                    echo $diff->m . ' mois';
                } elseif ($diff->d > 0) {
                    echo $diff->d . ' jour' . ($diff->d > 1 ? 's' : '');
                } else {
                    echo 'aujourd\'hui';
                }
                ?></p>

                <div class="library-section">
                    <p class="library-label">BIBLIOTHÈQUE</p>
                    <p class="library-count"><?php echo count($books); ?> livre<?php echo count($books) > 1 ? 's' : ''; ?></p>
                </div>

                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $user['id']) : ?>
                    <a href="<?php echo BASE_URL; ?>/messages/conversation?user_id=<?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-message">
                        Écrire un message
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="profile-right-column">
            <div class="books-section">
                <?php if (!empty($books)) : ?>
                    <div class="books-table-wrapper">
                        <table class="books-table">
                            <thead>
                                <tr>
                                    <th>PHOTO</th>
                                    <th>TITRE</th>
                                    <th>AUTEUR</th>
                                    <th>DESCRIPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books as $book) : ?>
                                    <tr>
                                        <td class="table-photo">
                                            <a href="<?php echo BASE_URL; ?>/books/show?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <img src="<?php echo $book['image'] ? BASE_URL . '/' . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') : BASE_URL . '/public/img/book-placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>" class="book-table-image">
                                            </a>
                                        </td>
                                        <td class="table-title">
                                            <a href="<?php echo BASE_URL; ?>/books/show?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" style="color: #1F2937; text-decoration: none; font-weight: 500;">
                                                <?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>
                                            </a>
                                        </td>
                                        <td class="table-author"><?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="table-description">
                                            <?php
                                            $desc = $book['description'] ?? '';
                                            echo htmlspecialchars(mb_strlen($desc) > 100 ? mb_substr($desc, 0, 100) . '...' : $desc, ENT_QUOTES, 'UTF-8');
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="empty-state">
                        <p>Cet utilisateur n'a pas encore ajouté de livres.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
