<?php
// On inclut la connexion à la base
require_once('../../configs/connection.php');

if(isset($_POST['add'])){
    if(isset($_POST['etab']) && !empty($_POST['etab'])
        && isset($_POST['montant']) && !empty($_POST['montant'])){
            $etab = strip_tags($_POST['etab']);
            $montant = strip_tags($_POST['montant']);

            $sql = "INSERT INTO `depense` (`etab_id`, `montant`, `date_creation`) VALUES (:etab, :montant, NOW());";

            $query = $db->prepare($sql);

            $query->bindValue(':etab', $etab, PDO::PARAM_INT);
            $query->bindValue(':montant', $montant, PDO::PARAM_STR);

            $query->execute();
            
            header('Location: ../index.php');
        }
}

require_once('../../configs/close.php');