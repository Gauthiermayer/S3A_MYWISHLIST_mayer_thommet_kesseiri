<?php


namespace mywishlist\controleurs;


use mywishlist\vues\VueLogin;

class ControleurLogin {

    public static function pageConnexion() {
        $vue = new VueLogin();
        $vue->afficherPageConnexion();
    }
}