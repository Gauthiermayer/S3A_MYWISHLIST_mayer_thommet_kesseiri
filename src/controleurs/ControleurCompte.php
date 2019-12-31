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

        if ($status != 'succes')
            $vue->afficherErreurConnexion($status);
        else
            $vue->afficherPageGestionCompte(true);
    }

    public static function inscription($login, $pass, $pseudo) {
        Authentification::creerCompte($login, $pass, $pseudo);
    }

    public static function pageInscription() {
        $vue = new VueCompte();
        $vue->afficherPageInscription();
    }

    public static function pageGestionCompte() {
        $vue = new VueCompte();
        $vue->afficherPageGestionCompte();
    }

    public static function deconnexion() {
        if (isset($_SESSION['user_connected'])) unset($_SESSION['user_connected']);
    }
}