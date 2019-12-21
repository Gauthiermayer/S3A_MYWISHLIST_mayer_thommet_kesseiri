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
            $nom = filter_var($_POST['liste_name'],FILTER_SANITIZE_SPECIAL_CHARS);
        }
        else{
            $nom = 'Liste sans nom';
        }

        if (isset($_POST['liste_desc'])){
            $desc = filter_var($_POST['liste_desc'],FILTER_SANITIZE_SPECIAL_CHARS);
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

        if (isset($_POST['date'])){
            $date = $_POST['date'];
        }
        else{
            $date = '31/12/2099';
        }

        $date = \DateTime::createFromFormat('d/m/Y', $date);

        $liste = new Liste();
        $liste->titre = $nom;
        $liste->description = $desc;
        $liste->expiration = $date;
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