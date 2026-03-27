<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css sem cache -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/output.css?v<?= time() ?>">

    <!-- logo do site -->
    <link rel="shortcut icon" href="<?= BASE_URL . "assets/img/logo.png" ?>" type="image/x-icon">

    <!-- icones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title><?= htmlspecialchars((isset($titulo) ? 'Mais Patinhas • ' . $titulo : 'Mais Patinhas')) ?></title>
</head>

<body>