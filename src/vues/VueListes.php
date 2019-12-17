<?php


namespace mywishlist\vues;


use mywishlist\models\Item;

class VueListes
{
    private $liste;
    private $app;

    /**
     * VueListe constructor.
     * @param $liste
     */
    public function __construct($liste)
    {
        $this->liste = $liste;
        $this->app = \Slim\Slim::getInstance() ;
    }




    private function afficherToutesListes()
    {
        if ($this->liste != NULL) {
            echo
<<<END
<div class="m-3">
        <ul class="list-group">
END;
            foreach ($this->liste as $key => $l) {
                if($l['private'] != 1) {

                    //$rootUri = $this->app->request->getRootUri() ;
                    $listeUrl = $this->app->urlFor('route_liste', ['id_liste' => $l['no']]);
                    $num = $l['no'];
                    $titre = $l['titre'];
                    $desc = $l['description'];
                    $user_id = $l['user_id'];
                    $nb_items = Item::all()->where('liste_id', '=', $num)->count();

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
        if ($this->liste != NULL) {
            echo
<<<END
<div class="row row-cols-1 row-cols-md-3 ml-5 mr-5">
END;

            foreach ($this->liste as $key => $items) {
                $rootUri = $this->app->urlFor('default', []);
                $itemUrl = $this->app->urlFor('route_item', ['id_liste' => $items['liste_id'], 'id_item' => $items['id']]);
                $num = $items['id'];
                $titre = $items['nom'];
                $desc = $items['descr'];
                $tarif = $items['tarif'];

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
        if ($this->liste != NULL) {
            foreach ($this->liste as $key => $val){
                $item = $val;
            }
            $rootUri = $this->app->urlFor('default', []);
            $titre = $item['nom'];
            $desc = $item['descr'];
            $tarif = $item['tarif'];

            $routeImg = $rootUri . '/img/' . 'defaut.jpg';
            if (isset($item['img'])) {
                $img = $item['img'];
                $routeImg = $rootUri . '/img/' . $img;
            }

            echo
<<<END
<div class="card m-lg-5 ">
  <img src="$routeImg" class="card-img-top align-self-center" alt=$desc style="height:50%;width: 50%">
  <div class="card-body">
    <h5 class="card-title">$titre</h5>
    <h4>$tarif €</h4>
    <p class="card-text">$desc</p>
    <a href="#" class="btn btn-primary">Réserver</a>
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