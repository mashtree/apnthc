<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Index extends BaseController {

    public function __construct($registry) {
        parent::__construct($registry);
    }

    public function index() {
        
        header('location:' . URL . 'home');
        /*if (Session::get('role') == PLATINUM) {
			header('location:' . URL . 'home');
        } elseif (Session::get('role') == GOLD) {
            header('location:' . URL . 'home');
        } elseif (Session::get('role') == SILVER) {
            header('location:' . URL . 'home'); 
        }else {
            header('location:' . URL . 'auth/login');
        }*/
    }

}
