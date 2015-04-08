<?php 
require('common.inc');
include('header.inc'); 

## get all patients

$str_sql = "select * from Patients order by Location";
	 	

$result = mysql_db_query($dbname, $str_sql, $id_link);

if (! $result) {
    affy_error_exit('SQL Select Execution has failed.');
  }



 


?>

<!--  Start Main Table -->

<CENTER>
<TABLE cellpadding=1 cellspacing=1 WIDTH =98% border=0><TR><TD><!-- main table -->


<TABLE cellpadding=1 cellspacing=1 border=3 width=100%><!-- 2 side by side windows -->
<TR><!-- window 1 -->
<TD width=25% valign=top><!-- window 1 -->


	



</TD><!-- window 1 -->
<TD width=75% valign=top><!-- window 2 -->






</TD><!-- window 2 -->
</TR><!-- window 2 -->
</TABLE><!-- 2 side by side windows -->	


</TD></TR></TABLE><!-- main table -->
</CENTER>
<!-- Finish Main Table -->



 
<?php include('footer.inc'); ?>