<?php

class Eselon {

	public static function to_eselon($es){

		switch($es){
			case '11':
				return 'I.a';
			case '12':
				return 'I.b';
			case '21':
				return 'II.a';
			case '22':
				return 'II.b';
			case '31':
				return 'III.a';
			case '32':
				return 'III.b';
			case '41':
				return 'IV.a';
			case '42':
				return 'IV.b';
			case '99':
				return '-';
		}
	}

	public static function from_eselon($es){

		switch($es){
			case 'I.a':
				return '11';
			case 'I.b':
				return '12';
			case 'II.a':
				return '21';
			case 'II.b':
				return '22';
			case 'III.a':
				return '31';
			case 'III.b':
				return '32';
			case 'IV.a':
				return '41';
			case 'IV.b':
				return '42';
			case '-':
				return '99';
		}
	}




	public static function to_role($es){

		switch($es){
			case 1:
				return 'PLATINUM';
			case 2:
				return 'GOLD';
			case 3:
				return 'SILVER';
		}
	}

	public static function from_role($es){

		switch($es){
			case 'PLATINUM':
				return 1;
			case 'GOLD':
				return 2;
			case 'SILVER':
				return 3;
		}
	}

}