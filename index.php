<?php
session_start();
if (!defined('BASE_URL')) {
    define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/');
}

// Includes necessários
require_once 'backend/conexao.php';
require_once 'backend/funcoes.php';
require_once 'middleware.php';
require_once 'router.php';

// Rota Raiz (Pública)
Route::get('', 'pages/welcome.php');

// --- Auth ---
Route::get('login',          'pages/auth/form_login.php');
Route::get('cadastro',      'pages/auth/form_cadastro.php');
Route::get('fazer_login',    'backend/auth/login.php');
Route::get('fazer_cadastro', 'backend/auth/cadastrar.php');

// --- Perfil ---
Route::get('perfil',   'pages/auth/perfil.php')->middleware('auth');
Route::get('deslogar', 'backend/auth/deslogar.php')->middleware('auth');
Route::get('atualizar_info', 'backend/auth/atualizar_info.php')->middleware(['auth']);
Route::get('atualizar_senha', 'backend/auth/atualizar_senha.php')->middleware(['auth']);

// --- Default ---
Route::get('anuncios', 'pages/default/anuncios.php')->middleware('auth');

// --- Admin ---
Route::get('dashboard', 'pages/admin/dashboard.php')->middleware(['auth', 'admin']);

// --- dev ---
Route::get('dev/dashboard', 'pages/dev/dashboard.php')->middleware(['auth', 'dev']);


// --- DISPARAR O SISTEMA ---
Route::dispatch();
