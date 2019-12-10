<?php


namespace mywishlist\controleurs;


use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vues\VueListes;

class ControleurListes
{
    public static function getListes()
    {
        $liste = Liste::all()->toArray();
        $vue = new VueListes($liste);
        $vue->afficher(1);
    }

    public static function getAllItems($id_liste){
        $items = Item::all()->where('liste_id','=',$id_liste)->toArray();
        $vue = new VueListes($items);
        $vue->afficher(2);
    }

    public static function getItem($id_item){
        $item = Item::all()->where('id','=',$id_item)->toArray();
        $vue = new VueListes($item);
        $vue->afficher(3);
    }
}