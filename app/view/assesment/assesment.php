<div class="units-row" >
<div class="units-row" >
<div class="large-2 columns side-menu" >
	<?php $this->load('assesment/menu');?>
</div>
<!-- table of assesment -->
<div class="large-10 columns list" >
<h3>Daftar Assesment</h3>
<table id="t_asses">
	<thead>
		<th>No</th>
		<th>Assesment/Profiling</th>
		<th>Uraian</th>
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
			echo "<td><a href=".URL."assesment/peserta/".$value['id']."><i class='step fi-torsos-all size-24' title='peserta'></i></a> | 
					<a href=".URL."assesment/korektor/".$value['id']."><i class='step fi-pencil size-24' title='korektor'></i></a> | 
					<a href=".URL."assesment/jenistes/".$value['id']."><i class='step fi-list size-24' title='jenis tes'></i></a> | 
					<a href=".URL."assesment/laporan/".$value['id']."><i class='step fi-graph-trend size-24' title='laporan'></i></a></td>";
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
</div>
</div>