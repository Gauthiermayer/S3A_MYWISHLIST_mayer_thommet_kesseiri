<?php


namespace mywishlist\controleurs;


use mywishlist\utils\Authentification;
use mywishlist\vues\VueCompte;

class ControleurCompte {

    public static function pageConnexion() {
        $vue = new VueCompte();
        $vue->afficherPageConnexion();
    }

    /**
     * Tente de se connecter.
     * Affiche une vue affichant le succès de connexion / ou le type de l'erreur.
     * @param $login
     * @param $pass
     */
    public static function connexion($login, $pass) {
        $status = Authentification::connexion($login, $pass);
        $vue = new VueCompte();
        $vue->afficherTentativeConnexion($status);
    }

    public static function inscription($login, $pass) {
        Authentification::creerCompte($login, $pass);
    }

    public static function pageInscription() {
        $vue = new VueCompte();
        $vue->afficherPageInscription();
    }
}