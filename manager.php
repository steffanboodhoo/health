<?php

include 'db.php';
$salt = 'salty salty salt';
function getAll(){
	$db = new dbQuery();
	$results = $db->getAll();
	$columns = array('0'=>'id','1'=>'age','2'=>'sex','3'=>'address','4'=>'onset','5'=>'seen','6'=>'referral','7'=>'diagnosis','8'=>'symptoms','9'=>'notes');
	$return_obj = array(
		'data' => $results,
		// 'columns' => ['id','age','sex','address','onset','seen','referral','diagnosis','symptoms','notes']
		'columns' => $columns
	);
	return json_encode($return_obj);
}

function createSubject($dataObj){
	$dataObj['onset'] = date ("Y-m-d", $dataObj['onset']);
	$dataObj['seen'] = date ("Y-m-d", $dataObj['seen']);
	//print_r($dataObj);
	$db = new dbQuery();
	$resp = $db->insert($dataObj);
	$return_obj['status']=$resp;
	return json_encode($return_obj);
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
// dave chickpass1
function login($username, $password){
	global $salt;
	$db = new dbQuery();
	$hashedPass = hash('md5',$password.$salt);
	// echo $hashedPass;
	$resp = $db->validate($username,$hashedPass);
	if($resp->num_rows > 0 ){
		return 1;
	}
	return 0;
}

function deleteSubject($id){
	$db = new dbQuery();
	$resp = $db->delete_subject($id);
	$return_obj['status'] = $resp;
	return json_encode($return_obj);
}	

?>