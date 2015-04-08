<?

print "<input type= 'hidden' name = 'Diagnosis1' value= '$Diagnosis1'>";
print "<input type= 'hidden' name = 'Diagnosis2' value= '$Diagnosis2'>";
print "<input type= 'hidden' name = 'Diagnosis3' value= '$Diagnosis3'>";
print "<input type= 'hidden' name = 'sort_field' value= 'Diagnosis'>";

print "<CENTER><TABLE width = 98% border = 0 cellpadding = 3 cellspacing = 0>";#whole diagnosis table
print "<TR><TD Colspan = 3>";
print "<H3>Diagnosis</H3>";
print "</TD></TR>";
print "<TD valign = top width=75%>";

print "<CENTER><TABLE width = 98% border = 0 cellpadding = 3 cellspacing = 3>";#table listing diagnoses

# I got bored trying to write a neat loop

if ($Diagnosis1){
	
	$str_sql = "SELECT Description from UDDA WHERE UDDAUniqueID = '$Diagnosis1' ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	$diagnosisar = mysql_fetch_row($result);
		
	print "<TR><TD width=15% height=40><A HREF=\"$PHP_SELF?action=UpdateData&key_ID=$key_ID&field1=Diagnosis1\"><H5><SPAN class='redbutton' >Delete</SPAN></H5></A></TD><TD>&nbsp;Main:&nbsp;$diagnosisar[0]";
	print '&nbsp;<input type="radio" name="Diagnosis1Certainty" value="1" ';
	if ($Diagnosis1Certainty == 1) {
		print 'checked ';
	}
	print '>';
	print '<FONT size="0.8em">possible</FONT>';
	print '&nbsp;<input type="radio" name="Diagnosis1Certainty" value="2" ';
	if ($Diagnosis1Certainty == 2) {
		print 'checked ';
	}
	print '>';
	print '<FONT size="0.8em">probable</FONT>';
	print '&nbsp;<input type="radio" name="Diagnosis1Certainty" value="3" ';
	if ($Diagnosis1Certainty == 3) {
		print 'checked ';
	}
	print '>';
	print '<FONT size="0.8em">proven</FONT>';
	print "</TD></TR>";
}

if ($Diagnosis2){
	
	$str_sql = "SELECT Description from UDDA WHERE UDDAUniqueID = '$Diagnosis2' ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	$diagnosisar = mysql_fetch_row($result);
		
		print "<TR><TD width=15% height=40><A HREF=\"$PHP_SELF?action=UpdateData&key_ID=$key_ID&field1=Diagnosis2\"><H5><SPAN class='redbutton' >Delete</SPAN></H5></A></TD><TD>&nbsp;Add&nbsp;:&nbsp;$diagnosisar[0]";
	print '&nbsp;<input type="radio" name="Diagnosis2Certainty" value="1" ';
	if ($Diagnosis2Certainty == 1) {
		print 'checked ';
	}
	print '>';
	print '<FONT size="0.8em">possible</FONT>';
	print '&nbsp;<input type="radio" name="Diagnosis2Certainty" value="2" ';
	if ($Diagnosis2Certainty == 2) {
		print 'checked ';
	}
	print '>';
	print '<FONT size="0.8em">probable</FONT>';
	print '&nbsp;<input type="radio" name="Diagnosis2Certainty" value="3" ';
	if ($Diagnosis2Certainty == 3) {
		print 'checked ';
	}
	print '>';
	print '<FONT size="0.8em">proven</FONT>';
		print "</TD></TR>";
}

if ($Diagnosis3){
	$dummy ++;
	$str_sql = "SELECT Description from UDDA WHERE UDDAUniqueID = '$Diagnosis3' ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	$diagnosisar = mysql_fetch_row($result);
		
	print "<TR><TD width=15% height=40><A HREF=\"$PHP_SELF?action=UpdateData&key_ID=$key_ID&field1=Diagnosis3\"><H5><SPAN class='redbutton' >Delete</SPAN></H5></A></TD><TD>&nbsp;Add&nbsp;:&nbsp;$diagnosisar[0]";
	print '&nbsp;<input type="radio" name="Diagnosis3Certainty" value="1" ';
	if ($Diagnosis3Certainty == 1) {
		print 'checked ';
	}
	print '>';
	print '<FONT size="0.8em">possible</FONT>';
	print '&nbsp;<input type="radio" name="Diagnosis3Certainty" value="2" ';
	if ($Diagnosis3Certainty == 2) {
		print 'checked ';
	}
	print '>';
	print '<FONT size="0.8em">probable</FONT>';
	print '&nbsp;<input type="radio" name="Diagnosis3Certainty" value="3" ';
	if ($Diagnosis3Certainty == 3) {
		print 'checked ';
	}
	print '>';
	print '<FONT size="0.8em">proven</FONT>';
	print "</TD></TR>";
}

print "</TABLE></CENTER>";


print "</TD><TD valign = top width=20%>";


print "<CENTER><input type=\"text\" name=\"Diagnosis_search\" size= \"17\"><BR><input type=\"submit\" name = \"action\" value=\"Diagnosis search\"></CENTER>";
print "</TD></TR>";



print "</TABLE></CENTER>\n";

?>