<!-- Vue pour modifier les informations du profil utilisateur -->
<div class="container">
    <div style="max-width: 600px; margin: 0 auto;">
        <h1 class="page-title">Modifier les informations</h1>

        <?php if (isset($error)) : ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <div style="background: var(--color-bg-white); padding: var(--spacing-2xl); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
            <form action="<?php echo BASE_URL; ?>/profil/edit" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

                <div class="form-group">
                    <label for="avatar">Photo de profil</label>
                    <?php if ($user['avatar']) : ?>
                        <div class="current-avatar mb-3">
                            <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($user['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar actuel" style="max-width: 120px; max-height: 120px; border-radius: 50%;">
                            <p class="text-secondary mt-2" style="font-size: 0.875rem;">Image actuelle</p>
                        </div>
                    <?php endif; ?>
                    <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                    <small class="form-text">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB</small>
                </div>

                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo htmlspecialchars($user['firstname'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo htmlspecialchars($user['lastname'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" id="pseudo" name="pseudo" class="form-control" value="<?php echo htmlspecialchars($user['pseudo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" minlength="4" required>
                    <small class="form-text">Minimum 4 caractères. Ce sera votre nom public sur le site.</small>
                </div>

                <div class="form-group">
                    <label for="bio">Biographie</label>
                    <textarea id="bio" name="bio" class="form-control" rows="4"><?php echo htmlspecialchars($user['bio'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="<?php echo BASE_URL; ?>/profil" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
