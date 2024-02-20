<?php
// On inclut la connexion à la base
require_once('../../configs/connection.php');

if(isset($_POST['edit'])){
    if(isset($_POST['id']) && !empty($_POST['id'])
        && isset($_POST['etab']) && !empty($_POST['etab'])
        && isset($_POST['montant']) && !empty($_POST['montant'])){
        $id = strip_tags($_POST['id']);
        $etab = strip_tags($_POST['etab']);
        $montant = strip_tags($_POST['montant']);

        $sql = "UPDATE `depense` SET `etab_id`=:etab, `utilisateur`=:utilisateur, `montant`=:montant WHERE `id`=:id;";

        $query = $db->prepare($sql);

        $query->bindValue(':etab', $etab, PDO::PARAM_INT);
        $query->bindValue(':utilisateur', $_COOKIE['id'], PDO::PARAM_INT);
        $query->bindValue(':montant', $montant, PDO::PARAM_STR);
        $query->bindValue(':id', $id ,PDO::PARAM_INT);

        $query->execute();

        header('Location: ../index.php');
    }
}

require_once('../../configs/close.php');