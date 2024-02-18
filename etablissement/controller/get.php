<?php
// On inclut la connexion à la base
require_once('../configs/connection.php');

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = strip_tags($_GET['id']);
    // On écrit notre requête
    $sql = 'SELECT * FROM `etablissement` WHERE `id`=:id';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On attache les valeurs
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On stocke le résultat dans un tableau associatif
    $etablissement = $query->fetch();

    if(!$etablissement){
        header('Location: ../index.php');
    }
}else{
    header('Location: ../index.php');
}

require_once('../configs/close.php');