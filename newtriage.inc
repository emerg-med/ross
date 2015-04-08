<?php 
 

	##### get variables off array
	$TriageNurse = $arr_request['TriageNurse'];
	$NewPtTriageCategory = $arr_request['TriageCategory'];
	$TriageDiagnosis = cleanup($arr_request['TriageDiagnosis']);
	$FirstName = ucfirst(cleanup($arr_request['FirstName']));
	$Surname = ucfirst(cleanup($arr_request['Surname']));
	$Age = cleanup($arr_request['Age']);
	$Sex = $arr_request['Sex'];

if (!$Sex) {$Sex="M";}

	$Location  = $arr_request['Location'];
	$TriageNurseCode = $arr_request['TriageNurseCode'];

	$TriageTimeStamp = $arr_request['TriageTimeStamp'];
	
	####### validate form data
	$tovalidate = array ('TriageNurse','TriageDiagnosis', 'FirstName', 'Surname', 'TriageNurseCode');
	validateform ( $arr_request, $tovalidate );
	
	
	####  get the triage queue ordered from the bottom up using dynamic variables
	
	$pos_update_sql = "SELECT key_ID, TriagePosition, TriageCategory FROM Patients WHERE Doctor = '' ORDER BY TriagePosition DESC";
	$pos_result = mysql_db_query($dbname, $pos_update_sql, $id_link);
	if (! $pos_result) { affy_error_exit('SQL Select Execution has failed.');}
	
	$num_intriagequeue = mysql_num_rows ($pos_result);
	
if ($num_intriagequeue){ #if no one in queue, set triage posn to 1

	for ($n = $num_intriagequeue; $n>0; $n--){
	$queueposition = "queueposition$n";
	${$queueposition} = mysql_fetch_array($pos_result);
	}

####  find out where new patient should go

	for ($n = $num_intriagequeue; $n>0; $n--){
		$queueposition = "queueposition$n";

		if (${$queueposition}[TriageCategory] <= $NewPtTriageCategory ){
			$new_position_in_q = ${$queueposition}[TriagePosition]+1;
		
		#	print '<HR>'.$new_position_in_q.'<HR>';
		
			break;
			}
		else {$new_position_in_q = 1;}
		
		# print ${$queueposition}[TriagePosition].'&nbsp;&nbsp;'.${$queueposition}[TriageCategory].'<BR>';
		}
		
	####  make space by moving those behind the new entry down
	
	for ($n = ($num_intriagequeue); $n >= $new_position_in_q ; $n--){
	
		$str_sql = "UPDATE Patients SET	TriagePosition = '".($n + 1)."' WHERE TriagePosition = '".$n."'";
		
print $strsql;

		$result = mysql_db_query($dbname, $str_sql, $id_link);
		if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
		}
	
	### put the new patient in 

	$TriagePosition = $new_position_in_q;

}
else {$TriagePosition = '1';}


	##### insert new patient
	$str_sql = "insert into Patients 
	( TriageNurse, TriageCategory, TriageDiagnosis, TriageTimeStamp, FirstName, Surname, Age, Sex, Location, TriageNurseCode, TriagePosition, Doctor)
	VALUES 
	( '$TriageNurse', '$NewPtTriageCategory', '$TriageDiagnosis', '$TriageTimeStamp', '$FirstName', '$Surname', '$Age', '$Sex', '$Location', '$TriageNurseCode', '$TriagePosition', '')";
			
	$result = mysql_db_query($dbname, $str_sql, $id_link);

	if (! $result) {
	affy_error_exit('SQL Select Execution has failed.');
	}
	else{}

  




?>