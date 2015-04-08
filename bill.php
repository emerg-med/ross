<?php # makes a bill - currrently Australian format
require('common.inc');

#phpinfo();

$key_ID=$arr_request[key_ID];


if ($arr_request['action']=='Lookup MBS_Procedure'){ #look up procedure
	$field1 = 'Procedure'; 
	$both= "code";
	$table_name = 'Medicare';	
	$action = 'Lookup MBS_Procedure';
	$search_str= $arr_request['MBS_Procedure_search'];
	$sort_field = 'ItemNumber';
	$description = "MBS_Procedure";
	$code = "ItemNumber";
	include('datalookup.php');
	exit;
	}

if ($arr_request[newvalue2]){ #if new procedure added
	$str_sql = "select Procedures from Patients WHERE key_ID=$key_ID";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) {affy_error_exit('SQL Select Execution 444 has failed.');}
	$patient=@mysql_fetch_array($result);
	
	$patient[Procedures]=$patient[Procedures]."{".$arr_request[newvalue2];

	$str_sql = "UPDATE Patients SET Procedures='".$patient[Procedures]."' WHERE key_ID=$key_ID";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) {affy_error_exit('SQL Select Execution 66 has failed.');}
	}


if ($arr_request[action]=='DeleteProcedure'){ #to delete procedure
	$str_sql = "select Procedures from Patients WHERE key_ID=$key_ID";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) {affy_error_exit('SQL Select 55 Execution has failed.');}
	$patient=@mysql_fetch_array($result);
	
	
	$patient[Procedures]=ereg_replace( $arr_request[procnumber] , "" , $patient[Procedures]);
	$patient[Procedures]=ereg_replace( "{{" , "{" , $patient[Procedures]);
	if (substr($patient[Procedures] , -1, 1)=="{"){
	$patient[Procedures]=substr_replace($patient[Procedures] , '' , -1, 1);
	}
#print substr($patient[Procedures] , -1 , 1)."pp";	

	$str_sql = "UPDATE Patients SET Procedures='".$patient[Procedures]."' WHERE key_ID=$key_ID";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) {affy_error_exit('SQL Select 0 Execution has failed.');}
	}

$str_sql = "select * from Patients WHERE key_ID=$key_ID";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit("SQL Select 1 Execution has failed.$str_sql");}
$patient=@mysql_fetch_array($result); 

$total=0;

if ($arr_request['action']=='Print'){ 
	include('billprint.inc');
	exit;
	}



if (!$patient[UR]){$patient[UR]='000000';}


# change the code for the second ECG, if done
$patient[Procedures]=ereg_replace("ECG2","11700",$patient[Procedures]);

#print $patient[Procedures]."<BR>".$temprocarray[0]."<BR>";

#Remove the facility fee from the codes
if (ereg("FacFee",$patient[Procedures])){
	$patient[Procedures]=ereg_replace("FacFee\{","",$patient[Procedures]);
	$FacFee=1;
	}else{
	$FacFee=0;
	}

#add codes for pressure monitoring
if (ereg("13842",$patient[Procedures])){
	$patient[Procedures]=$patient[Procedures]."{11600";
	}
if (ereg("13815",$patient[Procedures])){
	$patient[Procedures]=$patient[Procedures]."{11600";
	}


$tempprocarray = explode("{",$patient[Procedures]);
sort ($tempprocarray);

#if (!$tempprocarray[0]){
#	$temprocarray[0]=$patient[Procedures];
#	}



include('header.inc');
include('navbar.inc'); 


print "<FORM METHOD=POST ACTION='bill.php'>";
print "<BLOCKQUOTE><BR>";

print "Bill for: <B>".$patient[FirstName]." ".$patient[Surname]."</B>";
print "<BR><BR>";
print "<TABLE cellspacing=2 cellpadding=5>";
print "<TR><TH width=30></TH><TH width=105>MBS</TH><TH width=500>Description</TH><TH>&nbsp;</TH><TH width=120>Fee (85%)</TH>";

if ($FacFee){
	$str_sql = " SELECT Number1 FROM Setup WHERE Name='FacilityFee'";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution  44 has failed.');}
	$resultar = mysql_fetch_array($result);
	if (!$resultar){$facilityfee=0;}else{$facilityfee=$resultar[Number1];}

	print "<TR><TD></TD><TD></TD><TD><FONT SIZE=1>Facility Fee</FONT></TD><TD></TD><TD><H5>$ $facilityfee</H5></TD>";
	print "<input type = 'hidden' name = 'FacFee' value = '$FacFee'>";

	$total= $total+$facilityfee;
	}

