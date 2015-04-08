<?php 
##### looks up MySQL table and links back to update referring page
##### sets $field1, $field2 to $newvalue1, $newvalue2
##### if $both is set, updates both fields, otherwise just updates $field1
##### if $both is set to code
##### $sortfield = field to sort by, 
##### $description = column 1 name, $code = column 2 name
##### $tablename = MySQL table with columns of $description and $code
##### $action = action to be taken when returned to referring page

# need to sort out sortfield and also what happens when no matches and search again


$number_records_to_display = 20;

$key_ID = $arr_request[key_ID];
#$sort_field = $arr_request[sort_field];

if ($arr_request[$description."_search"] != NULL) {
	$sql_search_str = "%" . $arr_request[$description."_search"] . "%";
	$search_str = $arr_request[$description."_search"];
} else {
	$sql_search_str = "%". $search_str . "%";##### add wildcards
}

$refresh = "";
include('recordlock.inc');
include('header.inc');
include('navbar.inc');

#$hiddenar = array ("key_ID","table_name"); ##### send back these details so we can find which record we are updating
#hiddeninput ($hiddenar, $arr_request);

$more = $arr_request['more'];

##### find the total number of records in this search
if ($arr_request['code'] != "") {
	$code = $arr_request['code'];
}

$str_sql_all = "SELECT key_ID FROM $table_name WHERE ($description LIKE '$sql_search_str' OR $code LIKE '$sql_search_str'	)";
$result = mysql_db_query($dbname, $str_sql_all, $id_link);
if (! $result) {affy_error_exit("*SQL Select Execution has failed.<br>$str_sql_all");}
	#{error ("You need to select a patient first!", "Go back and try again");}
$number_of_records = mysql_num_rows ($result);

if ($more == "Y" ) {##### if sent by next/previous links, get details

	if (($number_of_records == $arr_request['number_of_records']) && $arr_request['initial_record']) {
		$initial_record = $arr_request['initial_record'];
		$sort_field = $arr_request['sort_field'];
		$both = $arr_request['both'];
		$field1 = $arr_request['field1'];
		$field2 = $arr_request['field2'];
		$description = $arr_request['description'];
		$descriptiondescription = $arr_request['descriptiondescription'];
		$code = $arr_request['code'];
		$codedescription = $arr_request['codedescription'];
		$var1= $arr_request['var1'];
	}else {
		$initial_record = 0;
	}
} else {
	$initial_record = 0;
}

if ($descriptiondescription == NULL) {
	$descriptiondescription = $description;
}

if ($codedescription == NULL) {
	$codedescription = $code;
}

 ##### get the batch of records needed for this page using MySQL limit function

$str_sql = "SELECT * FROM $table_name WHERE ($description LIKE '$sql_search_str' OR $code LIKE '$sql_search_str')
	ORDER BY $sort_field
	LIMIT $initial_record, $number_records_to_display";

$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) {affy_error_exit("**SQL Select Execution has failed.<br>$str_sql");}
$number_of_records_on_current_page = @mysql_num_rows($result);

