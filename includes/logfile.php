<?php
    function logger($log) {
    	if (!file_exists('log.txt')) {
    		// code...
    		file_put_contents('log.txt', '');
    	}

    	$ip = $_SERVER['REMOTE_ADDR'];
    	$time = date('m/d/y h:iA', time());

    	$contents = file_get_contents('log.txt');
    	$contents .= "$ip\t$time\t$log\r";

    	file_put_contents('log.txt', $contents);
    }

    // For checking users that tried to access unauthorized page
    function loggerPage($logPage) {
    	if (!file_exists('unauthorized.txt')) {
    		// code...
    		file_put_contents('unauthorized.txt', '');
    	}

    	$ipOfUnauthorize = $_SERVER['REMOTE_ADDR'];
    	$timeUnauthorized = date('m/d/y h:iA', time());

    	$contents = file_get_contents('unauthorized.txt');
    	$contents .= "$ipOfUnauthorize\t$timeUnauthorized\t$logPage\r";

    	file_put_contents('unauthorized.txt', $contents);
    }


?>