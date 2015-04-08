<?php 
require('common.inc');

#phpinfo();

## !!!!!!!! Make sure this file is edited in unix mode



## pull patient record off database

$key_ID  = $arr_request['key_ID']; 
$str_sql = "select * from Patients where key_ID = $key_ID";

$result = mysql_db_query($dbname, $str_sql, $id_link);

if (! $result) {affy_error_exit('This patient has been discharged or does not exist.');}

$patient = mysql_fetch_array($result);

if (!$patient[UR]){$patient[UR]='000000';}

#$barcode = "/usr/local/bin/barcode -b ".$patient[UR]." -o ".$path."temp/barcode".$patient[UR].".eps -E -g 50x10 0x0 -u mm -n";

#make barcode for this UR

exec ("/usr/local/bin/barcode -b ".$patient[UR]." -o ".$path."/var/www/html/temp/barcode".$patient[UR].".eps -E -g 50x10 0x0 -u mm -n");

#print $barcode;

#
## get alerts


$alert="";	
$str_sql = "select * from Alerts where AlertUR = '".$patient[UR]."' ";

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit('alerts SQL Execution has failed.');}

while ($alertarray = mysql_fetch_array($result)){
	$alert= $alert.$alertarray[Alert];
	}
if(!$alert){

	$alert="@CurveBox { 0.7f @Font { Alerts: none }} ";
	}else{
	
	$alert="{ 1.0 0.0 0.0 setrgbcolor } @SetColour {@CurveBox { 0.7f @Font { Alerts: ".$alert." }}} ";

	}



$dob = substr($patient[DateOfBirth],0,2)."\"/\"".substr($patient[DateOfBirth],2,2)."\"/\"".substr($patient[DateOfBirth],4,4);

$notesheader="@Display @Heading 1.5f @Font{ @I {".$patient[FirstName]."} ".$patient[Surname]."       Hosp Nr ".$patient[UR]." +0.2f @VShift @IncludeGraphic \"/var/www/html/temp/barcode".$patient[UR].".eps\" } ";

$notesfooter="0.4f @Font { Notes printed: ".(date("H:i - l F jS, Y"))."  at ". $institution ." Emergency Care Centre   @CopyRight ".(date("Y"))." emerg-med.com} 	@LP ";

include ('notesfront.lout'); 


##write the lout srcipt to notes.txt

$outputFileName = uniqid("notes");
$filehandle = fopen ("/tmp/" . $outputFileName . ".txt","w" );

if (!$filehandle) {	
	error( "not able to write notes", "try again");
	}
#  
$loutstring = "
@SysInclude {doc} 
@SysInclude {tbl} 
@Doc
@Text @Begin


";


#/*

switch ($arr_request[notes])
{
	case "obs": #obs chart
		$loutstring = $loutstring.$notesheader."
							
		@IncludeGraphic \"/var/www/html/notes/obschart.eps\" 
		@LP 

		". $notesfooter;
		

	break;
	
	case "long": # short notes = front page, plain notes page, obs page, and drugs/ fluids page
		$loutstring = $loutstring . $notesheader . $notesfront . $notesfooter . "
		
		@NP
		".$notesheader."
		@IncludeGraphic \"/var/www/html/notes/notesextra.eps\" 
		@LP 
		". $notesfooter."

		@NP
		".$notesheader."
		@IncludeGraphic \"/var/www/html/notes/obschart.eps\" 
		@LP 
		". $notesfooter."

		@NP
		".$notesheader.$alert." 
		@LP
		@IncludeGraphic \"/var/www/html/notes/drugsfluids.eps\" 
		@LP 
		". $notesfooter;




	break;
		
	case "short": #short notes = front page and single sheet with small drug sheet at bottom

		$loutstring = $loutstring .$notesheader . $notesfront . $notesfooter . "
		@NP
		".$notesheader."

		@IncludeGraphic \"/var/www/html/notes/notesshort1.eps\" 
		@LP 
		".$alert."
		@LP
		@IncludeGraphic \"/var/www/html/notes/notesshort2.eps\" 
		@LP
		". $notesfooter;

		
		
	break;

	case "drugs": #drug and fluid and fluid balance chart		@CurveBox { 0.7f @Font { Alerts: ".$alert." }} 


		$loutstring = $loutstring.$notesheader.$alert."
		@LP				
		@IncludeGraphic \"/var/www/html/notes/drugsfluids.eps\" 
		@LP
		". $notesfooter;

	break;

	default: # =extra plain notes sheet
		$loutstring = $loutstring.$notesheader."
		
		@IncludeGraphic \"/var/www/html/notes/notesextra.eps\" 
		@LP 
		". $notesfooter;

}

#* /

$loutstring = $loutstring." 
@LP
@End @Text";

fwrite ($filehandle, $loutstring);

fclose($filehandle);


### using perl to process output via lout to postsript, then to lpr doesn't hold up apache

## these work from the command line - prob permission problems

# exec ("perl perl/printnotes.pl");  
# exec ("lout temp/notes.txt >temp/notes.ps");
# exec ("perl -e 'lout temp/notes.txt >temp/notes.ps'");
#	exec ("lout -PDF var/www/html/temp/notes.txt >var/www/html/temp/notes.pdf");

# now get lout to translate into postscript file notes.ps

# remove the -PDF switch, and set to notes.ps to print out

# if (!$printer){
#	exec ("lout -PDF temp/notes.txt >temp/notes.pdf");
#	}else{

	exec ("lout /tmp/" . $outputFileName . ".txt > /tmp/" . $outputFileName . ".ps 2> /tmp/lout.log");

	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename="' . $patient[Surname] . $patient[FirstName] . '-' . $arr_request[notes] . 'notes.pdf"');
	ob_start();
	passthru ("ps2pdf -sPAPERSIZE=a4 /tmp/" . $outputFileName . ".ps -");
	ob_end_flush();

	unlink("/tmp/" . $outputFileName . ".txt");
	unlink("/tmp/" . $outputFileName . ".ps");
	#	}

# header("Location: http://192.168.0.187/temp/notes2.pdf");
exit();

#### delete the barcode

# exec ("rm ".$path."temp/barcode".$patient[UR].".eps");
 

#### print out a confirmation screen.


include('header.inc'); 
include('navbar.inc'); 
print"<BR><BR><BLOCKQUOTE><H3>";
print"Successfully printed<BR><BR>Click <A HREF=\"temp/notes.ps\" TARGET = \"_new\"><FONT COLOR=\"#3300FF\">here</FONT></A> to view a pdf of your notes .<BR>

<BR>If they look a bit bare, it may be that you need to enter more details in the registration screen. A hospital logo can be included in place of the Holby logo.";

print"<BR><BR>";
print "A wide variety of format of notes may be printed, depending on the printer available.<BR><BR>Duplex (double sided) printing of an A3 sheet (= 4 sheets of A4/letter) gives a very good result. This gives a folder which can enclose other documents - extra sheets, ECGs etc.<BR><BR>Good quality, heavyweight ( >100 gsm ) paper, is strongly recommended for archive quality.";
print"<BR><BR>";
print "The notes printer needs to be a heavy duty one which can handle Postscript files.<BR>The cheapest option is to print on multiple sheets of A4/letter size.";

print"</H3></BLOCKQUOTE><BR><BR>"; 
include('footer.inc'); ?>