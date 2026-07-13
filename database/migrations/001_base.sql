CREATE TABLE `negocios` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `telefono` VARCHAR(20) NOT NULL,
    `logo` VARCHAR(255) DEFAULT NULL,
    `moneda` VARCHAR(10) DEFAULT 'C$',
    `plan` ENUM('gratis','basico','pro') DEFAULT 'gratis',
    `activo` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `usuarios` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `negocio_id` INT UNSIGNED NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `nombre` VARCHAR(100) NOT NULL,
    `rol` ENUM('dueno','admin','empleado') DEFAULT 'dueno',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`negocio_id`) REFERENCES `negocios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `negocio_modulos` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `negocio_id` INT UNSIGNED NOT NULL,
    `modulo` VARCHAR(50) NOT NULL,
    `activo` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`negocio_id`) REFERENCES `negocios`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `negocio_modulo` (`negocio_id`, `modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `suscripciones` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `negocio_id` INT UNSIGNED NOT NULL,
    `plan` ENUM('gratis','basico','pro') NOT NULL,
    `monto` DECIMAL(10,2) DEFAULT 0,
    `fecha_inicio` DATE NOT NULL,
    `fecha_fin` DATE DEFAULT NULL,
    `estado` ENUM('activa','cancelada','vencida') DEFAULT 'activa',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`negocio_id`) REFERENCES `negocios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
