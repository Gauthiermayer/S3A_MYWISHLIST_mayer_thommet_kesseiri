<?php


namespace mywishlist\vues;


class VueCompte {

    private $app;

    /**
     * VueCompte constructor.
     */
    public function __construct() {
        $this->app = \Slim\Slim::getInstance() ;
    }

    public function afficherPageConnexion($connexion_return = null) {
        VueHeaderFooter::afficherHeader('login');

        $rootUri = $this->app->request->getRootUri();
        $urlConnexion = $this->app->urlFor('connexion');
        $urlInscription = $this->app->urlFor('form_inscription');

        $html_page =
        <<<END
            <div class="text-center container mt-5" style="max-width: 330px">
                <!-- Formulaire login -->
                <form method="post" action="$urlConnexion">
                    <img class="mb-4" src="$rootUri/img/login.png" alt="" width="120" height="120">
                    <h1 class="h3 mb-3 font-weight-normal">Connexion</h1>
                    <label for="login" class="sr-only">Adresse mail</label>
                    <input type="text" name="login" class="form-control" placeholder="Nom d'utilisateur" required autofocus>
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                    <button class="btn btn-success btn-primary btn-block" type="submit">Se connecter</button>                                                                      
                </form>
END;
        //------------------- Ajoute le message de retour si l'utilisateur à tenter de se connecter -------------------\\
        if (isset($connexion_return))
            $html_page = $html_page . $connexion_return;
        //------------------- Ajoute le message de retour si l'utilisateur à tenter de se connecter -------------------\\
        $html_page = $html_page .
        <<<END
                <hr>                            
                <!-- Bouton créer compte -->                             
                <form method="get" action="$urlInscription">
                    <button class="btn btn-primary btn-block" type="submit" id="btn-signup">Créer un compte </button>
                </form>                                       
            </div>
END;

        echo $html_page;
        VueHeaderFooter::afficherFooter();
    }

    public function afficherPageInscription() {
        VueHeaderFooter::afficherHeader('login');

        $rootUri = $this->app->request->getRootUri();
        $urlInscription = $this->app->urlFor('inscription');
        $urlLogin = $this->app->urlFor('login');

        echo
        <<<END
            <div class="text-center container mt-5" style="max-width: 330px">
                <!-- Formulaire inscription -->
                <form method="post" action="$urlInscription">
                    <img class="mb-4" src="$rootUri/img/login.png" alt="" width="120" height="120">
                    <h1 class="h3 mb-3 font-weight-normal">Inscription</h1>
                    <label for="login" class="sr-only">Adresse mail</label>
                    <input type="text" name="login" class="form-control" placeholder="Login" required autofocus>
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                    <button class="btn btn-success btn-primary btn-block" type="submit">S'inscrire</button>                                                                      
                </form>
                
                <hr>                            
                <!-- Bouton retour login -->                             
                <form method="get" action="$urlLogin">
                    <button class="btn btn-primary btn-block" type="submit" id="btn-signup">Retour vers la connexion</button>
                </form>                                       
            </div>
END;

        VueHeaderFooter::afficherFooter();
    }

    /**
     * Affiche le résultat de la connexion (succès / ou message d'erreur)
     * @param string $status Contient un message résultant de la connexion. (succes/password_incorrect/login_incorrect)
     */
    public function afficherTentativeConnexion(string $status) {
        switch ($status) {
            case 'succes':
                $html_code = '<div class="alert alert-success" role="alert">Vous êtes maintenant connecté !</div>';
                break;
            case 'login_incorrect' :
                $html_code = '<div class="alert alert-danger" role="alert">Login incorrect</div>';
                break;
            case 'password_incorrect':
                $html_code = '<div class="alert alert-danger" role="alert">Mot de passe incorrect</div>';
                break;
        }

        self::afficherPageConnexion($html_code);
    }
}