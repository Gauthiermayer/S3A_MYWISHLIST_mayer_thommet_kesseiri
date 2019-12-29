<?php


namespace mywishlist\controleurs;


use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\models\Reservation;
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
        $vue->afficher("listes");
    }

    public static function getAllItems($id_liste){
        $items = Item::all()->where('liste_id','=',$id_liste)->toArray();
        $liste = Liste::all()->find($id_liste);
        $token = $liste['token'];
        $isCreator = false;
        if (isset($_COOKIE['created'])) {
            $created = unserialize($_COOKIE['created']);
            if (in_array($token, $created)) {
                $isCreator = true;
            }
        }
        $vue = new VueListes(['items' => $items, 'creator' => $isCreator, 'liste_id' => $id_liste, 'titreListe' => $liste->titre]);
        $vue->afficher("liste");
    }

    public static function getItem($id_item){
        $reserv = Reservation::all()->where('idItem','=',$id_item)->toArray();
        if(sizeof($reserv) != 0){
            foreach ($reserv as $key => $val){
                $reserv = $val;
            }
        }
        else{
            $reserv = NULL;
        }
        $item = Item::all()->find($id_item);
        $liste = Liste::all()->find($item['liste_id']);
        $vue = new VueListes(['item' => $item, 'token_list' => $liste['token'], 'reserve' => $reserv != NULL, 'reservation' => $reserv]);
        $vue->afficher("item");
    }
}