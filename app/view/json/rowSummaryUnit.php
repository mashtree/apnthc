{

<?php

$total_gaji = 0;
$total_non_gaji = 0;
$total_lainnya = 0;
$total_void = 0;

foreach ($this->data_sp2d_rekap as $sp2d_rekap_harian) {
    $total_gaji += $sp2d_rekap_harian->get_gaji();
    $total_non_gaji += $sp2d_rekap_harian->get_non_gaji();
    $total_void += $sp2d_rekap_harian->get_void();
    $total_lainnya += $sp2d_rekap_harian->get_lainnya();
}

$total_lhp_completed = 0;
$total_lhp_validated = 0;
$total_lhp_error = 0;
$total_lhp_etc = 0;

$tanggal_lhp = "";

//var_dump($this->data_lhp_rekap);

foreach ($this->data_lhp_rekap as $lhp_rekap_harian) {
    $tanggal_lhp = $lhp_rekap_harian->get_tgl_lhp();
    $total_lhp_completed += $lhp_rekap_harian->get_lhp_completed();
    $total_lhp_validated += $lhp_rekap_harian->get_lhp_validated();
    $total_lhp_error += $lhp_rekap_harian->get_lhp_error();
    $total_lhp_etc += $lhp_rekap_harian->get_lhp_etc();
}

?>

    "rowHeader" : "<?php echo $this->nama_lengkap_unit; ?>",
    "rowLink" : "<?php echo URL."home/harian/".$this->nama_unit; ?>",
    "rowContents" : [ 

        <?php echo count($this->data_pos_spm); ?>, 
        <?php echo $total_gaji; ?>, 
        <?php echo $total_non_gaji; ?>, 
        <?php echo $total_lainnya; ?>, 
        <?php echo $total_void; ?>, 
        <?php echo $this->data_retur->get_retur_sudah_proses(); ?>, 
        <?php echo $this->data_retur->get_retur_belum_proses(); ?>, 
        <?php echo $total_lhp_completed; ?>, 
        <?php echo $total_lhp_validated; ?>,
        <?php echo $total_lhp_etc; ?>,
        <?php echo $total_lhp_error; ?>
        
    ]

}