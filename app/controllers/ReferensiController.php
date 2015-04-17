<?php

class ReferensiController extends BaseController{

	public function __construct($registry){
		parent::__construct($registry);
		$this->view->_set_title = '.:Aplikasi Penghitung Nilai Tes Hard Competency:.';
	}

	public function index(){
		$this->view->render('admin/home');
	}

	/*
	* ref assesment
	*/
	public function assesment(){
		$asses = new Assesment($this->registry);
		$data = $asses->get();
		$this->view->count = count($data);
		$this->view->data = $data;
		$this->view->aksi ='list';
		$this->view->render('admin/assesment');
	}

	public function rekamAssesment(){
		$user = new User($this->registry);
		$this->view->pic = $user->get_join();
		$tahun_skrg = (int) date('Y');
		$this->view->tahun = array();
		for($i=($tahun_skrg-7);$i<=$tahun_skrg;$i++){
			$this->view->tahun[] = $i;
		}
		if(isset($_POST['submit_a'])){
			$assesment = $_POST['assesment'];
			$eselon = $_POST['eselon'];
			$uraian = $_POST['uraian'];
			$pic = $_POST['pic'];
			$tahun = $_POST['tahun'];
			if($assesment=='') $this->view->add_error('assesment','kolom nama Assesment harus diisi!');
			if($eselon==0) $this->view->add_error('eselon','kolom eselon harus dipilih!');
			if($uraian=='') $this->view->add_error('uraian','kolom uraian Assesment harus diisi!');
			if($pic==0) $this->view->add_error('pic','kolom PIC harus dipilih!');
			if($tahun==0) $this->view->add_error('tahun','kolom tahun harus dipilih!');

			if(!$this->view->is_error()){
				$data = array('eselon'=>$eselon,
							'nama_kegiatan'=>$assesment,
							'uraian'=>$uraian,
							'pic'=>$pic,
							'tahun'=>$tahun);
				$assesment = new Assesment($this->registry);
				$assesment->add($data);
				$this->view->add_success('success','rekam data assesment berhasil!');
			}else{
				$this->view->data = array('eselon'=>$eselon,
							'assesment'=>$assesment,
							'uraian'=>$uraian,
							'pic'=>$pic,
							'tahun'=>$tahun);
			}
		}
		$this->view->aksi = 'add';
		$this->view->render('admin/assesment');
	}

	public function ubahAssesment($id){
		$asses = new Assesment($this->registry);
		$data = $asses->get($id);
		$user = new User($this->registry);
		$this->view->pic = $user->get_join();
		$tahun_skrg = (int) date('Y');
		$this->view->tahun = array();
		for($i=($tahun_skrg-7);$i<=$tahun_skrg;$i++){
			$this->view->tahun[] = $i;
		}
		$this->view->data = array('id'=>$data[0]['id'],
							'assesment'=>$data[0]['nama_kegiatan'],
							'eselon'=>$data[0]['eselon'],
							'uraian'=>$data[0]['uraian'],
							'pic'=>$data[0]['pic'],
							'tahun'=>$data[0]['tahun']); 
		if(isset($_POST['submit_e'])){
			$id = $_POST['id'];
			$assesment = $_POST['assesment'];
			$uraian = $_POST['uraian'];
			$eselon = $_POST['eselon'];
			$pic = $_POST['pic'];
			$tahun = $_POST['tahun'];
			if($assesment=='') $this->view->add_error('assesment','kolom nama Assesment harus diisi!');
			if($eselon==0) $this->view->add_error('eselon','kolom eselon harus dipilih!');
			if($uraian=='') $this->view->add_error('uraian','kolom uraian Assesment harus diisi!');
			if($pic==0) $this->view->add_error('pic','kolom PIC harus dipilih!');
			if($tahun==0) $this->view->add_error('tahun','kolom tahun harus dipilih!');

			if(!$this->view->is_error()){
				$data = array('eselon'=>$eselon,
							'nama_kegiatan'=>$assesment,
							'uraian'=>$uraian,
							'pic'=>$pic,
							'tahun'=>$tahun);
				$asses->edit($id, $data);
				$this->view->add_success('success','ubah data assesment berhasil!');
			}
			$this->view->data = array('id'=>$id,
									'assesment'=>$assesment,
									'eselon'=>$eselon,
									'uraian'=>$uraian,
									'pic'=>$pic,
									'tahun'=>$tahun);
			
		}
		$this->view->aksi = 'update';
		$this->view->render('admin/assesment');
	}

