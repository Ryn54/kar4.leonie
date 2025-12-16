<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <h2 class="mb-4">Modifier l'Avatar</h2>
    <div class="card">
        <div class="card-body">
            <form action="index.php?page=admin&action=updateAvatar" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $avatar['idAvatar'] ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'Avatar</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?= htmlspecialchars($avatar['nameAvatar']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image Actuelle</label>
                    <br>
                    <img src="<?= $avatar['imgAvatar'] ?>" alt="Avatar" width="100">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Changer Image (Optionnel)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Modèle Actuel</label>
                    <p class="form-control-plaintext">
                        <?= $avatar['modelAvatar'] ? basename($avatar['modelAvatar']) : 'Aucun' ?></p>
                </div>

                <div class="mb-3">
                    <label for="model" class="form-label">Changer Modèle 3D (.glb) (Optionnel)</label>
                    <input type="file" class="form-control" id="model" name="model" accept=".glb">
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="index.php?page=admin&action=dashboard" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>