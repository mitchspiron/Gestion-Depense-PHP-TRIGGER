<?php
// On écrit notre requête
$sql = 'SELECT * FROM `etablissement`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$etablissements = $query->fetchAll(PDO::FETCH_ASSOC);