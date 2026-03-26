<?php

class Route
{
    private static $routes = [];
    private static $lastRouteUri = null;

    // Simula o Route::get() do Laravel
    public static function get($uri, $file)
    {
        // Normaliza a URI (remove barras extras)
        $uri = trim($uri, '/');

        // Se for a raiz
        if ($uri === '') {
            $uri = '/';
        }

        self::$routes[$uri] = [
            'file' => $file,
            'middleware' => []
        ];

        self::$lastRouteUri = $uri;

        // Retorna uma instância da própria classe para permitir encadeamento (Fluent Interface)
        return new static();
    }

    // Método para adicionar middleware: ->middleware(['auth', 'admin'])
    public function middleware($middlewares)
    {
        // Se passar apenas uma string ('auth'), transforma em array
        if (!is_array($middlewares)) {
            $middlewares = [$middlewares];
        }

        if (self::$lastRouteUri !== null) {
            // Mescla os middlewares novos com os que já existiam na rota
            self::$routes[self::$lastRouteUri]['middleware'] = array_merge(
                self::$routes[self::$lastRouteUri]['middleware'],
                $middlewares
            );
        }

        return $this;
    }

    /// O "motor" que faz tudo funcionar
    public static function dispatch()
    {
        global $conexao;

        // Pega a URL atual
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');
        if ($url === '') {
            $url = '/';
        }

        // Verifica se a rota existe
        if (array_key_exists($url, self::$routes)) {
            $route = self::$routes[$url];

            // 1. Resolve os Middlewares
            if (!empty($route['middleware'])) {
                Middleware::resolve($route['middleware']);
            }

            // 2. Carrega o arquivo
            if (file_exists($route['file'])) {
                // Como declaramos 'global $conexao' lá em cima,
                // este arquivo agora terá acesso ao banco de dados.
                require $route['file'];
            } else {
                echo "Erro: Arquivo da rota não encontrado: " . $route['file'];
            }
            exit;
        }

        // 404
        http_response_code(404);
        require 'erro404.php';
        exit;
    }
}
