<?php


namespace mywishlist\controleurs;


use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vues\VueEditionCreationListe;

class ControleurEditionListe
{

    public static function afficherCreerListe(){
        $vue = new VueEditionCreationListe();
        $vue->afficher(1);
    }

    public static function afficherEditerListe(){
        $vue = new VueEditionCreationListe();
        $vue->afficher(2);
    }

    public static function afficherCreerItem(){
        $vue = new VueEditionCreationListe();
        $vue->afficher(3);
    }

    public static function creerListe(){
        //var_dump($_POST);
        if (isset($_POST['liste_name'])){
            $nom = filter_var($_POST['liste_name'],FILTER_SANITIZE_SPECIAL_CHARS);
        }
        else{
            $nom = 'Liste sans nom';
        }

        //vérifie si une liste porte déjà ce nom
        $listeExistante = Liste::where('titre', '=', $nom)->first();
        if (isset($listeExistante)) {
            //TODO afficher erreur
            return;
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

        //redirection vers la page d'affichage de la liste
        header("Location: ./$liste->no");
        exit(0);
    }

    public static function ajouterItem($id_liste){
        $liste = Liste::all()->find($id_liste);
        $token = $liste['token'];
        if (isset($_COOKIE['created'])) {
            $created = unserialize($_COOKIE['created']);
            if (in_array($token, $created)) {
                if (isset($_POST['nom']) && $_POST['nom'] != '') {
                    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
                } else {
                    $nom = 'Cadeau surprise';
                }

                if (isset($_POST['desc']) && $_POST['desc'] != '') {
                    $desc = filter_var($_POST['desc'], FILTER_SANITIZE_SPECIAL_CHARS);
                } else {
                    $desc = '';
                }

                if (isset($_POST['prix']) && $_POST['prix'] != ''){
                    $prix = filter_var($_POST['prix'], FILTER_SANITIZE_SPECIAL_CHARS);
                }
                else {
                    $prix = 0;
                }

                if (isset($_POST['image'])) {
                    $image = filter_var($_POST['image'], FILTER_SANITIZE_SPECIAL_CHARS);
                } else {
                    $image = NULL;
                }

                if (isset($_POST['url_image'])) {
                    $url_image = filter_var($_POST['url_image'], FILTER_SANITIZE_SPECIAL_CHARS);
                } else {
                    $url_image = NULL;
                }

                $item = new Item();
                $item->liste_id = $id_liste;
                $item->nom = $nom;
                $item->descr = $desc;
                $item->img = $image;
                $item->url = $url_image;
                $item->tarif = $prix;

                $item->save();
            }
        }
    }

}