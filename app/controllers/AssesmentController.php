<?php

class AssesmentController extends BaseController{

	public function __construct($registry){
		parent::__construct($registry);
		$this->view->_set_title = '.:Aplikasi Penghitung Nilai Tes Hard Competency:.';
	}

	public function index(){
		$this->view->render('assesment/home');
	}

	public function assesment(){
		$assesment = new Assesment($this->registry);
		$data = $assesment->get();
		$this->view->data = $data;
		$this->view->count = count($data); 
		$this->view->render('assesment/assesment');
	}

	/*
	 * peserta
	 */

	public function peserta($id){
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id);
		$this->view->data_asses = $data;
		$peserta = new Peserta($this->registry);
		$data = $peserta->get_peserta_assesment($id);
		$this->view->data = $data;
		$this->view->count = count($data);
		$this->view->id_asses = $id;
		$this->view->aksi = 'list'; 
		$this->view->render('assesment/peserta');
	}

	/*
	* rekam peserta
	* @param id assesment
	*/
	public function rekamPeserta($id){
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id);
		$pegawai = new Pegawai($this->registry);
		$this->view->pegawai_for_peserta = $pegawai->get_for_peserta($data[0]['eselon']); //var_dump($this->view->pegawai_for_peserta);
		$this->view->pegawai_sijon = $pegawai->pegawai_to_json($data[0]['eselon'],'peserta');
		$peserta = new Peserta($this->registry);
		if(isset($_POST['submit_a'])){
			foreach ($$_POST['peserta'] as $key => $value) {
				if($peserta->is_exist('id_pegawai',$value)) $this->view->add_error('peserta','cek kembali! ada yang telah terekam');
			}

			if(!$this->view->is_error()){
				foreach ($_POST['peserta'] as $key => $value) {
					$data = array('id_pegawai'=>$value,'id_assesment'=>$id);
					$peserta->add($data);
				}
			}
			header('location:'.URL.'assesment/peserta/'.$id);
		}
		$this->view->id_asses = $id;
		$this->view->aksi = 'add'; 
		$this->view->render('assesment/peserta');
	}

	/*
	* menampilkan halaman korektor per assesment untuk perekaman nilai
	* @param id assesment, id peserta, eselon
	*/
	public function korektorNilai($id_asses,$id_pegawai,$eselon){
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id_asses); 
		$this->view->data_asses = $data;
		$peserta = new Peserta($this->registry);
		$data = $peserta->get_peserta_assesment($id_asses,$id_pegawai); 
		$this->view->data_peserta = $data;
		$korektor = new Korektor($this->registry);
		$data = $korektor->get_korektor_assesment($id_asses);
		$this->view->count = count($data);
		$this->view->data_korektor = $data;
		$this->view->id_asses = $id_asses;
		$this->view->id_pegawai = $id_pegawai;
		$this->view->eselon = $eselon;
		$this->view->aksi = 'korektor';
		$this->view->render('assesment/peserta');
	}

	/*
	* rekam nilai,
	* @param id assesment, id pegawai peserta assesment, eselon, id korektor 
	*/
	public function rekamNilai($id_asses,$id_pegawai,$eselon,$id_korektor){
		$korektor = new Korektor($this->registry);
		$data = $korektor->get($id_korektor);
		$pegawai = new Pegawai($this->registry);
		$data = $pegawai->get($data[0]['id_pegawai']);
		$this->view->data_korektor = $data;
		$this->view->id_korektor = $id_korektor;
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id_asses);
		$this->view->data_asses = $data;
		$jenis_tes_asses = new JenisTesAssesment($this->registry);
		$data = $jenis_tes_asses->form_data($id_asses);  //var_dump($data);
		$this->view->data_form = $data; 
		$peserta = new Peserta($this->registry);
		$data = $peserta->get_peserta_assesment($id_asses,$id_pegawai); 
		$this->view->data_peserta = $data;//var_dump($data);
		if(isset($_POST['submit_a'])){
			$data_input = array();
			foreach ($this->view->data_form as $key => $value) {
				$data_input[$value['kode']] = array($value['id_sub_tes'],$_POST[$value['kode']]);
				if($_POST[$value['kode']]==''){
					$this->view->add_error($value['kode'], 'kolom ini harus diisi!'); 
				}else if(!is_numeric($_POST[$value['kode']])) {
					$this->view->add_error($value['kode'], 'kolom ini harus angka atau desimal!');
				}else if(((float) $_POST[$value['kode']])>100){
					$this->view->add_error($value['kode'], 'nilai maksimal hanya 100.00!');
				}
			}
			
			if(!$this->view->is_error()){
				foreach ($data_input as $key => $value) {
					$data = array('id_peserta'=>$this->view->data_peserta[0]['id'],
									'id_sub_tes'=>$value[0],
									'nilai'=>$value[1],
									'id_korektor'=>$id_korektor);
					$nilaites = new NilaiTes($this->registry);
					if($nilaites->is_exist_data($data['id_peserta'],$data['id_sub_tes'], $id_korektor)){
						$where = array('id_peserta='.$data['id_peserta'],'id_sub_tes='.$data['id_sub_tes'], 'id_korektor='.$id_korektor);
						$nilaites->edit($where, $data);
					}else{
						$nilaites->add($data);	
					}
					
					$this->view->add_success('success', 'rekam data nilai berhasil!');
				}
			}else{
				//var_dump($this->view->get_error());
				$this->view->data = $data_input;
				//var_dump($this->view->data);
			}
		}
		$this->view->id_asses = $id_asses;
		$this->view->id_pegawai = $id_pegawai;
		$this->view->eselon = $eselon; //var_dump($this->view->eselon);
		$this->view->aksi = 'nilai'; //var_dump($this->view->aksi);
		$this->view->render('assesment/peserta');
	}

	/*
	* hapus nilai peserta per korektor per assesment
	* @param id peserta, id assesment, id korektor
	*/
	public function hapusNilaiPeserta($id_assesment, $id_peserta, $id_korektor){
		$nilai = new NilaiTes($this->registry);
		$nilai->remove_nilai_assesment($id_assesment, $id_peserta, $id_korektor);
		header('location:'.URL.'assesment/dataPeserta/'.$id_assesment.'/'.$id_peserta);
	}

	/*
	* data peserta pada assesment yang bersangkutan, menampilkan informasi assesment, nilai per korektor, 
	* nilai total, status kelulusan
	* @param id peserta, id assesment
	*/
	public function dataPeserta($id_asses, $id_peserta){
		$assesment = new Assesment($this->id_asses);
		$data = $assesment->get($id_asses);
		$this->view->data_asses = $data;
		$korektor = new Korektor($this->registry);
		$data = $korektor->get_korektor_peserta($id_asses, $id_peserta);
		$this->view->data_korek = $data;
		$this->view->num_korektor = count($data);
		$peserta = new Peserta($this->registry);
		$data = $peserta->get($id_peserta);
		$id_pegawai = $data[0]['id_pegawai'];
		$data = $peserta->get_peserta_assesment($id_asses,$id_pegawai); 
		$this->view->data_peserta = $data;
		$nilai_tes = new NilaiTes($this->registry);
		if($nilai_tes->is_exist_nilai($id_asses, $id_peserta)){
			$data = $nilai_tes->get_nilai_peserta($id_asses, $id_peserta);
			$this->view->nilai_tes = $data; //var_dump($data);
			$this->view->count = count($data);
			$data = $nilai_tes->kelulusan($data);
			$this->view->kelulusan = $data;
		}else{
			$this->view->count = 0;
		}

		//join assesment, nilai trus diproses atau
		//get data assesment

		$this->view->aksi = 'data';
		$this->view->render('assesment/peserta');
	}

	/*
	* hapus data peserta assesment
	* @param id assesment, id pegawai
	*/
	public function hapusPeserta($id_asses,$id_pegawai){
		$peserta = new Peserta($this->registry);
		$peserta->remove($id_pegawai);
		header('location:'.URL.'assesment/peserta/'.$id_asses);
	}

	/*
	* mengambil data pegawai keseluruhan return json
	* untuk rekam peserta
	* @param -
	*/
	public function get_pegawai(){
		$pegawai = new Pegawai($this->registry);
		$data = $pegawai->get();
		echo json_encode($data);
	}

	/*
	* menampilkan korektor per assesment
	* @param id assesment
	*/
	public function korektor($id){
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id);
		$this->view->data_asses = $data;
		$korektor = new Korektor($this->registry);
		$data = $korektor->get_korektor_assesment($id);
		$this->view->data = $data;
		$this->view->count = count($data);
		$this->view->id_asses = $id;
		$this->view->aksi = 'list'; 
		$this->view->render('assesment/korektor');
	}

	/*
	* rekam korektor per assesment
	* @param id assesment
	*/
	public function rekamKorektor($id){
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id);
		$this->view->data_asses = $data;
		$pegawai = new Pegawai($this->registry);
		$this->view->pegawai_for_peserta = $pegawai->get_for_korektor($data[0]['eselon']);
		$this->view->pegawai_sijon = $pegawai->pegawai_to_json($data[0]['eselon'],'korektor');
		$peserta = new Korektor($this->registry);
		if(isset($_POST['submit_a'])){
			foreach ($_POST['korektor'] as $key => $value) {
				if($peserta->is_exist($value, $id)) $this->view->add_error('korektor','cek kembali! korektor ini sudah ada!');
			}
			if(!$this->view->is_error()){
				foreach ($_POST['korektor'] as $key => $value) {
					if($value!=0 && $value!=''){
						$data = array('id_pegawai'=>$value,'id_assesment'=>$id);
						$peserta->add($data);
					}
				}
			}
			header('location:'.URL.'assesment/korektor/'.$id);
		}
		$this->view->id_asses = $id;
		$this->view->aksi = 'add'; 
		$this->view->render('assesment/korektor');
	}

	/*
	* ubah korektor
	* @param id korektor
	*/
	public function ubahKorektor($id){
		$pegawai = new Pegawai($this->registry);
		$this->view->pegawai_for_peserta = $pegawai->get();
		$korektor = new Korektor($this->registry);
		$data = $korektor->get($id);
		$this->view->data = array('id'=>$data[0]['id'],
								'id_pegawai'=>$data[0]['id_pegawai'],
								'id_assesment'=>$data[0]['id_assesment']); 
		$id_assesment = $data[0]['id_assesment'];
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id_assesment);
		$this->view->data_asses = $data; 
		if(isset($_POST['submit_e'])){
			$id_korektor = $_POST['id'];
			$korek = $_POST['korektor'][0];
			if($korek==0) $this->view->add_error('korektor', 'kolom korektor harus dipilih!');
			if($korektor->is_exist($korek,$this->view->data_asses[0]['id'],$id)) $this->view->add_error('korektor', 'korektor ini sudah ada!');
			if(!$this->view->is_error()){
				$data = array('id_pegawai'=>$korek); 
				$korektor->edit($id_korektor,$data);
				
				header('location:'.URL.'assesment/korektor/'.$this->view->data['id_assesment']);
			}else{
				$this->view->data = array('id'=>$id_korektor,'korektor'=>$korek, 'id_assesment'=>$this->view->data['id_assesment']);
			}
		}
		$this->view->aksi = 'edit'; 
		$this->view->render('assesment/korektor');
	}

	/*
	* hapus korektor per assesment
	* @param id assesment, id korektor
	*/
	public function hapusKorektor($id_asses,$id_korektor){
		$korektor = new Korektor($this->registry);
		$korektor->remove($id_korektor);
		header('location:'.URL.'assesment/korektor/'.$id_asses);
	}

	/*
	* menampilkan jenis tes per assesment
	* @param id assesment
	*/
	public function jenistes($id){
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id);
		$this->view->data_asses = $data;
		$jenistes = new JenisTesAssesment($this->registry);
		$data = $jenistes->get_jenis_tes_assesment($id);
		$this->view->data = $data;
		$this->view->count = count($data);
		$this->view->id_asses = $id;
		$this->view->judul = 'Daftar Jenis Tes Assesment';
		$this->view->aksi = 'list'; 
		$this->view->render('assesment/jenistes');
	}

	/*
	* rekam jenis tes per assesment
	* @param id assesment
	*/
	public function rekamJenisTes($id){
		$jenistes = new TesAssesment($this->registry);
		$this->view->data_jenis_tes = $jenistes->get_jenis_tes($id);
		$jenistesasses = new JenisTesAssesment($this->registry);
		//var_dump($this->view->data_jenis_tes);
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id);
		$this->view->data_asses = $data;
		$peserta = new Korektor($this->registry);
		if(isset($_POST['submit_a'])){
			$jenis = $_POST['jenis_tes'];
			$sub_tes = $_POST['sub_tes'];
			$bobot = $_POST['bobot'];
			$kode = strtolower($_POST['kode']);
			$v = 0;
			if($bobot==''){
				$bobot = JenisTesAssesment::get_bobot($this->registry, $jenis);
				$x++;
			}
			if($jenis==0) $this->view->add_error('jenis_tes','kolom jenis tes harus dipilih!');
			if($sub_tes=='') $this->view->add_error('sub_tes','kolom sub tes harus diisi!');
			if($bobot!=''){
				if(!is_numeric($bobot)) $this->view->add_error('bobot','kolom bobot harus angka!');
			}
			if($kode=='') $this->view->add_error('kode','kolom kode harus diisi!');
			if($jenistesasses->is_exist($jenis,$sub_tes)) $this->view->add_error('sub_tes','nama tes ini sudah ada!');

			if(!$this->view->is_error()){
				$data = array('id_tes_asses'=>$jenis,
							'nama_sub_tes'=>$sub_tes, 
							'bobot'=>$bobot,
							'kode'=>$kode);
				$jenistesasses->add($data);
				if($x>0){
					//echo 'benar';
					$edit = array('bobot'=>$bobot);
					$jenistesasses->edit_where($edit,'id_tes_asses='.$jenis);
				}
				$this->view->add_success('success','rekam data jenis tes assesment berhasil!');
				//header('location:'.URL.'assesment/jenistes/'.$id);
			}else{
				$this->view->data = array('id_jenis_tes'=>$jenis,
										'sub_tes'=>$sub_tes,
										'bobot'=>$bobot,
										'kode'=>$kode);
			}
		}
		$this->view->judul = 'Rekam Jenis Tes Assesment';
		$this->view->id_asses = $id;
		$this->view->aksi = 'add'; 
		$this->view->render('assesment/jenistes');
	}

	/*
	* ubah jenis tes assesment
	* @param id jenis tes assesment dan id assesment
	* BELUM SELESAI
	*/
	public function ubahJenisTes($id, $id_asses){
		$this->view->id_asses = $id_asses;
		$jenistesasses = new JenisTesAssesment($this->registry);
		$data = $jenistesasses->get($id);
		$this->view->data = array('id'=>$data[0]['id'],
										'id_jenis_tes'=>$data[0]['id_tes_asses'],
										'sub_tes'=>$data[0]['nama_sub_tes'],
										'bobot'=>$data[0]['bobot'],
										'kode'=>$data[0]['kode']);
		$jenistes = new TesAssesment($this->registry);
		$this->view->data_jenis_tes = $jenistes->get_jenis_tes($id_asses);
		
		//var_dump($this->view->data_jenis_tes);
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id);
		$this->view->data_asses = $data;
		$peserta = new Korektor($this->registry);
		if(isset($_POST['submit_e'])){
			$id = $_POST['id'];
			$jenis = $_POST['jenis_tes'];
			$sub_tes = $_POST['sub_tes'];
			$bobot = $_POST['bobot'];
			$kode = strtolower($_POST['kode']);
			$v = 0;
			if($bobot==''){
				$bobot = JenisTesAssesment::get_bobot($this->registry, $jenis);
				$x++;
			}
			if($jenis==0) $this->view->add_error('jenis_tes','kolom jenis tes harus dipilih!');
			if($sub_tes=='') $this->view->add_error('sub_tes','kolom sub tes harus diisi!');
			if($bobot!=''){
				if(!is_numeric($bobot)) $this->view->add_error('bobot','kolom bobot harus angka!');
			}
			if($kode=='') $this->view->add_error('kode','kolom kode harus diisi!');
			if($jenistesasses->is_exist($jenis,$sub_tes, $id)) $this->view->add_error('sub_tes','nama tes ini sudah ada!');

			if(!$this->view->is_error()){
				$data = array('id_tes_asses'=>$jenis,
							'nama_sub_tes'=>$sub_tes, 
							'bobot'=>$bobot,
							'kode'=>$kode);
				$jenistesasses->edit($id,$data);
				if($x>0){
					//echo 'benar';
					$edit = array('bobot'=>$bobot);
					$jenistesasses->edit_where($edit,'id_tes_asses='.$jenis);
				}
				$this->view->add_success('success','rekam data jenis tes assesment berhasil!');
				//tampilin data lagi
				//header('location:'.URL.'assesment/jenistes/'.$id);
			}else{
				$this->view->data = array('id'=>$id,
										'id_jenis_tes'=>$jenis,
										'sub_tes'=>$sub_tes,
										'bobot'=>$bobot,
										'kode'=>$kode);
			}
		}
		$this->view->judul = 'Ubah Jenis Tes Assesment';
		$this->view->aksi = 'edit'; 
		$this->view->render('assesment/jenistes');
	}

	/*
	* hapus jenis tes assesment
	* @param id assesment, id jenis tes assesment
	*/
	public function hapusJenistes($id_asses,$id_jenis_tes){
		$jenis = new JenisTesAssesment($this->registry);
		$jenis->remove($id_jenis_tes);
		header('location:'.URL.'assesment/jenistes/'.$id_asses);
	}

	/*
	* menampilkan laporan assesment
	* @param id assesment
	*/
	public function laporan($id_asses){
		$assesment = new Assesment($this->registry);
		$data = $assesment->get($id_asses); 
		$this->view->data_asses = $data;
		$tesasses = new TesAssesment($this->registry);
		$data = $tesasses->get_join($id_asses);
		$this->view->data_jenis_tes_asses = $data; 
		$this->view->jumlah_jenis_tes_asses = count($data);
		$nilaites = new NilaiTes($this->registry);
		$data = $nilaites->get_nilai_assesment($id_asses); //var_dump($data);
		$this->view->data = $data;
		$this->view->jumlah_data = count($data);
		$this->view->aksi = 'report'; 
		$this->view->render('assesment/laporan');
	}

}