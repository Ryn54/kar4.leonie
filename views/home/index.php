<?php include '../layouts/header.php'; ?>

<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">Connexion</h3>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form action="/SIO2/Challenge/kar4.leonie/public/auth/login" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="d-grid">
                    <a href="/SIO2/Challenge/kar4.leonie/public/avatar/create" class="btn btn-success btn-lg">Créer un
                        Avatar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>