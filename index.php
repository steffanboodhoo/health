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
$_SESSION['access'] = false;

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
	$_SESSION['access'] = login($allPostVars['username'], $allPostVars['password']); 
});

$app->run();