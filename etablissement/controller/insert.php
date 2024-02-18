<?php
// On inclut la connexion à la base
require_once('../../configs/connection.php');

if(isset($_POST['add'])){
    if(isset($_POST['nom']) && !empty($_POST['nom'])
        && isset($_POST['budget']) && !empty($_POST['budget'])){
            $nom = strip_tags($_POST['nom']);
            $budget = strip_tags($_POST['budget']);

            $sql = "INSERT INTO `etablissement` (`nom`, `budget`) VALUES (:nom, :budget);";

            $query = $db->prepare($sql);

            $query->bindValue(':nom', $nom, PDO::PARAM_STR);
            $query->bindValue(':budget', $budget, PDO::PARAM_STR);

            $query->execute();
            
            header('Location: ../index.php');
        }
}

require_once('../../configs/close.php');