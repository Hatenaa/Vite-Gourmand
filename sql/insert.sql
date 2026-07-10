-- Vite & Gourmand - Jeu de données de démonstration
-- SGBD ciblé : MySQL 8.0, encodage: utf8mb4

-- /!\ Prérequis: la base et ses tables doivent exister (exécuter create.sql)
-- Les INSERT suivent le même ordre que la création des tables, une
-- ligne n'est insérée qu'après les lignes qu'elle référence par clé étrangère.
-- les identifiants (id) sont explicites afin de rendre lisibles les associations entre
-- les tables.

-- Les mots de passe de la colonne user.password sont des empreintes bcrypt
-- générées avec l'algorithme de l'application (les mots de passe en clair correspondants
-- sont fournis dans le manuel d'utilisation).

-- Important: les statistiques de commandes (order_stats) résident dans MongoDB et
-- ne font pas partie de ce script. En effet, seule la base relationnelle est concernée ici.

USE vitegourmand;

-- 1. Référentiels
-- theme
INSERT INTO theme (id, label, is_active) VALUES
(1, 'Noël', 1),
(2, 'Pâques', 1),
(3, 'Classique', 1),
(4, 'Évènement', 1),
(5, 'Saisonnier', 1),
(6, 'Festif', 1),
(7, 'Méditerranéen', 1),
(8, 'Tradition', 1),
(9, 'Hiver', 1),
(10, 'Découverte', 1),
(11, 'Nature', 1),
(12 , 'Brunch', 1),
(13, 'Printemps', 1);

-- regime
INSERT INTO regime (id, label, description) VALUES
(1, 'Classique', 'Une cuisine équilibrée et savoureuse, fidèle aux traditions gourmandes.'),
(2, 'Végétarien', 'Des créations généreuses et créatives, mettant à l’honneur les produits végétaux.'),
(3, 'Vegan', 'Une cuisine 100% végétale, inventive et pleine de saveurs naturelles.');

-- allergen
INSERT INTO allergen (id, label) VALUES
(1, 'Gluten'),
(2, 'Crustacé'),
(3, 'Œuf'),
(4, 'Poisson'),
(5, 'Arachide'),
(6, 'Soja'),
(7, 'Lait'),
(8, 'Fruits à coque'),
(9, 'Céleri'),
(10, 'Moutarde'),
(11, 'Mollusque'),
(12, 'Sésame'),
(13, 'Sulfite'),
(14, 'Lupin');

-- opening_hours (les 7 jours de la semaine)
INSERT INTO opening_hours (id, day, opening_time, closing_time, is_closed) VALUES
(1, 'Lundi', '09:00:00', '18:00:00', 0),
(2, 'Mardi', '09:00:00', '18:00:00', 0),
(3, 'Mercredi', '09:00:00', '18:00:00', 0),
(4, 'Jeudi', '09:00:00', '18:00:00', 0),
(5, 'Vendredi', '09:00:00', '18:00:00', 0),
(6, 'Samedi', '08:00:00', '20:00:00', 0),
(7, 'Dimanche', NULL, NULL, 1);

-- 2. Utilisateurs
-- user (1 administrateur, 1 employé, des clients)
SET @password_hash = '$2y$13$QBIneDhmy4lAz9XAFEnHsOOpejfyy59UxJTPo6dJimo9eFxgUJ0uK';

INSERT INTO user (id, email, password, first_name, last_name, phone, address, city, roles, is_active, created_at) VALUES
(1, 'jose@example.com', @password_hash, 'José', 'Martinez', '0612345678', '12 rue Sainte-Catherine', 'Bordeaux', '["ROLE_ADMIN"]', 1, '2026-04-01 09:00:00'),
(2, 'josette@example.com', @password_hash, 'Josette', 'Dupont', '0623456789', '5 cours de l’Intendance', 'Bordeaux', '["ROLE_EMPLOYEE"]', 1, '2026-04-02 10:15:00'),
(3, 'lucas.bernard@example.com', @password_hash, 'Lucas', 'Bernard', '0634567890', '18 rue Judaïque', 'Bordeaux', '["ROLE_USER"]', 1, '2026-04-03 11:20:00'),
(4, 'emma.durand@example.com', @password_hash, 'Emma', 'Durand', '0645678901', '2 quai des Chartrons', 'Bordeaux', '["ROLE_USER"]', 1, '2026-04-04 14:05:00'),
(5, 'nathan.moreau@example.com', @password_hash, 'Nathan', 'Moreau', '0656789012', '7 rue Pasteur', 'Talence', '["ROLE_USER"]', 1, '2026-04-05 16:40:00'),
(6, 'lea.girard@example.com', @password_hash, 'Léa', 'Girard', '0667890123', '25 avenue de la Libération', 'Bègles', '["ROLE_USER"]', 1, '2026-04-06 08:55:00'),
(7, 'hussein.karimi@example.com', @password_hash, 'Hussein', 'Karimi', '0678123456', '9 rue de la Benauge', 'Bordeaux', '["ROLE_USER"]', 1, '2026-04-07 10:30:00'),
(8, 'marta.nowak@example.com', @password_hash, 'Marta', 'Nowak', '0678123499', '21 rue des Faures', 'Bordeaux', '["ROLE_USER"]', 1, '2026-04-07 12:15:00'),
(9, 'vladimir.petrov@example.com', @password_hash, 'Vladimir', 'Petrov', '0678001122', '4 rue du Loup', 'Bordeaux', '["ROLE_USER"]', 1, '2026-04-07 09:20:00'),
(10, 'clara.robert@example.com', @password_hash, 'Clara', 'Robert', '0689012345', '3 rue Voltaire', 'Le Bouscat', '["ROLE_USER"]', 1, '2026-04-08 17:25:00'),
(11, 'tom.richard@example.com', @password_hash, 'Tom', 'Richard', '0690123456', '14 rue François Arago', 'Cenon', '["ROLE_USER"]', 1, '2026-04-09 12:00:00'),
(12, 'sarah.petit@yahoo.fr', @password_hash, 'Sarah', 'Petit', '0611122233', '6 rue du Professeur Bergonié', 'Pessac', '["ROLE_USER"]', 1, '2026-04-10 15:45:00');

-- 3. Catalogue
-- dish
INSERT INTO dish (id, title, type, description) VALUES
(1, 'Foie gras maison et pain brioché', 'STARTER', 'Foie gras maison délicatement assaisonné, accompagné de tranches de pain brioché légèrement toastées.'),
(2, 'Suprême de volaille sauce morilles', 'MAIN', 'Suprême de volaille tendre nappé d’une sauce crémeuse aux morilles, servi avec accompagnement de saison.'),
(3, 'Bûche chocolat praliné', 'DESSERT', 'Bûche de Noël gourmande au chocolat noir et praliné croustillant, alliant douceur et intensité.'),
(4, 'Bœuf bourguignon mijoté', 'MAIN', 'Plat traditionnel français mijoté au vin rouge avec légumes.'),
(5, 'Gratin dauphinois fondant', 'SIDE', 'Pommes de terre fondantes gratinées à la crème.'),
(6, 'Tarte tatin maison', 'DESSERT', 'Dessert traditionnel aux pommes caramélisées.'),
(7, 'Soupe à l’oignon gratinée', 'STARTER', 'Soupe traditionnelle gratinée au fromage.'),
(8, 'Velouté de potimarron', 'STARTER', 'Velouté onctueux de potimarron légèrement épicé.'),
(9, 'Bruschetta tomate & basilic', 'STARTER', 'Pain grillé garni de tomates fraîches et basilic.'),
(10, 'Lasagnes à la bolognaise', 'MAIN', 'Lasagnes généreuses à la viande et béchamel.'),
(11, 'Tiramisu classique', 'DESSERT', 'Dessert italien au café et mascarpone.'),
(12, 'Mini wraps poulet crudités', 'STARTER', 'Wraps frais garnis de poulet et légumes croquants.'),
(13, 'Verrines avocat-crevettes', 'STARTER', 'Verrine fraîche à base d’avocat et crevettes.'),
(14, 'Salade méditerranéenne', 'STARTER', 'Salade fraîche aux légumes de saison et herbes.'),
(15, 'Curry de légumes doux', 'MAIN', 'Curry parfumé aux légumes de saison.'),
(16, 'Cheesecake fruits rouges', 'DESSERT', 'Dessert crémeux aux fruits rouges.'),
(17, 'Viennoiseries assorties', 'DESSERT', 'Sélection de croissants et pains au chocolat.'),
(18, 'Pancakes au sirop d’érable', 'DESSERT', 'Pancakes moelleux servis avec sirop d’érable.'),
(19, 'Poulet rôti aux herbes', 'MAIN', 'Poulet rôti parfumé aux herbes fraîches.'),
(20, 'Tarte aux fraises', 'DESSERT', 'Dessert frais à base de fraises de saison.'),
(21, 'Mini burgers gourmets', 'STARTER', 'Petits burgers savoureux pour l’apéritif.'),
(22, 'Feuilletés au fromage', 'STARTER', 'Bouchées feuilletées croustillantes au fromage.'),
(23, 'Focaccia maison', 'STARTER', 'Pain italien moelleux à l’huile d’olive.'),
(24, 'Panna cotta vanille', 'DESSERT', 'Dessert italien crémeux à la vanille.');

-- menu
INSERT INTO menu (id, theme_id, regime_id, title, description, min_people, base_price, conditions, stock, created_at, is_active) VALUES
(1, 1, 1, 'Noël Prestige', 'Un menu festif complet pour les repas de fin d’année.', 4, 89.00, 'Commande à effectuer au moins 7 jours avant la prestation. Conservation au frais recommandée.', 5, '2026-04-01 10:00:00', 1),
(2, 8, 1, 'Tradition Française', 'Un menu généreux inspiré des grands classiques de la cuisine française.', 4, 32.00, 'Commande à effectuer au moins 5 jours avant la prestation.', 8, '2026-04-01 10:10:00', 0),
(3, 9, 1, 'Soupé', 'Un menu réconfortant autour de saveurs chaudes et authentiques.', 4, 26.00, 'Commande à effectuer au moins 3 jours avant la prestation.', 10, '2026-04-01 10:20:00', 1),
(4, 7, 1, 'Dolce Vita', 'Un menu ensoleillé inspiré de l’Italie, entre convivialité et gourmandise.', 4, 24.00, 'Commande à effectuer au moins 4 jours avant la prestation.', 9, '2026-04-01 10:30:00', 1),
(5, 10, 1, 'Découverte', 'Une sélection variée de créations fraîches et modernes pour éveiller les papilles.', 2, 28.00, 'Commande à effectuer au moins 3 jours avant la prestation.', 12, '2026-04-01 10:40:00', 1),
(6, 11, 2, 'Végétarien', 'Un menu équilibré et gourmand, riche en légumes, textures et saveurs.', 4, 24.00, 'Commande à effectuer au moins 4 jours avant la prestation.', 10, '2026-04-02 09:00:00', 1),
(7, 12, 1, 'Matinal', 'Un menu pensé pour les petits-déjeuners et pauses matinales conviviales.', 6, 28.00, 'Commande à effectuer au moins 2 jours avant la prestation.', 15, '2026-04-02 09:10:00', 1),
(8, 13, 1, 'Printemps', 'Un menu frais et coloré qui met à l’honneur les produits de saison.', 6, 38.00, 'Commande à effectuer au moins 5 jours avant la prestation.', 7, '2026-04-02 09:20:00', 1),
(9, 6, 1, 'Apéritif', 'Une formule conviviale idéale pour les cocktails, afterworks et réceptions.', 2, 22.00, 'Commande à effectuer au moins 3 jours avant la prestation.', 14, '2026-04-02 09:30:00', 1),
(10, 7, 1, 'Méditerranéen', 'Un menu chaleureux et méditerranéen autour des saveurs italiennes.', 4, 24.00, 'Commande à effectuer au moins 4 jours avant la prestation.', 9, '2026-04-02 09:40:00', 1);

-- menu_image (une image de présentation par menu)

-- Attention: la colonne path stocke un chemin relatif au dossier public/ de
-- l'application, pas l'image elle-même. La base de données ne contient donc
-- aucun fichier: chaque chemin ne fonctionnera que si l'image correspondante
-- a été publiée au préalable sur le serveur (fichiers livrés avec le dépôt,
-- ou téléversés depuis l'espace administrateur).

INSERT INTO menu_image (id, menu_id, path, alt, position) VALUES
(1, 9, 'images/menus/menu-aperitif/menu-aperitif.jpg', 'Menu Apéritif', 1),
(2, 1, 'images/menus/menu-de-noel-prestige/menu-de-noel-prestige.jpg', 'Menu de Noël Prestige', 1),
(3, 10, 'images/menus/menu-mediterraneen/menu-mediterraneen.jpg', 'Menu Méditerranéen', 1),
(4, 5, 'images/menus/menu-decouverte/menu-decouverte.jpg', 'Menu Découverte', 1),
(5, 4, 'images/menus/menu-dolce-vita/menu-dolce-vita.jpg', 'Menu Dolce Vita', 1),
(6, 7, 'images/menus/menu-matinal/menu-matinal.jpg', 'Menu Matinal', 1),
(7, 8, 'images/menus/menu-printemps/menu-printemps.jpg', 'Menu Printemps', 1),
(8, 3, 'images/menus/menu-soupe/menu-soupe.jpg', 'Menu Soupé', 1),
(9, 2, 'images/menus/menu-tradition-francaise/menu-tradition-francaise.jpg', 'Menu Tradition Française', 1),
(10, 6, 'images/menus/menu-vegetarien/menu-vegetarien.jpg', 'Menu Végétarien', 1);

-- 4. Associations plusieurs-à-plusieurs (many to many)
-- menu_dish
INSERT INTO menu_dish (menu_id, dish_id) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(2, 6),
(3, 7),
(3, 8),
(4, 9),
(4, 10),
(4, 11),
(5, 12),
(5, 13),
(6, 14),
(6, 15),
(6, 16),
(7, 17),
(7, 18),
(8, 14),
(8, 19),
(8, 20),
(9, 21),
(9, 22),
(10, 10),
(10, 23),
(10, 24);

-- dish_allergen
INSERT INTO dish_allergen (dish_id, allergen_id) VALUES
(5, 7),
(6, 1),
(6, 7),
(7, 1),
(7, 7),
(8, 7),
(9, 1),
(10, 1),
(10, 7),
(11, 3),
(11, 7),
(12, 1),
(13, 2),
(16, 1),
(16, 7),
(17, 1),
(17, 7),
(18, 1),
(18, 3),
(18, 7),
(20, 1),
(20, 7),
(21, 1),
(22, 1),
(22, 7),
(23, 1),
(24, 7);

-- 5. Commandes et suivi
-- `order`
INSERT INTO `order` (id, user_id, menu_id, first_name, last_name, email, phone, address, city, delivery_date, delivery_time, people_count, status, menu_price, delivery_price, discount, total_price, created_at, has_borrowed_material, distance_km) VALUES
(1, 4, 1, 'Emma', 'Durand', 'emma.durand@example.com', '0645678901', '2 quai des Chartrons', 'Bordeaux', '2026-05-10', '19:30:00', 4, 'DELIVERED', 89.90, 5.00, 0.00, 94.90, '2026-05-01 10:12:00', 0, 0.00),
(2, 12, 1, 'Sarah', 'Petit', 'sarah.petit@yahoo.fr', '0611122233', '6 rue du Professeur Bergonié', 'Pessac', '2026-05-12', '20:00:00', 6, 'PENDING', 134.85, 7.95, 13.48, 129.32, '2026-05-02 14:22:00', 1, 5.00),
(3, 9, 1, 'Vladimir', 'Petrov', 'vladimir.petrov@gmail.com', '0678001122', '4 rue du Loup', 'Bordeaux', '2026-05-14', '18:45:00', 5, 'COMPLETED', 112.40, 6.77, 0.00, 119.17, '2026-05-03 09:10:00', 0, 3.00),
(4, 8, 1, 'Marta', 'Nowak', 'marta.nowak@example.com', '0650010203', '15 rue Sainte-Catherine', 'Bordeaux', '2026-05-15', '19:00:00', 3, 'PENDING', 67.43, 5.00, 0.00, 72.43, '2026-05-04 11:20:00', 0, 1.50),
(5, 6, 1, 'Léa', 'Girard', 'lea.girard@example.com', '0651122334', '22 avenue de la Libération', 'Talence', '2026-05-16', '20:15:00', 4, 'PENDING', 89.90, 6.12, 0.00, 96.02, '2026-05-05 09:45:00', 0, 2.40),
(6, 7, 1, 'Hussein', 'Karimi', 'hussein.karimi@example.com', '0662233445', '8 rue Judaïque', 'Bordeaux', '2026-05-17', '18:30:00', 2, 'PENDING', 44.95, 5.00, 0.00, 49.95, '2026-05-06 13:10:00', 0, 1.10),
(7, 5, 1, 'Nathan', 'Moreau', 'nathan.moreau@example.com', '0673344556', '12 rue Fondaudège', 'Bordeaux', '2026-05-18', '19:45:00', 5, 'PENDING', 112.40, 5.85, 0.00, 118.25, '2026-05-07 16:05:00', 1, 2.80),
(8, 11, 1, 'Tom', 'Richard', 'tom.richard@example.com', '0684455667', '5 place Pey-Berland', 'Bordeaux', '2026-05-19', '20:30:00', 3, 'PENDING', 67.43, 5.00, 6.74, 65.69, '2026-05-08 12:40:00', 0, 0.90);

-- order_status_history
INSERT INTO order_status_history (id, order_ref_id, changed_by_id, status, changed_at) VALUES
(1, 1, 1, 'COMPLETED', '2026-05-01 10:52:00'),
(2, 1, 2, 'PREPARING', '2026-05-01 12:16:00'),
(3, 1, 2, 'DELIVERING', '2026-05-01 18:17:00'),
(4, 1, 2, 'DELIVERED', '2026-05-01 19:32:00');

-- order_contact
INSERT INTO order_contact (id, customer_order_id, contacted_by_id, contact_mode, reason, contacted_at) VALUES
(1, 1, 2, 'EMAIL', 'Confirmation de la commande et vérification des détails de livraison', '2026-05-01 10:30:00'),
(2, 1, 1, 'PHONE', 'Modification de l’heure de livraison demandée par le client', '2026-05-01 11:15:00'),
(3, 2, 2, 'EMAIL', 'Demande d’informations supplémentaires concernant l’adresse', '2026-05-02 15:00:00'),
(4, 2, 1, 'PHONE', 'Validation du nombre de personnes avant préparation', '2026-05-02 16:20:00'),
(5, 3, 2, 'EMAIL', 'Envoi du récapitulatif de commande au client', '2026-05-03 09:30:00'),
(6, 3, 1, 'PHONE', 'Confirmation de la disponibilité du client pour la livraison', '2026-05-03 10:00:00'),
(7, 1, 2, 'EMAIL', 'Information au client sur le départ de la livraison', '2026-05-01 18:00:00'),
(8, 2, 2, 'EMAIL', 'Rappel des conditions de restitution du matériel prêté', '2026-05-02 18:45:00');

-- 6. Avis clients
-- review
INSERT INTO review (id, user_id, customer_order_id, note, comment, status, created_at, review_at) VALUES
(1, 8, 4, 3, 'Le produit est correct mais j’hésite encore, j’attends de voir sur la durée.', 'PENDING', '2026-04-10 14:32:00', NULL),
(2, 6, 5, 4, 'Bonne première impression, mais je préfère attendre avant de valider définitivement.', 'PENDING', '2026-04-11 09:15:00', NULL),
(3, 7, 6, 2, 'Quelques problèmes rencontrés, je suis en train de tester des solutions.', 'PENDING', '2026-04-12 18:47:00', NULL),
(4, 5, 7, 4, 'Très satisfait pour l’instant, mais j’attends confirmation sur le long terme.', 'PENDING', '2026-04-13 11:05:00', NULL),
(5, 11, 8, 1, 'Expérience décevante jusqu’ici, je laisse en attente avant de trancher.', 'PENDING', '2026-04-14 16:20:00', NULL),
(6, 12, 2, 4, 'Après plusieurs jours d’utilisation, je confirme que le produit est fiable et correspond à mes attentes.', 'VALIDATED', '2026-04-09 10:00:00', '2026-04-15 13:45:00');