<?php
require_once 'db.php';
$db = new WorldDB();
$users = $db->getUsers();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Laponie VR - Authentification</title>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://binzume.github.io/aframe-xylayout/dist/xylayout-all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/donmccurdy/aframe-extras@v6.1.1/dist/aframe-extras.min.js"></script>

    <script>
        //fonction qui hash le mot de passe
        async function hashPassword(password) {
            const msgBuffer = new TextEncoder().encode(password);
            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        }

        window.isShifted = false;

        AFRAME.registerComponent("keyboard-key", {
            schema: { value: { type: "string", default: "" } },
            //fonction init qui ajoute un event listener sur le click
            //si le bouton est shift, on change la variable isShifted
            //si le bouton est submit, on envoie le formulaire
            //sinon on ajoute le caractere du bouton dans le champ de texte
            init: function () {
                this.el.classList.add("raycastable");
                this.el.addEventListener("click", () => {
                    const input = document.querySelector("#inputText");
                    const label = document.querySelector("#typedLabel");
                    let current = input.getAttribute("value") || "";
                    let display = label.getAttribute("value") || "";

                    if (this.data.value === "space") {
                        input.setAttribute("value", current + " ");
                        label.setAttribute("value", display + " ");
                    } else if (this.data.value === "backspace") {
                        input.setAttribute("value", current.slice(0, -1));
                        label.setAttribute("value", display.slice(0, -1));
                    } else if (this.data.value === "submit") {
                        this.el.sceneEl.emit("submit-login");
                    } else if (this.data.value === "shift") {
                        window.isShifted = !window.isShifted;
                        this.el.sceneEl.emit("keyboard-shift-toggle", { shifted: window.isShifted });
                    } else {
                        let val = this.data.value;
                        val = window.isShifted ? val.toUpperCase() : val.toLowerCase();
                        input.setAttribute("value", current + val);
                        label.setAttribute("value", display + "*");
                    }
                });

                this.el.sceneEl.addEventListener("keyboard-shift-toggle", (e) => {
                    const val = this.data.value;
                    if (val.length === 1 && val !== " ") {
                        const newLabel = e.detail.shifted ? val.toUpperCase() : val.toLowerCase();
                        this.el.setAttribute("label", newLabel);
                    }
                });
            },
        });

        AFRAME.registerComponent("user-selector", {
            schema: {
                id: { type: 'string' },
                name: { type: 'string' },
                world: { type: 'string' },
                url: { type: 'string' }
            },
            //fonction event qui detecte quand l'utilisateur choisi son compte.
            //si le monde est different de laponie, on redirige vers le monde.
            //sinon on affiche le terminal de connexion.
            init: function () {
                this.el.classList.add("raycastable");
                this.el.addEventListener("click", () => {
                    console.log("Clicked user:", this.data);
                    const worldName = this.data.world ? this.data.world.toLowerCase() : "";
                    if (worldName !== "laponie") {
                        if (this.data.url) {
                            window.location.href = this.data.url;
                        } else {
                            alert("URL du monde manquante pour : " + this.data.world);
                        }
                    } else {
                        window.selectedUserId = this.data.id;
                        const loginTerm = document.querySelector("#login-terminal");
                        loginTerm.setAttribute("visible", "true");
                        document.querySelector("#user-name-display").setAttribute("value", "Compte : " + this.data.name);
                    }
                });
            }
        });

        AFRAME.registerComponent('vr-interaction', {
            //fonction qui grossi le profil selectionner quand le lazer et pointé dessus
            init: function () {
                this.el.classList.add("raycastable");
                this.el.addEventListener('mouseenter', () => {
                    this.el.setAttribute('animation__scale', { property: 'scale', to: '1.1 1.1 1.1', dur: 200 });
                });
                this.el.addEventListener('mouseleave', () => {
                    this.el.setAttribute('animation__scale', { property: 'scale', to: '1 1 1', dur: 200 });
                });
                this.el.addEventListener('click', () => {
                    console.log("VR Click detected on:", this.el);
                });
            }
        });

        AFRAME.registerComponent("world-manager", {
            //fonction qui gere le login bouton valider
            //elle recupere le mot de passe et l'envoie au serveur
            //si le mot de passe est correct, elle redirige vers le monde
            init: function () {
                this.el.addEventListener("submit-login", async () => {
                    const input = document.querySelector("#inputText");
                    const password = input.getAttribute("value");
                    if (!window.selectedUserId || !password) return;

                    const hashed = await hashPassword(password);
                    const fd = new FormData();
                    fd.append('userId', window.selectedUserId);
                    fd.append('password', hashed);

                    console.log('Logging in user ID:', window.selectedUserId);
                    console.log('Sending hash:', hashed);

                    fetch('auth.php', { method: 'POST', body: fd })
                        .then(r => r.json())
                        .then(res => {
                            console.log('Server response:', res);
                            if (res.status === 'success') {
                                if (res.world && res.world.toLowerCase() === 'laponie') {
                                    window.location.href = "laponie.html?model=" + encodeURIComponent(res.avatarModel);
                                } else if (res.url) {
                                    window.location.href = res.url;
                                } else {
                                    alert("Monde inconnu ou URL manquante.");
                                }
                            } else {
                                alert(res.message);
                                document.querySelector("#inputText").setAttribute("value", "");
                                document.querySelector("#typedLabel").setAttribute("value", "");
                            }
                        });
                });
            },
            //fonction qui affiche dans le monde de laponie
            enterLaponie: function (modelPath) {
                document.querySelector("#auth-ui").setAttribute("visible", "false");
                document.querySelector("#laponie-world").setAttribute("visible", "true");
                if (modelPath) {
                    const av = document.querySelector("#player-avatar");
                    av.setAttribute("gltf-model", "../" + modelPath);
                    av.setAttribute("visible", "true");
                }
            }
        });

    </script>
