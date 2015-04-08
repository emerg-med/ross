<?php
#####
# to add new fields to SQL need to add to update.inc and hidden entry in reg.php, detail.php.
#
# naming convention:	php variables/ functions in lowercase
#						variables corresponding to SQL columns in CapitalisedWords
#
#####

	
$administrator_email = 'enquiries@emerg-med.com';



################################ System variables: do not change these unless you know what you are doing

$yesnolist = array ("No","Yes");
$bgcolor = "99CCCC";# 88BBDD


########## define functions

  function cleanup ($datastring) {#prevent essays/ malicious behaviour/ turns all " into '
	$datastring = substr($datastring, 0, 200); 
	$datastring = strip_tags(str_replace('"',"'",$datastring));
	return $datastring;
	}

  function bigcleanup ($datastring) {#prevent malicious behaviour/ turn all " into '
	$datastring = substr($datastring, 0, 5000); 
	$datastring = strip_tags(str_replace('"',"'",$datastring));
	return $datastring;
	}

  function error ($msg1, $msg2){
	$refresh = "60";
	include("./wwwheader.inc"); #../html/header
	include("./wwwnavbar.inc"); 
	print"<BR><BR><BR><CENTER><H2>$msg1</H2></CENTER><BR><BR>";
	print"<CENTER><H2>$msg2</H2></CENTER><BR><BR><BR>";
	include('./wwwfooter.inc'); 
	exit;
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


######## End of functions


######## Get stuff off the url and put into an array

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