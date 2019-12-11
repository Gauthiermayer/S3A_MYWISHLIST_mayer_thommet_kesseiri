<?php


namespace mywishlist\vues;


class VueLogin {

    private $app;

    /**
     * VueLogin constructor.
     */
    public function __construct() {
        $this->app = \Slim\Slim::getInstance() ;
    }

    public function afficherPageConnexion() {
        VueHeaderFooter::afficherHeader('login');

        $rootUri = $this->app->request->getRootUri() ;
        echo
        <<<END
            <div class="text-center">
         <form class="container mt-5" style="max-width: 330px">
  <img class="mb-4" src="$rootUri/img/defaut.jpg" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Connexion</h1>
  <label for="inputEmail" class="sr-only">Adresse mail</label>
  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
  <label for="inputPassword" class="sr-only">Mot de passe</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
  
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

</form>            
</div>    
END;

        VueHeaderFooter::afficherFooter();
    }

}