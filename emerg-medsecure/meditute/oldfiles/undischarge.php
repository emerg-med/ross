<?php 
include('/home/httpd/html/common.inc');
#phpinfo();
include('checkvalid.inc');



/*


( UR , Medicare , MedicareSuffix , DVA , Sex , DateOfBirth , Country , Indigenous , Language , Locality , Postcode , ArriveTrans , ReferredBy , ArriveSource , TypeVisit , Compensable , AmbCase , ArrivalDate , ArrivalTime , TriageDate , TriageTime , TriageNurse , TriageCategory , DoctorDate , DoctorTime , Procedures , BedReq , BedReqDate , BedReqTime , DepartureDate , DepartureTime , DischargedStatus , TransHosp , DischargedTo , CareComm , TransReason , TransEscort , TransMode , Diagnosis1 , Diagnosis2 , Diagnosis3 , InjuryNatureof , InjuryBodyRegion , TriageDiagnosis , InjuryCause , InjuryIntent , InjuryPlace , InjuryActivity , ArrivalTimeStamp , TriageTimeStamp , DoctorTimeStamp , BedReqTimeStamp , DischargeTimeStamp , FirstName , Surname , GP , Address , Location , StatusReport , Doctor , AdmitWard , Age , Locked , TriageNurseCode , TriagePosition , PatientTitle , PhoneHome , PhoneWork , PhoneMob , Email , Marital , Religeon , PrevName , MedAlert , DrugAlert , PrivInsurance , PrivNumber , ClericalID )

	## this SQL should work (does with just one column) but couldn't get it to, so do it longhand below

	$str_sql = " INSERT INTO Patients ( UR, Surname ) SELECT ( UR, Surname ) FROM DischargedPatients WHERE key_ID='$arr_request[undischarge]' ";

	#print $str_sql;
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

*/

