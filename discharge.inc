<?
##### Set up arrays ! note that the arrays in letter.php will also need changing


$escortlist = array ("1{Emergency department","2{ICU / CCU","3{Ward","4{Retrieval service","5{Nil (no escort)","9{Other");
$transreasonlist = array ( "4{Speciality not availabe","1{ICU bed not available","2{CCU bed not available","3{General bed not available","6{Insured/ compensatable","9{Other reason","7{Patient preference","5{Previous patient");
$referredlist = array ( "4{General practioner","3{Outpatients","5{Medical specialist","6{Other specialist health practitioner","7{District nurse","1{Review in ED - scheduled","2{Review in ED - if necessary","16{No referral","8{Community service eg psych");
$depstatuslist = array ("1{Discharged home / nurs. home","2{Admitted to ward (not short stay)","3{Admitted to SSU","5{Left at own risk","6{Left before seen by doctor","8{Dead on arrival","7{Died within hospital","4{Transfer - hosp to hosp");


/*
print"<input type= 'hidden' name = 'BedReq' value= '$patient[BedReq]'>";
print"<input type= 'hidden' name = 'BedReqDate' value= '$patient[BedReqDate]'>";
print"<input type= 'hidden' name = 'BedReqTime' value= '$patient[BedReqTime]'>";
print"<input type= 'hidden' name = 'DepartureDate' value= '$patient[DepartureDate]'>";
print"<input type= 'hidden' name = 'DepartureTime' value= '$patient[DepartureTime]'>";
print"<input type= 'hidden' name = 'AdmitWard' value= '$patient[AdmitWard]'>";

$hiddenar = array ("");
hiddeninput ($hiddenar, $patient);

*/
print "<TR><TD>";
print "<CENTER><TABLE width = 98% border = 0 cellpadding = 0 cellspacing = 0>";##### table for all discharge data
	print "<TR><TD colspan = 2><H3>Discharge<H3></TD></TR>";



	print "<TR><TD width = 85%>";##### Col 1

	print "<CENTER><TABLE width = 100% border = 0 cellpadding = 3 cellspacing = 0>";##### table main details 

$dischargedstatus = $patient[DischargedStatus];
$dischargedto = $patient[DischargedTo];

		print "<TR><TD WIDTH= 40%>Discharge Status </TD><TD WIDTH = 60% >";
		codedropdownbox ($depstatuslist, "DischargedStatus", $dischargedstatus );
		print '</TD></TR>';


switch ($dischargedstatus)
	{
		 case '4': #if transport to another hosp

			print '<input type = "hidden" name = "DischargedTo" value = "19">';
			print '<input type = "hidden" name = "CareComm" value = "Y">';
			print "<input type = \"hidden\" name = \"TransHosp\" value = \"$patient[TransHosp]\">";

			$str_sql = "SELECT Hospital from Hospitals WHERE Code = '$patient[TransHosp]' ";
			$result = mysql_db_query($dbname, $str_sql, $id_link);
			if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
			$hospar = mysql_fetch_row($result);


			print "<TR><TD valign = top>Transferred To </TD><TD>";
			print $hospar[0]; 
			print "<BR><input type=\"text\" name=\"Hospital_search\" size= \"15\">&nbsp;&nbsp;";
			print "<input type=\"submit\" name = \"action\" value=\"Lookup Hospital\">";
			print '</TD></TR>';

			print "<TR><TD>Transport Reason </TD><TD>";
			codedropdownbox ($transreasonlist, "TransReason", $patient[TransReason] );
			print '</TD></TR>';

			print "<TR><TD>Transport Mode </TD><TD>";
			codedropdownbox ($transmodelist, "TransMode", $patient[TransMode] );
			print '</TD></TR>';

			print "<TR><TD>Escort </TD><TD>";
			codedropdownbox ($escortlist, "TransEscort", $patient[TransEscort] );
			print '</TD></TR>';
		break;

		case '3':#admission to SSU
			print '<input type = "hidden" name = "CareComm" value = "Y">';
			print "<input type= 'hidden' name = 'DischargedTo' value= '19'>";
			print "<input type= 'hidden' name = 'DischargedStatus' value= '0'>";
			print "<TR><TD>SSU bed </TD><TD>";
			dropdownbox ($locationlistSSU, "Location", $patient[Location] );
			print '</TD></TR>';
		break;

		case '2':#admission to ward
			print '<input type = "hidden" name = "CareComm" value = "Y">';
			print "<input type= 'hidden' name = 'DischargedTo' value= '19'>";
			print "<TR><TD>Admission Ward </TD><TD>";
			dropdownbox2 ($wardlist, "AdmitWard", $patient[AdmitWard] );
			print '</TD></TR>';
		break;


		case '1': # ask who pt referred to

			print "<TR><TD>Referred to </TD><TD>";
			codedropdownbox ($referredlist, "DischargedTo", $dischargedto );
			print "</TD></TR>";

		break;

		default:
		
	}
		
	if ($dischargedstatus){
		print '<TR><TD>Letter / Fax sent </TD><TD><input type = checkbox name = "CareComm" value="Y"';

		if ((!$dischargedto)||($patient[CareComm] == 'Y')) {
		print " checked"; 
		} else {}
		print "></TD></TR>";
		}

	print "</TABLE></CENTER>";

	print "</TD>";

print "<TD width = 15%>";##### Col 2


	if ( #conditions to allow discharge
		$dischargedstatus == '1' && $dischargedto && $dischargedto != '19'	 || #home and not coded as N/A
		$dischargedstatus == '4' && $patient[TransHosp] && $patient[TransReason] &&  $patient[TransMode] && $patient[TransEscort] || #all transfer details completed
		$dischargedstatus == '2' && $patient[AdmitWard] || # admission details completed
		$dischargedstatus > '4'


	){

	print "<BR><A HREF=\"index.php?action=dischargepatient&key_ID=$key_ID\"><H5><SPAN class='greenbutton' >Discharge</SPAN></H5></A><BR>";
	}
	else{}

print "</TD></TR>";

print "</TABLE></CENTER>";

print "</TD></TR>\n";
?>