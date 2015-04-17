<?php

class MetodePenilaian {

	private $_table = 'metode_penilaian';
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

            $data = $this->select('SELECT id FROM '.$this->_table.' WHERE id<>'.$id);

            if(count($data)==0) return;
            
            $pengganti = $data[0]['id']; //ubah pic assesment ke pic admin yg ada
            
            $asses = new TesAssesment($this->registry);

            $asses->select('UPDATE tes_asses SET metode='.$pengganti.' WHERE 1');
                     
            $this->_db->commit();
        } catch(PDOException $ex) {
            //Something went wrong rollback!
            $db->rollBack();
            echo $ex->getMessage();
        }   
		$this->_db->delete($this->_table,'id='.$id);
	}
}