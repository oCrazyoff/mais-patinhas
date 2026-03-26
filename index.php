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

// --- Guest ---
Route::get('login',          'pages/auth/login.php')->middleware('guest');
Route::get('cadastrar',      'pages/auth/cadastrar.php')->middleware('guest');
Route::get('fazer_login',    'backend/auth/login.php')->middleware('guest');
Route::get('fazer_cadastro', 'backend/auth/cadastrar.php')->middleware('guest');

// --- Auth (Logado) ---
Route::get('perfil',   'pages/auth/perfil.php')->middleware('auth');
Route::get('deslogar', 'backend/auth/deslogar.php')->middleware('auth');
Route::get('mais', 'pages/admin/mais.php')->middleware(['auth']);
Route::get('atualizar_info', 'backend/auth/atualizar_info.php')->middleware(['auth']);
Route::get('atualizar_senha', 'backend/auth/atualizar_senha.php')->middleware(['auth']);

// --- Cliente ---
Route::get('cardapio', 'pages/cardapio.php')->middleware('auth');

// --- Funcionários (Caixa e Admin) ---
Route::get('pdv', 'pages/funcionarios/pdv.php')->middleware(['auth', 'funcionario']);
Route::get('produtos', 'pages/funcionarios/produtos.php')->middleware(['auth', 'funcionario']);
Route::get('categorias', 'pages/funcionarios/categorias.php')->middleware(['auth', 'funcionario']);
Route::get('mensalidade_vencida', 'pages/funcionarios/mensalidade_vencida.php')->middleware(['auth', 'funcionario']);
Route::get('vendas', 'pages/admin/vendas.php')->middleware(['auth', 'funcionario']);

// --- Admin (Exclusivo) ---
Route::get('dashboard',       'pages/admin/dashboard.php')->middleware(['auth', 'admin']);
Route::get('mensalidade',     'pages/admin/mensalidade.php')->middleware(['auth', 'admin']);
Route::get('historico',       'pages/admin/historico.php')->middleware(['auth', 'admin']);
Route::get('usuarios',        'pages/admin/usuarios.php')->middleware(['auth', 'admin']);
Route::get('relatorios',        'pages/admin/relatorios.php')->middleware(['auth', 'admin']);
Route::get('configurar_desconto_metodos', 'backend/admin/configurar_desconto_metodos.php')->middleware(['auth, admin']);

// --- CRUD Admin (Disponível para funcionários) ---
Route::get('controle_produtos', 'backend/controladores/produtos.php')->middleware(['auth', 'funcionario']);
Route::get('controle_vendas', 'backend/controladores/vendas.php')->middleware(['auth', 'funcionario']);
Route::get('controle_categorias', 'backend/controladores/categorias.php')->middleware(['auth', 'funcionario']);
Route::get('controle_usuarios', 'backend/controladores/usuarios.php')->middleware(['auth', 'admin']);
Route::get('controle_pdv', 'backend/controladores/pdv.php')->middleware(['auth', 'funcionario']);
Route::get('controle_usuarios', 'backend/controladores/usuarios.php')->middleware(['auth']);

// --- InfinitePay (Admin) ---
Route::get('processar_checkout',       'backend/infinitepay/processar_checkout.php')->middleware(['auth', 'admin']);
Route::get('check_status_infinitepay', 'backend/infinitepay/check_status.php')->middleware(['auth', 'admin']);
Route::get('webhook_infinitepay',      'backend/infinitepay/webhook.php'); // webhooks são públicos

// --- Fundador ---
Route::get('fundador',             'fundador/dashboard.php')->middleware(['auth', 'fundador']);
Route::get('fundador/dashboard',   'fundador/dashboard.php')->middleware(['auth', 'fundador']);
Route::get('fundador/erros',       'fundador/erros.php')->middleware(['auth', 'fundador']);
Route::get('fundador/usuarios',    'fundador/usuarios.php')->middleware(['auth', 'fundador']);
Route::get('fundador/mensalidade', 'fundador/mensalidade.php')->middleware(['auth', 'fundador']);
Route::get('fundador/historico',   'fundador/historico.php')->middleware(['auth', 'fundador']);
Route::get('atualizar_mensalidade',   'backend/fundador/atualizar_mensalidade.php')->middleware(['auth', 'fundador']);
Route::get('apagar_todos_erros',   'backend/fundador/apagar_todos_erros.php')->middleware(['auth', 'fundador']);


// --- DISPARAR O SISTEMA ---
Route::dispatch();
