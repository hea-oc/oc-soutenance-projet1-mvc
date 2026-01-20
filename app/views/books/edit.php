<!-- Page d'édition des informations d'un livre spécifique -->
<div class="book-edit-wrapper">
    <div class="container" style="color:gray;padding-top:1rem;">
        <a href="<?php echo BASE_URL; ?>/profil">← retour</a>
    </div>

    <div class="book-edit-header">
        <div class="container">
            <h1 class="book-edit-title">Modifier les informations</h1>
        </div>
    </div>

    <?php if (isset($error)) : ?>
        <div class="container">
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="book-edit-container">
        <div class="book-edit-image">
            <?php if (isset($book['image']) && $book['image']) : ?>
                <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Photo du livre" id="preview-image">
            <?php else : ?>
                <img src="<?php echo BASE_URL; ?>/public/img/book-placeholder.jpg" alt="Photo du livre" id="preview-image">
            <?php endif; ?>
            <button type="button" class="btn-modify-photo" onclick="document.getElementById('image').click()">Modifier la photo</button>
        </div>

        <div class="book-edit-content">
            <form action="<?php echo BASE_URL; ?>/books/edit?id=<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="file" id="image" name="image" style="display: none;" accept="image/*" onchange="previewImage(event)">

                <div class="form-group">
                    <label for="title">Titre</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control"
                        placeholder="Titre du livre"
                        value="<?php echo htmlspecialchars($book['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
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
                        value="<?php echo htmlspecialchars($book['author'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="description">Commentaire</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="8"
                        placeholder="Ajoutez un commentaire sur ce livre..."
                    ><?php echo htmlspecialchars($book['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Disponibilité</label>
                    <select name="status" class="form-control">
                        <option value="available" <?php echo (isset($book['status']) && htmlspecialchars($book['status'], ENT_QUOTES, 'UTF-8') === 'available') ? 'selected' : ''; ?>>disponible</option>
                        <option value="unavailable" <?php echo (isset($book['status']) && htmlspecialchars($book['status'], ENT_QUOTES, 'UTF-8') === 'unavailable') ? 'selected' : ''; ?>>non disponible</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-message-full">Valider</button>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
