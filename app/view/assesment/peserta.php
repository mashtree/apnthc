<div class="units-row">
<div class="units-row" >
<div class="large-2 columns side-menu" >
	<?php $this->load('assesment/menu');?>
</div>
<?php if($this->aksi=='add'){ ?>
<!-- form rekam / ubah -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'>Rekam Peserta Assesment</h3>
<p>Kegiatan : <?php echo $this->data_asses[0]['nama_kegiatan'];?></p>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<form method="post" action="<?php echo URL;?>assesment/rekamPeserta/<?php echo $this->id_asses;?>">
	<?php 
    	if(isset($this->error['peserta'])){
			echo '<div class="warning error">'.$this->error['peserta'].'</div>';
		}
    ?>
	<div class="input_fields_wrap">
    <div><select name="peserta[]"><option value=0>--PILIH PESERTA--</option>
    	<?php 
    		foreach ($this->pegawai_for_peserta as $key => $value) {
    			echo "<option value=".$value['id'].">".$value['nama']." ".$value['nip']."</option>";
    		}
    	?>
    </select></div>
	</div>
	<button class="add_field_button" title="tambah kolom lagiii...">+</button>
	<input class="button medium" type='submit' name='submit_a' value='SIMPAN'>
</form>
</div>
<div class="large-2 columns"></div>

<!-- end of form -->
<?php }elseif ($this->aksi=='list'){ ?>
<!-- table of assesment -->
<div class="large-10 columns list" >
<h3>Daftar Peserta Assesment</h3>
<p>Kegiatan : <?php echo $this->data_asses[0]['nama_kegiatan'];?></p>
<a href="<?php echo URL;?>assesment/rekamPeserta/<?php echo $this->data_asses[0]['id'];?>"><button class="button small">Rekam</button></a>
<table id="t_peserta">
	<thead>
		<th>No</th>
		<th>NIP</th>
		<th>Nama</th>
		<th>Nilai SC</th>
		<th>Nilai HC</th>
		<th>Aksi</th>
	</thead>
	<tbody>
	<?php if($this->count>0){
		$no = 0;
		foreach ($this->data as $key => $value) {
			echo "<tr>";
			echo "<td>".++$no."</td>";
			echo "<td>".$value['nip']."</td>";
			echo "<td class='text-left'>".$value['pegawai']."</td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td><a href=".URL."assesment/korektorNilai/".$this->id_asses."/".$value['id_pegawai']."/".$this->data_asses[0]['eselon']."><i class='step fi-graph-pie size-24' title='rekam nilai'></i></a> | 
					<a href=".URL."assesment/dataPeserta/".$this->id_asses.'/'.$value['id']."><i class='step fi-graph-bar size-24' title='peserta'></i></a> |  
					<a href=".URL."assesment/hapusPeserta/".$this->id_asses.'/'.$value['id']." onclick=\"return rdelete('peserta');\"><i class='step fi-trash size-24' title='hapus'></i></a>";
			echo "</tr>"; 	
		} 
	}else{ ?>
		<tr>
			<td colspan="5" class="no-data">DATA TIDAK DITEMUKAN</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#t_peserta').dataTable();
	} );
</script>
</div>
<!-- end of table -->

<?php }elseif ($this->aksi=='nilai') { ?>
<!-- form rekam nilai non esmelon 4 -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'>Rekam Nilai Peserta Assesment</h3>
<p><span style="font-weight:bold;font-size:1.2em;text-transform:uppercase">Peserta : <?php echo $this->data_peserta[0]['pegawai'].' '.$this->data_peserta[0]['nip'];?></span><br/>
Kegiatan : <?php echo $this->data_peserta[0]['kegiatan'];?><br/>
<span style="font-weight:bold;font-size:1.2em;text-transform:uppercase">Korektor : <?php echo $this->data_korektor[0]['nama'].' '.$this->data_korektor[0]['nip'];?></span></p>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<fieldset>
<form method="post" action="<?php echo URL;?>assesment/rekamNilai/<?php echo $this->id_asses.'/'.$this->id_pegawai.'/'.$this->eselon.'/'.$this->id_korektor;?>">
	<input type='hidden' name='id_peserta' value='<?php echo $this->data_peserta[0]['id'];?>'>
	<?php
		foreach ($this->data_form as $key => $value) {
			echo '<label for='.$value['kode'].'>'.$value['jenis_tes'].' - '.$value['nama_sub_tes'].'</label>';
			echo '<input type="text" name='.$value['kode'].' placeholder="'.$value['jenis_tes'].' - '.$value['nama_sub_tes'].', desimal pisahkan dengan titik (.)"';
			if(isset($this->data)){
				echo ' value='.$this->data[$value['kode']][1].' ';
			}
			echo '>';
			if(isset($this->error[$value['kode']])){
				echo '<div class="warning error">'.$this->error[$value['kode']].'</div>';
			}
		}
	?>
	<input class="button medium" type='submit' name='submit_a' value='SIMPAN'>
</form>
</fieldset>
</div>
<div class="large-2 columns"></div>
<!-- end form rekam nilai esmelon 4 -->
<?php }elseif($this->aksi=='korektor'){ ?>
<!-- table of korektor assesment -->
<div class="large-10 columns list" >
<h3>Daftar Korektor Assesment</h3>
<p><span style="font-weight:bold;font-size:1.2em;text-transform:uppercase">Peserta : <?php echo $this->data_peserta[0]['pegawai'].' '.$this->data_peserta[0]['nip'];?></span><br/>
Kegiatan : <?php echo $this->data_asses[0]['nama_kegiatan'];?><br/></p>
<!--<a href="<?php echo URL;?>assesment/rekamPeserta/<?php echo $this->data_asses[0]['id'];?>"><button class="button small">Rekam</button></a>-->
<table id="t_korek">
	<thead>
		<th>No</th>
		<th>NIP</th>
		<th>Nama</th>
		<th>Aksi</th>
	</thead>
	<tbody>
	<?php if($this->count>0){
		$no = 0;
		foreach ($this->data_korektor as $key => $value) {
			echo "<tr>";
			echo "<td>".++$no."</td>";
			echo "<td>".$value['nip']."</td>";
			echo "<td class='text-left'>".$value['pegawai']."</td>";
			echo "<td><a href=".URL."assesment/rekamNilai/".$this->id_asses."/".$this->id_pegawai."/".$this->data_asses[0]['eselon']."/".$value['id']."><i class='step fi-graph-pie size-24' title='rekam nilai'></i></a>";
			echo "</tr>"; 	
		} 
	}else{ ?>
		<tr>
			<td colspan="5" class="no-data">DATA TIDAK DITEMUKAN</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#t_korek').dataTable();
	} );
