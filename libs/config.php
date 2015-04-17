<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
|
| setting database
|
*/
define('DB_TYPE','mysql');
define('DB_HOST','localhost');
define('DB_NAME','poksisi');
define('DB_USER','root');
define('DB_PASS','');

/*
|
| tipe file
|
*/
define('PDF_EXT', 'application/pdf');
define('DOC_EXT', 'application/msword');
define('DOCX_EXT', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
define('DOCX2_EXT', 'application/octet-stream');
define('JPEG', 'image/jpeg');
define('DIR_UPLOAD', 'upload/');

/*
|
| time zone
|
*/
date_default_timezone_set('Asia/Jakarta');

/*
|
| maksimal session expired in second
|
*/
define('MAX_SESSION', 3600); //dalam detik

define('HASH_GENERAL_KEY', 'MixitUp200');

/*
|
| hash key
|
*/
define('HASH_SALT_KEY', 'kolokulokelaskalihkulokaliankoncokoncoklayapan');

/*
|
| title
|
*/
define('TITLE','.:POK SISI:.');

/*
|
| set time limit
|
*/
ini_set('max_execution_time', 600);