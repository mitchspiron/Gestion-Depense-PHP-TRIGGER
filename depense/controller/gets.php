<?php
// On écrit notre requête
$sql = 'SELECT depense.*, etablissement.nom FROM `depense`, `etablissement` WHERE depense.etab_id = etablissement.id';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$depenses = $query->fetchAll(PDO::FETCH_ASSOC);