<?php

class JenisTes {

	private $_table = 'jenis_tes';
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
		//TODO hapus semua jenis tes assesment yg berhubungan dengan jenis tes ini
		try {
		    $this->_db->beginTransaction();

		    //TODO select data tes asses untuk menghapus nilai asses
		 
		   	$data = $this->_db->select('SELECT id FROM tes_asses WHERE id_jenis_tes='.$id);
		    
		    foreach ($data as $key => $value) {
		    	$sub_tes = $this->_db->select('SELECT id FROM sub_tes WHERE id_tes_asses='.$value);
		    	foreach ($sub_tes as $k => $v) {
		    		
		    		$this->_db->exec('DELETE FROM nilai_tes WHERE id_sub_tes='.$v); //hapus nilai tes assesment
		    		
		    	}
		    	$this->_db->exec('DELETE FROM sub_tes WHERE id_tes_asses='.$value); //hapus sub tes assesment
		    }

		    $this->_db->exec("DELETE FROM tes_asses WHERE id_jenis_tes=".$id); //hapus tes assesment

		 
		    $this->_db->commit();
		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $db->rollBack();
		    echo $ex->getMessage();
		}
		$this->_db->delete($this->_table,'id='.$id);
	}

	public function is_exist($nama,$id=null){
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE LOWER(jenis_tes)="'.strtolower($nama).'"'));
        if(!is_null($id)) $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE LOWER(jenis_tes)="'.strtolower($nama).'" AND id<>'.$id));
        if($result>0) return TRUE;
        return FALSE;
	}
}