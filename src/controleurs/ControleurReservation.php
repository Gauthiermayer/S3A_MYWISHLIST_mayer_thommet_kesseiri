<?php


namespace mywishlist\controleurs;


use mywishlist\models\Liste;
use mywishlist\models\Reservation;

class ControleurReservation
{

    public static function reserverItem($id_item, $id_liste){
        $liste = Liste::all()->find($id_liste);
        $token = $liste['token'];

        //vérifie si la personne qui reserve n'est pas le créateur de la liste
        if (isset($_COOKIE['created'])) {
            $created = unserialize($_COOKIE['created']);
            if (in_array($token, $created)) { //créateur de la liste
                return null;
            }
        }
        //pas créateur
        //vérifie que pas dejà reservé
        $reserv = Reservation::all()->where('idItem','=',$id_item)->toArray();
        if(sizeof($reserv) == 0){ //pas deja reservé
            $token_reserv = "";
            try {
                $token_reserv = bin2hex(random_bytes(5));
            } catch (\Exception $e) {}

            $cookie = [];
            if (isset($_COOKIE['reserves'])){
                $cookie = unserialize($_COOKIE['reserves']);
                var_dump($cookie);
                array_push($cookie,$token_reserv);
                $cookie = serialize($cookie);
            }
            else{
                echo 'test';
                $cookie = serialize([$token_reserv]);
            }

            setcookie('reserves',$cookie,time()+60*60*24*365);

            $reserv = new Reservation();
            $reserv->idItem = $id_item;
            $reserv->idListe = $id_liste;
            $reserv->tokenReserv = $token_reserv;
            if (isset($_POST['nom'])){
                $reserv->message = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
            }
            else{
                $reserv->message = 'Anonymous';
            }
            $reserv->save([$id_item, $id_liste]);
        }
        else{ //déja reservé
            //TODO AFFICHER ERREUR DEJA RESERVE
        }
    }

    public static function annulerReservation($id_item,$id_liste){
        $reservation = Reservation::all()->where('idItem','=',$id_item)->where('idListe','=',$id_liste)->first();
        $token = $reservation['tokenReserv'];
        if (isset($_COOKIE['reserves'])) {
            $reserves = unserialize($_COOKIE['reserves']);
            if (in_array($token, $reserves)) {
                $reservation->delete();
            }
        }
    }
}