<?php
#region Config
define('PUB_DIR', getenv('DOCUMENT_ROOT').'/');
define('PUB_DIR_FILES', PUB_DIR.'files/');
define('SYS_DIR', dirname(PUB_DIR).'/php/');

define('PUB_DIR_SHOP', PUB_DIR.'/images/shop/');

define('Conf_DIR', SYS_DIR.'/Conf/');

//define('SYS_CONF', SYS_DIR.'conf/');

header("Content-Encoding: gzip");
ob_start("ob_gzhandler")or die('f1');

require_once Conf_DIR.'config.php';




//echo '<hr>'.rand(1, 11111111111);



//$dbConect->CloseConection();

ob_end_flush()or die('f2');

?>