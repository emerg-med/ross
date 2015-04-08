<?php 

#phpinfo();

$key_ID = $arr_request['key_ID'];


# check we are updating a valid record
	$str_sql = "Select Doctor from Patients where key_ID = $key_ID";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
if ((! $key_ID)  || (mysql_num_rows($result) == 0)) {
	error ("Sorry! That Patient has been discharged","or does not exist");
	}

#	$doc = mysql_fetch_row($result);




# calculate age function
$dobday =  $arr_request['dobday'];
$dobmonth = $arr_request['dobmonth'];
$dobyear = $arr_request['dobyear'];


if (!$dobday|| !$dobmonth || !$dobyear || $dobday=='00' || $dobmonth=='00'){ 
	$Age = $arr_request['Age'];#if no dob set, then use age as set by triage
	}
	else{

	$isValid = checkdate($dobmonth,$dobday,$dobyear);#
	if ($isValid == FALSE) {
		error ("The date of birth is not valid", "press the 'back' button to go back and change it");
		}

	$ageyears = $todayyear - $dobyear;#work out age

	if (($todaymonth< $dobmonth) || (($todaymonth == $dobmonth) && ($todayday < $dobday))) 
	{$ageyears-- ;}# if not had birthday this year, then subtract 1

	if ($ageyears < 0){#exclude those still not born
		error("This patient hasn't been born yet!","Go back and have another go");
	}

	if ($ageyears <2){#if less than 2yrs, convert to unixtime
		
		$age = (time()-mktime(23,59,59,$dobmonth,$dobday,$dobyear))/86400; # age in days

		switch ($age){

			case $age > 90:
				$Age = floor($age/30)." months";
				break;

			case $age > 14:
				$Age = floor($age/7)." weeks";
				break;

			default:
				$age = floor($age+1);
				if ($age == 1){
					$Age="1 day";
					}else{
					$Age=$age." days";
					}
			}
		}
		else { 
		$Age = $ageyears;
	} 
}


$DateOfBirth = $dobday.$dobmonth.$dobyear;


$FirstName = cleanup($arr_request['FirstName']);
$Surname = cleanup($arr_request['Surname']);


$UR = trim(cleanup($arr_request['UR']));
$Medicare = substr(cleanup($arr_request['Medicare']),0,10);##### takes the first ten numbers
if ($Medicare){
	$MedicareSuffix = strtoupper(substr($FirstName,0,3));
	}
elseif (! $arr_request['MedicareSuffix']){
	$MedicareSuffix = 'C-U';
	}
else{
	$MedicareSuffix = cleanup($arr_request['MedicareSuffix']);
	}

$DVA = $arr_request['DVA'];
$Sex = $arr_request['Sex'];





$Country = $arr_request['Country'];
$Indigenous = $arr_request['Indigenous'];
$Language = $arr_request['Language'];

$Locality = $arr_request['Locality'];
$Postcode = $arr_request['Postcode'];

$ArriveTrans = $arr_request['ArriveTrans'];
$ReferredBy = $arr_request['ReferredBy'];
$ArriveSource = $arr_request['ArriveSource'];
$TypeVisit = $arr_request['TypeVisit'];
$Compensable = $arr_request['Compensable'];
$AmbCase = cleanup($arr_request['AmbCase']);

$TriageNurse = $arr_request['TriageNurse'];
$TriageCategory = $arr_request['TriageCategory'];

function setIfRequired($isRequired, $valueToSet) {
	if ($isRequired == ' ') {
		if (($valueToSet == 'Y') || ($valueToSet == 'N')) {
			return $valueToSet;
		} else {
			return ' ';
		}
	} else {
		return '-';
	}
}

if ($arr_request['FlagsA1'] == NULL) {
	$updateFlagsColumns = false;
} else {
	$updateFlagsColumns = true;
	$FlagsDischargeScreen = $arr_request['FlagsA1'] . $arr_request['FlagsA2'] . $arr_request['FlagsA3'] . $arr_request['FlagsA4'];
	$FlagsTreatment = $arr_request['FlagsB1'] . $arr_request['FlagsB2'] . $arr_request['FlagsB3'] . $arr_request['FlagsB4'];

	if ($arr_request['FlagsCr'] == 'Y') {
		$FlagsReferral = 'Y------';
	} else {
		$FlagsReferral = '-' . setIfRequired($arr_request['FlagsC1r'], $arr_request['FlagsC1']) .
						setIfRequired($arr_request['FlagsC2r'], $arr_request['FlagsC2']) . setIfRequired($arr_request['FlagsC3r'], $arr_request['FlagsC3']) .
						setIfRequired($arr_request['FlagsC4r'], $arr_request['FlagsC4']) . setIfRequired($arr_request['FlagsC5r'], $arr_request['FlagsC5']) . 
						setIfRequired($arr_request['FlagsC6r'], $arr_request['FlagsC6']);
	}

	if ($arr_request['FlagsDr'] == 'Y') {
		$FlagsDiagnostics = 'Y---';
	} else {
		$FlagsDiagnostics = '-' . setIfRequired($arr_request['FlagsD1r'], $arr_request['FlagsD1']) . 
							setIfRequired($arr_request['FlagsD2r'], $arr_request['FlagsD2']) .
							setIfRequired($arr_request['FlagsD3r'], $arr_request['FlagsD3']);
	}

	if ($arr_request['FlagsEr'] == 'Y') {
		$FlagsBarriers = 'Y------';
	} else {
		$FlagsBarriers = '-' . setIfRequired($arr_request['FlagsE1r'], $arr_request['FlagsE1']) . 
						setIfRequired($arr_request['FlagsE2r'], $arr_request['FlagsE2']) . setIfRequired($arr_request['FlagsE3r'], $arr_request['FlagsE3']) .
						setIfRequired($arr_request['FlagsE4r'], $arr_request['FlagsE4']) . setIfRequired($arr_request['FlagsE5r'], $arr_request['FlagsE5']) .
						setIfRequired($arr_request['FlagsE6r'], $arr_request['FlagsE6']);
	}
}

