<?php
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . './includes/Manager.php';

session_start();
// si l'utilisateur n'est pas connecté
if (!array_key_exists("user", $_SESSION)) {
    // renvoi à la page d'accueil
    header('Location: index.php');
    exit;
}
// l'utilisateur est loggué
else {
    $utilisateur = $managers["utilisateursMgr"]->getCompleteUsernameByEmailAddress($_SESSION['user']);
}
require 'views/viewFavoriteMoviesList.php';
?>

