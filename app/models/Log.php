<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Log {

    public $registry;
    private $_table = "d_user";    
	private $_table = "d_log";
    public $_db;
    private $_kd_log;
    private $_kd_d_user;
    private $_activity;
    private $_activity_time;
    private $_ip_client;
    private $_status;

    public function __construct($registry) {
        $this->registry = $registry;
        $this->_db = new Database();
    }

    public function log_it($kd_d_user, $activity, $status) {
        $sql = "SELECT KD_R_JENIS, NAMA_USER, KD_SATKER FROM " . $this->_table . " WHERE KD_D_USER ='" . $kd_d_user;
        $result = $this->_db->select($sql);
        $role = 0;
        $return = array();
        foreach ($result as $v) {
           $kd_r_jenis = $v['KD_R_JENIS'];
           $nama_user = $v['NAMA_USER'];
           $kd_satker = $v['KD_SATKER'];
        }
		
        $return[] = count($result);
        $return[] = $role;
        $return[] = $kd;
        $return[] = $id;
        $return[] = $satker;
        return $return;
    }

    public function get_kd_d_user() {
        return $this->_kd_d_user;
    }

    public function set_kd_d_user($kd_d_user) {
        $this->_kd_d_user = $kd_d_user;
    }

    public function get_kd_r_jenis() {
        return $this->_kd_r_jenis;
    }

    public function set_kd_r_jenis($kd_r_jenis) {
        $this->_kd_r_jenis = $kd_r_jenis;
    }

    public function get_kd_d_kppn() {
        return $this->_kd_d_kppn;
    }

    public function set_kd_d_kppn($kd_r_unit) {
        $this->_kd_d_kppn = $kd_r_unit;
    }

    public function get_nama_user() {
        return $this->_nama_user;
    }

    public function set_nama_user($nama_user) {
        $this->_nama_user = $nama_user;
    }

    public function get_pass_user() {
        return $this->_pass_user;
    }

    public function set_pass_user($pass_user) {
        $this->_pass_user = $pass_user;
    }

}