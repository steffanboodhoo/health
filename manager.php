<?php

include 'db.php';

function getAll(){
	$db = new dbQuery();
	$results = $db->getAll();
	$return_obj = array(
		'data' => $results,
		'columns' => ['id','age','sex','address','onset','seen','referral','diagnosis','symptoms','notes']
	);
	return json_encode($return_obj);
}

function createSubject($dataObj){
	$dataObj['onset'] = date ("Y-m-d", $dataObj['onset']);
	$dataObj['seen'] = date ("Y-m-d", $dataObj['seen']);
	print_r($dataObj);
	$db = new dbQuery();
	$resp = $db->insert($dataObj);
	return $resp;
}

function update($dataObj,$constraintObj){
	$dataObj['onset'] = date ("Y-m-d", $dataObj['onset']);
	$dataObj['seen'] = date ("Y-m-d", $dataObj['seen']);

	$dataObj['address'] = '\''.$dataObj['address'].'\'';
	// $dataObj['sex'] = '\''.$dataObj['sex'].'\'';
	// $dataObj['referral'] = '\''.$dataObj['referral'].'\'';
	$dataObj['diagnosis'] = '\''.$dataObj['diagnosis'].'\'';
	$dataObj['notes'] = '\''.$dataObj['notes'].'\'';
	$dataObj['symptoms'] = '\''.$dataObj['symptoms'].'\'';
	$dataObj['onset'] = '\''.$dataObj['onset'].'\'';
	$dataObj['seen'] = '\''.$dataObj['seen'].'\'';
	$db = new dbQuery();
	$db->modify($dataObj,$constraintObj);
}

?>