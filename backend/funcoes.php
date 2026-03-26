<?php

/**
 * ============================================================
 * SISTEMA DE LOGS E ERROS
 * ============================================================
 */

function registrarErro($msg, $arquivo = '', $linha = '')
{
    // Usa a conexão global definida no conexao.php
    global $conexao;

    $usuario_id = $_SESSION['id'] ?? null;
    $url = $_SERVER['REQUEST_URI'] ?? 'Desconhecido';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

    // Captura dados da requisição (mas remove senhas por segurança)
    $requestData = ['GET' => $_GET, 'POST' => $_POST];
    if (isset($requestData['POST']['senha'])) $requestData['POST']['senha'] = '***';
    if (isset($requestData['POST']['password'])) $requestData['POST']['password'] = '***';

    $dados_json = json_encode($requestData);

    // Verifica se a conexão existe antes de tentar salvar
    if ($conexao) {
        $stmt = $conexao->prepare("INSERT INTO logs_erros (usuario_id, url, mensagem, arquivo, linha, user_agent, json_request) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssiss", $usuario_id, $url, $msg, $arquivo, $linha, $user_agent, $dados_json);
        $stmt->execute();
        $stmt->close();
    } else {
        // Fallback: Se o banco caiu, salva em arquivo de texto
        error_log("[$url] $msg em $arquivo:$linha");
    }
}

// Ativa o monitoramento de erros automaticamente ao incluir este arquivo
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) return false;
    registrarErro($errstr, $errfile, $errline);
    return false; // Deixa o PHP continuar (ou mostre erro na tela se for dev)
});

set_exception_handler(function ($e) {
    dd($e->getMessage());
});

function aviso($mensagem)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $_SESSION['resposta'] = $mensagem;
}

/**
 * ============================================================
 * UTILITÁRIOS GERAIS
 * ============================================================
 */

// Carrega o .env
function carregarEnv($caminho)
{
    if (!file_exists($caminho)) {
        throw new Exception("Arquivo .env não encontrado em: " . $caminho);
    }

    $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $linha) {
        // Ignorar comentários
        if (strpos(trim($linha), '#') === 0) {
            continue;
        }

        // Separar chave e valor
        list($chave, $valor) = explode('=', $linha, 2);

        $chave = trim($chave);
        $valor = trim($valor, " \"'"); // já remove espaços e aspas

        // Salvar no ambiente
        putenv("$chave=$valor");
        $_ENV[$chave] = $valor;
    }
}

// href de links
function hrefLink($link)
{
    return BASE_URL . $link;
}


// Debug bonito (mata a execução e mostra o array formatado)
function dd($data)
{
    echo "<pre style='background:#1a1a1a; color:#00ff00; padding:20px; z-index:9999; position:relative;'>";
    print_r($data);
    echo "</pre>";
    exit;
}

// Redirecionamento simplificado
function redirect($rota)
{
    header("Location: " . BASE_URL . $rota);
    exit;
}

// CSRF
function gerarCSRF()
{
    // Se NÃO existir token na sessão, cria um novo.
    // Se já existir, mantém o mesmo.
    if (!isset($_SESSION["csrf"])) {
        $_SESSION["csrf"] = hash('sha256', random_bytes(32));
    }

    return $_SESSION["csrf"];
}

function validarCSRF($csrf)
{
    if (!isset($_SESSION["csrf"])) {
        return (false);
    }
    if ($_SESSION["csrf"] !== $csrf) {
        return false;
    }
    if (!hash_equals($_SESSION["csrf"], $csrf)) {
        return false;
    }

    return true;
}

function validarLogado()
{
    if ((!isset($_SESSION["id"])) || (!isset($_SESSION["nome"])) || (!isset($_SESSION["email"])) || (!isset($_SESSION["cargo"]))) {
        return false;
    } else {
        return true;
    }
}

// Lê o corpo da requisição (para POST, PUT, DELETE)
function pegarJsonInput()
{
    $input = file_get_contents("php://input");
    return json_decode($input, true) ?? [];
}

/**
 * ============================================================
 * FORMATAÇÃO
 * ============================================================
 */

// Formata moeda (R$ 1.250,00)
function formatarMoeda($valor)
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

// Formata data (de 2025-12-31 para 31/12/2025)
function formatarData($data)
{
    return date('d/m/Y', strtotime($data));
}

// formatar data e hora
function formatarDataHora($data)
{
    return date('d/m/Y H:i', strtotime($data));
}
