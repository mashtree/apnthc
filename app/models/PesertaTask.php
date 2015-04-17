<?php

class PesertaTask{

	private $_table = 'w_peserta';
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
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE id_pegawai='.$id_pegawai.' AND id_task='.$id_task));
        if(!is_null($id)) $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE id_pegawai='.$id_pegawai.' AND id_task='.$id_task.' AND id<>'.$id));
        if($result>0) return TRUE;
        return FALSE;
	}

	public function get_task($month=null){
		if(is_null($month)){
			$month = date('Y-m');
		}

		$time = explode('-', $month);
		$sql = 'SELECT ';

	}
}