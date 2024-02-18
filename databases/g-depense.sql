-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 18 fév. 2024 à 09:16
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `g-depense`
--

-- --------------------------------------------------------

--
-- Structure de la table `audit`
--

DROP TABLE IF EXISTS `audit`;
CREATE TABLE IF NOT EXISTS `audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `etablissement` int(11) NOT NULL,
  `num_depense` int(11) NOT NULL,
  `ancien_dep` varchar(20) DEFAULT NULL,
  `nouveau_dep` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

DROP TABLE IF EXISTS `depense`;
CREATE TABLE IF NOT EXISTS `depense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etab_id` int(11) NOT NULL,
  `montant` varchar(20) NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `etab_id` (`etab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déclencheurs `depense`
--
DROP TRIGGER IF EXISTS `delete_audit_trigger`;
DELIMITER $$
CREATE TRIGGER `delete_audit_trigger` AFTER DELETE ON `depense` FOR EACH ROW INSERT INTO audit VALUES(null,'SUPPRESSION', NOW(), Old.etab_id, Old.id, Old.montant, NULL)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `delete_depense_trigger`;
DELIMITER $$
CREATE TRIGGER `delete_depense_trigger` AFTER DELETE ON `depense` FOR EACH ROW UPDATE etablissement SET budget = budget + Old.montant WHERE id = Old.etab_id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_audit_trigger`;
DELIMITER $$
CREATE TRIGGER `insert_audit_trigger` AFTER INSERT ON `depense` FOR EACH ROW BEGIN
    SET @latest_depense = (SELECT montant FROM depense ORDER BY id DESC LIMIT 1 OFFSET 1);
    
    INSERT INTO audit VALUES(null, 'INSERTION', NOW(), New.etab_id, New.id, @latest_depense, New.montant);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_depense_trigger`;
DELIMITER $$
CREATE TRIGGER `insert_depense_trigger` AFTER INSERT ON `depense` FOR EACH ROW UPDATE etablissement SET budget = budget - New.montant WHERE id = New.etab_id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_audit_trigger`;
DELIMITER $$
CREATE TRIGGER `update_audit_trigger` AFTER UPDATE ON `depense` FOR EACH ROW INSERT INTO audit VALUES(null,'MODIFICATION', NOW(), New.etab_id, New.id, Old.montant, New.montant)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_depense_trigger`;
DELIMITER $$
CREATE TRIGGER `update_depense_trigger` AFTER UPDATE ON `depense` FOR EACH ROW UPDATE etablissement SET budget = budget - New.montant + Old.montant WHERE id = Old.etab_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `etablissement`
--

DROP TABLE IF EXISTS `etablissement`;
CREATE TABLE IF NOT EXISTS `etablissement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `budget` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour la table `depense`
--
ALTER TABLE `depense`
  ADD CONSTRAINT `depense_ibfk_1` FOREIGN KEY (`etab_id`) REFERENCES `etablissement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
