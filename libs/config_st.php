<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//setting database
define('DB_TYPE', '');
define('DB_HOST', '10.100.244.253');
define('DB_NAME', 'DEVSPANDB');
define('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.100.244.253)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=DEVSPANDB)(INSTANCE_NAME= DEVSPANDB)))');
define('DB_USER', 'USRAPL_ST');
define('DB_PASS', 'strestes');

//end setting database

define('PDF_EXT', 'application/pdf');
define('DOC_EXT', 'application/msword');
define('DOCX_EXT', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
define('DOCX2_EXT', 'application/octet-stream');
define('JPEG', 'image/jpeg');
define('DIR_UPLOAD', 'upload/');


date_default_timezone_set('Asia/Jakarta');

define('HASH_GENERAL_KEY', 'MixitUp200');

define('HASH_SALT_KEY', 'kolokulokelaskalihkulokaliankoncokoncoklayapan');
