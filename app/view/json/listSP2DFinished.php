{

    "title" : "SP2D Selesai",

    "listHeader" : ["Nomor SP2D", "Jenis SP2D", "Nominal"],

    "listType" : ["String", "String", "Number"],

    "listRow" : [

    <?php

    $pos_count = 0;

    foreach ($this->data_list_sp2d as $value) {
        if ($pos_count > 0) {
            echo ' , ';
        }
        echo '{';
        
            echo '"listCol" : [';
        
                echo '"'.$value->get_check_number().'" , "'.$value->get_jenis_sp2d().'" , '.$value->get_nominal_sp2d().'';
        
            echo ']';
        
        echo '}';
        
        $pos_count++;
    }

    ?>

    ]

}