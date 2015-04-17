<?php

class Peserta {

	private $_table = 'peserta';
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

	/*
	* mendapatkan data peserta assesment, nip, nama, kegiatan assesment
	* @param id assesment atau dengan id pegawai
	*/
	public function get_peserta_assesment($id_asses, $id_p = NULL){
		$sql = 'SELECT a.id as id,
					b.id as id_pegawai, 
					b.nip as nip, 
					b.nama as pegawai,
					b.unit as unit,
					b.jabatan as jabatan,
					c.id as id_assesment, 
					c.nama_kegiatan as kegiatan
					FROM '.$this->_table.' a 
					LEFT JOIN pegawai b ON a.id_pegawai = b.id 
					LEFT JOIN assesment c ON a.id_assesment = c.id
					WHERE c.id='.$id_asses.' ';
		if(NULL!=$id_p) { 
			$sql = $sql.' AND b.id='.$id_p;
		}
		
		$result = $this->_db->select($sql);
		return $result;
	}

	public function add($data){
		$this->_db->insert($this->_table,$data);
	}

	public function edit($id,$data){
		var_dump($this->_db->update($this->_table,$data,'id='.$id));
	}

	public function remove($id){
		try {
		    $this->_db->beginTransaction();

		    //TODO select data pegawai untuk menghapus nilai asses dan keikutsertaan di assesment

		    $this->_db->exec("DELETE FROM nilai_tes WHERE id_peserta=".$id); //hapus di user
		 
		    $this->_db->commit();
		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $db->rollBack();
		    echo $ex->getMessage();
		}

		$this->_db->delete($this->_table,'id='.$id);
	}

	public function is_exist($kolom, $value, $id=null){ //cek lagi
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE '.$kolom.' = "'.$value.'"'));
		if(!is_null($id)) $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE '.$kolom.' = "'.$value.'" AND id<>'.$id));
		if($result>0) return TRUE;
		return FALSE;
	}
}