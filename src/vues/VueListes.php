<?php


namespace mywishlist\vues;


use mywishlist\models\Item;

class VueListes
{
    private $params;
    private $app;

    /**
     * VueListe constructor.
     * @param $liste
     */
    public function __construct($params)
    {
        $this->params = $params;
        $this->app = \Slim\Slim::getInstance() ;
    }




    private function afficherToutesListes()
    {
        if ($this->params != NULL) {
            echo
<<<END
<div class="m-3">
        <ul class="list-group">
END;
            foreach ($this->params['listes'] as $key => $l) {
                if($l['liste']['private'] != 1) {

                    //$rootUri = $this->app->request->getRootUri() ;
                    $listeUrl = $this->app->urlFor('route_liste', ['id_liste' => $l['liste']['no']]);
                    $num = $l['liste']['no'];
                    $titre = $l['liste']['titre'];
                    $desc = $l['liste']['description'];
                    $user_id = $l['liste']['user_id'];
                    $nb_items = $l['nb'];

                    echo
<<<END
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href=" $listeUrl"> $titre : $desc par $user_id.</a>
             <span class="badge badge-primary badge-pill">$nb_items items</span>
        </li>
END;
                }
            }
            echo
<<<END
        </ul>
</div>
END;

        }
    }

    private function afficherAllItems(){
        if ($this->params != NULL) {
            echo
<<<END
<div class="row row-cols-1 row-cols-md-3 ml-5 mr-5">
END;

            foreach ($this->params['items'] as $key => $items) {
                $rootUri = $this->app->urlFor('default', []);
                $itemUrl = $this->app->urlFor('route_item', ['id_liste' => $items['liste_id'], 'id_item' => $items['id']]);
                $num = $items['id'];
                $titre = $items['nom'];
                $desc = $items['descr'];
                if (strlen($desc) > 60){
                    $desc = substr_replace($desc,'..',60);
                }

                $routeImg = $rootUri . '/img/' . 'defaut.jpg';
                if (isset($items['img'])) {
                    $img = $items['img'];
                    $routeImg = $rootUri . '/img/' . $img;
                }

                echo
<<<END
<div class="col mb-4">
<div class="card h-100 m-3" style="width: 18rem;">
  <img class="card-img-top m-auto" src="$routeImg" alt=$desc style="width: 17.9rem;height: 180px ">  

      <div class="card-body">
        <h5 class="card-title">$titre</h5>
        <p class="card-text">$desc.</p>
        <a href="$itemUrl" class="btn btn-primary">Réserver</a>
      </div>
  </div>
</div>
END;
            }

            echo
<<<END
</div>
END;

        }
    }

    private function afficherItem(){
        if ($this->params['item'] != NULL) {
            $rootUri = $this->app->urlFor('default', []);
            $item = $this->params['item'];
            $titre = $item['nom'];
            $desc = $item['descr'];
            $tarif = $item['tarif'];

            $routeImg = $rootUri . '/img/' . 'defaut.jpg';
            if (isset($item['img'])) {
                $img = $item['img'];
                $routeImg = $rootUri . '/img/' . $img;
            }

            $reservation = '<a href="#" class="btn btn-primary">Réserver</a>';
            if (isset($_COOKIE['created'])) {

                $created = unserialize($_COOKIE['created']);
                if (in_array($this->params['token_list'], $created)) {
                    $reservation = '<a href="#" class="btn btn-primary disabled">Réserver</a>';
                }
            }

            echo
<<<END
<div class="card m-lg-5 ">
  <img src="$routeImg" class="card-img-top align-self-center" alt=$desc style="height:50%;width: 50%">
  <div class="card-body">
    <h5 class="card-title">$titre</h5>
    <h4>$tarif €</h4>
    <p class="card-text">$desc</p>
    $reservation
  </div>
</div>
END;
        }


    }

    public function afficher($type){

        VueHeaderFooter::afficherHeader("wishlist");

        //affiche le contenu
        switch ($type){
            case 1:
                $this->afficherToutesListes();
                break;
            case 2:
                $this->afficherAllItems();
                break;
            case 3:
                $this->afficherItem();
                break;
        }

        //affiche le footer
        VueHeaderFooter::afficherFooter();
    }
}