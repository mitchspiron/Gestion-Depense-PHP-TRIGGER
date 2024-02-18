<?php
// On écrit notre requête
$sql = "SELECT (SELECT COUNT(*) FROM etablissement) AS nb_etablissement, (SELECT COUNT(*) FROM audit WHERE action = 'INSERTION') AS nb_insertion, (SELECT COUNT(*) FROM audit WHERE action = 'MODIFICATION') AS nb_modification, (SELECT COUNT(*) FROM audit WHERE action = 'SUPPRESSION') AS nb_suppression";

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$count = $query->fetch();
