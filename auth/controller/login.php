<!-- Bootstrap core JavaScript-->
<script src="../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../assets/js/swal.js"></script>
<?php
// On inclut la connexion à la base
require_once('../../configs/connection.php');

// Vérifier si le formulaire a été soumis
if (isset($_POST['login'])) {
  // Récupérer les données du formulaire
  $email = strip_tags($_POST['email']);
  $password = strip_tags($_POST['password']);

  // Préparer la requête SQL
  $sql = "SELECT * FROM utilisateur WHERE email = :email AND mot_de_passe = :password";

  // On prépare la requête
  $query = $db->prepare($sql);

  $query->bindValue(':email', $email, PDO::PARAM_STR);
  $query->bindValue(':password', $password, PDO::PARAM_STR);

  // Exécuter la requête
  $query->execute();

  // Récupérer les résultats
  $result = $query->fetch();
  // Vérifier si l'utilisateur existe
  if ($result) {
    // Stocker les données dans des cookies
    setcookie("email", $email, time() + (86400 * 30), "/"); // 86400 = 1 jour
    setcookie("nom", $result['nom'], time() + (86400 * 30), "/");
    setcookie("prenom", $result['prenom'], time() + (86400 * 30), "/");
    setcookie("id", $result['id'], time() + (86400 * 30), "/");

    // Rediriger l'utilisateur vers la page dashboard
    header('Location: ../../index.php');
  } else {

    //header('Location: ../index.php');

    echo "<script type='text/javascript'>

    $(document).ready(function(){
      Swal.fire({
        title: 'Accès réfusé !',
        text: 'Email ou mot de passe incorrect',
        icon: 'error'
      }).then(function() {
        window.location='../index.php'
      });;
    });

    </script>";
  }
}
require_once('../../configs/close.php');
