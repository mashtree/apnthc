<?php

class NilaiTes {

	private $_table = 'nilai_tes';
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
	* nilai peserta per assesment per peserta
	*
	*/
	public function get_nilai_peserta($id_asses, $id_peserta){
		$return = array();
		$korektor = new korektor($this->registry);
		$data_korektor = $korektor->get_korektor_peserta($id_asses, $id_peserta); 
		$sub_tes = new JenisTesAssesment($this->registry);
		$data_sub_tes = $sub_tes->get_jenis_tes_assesment($id_asses);
		$return = $data_sub_tes; 
		$no = 0;
		foreach ($return as $key => $value) {
			$nilai = 0;
			$i = 0;
			foreach ($data_korektor as $k => $v) {
				$data_nilai = $this->get_nilai_where($id_asses, $id_peserta, $v['id'], $value['id']);
				$return[$no][$v['id_pegawai']] = $data_nilai[0]['nilai'];
				$nilai += $data_nilai[0]['nilai'];
				$i++;
				//$return[$no][$v['id_pegawai']] = $data_nilai;
			}
			$return[$no]['rata'] = ($i==0)?0:round($nilai/$i,2,PHP_ROUND_HALF_UP);

			$no++;
		}

		//nilai total sub tes sesuai metode pembobotan
		$tes_asses = '';
		$no = 0;
		foreach ($return as $key => $value) {
			if($tes_asses!=$value['id_tes_asses']){
				$tes_asses = $value['id_tes_asses'];
			}
			$nilai_bobot = 0;
			$nu = 0;
			foreach ($return as $k => $v) {
				if($tes_asses==$v['id_tes_asses']){
					if($v['metode']==1){
						$nilai_bobot += $v['rata'];
					}elseif($v['metode']==2){
						$nilai_bobot += $v['rata']/$v['bobot'];
						$nu++;
					}elseif($v['metode']==3){
						$nilai_bobot += $v['rata']*$v['bobot']/100;
					}
				}
			}

			//TODO metode bobot 2 setelah dijumlahkan seharusnya dibagi jumlah soal
			if($value['metode']==2){
				$nilai_bobot = ($nilai_bobot/$nu)*100;
			}
			$return[$no]['nilai'] = round($nilai_bobot,2,PHP_ROUND_HALF_UP);
			$return[$no]['nilai_bobot'] = round($nilai_bobot*$return[$no]['bobot_tes']/100,2,PHP_ROUND_HALF_UP);
			$no++;
		}
		//var_dump($return);
		return $return;
	}

	/*
	* nilai peserta per korektor
	*
	*/
	public function get_nilai_where($id_asses, $id_peserta, $id_korektor, $id_sub_tes){
		$sql = 'SELECT a.nilai as nilai, b.bobot as bobot, d.metode as metode FROM '.$this->_table.' a
				LEFT JOIN sub_tes b ON a.id_sub_tes=b.id
				LEFT JOIN peserta c ON a.id_peserta = c.id
				LEFT JOIN tes_asses d ON b.id_tes_asses = d.id
				WHERE a.id_korektor='.$id_korektor.' AND 
				a.id_peserta='.$id_peserta.' AND
				c.id_assesment='.$id_asses.' AND
				a.id_sub_tes='.$id_sub_tes;
		$data = $this->_db->select($sql);
		return $data;
		//return ($data[0]['nilai']*$data[0]['bobot'])/100;
	}

	/*
	*
	*/
	public function is_exist_nilai($id_asses, $id_peserta){
		$sql = 'SELECT COUNT(a.id) as num FROM '.$this->_table.' a
				LEFT JOIN sub_tes b ON a.id_sub_tes = b.id 
				LEFT JOIN tes_asses c ON b.id_tes_asses = c.id
				WHERE a.id_peserta='.$id_peserta.' AND c.id_assesment='.$id_asses;
			
		$data = $this->_db->select($sql);

		if((int) $data[0]['num']>0) return TRUE;
		return FALSE;
	}

	/*
	* cek kelulusan, dan informasi kelulusan
	*/
	public function kelulusan($data_nilai){
		$soft = 'soft competency';
		$jenis_tes = '';
		$nilai = 0.0;
		$gagal = array();
		$is_lulus = TRUE;
		foreach ($data_nilai as $key => $value) {
			$tes_asses = strtolower($value['id_tes_asses']);
			if($tes_asses!=$soft){
				if($tes_asses!=$jenis_tes){
					$jenis_tes = $tes_asses;
					$nilai += (float) $value['nilai_bobot'];
					//echo $value['rata'].'-'.$value['pass_grade'].'<br/>';
					if($value['nilai']< $value['pass_grade']){

						$gagal[] = $value['id_tes_asses'];
					}
				}
			}
		}
		if(count($gagal)>0) $is_lulus = FALSE;

		$return = array('is_lulus'=>$is_lulus,
						'tes_gagal'=>$gagal,
						'total_nilai'=>$nilai);
		//var_dump($return);
		return $return;
	}

