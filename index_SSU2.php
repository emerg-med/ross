<?php 
require('common.inc');

if ($arr_request['action']==update){ 
	include('update.inc');
	}

if ($arr_request['action']==dischargepatient){ 
	include('dischargepatient.inc');
	}


## get all patients
/*
$str_sql = "select * from Patients";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit('SQL Select Execution has failed.');}

$number_of_patients = @mysql_num_rows($result);
 

#find out how many are w
$str_sql = "select * FROM Patients WHERE Location = '$location' ORDER BY TriageCategory" ;
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit('SQL Select Execution has failed.');}

if (mysql_num_rows($result)!=0) {
*/

$refresh="60";
include('headerblue.inc'); 
include('navbar.inc');

# keep this part as HTML as is easier to alter layout 
?>

<!--  Start Main Table -->

<CENTER>
<TABLE cellpadding=0 cellspacing=0 WIDTH =98% border=0> <!-- main table -->
<TR>
	<TD colspan=3>
	<H4 style='float: left'>SSU-2</H4>
	<A HREF="handover.php?location_name=SSU-2" style='float: left; margin: 2px 0 0 10px'><I><U><FONT size='-1'>(click here to print hand-over sheet)</FONT></U></I></A>
	</TD>
</TR>
<TR>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- bay 6 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 6, Bed 2"; include('patient.inc')?>
				<!-- bay 6 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 6, Bed 3"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 6 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 6, Bed 1"; include('patient.inc')?>
				<!-- bay 6 bed 4 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 6, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<TD style='height: 75px;'><CENTER><H4>Bay 6</H4></CENTER></TD>
				<!-- bay 6 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 6, Bed 5"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- bay 7 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 7, Bed 2"; include('patient.inc')?>
				<!-- bay 7 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 7, Bed 3"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 7 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 7, Bed 1"; include('patient.inc')?>
				<!-- bay 7 bed 4 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 7, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<TD style='height: 75px;'><CENTER><H4>Bay 7</H4></CENTER></TD>
				<!-- bay 7 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 7, Bed 5"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
	<TD width=34%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- bay 8 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 8, Bed 3"; include('patient.inc')?>
				<!-- bay 8 bed 4 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 8, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 8 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 8, Bed 2"; include('patient.inc')?>
				<!-- bay 8 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 8, Bed 5"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 8 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 8, Bed 1"; include('patient.inc')?>
				<TD style='height: 75px;'><CENTER><H4>Bay 8</H4></CENTER></TD>
			</TR>
		</TABLE>
	</TD>
</TR>
<TR height='37px'>
	<TD colspan=6>&nbsp;</TD>
</TR>
<TR>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- bay 9 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 9, Bed 2"; include('patient.inc')?>
				<!-- bay 9 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 9, Bed 3"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 9 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 9, Bed 1"; include('patient.inc')?>
				<!-- bay 9 bed 4 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 9, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<TD style='height: 75px;'><CENTER><H4>Bay 9</H4></CENTER></TD>
				<!-- bay 9 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 9, Bed 5"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- bay 10 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 10, Bed 3"; include('patient.inc')?>
				<!-- bay 10 bed 4 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 10, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 10 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 10, Bed 2"; include('patient.inc')?>
				<!-- bay 10 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 10, Bed 5"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 10 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU-2 Bay 10, Bed 1"; include('patient.inc')?>
				<TD style='height: 75px;'><CENTER><H4>Bay 10</H4></CENTER></TD>
			</TR>
		</TABLE>
	</TD>
	<TD width=34%>
		&nbsp;
	</TD>
</TR>
<TR height='38px'>
	<TD colspan=6>&nbsp;</TD>
</TR>
<TR>
	<TD width=100% colspan=6>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- Side Room F -->
				<? $tableformat= 'width=16% border=0'; $location="SSU-2 SR F"; include('patient.inc')?>
				<!-- Side Room G -->
				<? $tableformat= 'width=16% border=0'; $location="SSU-2 SR G"; include('patient.inc')?>
				<!-- Side Room H -->
				<? $tableformat= 'width=17% border=0'; $location="SSU-2 SR H"; include('patient.inc')?>
				<!-- Side Room J -->
				<? $tableformat= 'width=17% border=0'; $location="SSU-2 SR J"; include('patient.inc')?>
				<!-- Side Room K -->
				<? $tableformat= 'width=17% border=0'; $location="SSU-2 SR K"; include('patient.inc')?>
				<!-- Day Room -->
				<? $tableformat= 'width=17% border=0'; $location="SSU-2 Day Room"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
</TR>
</TABLE> <!-- main table -->
</CENTER>
<!-- Finish Main Table -->

 
<?php include('footer.inc'); ?>