	public function hapusAssesment($id){
		$assesment = new Assesment($this->registry);
		$assesment->remove($id);
		header('location:'.URL.'referensi/assesment');
	}

	/*
	* ref jenis tes assesment
	*/
	public function jenisTes(){
		$jnstes = new JenisTes($this->registry);
		$data = $jnstes->get();
		$this->view->count = count($data);
		$this->view->data = $data;
		$this->view->aksi ='list';
		$this->view->render('admin/jenis_tes');
	}

	public function rekamJenisTes(){
		if(isset($_POST['submit_a'])){
			$jenis_tes = new JenisTes($this->registry);
			$jenis = $_POST['jenis'];
			$uraian = $_POST['uraian'];
			$singkat = strtoupper($_POST['singkat']);
			if($jenis=='') $this->view->add_error('jenis','kolom jenis tes harus diisi!');
			if($jenis_tes->is_exist($jenis)) $this->view->add_error('jenis','nama jenis tes ini sudah ada!');
			if($uraian=='') $this->view->add_error('uraian','kolom jenis tes harus diisi!');
			if($singkat=='') $this->view->add_error('singkat','kolom Singkatan harus diisi!');
			if(!$this->view->is_error()){
				$data = array('jenis_tes'=>$jenis,
							'singkat'=>$singkat,
							'uraian'=>$uraian);
				
				$jenis_tes->add($data);
				$this->view->add_success('success','rekam data jenis tes berhasil!');
			}else{
				$this->view->data = array('jenis'=>$jenis,
										'singkat'=>$singkat,
										'uraian'=>$uraian);
			}
		}
	
		$this->view->aksi = 'add';
		$this->view->render('admin/jenis_tes');
	}

	public function ubahJenisTes($id){
		$jenis_tes = new JenisTes($this->registry);
		$data = $jenis_tes->get($id);
		$this->view->data = array('id'=>$data[0]['id'],
							'jenis'=>$data[0]['jenis_tes'],
							'singkat'=>$data[0]['singkat'],
							'uraian'=>$data[0]['uraian']);
		if(isset($_POST['submit_e'])){
			$id = $_POST['id'];
			$jenis = $_POST['jenis'];
			$singkat = $_POST['singkat'];
			$uraian = $_POST['uraian'];
			if($jenis=='') $this->view->add_error('jenis','kolom nama jenis tes harus diisi!');
			if($jenis_tes->is_exist($jenis,$id)) $this->view->add_error('jenis','nama jenis tes ini sudah ada!');
			if($uraian=='') $this->view->add_error('uraian','kolom uraian jenis tes harus diisi!');
			if($singkat=='') $this->view->add_error('singkat','kolom Singkatan harus diisi!');

			if(!$this->view->is_error()){
				$data = array('jenis_tes'=>$jenis,
							'singkat'=>$singkat,
							'uraian'=>$uraian);
				$jenis_tes->edit($id, $data);
				$this->view->add_success('success','ubah data jenis tes berhasil!');
			}
			$this->view->data = array('id'=>$id,
									'jenis'=>$jenis,
									'singkat'=>$singkat,
									'uraian'=>$uraian);
			
		}
		$this->view->aksi = 'update';
		$this->view->render('admin/jenis_tes');
	}

