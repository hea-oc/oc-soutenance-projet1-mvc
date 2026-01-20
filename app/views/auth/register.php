<div class="auth-layout">
    <div class="auth-form-container">
        <div class="auth-form">
            <h1>Inscription</h1>

            <?php if (isset($error)) : ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>/register" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input
                        type="text"
                        id="firstname"
                        name="firstname"
                        class="form-control"
                        placeholder="Jean"
                        value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input
                        type="text"
                        id="lastname"
                        name="lastname"
                        class="form-control"
                        placeholder="Dupont"
                        value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input
                        type="text"
                        id="pseudo"
                        name="pseudo"
                        class="form-control"
                        placeholder="Votre pseudo"
                        value="<?php echo isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                        minlength="4"
                        required
                    />
                    <small class="form-text">Minimum 4 caractères. Ce sera votre nom public sur le site.</small>
                </div>

                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="votre@email.com"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>"
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
                        placeholder="********"
                        required
                    />
                    <small class="form-text">Minimum 8 caractères</small>
                </div>

                <button type="submit" class="btn btn-primary btn-full">S'inscrire</button>
            </form>

            <div class="auth-links">
                <p>Déjà un compte ? <a href="<?php echo BASE_URL; ?>/login">Connectez-vous</a></p>
            </div>
        </div>
    </div>

    <div class="auth-image-container">
        <img src="<?php echo BASE_URL; ?>/public/img/auth-books.jpg" alt="Bibliothèque" />
    </div>
</div>
