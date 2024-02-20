// Fonction pour supprimer les cookies
function deleteCookies() {
  // Définir la date d'expiration des cookies à une date passée
  document.cookie = "email=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  document.cookie = "nom=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  document.cookie = "prenom=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  document.cookie = "id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

  // Recharger la page pour voir les effets
  location.reload();
}
