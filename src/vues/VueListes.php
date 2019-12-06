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
        $head = "<!doctype html>
                    <html lang=\"fr\">
                        <head>
                            <meta charset=\"UTF-8\">
                            <meta name=\"viewport\"
                                  content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
                            <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
                            <title>Items de la liste </title>
                        </head>
                        <body>";

        $footer = "</body>
                    </html>";

        $content = "";
        if ($this->liste != NULL){
            foreach ($this->liste as $key => $l){
                //$rootUri = $this->app->request->getRootUri() ;
                $listeUrl = $this->app->urlFor('route_liste', ['id_liste'=> $l['no']] ) ;

                $content .= '
                            <div class="liste">
                                <a href="'.$listeUrl.'"> ' . $l['no'] . '. '. $l['titre'] . ' : ' . $l['description'] . ' par ' . $l['user_id'] . '</a>
                            </div>';
            }
        }
        echo $head.$content.$footer;
    }


}