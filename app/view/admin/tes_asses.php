<div class="units-row">
<div class="units-row">
<div class="large-2 columns" >
	<?php $this->load('admin/menu-admin');?>
</div>
<?php if($this->aksi=='add' || $this->aksi=='update'){ ?>
<!-- form rekam / ubah -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'><?php echo $this->judul;?></h3>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<fieldset>
	<form method="post" action="<?php echo URL;?>referensi/<?php echo ($this->aksi=='add')?'rekamTesAsses':'ubahTesAsses/'.$this->data['id']?>">
		<?php 
			if($this->aksi=='update'){
				echo "<input type=hidden name=id value=".$this->data['id'].">";
			}
		?>
		<label for='assesment'>Assesment/Profiling</label>
		<select name='assesment'>
			<option value=0>--PILIH ASSESMENT--</option>
			<?php 
				foreach ($this->data_asses as $key => $value) {
					if(isset($this->id_asses)){
						if($this->id_asses==$value['id']){
							echo "<option value=".$value['id']." selected>".strtoupper($value['nama_kegiatan'])."</option>";
						}
					}
					if(isset($this->data)){
						if($this->data['assesment']==$value['id']){
							echo "<option value=".$value['id']." selected>".strtoupper($value['nama_kegiatan'])."</option>";
						}else{
							echo "<option value=".$value['id'].">".strtoupper($value['nama_kegiatan'])."</option>";
						}
					}else{
						echo "<option value=".$value['id'].">".strtoupper($value['nama_kegiatan'])."</option>";
					}
				}
			?>
		</select>
		<?php if(isset($this->error['assesment'])){
				echo '<div class="warning error">'.$this->error['assesment'].'</div>';
			}
		?>
		<label for='jenis'>Jenis Tes</label>
		<select name='jenis'>
			<option value=0>--PILIH JENIS TES--</option>
			<?php 
				foreach ($this->data_jenis_tes as $key => $value) {
					if(isset($this->data)){
						if($this->data['jenis']==$value['id']){
							echo "<option value=".$value['id']." selected>".strtoupper($value['jenis_tes'])."</option>";
						}else{
							echo "<option value=".$value['id'].">".strtoupper($value['jenis_tes'])."</option>";
						}
					}else{
						echo "<option value=".$value['id'].">".strtoupper($value['jenis_tes'])."</option>";
					}
				}
			?>
		</select>
		<?php if(isset($this->error['jenis'])){
				echo '<div class="warning error">'.$this->error['jenis'].'</div>';
			}
		?>
		<label for="pass_grade">Passing Grade Tes</label>
		<input type='text' name='pass_grade' value='<?php if(isset($this->data)) echo $this->data['pass_grade']; ?>' placeholder="pisahkan desimal dengan titik (.)">
		<?php if(isset($this->error['pass_grade'])){
				echo '<div class="warning error">'.$this->error['pass_grade'].'</div>';
			}
		?>
		<label for="bobot">Bobot</label>
		<input type='text' name='bobot' value='<?php if(isset($this->data)) echo $this->data['bobot']; ?>' placeholder="bobot penilaian sub tes per jenis tes">
		<?php if(isset($this->error['bobot'])){
				echo '<div class="warning error">'.$this->error['bobot'].'</div>';
			}
		?>
		<label for="metode">Metode</label>
		<select name='metode'>
			<option value=0>--PILIH METODE PEMBOBOTAN SUB TES--</option>
			<?php 
				foreach ($this->metode as $key => $value) {
					if(isset($this->data)){
						if($this->data['metode']==$value['id']){
							echo "<option value=".$value['id']." selected>".strtoupper($value['nama'])."</option>";
						}else{
							echo "<option value=".$value['id'].">".strtoupper($value['nama'])."</option>";
						}
					}else{
						echo "<option value=".$value['id'].">".strtoupper($value['nama'])."</option>";
					}
				}
			?>
		</select>
		<?php if(isset($this->error['metode'])){
				echo '<div class="warning error">'.$this->error['metode'].'</div>';
			}
		?>
		<input class="button medium" type='submit' name='submit_<?php echo ($this->aksi=='add')?'a':'e';?>' value='SIMPAN'>
	</form>
</fieldset>
</div>
<div class="large-2 columns"></div>
<!-- end of form -->
<?php }elseif ($this->aksi=='list'){ ?>
<!-- table of passing grade -->
<div class="large-10 columns list">
<h3>Daftar Jenis Tes Assesment</h3>
<a href="<?php echo URL;?>referensi/rekamTesAsses<?php echo (isset($this->id_asses))?'/'.$this->id_asses:''; ?>"><button class="button small">Rekam</button></a>
<table id="t_tes">
	<thead>
		<th>No</th>
		<th>Assesment/Profiling</th>
		<th>Jenis Tes</th>
		<th>Bobot</th>
		<th>Metode</th>
		<th>Passing Grade</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		<?php if($this->count>0){
			$no = 0;
			foreach ($this->data as $key => $value) {
				echo "<tr>";
				echo "<td>".++$no."</td>";
				echo "<td class='text-left'>".$value['id_assesment']."</td>";
				echo "<td class='text-left'>".$value['id_jenis_tes']."</td>";
				echo "<td>".$value['bobot']."</td>";
				echo "<td class='text-left'>".$value['metode']."</td>";
				echo "<td>".$value['pass_grade']."</td>";
				echo "<td><a href=".URL."referensi/ubahTesAsses/".$value['id']."><i class='step fi-page-edit size-24' title='ubah'></i></a> | 
				<a href=".URL."referensi/hapusTesAsses/".$value['id']." onclick=\"return rdelete('tesasses');\"><i class='step fi-trash size-24' title='hapus'></i></a></td>";
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
	    $('#t_tes').dataTable();
	} );
</script>
</div>
<!-- end of table -->
<?php } ?>
</div>
</div>
