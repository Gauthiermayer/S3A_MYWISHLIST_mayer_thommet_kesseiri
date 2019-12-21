<?php

require_once 'vendor/autoload.php';

use mywishlist\controleurs\ControleurEditionListe;
use mywishlist\controleurs\ControleurHome;
use mywishlist\controleurs\ControleurListes;
use mywishlist\conf\Database;
use mywishlist\controleurs\ControleurLogin;
use mywishlist\controleurs\ControleurReservation;

Database::connect();
$app = new \Slim\Slim();

$app->get('/', function() {
    ControleurHome::default();
})->name('default');

$app->get('/login', function() {
    ControleurLogin::pageConnexion();
})->name('login');

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





$app->run();



