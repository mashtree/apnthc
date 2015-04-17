{

<?php

$total_vol_gaji = 0;
$total_vol_non_gaji = 0;

$total_vol_gaji += $this->data_sp2d_rekap->get_vol_gaji();
$total_vol_non_gaji += $this->data_sp2d_rekap->get_vol_non_gaji();

?>

    "title" : "Nominal SP2D",

    "pieData" : [

        {
            "value" : <?php echo $total_vol_gaji; ?>,
            "index" : "<?php echo (number_format(round(($total_vol_gaji / 1000000000), 2), 2)." M"); ?>",
            "label" : "Gaji",
            "color" : "#409ACA"
        },
        {
            "value" : <?php echo $total_vol_non_gaji; ?>,
            "index" : "<?php echo (number_format(round(($total_vol_non_gaji / 1000000000), 2), 2)." M"); ?>",
            "label" : "Non Gaji",
            "color" : "#8E5696"
        }

    ]

}