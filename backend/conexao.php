<?php
// Força o PHP a usar o horário de Brasília (afeta a função date() e outras)
date_default_timezone_set('America/Sao_Paulo');

require_once 'funcoes.php';

carregarEnv(__DIR__ . '/../.env');

// Detecta o host atual
$hostAtual = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Configuração de conexão
$host = $_ENV['DB_HOST'] ?? '';
$username = $_ENV['DB_USER'] ?? '';
$password = $_ENV['DB_PASS'] ?? '';
$dbname = $_ENV['DB_NAME'] ?? '';

// Conexão MySQL
$conexao = new mysqli($host, $username, $password, $dbname);

if ($conexao->connect_error) {
    die("Erro na conexão! " . $conexao->connect_error);
}

// concertando caracteres
$conexao->set_charset("utf8mb4");

// Isso resolve o problema das funções como NOW() ou colunas TIMESTAMP no servidor hospedado
$conexao->query("SET time_zone = '-03:00'");