	public function hapusJenisTes($id){
		$jenis_tes = new JenisTes($this->registry);
		$jenis_tes->remove($id);
		header('location:'.URL.'referensi/jenisTes');
	}

	/*
	* ref jenis tes per assesment
	*/
	public function tesAsses($id=null){
		$tesa = new TesAssesment($this->registry);
		$data = $tesa->get_join();
		if(!is_null($id)){
			$data = $tesa->get_join($id);
			$this->view->id_asses = $id; 
		}
		$this->view->count = count($data);
		$this->view->data = $data;
		$this->view->aksi ='list';
		$this->view->render('admin/tes_asses');
	}

	public function rekamTesAsses($id=null){
		if(!is_null($id)) $this->view->id_asses = $id;
		$asses = new Assesment($this->registry);
		$jenis_tes = new JenisTes($this->registry);
		$metode = new MetodePenilaian($this->registry);
		$this->view->data_asses = $asses->get(); //var_dump($this->view->data_asses);
		$this->view->data_jenis_tes = $jenis_tes->get();
		$this->view->metode = $metode->get(); 
		$this->view->judul = 'Rekam Jenis Tes Assesment';
		if(isset($_POST['submit_a'])){
			$tesa = new TesAssesment($this->registry);
			$assesment = $_POST['assesment'];
			$jenis = $_POST['jenis'];
			$pass_grade = $_POST['pass_grade'];
			$metode = $_POST['metode'];
			$bobot = $_POST['bobot'];
			if($assesment==0) $this->view->add_error('assesment','kolom assesment harus dipilih!');
			if($jenis==0) $this->view->add_error('jenis','kolom jenis tes harus dipilih!');
			if($tesa->is_exist($assesment,$jenis)) $this->view->add_error('jenis','data tes ini sudah ada di database!');
			if($pass_grade=='') $this->view->add_error('pass_grade','kolom passing grade harus diisi!');
			if(!is_numeric($pass_grade)) $this->view->add_error('pass_grade','kolom passing grade harus angka atau desimal!');
			if($metode==0) $this->view->add_error('metode','kolom metode penilaian harus dipilih!');
			if($bobot=='') $this->view->add_error('bobot','kolom passing grade harus diisi!');
			if(!is_numeric($bobot)) $this->view->add_error('bobot','kolom passing grade harus angka !');
			if(!$this->view->is_error()){
				$data = array('id_assesment'=>$assesment,
							'id_jenis_tes'=>$jenis,
							'pass_grade'=>$pass_grade,
							'bobot'=>$bobot,
							'metode'=>$metode);
				
				$tesa->add($data);
				$this->view->add_success('success','rekam data jenis tes assesment berhasil!');
			}else{
				$this->view->data = array('assesment'=>$assesment,
										'jenis'=>$jenis,
										'pass_grade'=>$pass_grade,
										'bobot'=>$bobot,
										'metode'=>$metode);
			}
		}
	
		$this->view->aksi = 'add';
		$this->view->render('admin/tes_asses');
	}

