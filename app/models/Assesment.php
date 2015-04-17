<?php

class Assesment {

	private $_table = 'assesment';
	private $_db;

	public function __construct($registry){
		$this->registry = $registry;
        $this->_db = new Database();
	}

	public function get($id=null){
		$sql = 'SELECT * FROM '.$this->_table;
		if(!is_null($id)) $sql = 'SELECT * FROM '.$this->_table.' WHERE id='.$id;
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

		    //TODO select data tes asses untuk menghapus nilai asses

		    $data = $this->select('SELECT id FROM tes_asses WHERE id_assesment='.$id);
		    $peserta = $this->select('SELECT id FROM peserta WHERE id_assesment='.$id);
		    
		    foreach ($data as $key => $value) {
		    	$sub_tes = $this->select('SELECT id FROM sub_tes WHERE id_tes_asses='.$value);
		    	foreach ($sub_tes as $k => $v) {
		    		foreach ($peserta as $ke => $val) {
		    			$this->_db->exec('DELETE FROM nilai_tes WHERE id_peserta='.$value.' AND id_sub_tes='.$v); //hapus nilai tes assesment
		    		}
		    	}
		    	$this->_db->exec('DELETE FROM sub_tes WHERE id_tes_asses='.$value); //hapus sub tes assesment
		    }

		    $this->_db->exec('DELETE FROM korektor WHERE id_assesment='.$id); //hapus korektor assesment

		    $this->_db->exec("DELETE FROM peserta WHERE id_assesment=".$id); //hapus peserta assesment
		 
		    $this->_db->exec("DELETE FROM tes_asses WHERE id_assesment=".$id); //hapus tes assesment
		 
		    $this->_db->commit();
		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $db->rollBack();
		    echo $ex->getMessage();
		}
		
		$this->_db->delete($this->_table,'id='.$id);
	}
}