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

    private function afficherHeader(){
        $rootUri = $this->app->request->getRootUri() ;
        echo
<<<END
<!doctype html>
    <html lang=\"fr\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
            <LINK href="$rootUri/styles/view-listes.css" rel="stylesheet" type="text/css">
            <title>Toutes les wishlist </title>
        </head>
        <body>

        <div class="header">
          <a href="#default" class="logo">Test</a>
          <div class="header-right">
            <a href="$rootUri/">Home</a>
            <a href="$rootUri/listes">Wishlist</a>
            <a href="#about">About</a>
          </div>
        </div>
END;

    }

    private function afficherFooter(){
        echo
<<<END
        </body>
    </html>
END;
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

        //afficher le header
        $this->afficherHeader();

        //affiche le contenu
        switch ($type){
            case 1:
                $this->afficherToutesListes();
                break;
            case 2:
                $this->afficherAllItems();
                break;
            default:
                //fait rien
                break;
        }

        //affiche le footer
        $this->afficherFooter();
    }
}