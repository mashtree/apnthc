{

<?php



?>

    "title" : "Retur SP2D",

    "pieData" : [

        {
            "value" : <?php echo $this->data_retur->get_retur_sudah_proses(); ?>,
            "index" : "<?php echo (number_format($this->data_retur->get_retur_sudah_proses())." (".number_format(round($this->data_retur->get_vol_retur_sudah_proses() / 1000000000, 2), 2)." M)"); ?>",
            "label" : "Sudah Proses",
            "color" : "#409ACA"
        },
        {
            "value" : <?php echo $this->data_retur->get_retur_belum_proses(); ?>,
            "index" : "<?php echo (number_format($this->data_retur->get_retur_belum_proses())." (".number_format(round($this->data_retur->get_vol_retur_belum_proses() / 1000000000, 2), 2)." M)"); ?>",
            "label" : "Belum Proses",
            "color" : "#F6CE40"
        }

    ]

}