<!-- Page pour créer un nouveau livre à ajouter à la collection -->
<div class="container">
    <div style="max-width: 700px; margin: 0 auto;">
        <h1 class="page-title">Ajouter un livre</h1>

        <?php if (isset($error)) : ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <div style="background: var(--color-bg-white); padding: var(--spacing-2xl); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
            <form action="<?php echo BASE_URL; ?>/books/create" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

                <div class="form-group">
                    <label for="image">Photo</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                    <small class="form-text">Formats acceptés: JPG, PNG. Taille max: 2MB</small>
                </div>

                <div class="form-group">
                    <label for="title">Titre</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control"
                        placeholder="Titre du livre"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="author">Auteur</label>
                    <input
                        type="text"
                        id="author"
                        name="author"
                        class="form-control"
                        placeholder="Nom de l'auteur"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="description">Commentaire</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="6"
                        placeholder="Ajoutez un commentaire sur ce livre..."
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Disponibilité</label>
                    <select name="status" id="status" class="form-control">
                        <option value="available">Disponible</option>
                        <option value="unavailable">Non disponible</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Valider</button>
                    <a href="<?php echo BASE_URL; ?>/books" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
