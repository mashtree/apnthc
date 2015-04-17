<?php

class Pegawai {

	private $_table = 'pegawai';
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

	public function get_for_korektor($eselon){
		$es = 99;
		$sql = 'SELECT * FROM '.$this->_table;
		if($eselon==41 OR $eselon==42){
			$sql .= ' WHERE eselon=41 OR eselon=42';
		}elseif($eselon==31 OR $eselon==32){
			$sql .= ' WHERE eselon=31 OR eselon=32';
		}elseif($eselon==21 OR $eselon==22){
			$sql .= ' WHERE eselon=21 OR eselon=22';
		}else{
			$sql .= ' WHERE eselon=41 OR eselon=42';
		}
		$result = $this->_db->select($sql);
		return $result;
	}

	public function get_for_peserta($eselon){
		$eselon = (int) $eselon; 
		$es = 99;
		$sql = 'SELECT * FROM '.$this->_table;
		if($eselon==41 OR $eselon==42){
			$sql .= ' WHERE eselon=99';
		}elseif($eselon==31 OR $eselon==32){
			$sql .= ' WHERE eselon=41 OR eselon=42';
		}elseif($eselon==21 OR $eselon==22){
			$sql .= ' WHERE eselon=31 OR eselon=32';
		}else{
			$sql .= ' WHERE eselon=99';
		}
		
		$return = $this->_db->select($sql);
		return $return;
	}

	public function pegawai_to_json($eselon, $filter){
		if($filter=='korektor'){
			return $this->get_for_korektor($eselon);
		}
		return $this->get_for_peserta($eselon);
	}

	public function add($data){
		$this->_db->insert($this->_table,$data);
	}

	public function edit($id,$data){
		if(is_numeric($id)){
			$this->_db->update($this->_table,$data,'id='.$id);
		}else{
			$this->_db->update($this->_table,$data,$id);
		}
		
	}

	public function remove($id){
		try {
		    $this->_db->beginTransaction();

		    //TODO select data pegawai untuk menghapus nilai asses dan keikutsertaan di assesment

		    $data = $this->select('SELECT id FROM peserta WHERE id_pegawai='.$id);

		    foreach ($data as $key => $value) {
		    	$this->_db->exec("DELETE FROM nilai_tes WHERE id_peserta=".$value); //hapus di nilai tes
		    }

		    $this->_db->exec("DELETE FROM peserta WHERE id_pegawai=".$id); //hapus di nilai tes

		    $data = $this->select('SELECT id FROM korektor WHERE id_pegawai='.$id); 

		    foreach ($data as $key => $value) {
		    	$this->_db->exec("DELETE FROM nilai_tes WHERE id_korektor=".$value); //hapus di nilai tes
		    }

		    $this->_db->exec("DELETE FROM korektor WHERE id_pegawai=".$id); //hapus korektor

		    $this->_db->exec("DELETE FROM user WHERE id_pegawai=".$id); //hapus di user
		 
		    $this->_db->commit();
		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $db->rollBack();
		    echo $ex->getMessage();
		}
		
		$this->_db->delete($this->_table,'id='.$id);
	}

	public function is_exist($kolom, $value, $id=null){
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE '.$kolom.' = "'.$value.'"'));
		if(!is_null($id)) $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE '.$kolom.' = "'.$value.'" AND id<>'.$id));
		if($result>0) return TRUE;
		return FALSE;
	}
}