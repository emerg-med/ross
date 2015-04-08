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
<TABLE cellpadding=1 cellspacing=1 WIDTH =98% border=0><TR><TD><!-- main table -->


<TABLE cellpadding=1 cellspacing=1 border=3 width=100%><!-- 2 side by side windows -->
<TR><!-- window 1 -->
<TD width=25% valign=top><!-- window 1 -->


	<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- resus --><TR><TD><CENTER><H4><B>RESUSCITATION</B></H4></CENTER></TD></TR>
		<TR>
		<!-- resus 1 -->
		<? $tableformat= 'width=100%'; $location="Resus 1"; include('patient.inc')?>

		
		</TR><TR>
		<!-- resus 2 -->
		<? $tableformat= 'width=100%'; $location="Resus 2"; include('patient.inc')?>
		
		</TR>
	</TABLE>

<BR>
	<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- waiting room --><TR><TD><CENTER><H4><B>WAITING ROOM </B></H4></CENTER></TD></TR>
		<TR>
		<? $tableformat= 'width=100%'; $location="Waiting Room"; include('patient.inc')?>

		</TR>
		</TABLE>



</TD><!-- window 1 -->
<TD width=75% valign=top><!-- window 2 -->


<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- cubicles 1-6 -->
		<TR>
		<!-- cubicle 1 -->
		<? $tableformat= 'width=33%'; $location="Bay 1"; include('patient.inc')?>

		<!-- cubicle 2 -->
		<? $tableformat= 'width=33%'; $location="Bay 2"; include('patient.inc')?>

		<!-- cubicle 3 -->
		<? $tableformat= 'width=33%'; $location="Bay 3"; include('patient.inc')?>

		</TR>
		<TR>
		<!-- cubicle 4 -->
		<? $location="Bay 4"; include('patient.inc')?>
	
		<!-- cubicle 5 -->
		<? $location="Bay 5"; include('patient.inc')?>

		<!-- cubicle 6 -->
		<? $location="Bay 6"; include('patient.inc')?>
	
		</TR>
	</TABLE>


<BR>

	<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- cubicles 7-16 -->
		<TR>
		<TD width=50%><!-- cubicle 16 --><CENTER><H4><B>CUBICLES</B></H4></CENTER>
		</TD>
		<!-- cubicle 7 -->
		<? $tableformat= 'width=50%'; $location="Bay 7"; include('patient.inc')?>
		
		</TR>
		<TR>
		<!-- cubicle 15 -->
		<? $location="Bay 15"; include('patient.inc')?>
		
		<!-- cubicle 8 -->
		<? $location="Bay 8"; include('patient.inc')?>
		
		</TR>
		<TR>
		<!-- cubicle 14 -->
		<? $location="Bay 14"; include('patient.inc')?>
		
		<!-- cubicle 9 -->
		<? $location="Bay 9"; include('patient.inc')?>
		
		</TR>
		<TR>
		<!-- cubicle 13 -->
		<? $location="Bay 13"; include('patient.inc')?>
		
		<!-- cubicle 10 -->
		<? $location="Bay 10"; include('patient.inc')?>
		
		</TR>
		<TR>
		<!-- cubicle 12 -->
		<? $location="Bay 12"; include('patient.inc')?>
		
		<!-- cubicle 11 -->
		<? $location="Bay 11"; include('patient.inc')?>
		
		</TR>
	
	</TABLE>

<BR>

	<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- other treatment areas -->
		<TR>
		<!-- treatment room -->
		<? $tableformat= 'width=50%'; $location="Treatment"; include('patient.inc')?>
		
		<!-- eye bay -->
		<? $tableformat= 'width=50%'; $location="Eye Bay"; include('patient.inc')?>
		
		</TR>
	</TABLE>
	

</TD><!-- window 2 -->
</TR><!-- window 2 -->
</TABLE><!-- 2 side by side windows -->	


</TD></TR></TABLE><!-- main table -->
</CENTER>
<!-- Finish Main Table -->

 
<?php include('footer.inc'); ?>