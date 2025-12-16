<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <h2 class="mb-4">Administration - Gestion</h2>

    <ul class="nav nav-tabs mb-4" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="avatars-tab" data-bs-toggle="tab" data-bs-target="#avatars" type="button" role="tab">Avatars</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="worlds-tab" data-bs-toggle="tab" data-bs-target="#worlds" type="button" role="tab">Mondes</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">Utilisateurs</button>
        </li>
    </ul>

    <div class="tab-content" id="adminTabContent">
        <!-- Avatars Section -->
        <div class="tab-pane fade show active" id="avatars" role="tabpanel">
            <div class="d-flex justify-content-between mb-3">
                <h4>Liste des Avatars</h4>
                <a href="index.php?page=admin&action=addAvatar" class="btn btn-primary btn-sm">Ajouter un Avatar</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Image</th>
                        <th>Modèle</th> <!-- Added modelAvatar -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($avatars as $avatar): ?>
                    <tr>
                        <td><?= $avatar['idAvatar'] ?></td>
                        <td><?= $avatar['nameAvatar'] ?></td>
                        <td><?= $avatar['imgAvatar'] ?></td>
                        <td><?= $avatar['modelAvatar'] ?? '-' ?></td>
                        <td>
                            <a href="index.php?page=admin&action=editAvatar&id=<?= $avatar['idAvatar'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($avatars)): ?>
                        <tr><td colspan="5" class="text-center">Aucun avatar trouvé</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Worlds Section -->
        <div class="tab-pane fade" id="worlds" role="tabpanel">
            <div class="d-flex justify-content-between mb-3">
                <h4>Liste des Mondes</h4>
                <a href="index.php?page=admin&action=addWorld" class="btn btn-primary btn-sm">Ajouter un Monde</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Image</th>
                        <th>URL</th> <!-- Added urlWorld -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($worlds as $world): ?>
                    <tr>
                        <td><?= $world['idWorld'] ?></td>
                        <td><?= $world['nameWorld'] ?></td>
                        <td><?= $world['imgWorld'] ?></td>
                        <td><?= $world['urlWorld'] ?? '-' ?></td>
                        <td>
                            <a href="index.php?page=admin&action=editWorld&id=<?= $world['idWorld'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($worlds)): ?>
                        <tr><td colspan="5" class="text-center">Aucun monde trouvé</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Users Section -->
        <div class="tab-pane fade" id="users" role="tabpanel">
            <div class="d-flex justify-content-between mb-3">
                <h4>Liste des Utilisateurs</h4>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($users)): ?>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= $user['idUser'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= $user['userRole'] ?></td>
                            <td>
                                <a href="index.php?page=admin&action=editUser&id=<?= $user['idUser'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="index.php?page=admin&action=deleteUser&id=<?= $user['idUser'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">Aucun utilisateur trouvé</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
