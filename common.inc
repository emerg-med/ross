<?php
####
# To add new fields to SQL need to add to update.inc and 
#	hidden entry in reg.php, detail.php.
#
# Naming convention:	
#	php variables/ functions in lowercase
#	variables corresponding to SQL columns in CapitalisedWords
#
####

include('sysvar.inc');

#### set up dates - don't use loop to fill, as need the leading zeros

$hourlist = array  ('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24');

$minutelist = array 	('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59');
$monthlist = array ('01','02','03','04','05','06','07','08','09','10','11','12');
$daylist = array  ('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');

global $todayyear;
global $todaymonth;
global $todayday;

$todayyear = strval (strftime("%Y"));
$todaymonth = strval (strftime ("%m"));
$todayday = strval (strftime ("%d"));

$yearlist = array ( $todayyear, ($todayyear-1) );

#### check sql link

$id_link = @mysql_connect($dbhost, $username, $password);

if (! $id_link) {
	print '<html><head><title>Error</title></head><body>';
	print 'Connection to SQL has failed - common.';
	print '</body></html>';
	exit();
	}

#### define functions

function cleanup ($datastring) {#prevent essays/ malicious behaviour/ turns all " into '
	$datastring = substr($datastring, 0, 200); 
	$datastring = strip_tags(str_replace('"',"'",$datastring));
	return $datastring;
	}

function bigcleanup ($datastring) {#prevent malicious behaviour/ turn all " into '
	$datastring = substr($datastring, 0, 5000); 
	$datastring = trim($datastring); 
	$datastring = strip_tags(str_replace('"',"'",$datastring));
	return $datastring;
	}

function validateform($dataarray, $tovalidate){
	foreach ($tovalidate as $formentry){
		if (! $dataarray[$formentry]){
			$output[]=$formentry;
			}else{}
	}
	if ($output[0]){
		foreach ($output as $invalid){
		$msg = $invalid."<BR>".$msg;
		}
		error ("Sorry, you need to enter more data", "Use the 'back' button to go back and fill in some details about the patient's:<BR><BR>$msg");
		}else{}
	}
  
function dropdownbox($list, $varname, $selectedoption){
	print "<select name=\"$varname\" size= \"1\" >";
	foreach ($list as $option) {
		print '<option';
		if ($option==$selectedoption){print ' selected';}
		print ">$option</option>";
		}
	print "</select>";
	}

function dropdownbox2($list, $varname, $selectedoption){
	print "<select name=\"$varname\" size= \"1\" >";
	print '<option value = ""> - No Selection - </option>';
	foreach ($list as $option) {
		print '<option';
		if ($option==$selectedoption){print ' selected';}
		print ">$option</option>";
		}
	print "</select>";
	}

function codedropdownbox($list, $varname, $selectedoption){
	print "<select name=\"$varname\" size= \"1\" >";
	print '<option value = ""> - - - - - - - - No Selection - - - - - - - - </option>';
	foreach ($list as $option) {
		$optionar = explode ("{", $option);
		print "<option value=$optionar[0]";
		if ($optionar[0]==$selectedoption){print ' selected';}
		print ">$optionar[1]</option>";
		}
	print "</select>";
	}


function procedureboxes ($proc, $Procedures){
	foreach ($proc as $procarray){
		$procar = explode( "{" , $procarray);
		# print procedurebox ($procar[0], $Procedures);
		print "<input type=\"checkbox\" name=\"proceduresar[]\" value=\"$procar[0]\" ";
		if (($Procedures)&&($proc)) {
			if (ereg("$procar[0]", "$Procedures")){
				print ' checked > ';
				} else print '> '; 
			} else print '> ';
			print $procar[1]."<BR>";
		}
	}


function hiddeninput ($hiddenar, $patient) { 
	foreach ($hiddenar as $hidden) {
		print"<input type= \"hidden\" name = \"$hidden\" value = \"$patient[$hidden]\">\n";
		}
	}

function error ($msg1, $msg2){
	$refresh = "60";
	include ('sysvar.inc');
	include($path."header.inc"); 
	include("$path/navbar.inc"); 
	print"<BR><BR><BR><CENTER><H2>$msg1</H2></CENTER><BR><BR>";
	print"<CENTER><H2>$msg2</H2></CENTER><BR><BR><BR>";
	include("$path/footer.inc"); 
	exit;
	}

function affy_error_exit($msg) {
	$errno = mysql_errno();
	$error = mysql_error();
	print '<html><head><title>Error</title></head><body>';
	print $msg;
	print "<br>Error: ($errno) $error<br>";
	print '</body></html>';
	exit();
	}

#### End of functions


#### Get stuff off the url and put into an array

$arr_request = array();

if (count($HTTP_GET_VARS)) {
	while (list($key, $value) = each ($HTTP_GET_VARS)) {
		$arr_request[$key] = $value;
		}
	}
if (count($HTTP_POST_VARS)) {
	while (list($key, $value) = each ($HTTP_POST_VARS)) {
		$arr_request[$key] = $value;
		}
	}
?>
