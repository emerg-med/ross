<?php  

# !!!!!!!!!  Make sure this file is edited in unix mode/ uploaded as ascii !!!!!!!!


require('common.inc');

## pull patient record off database

$key_ID  = $arr_request['key_ID']; 
$str_sql = "select * from Patients where key_ID = $key_ID";
$result = mysql_db_query($dbname, $str_sql, $id_link);

if (!$result) {affy_error_exit('This patient has been discharged or does not exist.');}

$patient = mysql_fetch_array($result);


$dob = substr($patient[DateOfBirth],0,2)."\"/\"".substr($patient[DateOfBirth],2,2)."\"/\"".substr($patient[DateOfBirth],4,4);


##write the lout srcipt to notes.txt
$outputFileName = uniqid("labels");
$filehandle = fopen ("/tmp/" . $outputFileName . ".txt","w" );

if (!$filehandle) {	
	error( "not able to write labels", "try again");
	}


## main label routine

$labelblock = "";

$labeltext = "
@Rowa
A { ".$patient[FirstName]." @B ".$patient[Surname]." @LP
HN ".$patient[UR]." @LP
".$dob."   Age ".$patient[Age]." @LP
".$patient[Address]." @LP ".$patient[Locality]."  ".$patient[Postcode]."
}
B {
".$patient[FirstName]." @B ".$patient[Surname]." @LP
HN ".$patient[UR]." @LP
".$dob."   Age ".$patient[Age]." @LP
".$patient[Address]." @LP ".$patient[Locality]."  ".$patient[Postcode]."
}
C { 
".$patient[FirstName]." @B ".$patient[Surname]." @LP
HN ".$patient[UR]." @LP
".$dob."   Age ".$patient[Age]." @LP
".$patient[Address]." @LP ".$patient[Locality]."  ".$patient[Postcode]."
}
";

# loop to print $n rows of labels

for ( $n=1 ; $n<8 ; $n++ ){
	$labelblock = $labelblock.$labeltext;
	}



$loutstring = "
@SysInclude {doc}
@SysInclude {tbl}
@Doc 
@Text @Begin
@LP

@Tbl
marginabove {1.8c}
aformat { @Cell width {6.3c} height {3.7c} ml {0.6c} mr {0.1c} A | @Cell width {6.3c} height {3.7c} ml {0.5c} mr {0.1c} B | @Cell width {6.3c} height {3.7c} ml {0.5c} mr {0.6c} C }
{
".$labelblock."
}
@LP


@End @Text";


fwrite ($filehandle, $loutstring);

fclose($filehandle);


### use perl to process output via lout to postsript, then to lpr (doesn't hold up sending page back to browser)

# exec ("perl perl/printnotes.pl");  # exec ("lout temp/notes.txt >temp/notes.ps");


#exec ("perl -e 'lout temp/notes.txt >temp/notes.ps'");


# now get lout to translate into postscript file notes.ps 

# remove the -PDF switch, and set to labels.ps to print out

#	exec ("lout /tmp/" . $outputFileName . ".txt > /tmp/" . $outputFileName . ".ps");

	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename="' . $patient[Surname] . $patient[FirstName] . '-labels.pdf"');

	ob_start();
#	passthru ("ps2pdf -sPAPERSIZE=a4 /tmp/" . $outputFileName . ".ps -");
passthru ("lout -PDF /tmp/" . $outputFileName . ".txt");
	ob_end_flush();

	unlink("/tmp/" . $outputFileName . ".txt");
#	unlink("/tmp/" . $outputFileName . ".ps");
	
	exit();
#### print out a confirmation screen.


include('header.inc'); 
include('navbar.inc'); 
print"<BR><BR><BR><BR><BLOCKQUOTE><H3>";
print"Labels successfully printed<BR><BR>Click <A HREF=\"temp/labels.pdf\" TARGET = \"_new\"><FONT COLOR=\"#3300FF\">here</FONT></A> to view how your labels would look for this patient.<BR><BR>(If the labels look a bit bare, you need to enter more details (e.g. Address, Date of Birth) in the registration screen for this patient.)<BR>
Note that the paper version of the labels includes a standard format barcode of the patient's UR.
";
print"<BR><BR>"; 


print "Different formats of labels may be printed, depending on what printer is available.</H3><UL>
	<LI><H3>tractor feed inkjet printer</H3>
	<LI><H3>laser label sheets</H3>
	<LI><H3>specialist label printers</H3>
</UL><H3>We recommend standard ('Avery') size labels in a standard laser printer as the most efficient solution, as it is easy to provide the backup printers necessary within the organisation.<BR><BR>It is also possible to print custom label sizes - eg a sheet with small labels for pathology tubes.<BR>Barcodes can be printed on the label.<BR><BR>It is not necessary to use a large or expensive laser printer for this job, but it must be able to handle Postscript.";
print"</H3></BLOCKQUOTE><BR><BR><BR><BR>"; 



include('footer.inc'); ?>