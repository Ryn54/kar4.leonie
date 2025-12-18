<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <h2 class="mb-4">Modifier Utilisateur</h2>
    <div class="card">
        <div class="card-body">
            <form action="index.php?page=admin&action=updateUser" method="POST">
                <input type="hidden" name="id" value="<?= $user['idUser'] ?>">

                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Rôle</label>
                    <select class="form-select" id="role" name="role">
                        <option value="user" <?= $user['userRole'] == 'user' ? 'selected' : '' ?>>Utilisateur</option>
                        <option value="admin" <?= $user['userRole'] == 'admin' ? 'selected' : '' ?>>Administrateur</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Réinitialiser Mot de Passe (Laisser vide si
                        inchangé)</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Nouveau mot de passe">
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="index.php?page=admin&action=dashboard" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<script>
    // SHA-256 Client-side hashing for password consistency
    document.querySelector('form').addEventListener('submit', async function (e) {
        const pwdField = document.getElementById('password');
        const rawPwd = pwdField.value;

        if (rawPwd) {
            e.preventDefault(); // Stop only to hash
            const msgBuffer = new TextEncoder().encode(rawPwd);
            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
            pwdField.value = hashHex;
            this.submit(); // Resume submit
        }
    });
</script>

<?php include 'views/layouts/footer.php'; ?>