$j=count($tempprocarray);

print "<input type = 'hidden' name = 'numprocs' value = '$j'>";

for ( $i=0; $i<$j; $i++ ){
	
	# print $patient[Procedures]."<BR>".$temprocarray[$i]."<BR>";

	$str_sql = "select * from Medicare WHERE ItemNumber = $tempprocarray[$i]";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) {affy_error_exit('SQL Select Execution 777 has failed.');}
	$medicare=@mysql_fetch_array($result); 

	print "<TR><TD VALIGN=TOP><H5>";
	print ($i+1)."</H5></TD><TD VALIGN=TOP><H5>$tempprocarray[$i]&nbsp;<A HREF=\"$PHP_SELF?action=DeleteProcedure&procnumber=$tempprocarray[$i]&key_ID=$key_ID\"><SPAN class='redbutton' >Delete</SPAN></H5></A>";
	
	print "</TD><TD  VALIGN=TOP><FONT SIZE=1> ".$medicare[MBS_Procedure]." ".$medicare[DerivedDescription]."</FONT></TD><TD VALIGN=TOP>";
	
	if ($tempprocarray[$i]>30000){#if surgical/ortho item
		print "<FONT SIZE=\"1\" ><INPUT TYPE=\"radio\" NAME=\"multiplier".$i."\" VALUE=\"1\" CHECKED>100%<BR><INPUT TYPE=\"radio\" NAME=\"multiplier".$i."\" VALUE=\"0.75\">75%<BR><INPUT TYPE=\"radio\" NAME=\"multiplier".$i."\" VALUE=\"0.5\">50%<BR><INPUT TYPE=\"radio\" NAME=\"multiplier".$i."\" VALUE=\"0.25\">25%</FONT>";
		}else{
		print "<input type = 'hidden' name = 'multiplier".$i."' value = '1'>";
		}

	print "</TD><TD VALIGN=TOP><H5>";
	
	print "<input type = 'hidden' name = 'itemno$i' value = '$tempprocarray[$i]'>";	
	print "<input type = 'hidden' name = 'bill$i' value = '$i'>";
	print "<input type = \"hidden\" name = \"description$i\" value = \"".$medicare[MBS_Procedure]." ".$medicare[DerivedDescription]."\">";

	if($medicare[Fee85]){#if a fee is listed, use it otherwise give a text entry box and calculator
		print "$ ".number_format($medicare[Fee85], 2);
		print "<input type = 'hidden' name = 'fee$i' value = '".number_format($medicare[Fee85], 2)."'>";
		}else{
		print "$ <input type = 'text' name = 'fee$i' size=5 >";
		print "<A HREF=\"javascript:minipopupwindow('./java/calculator.html');\"><IMG SRC=\"images/calc.gif\" ALT=\"Calculator\"></A>";
		}
	$total=$total+$medicare[Fee85];
	print "</H5></TD></TR>";
	}


print "<TR><TD colspan=4 ALIGN=RIGHT VALIGN=TOP><B>Total $</B></TD><TD><B>".number_format($total, 2)."</B>";

print "<BR><BR><INPUT TYPE=\"submit\" NAME=\"action\" VALUE=\"Print\">";

print "</TD></TR></TABLE>";
 

print "<input type = 'hidden' name = 'key_ID' value = '$key_ID'>";


print "<CENTER><TABLE>";
print "<TR><TD valign = top>Add procedure </TD><TD>";
print "<input type=\"text\" name=\"MBS_Procedure_search\" size= \"15\">&nbsp;&nbsp;";
print "<input type=\"submit\" name = \"action\" value=\"Lookup MBS_Procedure\">";
print '</TD></TR>';
print "</TABLE>";
print "<BR><FONT SIZE=\"1\" >Multiple lacerations - 100% first item, 50% second, 25% others. 75% if LMO follow-up. Fractures - 50% if not providing follow-up.</FONT>";

print "</CENTER></BLOCKQUOTE>";
print "<BR>";
print "</FORM>";


include('footer.inc'); 
?>