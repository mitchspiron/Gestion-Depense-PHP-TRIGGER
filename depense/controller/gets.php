<?php
// On écrit notre requête
$sql = "SELECT depense.*, etablissement.nom, CONCAT(utilisateur.nom,' ',utilisateur.prenom) AS personne FROM `depense`, `etablissement`, `utilisateur` WHERE depense.etab_id = etablissement.id AND utilisateur.id = depense.utilisateur";

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$depenses = $query->fetchAll(PDO::FETCH_ASSOC);