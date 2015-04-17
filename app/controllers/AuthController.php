<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AuthController extends BaseController {

    public function __construct($registry) {
        parent::__construct($registry);
    }

    public function index() {
        $this->view->load('admin/login');
    }

    public function login() {
		
        if (isset($_POST['user'])) {
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $pwd = Hash::create('sha1', $pass, HASH_SALT_KEY);
            $cuser = new User($this->registry);
            $res = $cuser->login($user, $pwd);
            switch ($res[1]) {
                case 1:
                    $role = 'admin';
                    break;
                case 2:
                    $role = 'koordinator';
                    break;
                case 3:
                    $role = 'inputer';
                    break;
                default:
                    $role = 'guest';
            }
            if ((int) $res[0] == 1) {
                $pegawai = new Pegawai($this->registry);
                $data = $pegawai->get($res[3]);
                Session::createSession();
                Session::set('loggedin', TRUE);
                Session::set('nama',$data[0]['nama']);
                Session::set('user', $res[2]);
                Session::set('role', $role);
                Session::set('id_user', $res[4]); 
                header('location:' . URL); 
            } else if ((int) $res[0] == 0) {
                $this->view->add_error('error',"user tidak ditemukan!");
                $this->view->load('admin/login');
            } else {
                $this->view->add_error('error',"database tidak valid!");
                $this->view->load('admin/login');
            }
        } else {
            $this->view->load('admin/login');
        }
    }

    public function logout() {
        Session::createSession();
        Session::destroySession();
        Session::unsetAll();
        $this->view->load('admin/login');
    }

    public function __destruct() {
        parent::__destruct();
    }
}