<?php
Class dbQuery{
	protected $user, $pass, $db, $host, $conn;
	

	function __construct(){
		global $conn, $user, $pass, $db, $host;
		$user = "root";$pass = "admin";$host = "localhost";$db="moodledb";
		// $user = "steffan";$pass = "chikungunyavirus";$host = "localhost";$db="chikv";
		// $user = "root";$pass = "";$host = "localhost";$db="chikv";

		$conn = new mysqli($host, $user, $pass, $db);
		if($conn -> connect_errno){
			echo "failed to connect to mysql:(". $conn->connect_errno .") ".$mysql->connect_error;
		}	
	}

	function a(){
		echo"something";
	}

	function b(){

	}

	function createSubject(){
		global $conn;
		$query_str = "create table if not exists subject( id int not null auto_increment, age int, sex char(1), onset date, seen date, address varchar (150), lon float, lat float, phone int, diagnosis varchar (150), referral char(1), symptoms varchar (150), notes varchar(500), primary key (id)) ";
		$resp = $conn->query($query_str);
		if($resp)
			return 1;
		return 0;
	}
	function createUser(){
		global $conn;
		$query_str = "create table if not exists users( username varchar(50) not null, password varchar(50) not null, primary key(username));";
		$resp = $conn->query($query_str);
		if($resp)
			return 1;
		return 0;
	}
	function validate($username, $password){
		global $conn;
		$query_str = "select * from users where username = '".$username."' and password = '".$password."';";
		$resp = $conn->query($query_str);
		return $resp;
	}
	function insert($dataObj){
		global $conn;
		$query_str = "insert into subject(age,sex,onset,seen,address, lon,lat,phone,diagnosis,referral,symptoms,notes) values(";
		$query_str = $query_str.$dataObj['age'].',\''.$dataObj['sex'].'\',\''.$dataObj['onset'].'\',\''.$dataObj['seen'].'\',\''.$dataObj['address'].'\','.$dataObj['lon'].',';
		$query_str = $query_str.$dataObj['lat'].','.$dataObj['phone'].',\''.$dataObj['diagnosis'].'\',\''.$dataObj['referral'].'\',\''.$dataObj['symptoms'].'\',\''.$dataObj['notes'].'\');';
		
		$resp = $conn->query($query_str);
		if($resp)
			return 1;
		return 0;	
	}

	function modify($updateVals, $constraints){
		global $conn;
		$query_str = "update subject SET ";
		foreach ($updateVals as $key => $value) {
			$query_str = $query_str.$key." = ".$value.",";
		}
		$query_str = substr($query_str, 0, strlen($query_str)-1); 
		if( count($constraints)>0){
			$query_str = $query_str." where ";
			foreach ($constraints as $key => $value) {
				$query_str = $query_str.$key." = ".$value.",";
			}
			$query_str = substr($query_str, 0, strlen($query_str)-1);
		}
		$query_str = $query_str.";";
		$resp = $conn->query($query_str);
		if($resp)
			return 1;
		return 0;	
	}

	function getAll(){
		global $conn;
		$query_str = " select * from subject;";
		$resp = $conn->query($query_str);
		
		$results = array();
		while ($row = $resp->fetch_assoc()) {
			unset($row['name']);
		   	array_push($results,$row);
		}
		return $results;
	} 

	function delete_subject($id){
		global $conn;
		$query_str = ' delete from subject where id = \''.$id.'\'';
		$resp = $conn->query($query_str);
		if($resp)
			return 1;
		return 0;	
	}

	function user_query($query){
		global $conn;
		$resp = $conn->query($query);
		// return  $resp;

		$results = array();
		while ($row = $resp->fetch_assoc()) {
			unset($row['name']);
		   	array_push($results,$row);
		}
		return $results;
	}
}//end of class

?>