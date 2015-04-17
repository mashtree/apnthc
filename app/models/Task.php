<?php

class Task{

	private $_table = 'w_task';
	private $_db;

	public function __construct(){
		$this->registry = $registry;
        $this->_db = new Database();
	}

	public function add($data){
		$this->_db->insert($this->_table,$data);
	}

	public function edit($id,$data){
		$this->_db->update($this->_table,$data,'id='.$id);
	}

	public function remove($id){
		
		$this->_db->delete($this->_table,'id='.$id);
	}

	public function is_exist($nomor,$id=null){
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE nomor="'.$nomor.'"'));
        if(!is_null($id)) $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE nomor="'.$nomor.'" AND id<>'.$id));
        if($result>0) return TRUE;
        return FALSE;
	}

	public function last_insert_id(){
		return $this->_db->last_insert_id();
	}

	public function get_task($bulan = null){
		$sql = "SELECT * FROM w_task";
		if(!is_null($bulan)){
			$sql .= " WHERE MONTH(tgl_mulai)=$bulan OR MONTH(tgl_selesai)=$bulan ";
		}
		return $this->_db->select($sql);
	}
}