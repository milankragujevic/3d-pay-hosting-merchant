-- ---------------------------------------------------------------------------------------------
-- CREATE `kg_merchant` SCHEMA.
-- ---------------------------------------------------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kg_merchant` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- ---------------------------------------------------------------------------------------------
-- SET `kg_merchant` AS DEFAULT SCHEMA.
-- ---------------------------------------------------------------------------------------------
USE `kg_merchant`;
-- ---------------------------------------------------------------------------------------------
-- DROPPING ALL TABLES.
-- ---------------------------------------------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `items`;
SET FOREIGN_KEY_CHECKS = 1;
-- ---------------------------------------------------------------------------------------------
-- CREATE `orders` TABLE.
-- ---------------------------------------------------------------------------------------------
CREATE TABLE `orders`
(
    `id`                 INT(11) UNSIGNED        NOT NULL AUTO_INCREMENT,
    `order_number`       CHAR(20)                NOT NULL,
    `transaction_amount` DECIMAL(10, 2) UNSIGNED NOT NULL,
    `gateway_response`   JSON                    NULL,
    `is_finished`        BOOLEAN                 NOT NULL DEFAULT FALSE,
    `is_charged`         BOOLEAN                 NOT NULL DEFAULT FALSE,
    `updated_at`         TIMESTAMP               NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at`         TIMESTAMP               NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`order_number`)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_general_ci;
-- ---------------------------------------------------------------------------------------------
-- CREATE `items` TABLE.
-- ---------------------------------------------------------------------------------------------
CREATE TABLE `items`
(
    `id`               INT(11) UNSIGNED        NOT NULL AUTO_INCREMENT,
    `order_id`         INT(11) UNSIGNED        NOT NULL,
    `alias_number`     CHAR(11)                NOT NULL,
    `product_id`       INT(11) UNSIGNED        NOT NULL,
    `base_price`       DECIMAL(10, 2) UNSIGNED NOT NULL,
    `vat_amount`       DECIMAL(10, 2) UNSIGNED NOT NULL,
    `product_price`    DECIMAL(10, 2) UNSIGNED NOT NULL,
    `is_on_kk_queue`   BOOLEAN                 NOT NULL DEFAULT FALSE,
    `is_on_white_list` BOOLEAN                 NOT NULL DEFAULT FALSE,
    `updated_at`       TIMESTAMP               NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at`       TIMESTAMP               NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`order_id`, `alias_number`),
    CONSTRAINT FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_general_ci;
