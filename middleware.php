    <?php

    class Middleware
    {
        public static function resolve($middlewares = [])
        {
            // Se não houver middlewares, retorna
            if (empty($middlewares)) return;

            // Garante que a sessão existe para verificações
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            foreach ($middlewares as $middleware) {
                switch ($middleware) {
                    case 'auth':
                        self::auth();
                        break;
                    case 'guest':
                        self::guest();
                        break;
                    case 'admin':
                        self::admin();
                        break;
                    case 'dev':
                        self::dev();
                        break;
                }
            }
        }

        // Apenas usuários logados
        private static function auth()
        {
            // Verificações básicas de sessão
            if (!isset($_SESSION['id'])) {
                aviso("Faça login para acessar essa página.");
                redirect('login');
            }

            global $conexao;

            if ($conexao) {

                // Busca dados atualizados do usuário
                $stmt = $conexao->prepare("SELECT nome, email, cargo FROM usuarios WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['id']);
                $stmt->execute();
                $usuario = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if (!$usuario) {
                    session_unset();
                    session_destroy();
                    session_start();
                    aviso("Sua conta não foi encontrada.");
                    redirect('login');
                }

                // Atualiza sessão
                $_SESSION['nome']  = $usuario['nome'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['cargo'] = $usuario['cargo'];
            }
        }

        // Apenas visitantes
        private static function guest()
        {
            if (isset($_SESSION['id'])) {
                redirect('cardapio');
            }
        }

        // Apenas Administradores
        private static function admin()
        {
            // Assume que auth() já rodou antes
            if (!isset($_SESSION['cargo']) || $_SESSION['cargo'] != 2) {
                aviso("Você não tem permissão para acessar essa área.");
                redirect('cardapio');
            }
        }

        // Apenas Devs
        private static function dev()
        {
            // Assume que auth() já rodou antes
            if (!isset($_SESSION['cargo']) || $_SESSION['cargo'] != 3) {
                aviso("Você não tem permissão para acessar essa área.");
                redirect('cardapio');
            }
        }
    }
