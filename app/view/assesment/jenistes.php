<div class="units-row" >
<div class="units-row" >
<div class="large-2 columns side-menu" >
	<?php $this->load('assesment/menu');?>
</div>
<?php if($this->aksi=='add' || $this->aksi=='edit'){ ?>
<!-- form rekam / ubah -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'><?php echo $this->judul; ?></h3>
<p>Kegiatan : <?php echo $this->data_asses[0]['nama_kegiatan'];?></p>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<form method="post" action="<?php echo URL;?>assesment/<?php echo ($this->aksi=='add')?'rekamJenisTes':'ubahJenisTes/'.$this->data['id'].(($this->aksi=='edit')?'/'.$this->id_asses:'');?>">
	<?php
		if($this->aksi=='edit'){
			echo "<input type='hidden' name='id' value=".$this->data['id'].">";
		}
	?>
	<label for="jenis tes">JENIS TES</label>
    <select name="jenis_tes"><option value=0>--PILIH JENIS TES--</option>
    	<?php 
    		foreach ($this->data_jenis_tes as $key => $value) {
    			if(isset($this->data)){
    				if($this->data['id_jenis_tes']==$value['id']){
    					echo "<option value=".$value['id']." selected>".$value['id_jenis_tes']."</option>";
    				}else{
    					echo "<option value=".$value['id'].">".$value['id_jenis_tes']."</option>";
    				}
    			}else{
    				echo "<option value=".$value['id'].">".$value['id_jenis_tes']."</option>";
    			}
    			
    		}
    	?>
    </select>
    <?php 
    	if(isset($this->error['jenis_tes'])){
			echo '<div class="warning error">'.$this->error['jenis_tes'].'</div>';
		}
    ?>
	<label for="sub tes">NAMA SUB TES</label>
	<input type="text" name="sub_tes" placeholder='nama sub tes, misal konsepsi' value='<?php if(isset($this->data)) echo $this->data['sub_tes'];?>'>
	<?php 
    	if(isset($this->error['sub_tes'])){
			echo '<div class="warning error">'.$this->error['sub_tes'].'</div>';
		}
    ?>
	<label for="sub tes">BOBOT</label>
	<input type="text" name="bobot" placeholder='jika tidak diisi maka dianggap sesuai proporsi sub tes' value='<?php if(isset($this->data)) echo $this->data['bobot'];?>'>
	<?php 
    	if(isset($this->error['bobot'])){
			echo '<div class="warning error">'.$this->error['bobot'].'</div>';
		}
    ?>
    <label for="kode">KODE</label>
	<input type="text" name="kode" placeholder='kode singkat sub tes [tidak boleh sama antar sub tes]' value='<?php if(isset($this->data)) echo $this->data['kode'];?>'>
	<?php 
    	if(isset($this->error['kode'])){
			echo '<div class="warning error">'.$this->error['kode'].'</div>';
		}
    ?>
	<input class="button medium" type='submit' name='submit_<?php echo ($this->aksi=='add')?'a':'e';?>' value='SIMPAN'>
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
<form method="post" action="<?php echo URL;?>assesment/ubahKorektor/<?php echo $this->data[0]['id_assesment'];?>">
	<input type="hidden" name="id" value="<?php echo $this->data[0]['id']; ?>">
    
    <select name="korektor"><option value=0>--PILIH PESERTA--</option>
    	<?php 
    		foreach ($this->pegawai_for_peserta as $key => $value) {
    			if($this->data[0][id_pegawai]==$value['id']){
    				echo "<option value=".$value['id']." selected>".$value['nip']." ".$value['nama']."</option>";
    			}else{
    				echo "<option value=".$value['id'].">".$value['nip']." ".$value['nama']."</option>";
    			}
    		}
    	?>
    </select>
    
	<input class="button medium" type='submit' name='submit_e' value='SIMPAN'>
</form>
</div>
<div class="large-2 columns"></div>

<!-- end of form -->
<?php }elseif ($this->aksi=='list'){ ?>
<!-- table of korektor -->
<div class="large-10 columns list" >
<h3><?php echo $this->judul;?></h3>
<p>Kegiatan : <?php echo $this->data_asses[0]['nama_kegiatan'];?></p>
<a href="<?php echo URL;?>assesment/rekamJenisTes/<?php echo $this->data_asses[0]['id'];?>"><button class="button small">Rekam</button></a>
<table id="t_jenis">
	<thead>
		<th>No</th>
		<th>Jenis Tes</th>
		<th>Sub Tes</th>
		<th>Bobot</th>
		<th>Aksi</th>
	</thead>
	<tbody>
	<?php if($this->count>0){
		$no = 0;
		foreach ($this->data as $key => $value) {
			echo "<tr>";
			echo "<td>".++$no."</td>";
			echo "<td >".$value['id_tes_asses']."</td>";
			echo "<td class='text-left'>".$value['nama_sub_tes']."</td>";
			echo "<td>".$value['bobot']."%</td>";
			echo "<td><a href=".URL."assesment/ubahJenisTes/".$value['id']."/".$this->data_asses[0]['id']."><i class='step fi-page-edit size-24' title='ubah'></i></a> | 
			<a href=".URL."assesment/hapusJenisTes/".$this->id_asses.'/'.$value['id']." onclick=\"return rdelete('subtes');\"><i class='step fi-trash size-24' title='hapus'></i></a>";
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
<?php }elseif ($this->aksi=='nilai' && $this->eselon!=41) { ?>
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