<?php include 'views/layouts/header.php'; ?>

<h2 class="text-center mb-5"><?= isset($currentUser) ? "Modification de votre Avatar" : "Création de votre Avatar" ?></h2>

<form id="avatarForm" action="index.php?page=avatar&action=store" method="POST">
    <div class="row mb-5">
        <!-- Left: Inputs -->
        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">Vos Informations</div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="name" name="username" 
                               value="<?= isset($currentUser) ? htmlspecialchars($currentUser['username']) : '' ?>" 
                               <?= isset($currentUser) ? 'readonly' : 'required placeholder="Entrez le nom"' ?> >
                    </div>
                    
                    <?php if(isset($currentUser)): ?>
                        <div class="mb-3">
                            <label class="form-label">Changer le mot de passe</label>
                            <input type="password" class="form-control mb-2" id="pwd" name="password" placeholder="Nouveau mot de passe (laisser vide si inchangé)">
                            <input type="password" class="form-control" id="pwd_confirm" placeholder="Confirmer mot de passe">
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <label for="pwd" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="pwd" name="password" placeholder="Choisissez un mot de passe" required>
                        </div>
                    <?php endif; ?>
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
                                <!-- Initial/Current Display -->
                                <img id="current-avatar-img" src="" alt="Avatar" class="img-fluid rounded-circle" style="max-height: 200px; max-width: 200px;">
                                <h4 id="current-avatar-name" class="mt-3 fw-bold text-primary"></h4>
                                <input type="hidden" id="selected-avatar-id" name="avatar_id" value="">
                            <?php else: ?>
                                 <p>Aucun avatar disponible</p>
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
                                <img id="current-world-img" src="" alt="World" class="img-fluid" style="max-height: 300px;">
                                <h4 id="current-world-name" class="mt-3 fw-bold text-primary"></h4>
                                <input type="hidden" id="selected-world-id" name="world_id" value="">
                            <?php else: ?>
                                 <p>Aucun monde disponible</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="carousel-control-btn" onclick="rotateWorld(1)">&#10095;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4 mb-5">
        <button type="submit" class="btn btn-primary btn-lg px-5">
            <?= isset($currentUser) ? "Valider les modifications" : "Valider la création" ?>
        </button>
    </div>
</form>

<script>
    // PHP Data passed to JS
    const avatars = <?= json_encode($avatars) ?>;
    const worlds = <?= json_encode($worlds) ?>;
    
    // Default or Current User selections
    const userAvatarId = <?= isset($currentUser['idAvatar']) ? $currentUser['idAvatar'] : 'null' ?>;
    const userWorldId = <?= isset($currentUser['idWorld']) ? $currentUser['idWorld'] : 'null' ?>;

    let currentAvatarIndex = 0;
    let currentWorldIndex = 0;

    // Initialize indices based on user selection if exists
    if (userAvatarId) {
        const found = avatars.findIndex(a => a.idAvatar == userAvatarId);
        if (found !== -1) currentAvatarIndex = found;
    }
    
    if (userWorldId) {
        const found = worlds.findIndex(w => w.idWorld == userWorldId);
        if (found !== -1) currentWorldIndex = found;
    }

    // Render Function
    function render() {
        if(avatars.length > 0) {
            const av = avatars[currentAvatarIndex];
            document.getElementById('current-avatar-img').src = av.imgAvatar;
            document.getElementById('current-avatar-name').innerText = av.nameAvatar; // Display Name
            document.getElementById('selected-avatar-id').value = av.idAvatar;
        }

        if(worlds.length > 0) {
            const wd = worlds[currentWorldIndex];
            document.getElementById('current-world-img').src = wd.imgWorld;
            document.getElementById('current-world-name').innerText = wd.nameWorld; // Display Name
            document.getElementById('selected-world-id').value = wd.idWorld;
        }
    }

    function rotateAvatar(dir) {
        if(avatars.length === 0) return;
        currentAvatarIndex += dir;
        if(currentAvatarIndex < 0) currentAvatarIndex = avatars.length - 1;
        if(currentAvatarIndex >= avatars.length) currentAvatarIndex = 0;
        render();
    }

    function rotateWorld(dir) {
        if(worlds.length === 0) return;
        currentWorldIndex += dir;
        if(currentWorldIndex < 0) currentWorldIndex = worlds.length - 1;
        if(currentWorldIndex >= worlds.length) currentWorldIndex = 0;
        render();
    }
    
    // Hashing Script
    document.getElementById('avatarForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const pwdField = document.getElementById('pwd');
        const rawPwd = pwdField.value;
        const confirmField = document.getElementById('pwd_confirm');
        
        // If edit mode and password empty, just submit (no change)
        if(!rawPwd && confirmField) {
            this.submit();
            return;
        }
        
        if (confirmField && rawPwd !== confirmField.value) {
            alert('Les mots de passe ne correspondent pas.');
            return;
        }
        
        if(rawPwd) {
            const msgBuffer = new TextEncoder().encode(rawPwd);
            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
            pwdField.value = hashHex;
        }
        
        this.submit();
    });

    // Initial render
    render();
</script>

<?php include 'views/layouts/footer.php'; ?>