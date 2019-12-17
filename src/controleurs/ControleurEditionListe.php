<?php


namespace mywishlist\controleurs;


use mywishlist\models\Liste;
use mywishlist\vues\VueEditionCreationListe;

class ControleurEditionListe
{

    public static function afficherCreerListe(){
        $vue = new VueEditionCreationListe();
        $vue->afficher(1);
    }

    public static function creerListe(){
        //var_dump($_POST);
        if (isset($_POST['liste_name'])){
            $nom = $_POST['liste_name'];
        }
        else{
            $nom = 'Liste sans nom';
        }

        if (isset($_POST['liste_desc'])){
            $desc = $_POST['liste_desc'];
        }
        else{
            $desc = '';
        }

        if (isset($_POST['private'])){
            $private = 1;
        }
        else{
            $private = 0;
        }

        $liste = new Liste();
        $liste->titre = $nom;
        $liste->description = $desc;
        //$liste->expiration = ? ;
        $token = "";
        try {
            $token = bin2hex(random_bytes(5));
        } catch (\Exception $e) {

        }
        $liste->token = $token;
        $liste->private = $private;


        $cookie = [];
        if (isset($_COOKIE['created'])){
            $cookie = unserialize($_COOKIE['created']);
            array_push($cookie,$token);
            $cookie = serialize($cookie);
        }
        else{
            $cookie = serialize([$token]);
        }

        setcookie('created',$cookie,time()+60*60*24*365);

        $liste->save();

    }

}