<div class="units-row">
<div class="units-row">
<div class="large-2 columns">
	<?php $this->load('admin/menu-admin');?>
</div>
<?php if($this->aksi=='add' || $this->aksi=='update'){ ?>
<!-- form rekam / ubah -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'>Rekam Pegawai</h3>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<fieldset>
	<form method="post" action="<?php echo URL;?>referensi/<?php echo ($this->aksi=='add')?'rekamPegawai':'ubahPegawai/'.$this->data['id']?>">
		<?php 
			if($this->aksi=='update'){
				echo "<input type=hidden name=id value=".$this->data['id'].">";
			}
		?>
		<label for='nip'>NIP</label>
		<input type='text' name='nip' value='<?php if(isset($this->data)) echo $this->data['nip']; ?>' <?php if($this->aksi=='update') echo 'readonly'; ?>>
		<?php if(isset($this->error['nip'])){
				echo '<div class="warning error">'.$this->error['nip'].'</div>';
			}
		?>
		<label for='nama'>Nama pegawai</label>
		<input type='text' name='nama' value='<?php if(isset($this->data)) echo $this->data['nama']; ?>'>
		<?php if(isset($this->error['nama'])){
				echo '<div class="warning error">'.$this->error['nama'].'</div>';
			}
		?>
		<label for='eselon'>Eselon</label>
		<select name='eselon'>
			<option value='0'>--PILIH ESELON PEGAWAI--</option>
			<option value='11' <?php if(isset($this->data) && $this->data['eselon']=='11') echo 'selected'; ?>>Eselon I.a</option>
			<option value='12' <?php if(isset($this->data) && $this->data['eselon']=='12') echo 'selected'; ?>>Eselon I.b</option>
			<option value='21' <?php if(isset($this->data) && $this->data['eselon']=='21') echo 'selected'; ?>>Eselon II.a</option>
			<option value='22' <?php if(isset($this->data) && $this->data['eselon']=='22') echo 'selected'; ?>>Eselon II.b</option>
			<option value='31' <?php if(isset($this->data) && $this->data['eselon']=='31') echo 'selected'; ?>>Eselon III.a</option>
			<option value='32' <?php if(isset($this->data) && $this->data['eselon']=='32') echo 'selected'; ?>>Eselon III.b</option>
			<option value='41' <?php if(isset($this->data) && $this->data['eselon']=='41') echo 'selected'; ?>>Eselon IV.a</option>
			<option value='42' <?php if(isset($this->data) && $this->data['eselon']=='42') echo 'selected'; ?>>Eselon IV.b</option>
			<option value='99' <?php if(isset($this->data) && $this->data['eselon']=='99') echo 'selected'; ?>>Pelaksana</option>
		</select>
		<?php if(isset($this->error['eselon'])){
				echo '<div class="warning error">'.$this->error['eselon'].'</div>';
			}
		?>
		<input class="button medium" type='submit' name='submit_<?php echo ($this->aksi=='add')?'a':'e';?>' value='SIMPAN'>
	</form>
</fieldset>
</div>
<div class="large-2 columns"></div>
<!-- end of form -->
<?php }elseif ($this->aksi=='list'){ ?>
<!-- table of pegawai -->
<div class="large-10 columns list">
<h3>Daftar Pegawai</h3>
<a href="<?php echo URL;?>referensi/rekamPegawai"><button class="button small">Rekam</button></a>
<a href="<?php echo URL;?>referensi/uploadDataCsv"><button class="button small">Upload Data</button></a>
<table id="t_pegawai">
	<thead>
		<th>No</th>
		<th>NIP</th>
		<th>Nama</th>
		<th>Eselon</th>
		<th>Jabatan</th>
		<th>Unit</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		<?php if($this->count>0){
			$no = 0;
			foreach ($this->data as $key => $value) {
				echo "<tr>";
				echo "<td>".++$no."</td>";
				echo "<td>".$value['nip']."</td>";
				echo "<td class='text-left'>".$value['nama']."</td>";
				echo "<td>".Eselon::to_eselon($value['eselon'])."</td>";
				echo "<td class='text-left'>".$value['jabatan']."</td>";
				echo "<td class='text-left'>".$value['unit']."</td>";
				echo "<td><a href=".URL."referensi/ubahPegawai/".$value['id']."><i class='step fi-page-edit size-24' title='ubah'></i></a> | 
				<a href=".URL."referensi/hapusPegawai/".$value['id']." onclick=\"return rdelete('pegawai');\"><i class='step fi-trash size-24' title='hapus'></i></a></td>";
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
	    $('#t_pegawai').dataTable();
	} );
</script>
</div>
<!-- end of table -->
<?php }elseif($this->aksi=='csv'){ ?>
<!-- form rekam / ubah -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'>Upload Data Pegawai</h3>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<fieldset>
	<form method="post" action="<?php echo URL;?>referensi/uploadDataCsv" enctype="multipart/form-data">
		<input type="file" name="file">
		<?php if(isset($this->error['eselon'])){
				echo '<div class="warning error">'.$this->error['eselon'].'</div>';
			}

			if(isset($this->error['file'])){
				echo '<div class="warning error">'.$this->error['file'].'</div>';
			}
		?>
		<input class="button medium" type='submit' name='submit_a' value='SIMPAN'>
	</form>
</fieldset>
</div>
<div class="large-2 columns"></div>
<!-- end of form -->
<?php } ?>
</div>
</div>