<?php

require 'vendor/autoload.php';
include 'manager.php';

$app = new \Slim\Slim();
 $app->config(array(
    'debug' => true,
    'templates.path' => './templates'
));

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


$_SESSION['working'] = 'no';
$_SESSION['user_access'] = 0;//changingthis breiaks the ap kinda weird
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
	if(isset($_SESSION['access']))
		echo "{'status':".$_SESSION['access']."}";
	else
		echo "{'status':0}";
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
	$_SESSION['user_access'] = login($allPostVars['username'], $allPostVars['password']); 
	if($_SESSION['user_access'] > 0)
		echo "{'status':'1'}";
	else
		echo "{'status':'0'}";
});


$app->run();