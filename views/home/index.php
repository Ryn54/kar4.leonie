<?php include 'views/layouts/header.php'; ?>

<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">Connexion</h3>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form id="loginForm" action="index.php?page=auth&action=login" method="POST">
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

                <script>
                    document.getElementById('loginForm').addEventListener('submit', async function (e) {
                        e.preventDefault();
                        const pwdField = document.getElementById('password');
                        const rawPwd = pwdField.value;

                        if (rawPwd) {
                            const msgBuffer = new TextEncoder().encode(rawPwd);
                            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
                            const hashArray = Array.from(new Uint8Array(hashBuffer));
                            const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
                            pwdField.value = hashHex;
                        }

                        this.submit();
                    });
                </script>

                <hr class="my-4">

                <div class="d-grid">
                    <a href="index.php?page=avatar&action=create" class="btn btn-success btn-lg">Créer un Avatar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>