<?php


namespace mywishlist\controleurs;


use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vues\VueListes;

class ControleurListes
{
    public static function getListes()
    {
        $params = ['listes' => []];
        $listes = Liste::all()->toArray();
        foreach ($listes as $key => $liste){
            $nb_items = Item::all()->where('liste_id', '=', $liste['no'])->count();
            array_push($params['listes'], ['liste' => $liste, 'nb' => $nb_items]);
        }
        $vue = new VueListes($params);
        $vue->afficher(1);
    }

    public static function getAllItems($id_liste){
        $items = Item::all()->where('liste_id','=',$id_liste)->toArray();
        $vue = new VueListes(['items' => $items]);
        $vue->afficher(2);
    }

    public static function getItem($id_item){
        $item = Item::all()->find($id_item);
        $liste = Liste::all()->find($item['liste_id']);
        $vue = new VueListes(['item' => $item, 'token_list' => $liste['token']]);
        $vue->afficher(3);
    }
}