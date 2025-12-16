<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <h2 class="mb-4">Ajouter un Monde</h2>
    <div class="card">
        <div class="card-body">
            <form action="index.php?page=admin&action=storeWorld" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du Monde</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image (Fichier)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">URL du Monde</label>
                    <input type="text" class="form-control" id="url" name="url"
                        placeholder="Ex: https://laponie.example.com">
                </div>
                <button type="submit" class="btn btn-success">Ajouter</button>
                <a href="index.php?page=admin&action=dashboard" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>