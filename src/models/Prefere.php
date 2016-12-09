<?php

namespace Semeformation\Mvc\Cinema_crud\models;

use Semeformation\Mvc\Cinema_crud\includes\DBFunctions;

/**
 * Description of Prefere
 *
 * @author admin
 */
class Prefere extends DBFunctions {

    /**
     * Méthode qui retourne les films préférés d'un utilisateur donné
     * @param string $utilisateur Adresse email de l'utilisateur
     * @return array[][] Les films préférés (sous forme de tableau associatif) de l'utilisateur
     */
    public function getFavoriteMoviesFromUser($id) {
        // on construit la requête qui va récupérer les films de l'utilisateur
        $requete = "SELECT f.filmID, f.titre, p.commentaire from film f" .
                " INNER JOIN prefere p ON f.filmID = p.filmID" .
                " AND p.userID = " . $id;

        // on extrait le résultat de la BDD sous forme de tableau associatif
        $resultat = $this->extraireNxN($requete, null, false);

        // on retourne le résultat
        return $resultat;
    }

    /**
     * Méthode qui renvoie les informations sur un film favori donné pour un utilisateur donné
     * @param int $userID Identifiant de l'utilisateur
     * @param int $filmID Identifiant du film
     * @return array[]
     */
    public function getFavoriteMovieInformations($userID, $filmID) {
        // requête qui récupère les informations d'une préférence de film pour un utilisateur donné
        $requete = "SELECT f.titre, p.userID, p.filmID, p.commentaire"
                . " FROM prefere p INNER JOIN film f ON p.filmID = f.filmID"
                . " WHERE p.userID = "
                . $userID
                . " AND p.filmID = "
                . $filmID;

        // on extrait les résultats de la BDD
        $resultat = $this->extraire1xN($requete, null, false);
        // on retourne le résultat
        return $resultat;
    }
    
        /**
     * Méthode qui met à jour une préférence de film pour un utilisateur
     * @param int userID Identifiant de l'utilisateur
     * @param int filmID Identifiant du film
     * @param string comment Commentaire de l'utilisateur à propos de ce film
     */
    public function updateFavoriteMovie($userID, $filmID, $comment) {
        // on construit la requête d'insertion
        $requete = "UPDATE prefere SET commentaire = "
                . "'" . $comment . "'"
                . " WHERE filmID = "
                . $filmID
                . " AND userID = "
                . $userID;
        // exécution de la requête
        $this->executeQuery($requete);
    }


    /**
     * Méthode qui ajoute une préférence de film à un utilisateur
     * @param int userID Identifiant de l'utilisateur
     * @param int filmID Identifiant du film
     * @param string comment Commentaire de l'utilisateur à propos de ce film
     */
    public function insertNewFavoriteMovie($userID, $filmID, $comment = "") {
        // on construit la requête d'insertion
        $requete = "INSERT INTO prefere (filmID, userID, commentaire) VALUES ("
                . ":filmID"
                . ", :userID"
                . ", :comment)";

        // exécution de la requête
        $this->executeQuery($requete,
                ['filmID' => $filmID,
            'userID' => $userID,
            'comment' => $comment]);

        if ($this->logger) {
            $this->logger->info('Movie ' . $filmID . ' successfully added to ' . $userID . '\'s preferences.');
        }
    }

    /**
     * 
     * @param type $userID
     * @param type $filmID
     */
    public function deleteFavoriteMovie($userID, $filmID) {
        $this->executeQuery("DELETE FROM prefere WHERE userID = "
                . $userID
                . " AND filmID = "
                . $filmID);

        if ($this->logger) {
            $this->logger->info('Movie ' . $filmID . ' successfully deleted from ' . $userID . '\'s preferences.');
        }
    }

    
}
