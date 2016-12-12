<?php

namespace Semeformation\Mvc\Cinema_crud\includes;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Semeformation\Mvc\Cinema_crud\models\Utilisateur;
use Semeformation\Mvc\Cinema_crud\models\Film;
use Semeformation\Mvc\Cinema_crud\models\Prefere;
use Semeformation\Mvc\Cinema_crud\models\Cinema;
use Semeformation\Mvc\Cinema_crud\models\Seance;

// Création du logger
$logger = new Logger("Functions");
$logger->pushHandler(new StreamHandler(dirname(__DIR__) . './logs/functions.log'));
$fctManager = new DBFunctions($logger);

/*
$utilisateursMgr = new Utilisateur($logger);
$filmMgr = new Film($logger);
$preferesMgr = new Prefere($logger);
$cinemaMgr = new Cinema($logger);
$seanceMgr = new Seance($logger);
 * 
 */


$managers = ['utilisateursMgr'=> new Utilisateur($logger),
 'cinemasMgr'=> new Cinema($logger),
 'seancesMgr'=> new Seance($logger),
 'preferesMgr'=> new Prefere($logger),
 'filmsMgr'=> new Film($logger)];

