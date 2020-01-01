<?php

namespace mywishlist\utils;

require_once 'vendor/autoload.php';
use mywishlist\controleurs\ControleurCompte;
use mywishlist\models\Compte;
use ZxcvbnPhp\Zxcvbn as PasswordChecker;


class Authentification {

    /**
     * Créer un compte et l'enregistre dans la base de donnée.
     * @param $username string Username du compte.
     * @param $password string Mot de passe du compte.
     * @param $pseudo string Pseudo du compte.
     * @return string "Code de retour" : soit "succes" soit un message d'erreur.
     */
    public static function creerCompte($username, $password, $pseudo):string {
        if (self::compteExiste($username, $pseudo))
            return 'Un compte avec le même login/pseudo existe déjà';

        //---------------- Vérifie la force du mot de passe ----------------\\
        $passChecker = new PasswordChecker();
        $force = $passChecker->passwordStrength($password, array($username));

        if ($force['score'] < 1)
            return 'Veuillez entrer un mot de passe plus sécurisé';

        //---------------- Vérifie la force du mot de passe ----------------\\

        $hash = password_hash($password, PASSWORD_DEFAULT, ['cost'=> 12]);

        $compte = new Compte();
        $compte->username = $username;
        $compte->password = $hash;
        $compte->role = 'user';
        $compte->pseudo = $pseudo;
        $compte->save();

        return 'succes';
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
                                            'role' => "$user->role",
                                            'pseudo' => "$user->pseudo");
    }

    public static function checkAccessRights($required) {
        //TODO pour check les droits en fonction du rôle.
    }

    /**
     * Vérifie si le compte existe déjà dans la BDD.
     * @param $username string Nom de compte.
     * @param $pseudo string Pseudo du compte.
     * @return bool true si le compte existe déjà.
     */
    private static function compteExiste($username, $pseudo):bool {
        //Check sur l'username
        $alreadyExist = Compte::where('username', '=', $username)->first() != null;
        //Si l'username n'est pas déjà utilisé vérifie le pseudo
        if (!$alreadyExist)
            $alreadyExist = Compte::where('pseudo', '=', $pseudo)->first() != null;

        return $alreadyExist;
    }
}