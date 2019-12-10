<?php


namespace mywishlist\vues;

use Slim\Slim;

class VueHeaderFooter
{



    public static function afficherHeader($active){
        $app = \Slim\Slim::getInstance() ;
        $rootUri = $app->request->getRootUri() ;
        $header =
<<<END
<!doctype html>
    <html lang=\"fr\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
            <LINK href="$rootUri/styles/$active.css" rel="stylesheet" type="text/css">
            <title>Toutes les wishlist </title>
        </head>
        <body>

        <div class="header">
          <a href="#default" class="logo">MyWishlist</a>
          <div class="header-right">
            <a class="home" href="$rootUri/">Home</a>
            <a class="wishlist" href="$rootUri/listes">Wishlist</a>
            <a class="TODO" href="#TODO">About</a>
          </div>
        </div>
END;

        echo str_replace("class=\"" .$active."\"", "class=\"active\"",$header);

    }

    public static function afficherFooter(){
        echo
<<<END
        </body>
    </html>
END;
    }

}