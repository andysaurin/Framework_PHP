<?php

$this->template->assign('module', $_GET['module'] );
if ( $_GET['class'] )
	$this->template->assign('class', $_GET['class'] );
else
	$this->template->assign('class', 'index' );

$this->template->assign('event', $_GET['event'] );

$this->template->assign('module_title', $this->module->module_title);
$this->template->assign('class_title',$this->module->class_title);

if ( $_SERVER['HTTP_X_REQUESTED_HOST'] )
	$host = $_SERVER['HTTP_X_REQUESTED_HOST'];
else
	$host = $_SERVER['SERVER_NAME']; //but see http://stackoverflow.com/questions/2297403/http-host-vs-server-name

if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ) {
	$protocol = 'https';
	$this->template->assign('ssl', true );
	$this->template->assign('static_port', 82 ); //The nginx port where we will server static content from
	
}else{
	$protocol = 'http';
	$this->template->assign('ssl', false );
	$this->template->assign('static_port', 81 ); //The nginx port where we will server static content from
}

$this->template->assign('host', "{$protocol}://{$host}" );
$this->template->assign('request_uri', $_SERVER['REQUEST_URI'] );

$this->template->assign('now', time() );

//set_include_path( SYSTEM_DOCUMENT_ROOT . '/:'. get_include_path() );
$this->template->assign('docroot', SYSTEM_DOCUMENT_ROOT);


$this->template->assign('main_css', file_get_contents(SYSTEM_DOCUMENT_ROOT."/stylesheets/main.css") );

$this->template->assign('reCaptcha_key', RECAPTCHA_PUBLIC_KEY);

?>