	public function ubahTesAsses($id){
		$asses = new Assesment($this->registry);
		$jenis_tes = new JenisTes($this->registry);
		$metode = new MetodePenilaian($this->registry);
		$this->view->metode = $metode->get(); 
		$this->view->data_asses = $asses->get();
		$this->view->data_jenis_tes = $jenis_tes->get();
		$tesa = new TesAssesment($this->registry);
		$data = $tesa->get($id); 
		$this->view->data = array('id'=>$data[0]['id'],
							'assesment'=>$data[0]['id_assesment'],
							'jenis'=>$data[0]['id_jenis_tes'],
							'pass_grade'=>$data[0]['pass_grade'],
							'bobot'=>$data[0]['bobot'],
							'metode'=>$data[0]['metode']);
		$this->view->judul = 'Ubah Jenis Tes Assesment';
		if(isset($_POST['submit_e'])){
			$id = $_POST['id'];
			$assesment = $_POST['assesment'];
			$jenis = $_POST['jenis'];
			$pass_grade = $_POST['pass_grade'];
			$metode = $_POST['metode'];
			$bobot = $_POST['bobot'];
			if($assesment==0) $this->view->add_error('assesment','kolom assesment harus dipilih!');
			if($jenis==0) $this->view->add_error('jenis','kolom jenis tes harus dipilih!');
			if($tesa->is_exist($assesment,$jenis,$id)) $this->view->add_error('jenis','data tes ini sudah ada di database!');
			if($pass_grade=='') $this->view->add_error('pass_grade','kolom passing grade harus diisi!');
			if(!is_numeric($pass_grade)) $this->view->add_error('pass_grade','kolom passing grade harus angka atau desimal!');
			if($metode==0) $this->view->add_error('metode','kolom metode penilaian harus dipilih!');
			if($bobot=='') $this->view->add_error('bobot','kolom passing grade harus diisi!');
			if(!is_numeric($bobot)) $this->view->add_error('bobot','kolom passing grade harus angka !');

			if(!$this->view->is_error()){
				$data = array('id_assesment'=>$assesment,
							'id_jenis_tes'=>$jenis,
							'pass_grade'=>$pass_grade,
							'bobot'=>$bobot,
							'metode'=>$metode);
				$tesa = new TesAssesment($this->registry);
				$tesa->edit($id,$data);
				$this->view->add_success('success','ubah data jenis tes assesment berhasil!');
			}
			$this->view->data = array('id'=>$id,
										'assesment'=>$assesment,
										'jenis'=>$jenis,
										'pass_grade'=>$pass_grade,
										'bobot'=>$bobot,
										'metode'=>$metode);
			
		}
		$this->view->aksi = 'update';
		$this->view->render('admin/tes_asses');
	}

	public function hapusTesAsses($id){
		$tesa = new TesAssesment($this->registry);
		$tesa->remove($id);
		header('location:'.URL.'referensi/tesAsses');
	}

	/*
	* ref pegawai
	*/
	public function pegawai(){
		$pegawai = new Pegawai($this->registry);
		$data = $pegawai->get();
		$this->view->count = count($data);
		$this->view->data = $data;
		$this->view->aksi ='list';
		$this->view->render('admin/pegawai');
	}

	public function rekamPegawai(){
		if(isset($_POST['submit_a'])){
			$pegawai = new Pegawai($this->registry);
			$nip = $_POST['nip'];
			$nama = $_POST['nama'];
			$es = $_POST['eselon'];
			if($nip=='') $this->view->add_error('nip','kolom nip harus diisi!');
			if($pegawai->is_exist('nip',$nip)) $this->view->add_error('nip','pegawai ini telah ada di database!');
			if(!is_numeric($nip)) $this->view->add_error('nip','nip harus diisi dengan angka!');
			if($nama=='') $this->view->add_error('nama','kolom nama harus diisi!');
			//if(!ctype_alpha(trim(str_replace(' ', '', $nama)))) $this->view->add_error('nama','nama harus diisi dengan karakter alphabetic!');
			if($es==0) $this->view->add_error('eselon','kolom eselon harus dipilih!');
			
			if(!$this->view->is_error()){
				$data = array('nip'=>$nip,
							'nama'=>$nama,
							'eselon'=>$es);
				
				$pegawai->add($data);
				$this->view->add_success('success','rekam data pegawai berhasil!');
			}else{
				$this->view->data = array('nip'=>$nip,
										'nama'=>$nama,
										'eselon'=>$es);
			}
		}
	
		$this->view->aksi = 'add';
		$this->view->render('admin/pegawai');
	}

