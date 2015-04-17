{

    "title" : "SPM Dalam Proses",

    "listHeader" : ["Nomor SPM", "User", "Waktu Mulai"],

    "listType" : ["String", "String", "String"],

    "listRow" : [

    <?php

    $pos_count = 0;

    foreach ($this->data_pos_spm as $value) {
        if ($pos_count > 0) {
            echo ' , ';
        }
        echo '{';
        
            echo '"listCol" : [';
        
                echo '"'.$value->get_invoice_num().'" , "'.$value->get_to_user().' ('.$value->get_fu_description() .')" , "'.$value->get_begin_date().' '.$value->get_time_begin_date().'"';
        
            echo ']';
        
        echo '}';
        
        $pos_count++;
    }

    ?>

    ]

}