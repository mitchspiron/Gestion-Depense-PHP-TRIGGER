<?php
// On inclut la connexion à la base
require_once('../../configs/connection.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $sql = "DELETE FROM `etablissement` WHERE `id`=:id;";

    $query = $db->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    header('Location: ../index.php');
}

require_once('../../configs/close.php');
