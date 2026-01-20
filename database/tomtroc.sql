-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 18 jan. 2026 à 16:20
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('available','unavailable') DEFAULT 'available',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `user_id`, `title`, `author`, `image`, `description`, `status`, `created_at`) VALUES
(8, 3, 'Astérix - Le devin', 'René Goscinny (Auteur), Albert Uderzo (Auteur)', 'storage/uploads/3/books/8/696cf74d70369_Goscinny-Uderzo-Astérix-N°-19-Le-devin-Amazonie-BD.jpg', 'Par une nuit d\'orage, alors que tous les Gaulois du village sont réunis dans la maison d\'Abraracourcix en attendant le retour de Panoramix, un étrange personnage vêtu d\'une peau de loup demande l\'hospitalité : c\'est un devin. Malgré les avertissements d\'Astérix mettant en garde les Gaulois contre ce charlatan, tous les habitants commencent à venir le consulter. La situation empire quand le devin, utilisé par les Romains qui l\'ont capturé, prédit la fin du petit village. Il faudra toute l\'intelligence d\'Astérix et de Panoramix (enfin de retour) pour contrecarrer les plans des Romains et du devin.', 'available', '2026-01-18 16:07:57'),
(9, 4, 'Blade runner: Les androïdes rêvent-ils de moutons électriques ?', 'Philip K. Dick (Auteur), Sébastien Guillot (Traduction)', 'storage/uploads/4/books/9/696cf7fdd09a1_71E4Z7seKZL._AC_UF1000,1000_QL80_.jpg', 'Le mouton n\'était pas mal, avec sa laine et ses bêlements plus vrais que nature - les voisins n\'y ont vu que du feu. Mais il arrive en fin de carrière : ses circuits fatigués ne maintiendront plus longtemps l\'illusion de la vie. Il va falloir le remplacer. Pas par un autre simulacre, non, par un véritable animal. Deckard en rêve, seulement ce n\'est pas avec les maigres primes que lui rapporte la chasse aux androïdes qu\'il parviendra à mettre assez de côté. Holden, c\'est lui qui récupère toujours les boulots les plus lucratifs - normal, c\'est le meilleur. Mais ce coup-ci, ça n\'a pas suffi. Face aux Nexus-6 de dernière génération, même Holden s\'est fait avoir. Alors, quand on propose à Deckard de reprendre la mission, il serre les dents et signe. De toute façon, qu\'a-t-il à perdre ?', 'available', '2026-01-18 16:10:53'),
(10, 4, 'Apprenez à programmer en C ; enfin un livre pour les débutants !', 'Mathieu Nebra (auteur)', 'storage/uploads/4/books/10/696cf8b64b6b2_9782953527803_1_75.jpg', 'Apprenez à programmer en C est le premier livre de la collection Livre du Zéro ! Ce livre a été entièrement auto-édité par l\'équipe du Site du Zéro, ce qui nous a permis d\'avoir de plus grandes libertés lors de sa conception. Nous avons voulu créer un livre à l\'image du site, respectant son style, sa pédagogie et ses touches d\'humour.\r\n\r\nCe livre contient le cours de programmation en C du Site du Zéro dans une édition largement revue et corrigée.\r\nIl a fait l\'objet de nombreuses relectures rigoureuses et a été complété de plusieurs remarques et anecdotes. Vous y trouverez notamment une série de chapitres inédits sur les structures de données : listes chaînées, piles, files, tables de hachage...\r\n\r\nCe livre a été écrit par Mathieu Nebra (M@teo21), auteur de nombreux cours sur le Site du Zéro, dont celui sur le langage C.', 'available', '2026-01-18 16:13:58'),
(11, 4, 'Coder proprement', 'Martin Robert C. (Auteur), Hervé Soulard (Traduction)', 'storage/uploads/4/books/11/696cf96665910_91rDX5YuLVL._AC_UF1000,1000_QL80_.jpg', 'Clean Code, la référence mondiale, en version française !\r\n\r\nSi un code \"sale\" peut fonctionner, il peut également remettre en question la pérennité d\'une entreprise de développement de logiciels. Chaque année, du temps et des ressources sont gaspillés à cause d\'un code mal écrit. \r\n\r\nCet ouvrage vous apprendra les meilleures pratiques de nettoyage du code \"à la volée\" et les valeurs d\'un artisan du logiciel qui feront de vous un meilleur programmeur. Véritable manuel du savoir-faire en développement agile, cet ouvrage est un outil indispensable à tout développeur, ingénieur logiciel, chef de projet, responsable d\'équipe ou analyste des systèmes dont l\'objectif est de produire un meilleur code. \r\n\r\nCoder proprement est décomposé en trois parties : \r\n- La première décrit les principes, les motifs et les pratiques employés dans l\'écriture d\'un code propre. \r\n- La deuxième est constituée de plusieurs études de cas à la complexité croissante. Chacune d\'elles est un exercice de nettoyage: vous partirez d\'un exemple de code présentant certains problèmes et l\'auteur vous expliquera comment en obtenir une version saine et performante. \r\n\r\n- La troisième partie est une sorte de \"récompense\" puisqu\'elle contient une liste d\'indicateurs éprouvés par l\'auteur qui seront précieux pour repérer efficacement les défauts de votre code.', 'unavailable', '2026-01-18 16:16:54'),
(12, 3, 'Spirou et Fantasio, tome 12 : Le Nid des Marsupilamis', 'Franquin (Dessins, Scénario)', 'storage/uploads/3/books/12/696cfa02a1501_71BLBP-P0RL._SL1378_.jpg', 'Seccotine organise une conférence pour y annoncer qu\'elle a découvert une famille de marsupilamis dans la forêt palombienne.', 'available', '2026-01-18 16:19:30');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `content`, `is_read`, `created_at`) VALUES
(51, 4, 3, 'Bonjour, j\'aimerais emprunter votre livre astérix, est-ce possible ?', 1, '2026-01-18 16:15:32'),
(52, 3, 4, 'Bonjour, oui c\'est possible !', 0, '2026-01-18 16:18:11');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `pseudo`, `email`, `password`, `avatar`, `bio`, `created_at`) VALUES
(3, 'Albert', 'Hugo', 'Algo', 'a@a.a', '$2y$10$HnBRDFhtYWUZv/SMyr1Oueeqmf4HZITvA0uWN8jc4WiVu1gqsXdlK', 'storage/uploads/3/avatars/avatar_3_1768748954.jpeg', NULL, '2026-01-18 16:05:33'),
(4, 'Fred', 'Dupont', 'Fripon', 'z@z.z', '$2y$10$5Z5vMvGMZ/C68UgMFugPrOwvC.qjxkQezzis16dNzRgsCo1DxS67S', 'storage/uploads/4/avatars/avatar_4_1768749110.jpg', NULL, '2026-01-18 16:06:05');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_pseudo` (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
