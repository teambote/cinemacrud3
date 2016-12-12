<?php

require_once __DIR__ . '/vendor/autoload.php';

// init. des managers
require_once __DIR__ . './includes/Manager.php';

// initialisation de l'application
require_once __DIR__ . './init.php';

//require_once __DIR__ . './includes/managers.php';
// appel au contrôleur serviteur
require __DIR__ . './controllers/controleur.php';

// on "sainifie" les entrées
$sanitizedEntries = filter_input_array(INPUT_GET, ['action' => FILTER_SANITIZE_STRING]);
if ($sanitizedEntries && $sanitizedEntries['action'] !== '') {
    switch ($sanitizedEntries['action']) {

        case "cinemasList":
            // Activation de la route cinemasList
            cinemasList($managers);
            break;
        case "moviesList":
            // Activation de la route moviesList
            moviesList($managers);
            break;
        case "movieShowTimes":
            // Activation de la route movieShowTimes
            movieShowTimes($managers);
            break;
        case "editShowTime":
            // Activation de la route editShowTime
            editShowTime($managers);
            break;
        case "editMovie":
            // Activation de la route editMovie
            editMovie($managers);
            break;
        case "editFavoriteMoviesList":
            // Activation de la route editFavoriteMoviesList
            editFavoriteMoviesList($managers);
            break;
        case "editFavoriteMovie":
            // Activation de la route editFavoriteMovie
            editFavoriteMovie($managers);
            break;
        case "editCinema":
            // Activation de la route editCinema
            editCinema($managers);
            break;
        case "deleteShowtime":
            // Activation de la route deleteShowtime
            deleteShowtime($managers);
            break;
        case "deleteMovie":
            // Activation de la route deleteMovie
            deleteMovie($managers);
            break;
        case "deleteFavoriteMovie":
            // Activation de la route deleteFavoriteMovie
            deleteFavoriteMovie($managers);
            break;
        case "deleteCinema":
            // Activation de la route deleteCinema
            deleteCinema($managers);
            break;
        case "createNewUser":
            // Activation de la route CreateNewUser
            CreateNewUser($managers);
            break;
        case "cinemaShowTimes":
            // Activation de la route cinemaShowTimes
            cinemaShowTimes($managers);
            break;
        default:
            // Activation de la route par défaut (page d'accueil)
            home($managers);
    }

    /*
      // si l'action demandée est la liste des cinémas
      if ($sanitizedEntries['action'] == "cinemasList") {
      // Activation de la route cinemasList
      cinemasList($managers);
      } else {
      // Activation de la route par défaut (page d'accueil)
      home($managers);
      }
     * 
     */
} else {
    // Activation de la route par défaut (page d'accueil)
    home($managers);
}
