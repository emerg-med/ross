<?php
include('common.inc');
#PHPINFO(); 


$refresh = "";

include('header.inc');
include('navbar.inc');


$number_records_to_display = 20;



		$search_str = $arr_request['phone_search'];
		$more = $arr_request[more];
		$sql_search_str = "%$search_str%";##### add wildcards


if ($more !="Y" ) {##### if sent by next/previous links, get details

	if	($arr_request['initial_record']) {
		$initial_record = $arr_request['initial_record'];

		$search_str = $arr_request['phone_search'];

		$sql_search_str = "%$search_str%";##### add wildcards

	}else {
	$initial_record = 0;
	}

	
	##### find the total number of records in this search
	
	$str_sql_all = "SELECT key_ID FROM Phone WHERE (Name LIKE '$sql_search_str' OR Phone LIKE '$sql_search_str' OR Email LIKE '$sql_search_str')";
	$result = mysql_db_query($dbname, $str_sql_all, $id_link);
	if (! $result) {affy_error_exit('*SQL Select Execution has failed.');}
	$number_of_records = mysql_num_rows ($result);
}



 ##### get the batch of records needed for this page using MySQL limit function

$str_sql = "SELECT * FROM Phone WHERE (Name LIKE '$sql_search_str' OR Phone LIKE '$sql_search_str' OR Email LIKE '$sql_search_str')
	ORDER BY Name
	LIMIT $initial_record, $number_records_to_display";

$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) {affy_error_exit('**SQL Select Execution has failed.');}
$number_of_records_on_current_page = @mysql_num_rows($result);

if ($number_of_records < 1) { ##### if no matches display new search form

    print '<CENTER><BR><BR><BR><H3>No matches found.</H3>';
	
	print "<BR><form action=\"$PHP_SELF\" method=\"post\">";

	print "<input type=\"hidden\" name=\"action\" value=$action>";
	print "<input type=\"text\" name=\"phone_search\" size= \"10\" value=\"\">&nbsp;&nbsp;";
	print "<input type=\"submit\" name=\"action\" value=\"Search\">";
	print "</form>";
	print "</CENTER><BR><BR><BR>";

	include('footer.inc');
	exit();
	}
else {##### Display records

    $next_index = $initial_record + $number_records_to_display;

	if ($next_index > $number_of_records) { 
		$next_index = $number_of_records;
		}

    ##### Display a message so the user knows their location in the database table. The messages says "Displaying X to Y of Z records."
	$t1 = $initial_record + 1;
	$junk = $t1;

	##### Determine the starting position of the previous set of records.
    $prev_index = $initial_record - $number_records_to_display;

    ##### The starting position can't be less than zero.	
    if ($prev_index < 0) {
     $prev_index = 0;
    } 
  }  




print "<CENTER><table border=\"0\" width=95% cellspacing=0 cellpadding = 0>"; #table to hold all
  
 print "<tr><td>";
    
	print "<table width=\"100%\"><tr><td align=\"left\" width=\"25%\">";#   table for links and searchbox 
	    
		
		  ##### Link for the previous set of records.
		  if ($initial_record != 0) {
  		    
			// send search terms back
			$search= "phone_search=$search_str";
			$more = "more=Y&table_name=$table_name&key_ID=$key_ID&action=$action";
			$numrec = "number_of_records=$number_of_records";
			$t1 = "initial_record=$prev_index";
        
    
            print "<a href=\"$PHP_SELF?$t1&$numrec&$more&$search\">";
			print "<IMG SRC=\"images/prev.gif\" BORDER= 0 ALT=\"Previous $number_records_to_display\" ></a>";
		  }
	
	print "</td>";
	print "<td valign = middle><CENTER><BR><form action=\"$PHP_SELF\" method=\"post\">";

	print "<input type=\"text\" name=\"phone_search\" size= \"10\" value=\"".(str_replace('%','',($sql_search_str)))."\">";

	print "&nbsp;&nbsp;<input type=\"submit\" name=\"action\" value=\"Search\">";
	print "</form>";
	print "</CENTER></td>";


	print "	<td align=\"right\" width=\"25%\">";
	
		  ##### Link to the next set of records.
		  if ($next_index != $number_of_records) {
			
			// send search terms back
			$search= "phone_search=$search_str";
			$more = "more=Y&table_name=$table_name&key_ID=$key_ID&action=$action";
			$numrec = "number_of_records=$number_of_records";
		    $t1 = "initial_record=$next_index";
           
            print "<a href=\"$PHP_SELF?$t1&$numrec&$more&$search\">";
			print "<IMG SRC=\"images/next.gif\" BORDER= 0 ALT=\"Next $number_records_to_display\" ></a>";
			}

print "</TD>";
print "</TR></TABLE>";
 
  
print "</TD></TR>";
print "<TR><TD>";

print "<CENTER>";
print "<TABLE BORDER=\"1\" CELLPADDING=\"3\" CELLSPACING=\"0\" WIDTH=90%>\n";# main result display table

###### header for results table
print "<TR><TH>"; 
print "<CENTER><H3>Phone Numbers - Displaying $junk to $next_index ";
print "of $number_of_records records</H3>";
print "</TH><TH><H3>Phone</H3></TH><TH><H3>e-mail</H3></TH><TH><H3>Pager</H3></TH></TR>\n";

 
    for ($iindex = 0;    ######  get records on this page
	     $iindex < $number_of_records_on_current_page; 
		 $iindex++) {

		$record = @mysql_fetch_array($result);
   
		print "<tr><td><H5>";##### display them
		  
		print "$record[Name]";
		print "</H5></td>";
		print "<td align=right><H5>$record[Phone]";
		print "</H5></td>";
		print "<td align=right><H5>";
		if ($record[Email]){

		print "<a href=\"mailto:$record[Email] \">e-mail</a>";
		}
		else{}
		print "</H5></td>";
		print "<td align=right><H5>";
		if ($record[Pager]){

		print "<a href=\"javascript:popupwindow('pager.php?pager=$record[Pager]&name=$record[Name]');\">Page</a>";
		}
		else{}
		print "</H5></td></tr>\n";
		
    }	
  
print "</TABLE></CENTER>";
print "</TD></TR></TABLE>";
print "<H6>Just click to send an e-mail.</H6>";
print "</CENTER><BR>";



include('footer.inc');






?>



