<?php


namespace mywishlist\vues;


class VueEditionCreationListe
{

    private $app;

    public function __construct()
    {
        $this->app = \Slim\Slim::getInstance() ;
    }

    private function afficherCreation(){
        echo
<<<END
<form class="container mt-5" style="max-width: 700px" method="post" action="">
  <div class="form-group">
    <label for="liste_name">Nom de la liste</label>
    <input type="text" class="form-control" name="liste_name" id="liste_name" aria-describedby="list_name" placeholder="Pour notre mariage...">    
  </div>
  <div class="form-group">
    <label for="liste_desc">Description</label>
    <input type="text" class="form-control" name="liste_desc" id="liste_desc" placeholder="Description">
  </div>
  
  <div class="form-group">
    <label for="date">Date d'expiration</label>  
    <input size="16" class="form-control" type="text" placeholder="31/12/2099" name ="date">    
  </div> 
   
  <div class="form-check">
    <input type="checkbox" name="private" class="form-check-input" id="private">
    <label class="form-check-label" for="private">Privée</label>
  </div>
    
  <button type="submit" class="btn btn-primary mb-3 mt-3">Envoyer</button>
</form>  

END;
    }

    public function afficher($type){
        VueHeaderFooter::afficherHeader('create');

        switch ($type){
            case 1:
                $this->afficherCreation();
                break;
        }

        VueHeaderFooter::afficherFooter();
    }
}