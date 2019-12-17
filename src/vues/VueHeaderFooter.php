<?php


namespace mywishlist\vues;

use Slim\Slim;

class VueHeaderFooter
{



    public static function afficherHeader($active, $css = null){
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
            <link href="$rootUri/styles/bootstrap.css" rel="stylesheet" type="text/css">
            <link href="$rootUri/styles/header-footer.css" rel="stylesheet" type="text/css">
END;

        //------------------- Ajoute le css en param -------------------\\
        if (!is_null($css))
            $header = $header . <<<END
            <link href="$rootUri/styles/$css" rel="stylesheet" type="text/css">
END;
        //------------------- Ajoute le css en param -------------------\\

        $header = $header .
            <<<END
            <title>Wishlist</title>
        </head>
        <body class="">

        <div class="header">
          <a href="#default" class="logo">MyWishlist</a>
          <div class="header-right">
            <a class="home" href="$rootUri/">Home</a>
            <a class="wishlist" href="$rootUri/listes">Wishlist</a>
            <a class="create" href="$rootUri/liste/create">Nouvelle liste</a>
            <a class="login" href="$rootUri/login">Login</a>
          </div>
        </div>

END;

        echo str_replace("class=\"" .$active."\"", "class=\"active\"",$header);
    }

    public static function afficherFooter(){
        echo
<<<END
        </body>
        <!-- Footer -->
        <footer class="container-fluid position-absolute" style="background-color: #005cbf">
        
          <!-- Copyright -->
          <div class="text-center py-3">© 2019 Copyright:
            <a href="http://www.google.fr"> Github.com</a>
          </div>
          <!-- Copyright -->
        
        </footer>
        <!-- Footer -->
    </html>
END;
    }

}