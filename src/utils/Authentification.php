<?php


namespace mywishlist\utils;


use mywishlist\controleurs\ControleurCompte;
use mywishlist\models\Compte;

class Authentification {

    public static function creerCompte($username, $password) {
        if (self::compteExiste($username)) {
            echo 'Compte déjà existant';
            return;
        }//TODO afficher une erreur

        //TODO check password policy (si assez fort)
        $hash = password_hash($password, PASSWORD_DEFAULT, ['cost'=> 12]);

        $compte = new Compte();
        $compte->username = $username;
        $compte->password = $hash;
        $compte->role = 'user'; //TODO
        $compte->save();

        ControleurCompte::pageConnexion(); //TODO AFFICHER MESSAGE SUCCES OU ERREUR
    }

    /**
     * Tente de se connecter = créer une variable de session 'user_connected' contenant les infos de l'user.
     * @param $username string Username
     * @param $password string Mot de passe
     * @return string Status de retour (succes/password_incorrect/login_incorrect)
     */
    public static function connexion($username, $password):string {
        $user = Compte::where('username', '=', $username)->first();

        //Si le login est bon
        if (isset($user)) {
            //Si le mot de passe est aussi bon
            if (password_verify($password, $user->password)) {
                self::loadProfile($user);
                return 'succes';
            }

            return 'password_incorrect';
        }
        return 'login_incorrect';
    }

    /**
     * Seulement appeler si on a DEJA VERIFIE les identifiants.
     * Créer une variable de session 'user_connected' contenant les informations de l'user.
     * @param $user Compte déjà vérifié.
     */
    private static function loadProfile($user) {
        unset($_SESSION['user_connected']);
        $_SESSION['user_connected'] = array('username' => "$user->username",
                                            'role' => "$user->role");
    }

    public static function checkAccessRights($required) {
        //TODO pour check les droits en fonction du rôle.
    }

    /**
     * Vérifie si le compte existe déjà dans la BDD.
     * @param $username string Nom de compte.
     * @return bool true si le compte existe déjà.
     */
    private static function compteExiste($username):bool {
        return Compte::where('username', '=', $username)->first() != null;
    }
}