# if procedures sent as array, implode
$proceduresar=$arr_request['proceduresar'];
if (! $proceduresar){
	$Procedures = $arr_request['Procedures'];
	}
else {
	$Procedures = implode ($proceduresar,"{");
	}



if  (preg_match ('/A|B|C1|C2|C4/', $Procedures )){ #if there are investigations
	$Procedures = str_replace ( '{C3','', $Procedures ); # delete 'no investigations'
	}
if  (preg_match ('/D|E|F|G|H|I|J|K|L|M|N|O|P/', $Procedures )){ #if there are treatments
	$Procedures = str_replace ( '{P3','', $Procedures ); # delete 'no treatments'	
	$Procedures = str_replace ( '{P2','', $Procedures ); # delete 'verbal advice only'	
	$Procedures = str_replace ( '{P1','', $Procedures ); # delete 'written advice only'	
	}



$BedReq = $arr_request['BedReq'];
$BedReqTimeStamp = $arr_request['BedReqTimeStamp'];

if ($BedReq =='Y' && !$BedReqTimeStamp){
	$BedReqTimeStamp = time();
	}


$DischargedStatus  = $arr_request['DischargedStatus'];
$TransHosp = $arr_request['TransHosp'];
$DischargedTo = $arr_request['DischargedTo'];

if ($arr_request['CareComm']=='Y'){	$CareComm = 'Y';}
	else{$CareComm = 'N';}


$TransReason = $arr_request['TransReason'];
$TransEscort = $arr_request['TransEscort'];
$TransMode = $arr_request['TransMode'];

$Diagnosis1 = $arr_request['Diagnosis1'];
$Diagnosis2 = $arr_request['Diagnosis2'];
$Diagnosis3 = $arr_request['Diagnosis3'];

$Diagnosis1Certainty = $arr_request['Diagnosis1Certainty'];
$Diagnosis2Certainty = $arr_request['Diagnosis2Certainty'];
$Diagnosis3Certainty = $arr_request['Diagnosis3Certainty'];

$InjuryNatureof = $arr_request['InjuryNatureof'];
$InjuryBodyRegion = $arr_request['InjuryBodyRegion'];

$TriageDiagnosis = bigcleanup($arr_request['TriageDiagnosis']);

$InjuryCause = $arr_request['InjuryCause'];
$InjuryIntent = $arr_request['InjuryIntent'];
$InjuryPlace = $arr_request['InjuryPlace'];
$InjuryActivity = $arr_request['InjuryActivity'];

$ArrivalTimeStamp = $arr_request['TriageTimeStamp']; ## set arrival = triage
$TriageTimeStamp = $arr_request['TriageTimeStamp'];

$Location  = $arr_request['Location'];

$MovedToTriage = FALSE;

if ($Location == "(move back to triage)") {
	$DoctorTimeStamp = NULL;
	$Doctor = '';
	$Location = '';
	$MovedToTriage = TRUE;
} else {
	$DoctorTimeStamp = $arr_request['DoctorTimeStamp'];
	$Doctor = $arr_request['Doctor'];

	if ((!$DoctorTimeStamp) && ($Doctor)){#if this is the first time seen by doctor
		$DoctorTimeStamp = time();
		}
}

$DischargeTimeStamp = $arr_request['DischargeTimeStamp'];


$GP = $arr_request['GP'];
$Address = cleanup($arr_request['Address']);

$StatusReport = cleanup($arr_request['StatusReport']);


$AdmitWard = $arr_request['AdmitWard'];

if ($AdmitWard && !$BedReqTimeStamp){
	$BedReqTimeStamp = time(); 
	}

$TriageNurseCode = $arr_request['TriageNurseCode'];
$TriagePosition = $arr_request['TriagePosition'];

