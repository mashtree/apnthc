<div class="units-row">
<div class="units-row">
<div class="large-2 columns" >
	<?php $this->load('admin/menu-admin');?>
</div>
<?php if($this->aksi=='add' || $this->aksi=='update'){ ?>
<!-- form rekam / ubah -->
<div class="large-2 columns">&nbsp;</div>
<div class="large-6 columns list">
<h3 class='title'>Rekam User</h3>
<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
?>
<fieldset>
	<form method="post" action="<?php echo URL;?>referensi/<?php echo ($this->aksi=='add')?'rekamUser':'ubahUser/'.$this->data['id']?>">
		<?php 
			if($this->aksi=='update'){
				echo "<input type=hidden name=id value=".$this->data['id'].">";
				echo "<input type=hidden name=pegawai value=".$this->data['id_pegawai'].">";
			}
		?>
		<label for='pegawai'>Pegawai</label>
		<select name='pegawai' <?php if($this->aksi=='update') echo 'disabled'; ?>>
			<option value=0>--PILIH PEGAWAI--</option>
			<?php 
				foreach ($this->data_peg as $key => $value) {
					if(isset($this->data)){
						if($this->data['id_pegawai']==$value['id']){
							echo '<option value='.$value['id'].' selected>'.$value['nama'].' '.$value['nip'].'</option>';
						}else{
							echo '<option value='.$value['id'].'>'.$value['nama'].' '.$value['nip'].'</option>';
						}
					}else{
						echo '<option value='.$value['id'].'>'.$value['nama'].' '.$value['nip'].'</option>';
					}
				}
			?>
		</select>
		<?php if(isset($this->error['pegawai'])){
				echo '<div class="warning error">'.$this->error['pegawai'].'</div>';
			}
		?>
		<label for='nama_user'>nama user</label>
		<input type='text' name='nama' value='<?php if(isset($this->data)) echo $this->data['nama']; ?>' <?php if($this->aksi=='update') echo 'readonly'; ?>>
		<?php if(isset($this->error['nama'])){
				echo '<div class="warning error">'.$this->error['nama'].'</div>';
			}
		?>
		<label for='pass'>Password</label>
		<input type='text' name='pass' value='<?php if(isset($this->data)) echo $this->data['pass']; ?>'>
		<?php if(isset($this->error['pass'])){
				echo '<div class="warning error">'.$this->error['pass'].'</div>';
			}
		?>
		<label for='role'>Role</label>
		<select name='role'>
			<option value='0'>--PILIH ROLE USER--</option>
			<option value='1' <?php if(isset($this->data) && $this->data['role']=='1') echo 'selected'; ?>>PLATINUM</option>
			<option value='2' <?php if(isset($this->data) && $this->data['role']=='2') echo 'selected'; ?>>GOLD</option>
			<option value='3' <?php if(isset($this->data) && $this->data['role']=='3') echo 'selected'; ?>>SILVER</option>
		</select>
		<?php if(isset($this->error['role'])){
				echo '<div class="warning error">'.$this->error['role'].'</div>';
			}
		?>
		<input class="button medium" type='submit' name='submit_<?php echo ($this->aksi=='add')?'a':'e';?>' value='SIMPAN'>
	</form>
</fieldset>
</div>
<div class="large-2 columns"></div>
<!-- end of form -->
<?php }elseif ($this->aksi=='list'){ ?>
<!-- table of user -->
<div class="large-10 columns list">
<h3>Daftar Pegawai</h3>
<a href="<?php echo URL;?>referensi/rekamUser"><button class="button small">Rekam</button></a>
<table id="t_user">
	<thead>
		<th>No</th>
		<th>Nama Pegawai</th>
		<th>Nama User</th>
		<th>Role</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		<?php if($this->count>0){
			$no = 0;
			foreach ($this->data as $key => $value) {
				echo "<tr>";
				echo "<td>".++$no."</td>";
				echo "<td class='text-left'>".$value['id_pegawai']."</td>";
				echo "<td class='text-left'>".$value['nama_user']."</td>";
				echo "<td>".Eselon::to_role($value['role'])."</td>";
				echo "<td><a href=".URL."referensi/ubahUser/".$value['id']."><i class='step fi-page-edit size-24' title='ubah'></i></a> | 
				<a href=".URL."referensi/hapusUser/".$value['id']." onclick=\"return rdelete('user');\"><i class='step fi-trash size-24' title='hapus'></i></a></td>";
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
	    $('#t_user').dataTable();
	} );
</script>
</div>
<!-- end of table -->
<?php } ?>
</div>
</div>