<?php

namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;

class Authentification {

    public static function createUser($userName, $password){
        // Une fois le formulaire envoyé
        if(isset($_POST["BT_Envoyer"])) {

            // Vérification de la validité des champs
            if (!preg_match("^[A-Za-z0-9_]{4,20}$", $_POST["TB_Nom_Utilisateur"])) {
                $message = "Votre nom d'utilisateur doit comporter entre 4 et 20 caractères<br />\n";
                $message .= "L'utilisation de l'underscore est autorisée";
            } elseif (!preg_match("^[A-Za-z0-9]{4,}$", $_POST["TB_Mot_de_Passe"])) {
                $message = "Votre mot de passe doit comporter au moins 4 caractères";
            } elseif ($_POST["TB_Mot_de_Passe"] != $_POST["TB_Confirmation_Mot_de_Passe"]) {
                $message = "Votre mot de passe n'a pas été correctement confirmé";
            }
        }

        //Hachage du mot de passe
        $pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    }

    public static function authenticate($userName, $password){
        //  Récupération de l'utilisateur et de son pass hashé
        $req = ->prepare('SELECT id, pass FROM membres WHERE pseudo = :pseudo');
        $req->execute(array(
            'user' => $userName));
        $resultat = $req->fetch();

        // Comparaison du pass envoyé via le formulaire avec la base
        $isPasswordCorrect = password_verify($_POST[$password], $resultat['pass']);

        if (!$resultat) {
            echo 'Mauvais identifiant ou mot de passe !';
        } else {
            if ($isPasswordCorrect) {
                session_start();
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['user'] = $userName;
                echo 'Vous êtes connecté !';
            } else {
                echo 'Mauvais identifiant ou mot de passe !';
            }
        }
    }

    public static function loadProfile($uid){

    }

    public static function chackAccessRights($required){

    }
}