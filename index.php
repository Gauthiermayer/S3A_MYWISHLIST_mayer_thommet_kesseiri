<?php

require_once 'vendor/autoload.php';

use mywishlist\controleurs\ControleurEditionListe;
use mywishlist\controleurs\ControleurHome;
use mywishlist\controleurs\ControleurListes;
use mywishlist\conf\Database;
use mywishlist\controleurs\ControleurCompte;
use mywishlist\controleurs\ControleurReservation;

session_start();
Database::connect();
$app = new \Slim\Slim();

//------------------------ HOME ------------------------\\
$app->get('/', function() {
    ControleurHome::default();
})->name('default');
//------------------------ HOME ------------------------\\


//------------------------ LISTE ------------------------\\
$app->get('/listes/', function() {
    //echo "Affiche toutes les listes";
    ControleurListes::getListes();
})->name('listes');

$app->post('/liste/create', function() {
    ControleurEditionListe::creerListe();
    ControleurEditionListe::afficherCreerListe();
});

$app->get('/liste/create', function() {
    //echo 'création d une liste';
    ControleurEditionListe::afficherCreerListe();
})->name('creation_liste');

$app->get('/liste/:id_liste', function($id_liste) {
    //echo "Affiche tous les items de la liste ".$id_liste;
    ControleurListes::getAllItems($id_liste);
})->name('route_liste');

$app->get('/liste/:id_liste/item/:id_item', function($id_liste, $id_item) {
    //echo "Affiche l'item ".$id_item." de la liste ".$id_liste;
    ControleurListes::getItem($id_item);
})->name('route_item');

$app->post('/liste/:id_liste/item/:id_item/reserver', function($id_liste, $id_item) {
    ControleurReservation::reserverItem($id_item,$id_liste);
    ControleurListes::getItem($id_item);
})->name('reserver_item');

$app->post('/liste/:id_liste/item/:id_item/annulerReservation', function($id_liste, $id_item) {
    ControleurReservation::annulerReservation($id_item,$id_liste);
    ControleurListes::getItem($id_item);
})->name('annuler_reservation');

$app->post('/liste/:id_liste/ajouterItem', function($id_liste) {
    ControleurEditionListe::ajouterItem($id_liste);
    ControleurListes::getAllItems($id_liste);
})->name('ajouter_item');

$app->get('/liste/:id_liste/ajouterItem', function($id_liste) {
    ControleurEditionListe::afficherCreerItem();
})->name('form_ajout_item');
//------------------------ LISTE ------------------------\\


//------------------------ COMPTE ------------------------\\
$app->get('/login', function() {
    ControleurCompte::deconnexion();
    ControleurCompte::pageConnexion();
})->name('login');

$app->get('/inscription', function () {
    ControleurCompte::pageInscription();
})->name('form_inscription');

$app->post('/inscription/succes', function () { //TODO changer la route car /inscription/succes bof
    $app = \Slim\Slim::getInstance() ;
    $pseudo = $app->request->post('pseudo');
    $login = $app->request->post('login');
    $pass = $app->request->post('password');
    ControleurCompte::inscription($login, $pass, $pseudo);
})->name('inscription');

$app->post('/connexion', function () {
    $app = \Slim\Slim::getInstance() ;
    $login = $app->request->post('login');
    $pass = $app->request->post('password');
    ControleurCompte::connexion($login, $pass);
})->name('connexion');

$app->get('/compte', function () {
   ControleurCompte::pageGestionCompte();
});

$app->post('/compte/modification', function () {
    $app = \Slim\Slim::getInstance() ;
    $pseudo = $app->request->post('pseudo');
    $pass = $app->request->post('password');
    ControleurCompte::modifierInformations($pseudo, $pass);
})->name('modificationCompte');
//------------------------ COMPTE ------------------------\\

$app->run();