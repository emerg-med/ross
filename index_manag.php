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
<TD width=15% valign=top><!-- window 1 -->


	<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- resus --><TR><TD><CENTER><H4><B>RESUSCITATION</B></H4></CENTER></TD></TR>
		<TR>
		<!-- resus 1 -->
		<? $tableformat= 'width=100%'; $location="Resus 1"; include('patient.inc')?>

		
		</TR>
		<TR>
		<!-- resus 2 -->
		<? $tableformat= 'width=100%'; $location="Resus 2"; include('patient.inc')?>
		
		</TR>
		<TR>
		<!-- resus 3 -->
		<? $tableformat= 'width=100%'; $location="Resus 3"; include('patient.inc')?>
		
		</TR>
		<TR>
		<!-- resus 4 -->
		<? $tableformat= 'width=100%'; $location="Resus 4"; include('patient.inc')?>
		
		</TR>
	</TABLE>

<BR>
	<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- waiting room --><TR><TD><CENTER><H4><B>WAITING ROOM </B></H4></CENTER></TD></TR>
		<TR>
		<? $tableformat= 'width=100%'; $location="WR"; include('patient.inc')?>

		</TR>
		</TABLE>



</TD><!-- window 1 -->
<TD width=85% valign=top><!-- window 2 -->


<TABLE cellpadding=2 cellspacing=0 border=0 width=100%><!-- cubicles 1-6 -->
		<TR>
		<!-- cubicle 12 -->
		<? $tableformat= 'width=20%'; $location="Maj 12"; include('patient.inc')?>

		<!-- cubicle 11 -->
		<? $tableformat= 'width=20%'; $location="Maj 11"; include('patient.inc')?>

		<!-- cubicle 10 -->
		<? $tableformat= 'width=20%'; $location="Maj 10"; include('patient.inc')?>

		<!-- cubicle 9 -->
		<? $tableformat= 'width=20%'; $location="Maj 9"; include('patient.inc')?>

		<!-- cubicle 8 -->
		<? $tableformat= 'width=20%'; $location="Maj 8"; include('patient.inc')?>
		</TR>
		
		

		
		
		<TR>
		<!-- cubicle 13 -->
		<? $tableformat= 'width=20%'; $location="Maj 13"; include('patient.inc')?>

		<!-- cubicle 14 -->
		<? $tableformat= 'width=20%'; $location="Maj 14"; include('patient.inc')?>

		<!-- cubicle 15 -->
		<? $tableformat= 'width=20%'; $location="Maj 15"; include('patient.inc')?>

		<!-- cubicle 16 -->
		<? $tableformat= 'width=20%'; $location="Maj 16"; include('patient.inc')?>

		<!-- cubicle 7 -->
		<? $tableformat= 'width=20%'; $location="Maj 7"; include('patient.inc')?>
	
		</TR>


		
		<TR>
		<!-- cubicle  -->
		<? # $tableformat= 'width=20%'; $location=""; include('patient.inc')?>
		<TD><CENTER><H4><B>MINORS</B></H4></CENTER></TD>
	
		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle 6 -->
		<? $tableformat= 'width=20%'; $location="Maj 6"; include('patient.inc')?>
	
		</TR>
		
		<TR>
		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Min 1"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Min 2"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Min 3"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle -->
		<? $tableformat= 'width=20%'; $location="Maj 5"; include('patient.inc')?>
	
		</TR>
		
		<TR>
		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Min 6"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Min 5"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Min 4"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle -->
		<? $tableformat= 'width=20%'; $location="Maj 4"; include('patient.inc')?>
	
		</TR>
		
		<TR>
		<!-- cubicle  -->
		<?# $tableformat= 'width=20%'; $location="Maj "; include('patient.inc')?>
		<TD><CENTER><H4><B>PAEDS</B></H4></CENTER></TD>
		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle 3-->
		<? $tableformat= 'width=20%'; $location="Maj 3"; include('patient.inc')?>
	
		</TR>
		
		<TR>
		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Paeds 1"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Paeds 2"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Paeds 3"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="Paeds 4"; include('patient.inc')?>

		<!-- cubicle 2-->
		<? $tableformat= 'width=20%'; $location="Maj 2"; include('patient.inc')?>
	
		</TR>
		
		<TR>
		<!-- cubicle  -->
		<?# $tableformat= 'width=20%'; $location="Maj "; include('patient.inc')?>
		<TD><CENTER><H4><B>CDU</B></H4></CENTER></TD>
		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- corridor  -->
		<? $tableformat= 'width=20%'; $location="Corridor"; include('patient.inc')?>

		<!-- cubicle 1 -->
		<? $tableformat= 'width=20%'; $location="Maj 1"; include('patient.inc')?>
	
		</TR>
		
		<TR>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU 1"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU 2"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU 3"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU 4"; include('patient.inc')?>

		<!-- cubicle 2-->
		<? $tableformat= 'width=20%'; $location="CDU 5"; include('patient.inc')?>
	
		</TR>
				<TR>
		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU 6"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU 7"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU 8"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU 9"; include('patient.inc')?>

		<!-- cubicle 2-->
		<? $tableformat= 'width=20%'; $location="CDU 10"; include('patient.inc')?>
	
		</TR>
				<TR>
		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU Cub1"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location="CDU Cub2"; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle  -->
		<? $tableformat= 'width=20%'; $location=""; include('patient.inc')?>

		<!-- cubicle 2-->
		<? $tableformat= 'width=20%'; $location="MAU"; include('patient.inc')?>
	
		</TR>
		
	</TABLE>


	

</TD><!-- window 2 -->
</TR><!-- window 2 -->
</TABLE><!-- 2 side by side windows -->	


</TD></TR></TABLE><!-- main table -->
</CENTER>
<!-- Finish Main Table -->

 
<?php include('footer.inc'); ?>