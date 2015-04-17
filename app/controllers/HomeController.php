<?php

class HomeController extends BaseController {
    /*
     * Konstruktor
     */

    public function __construct($registry) {
        parent::__construct($registry);
    }

    /*
     * Index
     */
    
    public function index() {
        //if (Session::get('role')==(PLATINUM || GOLD || SILVER)) {
           header('location:'.URL.'assesment');
        //} 
    }  
    
}

?>