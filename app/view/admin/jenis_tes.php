<div class="units-row">
<div class="units-row">
<div class="large-2 columns" >
	<?php $this->load('admin/menu-admin');?>
</div>
<?php if($this->aksi=='add' || $this->aksi=='update'){ ?>
<!-- form rekam / ubah -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'>Rekam Jenis Tes</h3>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<fieldset>
	<form method="post" action="<?php echo URL;?>referensi/<?php echo ($this->aksi=='add')?'rekamJenisTes':'ubahJenisTes/'.$this->data['id']?>">
		<?php 
			if($this->aksi=='update'){
				echo "<input type=hidden name=id value=".$this->data['id'].">";
			}
		?>
		<label for='jenis'>Jenis Soal</label>
		<input type='text' name='jenis' value='<?php if(isset($this->data)) echo $this->data['jenis']; ?>'>
		<?php if(isset($this->error['jenis'])){
				echo '<div class="warning error">'.$this->error['jenis'].'</div>';
			}
		?>
		<label for='singkat'>Singkatan</label>
		<input type='text' name='singkat' value='<?php if(isset($this->data)) echo $this->data['singkat']; ?>'>
		<?php if(isset($this->error['singkat'])){
				echo '<div class="warning error">'.$this->error['singkat'].'</div>';
			}
		?>
		<label for='uraian'>Uraian</label>
		<textarea rows='10' name='uraian'><?php if(isset($this->data)) echo $this->data['uraian']; ?></textarea>
		<?php if(isset($this->error['uraian'])){
				echo '<div class="warning error">'.$this->error['uraian'].'</div>';
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
<h3>Daftar Jenis Tes</h3>
<a href="<?php echo URL;?>referensi/rekamJenisTes"><button class="button small">Rekam</button></a>
<table id="t_jenis">
	<thead>
		<th>No</th>
		<th>Jenis Soal</th>
		<th>Uraian</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		<?php if($this->count>0){
			$no = 0;
			foreach ($this->data as $key => $value) {
				echo "<tr>";
				echo "<td>".++$no."</td>";
				echo "<td class='text-left'>".$value['jenis_tes']."</td>";
				echo "<td class='text-left'>".$value['uraian']."</td>";
				echo "<td><a href=".URL."referensi/ubahJenisTes/".$value['id']."><i class='step fi-page-edit size-24' title='ubah'></i></a> | 
					<a href=".URL."referensi/hapusJenisTes/".$value['id']." onclick=\"return rdelete('jenistes');\"><i class='step fi-trash size-24' title='hapus'></i></a></td>";
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
	    $('#t_jenis').dataTable();
	} );
</script>
</div>
<!-- end of table -->
<?php } ?>
</div>
</div>
