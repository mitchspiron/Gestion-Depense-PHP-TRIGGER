<?php
// On écrit notre requête
$sql = "SELECT (SELECT COUNT(*) FROM audit WHERE action = 'INSERTION' AND MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())) AS nb_insertion, (SELECT COUNT(*) FROM audit WHERE action = 'MODIFICATION' AND MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())) AS nb_modification, (SELECT COUNT(*) FROM audit WHERE action = 'SUPPRESSION' AND MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())) AS nb_suppression;";

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$pie = $query->fetch();
?>