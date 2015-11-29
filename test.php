<?php
// include 'db.php';
include 'manager.php';
$salt = 'salty salty salt';
// $db = new dbQuery();
$mysqltime = date ("Y-m-d", 1448004564);
$dataObj = array(
	'age' => '1992',
	'sex' => 'f',
	'onset' => ''.$mysqltime.'',
	'seen' => ''.$mysqltime.'',
	'address' => 'St Agustine Hill',
	'lon' => 1.2234,
	'lat' => 2.3434,
	'phone' => 2242323,
	'diagnosis' => 'the patient is amazing and cute',
	'referral' => 'N',
	'symptoms' => 'butterflies',
	'notes' => 'Im unsure of this person, kinda shy, we exchanged thoughts, she cried for me');

// $constraintsObj = array('id' => '3');
// $db->modify($dataObj,$constraintsObj);
// update($dataObj,$constraintsObj);
// $results = $db->getAll();
$password = "passgunya1";
$hashedPass = hash('md5',$password.$salt);
echo $hashedPass;
// login('dave','chickpass1');
//9ef9720585ec6a9af16c76f5fee34c55
//9ef9720585ec6a9af16c76f5fee34c55
echo "test\n";
?>