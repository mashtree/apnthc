<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class User {

    public $registry;
    private $_table = "user";
    public $_db;
    private $_id_pegawai;
    private $_id_user;
    private $_nama_user;
    private $_password;
    private $_role;

    public function __construct($registry) {
        $this->registry = $registry;
        $this->_db = new Database();
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM " . $this->_table . " WHERE nama_user='" . $username . "' AND password='" . $password . "'";
        $result = $this->_db->select($sql);
        $role = 0;
        $return = array();
        foreach ($result as $v) {
           $role = $v['role'];
           $user = $v['nama_user'];
           $id_pegawai = $v['id_pegawai'];
           $id = $v['id'];
        }
		
        $return[] = count($result);
        $return[] = $role;
        $return[] = $user;
        $return[] = $id_pegawai;
        $return[] = $id;
        return $return;
    }

    public function get($id=null){
        $sql = 'SELECT * FROM '.$this->_table;
        if(!is_null($id)) $sql = 'SELECT * FROM '.$this->_table.' WHERE id='.$id;
        $result = $this->_db->select($sql);
        return $result;
    }

    public function get_join(){
        $sql = 'SELECT 
                        a.id as id,
                        b.id as id_peg,
                        b.nama as id_pegawai,
                        a.nama_user as nama_user, 
                        a.role as role 
                FROM '.$this->_table.' a 
                        LEFT JOIN pegawai b ON a.id_pegawai=b.id';
        $result = $this->_db->select($sql);
        return $result;
    }

    public function add($data){
        $this->_db->insert($this->_table,$data);
    }

    public function edit($id,$data){
        $this->_db->update($this->_table,$data,'id='.$id);
    }

    public function remove($id){
        try {
            $this->_db->beginTransaction();

            $data = $this->select('SELECT id_pegawai FROM '.$this->_table.' WHERE role=1');

            if(count($data)==0) return;
            
            $pic = $data[0]['id_pegawai']; //ubah pic assesment ke pic admin yg ada
            
            $asses = new Assesment($this->registry);

            $asses->select('UPDATE assesment SET pic='.$pic.' WHERE 1');
                     
            $this->_db->commit();
        } catch(PDOException $ex) {
            //Something went wrong rollback!
            $db->rollBack();
            echo $ex->getMessage();
        }        
        $this->_db->delete($this->_table,'id='.$id);
    }

    public function is_exist($kolom, $value,$id=null){
        $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE '.$kolom.' = "'.$value.'"'));
        if(!is_null($id)) $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE '.$kolom.' = "'.$value.'" AND id<>'.$id));
        if($result>0) return TRUE;
        return FALSE;
    }

    public function get_id_user() {
        return $this->_id_user;
    }

    public function set_id_user($id_user) {
        $this->_id_user = $id_user;
    }

    public function get_id_pegawai() {
        return $this->_id_pegawai;
    }

    public function set_id_pegawai($id_pegawai) {
        $this->_id_pegawai = $id_pegawai;
    }

    public function get_nama_user() {
        return $this->_nama_user;
    }

    public function set_nama_user($nama_user) {
        $this->_nama_user = $nama_user;
    }

    public function get_password() {
        return $this->_password;
    }

    public function set_password($password) {
        $this->_password = $password;
    }

    public function get_role() {
        return $this->_role;
    }

    public function set_role($role) {
        $this->_role = $role;
    }

}