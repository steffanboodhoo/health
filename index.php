<?php

require 'vendor/autoload.php';
include 'manager.php';
date_default_timezone_set('Atlantic/Bermuda');
$app = new \Slim\Slim();
 $app->config(array(
    'debug' => true,
    'templates.path' => './templates'
));
$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => '20 minutes',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'slim_session',
    'secret' => 'SPECIAL_STUFF',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));
//----------
 if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    }
    //----------

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


// $_SESSION['working'] = 'no';
// $_SESSION['user_access'] = 0;//changingthis breiaks the ap kinda weird
$app->get('/test', function(){
    echo 'pew pew pew';
});

$app->get('/', function()use ($app) {
    $app->render('login.php');
});


$app->get('/home', function() use ($app) {
    $app->render('home.php');

});

$app->get('/getAll',function(){
	echo getAll();//in manager.php
});

$app->get('/validate',function(){
	global $_SESSION;
	$returnObj['status'] = 0;
	if(isset($_SESSION['user_access']))
		$returnObj['status'] = $_SESSION['user_access'];
	echo json_encode($returnObj);// 0 false > 0 true
});
$app->get('/logout',function(){
	global $_SESSION;
	$_SESSION['user_access'] = 0;
	$returnObj['status']=1;
	echo json_encode($returnObj);// 0 false > 0 true
});

$app->post('/subject',function() use ($app){
	$allPostVars = $app->request->post();
	echo createSubject($allPostVars);//in manager.php
});
$app->post('/subject/update',function() use ($app){
	$allPostVars = $app->request->post();
	$updateObj = $allPostVars['update']; 
	$constraints = $allPostVars['constraint'];
	update($updateObj, $constraints);//in manager.php
});
$app->post('/login',function() use ($app){
	$allPostVars = $app->request->post();
	global $_SESSION;
	$_SESSION['user_access'] = login($allPostVars['username'], $allPostVars['password']); 
	$returnObj['status'] = $_SESSION['user_access'];// 0 false, > 0 true
	echo json_encode($returnObj);
});
$app->get('/subject/delete/:id', function ($id) {
	if($_SESSION['user_access']==1){
    	echo deleteSubject($id);
	}
});

$app->run();