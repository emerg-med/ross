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
	<H4>AAU</H4>
	</TD>
</TR>
<TR>
	<TD width=50%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 120px;'>
				<!-- bay 3 bed 4 -->
				<? $tableformat= 'width=33% border=0'; $location="AAU Bay 3, Bed 4"; include('patient.inc')?>
				<!-- bay 3 bed 5 -->
				<? $tableformat= 'width=33% border=0'; $location="AAU Bay 3, Bed 5"; include('patient.inc')?>
				<!-- bay 3 bed 6 -->
				<? $tableformat= 'width=34% border=0'; $location="AAU Bay 3, Bed 6"; include('patient.inc')?>
			</TR>
			<TR style='height: 120px;'>
				<!-- bay 3 bed 3 -->
				<? $tableformat= 'width=33% border=0'; $location="AAU Bay 3, Bed 3"; include('patient.inc')?>
				<!-- bay 3 bed 2 -->
				<? $tableformat= 'width=33% border=0'; $location="AAU Bay 3, Bed 2"; include('patient.inc')?>
				<!-- bay 3 bed 1 -->
				<? $tableformat= 'width=34% border=0'; $location="AAU Bay 3, Bed 1"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
	<TD width=17%>
		<TABLE cellpadding=0 cellspacing=0 width=100%>
			<TR style='height: 121px;'>
				<!-- bay 4 bed 1 -->
				<? $tableformat= 'width=100% style=\'border: 1px solid black;\''; $location="AAU Bay 4, Bed 1"; include('patient.inc')?>
			</TR>
			<TR style='height: 121px;'>
				<TD style='height: 121px;'>&nbsp;</TD>
			</TR>
		</TABLE>
	</TD>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 120px;'>
				<!-- bay 5 bed 2 -->
				<? $tableformat= 'width=50%'; $location="AAU Bay 5, Bed 2"; include('patient.inc')?>
				<TD width='50%'><CENTER><H4>Bay 5</H4></CENTER></TD>
			</TR>
			<TR style='height: 120px;'>
				<!-- bay 5 bed 1 -->
				<? $tableformat= 'width=50%'; $location="AAU Bay 5, Bed 1"; include('patient.inc')?>
				<!-- bay 5 bed 3 -->
				<? $tableformat= 'width=50%'; $location="AAU Bay 5, Bed 3"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
</TR>
<TR>
	<TD width=50%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 120px;'>
				<!-- bay 2 bed 3 -->
				<? $tableformat= 'width=33% border=0'; $location="AAU Bay 2, Bed 3"; include('patient.inc')?>
				<!-- bay 2 bed 4 -->
				<? $tableformat= 'width=33% border=0'; $location="AAU Bay 2, Bed 4"; include('patient.inc')?>
				<!-- bay 2 bed 5 -->
				<? $tableformat= 'width=34% border=0'; $location="AAU Bay 2, Bed 5"; include('patient.inc')?>
			</TR>
			<TR style='height: 120px;'>
				<TD width='33%'><CENTER><H4>Bay 2</H4></CENTER></TD>
				<!-- bay 2 bed 2 -->
				<? $tableformat= 'width=33% border=0'; $location="AAU Bay 2, Bed 2"; include('patient.inc')?>
				<!-- bay 2 bed 1 -->
				<? $tableformat= 'width=34% border=0'; $location="AAU Bay 2, Bed 1"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
	<TD width=17%>
		&nbsp;
	</TD>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 120px;'>
				<TD width='50%'><CENTER><H4>Bay 6</H4></CENTER></TD>
				<!-- bay 6 bed 2 -->
				<? $tableformat= 'width=50%'; $location="AAU Bay 6, Bed 2"; include('patient.inc')?>
			</TR>
			<TR style='height: 120px;'>
				<!-- bay 6 bed 1 -->
				<? $tableformat= 'width=50%'; $location="AAU Bay 6, Bed 1"; include('patient.inc')?>
				<!-- bay 6 bed 3 -->
				<? $tableformat= 'width=50%'; $location="AAU Bay 6, Bed 3"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
</TR>
<TR>
	<TD width=50%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 120px;'>
				<!-- bay 1 bed 2 -->
				<? $tableformat= 'width=33% border=0'; $location="AAU Bay 1, Bed 2"; include('patient.inc')?>
				<!-- bay 1 bed 1 -->
				<? $tableformat= 'width=33% border=0'; $location="AAU Bay 1, Bed 1"; include('patient.inc')?>
				<TD width='50%'><CENTER><H4>Bay 1</H4></CENTER></TD>
			</TR>
		</TABLE>
	</TD>
	<TD width=17%>
		&nbsp;
	</TD>
	<TD width=33%>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% style='border: 1px solid black;'>
			<TR style='height: 120px;'>
				<!-- Side Room A -->
				<? $tableformat= 'width=50%'; $location="AAU SR A"; include('patient.inc')?>
				<!-- Day Room -->
				<? $tableformat= 'width=50%'; $location="AAU Day Room"; include('patient.inc')?>
			</TR>
		</TABLE>
	</TD>
</TR>
</TABLE> <!-- main table -->
</CENTER>
<!-- Finish Main Table -->

 
<?php include('footer.inc'); ?>