<?php
// On écrit notre requête
$sql = "SELECT 
JSON_ARRAY(
SUM(CASE MONTH(date) WHEN 1 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 2 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 3 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 4 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 5 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 6 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 7 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 8 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 9 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 10 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 11 THEN 1 ELSE 0 END),
SUM(CASE MONTH(date) WHEN 12 THEN 1 ELSE 0 END) ) AS sum_per_month
FROM
audit WHERE YEAR(date) = YEAR(NOW())";

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$line = $query->fetch();
