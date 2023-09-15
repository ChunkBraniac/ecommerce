<?php

require_once 'logfile.php';

$log = "User visited ".$_SERVER['PHP_SELF'];
logger($log);
echo 'You are not authorized to view this page, <a href="../index.php" title="">go back</a>';

?>