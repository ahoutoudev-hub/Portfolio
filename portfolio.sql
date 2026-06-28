-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 24 avr. 2026 à 10:09
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extrait` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contenu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `statut` enum('brouillon','publié','archivé') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'brouillon',
  `vues` int UNSIGNED NOT NULL DEFAULT '0',
  `temps_lecture` tinyint UNSIGNED DEFAULT NULL COMMENT 'En minutes',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_statut` (`statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_competences`
--

DROP TABLE IF EXISTS `categorie_competences`;
CREATE TABLE IF NOT EXISTS `categorie_competences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_competences`
--

INSERT INTO `categorie_competences` (`id`, `nom`, `icone`, `couleur`, `ordre`, `created_at`, `updated_at`) VALUES
(1, 'Web', 'internetcomputer', '#ff7c08', 1, '2026-03-23 14:15:47', '2026-03-23 14:56:18'),
(2, 'Framework  Web', 'framework', '#3b82f6', 4, '2026-03-23 14:27:06', '2026-03-23 15:00:27'),
(3, 'Base de données', 'diagramsdotnet', '#06b6d4', 2, '2026-03-23 14:34:21', '2026-03-23 14:56:44'),
(4, 'Mobile', 'deutschetelekom', '#f59e0b', 6, '2026-03-23 14:39:15', '2026-03-23 14:58:46'),
(5, 'Framework Mobile', 'framework', '#06b6d4', 7, '2026-03-23 14:41:04', '2026-03-23 15:00:42'),
(6, 'No Code Mobile', 'iledefrancemobilites', '#8b5cf6', 8, '2026-03-23 14:44:29', '2026-03-23 15:00:48'),
(7, 'CMS', 'datocms', '#ef4444', 3, '2026-03-23 14:46:35', '2026-03-23 14:57:11'),
(8, 'Data Analyst', 'googleanalytics', '#10b981', 5, '2026-03-23 14:52:05', '2026-03-23 14:58:14');

-- --------------------------------------------------------

--
-- Structure de la table `certificats`
--

DROP TABLE IF EXISTS `certificats`;
CREATE TABLE IF NOT EXISTS `certificats` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `organisme` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_obtention` date NOT NULL,
  `url_credential` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `ordre` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `certificats`
--

INSERT INTO `certificats` (`id`, `titre`, `organisme`, `date_obtention`, `url_credential`, `actif`, `ordre`, `created_at`, `updated_at`) VALUES
(1, 'CREER DES APPLICATIONS SANS CODER AVEC FLUTTERFLOW', 'Udemy', '2024-06-01', 'https://www.udemy.com/certificate/UC-012e2c76-fd5c-46e1-a6b7-d32016861ac5/', 1, 2, '2026-03-23 15:07:20', '2026-03-23 15:32:44'),
(2, 'Devenir spécialiste de WordPress', 'LinkedIn Learning', '2024-09-01', 'https://www.linkedin.com/learning/certificates/f5cc1d234a88ab418f05bc9ad43bcd3b8c0c5e2160aebd2a1aa472053c58d8e5?trk=share_certificate', 1, 3, '2026-03-23 15:19:20', '2026-03-23 15:32:53'),
(3, 'DEVELOPPEMENT WEB ET MOBILE Niveau 1', 'Université Virtuelle de Côte d’Ivoire (UVCI)', '2024-05-01', 'https://scolarite.uvci.online/main/public/certification/telecharger/b366d9d2-3605-42ad-9863-9c1782cf789c', 1, 1, '2026-03-23 15:22:22', '2026-03-23 15:32:34'),
(4, 'Devenir un expert du SQL - Le cours Complet', 'Udemy', '2026-03-23', NULL, 0, 0, '2026-03-23 15:24:34', '2026-03-23 15:24:34'),
(5, 'DATA SCIENCE avec Python en 2026 : le cours ULTIME', 'Udemy', '2026-03-23', NULL, 0, 0, '2026-03-23 15:25:07', '2026-03-23 15:25:07'),
(6, 'Devenir un expert de Power Bi - La formation complète 2026', 'Udemy', '2026-03-23', NULL, 0, 0, '2026-03-23 15:25:31', '2026-03-23 15:25:31'),
(7, 'Geo’Hackaton. Thème : enjeux des sciences de la terre pour le développement durable en Afrique', 'ATTESTATIONS DE PARTICIPATION', '2024-05-01', NULL, 1, 4, '2026-03-23 15:27:45', '2026-03-23 15:34:13'),
(8, 'MarCNoWA. Thème : Gestion de l’environnement marin et côtier en Afrique du Nord et de l’Ouest', 'ATTESTATIONS DE PARTICIPATION', '2024-05-01', NULL, 1, 5, '2026-03-23 15:30:07', '2026-03-23 15:34:21'),
(10, 'Lettre de Félicitation du président de l\'UVCI', 'ATTESTATIONS DE PARTICIPATION', '2024-05-01', NULL, 1, 6, '2026-03-23 15:31:54', '2026-03-23 15:34:29');

-- --------------------------------------------------------

--
-- Structure de la table `competences`
--

DROP TABLE IF EXISTS `competences`;
CREATE TABLE IF NOT EXISTS `competences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `categorie_id` bigint UNSIGNED NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Pourcentage 0-100',
  `icone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_comp_categorie` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `competences`
--

INSERT INTO `competences` (`id`, `categorie_id`, `nom`, `niveau`, `icone`, `ordre`, `created_at`, `updated_at`) VALUES
(1, 1, 'HTML', 90, 'html5', 1, '2026-03-23 14:23:02', '2026-04-09 19:13:49'),
(2, 1, 'Css', 80, 'css', 2, '2026-03-23 14:24:49', '2026-04-09 19:14:06'),
(3, 1, 'JavaScript', 75, 'javascript', 4, '2026-03-23 14:25:36', '2026-04-09 19:14:37'),
(4, 1, 'Php', 80, 'php', 3, '2026-03-23 14:26:27', '2026-04-09 19:14:20'),
(5, 2, 'Bootstrap', 85, 'bootstrap', 1, '2026-03-23 14:29:39', '2026-04-09 19:18:03'),
(6, 2, 'CodeIgniter', 70, 'codeigniter', 1, '2026-03-23 14:30:34', '2026-03-23 16:28:02'),
(7, 2, 'Laravel', 85, 'laravel', 1, '2026-03-23 14:32:44', '2026-04-09 19:18:19'),
(8, 3, 'MySql', 80, 'mysql', 2, '2026-03-23 14:35:20', '2026-04-09 19:16:59'),
(9, 3, 'Postgresql', 65, 'postgresql', 3, '2026-03-23 14:36:51', '2026-04-09 19:17:16'),
(10, 3, 'Sql', 80, 'sqlite', 1, '2026-03-23 14:37:58', '2026-04-09 19:16:44'),
(11, 4, 'Dart', 50, 'dart', 0, '2026-03-23 14:40:01', '2026-03-23 14:40:01'),
(12, 5, 'Flutter', 50, 'flutter', 0, '2026-03-23 14:41:35', '2026-03-23 14:41:35'),
(13, 3, 'Firebase', 50, 'firebase', 4, '2026-03-23 14:43:39', '2026-04-09 19:17:33'),
(14, 6, 'FlutterFlow', 75, 'flutter', 0, '2026-03-23 14:45:34', '2026-03-23 14:45:34'),
(15, 7, 'Wordpress', 90, 'wordpress', 0, '2026-03-23 14:47:41', '2026-03-23 14:47:41'),
(16, 7, 'Joomla', 50, 'joomla', 0, '2026-03-23 14:48:29', '2026-03-23 14:48:29'),
(17, 7, 'Prestashop', 50, 'prestashop', 0, '2026-03-23 14:49:34', '2026-03-23 14:49:34'),
(18, 7, 'Shopyfy', 50, 'shopify', 0, '2026-03-23 14:50:11', '2026-03-23 14:50:11'),
(19, 8, 'Python', 50, 'python', 0, '2026-03-23 14:52:56', '2026-03-23 14:52:56'),
(20, 8, 'Excel', 75, 'googleanalytics', 0, '2026-03-23 14:55:42', '2026-03-23 14:55:42');

-- --------------------------------------------------------

--
-- Structure de la table `cv_infos`
--

DROP TABLE IF EXISTS `cv_infos`;
CREATE TABLE IF NOT EXISTS `cv_infos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genre` enum('homme','femme','autre') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationalite` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `situation_matrimoniale` enum('celibataire','marie','divorce','veuf','pacse') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permis` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_complete` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre_professionnel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resume` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cv_infos`
--

INSERT INTO `cv_infos` (`id`, `user_id`, `date_naissance`, `lieu_naissance`, `genre`, `nationalite`, `situation_matrimoniale`, `permis`, `adresse_complete`, `titre_professionnel`, `resume`, `created_at`, `updated_at`) VALUES
(1, 3, '2002-03-12', 'DALOA', 'homme', 'IVOIRIENNE', NULL, 'AUCUN', NULL, 'DEVELOPEUR D\'APPLICATION WEB ET MOBILE', NULL, '2026-04-11 22:23:06', '2026-04-11 22:31:31');

-- --------------------------------------------------------

--
-- Structure de la table `cv_interets`
--

DROP TABLE IF EXISTS `cv_interets`;
CREATE TABLE IF NOT EXISTS `cv_interets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `interet` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cv_interets_user` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cv_interets`
--

INSERT INTO `cv_interets` (`id`, `user_id`, `interet`, `icone`, `ordre`, `created_at`, `updated_at`) VALUES
(9, 3, 'Athlétisme', '🏃', 3, '2026-04-11 22:31:31', '2026-04-11 22:31:31'),
(8, 3, 'Football', '⚽', 2, '2026-04-11 22:31:31', '2026-04-11 22:31:31'),
(7, 3, 'Documentaire', '📽️', 1, '2026-04-11 22:31:31', '2026-04-11 22:31:31'),
(6, 3, 'Jeux vidéos', '🎮', 0, '2026-04-11 22:31:31', '2026-04-11 22:31:31'),
(10, 3, 'Hackathons tech', '💻', 4, '2026-04-11 22:31:31', '2026-04-11 22:31:31');

-- --------------------------------------------------------

--
-- Structure de la table `cv_langues`
--

DROP TABLE IF EXISTS `cv_langues`;
CREATE TABLE IF NOT EXISTS `cv_langues` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `langue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau` enum('debutant','elementaire','intermediaire','avance','courant','natif') COLLATE utf8mb4_unicode_ci DEFAULT 'courant',
  `ordre` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cv_langues_user` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cv_langues`
--

INSERT INTO `cv_langues` (`id`, `user_id`, `langue`, `niveau`, `ordre`, `created_at`, `updated_at`) VALUES
(4, 3, 'Anglais', 'elementaire', 1, '2026-04-11 22:31:31', '2026-04-11 22:31:31'),
(3, 3, 'Français', 'courant', 0, '2026-04-11 22:31:31', '2026-04-11 22:31:31');

-- --------------------------------------------------------

--
-- Structure de la table `cv_qualites`
--

DROP TABLE IF EXISTS `cv_qualites`;
CREATE TABLE IF NOT EXISTS `cv_qualites` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `qualite` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cv_qualites_user` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cv_qualites`
--

INSERT INTO `cv_qualites` (`id`, `user_id`, `qualite`, `icone`, `ordre`, `created_at`, `updated_at`) VALUES
(7, 3, 'Esprit d\'équipe', '🤝', 2, '2026-04-11 22:31:31', '2026-04-11 22:31:31'),
(6, 3, 'Responsable', '🎯', 1, '2026-04-11 22:31:31', '2026-04-11 22:31:31'),
(5, 3, 'Rigoureux', '✅', 0, '2026-04-11 22:31:31', '2026-04-11 22:31:31'),
(8, 3, 'Créativité', '💡', 3, '2026-04-11 22:31:31', '2026-04-11 22:31:31');

-- --------------------------------------------------------

--
-- Structure de la table `experiences`
--

DROP TABLE IF EXISTS `experiences`;
CREATE TABLE IF NOT EXISTS `experiences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('travail','formation') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'travail',
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entreprise` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localisation` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `en_cours` tinyint(1) NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ordre` int UNSIGNED NOT NULL DEFAULT '0',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `experiences`
--

INSERT INTO `experiences` (`id`, `type`, `titre`, `entreprise`, `logo`, `localisation`, `date_debut`, `date_fin`, `en_cours`, `description`, `ordre`, `actif`, `created_at`, `updated_at`) VALUES
(1, 'travail', 'Stage : DEVELOPPEUR D\'APPLICATION WEB', 'Projet Collectif Tutoré (PCT) de fin de formation de la licence', NULL, 'Abidjan, Côte d’Ivoire', '2023-07-23', '2023-09-23', 0, 'Tâche : Développer une application Web pour le développement du portail de gestion des acteurs du village Allakro.', 4, 1, '2026-03-23 13:30:54', '2026-04-09 12:58:38'),
(2, 'travail', 'Freelance : DEVELOPPEUR D\'APPLICATION WEB ET MOBILE & DEVELOPPEUR WORDPRESS', 'Benahou', NULL, 'Abidjan/Côte d\'Ivoire', '2021-06-23', NULL, 1, 'Développement et Conception de prototypage\r\nConception de l\'application\r\nConception de base de données\r\nCodage\r\nIntégration des APIs\r\nIntégration de plugins\r\n\r\nTests de Validation, Déploiement et Maintenance, Support et Optimisation SEO\r\nTests\r\nDebugger\r\nPréparation du déploiement\r\nPublication\r\nMises à jour régulières\r\nSEO\r\n\r\nConfiguration, Installation, Développement et Personnalisation\r\nInstallation de WordPress\r\nChoix et installation de thèmes\r\nPersonnalisation de thèmes\r\nDéveloppement de thèmes sur mesure\r\n\r\nCréation , Gestion de Contenu et Fonctionnalités\r\nGestion des pages\r\nConfiguration de la boutique\r\nGestion des utilisateurs', 7, 1, '2026-03-23 13:35:12', '2026-04-09 13:00:21'),
(3, 'travail', 'Freelance : DEVELOPPEUR WORDPRESS E-COMMERCE', 'WinnerShop', NULL, 'Abidjan, Côte d’Ivoire', '2022-08-23', '2023-09-23', 0, 'Configuration, Installation, Développement et Personnalisation\r\nInstallation de WordPress\r\nChoix et installation de thèmes\r\nPersonnalisation de thèmes\r\nDéveloppement de thèmes sur mesure\r\n\r\nCréation , Gestion de Contenu et Fonctionnalités E-commerce\r\nGestion des produits\r\nOptimisation des pages produit\r\nConfiguration de la boutique\r\nGestion des utilisateurs\r\n\r\nIntégration de Plugins, Tests et Validation\r\nIntégration de plugins\r\nTests de fonctionnalités\r\n\r\nMaintenance, Support et Optimisation SEO\r\nMises à jour régulières\r\nSEO', 5, 1, '2026-03-23 13:38:06', '2026-04-09 12:58:01'),
(4, 'travail', 'Stage : DEVELOPPEUR D\'APPLICATION WEB ET MOBILE', 'Voisinage FabLab', NULL, 'Abidjan, Côte d’Ivoire', '2023-09-23', '2024-07-23', 0, 'Développement et Conception de prototypage\r\nConception de l\'application\r\nConception de base de données\r\nCodage\r\nIntégration des APIs\r\nPrototypage rapide\r\n\r\nTests de Validation et Déploiement\r\nTests unitaires et d\'intégration\r\nDebugger\r\nPréparation du déploiement\r\nPublication\r\n\r\nCollaboration et Gestion de Projet\r\nTravail en équipe\r\nPlanification et suivi des projets\r\nDocumentation', 3, 1, '2026-03-23 13:41:16', '2026-03-23 13:42:38'),
(5, 'travail', 'Contrat de Travail Temporaire : INVENTORISTE', 'BCEAO', NULL, 'Yamoussoukro, Côte d’Ivoire', '2025-10-01', '2025-10-31', 0, 'Inventaire de tous les équipement de la BCEAO Yamoussoukro, Côte d’Ivoire', 2, 1, '2026-03-23 13:47:42', '2026-03-24 09:58:58'),
(6, 'travail', 'Contrat à Durée Déterminée : ADMINISTRATEUR WEB', 'IIPEA', NULL, 'Yamoussoukro, Côte d’Ivoire', '2024-11-23', NULL, 1, 'Administration des sites et plateformes web\r\nGérer et maintenir le site web officiel de l’école ou de l’université.\r\nMettre à jour les contenus (actualités, programmes, événements, résultats, inscriptions, etc.).\r\nAdministrer les plateformes numériques telles que les portails étudiants, les plateformes e-learning et les systèmes de gestion académique.', 1, 1, '2026-03-23 13:53:14', '2026-03-23 13:53:21'),
(7, 'formation', 'Brevet d\'Etude Premier Cycle (BEPC)', 'Collège Catholique Pierre Pango (CCPP)', NULL, 'Daloa, Côte d’Ivoire', '2016-01-01', '2017-01-01', 0, NULL, 6, 1, '2026-03-23 13:56:11', '2026-03-23 14:13:34'),
(8, 'formation', 'Baccalauréat série D (BAC D)', 'Lycée Antoine Gauze  (LAG)', NULL, 'Daloa, Côte d’Ivoire', '2019-01-01', '2020-01-01', 0, 'Baccalauréat Scientifique. Mention Assez-Bien', 5, 1, '2026-03-23 13:59:02', '2026-03-23 14:13:26'),
(9, 'formation', 'LICENCE en Informatique et Science du Numérique', 'Université Virtuelle de Côte d’Ivoire (UVCI)', NULL, 'Abidjan, Côte d’Ivoire', '2022-01-01', '2023-01-01', 0, 'Specialité: Développement d’Application et e-Service (DAS). Mention Assez-Bien', 4, 1, '2026-03-23 14:03:28', '2026-03-23 14:13:14'),
(10, 'formation', 'Master 1 en Informatique et Science du Numérique', 'Université Virtuelle de Côte d’Ivoire (UVCI)', NULL, 'Abidjan, Côte d’Ivoire', '2024-01-23', '2025-01-01', 0, 'Master de recherche Spécialité: Big Data Analytics (BDA)', 3, 1, '2026-03-23 14:06:14', '2026-03-23 14:12:10'),
(11, 'formation', 'Master 2 en Informatique et Science du Numérique', 'Université Virtuelle de Côte d’Ivoire (UVCI)', NULL, 'Abidjan, Côte d’Ivoire', '2025-01-01', NULL, 1, 'Master de recherche Spécialité: Big Data Analytics (BDA)', 2, 1, '2026-03-23 14:08:35', '2026-03-23 14:08:35'),
(12, 'formation', 'Master 2 en Informatique Génie Logiciel', 'Institut International Polytechnique des Élites d\'Abidjan (IIPEA)', NULL, 'Yamoussoukro, Côte d’Ivoire', '2025-01-01', NULL, 1, 'Master Professionnel Spécialité: Génie Logiciel', 1, 1, '2026-03-23 14:11:44', '2026-03-24 09:57:19'),
(13, 'travail', 'Contrat de Travail Temporaire : METROLOGIE', 'SIR', NULL, 'Abidjan/Côte d\'Ivoire', '2022-02-23', '2022-04-16', 0, 'Aide à la structure Métrologie dans le cadre de l\'arrêt AG/CENTRALE/HSK3 2022', 6, 1, '2026-04-09 13:13:55', '2026-04-09 13:13:55');

-- --------------------------------------------------------

--
-- Structure de la table `lettres_motivations`
--

DROP TABLE IF EXISTS `lettres_motivations`;
CREATE TABLE IF NOT EXISTS `lettres_motivations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `modele` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'classique',
  `entreprise` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recruteur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poste` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_contrat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_lettre` date NOT NULL,
  `infos_complementaires` text COLLATE utf8mb4_unicode_ci,
  `contenu_genere` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lettres_user` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lettres_motivations`
--

INSERT INTO `lettres_motivations` (`id`, `user_id`, `modele`, `entreprise`, `recruteur`, `poste`, `type_contrat`, `ville`, `date_lettre`, `infos_complementaires`, `contenu_genere`, `created_at`, `updated_at`) VALUES
(1, 3, 'colore', 'Benahou', 'Directeur Géneral', 'Ingénieur Développeur Web', 'cdi', 'Abidjan', '2026-04-10', 'Disponible Immédiatement', NULL, '2026-04-10 11:02:10', '2026-04-10 11:02:10'),
(2, 3, 'moderne', 'SIR', 'Directeur Géneral', 'Ingénieur Développeur Web', 'cdd', 'Abidjan', '2026-04-10', 'Disponible immédiatement', NULL, '2026-04-10 11:05:56', '2026-04-10 11:05:56'),
(3, 3, 'classique', 'WinnerShop', 'Directeur Géneral', 'Ingénieur Développeur Web', 'freelance', 'Abidjan', '2026-04-10', 'Disponible immédiatement', NULL, '2026-04-10 11:07:16', '2026-04-10 11:07:16');

-- --------------------------------------------------------

--
-- Structure de la table `lettre_modeles`
--

DROP TABLE IF EXISTS `lettre_modeles`;
CREATE TABLE IF NOT EXISTS `lettre_modeles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `apercu` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sujet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lu` tinyint(1) NOT NULL DEFAULT '0',
  `lu_le` timestamp NULL DEFAULT NULL,
  `repondu` tinyint(1) NOT NULL DEFAULT '0',
  `important` tinyint(1) NOT NULL DEFAULT '0',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_lu` (`lu`),
  KEY `idx_important` (`important`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `nom`, `prenom`, `email`, `telephone`, `sujet`, `message`, `lu`, `lu_le`, `repondu`, `important`, `ip`, `created_at`, `updated_at`) VALUES
(1, 'AHOUTOU', 'N\'DA', 'ahoutoundajosue45@gmail.com', '+2250545397593', 'Juste un test depuis le téléphone', 'Je veux faire un test depuis le téléphone idée de savoir si tout fonctionne correctement', 1, '2026-03-23 16:29:02', 1, 1, '192.168.137.34', '2026-03-23 16:25:16', '2026-03-23 20:00:11');

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

DROP TABLE IF EXISTS `parametres`;
CREATE TABLE IF NOT EXISTS `parametres` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cle` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valeur` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `groupe` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'site',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cle` (`cle`),
  KEY `idx_groupe` (`groupe`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parametres`
--

INSERT INTO `parametres` (`id`, `cle`, `valeur`, `groupe`, `created_at`, `updated_at`) VALUES
(1, 'site_nom', 'AHOUTOU N\'DA JOSUE', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:21'),
(2, 'site_logo', 'Ahoutou.dev', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:21'),
(3, 'site_titre', 'Développeur d\'Application Web et Mobile', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:21'),
(4, 'site_description', '<p>Je conçois des applications web et mobiles modernes, performantes et élégantes. Du back-end robuste à l\'interface utilisateur soignée, tout sous un même toit.</p>', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:20'),
(5, 'site_email', 'ahoutoundajosue45@gmail.com', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:21'),
(6, 'site_telephone', '+225 01 03 23 69 07 / 05 66 94 71 07', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:21'),
(7, 'site_adresse', 'Yamoussoukro, Côte d\'Ivoire', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:20'),
(8, 'site_disponibilite', 'Lun–Ven · 8h–16h GMT', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:20'),
(9, 'site_disponible', '1', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:20'),
(10, 'site_cv', 'https://www.jobseeker.com/app/resumes/7a5cfc57-1176-4ffe-83b4-5d1d661ed796/edit?fullscreenPreview=1', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:20'),
(11, 'site_a_propos', '<p>Je suis <strong>AHOUTOU N\'da Josué</strong>, développeur Full-Stack passionné par la création d\'expériences numériques modernes, performantes et pensées pour l\'utilisateur final.</p><p>Avec plusieurs années d\'expérience, j\'interviens sur un large spectre de projets : <strong>sites e-commerce</strong>, <strong>plateformes immobilières</strong>, <strong>LMS (cours en ligne)</strong>, <strong>systèmes de prise de rendez-vous</strong> et <strong>applications métier sur mesure</strong>. Je maîtrise aussi bien les CMS comme <strong>WordPress</strong> (Woo Commerce, Divi, Elementor) que le développement from scratch avec <strong>Laravel</strong> et <strong>CodeIgniter</strong>.</p><p>Mon arsenal technique couvre l\'ensemble de la chaîne de développement :</p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Frontend</strong> — <em>HTML, CSS, JavaScript</em></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Backend</strong> — <em>PHP, Laravel, CodeIgniter, REST API</em></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Mobile</strong> — <em>Flutter / Dart (iOS &amp; Android)</em></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Base de données</strong> — <em>MySQL, PostgreSQL</em></li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>CMS</strong> — <em>WordPress, Woo Commerce, Divi</em></li></ol><p>Mon approche est simple : <strong>comprendre vos besoins</strong>, <strong>livrer de la valeur</strong>, <strong>dépasser les attentes</strong>. Je travaille avec rigueur, transparence et un souci constant de la qualité — du premier cahier des charges jusqu\'à la mise en production.</p>', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:19'),
(12, 'site_bio_courte', '<p>Développeur d\'Application Web et Mobile passionné, basé à Yamoussoukro. Disponible pour des projets freelance.</p>', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:20'),
(13, 'site_hero_badge', 'actuellement en formation', 'site', '2026-03-21 13:19:32', '2026-03-30 19:08:21'),
(14, 'stats_projets', '2', 'stats', '2026-03-21 13:19:32', '2026-03-24 08:16:12'),
(15, 'stats_clients', '2', 'stats', '2026-03-21 13:19:32', '2026-03-24 08:16:12'),
(16, 'stats_experience', '1.6', 'stats', '2026-03-21 13:19:32', '2026-03-24 08:16:12'),
(17, 'stats_satisfaction', '100', 'stats', '2026-03-21 13:19:32', '2026-03-24 08:16:12'),
(18, 'seo_titre', 'Ahoutou N\'da Josué_Développeur d\'Application Web', 'seo', '2026-03-21 13:19:32', '2026-03-23 15:53:45'),
(19, 'seo_description', '<p>AHOUTOU N\'DA JOSUE – Développeur Web Full-Stack, spécialisé dans la conception et le développement d’applications web utilisant Laravel, WordPress et MySQL. Basé à Yamoussoukro, Côte d’Ivoire.</p>', 'seo', '2026-03-21 13:19:32', '2026-03-23 15:53:45'),
(20, 'seo_keywords', 'développeur web, full-stack, Laravel, MySQL, portfolio, Yamoussoukro', 'seo', '2026-03-21 13:19:32', '2026-03-23 15:53:45'),
(21, 'seo_author', 'AHOUTOU N\'DA JOSUE', 'seo', '2026-03-21 13:19:32', '2026-03-23 15:53:45'),
(22, 'seo_image_og', '', 'seo', '2026-03-21 13:19:32', '2026-03-23 15:53:45'),
(23, 'mail_from_name', 'Ahoutou N\'da Josue Portfolio', 'mail', '2026-03-21 13:19:32', '2026-03-24 09:45:23'),
(24, 'mail_from_address', 'ahoutoundajosue45@gmail.com', 'mail', '2026-03-21 13:19:32', '2026-03-24 09:45:23'),
(25, 'mail_to', 'ahoutoundajosue45@gmail.com', 'mail', '2026-03-21 13:19:32', '2026-03-24 09:45:23'),
(26, 'mail_subject_prefix', 'AHOUTOU', 'mail', '2026-03-21 13:19:32', '2026-03-24 09:45:23'),
(27, 'social_github', 'https://github.com/ahoutoundajosue', 'social', '2026-03-21 13:19:32', '2026-03-27 14:39:47'),
(28, 'social_linkedin', 'https://linkedin.com/in/ahoutoundajosue', 'social', '2026-03-21 13:19:32', '2026-03-27 14:39:47'),
(29, 'social_twitter', 'https://twitter.com/ahoutoundajosue', 'social', '2026-03-21 13:19:32', '2026-03-27 14:39:47');

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

DROP TABLE IF EXISTS `projets`;
CREATE TABLE IF NOT EXISTS `projets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contenu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'HTML riche affiché en page détail',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_projet` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('brouillon','publié','archivé') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'brouillon',
  `en_vedette` tinyint(1) NOT NULL DEFAULT '0',
  `url_demo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_github` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `client` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duree` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fonctionnalites` json DEFAULT NULL,
  `defis` json DEFAULT NULL,
  `vues` int UNSIGNED NOT NULL DEFAULT '0',
  `ordre` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_statut` (`statut`),
  KEY `idx_en_vedette` (`en_vedette`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `titre`, `slug`, `description`, `contenu`, `image`, `type_projet`, `role`, `statut`, `en_vedette`, `url_demo`, `url_github`, `date_debut`, `date_fin`, `client`, `duree`, `fonctionnalites`, `defis`, `vues`, `ordre`, `created_at`, `updated_at`) VALUES
(1, 'PRESSING MANAGER', 'pressing-manager', 'Pressing Manager est une application web de gestion complète pour pressing (teinturerie / nettoyage à sec). Elle couvre l\'intégralité du cycle métier : de l\'enregistrement des clients et commandes jusqu\'à la facturation, en passant par la gestion des paiements, le reporting comptable et l\'administration des utilisateurs.', NULL, 'projets/KN7iQKYliWVerlaFYXJFklCKDXYvaAOTkv9e2IKi.png', 'Application Web', NULL, 'publié', 1, 'https://demo.exemple.com', NULL, '2025-07-28', '2025-09-09', NULL, NULL, '[\"•\\tCentraliser la gestion des commandes et services de pressing\", \"•\\tSuivre les paiements en temps réel\", \"•\\tGénérer des rapports comptables par période\"]', '[{\"solution\": \"•\\tGénérer des rapports comptables par période\", \"challenge\": \"•\\tGénérer des rapports comptables par période\"}]', 33, 1, '2026-03-23 13:19:59', '2026-04-09 18:59:24'),
(3, 'RestoFood', 'restofood', 'RestoFood est une plateforme complète permettant la gestion d\'un restaurant en ligne avec commandes,\r\nlivraisons, réservations de tables, support client et administration avancée. L\'application couvre l\'ensemble\r\ndu cycle de vie d\'une commande, de la sélection des plats jusqu\'à la livraison et la confirmation', NULL, 'projets/rRHmMErcCk6ki63jaVgyLzLQRjmrxgqiUS8IgRLH.png', 'Application Web', NULL, 'publié', 1, 'https://demo.exemple.com', NULL, '2025-12-01', '2026-02-28', NULL, NULL, '[\"Catalogue de plats avec catégories filtrables\", \"Tailles configurables par plat (ex : Small, Medium, Large) avec prix additionnel\", \"Suppléments optionnels par plat avec prix de surcharge ou prix par défaut\"]', NULL, 30, 2, '2026-03-23 13:25:47', '2026-03-30 19:31:39'),
(4, 'AHOUTOU', 'ahoutou', NULL, NULL, NULL, NULL, NULL, 'publié', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, '2026-03-24 15:11:12', '2026-03-24 15:22:23');

-- --------------------------------------------------------

--
-- Structure de la table `projet_images`
--

DROP TABLE IF EXISTS `projet_images`;
CREATE TABLE IF NOT EXISTS `projet_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `projet_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legende` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_couverture` tinyint(1) NOT NULL DEFAULT '0',
  `ordre` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pi_projet` (`projet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projet_images`
--

INSERT INTO `projet_images` (`id`, `projet_id`, `image`, `legende`, `alt`, `est_couverture`, `ordre`, `created_at`, `updated_at`) VALUES
(6, 1, 'projets/galerie/FOovy3jqM3rmTsB37fXAwBoaZxplEPnYl1vtGi2p.png', 'Optionnel', NULL, 0, 2, '2026-03-24 15:00:12', '2026-03-24 15:11:26');

-- --------------------------------------------------------

--
-- Structure de la table `projet_tag`
--

DROP TABLE IF EXISTS `projet_tag`;
CREATE TABLE IF NOT EXISTS `projet_tag` (
  `projet_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`projet_id`,`tag_id`),
  KEY `fk_pt_tag` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projet_tag`
--

INSERT INTO `projet_tag` (`projet_id`, `tag_id`) VALUES
(1, 6),
(3, 6),
(1, 7),
(3, 7),
(1, 8),
(3, 8),
(1, 9),
(3, 9),
(1, 10),
(3, 10),
(1, 11),
(3, 11),
(1, 12),
(3, 12);

-- --------------------------------------------------------

--
-- Structure de la table `reseaux_sociaux`
--

DROP TABLE IF EXISTS `reseaux_sociaux`;
CREATE TABLE IF NOT EXISTS `reseaux_sociaux` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `ordre` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '#ff7c08',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`id`, `nom`, `slug`, `couleur`, `created_at`, `updated_at`) VALUES
(6, 'HTML', 'html', '#3b82f6', '2026-03-23 12:53:44', '2026-03-23 13:15:11'),
(7, 'CSS', 'css', '#f97316', '2026-03-23 13:15:29', '2026-03-23 13:15:29'),
(8, 'JS', 'js', '#f59e0b', '2026-03-23 13:15:44', '2026-03-23 13:15:44'),
(9, 'PHP', 'php', '#84cc16', '2026-03-23 13:15:58', '2026-03-23 13:15:58'),
(10, 'SQL', 'sql', '#3b82f6', '2026-03-23 13:17:02', '2026-03-23 13:17:02'),
(11, 'BOOTSTRAP 5', 'bootstrap-5', '#8b5cf6', '2026-03-23 13:17:19', '2026-03-23 13:17:19'),
(12, 'LARAVEL 10', 'laravel-10', '#ef4444', '2026-03-23 13:17:31', '2026-03-23 13:17:31');

-- --------------------------------------------------------

--
-- Structure de la table `temoignages`
--

DROP TABLE IF EXISTS `temoignages`;
CREATE TABLE IF NOT EXISTS `temoignages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `poste` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entreprise` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` tinyint UNSIGNED NOT NULL DEFAULT '5' COMMENT 'Note sur 5',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `ordre` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `temoignages`
--

INSERT INTO `temoignages` (`id`, `nom`, `poste`, `entreprise`, `avatar`, `contenu`, `note`, `actif`, `ordre`, `created_at`, `updated_at`) VALUES
(1, 'Marie Kouamé', 'Directrice Générale', 'BCEAO', NULL, 'Un développeur sérieux, réactif et passionné. La qualité de son code et sa capacité à proposer des solutions créatives ont été des atouts majeurs pour notre projet.', 5, 1, 0, '2026-03-23 15:36:56', '2026-03-23 19:57:58'),
(2, 'Jean-Paul Konan', 'Développeur Web', 'WinnerShop', NULL, 'Excellent profil, livraisons dans les délais et communication impeccable. Je recommande vivement.', 5, 1, 0, '2026-03-23 15:38:11', '2026-03-23 15:38:11');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pays` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poste_actuel` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biographie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `disponible` tinyint(1) NOT NULL DEFAULT '1',
  `cv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `prenom`, `nom`, `email`, `password`, `avatar`, `ville`, `pays`, `telephone`, `poste_actuel`, `biographie`, `disponible`, `cv`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'N\'DA JOSUE', 'AHOUTOU', 'ahoutoundajosue45@gmail.com', '$2y$12$puPwxLoldAjUMzwVovkDIu/Slenc0m67qanIiZL4d8v9cTQrv.ESi', 'avatars/Ho3Cm6CJifSl7Pwte7fMo1G2DKnktyg7lx8Y0kMu.jpg', 'Yamoussoukro', 'Côte d\'Ivoire', '0103236907', 'Développeur d\'Application Web et Mobile', 'Passionné par le code depuis mes études, je mets mon expertise au service de vos projets.', 1, NULL, 'admin', 'Ft58FcykRoiRZOmzWaQejoISxvHYQxiuLktGTaC9c7gUGPE94D8F3Fsr8TrT', '2026-03-21 13:48:06', '2026-04-12 00:41:35');

-- --------------------------------------------------------

--
-- Structure de la table `visites`
--

DROP TABLE IF EXISTS `visites`;
CREATE TABLE IF NOT EXISTS `visites` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `page` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `projet_id` bigint UNSIGNED DEFAULT NULL,
  `ip_hash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appareil` enum('desktop','mobile','tablette') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'desktop',
  `referrer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visite_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_page` (`page`),
  KEY `idx_visite_le` (`visite_le`),
  KEY `fk_v_projet` (`projet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `visites`
--

INSERT INTO `visites` (`id`, `page`, `projet_id`, `ip_hash`, `appareil`, `referrer`, `visite_le`) VALUES
(1, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 16:01:27'),
(2, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 16:01:33'),
(3, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 16:12:20'),
(4, '/projets/restofood', 3, '5fe453b511d22407585f83ed7394eabd86941215c0f48da8f5c047ac20d8e96e', 'mobile', 'http://192.168.137.1:8000/projets', '2026-03-23 16:19:24'),
(5, '/projets/restofood', 3, '5fe453b511d22407585f83ed7394eabd86941215c0f48da8f5c047ac20d8e96e', 'mobile', 'http://192.168.137.1:8000/', '2026-03-23 16:21:14'),
(6, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 17:58:40'),
(7, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 18:06:21'),
(8, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 18:07:46'),
(9, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 18:08:27'),
(10, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 18:24:23'),
(11, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 18:24:55'),
(12, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 18:25:09'),
(13, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 18:25:25'),
(14, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets/pressing-manager', '2026-03-23 18:25:39'),
(15, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets/pressing-manager', '2026-03-23 18:26:42'),
(16, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 18:27:57'),
(17, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/', '2026-03-23 18:28:05'),
(18, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 18:28:25'),
(19, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets/pressing-manager', '2026-03-23 18:31:13'),
(20, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 19:50:02'),
(21, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 19:51:22'),
(22, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-23 19:51:28'),
(23, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/', '2026-03-23 19:52:30'),
(24, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 08:07:49'),
(25, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 08:23:17'),
(26, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 08:24:09'),
(27, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 08:24:43'),
(28, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 08:25:15'),
(29, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 08:36:14'),
(30, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 08:38:25'),
(31, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 08:51:28'),
(32, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 09:03:44'),
(33, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 09:04:12'),
(34, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 09:04:30'),
(35, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets/restofood', '2026-03-24 09:04:53'),
(36, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets/restofood', '2026-03-24 09:04:58'),
(37, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 09:07:47'),
(38, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 09:08:13'),
(39, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 09:17:53'),
(40, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 09:19:50'),
(41, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 09:19:58'),
(42, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/', '2026-03-24 09:29:17'),
(43, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 10:20:32'),
(44, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 15:00:47'),
(45, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 15:01:41'),
(46, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 15:04:12'),
(47, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 15:08:07'),
(48, '/projets/ahoutou', 4, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-24 15:12:47'),
(49, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/', '2026-03-27 14:34:26'),
(50, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/', '2026-03-30 10:28:32'),
(51, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets/pressing-manager', '2026-03-30 10:29:51'),
(52, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:13:53'),
(53, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:24:34'),
(54, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:25:42'),
(55, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:26:04'),
(56, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:26:30'),
(57, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:27:50'),
(58, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:29:25'),
(59, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:29:46'),
(60, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:30:10'),
(61, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:30:51'),
(62, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:31:08'),
(63, '/projets/restofood', 3, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-03-30 19:31:39'),
(64, '/projets/pressing-manager', 1, '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'desktop', 'http://127.0.0.1:8000/projets', '2026-04-09 18:59:25');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `competences`
--
ALTER TABLE `competences`
  ADD CONSTRAINT `fk_comp_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie_competences` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projet_images`
--
ALTER TABLE `projet_images`
  ADD CONSTRAINT `fk_pi_projet` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projet_tag`
--
ALTER TABLE `projet_tag`
  ADD CONSTRAINT `fk_pt_projet` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pt_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `visites`
--
ALTER TABLE `visites`
  ADD CONSTRAINT `fk_v_projet` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