</script>
</div>
<!-- end of table -->

<?php }elseif($this->aksi=='data'){ ?>
<!-- data assesment peserta -->
<div class="large-10 columns list" >
<h3>Daftar Penilaian Tes Hard Competency</h3>
<span style="font-weight:bold;font-size:1.2em;text-transform:uppercase">Peserta : <?php echo $this->data_peserta[0]['pegawai'].' '.$this->data_peserta[0]['nip'];?></span><br/>
Kegiatan : <?php echo $this->data_peserta[0]['kegiatan'];?><br/>
<table>
	<thead>
		<th rowspan="2">No</th>
		<th rowspan="2">Jenis Tes</th>
		<th colspan="<?php echo $this->num_korektor;?>">Korektor</th>
		<th rowspan="2">Rata-rata</th>
		<th rowspan="2">Nilai</th>
		<th rowspan="2">Bobot</th>
		<th rowspan="2">Nilai Bobot</th>
	
	<tr>
		<?php 
			foreach ($this->data_korek as $key => $value) {
				echo "<td>".$value['id_pegawai']." | <a href=".URL."assesment/hapusNilaiPeserta/".$this->data_asses[0]['id'].'/'.$this->data_peserta[0]['id'].'/'.$value['id']." onclick=\"return rdelete('nilai');\"><i class='step fi-trash size-24' title='hapus data nilai korektor ini'></i></a></td>";
			}
		?>
	</tr>
	</thead>
	<tbody>
		<?php
		if($this->count==0){
			echo "<tr>";
			echo "<td colspan=7 style='text-align:center;font-size:1.3em;'>DATA TIDAK DITEMUKAN</td>";
			echo "</tr>";
		}else{
			$no = 0;
			$tes_asses = '';
			$nrow = 0;
			foreach ($this->nilai_tes as $key => $value) {
				echo "<tr>";
				echo "<td>".++$no."</td>";
				echo "<td class='text-left'>".$value['id_tes_asses']." ".$value['nama_sub_tes']."</td>";
				$sub_total = 0;
				$i=0;
				foreach ($this->data_korek as $k => $v) {
					echo "<td>".$value[$v['id_pegawai']]."</td>";
					$sub_total += (int) $value[$v['id_pegawai']];
					$i++;
				}
				echo "<td>".$value['rata']."</td>"; //rata-rata
				if($value['id_tes_asses']!=$tes_asses){
					$tes_asses = $value['id_tes_asses'];
					$nrow = 1;
				}else{
					$nrow++;
				}
				$a = 0;
				foreach ($this->nilai_tes as $k => $v) {
					if($v['id_tes_asses']==$tes_asses) $a++;
				}
				//echo $nrow.'-'.$a.'<br/>';
				if((int) $value['nilai']>= (int) $value['pass_grade']){
					$s = 'background-color:green;color:#fff';
				}else{
					$s = 'background-color:red;color:#fff';
				}
				if($nrow == 1 & $a>1){
					//nilai tes dari sub tes setelah di bobot
					echo "<td rowspan=".$a." style='".$s."' title='passing grade=".$value['pass_grade']."'>".$value['nilai']."</td>";
					//bobot tes  
					echo "<td rowspan=".$a.">".$value['bobot_tes']."</td>";
					//nilai tes setelah dibobot
					echo "<td rowspan=".$a.">".$value['nilai_bobot']."</td>";
				}elseif($nrow== 1 & $a==1){
					echo "<td style='".$s."' title='passing grade=".$value['pass_grade']."'>".$value['nilai']."</td>";
					echo "<td>".$value['bobot_tes']."</td>";
					echo "<td>".$value['nilai_bobot']."</td>";
				}
				
				echo "</tr>";
			}

		}
		?>
	</tbody>
</table>
<div>
	<hr/>
	<h5>Keterangan : 
	<?php
		if($this->kelulusan['is_lulus']){
			echo '<span style="color:green;font-weight:bold">LULUS</span>';
		}else{
			echo '<span style="color:red;font-weight:bold">GAGAL</span>';
		}
	?>
	</h5>
	<p>
		Nilai tes <i>hard competency</i> : <span style='text-size:2em;font-weight:bold'><?php echo $this->kelulusan['total_nilai'];?></span>	
	</p>
	<p>
		<?php 
			if(count($this->kelulusan['tes_gagal'])>0){
				echo '<span>Tes yang mengalami kegagalan :</span>';
				echo '<ol>';
				foreach ($this->kelulusan['tes_gagal'] as $key => $value) {
					echo '<li style="color:red;font-weight:bold">'.$value.'</li>';
				}
				echo '</ol>';
			}
		?>
	</p>
</div>
</div>
<!-- end of data assesment peserta -->
<?php } ?>
</div>
</div>