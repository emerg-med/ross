<?php # prints the bill
#phpinfo();
####### edit this file in unix mode

$dob = substr($patient[DateOfBirth],0,2)."\"/\"".substr($patient[DateOfBirth],2,2)."\"/\"".substr($patient[DateOfBirth],4,4);


##write the lout srcipt to letter.txt

$filehandle = fopen ("temp/bill.txt","w" );

if (!$filehandle) {	
	error( "not able to write bill", "try again");
	}

$loutstring = "
@SysInclude {doc} 
@SysInclude {tbl} 
@Doc
@Text @Begin

@LP
@LP
@LP

@Tbl rule {no}
aformat { @Cell width {7c} A | @Cell width {5c} margin {.25c} B }
{
@Rowa
A { 1.2f @Font @B { Emergency Department } @LP ".$institution." @LP ".$institutiondetails." }
B { @LP @LP @IncludeGraphic \"temp/logo.eps\" @LP }
}

@LP @LP @LP

".$todayday."\"/\"".$todaymonth."\"/\"".$todayyear."

@LP @LP

@Display @Heading 2f @Font{Tax Invoice}

@LP @LP

1.2f @Font @B { Invoice for: ".$patient[FirstName]." ".$patient[Surname]." }

@LP @LP

Doctor: ".$patient[Doctor]."

@LP @LP

@Tbl rule {yes}
aformat { @Cell width {2.5c} A | @Cell width {14c} B | @Cell width {2.5c} C}
{
@Rowa
A { 1.2f @Font @B {Item No}}
B { 1.2f @Font @B {Description}}
C { 1.2f @Font @B {Fee}}
";
 

if ($arr_request[FacFee]){
$str_sql = " SELECT Number1 FROM Setup WHERE Name='FacilityFee'";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
$resultar = mysql_fetch_array($result);
if (!$resultar){$facilityfee=0;}else{$facilityfee=$resultar[Number1];}

$total= $total+$facilityfee;
$loutstring = $loutstring."
@Rowa
A { 0.6f @Font {}}
B { 0.6f @Font {Facility Fee}}
C { 0.6f @Font {@Char dollar ".$facilityfee."}}
";
}#end of if
	
for ( $i=0; $i<$arr_request[numprocs]; $i++ ){
	
$item="itemno".$i;
$description="description".$i;
$fee="fee".$i;
$multiplier="multiplier".$i;
$arr_request[$fee]=$arr_request[$fee]*$arr_request[$multiplier];
	$total= $total+$arr_request[$fee];	
$loutstring = $loutstring." 
@Rowa
A {0.6f @Font{ ".$arr_request[$item]."}}
B {0.6f @Font { nohyphen 0.5vx } @Break {".ereg_replace ("/","\"/\"",$arr_request[$description])."}}
C {0.6f @Font{ @Char dollar ".number_format($arr_request[$fee], 2)."}}
";
}#end of for 



$loutstring = $loutstring."


@Rowa
A { 0.6f @Font @B {}}
B { 1f @Font @B {Total}}
C { 1f @Font @B {@Char dollar ".number_format($total, 2)."}}

}

@LP @LP

0.4f @Font { Invoice printed: ".(date("H:i - l F jS, Y"))."  at ". $institution ." Emergency Department   @CopyRight ".(date("Y"))." emerg-med.com}
@LP 
0.4f @Font {This document becomes a tax invoice when stamped 'PAID' using an offical  ".$institution." stamp}
@LP 
0.4f @Font {ABN Number ".$ABNumber." }

@End @Text
"; #end of loutstring



fwrite ($filehandle, $loutstring);

fclose($filehandle);


### using perl to process output via lout to postsript, then to lpr doesn't hold up apache

## these work from the command line - prob permission problems

# exec ("perl perl/printbill.pl"); 
#exec ("perl -e 'lout temp/bill.txt >temp/bill.ps'");


# now get lout to translate into postscript file notes.ps

# remove the -PDF switch, and set to bill.ps to print out

if (!$printer){
	exec ("lout -PDF temp/bill.txt >temp/bill.pdf");
	}else{
	exec ("lout  temp/bill.txt >temp/bill.ps");
	exec ("lpr -P ".$printer." temp/bill.ps"); 
	}
#

#### to send it to the printer from php

# 

#exec ("lpr -P lp0 temp/bill.ps"); 
#### print out a confirmation screen.

include('header.inc'); 
include('navbar.inc'); 
#print $louttext;



print"<BR><BR><BLOCKQUOTE><H3>";
print "<A HREF=\"temp/bill.pdf\"><U><FONT COLOR=\"0000FF\">Click</FONT></U></A> to view bill. Note that graphics e.g. hospital logo are not shown in this instantly generated pdf file, but do appear on the actual bill.<BR><BR>Billing is integrated into the emerg-med.com package.<BR><BR>A well presented professional bill is generated immediately and can be given to the patient, saving clerical time.<BR><BR>The final bill can be interfaced to a hospital billing system.";
print"</H3></BLOCKQUOTE><BR><BR><BR><BR>"; 




print "</BODY></HTML>";
?>