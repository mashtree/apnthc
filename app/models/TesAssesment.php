<?php

class TesAssesment {

	private $_table = 'tes_asses';
	private $_db;

	public function __construct($registry){
		$this->registry = $registry;
        $this->_db = new Database();
	}

	public function get($id=null){
		$sql = 'SELECT * FROM '.$this->_table;
		if(!is_null($id)) {
			if(is_array($id)){
				$n = count($id);
				$m = 1;
				$where = '';
				foreach ($id as $key => $value) {
					$m++;
					$where .= $key.'='.$value.' ';
					if($m<$n) $where .= ' WHERE ';

				}
			}elseif(!is_numeric($id)){
				$sql = 'SELECT * FROM '.$this->_table.' WHERE '.$id;
			}else{
				$sql = 'SELECT * FROM '.$this->_table.' WHERE id='.$id;
			}
		}
		$result = $this->_db->select($sql);
		return $result;
	}

	public function get_join($id=null){
		$sql = 'SELECT 
						a.id as id,
						b.nama_kegiatan AS id_assesment,
						c.jenis_tes as id_jenis_tes, 
						c.singkat as singkat,
						a.pass_grade as pass_grade,
						a.bobot as bobot,
						d.nama as metode 
				FROM '.$this->_table.' a 
						LEFT JOIN assesment b ON a.id_assesment=b.id
						LEFT JOIN jenis_tes c ON a.id_jenis_tes=c.id
						LEFT JOIN metode_penilaian d ON a.metode=d.id';
		if(!is_null($id)) $sql .= ' WHERE a.id_assesment='.$id; //echo $sql;
		$result = $this->_db->select($sql);
		return $result;
	}

	public function get_jenis_tes($id){
		$sql = 'SELECT a.id as id, 
						a.id_assesment as id_assesment,
						b.jenis_tes as id_jenis_tes,
						a.pass_grade as pass_grade,
						a.timestamp as timestamp
				FROM '.$this->_table.' a  
				LEFT JOIN jenis_tes b ON a.id_jenis_tes=b.id
				WHERE id_assesment='.$id;
		$result = $this->_db->select($sql);
		return $result;
	}

	public function add($data){
		//TODO cek double
		$this->_db->insert($this->_table,$data);
	}

	public function edit($id,$data){
		//TODO cek double
		$this->_db->update($this->_table,$data,'id='.$id);
	}

	public function remove($id){
		//TODO hapus semua nilai yang berhubungan dengan data ini
		try {
		    $this->_db->beginTransaction();
		 
		    $data = $this->select('SELECT id FROM sub_tes WHERE id_tes_asses='.$id);
		       
		    foreach ($data as $key => $value) {
		    
		    	$this->_db->exec('DELETE FROM nilai_tes WHERE id_sub_tes='.$value); //hapus nilai tes assesment
		
		    }
		 
		    $this->_db->exec("DELETE FROM sub_tes WHERE id_tes_asses=".$id); //hapus sub tes assesment
		 
		    $this->_db->commit();
		} catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $db->rollBack();
		    echo $ex->getMessage();
		}
		$this->_db->delete($this->_table,'id='.$id);
	}

	public function is_exist($id_asses, $id_jenis_tes,$id=null){
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE id_assesment='.$id_asses.' AND id_jenis_tes='.$id_jenis_tes));
        if(!is_null($id)) $result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE id_assesment='.$id_asses.' AND id_jenis_tes='.$id_jenis_tes.' AND id<>'.$id));
        if($result>0) return TRUE;
        return FALSE;
	}
}