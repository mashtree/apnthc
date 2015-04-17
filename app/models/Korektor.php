<?php

class korektor {

	private $_table = 'korektor';
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

	public function get_korektor_assesment($id){
		$sql = 'SELECT a.id as id,
					b.id as id_pegawai, 
					b.nip as nip, 
					b.nama as pegawai,
					c.id as id_assesment, 
					c.nama_kegiatan as kegiatan
					FROM '.$this->_table.' a 
					LEFT JOIN pegawai b ON a.id_pegawai = b.id 
					LEFT JOIN assesment c ON a.id_assesment = c.id
					WHERE a.id_assesment='.$id;
					
		$result = $this->_db->select($sql);
		return $result;
	}

	public function get_korektor_peserta($id_asses, $id_peserta){
		$sql = 'SELECT DISTINCT(a.id) as id, c.nama as id_pegawai FROM '.$this->_table.' a 
				LEFT JOIN nilai_tes b ON a.id=b.id_korektor 
				LEFT JOIN pegawai c ON a.id_pegawai=c.id
				WHERE a.id_assesment='.$id_asses.' AND b.id_peserta='.$id_peserta;
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
		//TODO hapus juga data lain yang berhubungan dengan korektor
		try {
		    $this->_db->beginTransaction();

		    //TODO select data tes asses untuk menghapus nilai asses

		    $this->_db->exec("DELETE FROM nilai_tes WHERE id_korektor=".$id); //hapus tes assesment
		 
		    $this->_db->commit();
		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $db->rollBack();
		    echo $ex->getMessage();
		}
		$this->_db->delete($this->_table,'id='.$id);
	}

	public function is_exist($id_pegawai, $id_asses, $id=null){ //cek lagi
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE id_pegawai='.$id_pegawai.' AND id_assesment='.$id_asses));
		if(!is_null($id)) $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE id_pegawai='.$id_pegawai.' AND id_assesment='.$id_asses.' AND id<>'.$id));
		if($result>0) return TRUE;
		return FALSE;
	}
}