<?php
// On inclut la connexion à la base
require_once('../../configs/connection.php');

if(isset($_POST['edit'])){
    if(isset($_POST['id']) && !empty($_POST['id'])
        && isset($_POST['nom']) && !empty($_POST['nom'])
        && isset($_POST['budget']) && !empty($_POST['budget'])){
        $id = strip_tags($_POST['id']);
        $nom = strip_tags($_POST['nom']);
        $budget = strip_tags($_POST['budget']);

        $sql = "UPDATE `etablissement` SET `nom`=:nom, `budget`=:budget WHERE `id`=:id;";

        $query = $db->prepare($sql);

        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':budget', $budget, PDO::PARAM_STR);
        $query->bindValue(':id', $id ,PDO::PARAM_INT);

        $query->execute();

        header('Location: ../index.php');
    }
}

require_once('../../configs/close.php');