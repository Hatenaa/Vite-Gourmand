-- Vite & Gourmand - Script de création de la base de données
-- SGBD ciblé : MySQL 8.0, encodage: utf8mb4

-- Ordre de création : les tables seront déclarées de sorte qu'une table
-- soit toujours créée avant d'être référencée par une clé étrangère.
-- De plus, les commentaires COMMENT '(DC2Type:...)' sont des métadonnées
-- Doctrine permettant la correspondance avec les types PHP immutables.

-- 1. Base de données
CREATE DATABASE IF NOT EXISTS vitegourmand
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE vitegourmand;

-- 2. Référentiels (tables sans dépendance)
-- Valeurs de classification utilisées par le catalogue

-- theme
CREATE TABLE theme (
    id INT AUTO_INCREMENT NOT NULL,
    label VARCHAR(100) NOT NULL,
    is_active TINYINT(1) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- regime
CREATE TABLE regime (
    id INT AUTO_INCREMENT NOT NULL,
    label VARCHAR(100) NOT NULL,
    description LONGTEXT DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- allergen
CREATE TABLE allergen (
    id INT AUTO_INCREMENT NOT NULL,
    label VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- opening_hours
CREATE TABLE opening_hours (
    id INT AUTO_INCREMENT NOT NULL,
    day VARCHAR(50) NOT NULL,
    opening_time TIME DEFAULT NULL COMMENT '(DC2Type:time_immutable)',
    closing_time TIME DEFAULT NULL COMMENT '(DC2Type:time_immutable)',
    is_closed TINYINT(1) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 3. Utilisateurs
-- Comptes clients, employés et administrateur (rôles en JSON)

-- user
CREATE TABLE user (
    id INT AUTO_INCREMENT NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(45) NOT NULL,
    last_name VARCHAR(45) NOT NULL,
    phone VARCHAR(45) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    roles JSON NOT NULL,
    is_active TINYINT(1) NOT NULL,
    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    reset_token VARCHAR(255) DEFAULT NULL,
    reset_token_expires_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
    PRIMARY KEY (id),
    UNIQUE KEY uq_user_email (email)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 4. Catalogue
-- Les plats, les menus et leurs images

-- dish
CREATE TABLE dish (
    id INT AUTO_INCREMENT NOT NULL,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    description LONGTEXT DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- menu
CREATE TABLE menu (
    id INT AUTO_INCREMENT NOT NULL,
    theme_id INT NOT NULL,
    regime_id INT NOT NULL,
    title VARCHAR(45) NOT NULL,
    description LONGTEXT DEFAULT NULL,
    min_people INT NOT NULL,
    base_price NUMERIC(10, 2) NOT NULL,
    conditions LONGTEXT DEFAULT NULL,
    stock INT NOT NULL,
    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    is_active TINYINT(1) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_menu_theme FOREIGN KEY (theme_id) REFERENCES theme (id),
    CONSTRAINT fk_menu_regime FOREIGN KEY (regime_id) REFERENCES regime (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- menu_image
CREATE TABLE menu_image (
    id INT AUTO_INCREMENT NOT NULL,
    menu_id INT NOT NULL,
    path VARCHAR(255) NOT NULL,
    alt VARCHAR(255) DEFAULT NULL,
    position INT NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_menu_image_menu FOREIGN KEY (menu_id) REFERENCES menu (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 5. Associations plusieurs-à-plusieurs (many to many)
-- un plat appartient à plusieurs menus, un plat a plusieurs allergènes

-- menu_dish
CREATE TABLE menu_dish(
    menu_id INT NOT NULL,
    dish_id INT NOT NULL,
    PRIMARY KEY (menu_id, dish_id),
    CONSTRAINT fk_menu_dish_menu FOREIGN KEY (menu_id)
        REFERENCES menu (id) ON DELETE CASCADE,
    CONSTRAINT fk_menu_dish_dish FOREIGN KEY (dish_id)
        REFERENCES dish (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- dish_allergen
CREATE TABLE dish_allergen(
    dish_id INT NOT NULL,
    allergen_id INT NOT NULL,
    PRIMARY KEY (dish_id, allergen_id),
    CONSTRAINT fk_dish_allergen_dish FOREIGN KEY (dish_id)
        REFERENCES dish (id) ON DELETE CASCADE,
    CONSTRAINT fk_dish_allergen_allergen FOREIGN KEY (allergen_id)
        REFERENCES allergen (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 6. Commandes et suivi

-- `order`
CREATE TABLE `order` (
    id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    menu_id INT NOT NULL,
    first_name VARCHAR(45) NOT NULL,
    last_name VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    phone VARCHAR(45) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(45) NOT NULL,
    delivery_date DATE NOT NULL COMMENT '(DC2Type:date_immutable)',
    delivery_time TIME NOT NULL COMMENT '(DC2Type:time_immutable)',
    people_count INT NOT NULL,
    status VARCHAR(30) NOT NULL,
    menu_price NUMERIC(10, 2) NOT NULL,
    delivery_price NUMERIC(10, 2) NOT NULL,
    discount NUMERIC(10, 2) NOT NULL,
    total_price NUMERIC(10, 2) NOT NULL,
    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    has_borrowed_material TINYINT(1) NOT NULL,
    distance_km NUMERIC (8, 2) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_order_user FOREIGN KEY (user_id) REFERENCES user (id),
    CONSTRAINT fk_order_menu FOREIGN KEY (menu_id) REFERENCES menu (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- order_status_history
CREATE TABLE order_status_history (
    id INT AUTO_INCREMENT NOT NULL,
    order_ref_id INT NOT NULL,
    changed_by_id INT NOT NULL,
    status VARCHAR(45) NOT NULL,
    changed_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    PRIMARY KEY (id),
    CONSTRAINT fk_order_history_order FOREIGN KEY (order_ref_id) REFERENCES `order` (id),
    CONSTRAINT fk_order_history_user FOREIGN KEY (changed_by_id) REFERENCES user (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- order_contact
CREATE TABLE order_contact (
    id INT AUTO_INCREMENT NOT NULL,
    customer_order_id INT NOT NULL,
    contacted_by_id INT NOT NULL,
    contact_mode VARCHAR(50) NOT NULL,
    reason LONGTEXT NOT NULL,
    contacted_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    PRIMARY KEY (id),
    CONSTRAINT fk_order_contact_order FOREIGN KEY (customer_order_id) REFERENCES `order` (id),
    CONSTRAINT fk_order_contact_user FOREIGN KEY (contacted_by_id) REFERENCES user (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 7. Avis clients

--  review
CREATE TABLE review (
    id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    customer_order_id INT NOT NULL,
    note INT NOT NULL,
    comment LONGTEXT DEFAULT NULL,
    status VARCHAR(20) NOT NULL,
    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    review_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
    PRIMARY KEY (id),
    UNIQUE KEY uq_review_order (customer_order_id),
    CONSTRAINT fk_review_user FOREIGN KEY (user_id) REFERENCES user (id),
    CONSTRAINT fk_review_order FOREIGN KEY (customer_order_id) REFERENCES `order` (id),
    CONSTRAINT chk_review_note CHECK (note BETWEEN 1 AND 5)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;