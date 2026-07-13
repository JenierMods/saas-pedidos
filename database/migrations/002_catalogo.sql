CREATE TABLE `categorias_catalogo` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `negocio_id` INT UNSIGNED NOT NULL,
    `nombre` VARCHAR(100) NOT NULL,
    `orden` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`negocio_id`) REFERENCES `negocios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `productos` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `negocio_id` INT UNSIGNED NOT NULL,
    `categoria_id` INT UNSIGNED DEFAULT NULL,
    `nombre` VARCHAR(150) NOT NULL,
    `descripcion` TEXT DEFAULT NULL,
    `precio` DECIMAL(10,2) NOT NULL,
    `imagen` VARCHAR(255) DEFAULT NULL,
    `disponible` TINYINT(1) DEFAULT 1,
    `orden` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`negocio_id`) REFERENCES `negocios`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`categoria_id`) REFERENCES `categorias_catalogo`(`id`) ON DELETE SET NULL,
    INDEX `idx_negocio_disponible` (`negocio_id`, `disponible`),
    INDEX `idx_negocio_categoria` (`negocio_id`, `categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
