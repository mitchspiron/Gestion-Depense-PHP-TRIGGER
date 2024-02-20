<?php
// On écrit notre requête
$sql = "SELECT audit.*, etablissement.nom, CONCAT(utilisateur.nom,' ',utilisateur.prenom) AS personne FROM `audit`, `etablissement`, `utilisateur` WHERE audit.etablissement = etablissement.id AND utilisateur.id = audit.utilisateur ORDER BY id DESC";

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$audits = $query->fetchAll(PDO::FETCH_ASSOC);