if ($number_of_records_on_current_page < 1) { ##### if no matches display new search form

    print '<CENTER><BR><BR><BR><H3>No matches found.</H3>';
	
	print "<BR><form action=\"$PHP_SELF\" method=\"post\">";

	print "<input type=\"hidden\" name=\"action\" value=$action>";
	print "<input type=\"hidden\" name=\"both\" value=\"$both\">";
	print "<input type=\"hidden\" name=\"field1\" value=\"$field1\">";
	print "<input type=\"hidden\" name=\"field2\" value=\"$field2\">";
	print "<input type=\"hidden\" name=\"table_name\" value=\"$table_name\">";
	print "<input type=\"hidden\" name=\"key_ID\" value=\"$key_ID\">";
	print "<input type=\"hidden\" name=\"sort_field\" value=\"$sort_field\">";
	print "<input type=\"hidden\" name=\"code\" value=\"$code\">";
	print "<input type=\"hidden\" name=\"codedescription\" value=\"$codedescription\">";
	print "<input type=\"hidden\" name=\"descriptiondescription\" value=\"$descriptiondescription\">";
	print "<input type=\"hidden\" name=\"var1\" value=\"$var1\">";
	print "<input type=\"text\" name=\"".$description."_search\" size= \"10\" value=\"\">&nbsp;&nbsp;";
	print "<input type=\"submit\" name=\"action\" value=\"$action\">";
	print "</form>";
	print "</CENTER><BR><BR><BR>";
#phpinfo();
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
			$search= $description."_search=$search_str";
			$more = "more=Y&table_name=$table_name&key_ID=$key_ID&action=$action";
			$numrec = "number_of_records=$number_of_records";
			$t1 = "initial_record=$prev_index";
            $sort   = "sort_field=$sort_field&code=$code&description=$description&field1=$field1&field2=$field2&var1=$var1&both=$both&codedescription=$codedescription&descriptiondescription=$descriptiondescription";
    
            print "<a href=\"$PHP_SELF?$t1&$sort&$numrec&$more&$search\">";
			print "<IMG SRC=\"images/prev.gif\" BORDER= 0 ALT=\"Previous $number_records_to_display\" ></a>";
		  }
	
	print "</td>";
	print "<td valign = middle><CENTER><BR><form action=\"$PHP_SELF\" method=\"post\">";


	print "<input type=\"hidden\" name=\"both\" value=$both>";
	print "<input type=\"hidden\" name=\"field1\" value=$field1>";
	print "<input type=\"hidden\" name=\"field2\" value=$field2>";
	print "<input type=\"hidden\" name=\"table_name\" value=\"$table_name\">";
	print "<input type=\"hidden\" name=\"key_ID\" value=$key_ID>";
	print "<input type=\"hidden\" name=\"sort_field\" value=$sort_field>";
	print "<input type=\"hidden\" name=\"descriptiondescription\" value=$descriptiondescrption>";
	print "<input type=\"hidden\" name=\"code\" value=$code>";
	print "<input type=\"hidden\" name=\"codedescription\" value=$codedescription>";
	print "<input type=\"hidden\" name=\"var1\" value=$var1>";

	print "<input type=\"text\" name=\"".$description."_search\" size= \"10\" value=\"".(str_replace('%','',($sql_search_str)))."\">";

	print "&nbsp;&nbsp;<input type=\"submit\" name=\"action\" value=\"$action\">";
	print "</form>";
	print "</CENTER></td>";


	print "	<td align=\"right\" width=\"25%\">";
	
		  ##### Link to the next set of records.
		  if ($next_index != $number_of_records) {
			
			// send search terms back
			$search= $description."_search=$search_str";
			$more = "more=Y&table_name=$table_name&key_ID=$key_ID&action=$action";
			$numrec = "number_of_records=$number_of_records";
		    $t1 = "initial_record=$next_index";
            $sort   = "sort_field=$sort_field&code=$code&description=$description&field1=$field1&field2=$field2&var1=$var1&both=$both&codedescription=$codedescription&descriptiondescription=$descriptiondescription";
            print "<a href=\"$PHP_SELF?$t1&$numrec&$sort&$more&$search\">";
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
print "<CENTER><H3>$descriptiondescription - Displaying $junk to $next_index ";
print "of $number_of_records records</H3>";
print "</TH><TH><H3>$codedescription</H3></TH></TR>\n";

 
    for ($iindex = 0;    ######  get records on this page
	     $iindex < $number_of_records_on_current_page; 
		 $iindex++) {

		$record = @mysql_fetch_array($result);
   
		print "<tr><td><H5>";##### display them
		  
		print "<a href=\"$PHP_SELF?action=UpdateData&key_ID=$key_ID&field1=$field1&field2=$field2&newvalue2=$record[$code]&newvalue1=$record[$description]&both=$both&var1=$var1 \">$record[$description]</a>";
		print "</H5></td>";
		print "<td align=right><H5><a href=\"$PHP_SELF?action=UpdateData&key_ID=$key_ID&field1=$field1&field2=$field2&newvalue2=$record[$code]&newvalue1=$record[$description]&both=$both&var1=$var1\">$record[$code]</a>";
		print "</H5></td></tr>\n";
		
    }	
  
print "</TABLE></CENTER>";
print "</TD></TR></TABLE>";
print "<H6>Just click on the row you want to add.</H6>";
print "</CENTER>";
print "</BODY>";
#phpinfo();
?>