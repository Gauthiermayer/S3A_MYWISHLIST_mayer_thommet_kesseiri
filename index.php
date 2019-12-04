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

Database::connect();

{
    echo '<h2>Lister les listes de souhaits</h2>';
    $listes = Liste::query()->get();
    foreach ($listes as $liste) {
        echo $liste->no . ' ' . $liste->titre . '<br>';
    }
}

{
    echo '<h2>Lister les items</h2>';
    $items = Item::query()->get();
    foreach ($items as $item) {
        $liste = $item->getListe()->first();
        if (isset($liste))
            $listeNom = $liste->titre;
        else
            $listeNom = 'Pas de liste';

        echo $item->id . ' ' . $item->nom . ' liste de souhait : ' . $listeNom . '<br>';
    }
}

{
    echo '<h2>Afficher un item en particulier, dont l\'id est passé en paramêtre dans l\'url (test.php?id=1)</h2>';
    if (isset($_GET['id'])) {
        $query = Item::query()->where('id', '=', $_GET['id']);
        $item = $query->first();
        echo $item->id . ' ' . $item->nom . '<br>';
    }
}

{
    $oldItem = Item::query()->where('nom', '=', 'Nouveau item')->first();
    if (!isset($oldItem)) {
        $item = new Item();
        $item->nom = 'Nouveau item';
        $item->liste_id = '2';
        $item->save();
        echo '<h2>L\'item a bien été ajouté à la BDD</h2>';
    }
    else
        echo '<h2>L\'item est déjà dans la BDD</h2>';
}

{
    echo '<h2>lister les items d\'une liste donnée dont l\'id est passé en paramètre (no)</h2>';
    if (isset($_GET['no'])) {
        $liste = Liste::query()->where('no', '=', $_GET['no'])->first();
        $items = $liste->getItems()->get();
        foreach ($items as $item) {
            echo $item->id . ' ' . $item->nom . '<br>';
        }
    }
}