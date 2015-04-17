<div class="units-row" >
<div class="units-row" >
<div class="large-2 columns side-menu" >
	<?php $this->load('assesment/menu');?>
</div>
<?php if($this->aksi=='add'){ ?>
<!-- form rekam / ubah -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'>Rekam Korektor Assesment</h3>
<p>Kegiatan : <?php echo $this->data_asses[0]['nama_kegiatan'];?></p>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<form method="post" action="<?php echo URL;?>assesment/rekamKorektor/<?php echo $this->id_asses;?>">
	<?php 
    	if(isset($this->error['korektor'])){
			echo '<div class="warning error">'.$this->error['korektor'].'</div>';
		}
    ?>
	<div class="input_fields_korektor">
    <div><select name="korektor[]"><option value=0>--PILIH KOREKTOR--</option>
    	<?php 
    		foreach ($this->pegawai_for_peserta as $key => $value) {
    			echo "<option value=".$value['id'].">".$value['nama']." ".$value['nip']."</option>";
    		}
    	?>
    </select></div>
	</div>
	<?php if(isset($this->error['korektor'])){
			echo '<div class="warning error">'.$this->error['korektor'].'</div>';
		}
	?>
	<button class="add_field_button_korektor" title="tambah kolom lagiii...">+</button>
	<input class="button medium" type='submit' name='submit_a' value='SIMPAN'>
</form>
</div>
<div class="large-2 columns"></div>

<!-- end of form -->
<?php }elseif ($this->aksi=='edit') { ?>
<!-- form ubah -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'>Ubah Korektor Assesment</h3>
<p>Kegiatan : <?php //echo $this->data_asses[0]['nama_kegiatan'];?></p>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<form method="post" action="<?php echo URL;?>assesment/ubahKorektor/<?php echo $this->data['id'];?>">
	<input type="hidden" name="id" value="<?php echo $this->data['id']; ?>">
    
    <select name="korektor"><option value=0>--PILIH PESERTA--</option>
    	<?php 
    		foreach ($this->pegawai_for_peserta as $key => $value) {
    			if($this->data['id_pegawai']==$value['id']){
    				echo "<option value=".$value['id']." selected>".$value['nip']." ".$value['nama']."</option>";
    			}else{
    				echo "<option value=".$value['id'].">".$value['nip']." ".$value['nama']."</option>";
    			}
    		}
    	?>
    </select>
    <?php if(isset($this->error['korektor'])){
			echo '<div class="warning error">'.$this->error['korektor'].'</div>';
		}
	?>
	<input class="button medium" type='submit' name='submit_e' value='SIMPAN'>
</form>
</div>
<div class="large-2 columns"></div>

<!-- end of form -->
<?php }elseif ($this->aksi=='list'){ ?>
<!-- table of korektor -->
<div class="large-10 columns list" >
<h3>Daftar Korektor Assesment</h3>
<p>Kegiatan : <?php echo $this->data_asses[0]['nama_kegiatan'];?></p>
<a href="<?php echo URL;?>assesment/rekamKorektor/<?php echo $this->data_asses[0]['id'];?>"><button class="button small">Rekam</button></a>
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
		foreach ($this->data as $key => $value) {
			echo "<tr>";
			echo "<td>".++$no."</td>";
			echo "<td>".$value['nip']."</td>";
			echo "<td class='text-left'>".$value['pegawai']."</td>";
			echo "<td><a href=".URL."assesment/ubahKorektor/".$value['id']."><i class='step fi-page-edit size-24' title='ubah'></i></a> | 
					<a href=".URL."assesment/hapusKorektor/".$this->id_asses.'/'.$value['id']." onclick=\"return rdelete('korektor');\"><i class='step fi-trash size-24' title='hapus'></i></a>";
			echo "</tr>"; 	
		} 
	}else{ ?>
		<tr>
			<td colspan="5" class="no-data">DATA TIDAK DITEMUKAN</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
</div>
<!-- end of table -->
<?php }elseif ($this->aksi='nilai' && $this->eselon!=41) { ?>
<!-- form rekam nilai esmelon 4 -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'>Rekam Nilai Peserta Assesment</h3>
<p>Kegiatan : <?php echo $this->data_asses[0]['nama_kegiatan'];?></p>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<form method="post" action="<?php echo URL;?>assesment/rekamPeserta/<?php echo $this->id_asses;?>">
	<div class="input_fields_wrap">
    <div><select name="peserta[]"><option value=0>--PILIH PESERTA--</option>
    	<?php 
    		foreach ($this->pegawai_for_peserta as $key => $value) {
    			echo "<option value=".$value['id'].">".$value['nip']." ".$value['nama']."</option>";
    		}
    	?>
    </select></div>
	</div>
	<button class="add_field_button" title="tambah kolom lagiii...">+</button>
	<input class="button medium" type='submit' name='submit_a' value='SIMPAN'>
</form>
</div>
<div class="large-2 columns"></div>
<!-- end form rekam nilai esmelon 4 -->

<?php } ?>
</div>
</div>
