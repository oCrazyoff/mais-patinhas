-- tabela de erros
CREATE TABLE `logs_erros` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT DEFAULT NULL,
    `url` VARCHAR(255) DEFAULT NULL,
    `mensagem` TEXT NOT NULL,
    `arquivo` VARCHAR(255) DEFAULT NULL,
    `linha` INT DEFAULT NULL,
    `user_agent` TEXT DEFAULT NULL,
    `json_request` JSON DEFAULT NULL,
    `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;