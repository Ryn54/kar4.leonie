<?php include '../views/layouts/header.php'; ?>

<h2 class="text-center mb-5">Création de votre Avatar</h2>

<div class="row mb-5">
    <!-- Left: Inputs -->
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">Vos Informations</div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'Avatar</label>
                    <input type="text" class="form-control" id="name" placeholder="Entrez le nom">
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Choisissez un mot de passe">
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Avatar Selector -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark">Choisir un Personnage</div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div class="carousel-control-btn" onclick="rotateAvatar(-1)">&#10094;</div>
                    
                    <div id="avatar-display" class="text-center flex-grow-1">
                        <?php if(!empty($avatars)): ?>
                            <img id="current-avatar-img" src="<?= $avatars[0] ?>" alt="Avatar" class="img-fluid rounded-circle" style="max-height: 200px; max-width: 200px;">
                            <p id="current-avatar-name" class="mt-2 fw-bold"><?= basename($avatars[0]) ?></p>
                        <?php else: ?>
                             <div class="img-placeholder rounded-circle mx-auto">
                                <span>No Images</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="carousel-control-btn" onclick="rotateAvatar(1)">&#10095;</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom: World Selector -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">Choisir un Monde</div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="carousel-control-btn" onclick="rotateWorld(-1)">&#10094;</div>
                    
                    <div id="world-display" class="text-center flex-grow-1">
                         <?php if(!empty($worlds)): ?>
                            <img id="current-world-img" src="<?= $worlds[0] ?>" alt="World" class="img-fluid" style="max-height: 300px;">
                            <p id="current-world-name" class="mt-2 fw-bold"><?= basename($worlds[0]) ?></p>
                        <?php else: ?>
                             <div class="img-placeholder w-50 mx-auto" style="height: 200px;">
                                <span>No Worlds</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="carousel-control-btn" onclick="rotateWorld(1)">&#10095;</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-4 mb-5">
    <button class="btn btn-primary btn-lg px-5">Valider la création</button>
</div>

<script>
    const avatarImages = <?= json_encode($avatars) ?>;
    const worldImages = <?= json_encode($worlds) ?>;
    
    let currentAvatarIndex = 0;
    let currentWorldIndex = 0;

    function rotateAvatar(dir) {
        if(avatarImages.length === 0) return;
        currentAvatarIndex += dir;
        if(currentAvatarIndex < 0) currentAvatarIndex = avatarImages.length - 1;
        if(currentAvatarIndex >= avatarImages.length) currentAvatarIndex = 0;
        
        document.getElementById('current-avatar-img').src = avatarImages[currentAvatarIndex];
        document.getElementById('current-avatar-name').innerText = avatarImages[currentAvatarIndex].split('/').pop().split('\\').pop();
    }

    function rotateWorld(dir) {
        if(worldImages.length === 0) return;
        currentWorldIndex += dir;
        if(currentWorldIndex < 0) currentWorldIndex = worldImages.length - 1;
        if(currentWorldIndex >= worldImages.length) currentWorldIndex = 0;
        
        document.getElementById('current-world-img').src = worldImages[currentWorldIndex];
        document.getElementById('current-world-name').innerText = worldImages[currentWorldIndex].split('/').pop().split('\\').pop();
    }
</script>

<?php include '../views/layouts/footer.php'; ?>