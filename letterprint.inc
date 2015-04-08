<?php # prints the letter to the gp

####### edit this file in unix mode

$dob = substr($patient[DateOfBirth],0,2)."\"/\"".substr($patient[DateOfBirth],2,2)."\"/\"".substr($patient[DateOfBirth],4,4);


##write the lout srcipt to letter.txt

$outputFileName = uniqid("letter");
$filehandle = fopen ("/tmp/" . $outputFileName . ".txt","w" );

if (!$filehandle) {	
	error( "not able to write letter", "try again");
	}

$loutstring = "
@SysInclude {doc} 
@SysInclude {tbl} 
@Doc
@Text @Begin

@LP
@LP
@LP

@LP
@LP
@LP

@Tbl rule {no}
aformat { @Cell width {7c} A | @Cell width {8c} margin {.25c} B | @Cell width {5c} ma {0i} mr {0i} C}
{
@Rowa
A { 1.2f @Font @B { Emergency Care Centre (ED\"/\"AAU\"/\"SSU) } @LP ".$institution." @LP ".$institutiondetails." }
B { }
C { @LP @IncludeGraphic \"/var/www/html/notes/logo.eps\" }
}

@LP @LP @LP

".$todayday."\"/\"".$todaymonth."\"/\"".$todayyear."

@LP @LP

Dear ".$arr_request[GPname].",

@LP @LP

@Tbl rule {no} # table with hospital name, logo
aformat { @Cell width {1c} A | @Cell width {4c} B | @Cell width {7c} C }
{
@Rowa
A { }
B { re your patient }
C { 1.2f @Font @B { @I {".$patient[FirstName]."} ".$patient[Surname]." }}
@Rowa
A { }
B { date of birth }
C { 1.2f @Font @B { ".$dob." }}
@Rowa
A { }
B { HN }
C { 1.2f @Font @B { ".$patient[UR]." }}
}
@LP @LP

This patient presented to the Emergency Care Centre today. @LP At triage the problem was stated to be:

".ereg_replace ("&", "\"&\"", ereg_replace ("/","\"/\"",$patient[TriageDiagnosis]))."

@LP @LP

Investigations\"/\" procedures performed included: @LP ".ereg_replace ("&", "\"&\"", ereg_replace ("/","\"/\"",$arr_request[procedures]))."

@LP @LP

The final diagnosis was: 

".ereg_replace ("&", "\"&\"", ereg_replace ("/","\"/\"",$arr_request[diagnosis]))."

@LP @LP

".$arr_request[dischargedto]."

@LP @LP ";

if ($arr_request[followup]){
	$loutstring = $loutstring.$arr_request[followup]."
	@LP @LP ";
	}

if ($arr_request[gpfollowup]){
	$loutstring = $loutstring.$arr_request[gpfollowup].$arr_request[gpreviewdate]."
	@LP @LP ";
	}



if ($arr_request[letterinfo]){
	$loutstring = $loutstring."
	Additional information: ".$arr_request[letterinfo]."

	@LP @LP ";
	}

$loutstring = $loutstring."

".$arr_request[signoff]."

@LP @LP @LP @LP @LP @LP @LP @LP


".$patient[Doctor]."






@LP @LP @LP @LP @LP @LP @LP @LP


0.4f @Font { Letter printed: ".(date("H:i - l F jS, Y"))."  at ". $institution ." Emergency Care Centre   @CopyRight ".(date("Y"))." emerg-med.com} 	@LP 

@End @Text
"; #end of loutstring



fwrite ($filehandle, $loutstring);

fclose($filehandle);


### using perl to process output via lout to postsript, then to lpr doesn't hold up apache

## these work from the command line - prob permission problems

# exec ("perl perl/printletter.pl"); 
#exec ("perl -e 'lout temp/letter.txt >temp/letter.ps'");


# now get lout to translate into postscript file notes.ps

# remove the -PDF switch, and set to notes.ps to print out
#if (!$printer){
#	exec ("lout -PDF temp/letter.txt >temp/letter.pdf");
#	}else{
#	exec ("lout  temp/letter.txt >temp/letter.ps");
#	exec ("lpr.cups -P ".$printer." temp/letter.ps"); 
#	}
	exec ("lout /tmp/" . $outputFileName . ".txt > /tmp/" . $outputFileName . ".ps 2> /tmp/lout.log");
	
	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename="' . $patient[Surname] . $patient[FirstName] . '-letter.pdf"');

	ob_start();
	passthru ("ps2pdf -sPAPERSIZE=a4 /tmp/" . $outputFileName . ".ps -");
	ob_end_flush();

	unlink("/tmp/" . $outputFileName . ".txt");
	unlink("/tmp/" . $outputFileName . ".ps");
	exit();
#### print out a confirmation screen.

include('header.inc'); 
#print $louttext;


print"<BR><BR><BLOCKQUOTE><H3>";
print "<A HREF=\"temp/letter.ps\"><U><FONT COLOR=\"0000FF\">Click</FONT></U></A> to view letter. <BR><BR>Communication is an integral part of the package.<BR><BR>The letter can then be printed out to be signed and posted/ faxed, or can be emailed, using encrypted email.";
print"</H3></BLOCKQUOTE><BR><BR><BR><BR>"; 



print "</BODY></HTML>";
?>