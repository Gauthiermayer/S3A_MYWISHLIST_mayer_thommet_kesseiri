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
        VueHeaderFooter::afficherHeader('login', 'compte.css');

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
                    <input type="text" name="login" id ="login" class="form-control" placeholder="Nom d'utilisateur" required autofocus>
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                    
                    <!-- Indique à l'utilisateur la force du mot de passe -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>               
                    <p class="w-100">Force du mot de passe : <meter class="w-25"  max="4" id="password-strength-meter"></meter></p>                    
                    <script src="http://localhost/Web/S3A_MYWISHLIST_mayer_thommet_kesseiri/js/passwordMeter.js"></script>
                    <!-- Indique à l'utilisateur la force du mot de passe -->
                
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
     * Affiche le résultat de la connexion (message d'erreur)
     * @param string $status Contient un message résultant de la connexion. (password_incorrect/login_incorrect)
     */
    public function afficherErreurConnexion(string $status) {
        switch ($status) {
            case 'login_incorrect' :
                $html_code = '<div class="alert alert-danger" role="alert">Login incorrect</div>';
                break;
            case 'password_incorrect':
                $html_code = '<div class="alert alert-danger" role="alert">Mot de passe incorrect</div>';
                break;
        }

        self::afficherPageConnexion($html_code);
    }

    /**
     * Affiche la page de gestion de compte de l'utilisateur connecté.
     * Si aucun utilisateur est connecté affiche une erreur.
     */
    public function afficherPageGestionCompte($vientDetreCree = false) {
        if (!isset($_SESSION['user_connected'])) {
            VueHeaderFooter::afficherHeader('login', '404');
            echo
            <<<END
            <section class="error-container">
                <span>4</span>
                <span><span class="screen-reader-text">0</span></span>
                <span>4</span>
            </section>
END;
        }

        else {
            $urlConnexion = $this->app->urlFor('login');
            VueHeaderFooter::afficherHeader('login');

            $html_page = '';
            if ($vientDetreCree)
                $html_page = '<div class="alert alert-success" role="alert">Vous êtes maintenant connecté !</div>';

            $html_page = $html_page .
            <<<END
            <div class="text-center container mt-5" style="max-width: 330px">
                <form method="get" action="$urlConnexion">
                    <button class="btn btn-primary btn-block"   >Se déconnecter</button>
                </form>               
            </div>
END;
            echo $html_page;
        }

        VueHeaderFooter::afficherFooter();
    }
}