	public function ubahPegawai($id){
		$pegawai = new Pegawai($this->registry);
		$data = $pegawai->get($id);
		$this->view->data = array('id'=>$data[0]['id'],
							'nip'=>$data[0]['nip'],
							'nama'=>$data[0]['nama'],
							'eselon'=>$data[0]['eselon']);
		if(isset($_POST['submit_e'])){
			$id = $_POST['id'];
			$nip = $_POST['nip'];
			$nama = $_POST['nama'];
			$es = $_POST['eselon'];
			if($nip=='') $this->view->add_error('nip','kolom nip harus diisi!');
			if($pegawai->is_exist('nip',$nip,$id)) $this->view->add_error('nip','pegawai ini telah ada di database!');
			if(!is_numeric($nip)) $this->view->add_error('nip','nip harus diisi dengan angka!');
			if($nama=='') $this->view->add_error('nama','kolom nama harus diisi!');
			//if(!ctype_alpha(trim(str_replace(' ', '', $nama)))) $this->view->add_error('nama','nama harus diisi dengan karakter alphabetic!');
			if($es==0) $this->view->add_error('eselon','kolom eselon harus dipilih!');

			if(!$this->view->is_error()){
				$data = array('nip'=>$nip,
							'nama'=>$nama,
							'eselon'=>$es); 
				$pegawai->edit($id,$data);
				$this->view->add_success('success','ubah data pegawai berhasil!');
			}
			$this->view->data = array('id'=>$id,
										'nip'=>$nip,
										'nama'=>$nama,
										'eselon'=>$es);
			
		}
		$this->view->aksi = 'update';
		$this->view->render('admin/pegawai');
	}

	public function hapusPegawai($id){
		$pegawai = new Pegawai($this->registry);
		$pegawai->remove($id);
		header('location:'.URL.'referensi/pegawai');
	}

	/*
	| upload data pegawai
	| format csv
	| format data id(nomor urut), nip, nama, eselon
	*/
	public function uploadDataCsv(){

		if(isset($_POST['submit_a'])){ 
			$file = $_FILES['file'];
			$name = $_FILES['file']['name'];
			$tmp_name = $_FILES['file']['tmp_name'];
			$type = $_FILES['file']['type'];
			$size = $_FILES['file']['size'];
			$ext = explode('.', $name);
			if($type!='application/vnd.ms-excel' && $ext!=end($ext)) $this->view->add_error('file','file harus dalam format .csv');
			if($size>30000000) $this->view->add_error('file','ukuran file maksimal 30 MB ya!');

			if(!$this->view->is_error()){
				$pegawai = new Pegawai($this->registry); 
				$destination = 'files/'.$name;
				move_uploaded_file($tmp_name, $destination);
				$d_peg = CSV::readCSV($destination);//var_dump($d_peg);
				foreach ($d_peg as $key => $value) {
					//validasi data dengan validasi nip
					$nip = $value[1];
					/*$is_angka = is_numeric($nip); 
					if(!$is_angka) continue; //jika bukan angka
					$len = strlen($nip);
					if($len!=18 && $len!=6) continue; //jika panjang bukan 18 atau 6
					$nip_th_lhr = (int) substr($nip, 0,4);
					if($nip_th_lhr<(date('Y')-60) || $nip_th_lhr>(date('Y')-18)) continue; //jika umur gak sesuai
					$nip_th_masuk = (int) substr($nip, 7,4); 
					if($nip_th_masuk<(date('Y')-40)) continue; //jika tahun masuk > 40
					$nip_jk = (int) substr($nip, 14,1);
					if($nip_jk>2 || $nip_jk<1) continue; //jika gender bukan 1 atau 2, tidak menerima gender ke-3 :)*/
					//end of validasi data
					if($pegawai->is_exist('nip',$value[1])){
						$data = array('nama'=>$value[2],
									'eselon'=>$value[3],
									'jabatan'=>$value[4],
									'unit'=>$value[5]);
						$pegawai->edit('nip='.$value[1],$data);
					}else{
						$data = array('nip'=>$value[1],
									'nama'=>$value[2],
									'eselon'=>$value[3],
									'jabatan'=>$value[4],
									'unit'=>$value[5]);
						$pegawai->add($data);
					}
				}
				unlink($destination);
				$this->view->add_success('success', 'update data pegawai berhasil!');
			}
		}
		$this->view->aksi = 'csv';
		$this->view->render('admin/pegawai');
	}

