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
include('header.inc'); 
include('navbar.inc');

# keep this part as HTML as is easier to alter layout 
?>

<!--  Start Main Table -->

<CENTER>
<TABLE cellpadding=0 cellspacing=0 WIDTH =98% border=0> <!-- main table -->
<TR>
	<TD colspan=3>
	<H4 style='float: left'>SSU</H4>
<!--	<A HREF="handover.php?location_name=SSU" style='float: left; margin: 4px 0 0 10px'><IMG SRC="images/notesh.gif" ALT="Handover Sheet"></A>-->
	<A HREF="handover.php?location_name=SSU" style='float: left; margin: 2px 0 0 10px'><I><U><FONT size='-1'>(click here to print hand-over sheet)</FONT></U></I></A>
	</TD>
</TR>
<TR>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- bay 1 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 1, Bed 3"; include('patient.inc')?>
				<!-- bay 1 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 1, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 1 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 1, Bed 2"; include('patient.inc')?>
				<!-- bay 1 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 1, Bed 5"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 1 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 1, Bed 1"; include('patient.inc')?>
				<TD style='height: 75px;'><CENTER><H4>Bay 1</H4></CENTER></TD>
			</TR>
		</TABLE>
	</TD>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- bay 2 bed 4 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 2, Bed 2"; include('patient.inc')?>
				<!-- bay 2 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 2, Bed 3"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 2 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 2, Bed 1"; include('patient.inc')?>
				<!-- bay 2 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 2, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<TD style='height: 75px;'><CENTER><H4>Bay 2</H4></CENTER></TD>
				<!-- bay 2 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 2, Bed 5"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
	<TD width=34%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- bay 3 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 3, Bed 3"; include('patient.inc')?>
				<!-- bay 3 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 3, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 3 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 3, Bed 2"; include('patient.inc')?>
				<!-- bay 3 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 3, Bed 5"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 3 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 3, Bed 1"; include('patient.inc')?>
				<TD style='height: 75px;'><CENTER><H4>Bay 3</H4></CENTER></TD>
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
				<!-- bay 4 bed 4 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 4, Bed 2"; include('patient.inc')?>
				<!-- bay 4 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 4, Bed 3"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 4 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 4, Bed 1"; include('patient.inc')?>
				<!-- bay 4 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 4, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<TD style='height: 75px;'><CENTER><H4>Bay 4</H4></CENTER></TD>
				<!-- bay 4 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 4, Bed 5"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 75px;'>
				<!-- bay 5 bed 3 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 5, Bed 3"; include('patient.inc')?>
				<!-- bay 5 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 5, Bed 4"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 5 bed 2 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 5, Bed 2"; include('patient.inc')?>
				<!-- bay 5 bed 5 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 5, Bed 5"; include('patient.inc')?>
			</TR>
			<TR style='height: 75px;'>
				<!-- bay 5 bed 1 -->
				<? $tableformat= 'width=50% border=0'; $location="SSU Bay 5, Bed 1"; include('patient.inc')?>
				<TD style='height: 75px;'><CENTER><H4>Bay 5</H4></CENTER></TD>
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
				<!-- Side Room A -->
				<? $tableformat= 'width=16% border=0'; $location="SSU SR A"; include('patient.inc')?>
				<!-- Side Room B -->
				<? $tableformat= 'width=16% border=0'; $location="SSU SR B"; include('patient.inc')?>
				<!-- Side Room C -->
				<? $tableformat= 'width=17% border=0'; $location="SSU SR C"; include('patient.inc')?>
				<!-- Side Room D -->
				<? $tableformat= 'width=17% border=0'; $location="SSU SR D"; include('patient.inc')?>
				<!-- Side Room E -->
				<? $tableformat= 'width=17% border=0'; $location="SSU SR E"; include('patient.inc')?>
				<!-- Day Room -->
				<? $tableformat= 'width=17% border=0'; $location="SSU Day Room"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
</TR>
</TABLE> <!-- main table -->
</CENTER>
<!-- Finish Main Table -->

 
<?php include('footer.inc'); ?>