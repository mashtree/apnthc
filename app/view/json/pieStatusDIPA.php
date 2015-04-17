{

    "title" : "Pagu (<?php echo (number_format(round((($this->data_summary_dipa->get_dipa_terpakai() + $this->data_summary_dipa->get_dipa_sisa()) / 1000000000), 2), 2)." M"); ?>)",

    "pieData" : [

        {
            "value" : <?php echo $this->data_summary_dipa->get_dipa_terpakai(); ?>,
            "index" : "<?php echo (number_format(round(($this->data_summary_dipa->get_dipa_terpakai() / 1000000000), 2), 2)." M"); ?>",
            "label" : "Realisasi",
            "color" : "#409ACA"
        },
        {
            "value" : <?php echo $this->data_summary_dipa->get_dipa_sisa(); ?>,
            "index" : "<?php echo (number_format(round(($this->data_summary_dipa->get_dipa_sisa() / 1000000000), 2), 2)." M"); ?>",
            "label" : "Saldo",
            "color" : "#8E5696"
        }

    ]

}