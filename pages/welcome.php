<?php require_once "includes/layout/inicio.php" ?>
<main class="flex flex-col items-center justify-center w-full h-dvh">
    <div class="flex items-center justify-center w-full">
        <img class="h-25" src="<?= BASE_URL . "assets/img/logo.png" ?>" alt="Logo">
    </div>
    <h1 class="text-2xl font-semibold mt-5">Landing Page</h1>
    <div class="w-full flex items-center justify-center gap-3 mt-5">
        <a href="login" class="px-5 py-2 rounded-lg bg-principal text-white hover:bg-principal-hover">Login</a>
        <a href="cadastro" class="px-5 py-2 rounded-lg bg-principal text-white hover:bg-principal-hover">Cadastro</a>
    </div>
</main>
<?php require_once "includes/layout/fim.php" ?>