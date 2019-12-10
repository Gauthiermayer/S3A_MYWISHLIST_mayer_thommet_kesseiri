<?php


namespace mywishlist\vues;


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
            foreach ($this->liste as $key => $l) {
                //$rootUri = $this->app->request->getRootUri() ;
                $listeUrl = $this->app->urlFor('route_liste', ['id_liste' => $l['no']]);
                $num = $l['no'];
                $titre = $l['titre'];
                $desc = $l['description'];
                $user_id = $l['user_id'];

                echo
<<<END
        <div class="liste">
            <a href=" $listeUrl">  $num . $titre : $desc par $user_id . </a>
        </div>

END;
            }
        }
    }

    private function afficherAllItems(){
        if ($this->liste != NULL) {
            foreach ($this->liste as $key => $items) {
                //$rootUri = $this->app->request->getRootUri() ;
                $itemUrl = $this->app->urlFor('route_item', ['id_liste' => $items['liste_id'], 'id_item' => $items['id']]);
                $num = $items['id'];
                $titre = $items['nom'];
                $desc = $items['descr'];
                $tarif = $items['tarif'];

                echo
<<<END
        <div class="item">
            <a href=" $itemUrl">  $num . $titre : $desc ==> $tarif €. </a>
        </div>

END;
            }
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
        }

        //affiche le footer
        VueHeaderFooter::afficherFooter();
    }
}