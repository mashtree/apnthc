<?php

class CSV{
	
	static function readCSV($file){
		$return = array();
		if(($open = fopen($file,"r"))!==FALSE){
			while(($data=fgetcsv($open,1000,';'))!==FALSE){
				$num = count($data);
				$return[] = $data;
			}
		}
		fclose($open);
		return $return;
	}

	static function writeCSV($file, $data=array()){
		
	}
}