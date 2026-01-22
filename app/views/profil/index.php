<!-- Vue du profil utilisateur avec informations personnelles et liste des livres -->
<div class="profile-wrapper">
    <div class="profile-header-section">
        <div class="profile-header-container">

            <div class="profile-header-left">
                <div class="profile-sidebar-box">
                    <div class="profile-avatar-section">
                        <div class="profile-avatar" id="profile-avatar">
                            <?php if ($user['avatar']) : ?>
                                <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($user['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" id="avatar-preview">
                            <?php else : ?>
                                <div class="avatar-placeholder" id="avatar-preview">
                                    <?php echo strtoupper(substr($user['pseudo'], 0, 2)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <a href="#" class="profile-modify-link" onclick="document.getElementById('avatar-file-input').click(); return false;">modifier</a>
                    </div>

                    <hr class="profile-divider">

                    <div class="profile-info-section">
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

                        <div class="profile-library">
                            <p class="library-label">BIBLIOTHÈQUE</p>
                            <p class="library-count">
                                <span class="book-icon">📚</span> <?php echo count($books); ?> livre<?php echo count($books) > 1 ? 's' : ''; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-header-right">
                <div class="profile-form">
                    <h2 class="form-title">Vos informations personnelles</h2>

                    <form action="<?php echo BASE_URL; ?>/profil/edit" method="post" id="profile-form" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="file" id="avatar-file-input" name="avatar" accept="image/*" style="display: none;">

                        <div class="form-group">
                            <label for="email">Adresse email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Laissez vide pour ne pas changer">
                        </div>

                        <div class="form-group">
                            <label for="pseudo">Pseudo</label>
                            <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?php echo htmlspecialchars($user['pseudo'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <?php if (!empty($books)) : ?>
    <div class="profile-books-section">
        <div class="container">
                <div class="books-table-wrapper">
                    <table class="books-table">
                        <thead>
                            <tr>
                                <th>PHOTO</th>
                                <th>TITRE</th>
                                <th>AUTEUR</th>
                                <th>DESCRIPTION</th>
                                <th>DISPONIBILITÉ</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($books as $book) : ?>
                                <tr>
                                    <td class="table-photo">
                                        <img src="<?php echo $book['image'] ? BASE_URL . '/' . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') : BASE_URL . '/public/img/book-placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>" class="book-table-image">
                                    </td>
                                    <td class="table-title"><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="table-author"><?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="table-description"><?php echo htmlspecialchars(substr($book['description'] ?? '', 0, 50), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="table-status">
                                        <?php if ($book['status'] === 'available') : ?>
                                            <span class="badge badge-available">disponible</span>
                                        <?php else : ?>
                                            <span class="badge badge-unavailable">non dispo.</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="table-actions">
                                        <a href="<?php echo BASE_URL; ?>/books/edit?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" class="action-link action-edit">Éditer</a>
                                        <a href="<?php echo BASE_URL; ?>/books/delete?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" class="action-link action-delete" onclick="return confirm('Supprimer ce livre ?')">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        <?php else : ?>
                <div class="empty-state">
                    <h3>Vous n'avez pas encore ajouté de livres</h3>
                    <p>Commencez à partager votre bibliothèque avec la communauté TomTroc</p>
                    <a href="<?php echo BASE_URL; ?>/books/create" class="btn btn-primary">Ajouter votre premier livre</a>
                </div>
        <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Avatar preview when file selected
document.getElementById('avatar-file-input').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const avatarContainer = document.getElementById('profile-avatar');
            avatarContainer.innerHTML = '<img src="' + event.target.result + '" alt="Avatar" id="avatar-preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">';
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
