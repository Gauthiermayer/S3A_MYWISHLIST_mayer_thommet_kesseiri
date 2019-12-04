<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>TD 10</title>
    </head>
</html>

<?php

require_once 'vendor/autoload.php';

use mywishlist\conf\Database;
use mywishlist\models\Item;
use mywishlist\models\Liste;

$app = new \Slim\Slim();

$app->get('/', function() {
    echo "Home";
});

$app->get('/listes/', function() {
    echo "Affiche toutes les listes";
});

$app->get('/liste/:id_liste', function($id_liste) {
    echo "Affiche tous les items de la liste ".$id_liste;
});

$app->get('/liste/:id_liste/item/:id_item', function($id_liste, $id_item) {
    echo "Affiche l'item ".$id_item." de la liste ".$id_liste;
});
$app->run();