{
    "title" : "Histori Penerbitan SP2D",

    "lineData" : {

        "labels" : [

        <?php 

        //var_dump($this->data_sp2d_rekap);

        for ($i=($this->periode - 1); $i>=0; $i--) {
            if ($i < ($this->periode - 1)) {
                echo ' , ';
            }
            echo '"'.date("d-m",time()-($i*24*60*60)).'"';
        } ?>

        ],

        "datasets" : [
            {
                "fillColor" : "rgba(64,154,202,0.5)",
                "strokeColor" : "rgba(64,154,202,1)",
                "pointColor" : "rgba(64,154,202,1)",
                "pointStrokeColor" : "#fff",
                "data" : [
                
                <?php for ($i=($this->periode - 1); $i>=0; $i--) {
                    if ($i < ($this->periode - 1)) {
                        echo ' , ';
                    }
                    echo ''.$this->data_sp2d_rekap[$i]->get_gaji().'';
                } ?>
                
                ]
            },
            {
                "fillColor" : "rgba(142,86,150,0.5)",
                "strokeColor" : "rgba(142,86,150,1)",
                "pointColor" : "rgba(142,86,150,1)",
                "pointStrokeColor" : "#fff",
                "data" : [

                <?php for ($i=($this->periode - 1); $i>=0; $i--) {
                    if ($i < ($this->periode - 1)) {
                        echo ' , ';
                    }
                    echo ''.$this->data_sp2d_rekap[$i]->get_non_gaji().'';
                } ?>

                ]
            },
            {
                "fillColor" : "rgba(246,206,64,0.5)",
                "strokeColor" : "rgba(246,206,64,1)",
                "pointColor" : "rgba(246,206,64,1)",
                "pointStrokeColor" : "#fff",
                "data" : [

                <?php for ($i=($this->periode - 1); $i>=0; $i--) {
                    if ($i < ($this->periode - 1)) {
                        echo ' , ';
                    }
                    echo ''.$this->data_sp2d_rekap[$i]->get_lainnya().'';
                } ?>    

                ]
            },
            {
                "fillColor" : "rgba(227,92,92,0.5)",
                "strokeColor" : "rgba(227,92,92,1)",
                "pointColor" : "rgba(227,92,92,1)",
                "pointStrokeColor" : "#fff",
                "data" : [

                <?php for ($i=($this->periode - 1); $i>=0; $i--) {
                    if ($i < ($this->periode - 1)) {
                        echo ' , ';
                    }
                    echo ''.$this->data_sp2d_rekap[$i]->get_void().'';
                } ?>

                ]
            }
        ]

    }

}