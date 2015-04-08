<?php 
$key_ID = $arr_request['key_ID'];

##################################### update the doctor seen time, if necessary

if ($arr_request[newdoctorhours] && !$arr_request[longwait]){

	$doctortimestamp = mktime($arr_request[newdoctorhours],$arr_request[newdoctorminutes],30,$arr_request[newdoctormonth],$arr_request[newdoctorday],$arr_request[newdoctoryear]);

	if ($doctortimestamp < $arr_request[ArrivalTimeStamp]){# if the doctor time is still not right, guess it
		$doctortimestamp = ($arr_request[ArrivalTimeStamp]+(0.75*$arr_request[maxwaittime]));
		}
	$str_sql = " UPDATE Patients SET DoctorTimeStamp='$doctortimestamp' WHERE key_ID=$arr_request[key_ID] ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	}

if ($arr_request[newdischargehours] && !$arr_request[twelvehours]){#update discharge time, if necessary

	$dischargetimestamp = mktime($arr_request[newdischargehours],$arr_request[newdischargeminutes],30,$arr_request[newdischargemonth],$arr_request[newdischargeday],$arr_request[newdischargeyear]);

	if ($dischargetimestamp < $arr_request[DoctorTimeStamp]){# if the time is wrong, set discharge time to doctortime +1 hour
		$dischargetimestamp = ($arr_request[DoctorTimeStamp]+3600);
		}

	if ($arr_request[BedReqTimeStamp] > $dischargetimestamp ){# correct bedrequest time as well
		$str_sql = " UPDATE Patients SET BedReqTimeStamp='$dischargetimestamp' WHERE key_ID=$arr_request[key_ID]";
		$result = mysql_db_query($dbname, $str_sql, $id_link);
		if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
		}

	$str_sql = " UPDATE Patients SET DischargeTimeStamp='$dischargetimestamp' WHERE key_ID=$arr_request[key_ID] ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	
	}

####################################

# check we are updating a valid record
$str_sql = "Select * from Patients where key_ID = $key_ID";
$result = mysql_db_query($dbname, $str_sql, $id_link);

if ((! $key_ID)  || (mysql_num_rows($result) == 0)) {
	error ("Sorry! That Patient has  already been discharged","or does not exist");
	}

$pt_to_disch=mysql_fetch_array($result);

####################################

# check valid date of birth

# $dobday = substr ($pt_to_disch[DateOfBirth],0,2);
# $dobmonth =  substr ($pt_to_disch[DateOfBirth],2,2);
# $dobyear =  substr ($pt_to_disch[DateOfBirth],4,4);

# if (!$dobday|| !$dobmonth || !$dobyear || $dobday=='00' || $dobmonth=='00'){ 
#	error ("The patient needs to have a valid date of birth","Go back and check it, press 'update' and then try again");
#	}


# $isValid = checkdate($dobmonth,$dobday,$dobyear);
# if ($isValid == FALSE) {
# 	error ("The date of birth is not valid", "Go back and change it, press 'update' and then try again");
# 	}


$FirstName = $pt_to_disch[FirstName];
if (!$FirstName){
	error ("The patient's first name needs to be entered in the registration screen","Please do this, and then try again");
	}
$Surname = $pt_to_disch[Surname];
if (!$Surname){
	error ("The patient's unit Surname needs to be entered in the registration screen","Please do this, and then try again");
	}


# $UR = substr($pt_to_disch[UR],0,9);##### takes the first nine numbers
# if (!$UR){
# 	error ("The patient's hospital number (HR) needs to be entered in the registration screen","Please do this, and then try again");
# 	}

$Medicare = substr($pt_to_disch[Medicare],0,10);##### takes the first ten numbers
if ($Medicare){
	$MedicareSuffix = strtoupper(substr($FirstName,0,3));
	}
elseif (! $pt_to_disch[MedicareSuffix]){
	$MedicareSuffix = 'C-U';
	}
else{
	$MedicareSuffix = $pt_to_disch[MedicareSuffix];
	}

$DVA = $pt_to_disch[DVA];
$Sex = $pt_to_disch[Sex];
$DateOfBirth = $pt_to_disch[DateOfBirth];


/*
$Country = $pt_to_disch[Country];
if (!$Country){
	error ("The patient's country of birth needs to be entered in the registration screen","Please do this, and then try again");
	}

$Indigenous = $pt_to_disch[Indigenous];
if (!$Indigenous){
	error ("The patient's racial/indigenous status needs to be entered in the registration screen","Please do this, and then try again");
	}

$Language = $pt_to_disch[Language];
if (!$Language){
	error ("The patient's language needs to be entered in the registration screen","Please do this, and then try again");
	}

$Locality = $pt_to_disch[Locality];
$Postcode = $pt_to_disch[Postcode];
if (!$Postcode){
	error ("The patient's postcode needs to be entered in the registration screen","Please do this, and then try again");
	}

$AmbCase = $pt_to_disch[AmbCase];
$ArriveTrans = $pt_to_disch[ArriveTrans];
if (!$ArriveTrans){
	error ("The patient's arrival transport needs to be entered in the registration screen","Please do this, and then try again");
	}

if (($ArriveTrans=='1'||$ArriveTrans=='2'||$ArriveTrans=='3'||$ArriveTrans=='4'||$ArriveTrans=='10') && !$AmbCase){
	error ("The patient arrived by ambulance, but has not got an ambulance case number recorderd","Please check the registration screen and try again");
	}

$ReferredBy = $pt_to_disch[ReferredBy];
if (!$ReferredBy){
	error ("The patient's referral source needs to be entered in the registration screen","Please do this, and then try again");
	}
$ArriveSource = $pt_to_disch[ArriveSource];

if ($ReferredBy=='6' && !$ArriveSource){# if referred from another hospital
	error ("The patient was transferred from another hospital, which needs to be entered in the registration screen","Please do this, press 'update' and then try again");
	}
*/
$TypeVisit = $pt_to_disch[TypeVisit];
if (!$TypeVisit){
	error ("The patient's Type of Visit needs to be entered in the registration screen","Please do this, and then try again");
	}
	
/*
$Compensable = $pt_to_disch[Compensable];
if (!$Compensable){
	error ("The patient's Comensable status needs to be entered in the registration screen","Please do this, and then try again");
	}
*/

$TriageNurse = $pt_to_disch[TriageNurse];
$TriageCategory = $pt_to_disch[TriageCategory];

####  if procedures sent as array, implode

$proceduresar=$pt_to_disch[proceduresar];
if (! $proceduresar){
	$Procedures = $pt_to_disch[Procedures];
	}
else {
	$Procedures = implode ($proceduresar,"{");
	}

$BedReq = $pt_to_disch[BedReq];


$DischargedStatus  = $pt_to_disch[DischargedStatus];
$TransHosp = $pt_to_disch[TransHosp];
$DischargedTo = $pt_to_disch[DischargedTo];

$CareComm = $pt_to_disch[CareComm];

$TransReason = $pt_to_disch[TransReason];
$TransEscort = $pt_to_disch[TransEscort];
$TransMode = $pt_to_disch[TransMode];

$Diagnosis1 = $pt_to_disch[Diagnosis1];
$Diagnosis2 = $pt_to_disch[Diagnosis2];
$Diagnosis3 = $pt_to_disch[Diagnosis3];

$InjuryNatureof = $pt_to_disch[InjuryNatureof];
$InjuryBodyRegion = $pt_to_disch[InjuryBodyRegion];

$TriageDiagnosis = $pt_to_disch[TriageDiagnosis];

$InjuryCause = $pt_to_disch[InjuryCause];
$InjuryIntent = $pt_to_disch[InjuryIntent];
$InjuryPlace = $pt_to_disch[InjuryPlace];
$InjuryActivity = $pt_to_disch[InjuryActivity];




#$FirstName = $pt_to_disch[FirstName];
#$Surname = $pt_to_disch[Surname];
$GP = $pt_to_disch[GP];
$Address = $pt_to_disch[Address];

$Location  = $pt_to_disch[Location];
$StatusReport = $pt_to_disch[StatusReport];
$Doctor = $pt_to_disch[Doctor];

$AdmitWard = $pt_to_disch[AdmitWard];
$Age = $pt_to_disch[Age];

$TriageNurseCode = $pt_to_disch[TriageNurseCode];
$TriagePosition = $pt_to_disch[TriagePosition];

$PatientTitle = $pt_to_disch[PatientTitle];
$PhoneHome = $pt_to_disch[PhoneHome];
$PhoneWork = $pt_to_disch[PhoneWork];
$PhoneMob = $pt_to_disch[PhoneMob];
$Email = $pt_to_disch[Email];
$Marital = $pt_to_disch[Marital];
$Religeon = $pt_to_disch[Religeon];
$PrevName = $pt_to_disch[PrevName];
$MedAlert = $pt_to_disch[MedAlert];
$DrugAlert = $pt_to_disch[DrugAlert];
$PrivInsurance = $pt_to_disch[PrivInsurance];
$PrivNumber = $pt_to_disch[PrivNumber];
$ClericalID = $pt_to_disch[ClericalID];

$FlagsDischargeScreen = $pt_to_disch[FlagsDischargeScreen];
$FlagsTreatment = $pt_to_disch[FlagsTreatment];
$FlagsReferral = $pt_to_disch[FlagsReferral];
$FlagsDiagnostics = $pt_to_disch[FlagsDiagnostics];
$FlagsBarriers = $pt_to_disch[FlagsBarriers];
$Diagnosis1Certainty = $pt_to_disch[Diagnosis1Certainty];
$Diagnosis2Certainty = $pt_to_disch[Diagnosis2Certainty];
$Diagnosis3Certainty = $pt_to_disch[Diagnosis3Certainty];

/*
if (!$ClericalID){
	error ("The clerical ID to be entered in the registration screen","Please do this, and then try again");
	}
*/
##########################################################

## time and date functions

$ArrivalTimeStamp = $pt_to_disch[TriageTimeStamp];## if you want to collect arrival time separately, write the code!
$TriageTimeStamp = $pt_to_disch[TriageTimeStamp];
$DoctorTimeStamp = $pt_to_disch[DoctorTimeStamp];
$BedReqTimeStamp = $pt_to_disch[BedReqTimeStamp];

if  (!$pt_to_disch[DischargeTimeStamp]){
	$DischargeTimeStamp = time();
	}else{
	$DischargeTimeStamp = $pt_to_disch[DischargeTimeStamp];
	}

## do calculations with timestamps - if conflicting information estimate.

if ($DoctorTimeStamp<$TriageTimeStamp){
	$DoctorTimeStamp=$TriageTimeStamp+1;
	}

if ($DischargeTimeStamp<$TriageTimeStamp){
	error("The triage time is wrong/ the clocks have changed","Please have the supervisor check the times");
	}

if ($BedReqTimeStamp && $BedReqTimeStamp < $TriageTimeStamp){ #if there is a bedrequest before being seen at triage, guess
	$BedReqTimeStamp=$TriageTimeStamp+0.75*($DischargeTimeStamp-$TriageTimeStamp);
	}

if ($DischargedStatus=='2' && !$BedReqTimeStamp){# if admitted but bed not requested, guess time bed requested
	$BedReqTimeStamp=$TriageTimeStamp+0.75*($DischargeTimeStamp-$TriageTimeStamp);
	}

switch ($TriageCategory){ #work out maximum recommended waiting time for that category
	case '1':
	$maxwaittime=0;
	break;
	case '2':
	$maxwaittime=599;
	break;
	case '3':
	$maxwaittime=1799;
	break;
	case '4':
	$maxwaittime=3599;
	break;
	case '5':
	$maxwaittime=7199;
	break;
	case '6':
	$maxwaittime=7199;
	break;
}

$waittime=$DoctorTimeStamp-$TriageTimeStamp;
$arrivaltimestampar = getdate($ArrivalTimeStamp);
$triagetimestampar = getdate($TriageTimeStamp);
$doctortimestampar = getdate($DoctorTimeStamp);
$dischargetimestampar = getdate($DischargeTimeStamp);

$PatientInSSU = true;

if (substr($Location, 0, 3) == 'AAU') {
	$PatientInSSU = false;
	if ($waittime>$maxwaittime && !$arr_request[longwait]){## if pt waited too long allow doctor to amend, unless has already ticked box

		include("header.inc"); 
		include("navbar.inc"); 
		#phpinfo();
		print"<BR><BR><CENTER><FORM ACTION='index.php' METHOD='POST'>
		<INPUT TYPE='HIDDEN' NAME='action' VALUE='dischargepatient'>
		<INPUT TYPE='HIDDEN' NAME='key_ID' VALUE='$key_ID'>
		<INPUT TYPE='HIDDEN' NAME='ArrivalTimeStamp' VALUE='$ArrivalTimeStamp'>
		<INPUT TYPE='HIDDEN' NAME='maxwaittime' VALUE='$maxwaittime'>
		<TABLE WIDTH=80% CELLPADDING=20><TR><TD>
		<H2>Did it really take you ".(floor($waittime/60))." minutes to see this Category $TriageCategory patient?</H2>
		</TD></TR>
		<TR><TD>
		<TABLE CELLPADDING=10>
		<TR><TD><H3>Triage time</H3>
		</TD><TD>
		<H3>$triagetimestampar[hours] : ".date(i,$TriageTimeStamp)." on $triagetimestampar[mday] / $triagetimestampar[mon] / $triagetimestampar[year]</H3>
		</TD></TR>
		<TR><TD><H3>Seen by doctor</H3></TD><TD>
		<H3>$doctortimestampar[hours] : ".date(i,$DoctorTimeStamp)." on $doctortimestampar[mday] / $doctortimestampar[mon] / $doctortimestampar[year]</H3>
		</TD></TR></TABLE>
		</TD></TR>
		<TR><TD><H2>No</H2><BR>
		<TABLE CELLPADDING=10><TR><TD>
		<H3>Amend time:</H3></TD><TD>

		</TD></TR><TR><TD>";	
		$doctortimestampar = getdate($TriageTimeStamp+(0.75*$maxwaittime));

		print "<H3>Time</H3></TD><TD>";
		dropdownbox ($hourlist, "newdoctorhours", $doctortimestampar[hours]);
		print "&nbsp;<B>:</B>&nbsp;";
		dropdownbox ($minutelist, "newdoctorminutes", $doctortimestampar[minutes]);

		print "</TD></TR><TR><TD VALIGN=top><H3>Date&nbsp;</H3></TD><TD VALIGN=top>";
		dropdownbox ($daylist, "newdoctorday", $doctortimestampar[mday]);
		print "&nbsp;<B>/</B>&nbsp;";
		dropdownbox ($monthlist, "newdoctormonth", $doctortimestampar[mon]);
		
		print "&nbsp;<B>/</B>&nbsp;";
		dropdownbox ($yearlist, "newdoctoryear", $doctortimestampar[year]);

		print "<BR><BR><CENTER><INPUT TYPE=\"submit\" TEXT=\"Update\"></CENTER>";
		print "</TD></TR></TABLE>";

		if ($arr_request[twelvehours]){##allow both a long wait and a long stay
			print " <INPUT TYPE='HIDDEN' NAME='twelvehours' VALUE='Y'>";
			}

		print"</TD></TR><TR><TD>
		<BR>
		<H2>Yes</H2>
		<TABLE CELLPADDING=10><TR><TD><H3>It really did take me ".(floor($waittime/60))." minutes to see this Category $TriageCategory patient <INPUT TYPE=\"checkbox\" NAME=\"longwait\" VALUE=\"Y\"></H3>
		</TD></TR></TABLE>
		</TD></TR>
		</TABLE></CENTER>
		<BR><BR><BR></FORM>";
		include('footer.inc'); 
		exit;
		}
	$edtime=$DischargeTimeStamp-$ArrivalTimeStamp;

	if ($edtime>43100 && !$arr_request[twelvehours]){## if patient in dept >12hrs, and has not ticked box
		include("header.inc"); 
		include("navbar.inc"); 
		#phpinfo();
		print"<BR><BR><CENTER><FORM ACTION='index.php' METHOD='POST'>
		<INPUT TYPE='HIDDEN' NAME='action' VALUE='dischargepatient'>
		<INPUT TYPE='HIDDEN' NAME='key_ID' VALUE='$key_ID'>
		<INPUT TYPE='HIDDEN' NAME='DoctorTimeStamp' VALUE='$DoctorTimeStamp'>
		<INPUT TYPE='HIDDEN' NAME='BedReqTimeStamp' VALUE='$BedReqTimeStamp'>
		<TABLE WIDTH=80% CELLPADDING=20><TR><TD>
		<H2>Did this Category $TriageCategory patient really stay  ".(floor($edtime/3600))." hours in the Emergency Department?</H2>
		</TD></TR>
		<TR><TD>
		<TABLE CELLPADDING=10>
		<TR><TD><H3>Arrival time</H3>
		</TD><TD>
		<H3>$arrivaltimestampar[hours] : ".date(i,$ArrivalTimeStamp)." on $arrivaltimestampar[mday] / $arrivaltimestampar[mon] / $arrivaltimestampar[year]</H3>
		</TD></TR>
		<TR><TD><H3>Discharge time</H3></TD><TD>
		<H3>$dischargetimestampar[hours] : ".date(i,$DischargeTimeStamp)." on $dischargetimestampar[mday] / $dischargetimestampar[mon] / $dischargetimestampar[year]</H3>
		</TD></TR></TABLE>
		</TD></TR>
		<TR><TD><H2>No</H2><BR>
		<TABLE CELLPADDING=10><TR><TD>
		<H3>Amend time:</H3></TD><TD>

		</TD></TR><TR><TD>";	

		$dischargetimestampar = getdate($ArrivalTimeStamp+10800*(6/($TriageCategory+1)));#guess how long patient should have stayed

		if ($arr_request[longwait]){ ##allow both a long wait and a long stay
			print " <INPUT TYPE='HIDDEN' NAME='longwait' VALUE='Y'>";
			}

		print "<H3>Time</H3></TD><TD>";
		dropdownbox ($hourlist, "newdischargehours", $dischargetimestampar[hours]);
		print "&nbsp;<B>:</B>&nbsp;";
		dropdownbox ($minutelist, "newdischargeminutes", $dischargetimestampar[minutes]);

		print "</TD></TR><TR><TD VALIGN=top><H3>Date&nbsp;</H3></TD><TD VALIGN=top>";
		dropdownbox ($daylist, "newdischargeday", $dischargetimestampar[mday]);
		print "&nbsp;<B>/</B>&nbsp;";
		dropdownbox ($monthlist, "newdischargemonth", $dischargetimestampar[mon]);
		
		print "&nbsp;<B>/</B>&nbsp;";
		dropdownbox ($yearlist, "newdischargeyear", $dischargetimestampar[year]);

		print "<BR><BR><CENTER><INPUT TYPE=\"submit\" TEXT=\"Update\"></CENTER>";
		print "</TD></TR></TABLE>";


		print"</TD></TR><TR><TD>
		<BR>
		<H2>Yes</H2>
		<TABLE CELLPADDING=10><TR><TD><H3>This Category $TriageCategory patient stayed ".(floor($edtime/3600))." hours in the department <INPUT TYPE=\"checkbox\" NAME=\"twelvehours\" VALUE=\"Y\"></H3>
		</TD></TR></TABLE>
		</TD></TR>
		</TABLE></CENTER>
		<BR><BR><BR></FORM>";
		include('footer.inc'); 
		exit;
		}


	############ if more than 12 hours, or outstayed their max triage time, send an alert to the quality

	if ($arr_request[longwait]){
		$quality="Triage category ".$TriageCategory." patient waited ".(floor($waittime/60))." minutes, triaged by ".$TriageNurse." seen by doctor ".$Doctor;

		$str_sql = "INSERT INTO Quality SET UR='$UR',  QualTimeStamp = $TriageTimeStamp, QualityText='$quality', FirstName= '$FirstName', Surname='$Surname' ";

		$result = mysql_db_query($dbname, $str_sql, $id_link);
		if (! $result) { affy_error_exit('Quality SQL Select Execution has failed.');}
		}

	if ($arr_request[twelvehours]){
		$quality="Triage category ".$TriageCategory." patient waited ".(floor($edtime/3600))." hours in the emergency department - looked after by doctor ".$Doctor;

		$str_sql = "INSERT INTO Quality SET UR='$UR',  QualTimeStamp = $DischargeTimeStamp, QualityText='$quality', FirstName= '$FirstName', Surname='$Surname' ";

		$result = mysql_db_query($dbname, $str_sql, $id_link);
		if (! $result) { affy_error_exit('Quality SQL Select Execution has failed.');}
		}

}

################################## convert timestamps to real times/dates

$ArrivalDate = date (dmY, $ArrivalTimeStamp);
$ArrivalTime = date (Hi, $ArrivalTimeStamp);

$TriageDate = date (dmY, $TriageTimeStamp);
$TriageTime = date (Hi, $TriageTimeStamp);

$DoctorDate = date (dmY, $DoctorTimeStamp);
$DoctorTime = date (Hi, $DoctorTimeStamp);

if($BedReqTimeStamp){
	$BedReqDate = date (dmY, $BedReqTimeStamp);
	$BedReqTime = date (Hi, $BedReqTimeStamp);
	}

$DepartureDate = date (dmY, $DischargeTimeStamp);
$DepartureTime = date (Hi, $DischargeTimeStamp);


#################################### sort out the discharge referrals
 
 switch ($DischargedStatus){
	#	case '2':#admission to ward
	#		$CareComm = "Y";
	#		$DischargedTo= '19';
	#	break;

		case '5':#left before seen
			$DischargedTo= '19';
		break;

		case '6':#left at own risk
			$DischargedTo= '19';
		break;
		
		case '7':#DOA
			$DischargedTo= '19';
			$TransMode= '9'; #undertaker
		break;

		case '8':#died in ED
			$DischargedTo= '19';
			$TransMode= '9'; #undertaker
		break;

}



############################# lock tables to avoid grief

/*
$str_sql = "LOCK TABLES Patients READ, DischargedPatients READ";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
*/

######################################################## insert into DischargedPatients

# note that the unique ID number is the key_ID in DischargedPatients

$str_sql = "INSERT INTO DischargedPatients 	SET

key_ID= \"$key_ID\",

UR = \"$UR\",
Medicare = \"$Medicare\",
MedicareSuffix = \"$MedicareSuffix\",
DVA = \"$DVA\",
Sex = \"$Sex\",
DateOfBirth = \"$DateOfBirth\",
Country = \"$Country\",

Indigenous = \"$Indigenous\",
Language = \"$Language\",
Locality = \"$Locality\",
Postcode = \"$Postcode\",

ArriveTrans = \"$ArriveTrans\",
ReferredBy = \"$ReferredBy\",
ArriveSource = \"$ArriveSource\",

TypeVisit = \"$TypeVisit\",
Compensable = \"$Compensable\",

AmbCase = \"$AmbCase\",

ArrivalDate = \"$ArrivalDate\",
ArrivalTime = \"$ArrivalTime\",

TriageDate = \"$TriageDate\",
TriageTime = \"$TriageTime\",

TriageNurse = \"$TriageNurse\",
TriageCategory = \"$TriageCategory\",

DoctorDate = \"$DoctorDate\",
DoctorTime = \"$DoctorTime\",

Procedures = \"$Procedures\",

BedReq = \"$BedReq\",
BedReqDate = \"$BedReqDate\",
BedReqTime = \"$BedReqTime\",

DepartureDate = \"$DepartureDate\",
DepartureTime = \"$DepartureTime\",

DischargedStatus = \"$DischargedStatus\",
TransHosp = \"$TransHosp\",
DischargedTo = \"$DischargedTo\",

CareComm = \"$CareComm\",

TransReason = \"$TransReason\",
TransEscort = \"$TransEscort\",
TransMode = \"$TransMode\",

Diagnosis1 = \"$Diagnosis1\",
Diagnosis2 = \"$Diagnosis2\",
Diagnosis3 = \"$Diagnosis3\",

InjuryNatureof = \"$InjuryNatureof\",
InjuryBodyRegion = \"$InjuryBodyRegion\",

TriageDiagnosis = \"$TriageDiagnosis\",

InjuryCause = \"$InjuryCause\",
InjuryIntent = \"$InjuryIntent\",
InjuryPlace = \"$InjuryPlace\",
InjuryActivity = \"$InjuryActivity\",

ArrivalTimeStamp = \"$ArrivalTimeStamp\",
TriageTimeStamp = \"$TriageTimeStamp\",
DoctorTimeStamp = \"$DoctorTimeStamp\",
BedReqTimeStamp = \"$BedReqTimeStamp\",
DischargeTimeStamp = \"$DischargeTimeStamp\",

FirstName = \"$FirstName\",
Surname = \"$Surname\",
GP = \"$GP\",
Address = \"$Address\",

Location = \"$Location\",

StatusReport = \"$StatusReport\",
Doctor = \"$Doctor\",
AdmitWard = \"$AdmitWard\",
Age = \"$Age\",
TriageNurseCode =\"$TriageNurseCode\",
TriagePosition = \"$TriagePosition\",

PatientTitle = \"$PatientTitle\",
PhoneHome = \"$PhoneHome\",
PhoneWork = \"$PhoneWork\",
PhoneMob = \"$PhoneMob\",
Email = \"$Email\",
Marital = \"$Marital\",
Religeon = \"$Religeon\",
PrevName = \"$PrevName\",
MedAlert = \"$MedAlert\",
DrugAlert = \"$DrugAlert\",
PrivInsurance = \"$PrivInsurance\",
PrivNumber = \"$PrivNumber\",
ClericalID = \"$ClericalID\",

FlagsDischargeScreen = \"$FlagsDischargeScreen\",
FlagsTreatment = \"$FlagsTreatment\",
FlagsReferral = \"$FlagsReferral\",
FlagsDiagnostics = \"$FlagsDiagnostics\",
FlagsBarriers = \"$FlagsBarriers\",
Diagnosis1Certainty = \"$Diagnosis1Certainty\",
Diagnosis2Certainty = \"$Diagnosis2Certainty\",
Diagnosis3Certainty = \"$Diagnosis3Certainty\"
";


$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}


$str_sql = "DELETE FROM Patients WHERE key_ID= '$key_ID' ";

$result = mysql_db_query($dbname, $str_sql, $id_link);

if (! $result) {
    affy_error_exit('SQL Select Execution has failed.');
  }


/*
$str_sql = "UNLOCK TABLES";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
*/

if ($PatientInSSU == true) {
	header("Location: index_SSU.php");
	exit;
} else {
	header("Location: index.php");
	exit;
}
?>