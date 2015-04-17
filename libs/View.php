<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author aisyah
 */
class View {

    private $title;
    private $error;
    private $success;

    public function __construct() {
        $this->error = array();
        $this->success = array();
        $this->title = TITLE;
    }

    /*
     * render include header + footer
     * @param nama file tanpa ekstensi .php
     */

    public function render($view) {

        if (!is_array($view)) {
            require 'app/view/Header.php';
            if(file_exists('app/view/'.$view.'.php')){
                require 'app/view/' . $view . '.php';
            }else{
                echo '<div class=row>';
                echo '<div class="large-12 columns"';
                echo $view;
                echo '</div>';
                echo '</div>';
            }
            require 'app/view/Footer.php';
        } else {
            $this->load($view);
        }
    }

    /*
     * render file
     * @param nama file tanpa ekstensi .php
     */

    public function load($fileView) {
        require 'app/view/' . $fileView . '.php';
    }

    /*
     * set judul halaman di browser
     * @param judul
     */

    private function _set_title($title) {
        $this->title = $title;
    }

    /*
     * get judul halaman
     * return judul
     */

    private function get_title() {
        return $this->title;
    }

    /*
     * is error
     */

    public function is_error(){
        $err = count($this->error);
        if($err > 0) return TRUE;
        return FALSE;
    }

    /*
     * get error
     */
    public function get_error(){
        return $this->error;
    }

    /*
     * add error
     */
    public function add_error($key,$value){
        $this->error[$key] = $value;
    }

    /*
     * is success
     */

    public function is_success(){
        $err = count($this->success);
        if($err > 0) return TRUE;
        return FALSE;
    }

    /*
     * get success
     */
    public function get_success(){
        return $this->success;
    }

    /*
     * add error
     */
    public function add_success($key,$value){
        $this->success[$key] = $value;
    }

}