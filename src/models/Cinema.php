<?php

namespace Semeformation\Mvc\Cinema_crud\models;

use Semeformation\Mvc\Cinema_crud\includes\DBFunctions;

/**
 * Description of Cinema
 *
 * @author admin
 */
class Cinema extends DBFunctions {
    

    /**
     * 
     * @param type $denomination
     * @param type $adresse
     */
    public function insertNewCinema($denomination, $adresse) {
        // construction
        $requete = "INSERT INTO cinema (denomination, adresse) VALUES ("
                . ":denomination"
                . ", :adresse)";
        // exécution
        $this->executeQuery($requete,
                ['denomination' => $denomination,
            'adresse' => $adresse]);
        // log
        if ($this->logger) {
            $this->logger->info('Cinema ' . $denomination . ' successfully added.');
        }
    }

    /**
     * 
     * @param type $cinemaID
     * @param type $denomination
     * @param type $adresse
     */
    public function updateCinema($cinemaID, $denomination, $adresse) {
        // on construit la requête d'insertion
        $requete = "UPDATE cinema SET "
                . "denomination = "
                . "'" . $denomination . "'"
                . ", adresse = "
                . "'" . $adresse . "'"
                . " WHERE cinemaID = "
                . $cinemaID;
        // exécution de la requête
        $this->executeQuery($requete);
    }

    /**
     * 
     * @param type $cinemaID
     */
    public function deleteCinema($cinemaID) {
        $this->executeQuery("DELETE FROM cinema WHERE cinemaID = "
                . $cinemaID);

        if ($this->logger) {
            $this->logger->info('Cinema ' . $cinemaID . ' successfully deleted.');
        }
    }

    /**
     * 
     * @return type
     */
    public function getCinemasList() {
        $requete = "SELECT * FROM cinema";
        // on retourne le résultat
        return $this->extraireNxN($requete);
    }
    
    /**
     * 
     * @param type $cinemaID
     * @return type
     */
    public function getCinemaInformationsByID($cinemaID) {
        $requete = "SELECT * FROM cinema WHERE cinemaID = "
                . $cinemaID;
        $resultat = $this->extraire1xN($requete);
        // on retourne le résultat extrait
        return $resultat;
    }    
    
}
