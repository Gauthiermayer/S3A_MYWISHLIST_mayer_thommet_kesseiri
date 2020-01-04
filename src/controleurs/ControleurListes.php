<?php


namespace mywishlist\controleurs;


use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\models\Reservation;
use mywishlist\vues\VueListes;

class ControleurListes {

    /**
     * Affiche toutes les listes valides et non privées (sauf si le créateur de la liste privée est connecté)
     * @param null $listes Listes à afficher, null si on veut afficher toutes les listes.
     */
    public static function getListes($listes = null) {
        //Récupère l'utilisateur connecté pour afficher ses listes privées
        $userConnected = 'null';
        if (isset($_SESSION['user_connected']))
            $userConnected = $_SESSION['user_connected']['pseudo'];

        $params = ['listes' => []];

        if ($listes == null)
            $listes = Liste::all()->toArray();

        foreach ($listes as $key => $liste){
            //Pour afficher : soit la liste n'est pas privée, soit son créateur est connecté
            if( ($liste['private'] != 1 || ($userConnected == $liste['createur_pseudo']))
                && date('Y-m-d') <= $liste['expiration']) { //N'affiche que les listes encore valides

                $nb_items = Item::all()->where('liste_id', '=', $liste['no'])->count();
                array_push($params['listes'], ['liste' => $liste, 'nb' => $nb_items]);
            }
        }

        self::trierListes($params['listes']);
        $vue = new VueListes($params);
        $vue->afficher("listes");
    }

    /**
     * Trie le tableau de listes pour que les listes privées se retrouvent en premières dans le tableau.
     * Ensuite trie par ordre croissant de dates de validité.
     * @param $array array Tableau de listes.
     */
    private static function trierListes(& $array) {
        usort($array, function ($listeA, $listeB) {
            $a = $listeA['liste']['private']; //Soit 0 (non privée) soit 1 (privée)
            $b = $listeB['liste']['private'];

            if ($b - $a != 0) //Car on priorise l'attribut privé pour le tri
                return $b - $a;
            else {
                $a = $listeA['liste']['expiration'];
                $b = $listeB['liste']['expiration'];

                return $a > $b ? 1 : -1;
            }
        });
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

    /**
     * Affiche les listes correspondantes à la recherche dans la search-bar.
     */
    public static function getListesRecherchees() {
        switch ($_POST['typeRecherche']) {
            case 'auteur':
                $auteur = $_POST['auteur'];
                self::getListes(Liste::where('createur_pseudo', '=', "$auteur")->get());
                break;

            case 'date':
                $dateDebut = $_POST['dateDebut'];
                $dateFin = $_POST['dateFin'];
                self::getListes(Liste::whereBetween('expiration', [$dateDebut, $dateFin])->get());
                break;
        }
    }
}