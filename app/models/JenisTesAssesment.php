<?php

class JenisTesAssesment {

	private $_table = 'sub_tes';
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
	* mendapatkan jenis tes assesment per assesment
	*/
	public function get_jenis_tes_assesment($id){
		$sql = 'SELECT a.id as id,
					c.jenis_tes as id_tes_asses,
					c.singkat as singkat, 
					a.nama_sub_tes as nama_sub_tes,
					a.bobot as bobot,
					b.bobot as bobot_tes,
					b.metode as metode,
					b.pass_grade as pass_grade
					FROM '.$this->_table.' a 
					LEFT JOIN tes_asses b ON a.id_tes_asses = b.id
					LEFT JOIN jenis_tes c ON b.id_jenis_tes = c.id
					WHERE b.id_assesment='.$id;

		$result = $this->_db->select($sql);
		return $result;
	}

	public function add($data){
		$this->_db->insert($this->_table,$data);
	}

	public function edit($id,$data){
		$this->_db->update($this->_table,$data,'id='.$id);
	}

	public function edit_where($data,$where){
		$this->_db->update($this->_table,$data,$where);
	}

	public function remove($id){
		//TODO hapus juga data lain yang berhubungan dengan sub tes
		try {
		    $this->_db->beginTransaction();

		    //TODO select data tes asses untuk menghapus nilai asses

		    $this->_db->exec("DELETE FROM nilai_tes WHERE id_sub_tes=".$id); //hapus tes assesment
		 
		    $this->_db->commit();
		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $db->rollBack();
		    echo $ex->getMessage();
		}
		$this->_db->delete($this->_table,'id='.$id);
	}

	public function is_exist($sub_tes, $id_tes_asses, $id=null){ //cek lagi
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE LOWER(nama_sub_tes)='.strtolower($sub_tes).' AND id_tes_asses='.$id_tes_asses));
		if(!is_null($id)) $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE LOWER(nama_sub_tes)='.strtolower($sub_tes).' AND id_tes_asses='.$id_tes_asses.' AND id<>'.$id));
		if($result>0) return TRUE;
		return FALSE;
	}

	/*
	* menghitung bobot secara otomatis
	*/

	public static function get_bobot($registry,$id_jenis_tes){
		$sql = 'SELECT COUNT(id) as num FROM sub_tes 
				WHERE id_tes_asses='.$id_jenis_tes;
		$data = $registry->db->select($sql);//var_dump($data);
		$num = 100/((float) $data[0]['num'] + 1); //var_dump($num);
		return $num;

	}

	/*
	* mendapatkan data untuk pembentukan form
	*/

	public function form_data($id_asses){
		$sql = 'SELECT 	a.id as id_sub_tes,
						c.jenis_tes as jenis_tes,
						a.kode as kode,
						a.nama_sub_tes as nama_sub_tes
				FROM '.$this->_table.' a
				LEFT JOIN tes_asses b ON a.id_tes_asses=b.id 
				LEFT JOIN jenis_tes c ON b.id_jenis_tes = c.id 
				WHERE b.id_assesment='.$id_asses;

		$data = $this->_db->select($sql);
		return $data;
	}
}