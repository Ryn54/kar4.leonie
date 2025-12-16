<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <h2 class="mb-4">Ajouter un Avatar</h2>
    <div class="card">
        <div class="card-body">
            <form action="index.php?page=admin&action=storeAvatar" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'Avatar</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image (Fichier)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="model" class="form-label">Modèle (Nom/Référence)</label>
                    <input type="text" class="form-control" id="model" name="model" placeholder="Ex: robot_v1">
                </div>
                <button type="submit" class="btn btn-success">Ajouter</button>
                <a href="index.php?page=admin&action=dashboard" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>