if ($arr_request[undischarge]){
	$str_sql = "Select * from DischargedPatients where key_ID = '$arr_request[undischarge]' ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);

	if ((!$arr_request[undischarge])  || (mysql_num_rows($result) == 0)) {
	error ("Sorry! That Patient has  already been undischarged","or does not exist");
	}
	$patient=mysql_fetch_array($result);

#	$str_sql = "LOCK TABLES Patients READ, DischargedPatients READ ; ";
#	$result = mysql_db_query($dbname, $str_sql, $id_link);
#	if (! $result) { affy_error_exit('Table locking failed.');}		LOCK TABLES Patients READ, DischargedPatients READ;



	$str_sql = "

	INSERT INTO Patients SET
	
	key_ID = \"$patient[key_ID]\",

	UR = \"$patient[UR]\",
	Medicare = \"$patient[Medicare]\",
	MedicareSuffix = \"$patient[MedicareSuffix]\",
	DVA = \"$patient[DVA]\",
	Sex = \"$patient[Sex]\",
	DateOfBirth = \"$patient[DateOfBirth]\",
	Country = \"$patient[Country]\",

	Indigenous = \"$patient[Indigenous]\",
	Language = \"$patient[Language]\",
	Locality = \"$patient[Locality]\",
	Postcode = \"$patient[Postcode]\",

	ArriveTrans = \"$patient[ArriveTrans]\",
	ReferredBy = \"$patient[ReferredBy]\",
	ArriveSource = \"$patient[ArriveSource]\",

	TypeVisit = \"$patient[TypeVisit]\",
	Compensable = \"$patient[Compensable]\",

	AmbCase = \"$patient[AmbCase]\",

	ArrivalDate = \"$patient[ArrivalDate]\",
	ArrivalTime = \"$patient[ArrivalTime]\",

	TriageDate = \"$patient[TriageDate]\",
	TriageTime = \"$patient[TriageTime]\",

	TriageNurse = \"$patient[TriageNurse]\",
	TriageCategory = \"$patient[TriageCategory]\",

	DoctorDate = \"$patient[DoctorDate]\",
	DoctorTime = \"$patient[DoctorTime]\",

	Procedures = \"$patient[Procedures]\",

	BedReq = \"$patient[BedReq]\",
	BedReqDate = \"$patient[BedReqDate]\",
	BedReqTime = \"$patient[BedReqTime]\",

	DepartureDate = \"$patient[DepartureDate]\",
	DepartureTime = \"$patient[DepartureTime]\",

	DischargedStatus = \"$patient[DischargedStatus]\",
	TransHosp = \"$patient[TransHosp]\",
	DischargedTo = \"$patient[DischargedTo]\",

	CareComm = \"$patient[CareComm]\",

	TransReason = \"$patient[TransReason]\",
	TransEscort = \"$patient[TransEscort]\",
	TransMode = \"$patient[TransMode]\",

	Diagnosis1 = \"$patient[Diagnosis1]\",
	Diagnosis2 = \"$patient[Diagnosis2]\",
	Diagnosis3 = \"$patient[Diagnosis3]\",

	InjuryNatureof = \"$patient[InjuryNatureof]\",
	InjuryBodyRegion = \"$patient[InjuryBodyRegion]\",

	TriageDiagnosis = \"$patient[TriageDiagnosis]\",

	InjuryCause = \"$patient[InjuryCause]\",
	InjuryIntent = \"$patient[InjuryIntent]\",
	InjuryPlace = \"$patient[InjuryPlace]\",
	InjuryActivity = \"$patient[InjuryActivity]\",

	ArrivalTimeStamp = \"$patient[ArrivalTimeStamp]\",
	TriageTimeStamp = \"$patient[TriageTimeStamp]\",
	DoctorTimeStamp = \"$patient[DoctorTimeStamp]\",
	BedReqTimeStamp = \"$patient[BedReqTimeStamp]\",
	DischargeTimeStamp = \"$patient[DischargeTimeStamp]\",

	FirstName = \"$patient[FirstName]\",
	Surname = \"$patient[Surname]\",
	GP = \"$patient[GP]\",
	Address = \"$patient[Address]\",

	Location = \"$patient[Location]\",

	StatusReport = \"$patient[StatusReport]\",
	Doctor = \"$patient[Doctor]\",
	AdmitWard = \"$patient[AdmitWard]\",
	Age = \"$patient[Age]\",
	TriageNurseCode =\"$patient[TriageNurseCode]\",
	TriagePosition = \"$patient[TriagePosition]\",

	PatientTitle = \"$patient[PatientTitle]\",
	PhoneHome = \"$patient[PhoneHome]\",
	PhoneWork = \"$patient[PhoneWork]\",
	PhoneMob = \"$patient[PhoneMob]\",
	Email = \"$patient[Email]\",
	Marital = \"$patient[Marital]\",
	Religeon = \"$patient[Religeon]\",
	PrevName = \"$patient[PrevName]\",
	MedAlert = \"$patient[MedAlert]\",
	DrugAlert = \"$patient[DrugAlert]\",
	PrivInsurance = \"$patient[PrivInsurance]\",
	PrivNumber = \"$patient[PrivNumber]\",
	ClericalID = \"$patient[ClericalID]\" 


	";

	/*
	DELETE FROM DischargedPatients WHERE key_ID=\"$arr_request[undischarge]\";

	UNLOCK TABLES;
	$str_sql = "UNLOCK TABLES";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

	#print $str_sql;
*/
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	
	$str_sql = " DELETE FROM DischargedPatients WHERE key_ID='$arr_request[undischarge]'";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	
	}


$str_sql = " SELECT key_ID,FirstName,Surname FROM DischargedPatients WHERE DischargeTimeStamp > ".(time()-43200)." ";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}



include('/home/httpd/html/header.inc'); 
include('adminnavbar.inc');
print "<FORM METHOD=POST ACTION='undischarge.php'>";
print "<INPUT TYPE='HIDDEN' NAME='user' VALUE='$arr_request[user]'>";
print "<BLOCKQUOTE><H3>This form allows you to undischarge patients</H3><BR>";
print"<TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";

while($resultar = mysql_fetch_array($result)){
	print "<TR><TD><A HREF=\"undischarge.php?undischarge=$resultar[key_ID]&user=$arr_request[user]\"><SPAN class='redbutton' >Undischarge</SPAN></A></TD><TD>";
	print $resultar[FirstName]." <B>".$resultar[Surname]."</B></TD></TR>";
	}

print "</TABLE>";


print "</BLOCKQUOTE></FORM>";
include('/home/httpd/html/footer.inc'); 

?>