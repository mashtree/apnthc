{

<?php

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

    "title" : "LHP <?php if ($this->periode == 1) { echo '('.$tanggal_lhp.')'; } ?>",

    "pieData" : [

        {
            "value" : <?php echo $total_lhp_completed; ?>,
            "index" : "<?php echo number_format($total_lhp_completed); ?>",
            "label" : "Completed",
            "color" : "#409ACA"
        },
        {
            "value" : <?php echo $total_lhp_validated; ?>,
            "index" : "<?php echo number_format($total_lhp_validated); ?>",
            "label" : "Validated",
            "color" : "#8E5696"
        },
        {
            "value" : <?php echo $total_lhp_etc; ?>,
            "index" : "<?php echo number_format($total_lhp_etc); ?>",
            "label" : "Lainnya",
            "color" : "#F6CE40"
        },
        {
            "value" : <?php echo $total_lhp_error; ?>,
            "index" : "<?php echo number_format($total_lhp_error); ?>",
            "label" : "Error",
            "color" : "#E35C5C"
        }

    ]

}