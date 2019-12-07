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

    public function afficher(){
        echo
<<<END
<!doctype html>
    <html lang=\"fr\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
            <LINK href="styles/view-listes.css" rel="stylesheet" type="text/css">
            <title>Toutes les wishlist </title>
        </head>
        <body>
END;

        if ($this->liste != NULL){
            foreach ($this->liste as $key => $l){
                //$rootUri = $this->app->request->getRootUri() ;
                $listeUrl = $this->app->urlFor('route_liste', ['id_liste'=> $l['no']] ) ;
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

        echo
<<<END
        </body>
    </html>
END;

    }
}