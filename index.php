<?php
session_start();
header('X-Frame-Options: DENY');
header("Content-type: text/html; charset=utf-8");
session_name("lemivoyage");
date_default_timezone_set('Asia/Tbilisi');
error_reporting(0); 
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
ini_set('memory_limit', '5120M');
ini_set('display_errors', 0);
ini_set('session.cookie_httponly', 1);


try{
	if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
	    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    header('HTTP/1.1 301 Moved Permanently');
	    header('Location: ' . $redirect);
	    exit();
	}
	if(preg_match('/www/', $_SERVER['HTTP_HOST'])){ 
	  require_once 'app/core/Config.php';
	  require_once 'app/functions/redirect.php';
	  functions\redirect::url(Config::WEBSITE);
	}
	require_once 'app/init.php';
	$app = new App;
}catch(Exception $e){
	die("Error");
}
?>