	/*
	* mendapatkan nilai assesment
	* [untuk laporan]
	* @param id assesment
	*/
	public function get_nilai_assesment($id_asses){
		$return = array();
		// TODO
		// dapatkan peserta
		$peserta = new Peserta($this->registry);
		$data = $peserta->get_peserta_assesment($id_asses);
		//id peserta, nama, nip, kantor
		foreach ($data as $key => $value) {
			$return[$value['id']]['id'] = $value['id'];
		 	$return[$value['id']]['nama'] = $value['pegawai'];
		 	$return[$value['id']]['nip'] = $value['nip'];
		 	$return[$value['id']]['kantor'] = $value['unit'];
		 } 
		// jenis tes assesment
		$tesasses = new TesAssesment($this->registry);
		$data_tes_asses = $tesasses->get_join($id_asses);
		foreach ($return as $key => $value) {
			$data = $this->get_nilai_peserta($id_asses,$value['id']);
			
			$tes_asses = '';
			$i=0;
			//data nilai
			foreach ($data as $k => $v) {
				//=============

				$sub_total = 0;
				// TODO cari jumlah HC tidak lulus
				// dan status kelulusan
							
				if($v['id_tes_asses']!=$tes_asses){
					$tes_asses = $v['id_tes_asses'];
					$return[$value['id']]['nilai'][$i] = array();
					$return[$value['id']]['nilai'][$i]['id_tes_asses'] = $v['id_tes_asses'];
					$return[$value['id']]['nilai'][$i]['singkat'] = $v['singkat'];
					$return[$value['id']]['nilai'][$i]['nilai'] = $v['nilai'];
					$return[$value['id']]['nilai'][$i]['bobot_tes'] = $v['bobot_tes'];
					$return[$value['id']]['nilai'][$i]['nilai_bobot'] = $v['nilai_bobot'];
					$return[$value['id']]['nilai'][$i]['pass_grade'] = $v['pass_grade'];
					$lulus = FALSE;
					if((float) $v['nilai']>=(float) $v['pass_grade']) $lulus = TRUE;
					$return[$value['id']]['nilai'][$i]['lulus'] = $lulus;
					//var_dump($return[$value['id']]['nama']);
					//var_dump($return[$value['id']]['nilai'][$i]);
					$i++;
				
				}
								
				//===============
			}


		}
		// join nilai dari sub tes ke jenis tes dan cek passing grade
		// nilai tsb dikalikan bobot jenis tes
		// nilai terbobot dijumlahkan
		// nilai penjumlahan terbobot (HC) kalikan 60% -> fix ditetapkan
		// nilai SC kalikan 40%
		// jumlahkan nilai HC dan SC sebagai nilai akhir
		// simpulkan
		//var_dump($return);
		return $return;
	}

	public function add($data){
		$this->_db->insert($this->_table,$data);
	}

	public function edit($id,$data){
		if(is_array($id)){
			$this->_db->update($this->_table,$data,$id);
		}else{
			$this->_db->update($this->_table,$data,'id='.$id);
		}
	}

	public function remove($id){
		if(is_numeric($id)){
			$this->_db->delete($this->_table,'id='.$id);
		}else{
			$this->_db->delete($this->_table,$id);
		}
	}

	public function remove_nilai_assesment($id_asses,$id_peserta,$id_korektor){
		$sql = 'SELECT a.id as id FROM '.$this->_table.' a
				LEFT JOIN sub_tes b ON a.id_sub_tes = b.id
				LEFT JOIN tes_asses c ON b.id_tes_asses = c.id
				WHERE a.id_peserta='.$id_peserta.' AND 
				a.id_korektor='.$id_korektor.' 
				AND c.id_assesment='.$id_asses;
		$data = $this->_db->select($sql);
		foreach ($data as $key => $value) {
			$this->remove($value['id']);
		}
	}

	public function is_exist($kolom, $value){ //cek lagi
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE '.$kolom.' = "'.$value.'"'));
		if($result>0) return TRUE;
		return FALSE;
	}

	public function is_exist_data($id_peserta, $id_sub_tes, $id_korektor){
		$result = count($this->_db->select('SELECT * FROM '.$this->_table.' WHERE id_peserta='.$id_peserta.' AND id_sub_tes='.$id_sub_tes.' AND id_korektor='.$id_korektor));
		
		if($result>0) return TRUE;
		return FALSE;
	}
}