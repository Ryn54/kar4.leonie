<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leonie Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .carousel-item-custom {
            display: none;
            text-align: center;
        }

        .carousel-item-custom.active {
            display: block;
        }

        .carousel-control-btn {
            cursor: pointer;
            font-size: 2rem;
            user-select: none;
        }

        .selection-box {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            background: white;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .img-placeholder {
            width: 150px;
            height: 150px;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/SIO2/Challenge/kar4.leonie/public/">Leonie Logiciel</a>
        </div>
    </nav>
    <div class="container">