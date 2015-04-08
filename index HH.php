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
<TD width=30% valign=top><!-- window 1 -->


	<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- waiting room --><TR><TD><CENTER><H4><B>WAITING ROOM </B></H4></CENTER></TD></TR>
		<TR>
		<? $tableformat= 'width=100%'; $location="WR"; include('patient.inc')?>

		</TR>
		</TABLE>



</TD><!-- window 1 -->
<TD width=70% valign=top><!-- window 2 -->


<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- cubicles 1-6 -->
		<TR>
		<!-- header -->
		<? #$tableformat= 'width=40%'; $location=""; include('patient.inc')?>
		<TD><CENTER><H4><B>RECOVERY</B></H4></CENTER></TD>
		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- header -->
		<? #$tableformat= 'width=40%'; $location=""; include('patient.inc')?>
		<TD><CENTER><H4><B>MINORS</B></H4></CENTER></TD>
	
		</TR>
		
		
		<TR>
		<!-- Rec 4 -->
		<? $tableformat= 'width=40%'; $location="Rec 4"; include('patient.inc')?>

		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 1 -->
		<? $tableformat= 'width=40%'; $location="Min 1"; include('patient.inc')?>

		</TR>


		<TR>
		<!-- Rec 3 -->
		<? $tableformat= 'width=40%'; $location="Rec 3"; include('patient.inc')?>

		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 2 -->
		<? $tableformat= 'width=40%'; $location="Min 2"; include('patient.inc')?>

		</TR>

		<TR>
		<!-- Rec 2 -->
		<? $tableformat= 'width=40%'; $location="Rec 2"; include('patient.inc')?>

		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 3 -->
		<? $tableformat= 'width=40%'; $location="Min 3"; include('patient.inc')?>

		</TR>

		<TR>
		<!-- Rec 1 -->
		<? $tableformat= 'width=40%'; $location="Rec 1"; include('patient.inc')?>

		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 4 -->
		<? $tableformat= 'width=40%'; $location="Min 4"; include('patient.inc')?>

		</TR>

		<TR>
		<!-- resus title -->
		<? # $tableformat= 'width=40%'; $location=""; include('patient.inc')?>
		<TD><CENTER><H4><B>RESUS</B></H4></CENTER></TD>

		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 5 -->
		<? $tableformat= 'width=40%'; $location="Min 5"; include('patient.inc')?>

		</TR>

		<TR>
		<!-- Resus 1 -->
		<? $tableformat= 'width=40%'; $location="Resus 1"; include('patient.inc')?>

		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 6 -->
		<? $tableformat= 'width=40%'; $location="Min 6"; include('patient.inc')?>

		</TR>

		<TR>
		<!-- Resus 2 -->
		<? $tableformat= 'width=40%'; $location="Resus 2"; include('patient.inc')?>

		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 7 -->
		<? $tableformat= 'width=40%'; $location="Min 7"; include('patient.inc')?>

		</TR>

		<TR>
		<!-- corridor title -->
		<? $tableformat= 'width=40%'; $location=""; include('patient.inc')?>

		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 8 -->
		<? $tableformat= 'width=40%'; $location="Min 8"; include('patient.inc')?>

		</TR>

		<TR>
		<!--  -->
		<? #$tableformat= 'width=40%'; $location=""; include('patient.inc')?>
		<TD><CENTER><H4><B>CORRIDOR</B></H4></CENTER></TD>
		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 9 -->
		<? $tableformat= 'width=40%'; $location="Min 9"; include('patient.inc')?>

		</TR>

		<TR>
		<!-- Corridor  -->
		<? $tableformat= 'width=40%'; $location="Corridor"; include('patient.inc')?>

		<!-- spacer -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- Min 10 -->
		<? $tableformat= 'width=40%'; $location="Min 10"; include('patient.inc')?>

		</TR>

			

		

		
	</TABLE>


	

</TD><!-- window 2 -->
</TR><!-- window 2 -->
</TABLE><!-- 2 side by side windows -->	


</TD></TR></TABLE><!-- main table -->
</CENTER>
<!-- Finish Main Table -->

 
<?php include('footer.inc'); ?>