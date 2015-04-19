<div class="units-row">
<div class="units-row">
<div class="large-2 columns">
	<?php $this->load('wekdal/menu-wekdal');?>
</div>
<?php if($this->aksi=='kalendar'){ ?>
<!-- calendar -->
<div class="large-10 columns list">
<?php echo $this->kalendar; ?>
</div>
<!-- end of calendar -->
<?php }elseif ($this->aksi=='add') { ?>

<fieldset>
	<?php if($this->is_success()){
		echo '<div class="warning success">'.$this->success['success'].'</div>';
	}
	?>
	<legend><h3>Rekam ST</h3></legend>
	<form method="post" action="<?php echo URL; ?>wekdal/add_task/<?php echo $this->date; ?>">
	<div class="row">
	</div>
	<div class="large-6 columns list">
		<label for="nomor">NOMOR</label>
		<input type="text" name="nomor" placeholder="nomor surat tugas">
		<?php if(isset($this->error['nomor'])){
				echo '<div class="warning error">'.$this->error['nomor'].'</div>';
			}
		?>
		<div class="row" >
		<div class="large-6 columns" style="padding-left:0">
		<label for="mulai">MULAI</label>
		<input class="datepick" id="d1" type="text" name="mulai" placeholder='<?php echo is_null($this->date)?date('Y-m-d'):$this->date; ?>' readonly>
		</div>
		<div class="large-6 columns" style="padding-right:0">
		<label for="akhir">AKHIR</label>
		<input class="datepick" id="d2" type="text" name="akhir" placeholder='<?php echo date('Y-m-d'); ?>' readonly>
		</div>
		</div>
		<div class="row">
			<div class="large-12 columns" style="padding-left:0; padding-right:0">
				<?php if(isset($this->error['tanggal'])){
						echo '<div class="warning error">'.$this->error['tanggal'].'</div>';
					}
				?>
			</div>
		</div>
		<div class="row" >
		<div class="large-6 columns" style="padding-left:0">
		<label for="mulai">JAM MULAI</label>
		<div class="row">
			<div class="large-3 columns">
			<label for="mulai">JAM</label>
			<select name='jam_mulai'>
				<?php 
					for($i=1;$i<=24;$i++){
						echo '<option value='.$i.'>'.$i.'</option>';
					}
				?>
			</select>
			</div>
			<div class="large-3 columns end">
			<label for="mulai">MENIT</label>
			<select name="menit_mulai">
				<option value="0">00</option>
				<option value="15">15</option>
				<option value="30">30</option>
				<option value="45">45</option>
			</select>
			</div>
			
		</div>
		</div>
		<div class="large-6 columns end" style="padding-left:0">
		<label for="mulai">JAM SELESAI</label>
		<div class="row">
			<div class="large-3 columns">
			<label for="mulai">JAM</label>
			<select name="jam_selesai">
				<?php 
					for($i=1;$i<=24;$i++){
						echo '<option value='.$i.'>'.$i.'</option>';
					}
				?>
			</select>
			</div>
			<div class="large-3 columns end">
			<label for="mulai">MENIT</label>
			<select name="menit_selesai">
				<option value="0">00</option>
				<option value="15">15</option>
				<option value="30">30</option>
				<option value="45">45</option>
			</select>
			</div>
			
		</div>
		</div>
		</div>
		<label for="tujuan">DAERAH TUJUAN</label>
		<input type="text" name="tujuan" placeholder="kanwil/kppn/kota tujuan">
		<?php if(isset($this->error['tujuan'])){
				echo '<div class="warning error">'.$this->error['tujuan'].'</div>';
			}
		?>
		<label for="tentang">KEPERLUAN</label>
		<textarea name="tentang" rows="5"></textarea>
		
		<?php if(isset($this->error['tentang'])){
				echo '<div class="warning error">'.$this->error['tentang'].'</div>';
			}
		?>
		<input type="submit" name="submit" value="SIMPAN" class="button small">
		</div>
		<div class="large-5 columns list end">
			<label>PESERTA</label>
			<div class="input_fields_wrap">
		    <div><select name="peserta[]"><option value=0>--PILIH PESERTA 1--</option>
		    	<?php 
		    		foreach ($this->pegawai as $key => $value) {
		    			echo "<option value=".$value['id'].">".$value['nama']." ".$value['nip']."</option>";
		    		}
		    	?>
		    </select>
		    <div class="row" >
			<div class="large-6 columns" style="padding-left:0">
			<label for="mulai">MULAI</label>
			<input class="" id="d1" type="text" name="pmulai[]" placeholder='yyyy-mm-dd'>
			</div>
			<div class="large-6 columns" style="padding-right:0">
			<label for="akhir">AKHIR</label>
			<input class="" id="d2" type="text" name="pakhir[]" placeholder='yyyy-mm-dd'>
			</div>
			</div>
		    </div>
			</div>
			<button class="add_field_button" title="tambah kolom lagiii...">+</button>
		</div>
	</form>
</fieldset>
<script type="text/javascript">
	$(function () {
		window.prettyPrint && prettyPrint();
		$('.datepick').fdatepicker({
			format: 'yyyy-mm-dd'
		});
	});
</script>

<?php }elseif ($this->aksi=='list_task') { ?>
	# code...
<?php }elseif ($this->aksi=='list_pegawai') { ?>
	# code...
<?php } ?>
</div>
</div>
