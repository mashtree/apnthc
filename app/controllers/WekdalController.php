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
				$array = 0;
				foreach ($peserta as $key => $value) {
					$t_mulai = ($_POST['pmulai'][$array]=='')?$mulai:$_POST['pmulai'][$array];
					$t_akhir = ($_POST['pakhir'][$array]=='')?$akhir:$_POST['pakhir'][$array];
					$data = array('id_pegawai'=>$value,
								'id_task'=>$id,
								'tgl_mulai'=>$t_mulai,
								'tgl_selesai'=>$t_akhir
								);
					$p->add($data);
					$array++;
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
	public function pegawai($bulan=null){
		if(is_null($bulan)) $bulan = date('Y-m');
		$peserta = new PesertaTask($this->registry); 
		$data = $peserta->get_peserta_bulan($bulan); var_dump($data);
		$this->view->aksi = 'list_pegawai';
		$this->view->render('wekdal/kalendar');
	}

	/*
	* daftar kegiatan
	*/
	public function kegiatan($bulan=null){
		if(is_null($bulan)) $bulan = date('Y-m');
		$this->view->aksi = 'list_kegiatan';
		$this->view->render('wekdal/kalendar');
	}
	
}