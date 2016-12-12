<?php

/*

  La fonction cinemasList($managers) contient tout le code précédemment contenu dans
  cinemasList.php excepté les require du début. Ainsi, le fichier cinemasList.php peut être
  supprimé
 */

/**
 * contient tout le code précédemment contenu dans index.php excepté les require du début
 * @param type $managers
 */
function home($managers) {

    session_start();
// personne d'authentifié à ce niveau
    $loginSuccess = false;

// variables de contrôle du formulaire
    $areCredentialsOK = true;

// si l'utilisateur est déjà authentifié
    if (array_key_exists("user", $_SESSION)) {
        $loginSuccess = true;
// Sinon (pas d'utilisateur authentifié pour l'instant)
    } else {
        // si la méthode POST a été employée
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST") {
            // on "sainifie" les entrées
            $sanitizedEntries = filter_input_array(INPUT_POST, ['email' => FILTER_SANITIZE_EMAIL,
                'password' => FILTER_DEFAULT]);
            try {
                // On vérifie l'existence de l'utilisateur
                $utilisateursMgr->verifyUserCredentials($sanitizedEntries['email'], $sanitizedEntries['password']);

                // on enregistre l'utilisateur
                $_SESSION['user'] = $sanitizedEntries['email'];
                $_SESSION['userID'] = $utilisateursMgr->getUserIDByEmailAddress($_SESSION['user']);
                // on redirige vers la page d'édition des films préférés
                header("Location: editFavoriteMoviesList.php");
                exit;
            } catch (Exception $ex) {
                $areCredentialsOK = false;
                $logger->error($ex->getMessage());
            }
        }
    }

    require 'views/viewHome.php';
}

function cinemasList($managers) {

    $isUserAdmin = false;

    session_start();
// si l'utilisateur est pas connecté et qu'il est amdinistrateur
    if (array_key_exists("user", $_SESSION) and $_SESSION['user'] == 'admin@adm.adm') {
        $isUserAdmin = true;
    }

    require 'views/viewCinemasList.php';
}
