<?php
// On écrit notre requête
$sql = 'SELECT audit.*, etablissement.nom FROM `audit`, `etablissement` WHERE audit.etablissement = etablissement.id';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$audits = $query->fetchAll(PDO::FETCH_ASSOC);