$PatientTitle = $arr_request[PatientTitle];
$PhoneHome = cleanup($arr_request[PhoneHome]);
$PhoneWork = cleanup($arr_request[PhoneWork]);
$PhoneMob = cleanup($arr_request[PhoneMob]);
$Email = cleanup($arr_request[Email]);
$Marital = $arr_request[Marital];
$Religeon = $arr_request[Religeon];
$PrevName = $arr_request[PrevName];
$MedAlert = $arr_request[MedAlert];
$DrugAlert = $arr_request[DrugAlert];
$PrivInsurance = $arr_request[PrivInsurance];
$PrivNumber = $arr_request[PrivNumber];
$ClericalID = $arr_request[ClericalID];




$str_sql = "UPDATE Patients SET	
UR = '$UR',
Medicare = '$Medicare',
MedicareSuffix = '$MedicareSuffix',
DVA = '$DVA',
Sex = '$Sex',
DateOfBirth = '$DateOfBirth',
Country = '$Country',

Indigenous = '$Indigenous',
Language = '$Language',
Locality = '$Locality',
Postcode = '$Postcode',

ArriveTrans = '$ArriveTrans',
ReferredBy = '$ReferredBy',
ArriveSource = '$ArriveSource',

TypeVisit = '$TypeVisit',
Compensable = '$Compensable',

AmbCase = '$AmbCase',

TriageNurse = '$TriageNurse',
TriageCategory = '$TriageCategory',

Procedures = '$Procedures',

BedReq = '$BedReq',

DischargedStatus = '$DischargedStatus',
TransHosp = '$TransHosp',
DischargedTo = '$DischargedTo',

CareComm = '$CareComm',

TransReason = '$TransReason',
TransEscort = '$TransEscort',
TransMode = '$TransMode',

Diagnosis1 = '$Diagnosis1',
Diagnosis2 = '$Diagnosis2',
Diagnosis3 = '$Diagnosis3',

Diagnosis1Certainty = '$Diagnosis1Certainty',
Diagnosis2Certainty = '$Diagnosis2Certainty',
Diagnosis3Certainty = '$Diagnosis3Certainty',

InjuryNatureof = '$InjuryNatureof',
InjuryBodyRegion = '$InjuryBodyRegion',

TriageDiagnosis = '$TriageDiagnosis',

InjuryCause = '$InjuryCause',
InjuryIntent = '$InjuryIntent',
InjuryPlace = '$InjuryPlace',
InjuryActivity = '$InjuryActivity',




ArrivalTimeStamp = '$ArrivalTimeStamp', 
TriageTimeStamp = '$TriageTimeStamp',
DoctorTimeStamp = '$DoctorTimeStamp',
BedReqTimeStamp = '$BedReqTimeStamp',
DischargeTimeStamp = '$DischargeTimeStamp',

FirstName = '$FirstName',
Surname = '$Surname',
GP = '$GP',
Address = '$Address',

Location = '$Location',

StatusReport = '$StatusReport',
Doctor = '$Doctor',
AdmitWard = '$AdmitWard',
Age = '$Age',
TriageNurseCode ='$TriageNurseCode',
TriagePosition = '$TriagePosition',

PatientTitle = '$PatientTitle',
PhoneHome = '$PhoneHome',
PhoneWork = '$PhoneWork',
PhoneMob = '$PhoneMob',
Email = '$Email',
Marital = '$Marital',
Religeon = '$Religeon',
PrevName = '$PrevName',
MedAlert = '$MedAlert',
DrugAlert = '$DrugAlert',
PrivInsurance = '$PrivInsurance',
PrivNumber = '$PrivNumber',
ClericalID = '$ClericalID'";

if ($updateFlagsColumns == true) {
	$str_sql = $str_sql . ",

FlagsDischargeScreen = '$FlagsDischargeScreen',
FlagsTreatment = '$FlagsTreatment',
FlagsReferral = '$FlagsReferral',
FlagsDiagnostics = '$FlagsDiagnostics',
FlagsBarriers = '$FlagsBarriers'";
}

$str_sql = $str_sql . "WHERE key_ID = $key_ID ";


$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}


## update triage position order by getting all waiting patients and re-ordering

$str_sql = "SELECT  key_ID, TriagePosition FROM Patients WHERE Doctor = '' ORDER BY TriagePosition";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}

$num_waiting = mysql_num_rows ($result);

if ($num_waiting)
{
	$countr = 1;

	while ($row = mysql_fetch_array($result))
		{
		$triage_key_ID = $row[key_ID];
		$pos_update_sql = "UPDATE Patients SET TriagePosition = '$countr' WHERE key_ID = '$triage_key_ID'";

		$pos_result = mysql_db_query($dbname, $pos_update_sql, $id_link);
		if (! $pos_result) { affy_error_exit('SQL Select Execution has failed.');}

		$countr ++;
		}
}

## Quality control
$QualityText = cleanup($arr_request['Quality']);
if ($QualityText) {

	$str_sql = "INSERT INTO Quality (UR, QualityText, QualTimeStamp, Surname, FirstName) VALUES ('$UR', '$QualityText', '".time()."', '$Surname', '$FirstName') ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');} 
}

if ($MovedToTriage) {
	header("Location: triage.php");
}

?>