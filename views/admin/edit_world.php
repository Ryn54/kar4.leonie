<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <h2 class="mb-4">Modifier le Monde</h2>
    <div class="card">
        <div class="card-body">
            <form action="index.php?page=admin&action=updateWorld" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $world['idWorld'] ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Nom du Monde</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?= htmlspecialchars($world['nameWorld']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image Actuelle</label>
                    <br>
                    <img src="<?= $world['imgWorld'] ?>" alt="World" width="100">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Changer Image (Optionnel)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="url" class="form-label">URL du Monde</label>
                    <input type="text" class="form-control" id="url" name="url"
                        value="<?= htmlspecialchars($world['urlWorld'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="index.php?page=admin&action=dashboard" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>