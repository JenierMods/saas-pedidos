CREATE TABLE `pedidos` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `negocio_id` INT UNSIGNED NOT NULL,
    `numero` INT UNSIGNED NOT NULL,
    `cliente_nombre` VARCHAR(100) NOT NULL,
    `cliente_telefono` VARCHAR(20) NOT NULL,
    `cliente_direccion` VARCHAR(255) DEFAULT NULL,
    `nota` TEXT DEFAULT NULL,
    `total` DECIMAL(10,2) NOT NULL,
    `estado` ENUM('nuevo','preparando','listo','entregado','cancelado') DEFAULT 'nuevo',
    `metodo_entrega` ENUM('delivery','recoger') DEFAULT 'delivery',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`negocio_id`) REFERENCES `negocios`(`id`) ON DELETE CASCADE,
    INDEX `idx_negocio_estado` (`negocio_id`, `estado`),
    INDEX `idx_negocio_fecha` (`negocio_id`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pedido_items` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `pedido_id` INT UNSIGNED NOT NULL,
    `producto_id` INT UNSIGNED DEFAULT NULL,
    `nombre_producto` VARCHAR(150) NOT NULL,
    `precio` DECIMAL(10,2) NOT NULL,
    `cantidad` INT UNSIGNED NOT NULL,
    `subtotal` DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (`pedido_id`) REFERENCES `pedidos`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`producto_id`) REFERENCES `productos`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
