<?php

/*
 * error reporting on
 */

error_reporting(E_ALL ^ E_NOTICE);

/*
 * define the sitepath POK SISI/
 */

$sitepath = realpath(dirname(__FILE__));
define('ROOT',$sitepath);

//echo $sitepath;

/*
 * define the sitepath url
 */

$base_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/';

define('URL',$base_url);

define('APP','Aplikasi Penghitung Nilai Tes Hard Competency');

/*
 * define role
 */
define('PLATINUM','admin'); //super duper admin
define('GOLD','koordinator'); //koordinator
define('SILVER','inputer'); //inputer nilai

$path = array(
    ROOT.'/libs/',
    ROOT.'/app/controllers/',
    ROOT.'/app/models/'
);

//include ROOT.'/config/config.php';
include ROOT.'/libs/Autoloader.php';
include ROOT.'/libs/config.php';
include ROOT.'/app/akses.php';

Autoloader::setCacheFilePath(ROOT.'/libs/cache.txt');
Autoloader::setClassPaths($path);
Autoloader::register();
$registry = new Registry();
//$registry->upload = new Upload();
$registry->view = new View();
$registry->db = new Database();
$registry->auth = new Auth();
$registry->auth->add_roles(PLATINUM); //admin
$registry->auth->add_access('home',PLATINUM,$akses['Home']);
$registry->auth->add_access('referensi',PLATINUM,$akses['Referensi']);
$registry->auth->add_access('assesment',PLATINUM,$akses['Assesment']);
$registry->auth->add_access('wekdal',PLATINUM,$akses['Wekdal']);
$registry->auth->add_access('auth',PLATINUM,'logout');
$registry->auth->add_roles(GOLD); //operator
$registry->auth->add_access('home',GOLD,$akses['Home']);
$registry->auth->add_access('assesment',GOLD,$akses['Assesment']);
$registry->auth->add_access('auth',GOLD,'logout');
$registry->auth->add_roles(SILVER); //viewer
$registry->auth->add_access('home',SILVER,$akses['Home']);
$registry->auth->add_access('assesment',SILVER,$akses['Assesment_silver']);
$registry->auth->add_access('auth',SILVER,'logout');
$registry->auth->add_roles('guest'); //admin
$registry->auth->add_access('home','guest',$akses['Home']);
$registry->auth->add_access('auth','guest',$akses['Auth']);
$registry->exception = new ClassException();
$registry->bootstrap = new Bootstrap($registry);

$registry->bootstrap->loader();
