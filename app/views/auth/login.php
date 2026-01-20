<div class="auth-layout">
    <div class="auth-form-container">
        <div class="auth-form">
            <h1>Connexion</h1>

            <?php if (isset($error)) : ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>/login" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="votre@email.com"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                    />
                </div>

                <button type="submit" class="btn btn-primary btn-full">Se connecter</button>
            </form>

            <div class="auth-links">
                <p>Pas de compte ? <a href="<?php echo BASE_URL; ?>/register">Inscrivez-vous</a></p>
            </div>
        </div>
    </div>

    <div class="auth-image-container">
        <img src="<?php echo BASE_URL; ?>/public/img/auth-books.jpg" alt="Bibliothèque" />
    </div>
</div>
