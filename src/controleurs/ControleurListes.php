<?php


namespace mywishlist\controleurs;


use mywishlist\models\Liste;
use mywishlist\vues\VueListes;

class ControleurListes
{
    public static function getListes()
    {
        $liste = Liste::all()->toArray();
        $vue = new VueListes($liste);
        $vue->afficher();
    }
}