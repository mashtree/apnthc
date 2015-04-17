<div class="units-row">
<div class="units-row" >
<!--<div class="large-2 columns side-menu" >
	<?php //$this->load('assesment/menu');?>
</div>-->
<?php 
//Response.ContentType = "application/vnd.xls"; // for excel

if($this->aksi=='report'){ ?>
<!-- data assesment peserta -->
<div class="large-12 columns list" >
<h3 style="font-family:Lato-regular;font-weight:bold;font-size:1.2em;text-transform:uppercase;">
REKAPITULASI PENILAIAN <?php echo strtoupper($this->data_asses[0]['nama_kegiatan']);?></h3>
<h3 style="font-family:Lato-regular;font-weight:bold;font-size:1.2em;text-transform:uppercase;">
LINGKUP DIREKTORAT JENDERAL PERBENDAHARAAN TAHUN <?php echo $this->data_asses[0]['tahun'];?></h3>
<br/>

<a id="dlink"  ><div id="print">
<table id='laporan' class="hide"  style="border-collapse:collapse">
	
	<thead >
		<?php
			echo '<tr >';
			echo '<td style="text-align:center;font-size:1em" colspan='.($this->jumlah_jenis_tes_asses*2+10).'>REKAPITULASI PENILAIAN '.strtoupper($this->data_asses[0]['nama_kegiatan']).'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="text-align:center;font-size:1em" colspan='.($this->jumlah_jenis_tes_asses*2+10).'>LINGKUP DIREKTORAT JENDERAL PERBENDAHARAAN TAHUN '.$this->data_asses[0]['tahun'].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="text-align:center;" colspan='.($this->jumlah_jenis_tes_asses*2+10).'><br/></td>';
			echo '</tr>';
		?>
		<th rowspan="3" style="border:1px solid black;font-size:0.8em">No</th>
		<th rowspan="3" style="border:1px solid black;font-size:0.8em">Nama</th>
		<th rowspan="3" style="border:1px solid black;font-size:0.8em">NIP</th>
		<th rowspan="3" style="border:1px solid black;font-size:0.8em">Unit Kerja</th>
		<th rowspan="3" style="border:1px solid black;font-size:0.8em">JPM SC</th>
		<th rowspan="2" style="border:1px solid black;font-size:0.8em" colspan="<?php echo $this->jumlah_jenis_tes_asses-1; ?>">Nilai Hard Competency</th>
		<th colspan="<?php echo $this->jumlah_jenis_tes_asses+3; ?>" style="border:1px solid black;font-size:0.8em">Pemeringkatan</th>
		<th rowspan="3" style="border:1px solid black;font-size:0.8em">Keterangan</th>
	
	<tr style="text-align:center;border:1px solid black;font-size:0.8em">
		<td colspan="<?php echo $this->jumlah_jenis_tes_asses-1; ?>" style="text-align:center;border:1px solid black">Bobot HC</td>
		<td rowspan="2" style="text-align:center;border:1px solid black">Total Bobot HC</td>
		<td colspan="2" style="text-align:center;border:1px solid black">Bobot JPM dan HC</td>
		<td rowspan="2" style="text-align:center;border:1px solid black">Nilai Akhir</td>
	</tr  >
	<tr  style="text-align:center;border:1px solid black;font-size:0.8em">
		<?php
			foreach ($this->data_jenis_tes_asses as $key => $value) {
				if(strcasecmp(trim($value['id_jenis_tes']), 'soft competency'))
				echo "<td style='text-align:center;border:1px solid black'>Nilai ".$value['singkat']."</td>";
			}

			foreach ($this->data_jenis_tes_asses as $key => $value) {
				if(strcasecmp(trim($value['id_jenis_tes']), 'soft competency'))
				echo "<td  style='text-align:center;border:1px solid black'>".$value['singkat']."=".$value['bobot']."%</td>";
			}
		?>
		<td  style="text-align:center;border:1px solid black">HC=60%</td>
		<td  style="text-align:center;border:1px solid black">SC=40%</td>
	</tr>
	</thead>
	<tbody  >
		<?php
			if($this->jumlah_data>0){
				$no = 1;
				$columns = 10;
				foreach ($this->data as $key => $value) {
					echo "<tr  class='lap' style='font-size:0.8em'>";
					echo '<td  style="text-align:center;border:1px solid black;height:20px">'.$no++.'</td>';
					echo '<td  style="border:1px solid black" style="text-align:left">'.$value['nama'].'</td>';
					echo '<td  style="border:1px solid black">'.$value['nip'].'</td>';
					echo '<td  style="border:1px solid black">'.$value['kantor'].'</td>';
					$nilai_sc = 0;
					$nilai = $value['nilai']; //var_dump($nilai);
					$s = 'background-color:red;color:#fff';
					$p = 'background-color:green;color:#fff'; 
					$lulus = TRUE;
					//soft competency
					foreach ($nilai as $k => $v) {
							if(strtolower('soft competency')==strtolower($v['id_tes_asses'])){
								$nilai_sc = $v['nilai'];
								if($v['nilai']<$v['pass_grade']){
									$lulus = FALSE;
								}
								echo '<td  style="text-align:center;border:1px solid black;'.(($v['nilai']>=$v['pass_grade'])?$p:$s).'">'.$nilai_sc.'</td>';
							}
					}
					//nilai hard competency
					foreach ($this->data_jenis_tes_asses as $a => $b) {
						foreach ($nilai as $k => $v) {
						//if(!strcasecmp(trim($v['id_tes_asses']),'soft competency')){
							
								if(strtolower($b['id_jenis_tes'])==strtolower($v['id_tes_asses'])){
									if(strtolower($v['id_tes_asses'])!='soft competency'){
										echo '<td  style="text-align:center;border:1px solid black;'.(($v['nilai']>=$v['pass_grade'])?$p:$s).'">'.$v['nilai'].'</td>';
										if(!$v['lulus']) $lulus = FALSE;
										$columns++;
									}
								}
							}
							
						//}
					}

					//nilai bobot hard competency
					$nilai_hc = 0;
					foreach ($this->data_jenis_tes_asses as $a => $b) {
						foreach ($nilai as $k => $v) {
							if(strtolower($b['id_jenis_tes'])==strtolower($v['id_tes_asses'])){
								if(strtolower($v['id_tes_asses'])!='soft competency'){
									$nilai_temp = round($v['nilai']*$v['bobot_tes']/100,2,PHP_ROUND_HALF_UP);
									echo '<td  style="text-align:center;border:1px solid black">'.$nilai_temp.'</td>';
									$nilai_hc += $nilai_temp;
									$columns++;
								}
							}
						}
					}
					echo '<td style="text-align:center;border:1px solid black">'.$nilai_hc.'</td>';
					$nilai_hc = round($nilai_hc*60/100,2,PHP_ROUND_HALF_UP);
					$nilai_sc = round($nilai_sc*40/100,2,PHP_ROUND_HALF_UP);
					$total = $nilai_hc + $nilai_sc;
					if($lulus){
						$simpulan = '<td  style="text-align:center;border:1px solid black;'.$p.'">Memenuhi</td>';
					}else{
						$simpulan = '<td  style="text-align:center;border:1px solid black;'.$s.'">Belum Memenuhi</td>';
					}
					echo '<td  style="text-align:center;border:1px solid black">'.$nilai_hc.'</td>';
					echo '<td  style="text-align:center;border:1px solid black">'.$nilai_sc.'</td>';
					echo '<td  style="text-align:center;border:1px solid black">'.$total.'</td>';
					echo $simpulan;
					echo "</tr>";
				}
			}else{
				echo '<tr>';
				echo '<td  style="border:1px solid black" style="text-align:center;" colspan='.($this->jumlah_jenis_tes_asses*2+10).'>DATA TIDAK DITEMUKAN</td>';
				echo '</tr>';
			}
		?>
	</tbody>
</table></div>
</a>

<table >
	<thead>
		<th rowspan="3">NO</th>
		<th rowspan="3">NAMA</th>
		<th rowspan="3">NIP</th>
		<th rowspan="3">UNIT KERJA</th>
		<th rowspan="3">JPM SC</th>
		<th rowspan="2" colspan="<?php echo $this->jumlah_jenis_tes_asses-1; ?>">NILAI HARD COMPETENCY</th>
		<th colspan="<?php echo $this->jumlah_jenis_tes_asses+3; ?>">PEMERINGKATAN</th>
		<th rowspan="3">KETERANGAN</th>
	
	<tr>
		<td colspan="<?php echo $this->jumlah_jenis_tes_asses-1; ?>">Bobot HC</td>
		<td rowspan="2">Total Bobot HC</td>
		<td colspan="2">Bobot JPM dan HC</td>
		<td rowspan="2">Nilai Akhir</td>
	</tr>
	<tr>
		<?php
			foreach ($this->data_jenis_tes_asses as $key => $value) {
				if(strcasecmp(trim($value['id_jenis_tes']), 'soft competency'))
				echo "<td>Nilai ".$value['singkat']."</td>";
			}

			foreach ($this->data_jenis_tes_asses as $key => $value) {
				if(strcasecmp(trim($value['id_jenis_tes']), 'soft competency'))
				echo "<td>".$value['singkat']."=".$value['bobot']."%</td>";
			}
		?>
		<td>HC=60%</td>
		<td>SC=40%</td>
	</tr>
	</thead>
	<tbody>
		<?php
			if($this->jumlah_data>0){
				$no = 1;
				$columns = 10;
				foreach ($this->data as $key => $value) {
					echo "<tr>";
					echo '<td>'.$no++.'</td>';
					echo '<td style="text-align:left"><a href='.URL.'assesment/dataPeserta/'.$this->data_asses[0]['id'].'/'.$value['id'].'>'.$value['nama'].'</a></td>';
					echo '<td>\''.$value['nip'].'</td>';
					echo '<td>'.$value['kantor'].'</td>';
					$nilai_sc = 0;
					$nilai = $value['nilai']; //var_dump($nilai);
					$s = 'background-color:red;color:#fff';
					$p = 'background-color:green;color:#fff'; 
					$lulus = TRUE;
					//soft competency
					foreach ($nilai as $k => $v) {
							if(strtolower('soft competency')==strtolower($v['id_tes_asses'])){
								$nilai_sc = $v['nilai'];
								if($v['nilai']<$v['pass_grade']){
									$lulus = FALSE;
								}
								echo '<td style="'.(($v['nilai']>=$v['pass_grade'])?$p:$s).';cursor:pointer" title="passing grade = '.$v['pass_grade'].'">'.$nilai_sc.'</td>';
							}
					}
					//nilai hard competency
					foreach ($this->data_jenis_tes_asses as $a => $b) {
						foreach ($nilai as $k => $v) {
						//if(!strcasecmp(trim($v['id_tes_asses']),'soft competency')){
							
								if(strtolower($b['id_jenis_tes'])==strtolower($v['id_tes_asses'])){
									if(strtolower($v['id_tes_asses'])!='soft competency'){
										echo '<td style="'.(($v['nilai']>=$v['pass_grade'])?$p:$s).';cursor:pointer" title="passing grade = '.$v['pass_grade'].'">'.$v['nilai'].'</td>';
										if(!$v['lulus']) $lulus = FALSE;
										$columns++;
									}
								}
							}
							
						//}
					}

					//nilai bobot hard competency
					$nilai_hc = 0;
					foreach ($this->data_jenis_tes_asses as $a => $b) {
						foreach ($nilai as $k => $v) {
							if(strtolower($b['id_jenis_tes'])==strtolower($v['id_tes_asses'])){
								if(strtolower($v['id_tes_asses'])!='soft competency'){
									$nilai_temp = round($v['nilai']*$v['bobot_tes']/100,2,PHP_ROUND_HALF_UP);
									echo '<td>'.$nilai_temp.'</td>';
									$nilai_hc += $nilai_temp;
									$columns++;
								}
							}
						}
					}
					echo '<td>'.$nilai_hc.'</td>';
					$nilai_hc = round($nilai_hc*60/100,2,PHP_ROUND_HALF_UP);
					$nilai_sc = round($nilai_sc*40/100,2,PHP_ROUND_HALF_UP);
					$total = $nilai_hc + $nilai_sc;
					if($lulus){
						$simpulan = '<td style='.$p.'>Memenuhi</td>';
					}else{
						$simpulan = '<td style='.$s.'>Belum Memenuhi</td>';
					}
					echo '<td>'.$nilai_hc.'</td>';
					echo '<td>'.$nilai_sc.'</td>';
					echo '<td>'.$total.'</td>';
					echo $simpulan;
					echo "</tr>";
				}
			}else{
				echo '<tr>';
				echo '<td style="text-align:center;" colspan='.($this->jumlah_jenis_tes_asses*2+10).'>DATA TIDAK DITEMUKAN</td>';
				echo '</tr>';
			}
		?>
	</tbody>
</table>


<input type="button" class="button tiny" onclick="tableToExcel('laporan', 'Sheet_siji', 'laporan_hasil.xls')" value="Export to Excel">
<input type="button" class="button tiny" onclick="printData('laporan')" value="print" />
<div>
	
</div>
</div>
<script language="Javascript">
	
	var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();

        }
    })();


function printData(table)
{
	$('#'+table).removeClass('hide');
   var divToPrint=document.getElementById(table);
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
   $('#'+table).addClass('hide');
}

</script>
<!-- end of data assesment peserta -->
<?php } ?>
</div>
</div>