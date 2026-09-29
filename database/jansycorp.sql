
-- ================================================================
-- JansyCorp - Script SQL v3
-- ================================================================

CREATE DATABASE IF NOT EXISTS `jansycorp` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'jansy_user'@'localhost' IDENTIFIED BY 'jansy_pass';
GRANT ALL PRIVILEGES ON `jansycorp`.* TO 'jansy_user'@'localhost';
FLUSH PRIVILEGES;

USE `jansycorp`;

CREATE TABLE IF NOT EXISTS `categorias` (
    `id`          INT          AUTO_INCREMENT PRIMARY KEY,
    `nombre`      VARCHAR(100) NOT NULL,
    `descripcion` TEXT,
    `activa`      TINYINT(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id`         INT           AUTO_INCREMENT PRIMARY KEY,
    `nombre`     VARCHAR(100)  NOT NULL,
    `apellido`   VARCHAR(100)  NOT NULL DEFAULT '',
    `email`      VARCHAR(150)  NOT NULL UNIQUE,
    `password`   VARCHAR(255)  NOT NULL,
    `rol`        VARCHAR(20)   NOT NULL DEFAULT 'ROLE_USER',
    `telefono`   VARCHAR(20)   NOT NULL DEFAULT '',
    `direccion`  VARCHAR(255),
    `imgPerfil`  VARCHAR(255)  DEFAULT 'default-avatar.png',
    `fechaAlta`  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `idioma`     VARCHAR(10)   NOT NULL DEFAULT 'es_ES'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `productos` (
    `id`           INT            AUTO_INCREMENT PRIMARY KEY,
    `nombre`       VARCHAR(255)   NOT NULL,
    `precio`       DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
    `descripcion`  TEXT,
    `stock`        INT            NOT NULL DEFAULT 0,
    `imagen`       VARCHAR(255)   NOT NULL DEFAULT '',
    `categoria_id` INT,
    `usuario_id`   INT,
    `fechaAlta`    DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_producto_categoria`
        FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_producto_usuario`
        FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pedidos` (
    `id`          INT           AUTO_INCREMENT PRIMARY KEY,
    `usuario_id`  INT           NOT NULL,
    `fecha`       DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `total`       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `estado`      VARCHAR(30)   NOT NULL DEFAULT 'completado',
    CONSTRAINT `fk_pedido_usuario`
        FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `lineas_pedido` (
    `id`          INT           AUTO_INCREMENT PRIMARY KEY,
    `pedido_id`   INT           NOT NULL,
    `producto_id` INT,
    `cantidad`    INT           NOT NULL DEFAULT 1,
    `precio_unit` DECIMAL(10,2) NOT NULL,
    CONSTRAINT `fk_linea_pedido`
        FOREIGN KEY (`pedido_id`) REFERENCES `pedidos`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_linea_producto`
        FOREIGN KEY (`producto_id`) REFERENCES `productos`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Datos ────────────────────────────────────────────────────────
INSERT INTO `categorias` (`nombre`, `descripcion`, `activa`) VALUES
('Teclados',    'Teclados mecánicos y membrana custom',      1),
('Ratones',     'Ratones de alta precisión y gaming',        1),
('Audio',       'Auriculares, micrófonos y mesas de mezcla', 1),
('Componentes', 'Tarjetas gráficas, memorias y fuentes',     1),
('Accesorios',  'Alfombrillas, cables y demás accesorios',   1);

-- admin@jansycorp.com / password
INSERT INTO `usuarios` (`nombre`,`apellido`,`email`,`password`,`rol`,`telefono`,`direccion`,`imgPerfil`,`fechaAlta`,`idioma`) VALUES
('Admin','JansyCorp','admin@jansycorp.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
 'ROLE_ADMIN','900000000','Calle Admin 1, Madrid','default-avatar.png',NOW(),'es_ES');

-- carlos@example.com / password
INSERT INTO `usuarios` (`nombre`,`apellido`,`email`,`password`,`rol`,`telefono`,`direccion`,`imgPerfil`,`fechaAlta`,`idioma`) VALUES
('Carlos','García','carlos@example.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
 'ROLE_USER','612345678','Calle Mayor 10, Barcelona','default-avatar.png',NOW(),'es_ES');

-- Productos (usuario_id=1 = admin)
INSERT INTO `productos` (`nombre`,`precio`,`descripcion`,`stock`,`imagen`,`categoria_id`,`usuario_id`,`fechaAlta`) VALUES
('Teclado Keychron Q1 Pro',        149.99,'Teclado 75% con switches Gateron Pro Red, hot-swap.',  15,'keychron-q1.jpg',   1,1,NOW()),
('Teclado Anne Pro 2',              79.99,'Teclado 60% inalámbrico RGB Cherry MX Brown.',           8,'anne-pro-2.jpg',    1,1,NOW()),
('Ratón Logitech G Pro X',          79.95,'Ultraligero 63g, sensor HERO 25K, ambidiestro.',        20,'gpro-x.jpg',        2,1,NOW()),
('Ratón Zowie EC2-C',               69.00,'Asimétrico para diestros, sensor 3360, paracord.',      12,'zowie-ec2.jpg',     2,1,NOW()),
('Auriculares Beyerdynamic DT 770', 129.00,'Cerrados referencia 80 Ohm, estudio y gaming.',         7,'dt770.jpg',         3,1,NOW()),
('Micrófono Blue Yeti',             99.00,'USB condensador, patrón polar múltiple.',                5,'blue-yeti.jpg',     3,1,NOW()),
('RTX 4060 Ti 8GB',                399.00,'NVIDIA GeForce RTX 4060 Ti, 8GB GDDR6, DLSS 3.',        3,'rtx4060ti.jpg',     4,1,NOW()),
('Alfombrilla Artisan Zero XL',     49.99,'Tela alta velocidad, XL 490x420mm.',                   18,'artisan-zero.jpg',  5,1,NOW());
