<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kar4 Léonie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --christmas-red: #d32f2f;
            --pine-green: #388e3c;
            --snow-white: #ffffff;
            --gold: #fbc02d;
            --dark-text: #2c3e50;
        }

        body {
            /* Mountain Background - Light & Airy */
            background: url('https://images.unsplash.com/photo-1491002052546-bf38f186af56?q=80&w=2608&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            color: var(--dark-text);
        }
        
        /* Overlay to ensure text readability if image is too bright */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.4); /* Light semi-transparent overlay */
            z-index: -1;
        }

        /* Navbar: Clean White with LED Accent */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            position: relative;
        }

        /* LED Strip only at the bottom of navbar */
        .navbar::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ff0000, #ff7f00, #ffff00, #00ff00, #0000ff, #4b0082, #8f00ff);
            background-size: 200% auto;
            animation: led-strip-animation 4s linear infinite;
        }

        .navbar-brand {
            font-family: 'Segoe UI', sans-serif;
            font-weight: 700;
            color: var(--christmas-red) !important;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: none;
        }
        
        .nav-link { color: var(--dark-text) !important; font-weight: 500; }
        .nav-link:hover { color: var(--christmas-red) !important; }

        /* Animation for LEDs */
        @keyframes led-strip-animation {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        /* Cards: White Glassmorphism */
        .card {
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            color: var(--dark-text);
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: rgba(255, 255, 255, 0.9) !important;
            border-bottom: 2px solid var(--pine-green);
            color: var(--pine-green) !important;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Inputs: Clean Light Theme */
        .form-control {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ced4da;
            color: #333;
        }
        
        .form-control:focus {
            background-color: white;
            color: #333;
            border-color: var(--christmas-red);
            box-shadow: 0 0 0 0.25rem rgba(192, 57, 43, 0.2);
        }

        /* Buttons: Modern */
        .btn {
            border-radius: 8px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn-primary { background-color: var(--christmas-red); border: none; }
        .btn-success { background-color: var(--pine-green); border: none; }
        .btn-warning { background-color: var(--gold); color: #333; border: none; }
        .btn-outline-danger { color: var(--christmas-red); border-color: var(--christmas-red); }
        .btn-outline-danger:hover { background-color: var(--christmas-red); color: white; }

        /* Carousel & Layout */
        .carousel-item-custom { display: none; text-align: center; }
        .carousel-item-custom.active { display: block; }
        
        .carousel-control-btn {
            cursor: pointer;
            font-size: 2.5rem;
            user-select: none;
            color: var(--pine-green);
            transition: transform 0.2s, color 0.2s;
            filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));
        }

        .carousel-control-btn:hover {
            color: var(--christmas-red);
            transform: scale(1.1);
        }

        .selection-box {
            border: 2px dashed #b2bec3;
            border-radius: 12px;
            padding: 20px;
            background: rgba(255,255,255,0.5);
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .img-placeholder {
            width: 150px;
            height: 150px;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px auto;
            border-radius: 50%;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
    </style>
    <!-- Model Viewer -->
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.3.0/model-viewer.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 p-3">
        <div class="container">
            <a class="navbar-brand" href="index.php">Kar4 Léonie</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="d-flex align-items-center">
                    <span class="text-light me-3">Bonjour, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                    <a href="index.php?page=auth&action=logout" class="btn btn-outline-danger btn-sm">Se déconnecter</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container">