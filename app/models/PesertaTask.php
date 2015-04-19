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

	//belum selesai
	public function get_task($month=null){
		if(is_null($month)){
			$month = date('Y-m');
		}

		$time = explode('-', $month);
		$sql = 'SELECT ';

	}

	public function get_peserta_bulan($bulan){
		$result = array();
		$tmp = explode('-', $bulan);
		$month = $tmp[1];
		$year = $tmp[0];
		$sql = 'SELECT a.id_pegawai as id_pegawai, b.nama as nama, a.id_task as id_task, a.tgl_mulai as tgl_mulai, a.tgl_selesai as tgl_selesai 
				FROM '.$this->_table.' a LEFT JOIN pegawai b ON a.id_pegawai = b.id
				WHERE (MONTH(a.tgl_mulai)="'.$month.'" AND YEAR(a.tgl_mulai)="'.$year.'") OR (MONTH(a.tgl_selesai)="'.$month.'" AND YEAR(a.tgl_selesai)="'.$year.'")';
		//TODO pegawai bisa > 1 kegiatan; jadwal yg bentrok di blok hitam
		$data = $this->_db->select($sql);
		$day = date('t',strtotime($bulan));
		$result['num_day'] = $day;
		$id_pegawai = null;
		foreach ($data as $key => $value) {
			if($id_pegawai!=$value['id_pegawai']){
				$id_pegawai = $value['id_pegawai'];
				$result[$id_pegawai] = array();
				$result[$id_pegawai]['nama'] = $value['nama'];
				for($i=1;$i<=$day;$i++){
					$date = $bulan.'-'.$i;
					$is_in_mulai = strtotime($date)>=strtotime($value['tgl_mulai']);
					$is_in_selesai = strtotime($date)<=strtotime($value['tgl_selesai']);
					$result[$id_pegawai][$i] = array('isi'=>false,'bentrok'=>false);	
					if($is_in_mulai && $is_in_selesai){
						$result[$id_pegawai][$i]['isi'] = true;
					}
					
				}
			}else{
				for($i=1;$i<=$day;$i++){
					$date = $bulan.'-'.$i;
					$is_in_mulai = strtotime($date)>=strtotime($value['tgl_mulai']);
					$is_in_selesai = strtotime($date)<=strtotime($value['tgl_selesai']);	
					if($is_in_mulai && $is_in_selesai){
						if($result[$id_pegawai][$i]['isi'] == true){
							$result[$id_pegawai][$i]['bentrok'] = true;
						}else{
							$result[$id_pegawai][$i]['isi'] = true;
						}
					}
					
				}
			}
		}

		return $result;
	}
}