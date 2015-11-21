<?php
Class dbQuery{

	protected $host = "localhost";
	protected $user = "root";
	protected $pass = "admin";
	protected $db = "moodledb";
	protected $conn = null;

	function __construct(){
		// $conn = new mysqli($host,$user,$pass,$db);
		global $conn;
		$conn = new mysqli("localhost","root","admin","moodledb");
		if($conn -> connect_errno){
			echo "failed to connect to mysql:(". $conn->connect_errno .") ".$mysql->connect_error;
		}	
	}

	function a(){
		echo"something";
	}

	function b(){

	}

	function initialization(){
		$query_str = "create table if not exists subject( id int not null auto_increment, age int, sex char(1), onset date, seen date, address varchar (150), lon float, lat float, phone int, diagnosis varchar (150), referral char(1), symptoms varchar (150), notes varchar(500), primary key (id)) ";
	
	}

	function insert($dataObj){
		global $conn;
		$query_str = "insert into subject(age,sex,onset,seen,address, lon,lat,phone,diagnosis,referral,symptoms,notes) values(";
		$query_str = $query_str.$dataObj['age'].',\''.$dataObj['sex'].'\',\''.$dataObj['onset'].'\',\''.$dataObj['seen'].'\',\''.$dataObj['address'].'\','.$dataObj['lon'].',';
		$query_str = $query_str.$dataObj['lat'].','.$dataObj['phone'].',\''.$dataObj['diagnosis'].'\',\''.$dataObj['referral'].'\',\''.$dataObj['symptoms'].'\',\''.$dataObj['notes'].'\');';
		
		$resp = $conn->query($query_str);
		return $resp;	
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
		return $resp;
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

	//--------------------------- 1 
	/*function school_count(){
		$code = "select name from mdl_cohort;";

		$resp = $this->$conn->query($code);
		$namelist = array();
		while ($row = $resp->fetch_assoc()) {
		   convert_name($row['name'],$namelist)."\n";
		}
		echo count($namelist)."\n";
		// print_r($namelist);
	}

	//-------------------------- 2
	function school_student_count(){
		$code = "select ". 
					"cm.cohortid,count(cm.userid) as 'amt',m.name ".
				"from ".
					"mdl_cohort_members cm, mdl_role_assignments r, mdl_cohort m ".
				"where ".
					"r.roleid = 5 and r.userid = cm.userid ".
				"and m.id = cm.cohortid ".
				"group by cm.cohortid ;";

		$resp = $conn->query($code);
		$school_count = array();
		$namelist = array();
		while ($row = $resp->fetch_assoc()) {
		   $key = convert_name($row['name'],$namelist);
		   if(array_key_exists($key, $school_count)){
		   		$school_count[$key] += $row['amt'];
		   }else{
		   		$school_count[$key] = $row['amt'];
		   }
		}
		print_r($school_count);
	}

	//-------------------3
	function active_students($threshold,$t_start,$t_stop){
		$code = "select ".
					"l.userid,count(l.id) as 'usage', c.name ".
				"from ".
					"mdl_logstore_standard_log l, mdl_role_assignments r, mdl_cohort c, mdl_cohort_members cm ".
				"where ".
					"r.userid = l.userid and r.roleid=5 ".
					"and cm.userid=l.userid and cm.cohortid=c.id ";
		if(( gettype($t_start) == "integer" or gettype($t_start) == "string") 
			and ( gettype($t_stop) == "integer" or gettype($t_stop) == "string")){
			$code = $code."and l.timecreated > ".$t_start." and l.timecreated < ".$t_stop." ";
		}
		$code = $code."group by l.userid ".
				"having count(l.id)>".$threshold.";";
		
		$resp = $conn->query($code);
		echo "number of active students ".$resp->num_rows."\n";
		// echo count($resp->count);
		/*$student_list = array();
		$namelist = array();
		while ($row = $resp->fetch_assoc()) {
			$key = convert_name($row['name'],$namelist);
		}

	}

	function active_students_bySchool($threshold,$t_start,$t_stop){
		$code = "select ".
					"l.userid,count(l.id) as 'amt', c.name ".
				"from ".
					"mdl_logstore_standard_log l, mdl_role_assignments r, mdl_cohort c, mdl_cohort_members cm ".
				"where ".
					"r.userid = l.userid and r.roleid=5 ".
					"and cm.userid=l.userid and cm.cohortid=c.id ";
		if(( gettype($t_start) == "integer" or gettype($t_start) == "string") 
			and ( gettype($t_stop) == "integer" or gettype($t_stop) == "string")){
			$code = $code."and l.timecreated > ".$t_start." and l.timecreated < ".$t_stop." ";
		}
		$code = $code."group by l.userid ".
				"having count(l.id)>".$threshold.";";
		
		$resp = $conn->query($code);
		
		$school_count = array();
		$namelist = array();
		while ($row = $resp->fetch_assoc()) {
			$key = convert_name($row['name'],$namelist);
			if(array_key_exists($key, $school_count)){
		   		$school_count[$key] += 1;
		   }else{
		   		$school_count[$key] = 1;
		   }
		}
		arsort($school_count);
		print_r($school_count);
	}

	function active_teachers($threshold,$t_start,$t_stop){
		$code = "select ".
					"l.userid,count(l.id) as 'amt', c.name ".
				"from ".
					"mdl_logstore_standard_log l, mdl_role_assignments r, mdl_cohort c, mdl_cohort_members cm ".
				"where ".
					"r.userid = l.userid and (r.roleid=3 or r.roleid=4) ".
					"and cm.userid=l.userid and cm.cohortid=c.id ";
		if(( gettype($t_start) == "integer" or gettype($t_start) == "string") 
			and ( gettype($t_stop) == "integer" or gettype($t_stop) == "string")){
			$code = $code."and l.timecreated > ".$t_start." and l.timecreated < ".$t_stop." ";
		}
		$code = $code."group by l.userid ".
				"having count(l.id)>".$threshold.";";
		
		$resp = $conn->query($code);
		echo "number of active students ".$resp->num_rows."\n";
		// echo count($resp->count);
		$teacher_list = array();
		$namelist = array();
		while ($row = $resp->fetch_assoc()) {
			// $key = convert_name($row['name'],$namelist);
			$teacher_list[($row['userid'])]=$row['amt'];
		}
		print_r($teacher_list);

	}

	function convert_name($name,&$namelist){
		$parts = explode("-",$name);
		$base_name = "";
		foreach($parts as $sub){
			$temp = $base_name.$sub;
			if(in_array($temp, $namelist)){
				return $temp;				
			}else if(strlen($sub)<=1){
				break;
			}
			$base_name = $temp;
		}
		array_push($namelist, $base_name);
		return $base_name;
	}*/

}//end of class

/*	
	$db = new dbQuery();

	$db->a();
	echo "test\n";*/
	/*
	$db->school_student_count();
	$db->active_students(10,0,1444173037);
	$db->active_students_bySchool(10,0,1444173037);
	$db->active_teachers(10,0,1444173037);*/
	//echo $conn;

	/*$conn->real_query("SELECT distinct(id) FROM cohort ORDER BY id ASC");
	$res = $conn->use_result();

	echo "Result set order...\n";
	while ($row = $res->fetch_assoc()) {
	    echo " id = " . $row['distinct(id)'] . "\n";
	}*/
?>