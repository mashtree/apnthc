<div class="units-row">
<div class="units-row">
<div class="large-2 columns">
	<?php $this->load('admin/menu-admin');?>
</div>
<?php if($this->aksi=='add' || $this->aksi=='update'){ ?>
<!-- form rekam / ubah -->
<div class="large-2 columns list"></div>
<div class="large-6 columns list">
<h3 class='title'>Rekam Assesment</h3>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<fieldset>
	<form method="post" action='<?php echo URL;?>referensi/<?php echo ($this->aksi=='add')?'rekamAssesment':'ubahAssesment/'.$this->data['id']; ?>'>
		<?php 
			if($this->aksi=='update'){
				echo "<input type=hidden name=id value=".$this->data['id'].">";
			}
		?>
		<label for='assesment'>Nama Assesment/profiling</label>
		<input type='text' name='assesment' value='<?php if(isset($this->data)) echo $this->data['assesment']; ?>'>
		<?php if(isset($this->error['assesment'])){
				echo '<div class="warning error">'.$this->error['assesment'].'</div>';
			}
		?>
		<label for='eselon'>Level Eselon</label>
		<select name='eselon'>
			<option value='0'>-- PILIH ESELON --</option>
			<option value='99' <?php if(isset($this->data)){ if($this->data['eselon']==99) echo 'selected'; }?>>Pelaksana</option>
			<option value='42' <?php if(isset($this->data)){ if($this->data['eselon']==42) echo 'selected'; }?>>Eselon IV.b</option>
			<option value='41' <?php if(isset($this->data)){ if($this->data['eselon']==41) echo 'selected'; }?>>Eselon IV.a</option>
			<option value='32' <?php if(isset($this->data)){ if($this->data['eselon']==32) echo 'selected'; }?>>Eselon III.b</option>
			<option value='31' <?php if(isset($this->data)){ if($this->data['eselon']==31) echo 'selected'; }?>>Eselon III.a</option>
			<option value='22' <?php if(isset($this->data)){ if($this->data['eselon']==22) echo 'selected'; }?>>Eselon II.b</option>
			<option value='21' <?php if(isset($this->data)){ if($this->data['eselon']==21) echo 'selected'; }?>>Eselon II.a</option>
		</select>
		<?php if(isset($this->error['eselon'])){
				echo '<div class="warning error">'.$this->error['eselon'].'</div>';
			}
		?>
		<label for='soal'>Uraian</label>
		<textarea name='uraian' rows='10'><?php if(isset($this->data)) echo $this->data['uraian']; ?></textarea>
		<?php if(isset($this->error['uraian'])){
				echo '<div class="warning error">'.$this->error['uraian'].'</div>';
			}
		?>
		<label for='pic'>PIC</label>
		<select name='pic'>
			<option value='0'>-- PILIH PIC KEGIATAN --</option>
			<?php
				foreach ($this->pic as $key => $value) {
					if(isset($this->data)){
						echo '<option value='.$value['id_peg'];
						if($this->data['pic']==$value['id_peg']){
							echo ' selected>';
						}else{
							echo ' >';
						}
						echo $value['id_pegawai'].'</option>';
					}else{
						echo '<option value='.$value['id_peg'].'>'.$value['id_pegawai'].'</option>';
					}
				}
			?>
		</select>
		<?php if(isset($this->error['pic'])){
				echo '<div class="warning error">'.$this->error['pic'].'</div>';
			}
		?>
		<label for='tahun'>Tahun Kegiatan</label>
		<select name='tahun'>
			<option value='0'>-- PILIH TAHUN KEGIATAN --</option>
			<?php
				foreach ($this->tahun as $key => $value) {
					if(isset($this->data)){
						echo '<option value='.$value;
						if($this->data['tahun']==$value){
							echo ' selected>';
						}else{
							echo ' >';
						}
						echo $value.'</option>';
					}else{
						echo '<option value='.$value.'>'.$value.'</option>';
					}
				}
			?>
		</select>
		<?php if(isset($this->error['tahun'])){
				echo '<div class="warning error">'.$this->error['tahun'].'</div>';
			}
		?>
		<input class="button medium" type='submit' name='submit_<?php echo ($this->aksi=='add')?'a':'e';?>' value='SIMPAN'>
	</form>
</fieldset>
</div>
<div class="large-2 columns">&nbsp;</div>
<!-- end of form -->
<?php }elseif ($this->aksi=='list'){ ?>
<!-- table of assesment -->
<div class="large-10 columns list">
<h3>Daftar Assesment</h3>
<a href="<?php echo URL;?>referensi/rekamAssesment"><button class="button small">Rekam</button></a>
<table id="t_asses">
	<thead>
		<th>No</th>
		<th>Assesment/Profiling</th>
		<th>Uraian</th>
		<th>Jenis Tes</th>
		<th>Aksi</th>
	</thead>
	<tbody>
	<?php if($this->count>0){
		$no = 0;
		foreach ($this->data as $key => $value) {
			echo "<tr>";
			echo "<td>".++$no."</td>";
			echo "<td class='text-left'>".$value['nama_kegiatan']."</td>";
			echo "<td class='text-left'>".$value['uraian']."</td>";
			echo "<td><a href=".URL."referensi/tesAsses/".$value['id']."><i class='step fi-folder-add size-24' title='jenis tes assesment'></i></a></td>";
			//echo "<td><a href=".URL."assesment/peserta/".$value['id']."><i class='step fi-torsos-all size-24' title='ubah'></i></a></td>";
			echo "<td><a href=".URL."referensi/ubahAssesment/".$value['id']."><i class='step fi-page-edit size-24' title='ubah'></i></a> | 
					<a href=".URL."referensi/hapusAssesment/".$value['id']." onclick=\"return rdelete('assesment');\"><i class='step fi-trash size-24' title='hapus'></i></a></td>";
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
	    $('#t_asses').dataTable();
	} );
</script>
</div>
<!-- end of table -->
<?php } ?>
</div>
</div>