	/*
	* ref user
	*/
	public function user(){
		$user = new User($this->registry);
		$data = $user->get_join();
		$this->view->count = count($data);
		$this->view->data = $data;
		$this->view->aksi ='list';
		$this->view->render('admin/user');
	}

	public function rekamUser(){
		$pegawai = new Pegawai($this->registry);
		$this->view->data_peg = $pegawai->get();
		if(isset($_POST['submit_a'])){
			$user = new User($this->registry);
			$peg = $_POST['pegawai'];
			$nama = $_POST['nama'];
			$pass = $_POST['pass'];
			$role = $_POST['role'];
			if($peg==0) $this->view->add_error('pegawai','kolom pegawai harus dipilih!');
			if($nama=='') $this->view->add_error('nama','kolom nama harus diisi!');
			if($user->is_exist('nama_user',$nama)) $this->view->add_error('nama','nama user ini sudah kepake!');
			if($pass=='') $this->view->add_error('pass','kolom password harus diisi!');
			if($role==0) $this->view->add_error('role','kolom role harus dipilih!');
			
			if(!$this->view->is_error()){
				$data = array('id_pegawai'=>$peg,
							'nama_user'=>$nama,
							'password'=>Hash::create('sha1', $pass, HASH_SALT_KEY),
							'role'=>$role);
				$user->add($data);
				$this->view->add_success('success','rekam data user berhasil!');
			}else{
				$this->view->data = array('id_pegawai'=>$peg,
										'nama'=>$nama,
										'pass'=>$pass,
										'role'=>$role);
			}
		}
	
		$this->view->aksi = 'add';
		$this->view->render('admin/user');
	}

	public function ubahUser($id){
		$pegawai = new Pegawai($this->registry);
		$this->view->data_peg = $pegawai->get();
		$user = new User($this->registry);
		$data = $user->get($id);
		$this->view->data = array('id'=>$data[0]['id'],
							'id_pegawai'=>$data[0]['id_pegawai'],
							'nama'=>$data[0]['nama_user'],
							'pass'=>$data[0]['password'],
							'role'=>$data[0]['role']); 
		if(isset($_POST['submit_e'])){
			$peg = $_POST['pegawai'];
			$nama = $_POST['nama'];
			$pass = $_POST['pass'];
			$role = $_POST['role'];
			if($peg==0) $this->view->add_error('pegawai','kolom pegawai harus dipilih!');
			if($nama=='') $this->view->add_error('nama','kolom nama harus diisi!');
			if($user->is_exist('nama_user',$nama,$id)) $this->view->add_error('nama','nama user ini sudah kepake!');
			if($pass=='') $this->view->add_error('pass','kolom password harus diisi!');
			if($role==0) $this->view->add_error('role','kolom role harus dipilih!');

			if(!$this->view->is_error()){
				$data = array('id_pegawai'=>$peg,
							'nama_user'=>$nama,
							'password'=>Hash::create('sha1', $pass, HASH_SALT_KEY),
							'role'=>$role); 
				$user->edit($id,$data);
				$this->view->add_success('success','ubah data user berhasil!');
			}
			$this->view->data = array('id'=>$id,
										'id_pegawai'=>$peg,
										'nama'=>$nama,
										'pass'=>$pass,
										'role'=>$role);
			
		}
		$this->view->aksi = 'update';
		$this->view->render('admin/user');
	}

	public function hapusUser($id){
		$user = new User($this->registry);
		$user->remove($id);
		header('location:'.URL.'referensi/user');
	}
}