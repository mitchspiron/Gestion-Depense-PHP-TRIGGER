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