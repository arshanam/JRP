<?php
error_reporting(E_ALL);
ob_start();
@session_start();

setlocale(LC_TIME, 'Indonesian');
ini_set('date.timezone', 'Asia/Jakarta');
set_time_limit(0);

$conn = FALSE;
$readonly = 'readonly="readonly"';
$sess_user_id = (isset($_SESSION['USER_ID'])) ? $_SESSION['USER_ID'] : '';
$sess_db = (isset($_SESSION['DB'])) ? $_SESSION['DB'] : '';
$sess_app_id = (isset($_SESSION['APP_ID'])) ? $_SESSION['APP_ID'] : '';

#================ INCLUDE ================
require_once('adodb/adodb.inc.php');
require_once('functions.php');

#============== APPLICATION ==============
define('BASE_URL', 'http://localhost/market/');
define('BASE_APP', BASE_URL . 'app/');
define('APP_ROOT', 'C:\\uwamp\\www\\market\\');

#=============== DATABASE ================
define('DNS', TRUE);

define('DRIVER', 'mssql');
define('HOST', 'way\SQLEXPRESS');
define('USR', '');
define('PWD', '');