</head>

<body>
    <a-scene world-manager background="color: #0d1117" fog="type: exponential; color: #0d1117; density: 0.01">

        <a-light type="ambient" color="#b9d4ff" intensity="0.5"></a-light>
        <a-light type="directional" position="-1 4 1" intensity="0.4"></a-light>

        <a-entity id="rig" position="0 0 0">
            <a-camera position="0 1.6 0">
                <a-cursor color="#FFF" scale="0.5 0.5 0.5"></a-cursor>
            </a-camera>
            <a-entity laser-controls="hand: right" raycaster="objects: .raycastable"
                cursor="downEvents: triggerdown; upEvents: triggerup; rayOrigin: entity"></a-entity>
            <a-entity laser-controls="hand: left" raycaster="objects: .raycastable"
                cursor="downEvents: triggerdown; upEvents: triggerup; rayOrigin: entity"></a-entity>
        </a-entity>

        <a-entity id="auth-ui">


            <a-entity id="user-carousel" position="0 2.2 -2.5">
                <a-text value="Selectionnez votre profil" align="center" position="0 0.8 0" width="4"
                    color="#00d2ff"></a-text>
                <?php
                $count = count($users);
                foreach ($users as $i => $u):
                    $posX = ($i - ($count - 1) / 2) * 1.1;
                    $img = !empty($u['imgAvatar']) ? '../kar4.leonie/' . $u['imgAvatar'] : '../kar4.leonie/public/assets/avatars/default.jpg';
                    ?>
                    <a-entity position="<?= $posX ?> 0 0">
                        <a-circle vr-interaction
                            user-selector="id: <?= $u['idUser'] ?>; name: <?= htmlspecialchars($u['username']) ?>; world: <?= htmlspecialchars($u['nameWorld']) ?>; url: <?= htmlspecialchars($u['urlWorld'] ?? '') ?>"
                            radius="0.45" src="<?= $img ?>" color="#FFF" shadow></a-circle>
                        <a-text value="<?= htmlspecialchars($u['username']) ?>" align="center" position="0 -0.6 0"
                            width="2.5"></a-text>
                    </a-entity>
                <?php endforeach; ?>
            </a-entity>

            <a-entity id="login-terminal" position="0 1.2 -2" visible="false">
                <a-text id="user-name-display" value="Compte : " align="center" position="0 0.8 0" width="3"
                    color="#fbff00"></a-text>

                <a-plane position="0 0.5 0" width="2.0" height="0.25" color="#111">
                    <a-text id="typedLabel" value="Code..." align="center" position="0 0 0.01" width="3"></a-text>
                    <a-text id="inputText" value="" visible="false"></a-text>
                </a-plane>

                <!-- clavier virtuelle -->
                <a-xywindow position="-0.85 0 0" scale="0.12 0.12 0.12" width="14" height="6.5"
                    title="Clavier de Connexion" xycontainer="direction: column; spacing: 0.1">
                    <a-xycontainer direction="row" spacing="0.1">
                        <a-xybutton class="raycastable" label="1" width="1.2" height="1.2"
                            keyboard-key="value:1"></a-xybutton>
                        <a-xybutton class="raycastable" label="2" width="1.2" height="1.2"
                            keyboard-key="value:2"></a-xybutton>
                        <a-xybutton class="raycastable" label="3" width="1.2" height="1.2"
                            keyboard-key="value:3"></a-xybutton>
                        <a-xybutton class="raycastable" label="4" width="1.2" height="1.2"
                            keyboard-key="value:4"></a-xybutton>
                        <a-xybutton class="raycastable" label="5" width="1.2" height="1.2"
                            keyboard-key="value:5"></a-xybutton>
                        <a-xybutton class="raycastable" label="6" width="1.2" height="1.2"
                            keyboard-key="value:6"></a-xybutton>
                        <a-xybutton class="raycastable" label="7" width="1.2" height="1.2"
                            keyboard-key="value:7"></a-xybutton>
                        <a-xybutton class="raycastable" label="8" width="1.2" height="1.2"
                            keyboard-key="value:8"></a-xybutton>
                        <a-xybutton class="raycastable" label="9" width="1.2" height="1.2"
                            keyboard-key="value:9"></a-xybutton>
                        <a-xybutton class="raycastable" label="0" width="1.2" height="1.2"
                            keyboard-key="value:0"></a-xybutton>
                    </a-xycontainer>
                    <a-xycontainer direction="row" spacing="0.1">
                        <a-xybutton class="raycastable" label="a" width="1.2" height="1.2"
                            keyboard-key="value:a"></a-xybutton>
                        <a-xybutton class="raycastable" label="z" width="1.2" height="1.2"
                            keyboard-key="value:z"></a-xybutton>
                        <a-xybutton class="raycastable" label="e" width="1.2" height="1.2"
                            keyboard-key="value:e"></a-xybutton>
                        <a-xybutton class="raycastable" label="r" width="1.2" height="1.2"
                            keyboard-key="value:r"></a-xybutton>
                        <a-xybutton class="raycastable" label="t" width="1.2" height="1.2"
                            keyboard-key="value:t"></a-xybutton>
                        <a-xybutton class="raycastable" label="y" width="1.2" height="1.2"
                            keyboard-key="value:y"></a-xybutton>
                        <a-xybutton class="raycastable" label="u" width="1.2" height="1.2"
                            keyboard-key="value:u"></a-xybutton>
                        <a-xybutton class="raycastable" label="i" width="1.2" height="1.2"
                            keyboard-key="value:i"></a-xybutton>
                        <a-xybutton class="raycastable" label="o" width="1.2" height="1.2"
                            keyboard-key="value:o"></a-xybutton>
                        <a-xybutton class="raycastable" label="p" width="1.2" height="1.2"
                            keyboard-key="value:p"></a-xybutton>
                    </a-xycontainer>
                    <a-xycontainer direction="row" spacing="0.1">
                        <a-xybutton class="raycastable" label="q" width="1.2" height="1.2"
                            keyboard-key="value:q"></a-xybutton>
                        <a-xybutton class="raycastable" label="s" width="1.2" height="1.2"
                            keyboard-key="value:s"></a-xybutton>
                        <a-xybutton class="raycastable" label="d" width="1.2" height="1.2"
                            keyboard-key="value:d"></a-xybutton>
                        <a-xybutton class="raycastable" label="f" width="1.2" height="1.2"
                            keyboard-key="value:f"></a-xybutton>
                        <a-xybutton class="raycastable" label="g" width="1.2" height="1.2"
                            keyboard-key="value:g"></a-xybutton>
                        <a-xybutton class="raycastable" label="h" width="1.2" height="1.2"
                            keyboard-key="value:h"></a-xybutton>
                        <a-xybutton class="raycastable" label="j" width="1.2" height="1.2"
                            keyboard-key="value:j"></a-xybutton>
                        <a-xybutton class="raycastable" label="k" width="1.2" height="1.2"
                            keyboard-key="value:k"></a-xybutton>
                        <a-xybutton class="raycastable" label="l" width="1.2" height="1.2"
                            keyboard-key="value:l"></a-xybutton>
                        <a-xybutton class="raycastable" label="m" width="1.2" height="1.2"
                            keyboard-key="value:m"></a-xybutton>
                    </a-xycontainer>
                    <a-xycontainer direction="row" spacing="0.1">
                        <a-xybutton class="raycastable" label="w" width="1.2" height="1.2"
                            keyboard-key="value:w"></a-xybutton>
                        <a-xybutton class="raycastable" label="x" width="1.2" height="1.2"
                            keyboard-key="value:x"></a-xybutton>
                        <a-xybutton class="raycastable" label="c" width="1.2" height="1.2"
                            keyboard-key="value:c"></a-xybutton>
                        <a-xybutton class="raycastable" label="v" width="1.2" height="1.2"
                            keyboard-key="value:v"></a-xybutton>
                        <a-xybutton class="raycastable" label="b" width="1.2" height="1.2"
                            keyboard-key="value:b"></a-xybutton>
                        <a-xybutton class="raycastable" label="n" width="1.2" height="1.2"
                            keyboard-key="value:n"></a-xybutton>
                        <a-xybutton class="raycastable" label="Maj." width="2.5" height="1.2" keyboard-key="value:shift"
                            color="#555"></a-xybutton>
                        <a-xybutton class="raycastable" label="<-" width="1.2" height="1.2"
                            keyboard-key="value:backspace" color="#f00"></a-xybutton>
                    </a-xycontainer>
                    <a-xycontainer direction="row" spacing="0.1">
                        <a-xybutton class="raycastable" label="Espace" width="6" height="1.2"
                            keyboard-key="value:space"></a-xybutton>
                        <a-xybutton class="raycastable" label="VALIDER" width="5" height="1.2"
                            keyboard-key="value:submit" color="#0f0"></a-xybutton>
                    </a-xycontainer>
                </a-xywindow>
            </a-entity>
        </a-entity>

        <!-- test avant de mettre en place le monde -->
        <!-- <a-entity id="laponie-world" visible="false">
            <a-plane rotation="-90 0 0" width="300" height="300" color="#fff"
                material="roughness: 1; metalness: 0"></a-plane>
            <a-entity id="player-avatar" position="0 0 -3" scale="2 2 2" animation-mixer visible="false"></a-entity>
            <a-entity snow-fall></a-entity>
            <a-entity position="0 60 -50" rotation="10 0 -10">
                <a-cylinder radius="150" height="80" theta-start="90" theta-length="180" open-ended="true"
                    aurora-shader></a-cylinder>
            </a-entity>
            <a-text value="Bienvenue en Laponie" align="center" position="0 5 -10" width="20" color="#FFF"></a-text>
        </a-entity> -->

    </a-scene>
</body>

</html>