-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 12 déc. 2020 à 15:03
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jalal`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondary_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `art_created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66A76ED395` (`user_id`),
  KEY `IDX_23A0E66BCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `secondary_title`, `content`, `main_image`, `art_created_at`, `user_id`, `categorie_id`) VALUES
(1, 'titre', 'titre 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam. Pulvinar proin gravida hendrerit lectus a. Vehicula ipsum a arcu cursus vitae. Facilisi etiam dignissim diam quis enim lobortis. Nisi est sit amet facilisis magna. Tortor at risus viverra adipiscing. In hac habitasse platea dictumst quisque sagittis purus sit amet. Et netus et malesuada fames ac turpis egestas integer eget. In metus vulputate eu scelerisque felis imperdiet proin fermentum leo. Mollis nunc sed id semper risus in. Ornare arcu odio ut sem nulla.\r\n\r\nTincidunt arcu non sodales neque sodales ut etiam. Ut tellus elementum sagittis vitae et. Tortor condimentum lacinia quis vel eros. Habitant morbi tristique senectus et netus et malesuada fames ac. Amet est placerat in egestas erat. Aliquet risus feugiat in ante metus dictum. Commodo elit at imperdiet dui accumsan sit amet nulla. Volutpat est velit egestas dui id ornare arcu odio. Purus gravida quis blandit turpis. Tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada proin. Est ullamcorper eget nulla facilisi etiam. Diam donec adipiscing tristique risus nec feugiat in. Placerat orci nulla pellentesque dignissim enim sit amet venenatis. Interdum velit laoreet id donec ultrices tincidunt arcu non.\r\n\r\nIn vitae turpis massa sed elementum tempus egestas sed. Egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. In nibh mauris cursus mattis molestie a. Id porta nibh venenatis cras sed felis eget velit. Magnis dis parturient montes nascetur ridiculus mus mauris. Dictum at tempor commodo ullamcorper a lacus. Mauris nunc congue nisi vitae suscipit tellus mauris a diam. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Convallis a cras semper auctor neque vitae tempus quam. Suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Pulvinar sapien et ligula ullamcorper malesuada proin. Fermentum dui faucibus in ornare quam viverra. Enim eu turpis egestas pretium aenean pharetra magna ac. Viverra aliquet eget sit amet tellus cras adipiscing enim. Sed risus ultricies tristique nulla aliquet enim. Dictum fusce ut placerat orci nulla pellentesque. Eu facilisis sed odio morbi quis commodo.\r\n\r\nSed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibus interdum posuere lorem. Nunc vel risus commodo viverra. Posuere ac ut consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et netus et. Leo urna molestie at elementum eu facilisis sed odio morbi. Mauris sit amet massa vitae tortor condimentum lacinia quis vel. Tempor orci dapibus ultrices in iaculis. At auctor urna nunc id cursus metus aliquam. Ac tortor dignissim convallis aenean et tortor at. Quis lectus nulla at volutpat diam ut. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Amet consectetur adipiscing elit duis. Accumsan sit amet nulla facilisi morbi. Dictumst vestibulum rhoncus est pellentesque elit.\r\n\r\nDuis at consectetur lorem donec massa sapien. Tempor id eu nisl nunc. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Et ultrices neque ornare aenean euismod elementum nisi quis eleifend. Sed lectus vestibulum mattis ullamcorper velit sed. Viverra vitae congue eu consequat ac felis donec et. Sed elementum tempus egestas sed sed risus pretium quam vulputate. Adipiscing enim eu turpis egestas pretium aenean pharetra magna ac. Bibendum neque egestas congue quisque egestas diam in. Tellus mauris a diam maecenas sed enim ut. Felis imperdiet proin fermentum leo vel orci porta non pulvinar. In nisl nisi scelerisque eu. Vel facilisis volutpat est velit egestas. Nisi vitae suscipit tellus mauris a diam maecenas. Ut tellus elementum sagittis vitae et leo duis. Eget sit amet tellus cras. In hendrerit gravida rutrum quisque. Pellentesque sit amet porttitor eget dolor morbi non arcu.', 'poulo2.jpg', '2020-09-18 00:00:00', 2, 2),
(2, 'article 2 ', 'article 2 second tiltel', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam. Pulvinar proin gravida hendrerit lectus a. Vehicula ipsum a arcu cursus vitae. Facilisi etiam dignissim diam quis enim lobortis. Nisi est sit amet facilisis magna. Tortor at risus viverra adipiscing. In hac habitasse platea dictumst quisque sagittis purus sit amet. Et netus et malesuada fames ac turpis egestas integer eget. In metus vulputate eu scelerisque felis imperdiet proin fermentum leo. Mollis nunc sed id semper risus in. Ornare arcu odio ut sem nulla.\r\n\r\nTincidunt arcu non sodales neque sodales ut etiam. Ut tellus elementum sagittis vitae et. Tortor condimentum lacinia quis vel eros. Habitant morbi tristique senectus et netus et malesuada fames ac. Amet est placerat in egestas erat. Aliquet risus feugiat in ante metus dictum. Commodo elit at imperdiet dui accumsan sit amet nulla. Volutpat est velit egestas dui id ornare arcu odio. Purus gravida quis blandit turpis. Tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada proin. Est ullamcorper eget nulla facilisi etiam. Diam donec adipiscing tristique risus nec feugiat in. Placerat orci nulla pellentesque dignissim enim sit amet venenatis. Interdum velit laoreet id donec ultrices tincidunt arcu non.\r\n\r\nIn vitae turpis massa sed elementum tempus egestas sed. Egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. In nibh mauris cursus mattis molestie a. Id porta nibh venenatis cras sed felis eget velit. Magnis dis parturient montes nascetur ridiculus mus mauris. Dictum at tempor commodo ullamcorper a lacus. Mauris nunc congue nisi vitae suscipit tellus mauris a diam. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Convallis a cras semper auctor neque vitae tempus quam. Suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Pulvinar sapien et ligula ullamcorper malesuada proin. Fermentum dui faucibus in ornare quam viverra. Enim eu turpis egestas pretium aenean pharetra magna ac. Viverra aliquet eget sit amet tellus cras adipiscing enim. Sed risus ultricies tristique nulla aliquet enim. Dictum fusce ut placerat orci nulla pellentesque. Eu facilisis sed odio morbi quis commodo.\r\n\r\nSed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibus interdum posuere lorem. Nunc vel risus commodo viverra. Posuere ac ut consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et netus et. Leo urna molestie at elementum eu facilisis sed odio morbi. Mauris sit amet massa vitae tortor condimentum lacinia quis vel. Tempor orci dapibus ultrices in iaculis. At auctor urna nunc id cursus metus aliquam. Ac tortor dignissim convallis aenean et tortor at. Quis lectus nulla at volutpat diam ut. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Amet consectetur adipiscing elit duis. Accumsan sit amet nulla facilisi morbi. Dictumst vestibulum rhoncus est pellentesque elit.\r\n\r\nDuis at consectetur lorem donec massa sapien. Tempor id eu nisl nunc. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Et ultrices neque ornare aenean euismod elementum nisi quis eleifend. Sed lectus vestibulum mattis ullamcorper velit sed. Viverra vitae congue eu consequat ac felis donec et. Sed elementum tempus egestas sed sed risus pretium quam vulputate. Adipiscing enim eu turpis egestas pretium aenean pharetra magna ac. Bibendum neque egestas congue quisque egestas diam in. Tellus mauris a diam maecenas sed enim ut. Felis imperdiet proin fermentum leo vel orci porta non pulvinar. In nisl nisi scelerisque eu. Vel facilisis volutpat est velit egestas. Nisi vitae suscipit tellus mauris a diam maecenas. Ut tellus elementum sagittis vitae et leo duis. Eget sit amet tellus cras. In hendrerit gravida rutrum quisque. Pellentesque sit amet porttitor eget dolor morbi non arcu.', 'Barro.jpg', '2020-10-08 03:18:09', 2, 1),
(3, 'El Hadj', 'Omar Tall', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam. Pulvinar proin gravida hendrerit lectus a. Vehicula ipsum a arcu cursus vitae. Facilisi etiam dignissim diam quis enim lobortis. Nisi est sit amet facilisis magna. Tortor at risus viverra adipiscing. In hac habitasse platea dictumst quisque sagittis purus sit amet. Et netus et malesuada fames ac turpis egestas integer eget. In metus vulputate eu scelerisque felis imperdiet proin fermentum leo. Mollis nunc sed id semper risus in. Ornare arcu odio ut sem nulla.\r\n\r\nTincidunt arcu non sodales neque sodales ut etiam. Ut tellus elementum sagittis vitae et. Tortor condimentum lacinia quis vel eros. Habitant morbi tristique senectus et netus et malesuada fames ac. Amet est placerat in egestas erat. Aliquet risus feugiat in ante metus dictum. Commodo elit at imperdiet dui accumsan sit amet nulla. Volutpat est velit egestas dui id ornare arcu odio. Purus gravida quis blandit turpis. Tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada proin. Est ullamcorper eget nulla facilisi etiam. Diam donec adipiscing tristique risus nec feugiat in. Placerat orci nulla pellentesque dignissim enim sit amet venenatis. Interdum velit laoreet id donec ultrices tincidunt arcu non.\r\n\r\nIn vitae turpis massa sed elementum tempus egestas sed. Egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. In nibh mauris cursus mattis molestie a. Id porta nibh venenatis cras sed felis eget velit. Magnis dis parturient montes nascetur ridiculus mus mauris. Dictum at tempor commodo ullamcorper a lacus. Mauris nunc congue nisi vitae suscipit tellus mauris a diam. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Convallis a cras semper auctor neque vitae tempus quam. Suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Pulvinar sapien et ligula ullamcorper malesuada proin. Fermentum dui faucibus in ornare quam viverra. Enim eu turpis egestas pretium aenean pharetra magna ac. Viverra aliquet eget sit amet tellus cras adipiscing enim. Sed risus ultricies tristique nulla aliquet enim. Dictum fusce ut placerat orci nulla pellentesque. Eu facilisis sed odio morbi quis commodo.\r\n\r\nSed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibus interdum posuere lorem. Nunc vel risus commodo viverra. Posuere ac ut consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et netus et. Leo urna molestie at elementum eu facilisis sed odio morbi. Mauris sit amet massa vitae tortor condimentum lacinia quis vel. Tempor orci dapibus ultrices in iaculis. At auctor urna nunc id cursus metus aliquam. Ac tortor dignissim convallis aenean et tortor at. Quis lectus nulla at volutpat diam ut. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Amet consectetur adipiscing elit duis. Accumsan sit amet nulla facilisi morbi. Dictumst vestibulum rhoncus est pellentesque elit.\r\n\r\nDuis at consectetur lorem donec massa sapien. Tempor id eu nisl nunc. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Et ultrices neque ornare aenean euismod elementum nisi quis eleifend. Sed lectus vestibulum mattis ullamcorper velit sed. Viverra vitae congue eu consequat ac felis donec et. Sed elementum tempus egestas sed sed risus pretium quam vulputate. Adipiscing enim eu turpis egestas pretium aenean pharetra magna ac. Bibendum neque egestas congue quisque egestas diam in. Tellus mauris a diam maecenas sed enim ut. Felis imperdiet proin fermentum leo vel orci porta non pulvinar. In nisl nisi scelerisque eu. Vel facilisis volutpat est velit egestas. Nisi vitae suscipit tellus mauris a diam maecenas. Ut tellus elementum sagittis vitae et leo duis. Eget sit amet tellus cras. In hendrerit gravida rutrum quisque. Pellentesque sit amet porttitor eget dolor morbi non arcu.', 'Tall.jpg', '2020-10-09 01:00:00', 1, 1),
(4, 'Théatre au Sénégal', 'titre secondaire', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam. Pulvinar proin gravida hendrerit lectus a. Vehicula ipsum a arcu cursus vitae. Facilisi etiam dignissim diam quis enim lobortis. Nisi est sit amet facilisis magna. Tortor at risus viverra adipiscing. In hac habitasse platea dictumst quisque sagittis purus sit amet. Et netus et malesuada fames ac turpis egestas integer eget. In metus vulputate eu scelerisque felis imperdiet proin fermentum leo. Mollis nunc sed id semper risus in. Ornare arcu odio ut sem nulla.\r\n\r\nTincidunt arcu non sodales neque sodales ut etiam. Ut tellus elementum sagittis vitae et. Tortor condimentum lacinia quis vel eros. Habitant morbi tristique senectus et netus et malesuada fames ac. Amet est placerat in egestas erat. Aliquet risus feugiat in ante metus dictum. Commodo elit at imperdiet dui accumsan sit amet nulla. Volutpat est velit egestas dui id ornare arcu odio. Purus gravida quis blandit turpis. Tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada proin. Est ullamcorper eget nulla facilisi etiam. Diam donec adipiscing tristique risus nec feugiat in. Placerat orci nulla pellentesque dignissim enim sit amet venenatis. Interdum velit laoreet id donec ultrices tincidunt arcu non.\r\n\r\nIn vitae turpis massa sed elementum tempus egestas sed. Egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. In nibh mauris cursus mattis molestie a. Id porta nibh venenatis cras sed felis eget velit. Magnis dis parturient montes nascetur ridiculus mus mauris. Dictum at tempor commodo ullamcorper a lacus. Mauris nunc congue nisi vitae suscipit tellus mauris a diam. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Convallis a cras semper auctor neque vitae tempus quam. Suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Pulvinar sapien et ligula ullamcorper malesuada proin. Fermentum dui faucibus in ornare quam viverra. Enim eu turpis egestas pretium aenean pharetra magna ac. Viverra aliquet eget sit amet tellus cras adipiscing enim. Sed risus ultricies tristique nulla aliquet enim. Dictum fusce ut placerat orci nulla pellentesque. Eu facilisis sed odio morbi quis commodo.\r\n\r\nSed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibus interdum posuere lorem. Nunc vel risus commodo viverra. Posuere ac ut consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et netus et. Leo urna molestie at elementum eu facilisis sed odio morbi. Mauris sit amet massa vitae tortor condimentum lacinia quis vel. Tempor orci dapibus ultrices in iaculis. At auctor urna nunc id cursus metus aliquam. Ac tortor dignissim convallis aenean et tortor at. Quis lectus nulla at volutpat diam ut. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Amet consectetur adipiscing elit duis. Accumsan sit amet nulla facilisi morbi. Dictumst vestibulum rhoncus est pellentesque elit.\r\n\r\nDuis at consectetur lorem donec massa sapien. Tempor id eu nisl nunc. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Et ultrices neque ornare aenean euismod elementum nisi quis eleifend. Sed lectus vestibulum mattis ullamcorper velit sed. Viverra vitae congue eu consequat ac felis donec et. Sed elementum tempus egestas sed sed risus pretium quam vulputate. Adipiscing enim eu turpis egestas pretium aenean pharetra magna ac. Bibendum neque egestas congue quisque egestas diam in. Tellus mauris a diam maecenas sed enim ut. Felis imperdiet proin fermentum leo vel orci porta non pulvinar. In nisl nisi scelerisque eu. Vel facilisis volutpat est velit egestas. Nisi vitae suscipit tellus mauris a diam maecenas. Ut tellus elementum sagittis vitae et leo duis. Eget sit amet tellus cras. In hendrerit gravida rutrum quisque. Pellentesque sit amet porttitor eget dolor morbi non arcu.', 'poulo.jpg', '2020-11-23 14:24:58', 2, 1),
(5, 'teste média', 'test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam. Pulvinar proin gravida hendrerit lectus a. Vehicula ipsum a arcu cursus vitae. Facilisi etiam dignissim diam quis enim lobortis. Nisi est sit amet facilisis magna. Tortor at risus viverra adipiscing. In hac habitasse platea dictumst quisque sagittis purus sit amet. Et netus et malesuada fames ac turpis egestas integer eget. In metus vulputate eu scelerisque felis imperdiet proin fermentum leo. Mollis nunc sed id semper risus in. Ornare arcu odio ut sem nulla.\r\n\r\nTincidunt arcu non sodales neque sodales ut etiam. Ut tellus elementum sagittis vitae et. Tortor condimentum lacinia quis vel eros. Habitant morbi tristique senectus et netus et malesuada fames ac. Amet est placerat in egestas erat. Aliquet risus feugiat in ante metus dictum. Commodo elit at imperdiet dui accumsan sit amet nulla. Volutpat est velit egestas dui id ornare arcu odio. Purus gravida quis blandit turpis. Tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada proin. Est ullamcorper eget nulla facilisi etiam. Diam donec adipiscing tristique risus nec feugiat in. Placerat orci nulla pellentesque dignissim enim sit amet venenatis. Interdum velit laoreet id donec ultrices tincidunt arcu non.\r\n\r\nIn vitae turpis massa sed elementum tempus egestas sed. Egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. In nibh mauris cursus mattis molestie a. Id porta nibh venenatis cras sed felis eget velit. Magnis dis parturient montes nascetur ridiculus mus mauris. Dictum at tempor commodo ullamcorper a lacus. Mauris nunc congue nisi vitae suscipit tellus mauris a diam. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Convallis a cras semper auctor neque vitae tempus quam. Suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Pulvinar sapien et ligula ullamcorper malesuada proin. Fermentum dui faucibus in ornare quam viverra. Enim eu turpis egestas pretium aenean pharetra magna ac. Viverra aliquet eget sit amet tellus cras adipiscing enim. Sed risus ultricies tristique nulla aliquet enim. Dictum fusce ut placerat orci nulla pellentesque. Eu facilisis sed odio morbi quis commodo.\r\n\r\nSed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibus interdum posuere lorem. Nunc vel risus commodo viverra. Posuere ac ut consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et netus et. Leo urna molestie at elementum eu facilisis sed odio morbi. Mauris sit amet massa vitae tortor condimentum lacinia quis vel. Tempor orci dapibus ultrices in iaculis. At auctor urna nunc id cursus metus aliquam. Ac tortor dignissim convallis aenean et tortor at. Quis lectus nulla at volutpat diam ut. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Amet consectetur adipiscing elit duis. Accumsan sit amet nulla facilisi morbi. Dictumst vestibulum rhoncus est pellentesque elit.\r\n\r\nDuis at consectetur lorem donec massa sapien. Tempor id eu nisl nunc. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Et ultrices neque ornare aenean euismod elementum nisi quis eleifend. Sed lectus vestibulum mattis ullamcorper velit sed. Viverra vitae congue eu consequat ac felis donec et. Sed elementum tempus egestas sed sed risus pretium quam vulputate. Adipiscing enim eu turpis egestas pretium aenean pharetra magna ac. Bibendum neque egestas congue quisque egestas diam in. Tellus mauris a diam maecenas sed enim ut. Felis imperdiet proin fermentum leo vel orci porta non pulvinar. In nisl nisi scelerisque eu. Vel facilisis volutpat est velit egestas. Nisi vitae suscipit tellus mauris a diam maecenas. Ut tellus elementum sagittis vitae et leo duis. Eget sit amet tellus cras. In hendrerit gravida rutrum quisque. Pellentesque sit amet porttitor eget dolor morbi non arcu.', 'Tall.jpg', '2020-11-23 15:21:35', 1, 2),
(6, 'Théatre au Sénégal', 'testa', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam. Pulvinar proin gravida hendrerit lectus a. Vehicula ipsum a arcu cursus vitae. Facilisi etiam dignissim diam quis enim lobortis. Nisi est sit amet facilisis magna. Tortor at risus viverra adipiscing. In hac habitasse platea dictumst quisque sagittis purus sit amet. Et netus et malesuada fames ac turpis egestas integer eget. In metus vulputate eu scelerisque felis imperdiet proin fermentum leo. Mollis nunc sed id semper risus in. Ornare arcu odio ut sem nulla.\r\n\r\nTincidunt arcu non sodales neque sodales ut etiam. Ut tellus elementum sagittis vitae et. Tortor condimentum lacinia quis vel eros. Habitant morbi tristique senectus et netus et malesuada fames ac. Amet est placerat in egestas erat. Aliquet risus feugiat in ante metus dictum. Commodo elit at imperdiet dui accumsan sit amet nulla. Volutpat est velit egestas dui id ornare arcu odio. Purus gravida quis blandit turpis. Tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada proin. Est ullamcorper eget nulla facilisi etiam. Diam donec adipiscing tristique risus nec feugiat in. Placerat orci nulla pellentesque dignissim enim sit amet venenatis. Interdum velit laoreet id donec ultrices tincidunt arcu non.\r\n\r\nIn vitae turpis massa sed elementum tempus egestas sed. Egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. In nibh mauris cursus mattis molestie a. Id porta nibh venenatis cras sed felis eget velit. Magnis dis parturient montes nascetur ridiculus mus mauris. Dictum at tempor commodo ullamcorper a lacus. Mauris nunc congue nisi vitae suscipit tellus mauris a diam. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Convallis a cras semper auctor neque vitae tempus quam. Suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Pulvinar sapien et ligula ullamcorper malesuada proin. Fermentum dui faucibus in ornare quam viverra. Enim eu turpis egestas pretium aenean pharetra magna ac. Viverra aliquet eget sit amet tellus cras adipiscing enim. Sed risus ultricies tristique nulla aliquet enim. Dictum fusce ut placerat orci nulla pellentesque. Eu facilisis sed odio morbi quis commodo.\r\n\r\nSed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibus interdum posuere lorem. Nunc vel risus commodo viverra. Posuere ac ut consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et netus et. Leo urna molestie at elementum eu facilisis sed odio morbi. Mauris sit amet massa vitae tortor condimentum lacinia quis vel. Tempor orci dapibus ultrices in iaculis. At auctor urna nunc id cursus metus aliquam. Ac tortor dignissim convallis aenean et tortor at. Quis lectus nulla at volutpat diam ut. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Amet consectetur adipiscing elit duis. Accumsan sit amet nulla facilisi morbi. Dictumst vestibulum rhoncus est pellentesque elit.\r\n\r\nDuis at consectetur lorem donec massa sapien. Tempor id eu nisl nunc. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Et ultrices neque ornare aenean euismod elementum nisi quis eleifend. Sed lectus vestibulum mattis ullamcorper velit sed. Viverra vitae congue eu consequat ac felis donec et. Sed elementum tempus egestas sed sed risus pretium quam vulputate. Adipiscing enim eu turpis egestas pretium aenean pharetra magna ac. Bibendum neque egestas congue quisque egestas diam in. Tellus mauris a diam maecenas sed enim ut. Felis imperdiet proin fermentum leo vel orci porta non pulvinar. In nisl nisi scelerisque eu. Vel facilisis volutpat est velit egestas. Nisi vitae suscipit tellus mauris a diam maecenas. Ut tellus elementum sagittis vitae et leo duis. Eget sit amet tellus cras. In hendrerit gravida rutrum quisque. Pellentesque sit amet porttitor eget dolor morbi non arcu.', 'Barro.jpg', '2020-11-23 15:31:20', 1, 1),
(7, 'Footbal', 'Foot feminin', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam. Pulvinar proin gravida hendrerit lectus a. Vehicula ipsum a arcu cursus vitae. Facilisi etiam dignissim diam quis enim lobortis. Nisi est sit amet facilisis magna. Tortor at risus viverra adipiscing. In hac habitasse platea dictumst quisque sagittis purus sit amet. Et netus et malesuada fames ac turpis egestas integer eget. In metus vulputate eu scelerisque felis imperdiet proin fermentum leo. Mollis nunc sed id semper risus in. Ornare arcu odio ut sem nulla.\r\n\r\nTincidunt arcu non sodales neque sodales ut etiam. Ut tellus elementum sagittis vitae et. Tortor condimentum lacinia quis vel eros. Habitant morbi tristique senectus et netus et malesuada fames ac. Amet est placerat in egestas erat. Aliquet risus feugiat in ante metus dictum. Commodo elit at imperdiet dui accumsan sit amet nulla. Volutpat est velit egestas dui id ornare arcu odio. Purus gravida quis blandit turpis. Tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada proin. Est ullamcorper eget nulla facilisi etiam. Diam donec adipiscing tristique risus nec feugiat in. Placerat orci nulla pellentesque dignissim enim sit amet venenatis. Interdum velit laoreet id donec ultrices tincidunt arcu non.\r\n\r\nIn vitae turpis massa sed elementum tempus egestas sed. Egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. In nibh mauris cursus mattis molestie a. Id porta nibh venenatis cras sed felis eget velit. Magnis dis parturient montes nascetur ridiculus mus mauris. Dictum at tempor commodo ullamcorper a lacus. Mauris nunc congue nisi vitae suscipit tellus mauris a diam. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Convallis a cras semper auctor neque vitae tempus quam. Suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Pulvinar sapien et ligula ullamcorper malesuada proin. Fermentum dui faucibus in ornare quam viverra. Enim eu turpis egestas pretium aenean pharetra magna ac. Viverra aliquet eget sit amet tellus cras adipiscing enim. Sed risus ultricies tristique nulla aliquet enim. Dictum fusce ut placerat orci nulla pellentesque. Eu facilisis sed odio morbi quis commodo.\r\n\r\nSed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibus interdum posuere lorem. Nunc vel risus commodo viverra. Posuere ac ut consequat semper viverra nam libero justo laoreet. Habitant morbi tristique senectus et netus et. Leo urna molestie at elementum eu facilisis sed odio morbi. Mauris sit amet massa vitae tortor condimentum lacinia quis vel. Tempor orci dapibus ultrices in iaculis. At auctor urna nunc id cursus metus aliquam. Ac tortor dignissim convallis aenean et tortor at. Quis lectus nulla at volutpat diam ut. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Amet consectetur adipiscing elit duis. Accumsan sit amet nulla facilisi morbi. Dictumst vestibulum rhoncus est pellentesque elit.\r\n\r\nDuis at consectetur lorem donec massa sapien. Tempor id eu nisl nunc. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Et ultrices neque ornare aenean euismod elementum nisi quis eleifend. Sed lectus vestibulum mattis ullamcorper velit sed. Viverra vitae congue eu consequat ac felis donec et. Sed elementum tempus egestas sed sed risus pretium quam vulputate. Adipiscing enim eu turpis egestas pretium aenean pharetra magna ac. Bibendum neque egestas congue quisque egestas diam in. Tellus mauris a diam maecenas sed enim ut. Felis imperdiet proin fermentum leo vel orci porta non pulvinar. In nisl nisi scelerisque eu. Vel facilisis volutpat est velit egestas. Nisi vitae suscipit tellus mauris a diam maecenas. Ut tellus elementum sagittis vitae et leo duis. Eget sit amet tellus cras. In hendrerit gravida rutrum quisque. Pellentesque sit amet porttitor eget dolor morbi non arcu.', 'rep1.jpg', '2020-11-29 14:16:47', 1, 3),
(8, 'teste média', 'Foot feminin', 'Foot feminin Foot feminin Foot feminin Foot feminin Foot feminin', 'Tall.jpg', '2020-12-03 22:43:47', 1, 4),
(9, 'teste média', 'Foot feminin', 'Le contenu du portfolio pourra alors sensiblement varier selon que l’on désire illustrer un ensemble de compétences au travers de projets déjà réalisés ou bien encore mettre l’accent sur sa personnalité et/ou son univers pour accroître son potentiel séduction.', 'tv.jpg', '2020-12-10 19:47:18', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `designation`, `created_at`) VALUES
(1, 'International', '2020-08-12 16:30:02'),
(2, 'national', '2020-08-21 00:00:00'),
(3, 'Sports', '2020-08-14 00:00:00'),
(4, 'Politique', '2020-08-14 17:55:25');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_at` datetime NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `like_comment` int(11) NOT NULL DEFAULT '0',
  `unlike_comment` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BC7294869C` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `article_id`, `user`, `comment_at`, `comment`, `like_comment`, `unlike_comment`) VALUES
(1, 1, 'Toto', '2020-11-22 19:22:08', 'Thierno Mansour Barro !', 0, 0),
(2, 1, 'Moussa', '2020-11-28 23:02:40', 'ed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibu', 0, 0),
(3, 3, 'Assa', '2020-11-28 23:03:16', 'ed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibu', 0, 0),
(4, 8, 'Moussa', '2020-12-06 12:20:32', 'ed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibu ed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus ', 1, 0),
(5, 9, 'Toto', '2020-12-11 21:07:00', 'ed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse faucibu', 28, 5),
(6, 9, 'Nathalie', '2020-12-11 21:08:34', 'ed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse fauc ed felis eget velit aliquet. Dui faucibus in ornare quam viverra. Non quam lacus suspendisse fauc qsed', 58, 6),
(10, 9, 'mantch', '2020-12-12 14:52:41', 'hello  hello', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200814172516', NULL, NULL),
('DoctrineMigrations\\Version20200918103714', '2020-09-18 10:37:25', 175),
('DoctrineMigrations\\Version20201009180409', NULL, NULL),
('DoctrineMigrations\\Version20201009180707', NULL, NULL),
('DoctrineMigrations\\Version20201009182013', NULL, NULL),
('DoctrineMigrations\\Version20201018172536', NULL, NULL),
('DoctrineMigrations\\Version20201118154839', NULL, NULL),
('DoctrineMigrations\\Version20201118162533', NULL, NULL),
('DoctrineMigrations\\Version20201118163048', '2020-11-18 16:31:44', 150),
('DoctrineMigrations\\Version20201212124223', '2020-12-12 12:46:31', 206);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `legende` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texte` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6A2CA10C7294869C` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `article_id`, `nom`, `legende`, `texte`, `ordre`, `type`, `created_at`) VALUES
(1, 5, 'barro.jpg', 'sfdsf', 'lorem', 0, 'image', '2020-11-23 15:21:57'),
(2, 6, 'th.jpg', 'r\"zre', 'zerzer', 0, 'image', '2020-11-23 15:31:44'),
(3, 8, 'th.jpg', 'dgdf', 'dfgdfgfg', 0, 'image', '2020-12-03 22:44:05'),
(4, 9, 'satoru.jpg', 'sdf', 'Le contenu du portfolio pourra alors sensiblement varier', 0, 'image', '2020-12-10 19:47:56');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `civility` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `civility`, `first_name`, `last_name`, `mail`, `login`, `password`, `country`, `avatar`, `status`, `created_at`, `description`) VALUES
(1, 'homme', 'Harouna', 'Kane', 'rou07@dfdf.fr', 'arno', '$2y$10$0DaTIkULd4L6b9OClHy.MeZGWdrQSEE/2vCIQwOkY3MoVYWkdWkcy', 'Sénégal', 'berger.jpg', 'admin', '2020-08-12 18:10:58', NULL),
(2, 'femme', 'Fat', 'Dia', 'rou07@dfdf.fr', 'arno2', '$2y$10$LyhFgceh/1bg/dZMK8ArfuRpWUT51UX5w.PjevlthVXokfe4/v9Mq', 'France', 'Barro.jpg', 'utilisateur', '2020-08-12 18:11:34', NULL),
(3, 'homme', 'Harouna', 'ghjhghj', 'rou07@dfdf.fr', 'arno5', '$2y$10$L.ClSYEpQzXvL38VMWm7R.wVncOkXVnHmIglKx9J/wv28dKPMPQQK', 'Sénégal', 'hampate.jpg', 'utilisateur', '2020-09-18 11:37:55', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_23A0E66BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10C7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
