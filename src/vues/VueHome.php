<?php

namespace mywishlist\vues;

class VueHome {

    private $app;

    /**
     * VueHome constructor.
     */
    public function __construct() {
        $this->app = \Slim\Slim::getInstance() ;
    }

    public function afficherDefaultHome() {
        VueHeaderFooter::afficherHeader('home');





        VueHeaderFooter::afficherFooter();
    }
}