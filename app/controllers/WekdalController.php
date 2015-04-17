<?php

class WekdalController extends BaseController{

	/*
	* kalendar
	*/
	public function home($year=null,$month=null){
		$kalendar = new Calendar();
		$this->view->kalendar = $kalendar->show($year,$month); 
		$this->view->aksi = 'kalendar';
		$this->view->render('wekdal/kalendar');
	}

	/*
	* list ST
	*/
	public function list_task(){
		$this->view->aksi = 'list_task';
		$this->view->render('wekdal/kalendar');
	}

	/*
	* nambah ST
	*/
	public function add_task($tanggal=null){
		$pegawai = new Pegawai($this->registry);
		$this->view->date = $tanggal;
		$this->view->pegawai = $pegawai->get(); 
		if(isset($_POST{'submit'})){
			$nomor = $_POST['nomor'];
			$mulai = $_POST['mulai'];
			$akhir = $_POST['akhir'];
			$jam_mulai = $_POST['jam_mulai'].':'.$_POST['menit_mulai'].':00';
			$jam_selesai = $_POST['jam_selesai'].':'.$_POST['menit_selesai'].':00';
			$tujuan = $_POST['tujuan'];
			$keperluan = $_POST['tentang'];
			$peserta = $_POST['peserta'];

			$d_mulai = strtotime($mulai);
			$d_akhir = strtotime($akhir);

			if($nomor=='') $this->view->add_error('nomor','kolom nomor harus diisi!');
			if($tujuan=='') $this->view->add_error('tujuan','kolom daerah tujuan harus diisi!');
			if($keperluan=='') $this->view->add_error('tentang','kolom keperluan harus diisi!');
			if($d_mulai>$d_akhir) $this->view->add_error('tanggal','tanggal selesai tidak boleh sebelum tanggal mulai!');

			if(!$this->view->is_error()){
				$data = array(
						'nomor'=>$nomor,
						'tgl_mulai'=>$mulai,
						'tgl_selesai'=>$akhir,
						'jam_mulai'=>$jam_mulai,
						'jam_selesai'=>$jam_selesai,
						'tujuan'=>$tujuan,
						'uraian'=>$keperluan
					);
				$task = new Task($this->registry);
				$task->add($data);
				$id = $task->last_insert_id();
				$p = new PesertaTask($this->registry);
				foreach ($peserta as $key => $value) {
					$data = array('id_pegawai'=>$value,
								'id_task'=>$id
								);
					$p->add($data);
				}
				$this->view->add_success('success','rekam data task/kegiatan berhasil!');
			}
		}
		$this->view->aksi = 'add';
		$this->view->render('wekdal/kalendar');
	}

	/*
	* daftar pegawai dan jadwal satu bulan, per tanggal
	*/
	public function list_pegawai($bulan){
		$this->view->aksi = 'list_pegawai';
		$this->view->render('wekdal/kalendar');
	}
	
}