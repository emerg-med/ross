<?php 
require('common.inc');

$loutstring = "
@SysInclude {tbl}
@SysInclude {diag}
@Include {doc-handover}
@Doc
@Text @Begin

@Table @Tbl
aformat { @Cell width { 8.0c } A | @Cell width { 12c } B }
rule { no }
{
@Rowa
A { " . date("H:i - l F jS, Y") . " }
B { Hinchingbrooke SSU }
}
@LP
@Table @Heading 1.5f @Font {CONFIDENTIAL PATIENT INFORMATION }
@LP
@Table @Tbl
aformat { @Cell width { 1.5c } marginvertical { 0.6f } A | @Cell width { 1.5c } marginvertical { 0.6f } B | @Cell width { 1.5c } marginvertical { 0.6f } C | @Cell width { 15.5c } strut { no } D }
rule { yes }
{
@Rowa
A { Bay }
B { Bed }
C { Cons }
D { Patient }";

$location_name = $arr_request['location_name'] . " ";
$str_sql = "select * from Patients order by location";

$result = mysql_db_query($dbname, $str_sql, $id_link);

if (! $result) {affy_error_exit('This patient has been discharged or does not exist.');}

$patient = mysql_fetch_array($result);

while ($patient) {
	if (strpos($patient[Location], $location_name, 0) === 0) {
		$bay_pos = strpos($patient[Location], 'Bay', 0) + 4;
		$bay = substr($patient[Location], $bay_pos, strpos($patient[Location], ',', 0) - $bay_pos);
		$bed_pos = strpos($patient[Location], 'Bed', 0) + 4;
		$bed = substr($patient[Location], $bed_pos, strlen($patient[Location]) - $bed_pos);

		$flags1 = (strpos($patient[FlagsDischargeScreen], '-') === false);
		$flags2 = ($patient[FlagsTreatment] == "YYYY");

		$flags3String = $patient[FlagsReferral];
		$flags3 = ((strpos($flags3String, ' ') !== false) || (strpos($flags3String, 'N') !== false) || (strpos($flags3String, 'Y') === false));

		$flags4String = $patient[FlagsDiagnostics];
		$flags4 = ((strpos($flags4String, ' ') !== false) || (strpos($flags4String, 'N') !== false) || (strpos($flags4String, 'Y') === false));

		$flags5String = $patient[FlagsBarriers];
		$flags5 = ((strpos($flags5String, ' ') !== false) || (strpos($flags5String, 'N') !== false) || (strpos($flags5String, 'Y') === false));

		if (strpos($patient[Location], 'AAU') === 0) {
			$waittime = 1 + floor((5.0 * (time() - $patient[TriageTimeStamp])) / 43201.0);
		} else {
			$waittime_delta =  time() - $patient[TriageTimeStamp];

			if ($waittime_delta > 259200.0) {		# 60*60*24*3 - i.e. 3 days in seconds
				$waittime = 3 + ceil(($waittime_delta - 259200.0) / 172800.0);	# 3 + number of elapsed two-day periods, rounding up
			} else {
				$waittime = ceil($waittime_delta / 86400.0);	# number of elapsed one-day periods, rounding up
			}
		}

		if ($waittime < 1 ){$waittime = 1;} 
		if ($waittime > 6 ){$waittime = 6;}
		
		$consultant = substr($patient[Doctor], 0, 2);
		
		if (strpos($patient[Doctor], ' ')) {
			$consultant = $consultant . substr($patient[Doctor], strpos($patient[Doctor], ' ') + 1, 2);
		}

		$loutstring = $loutstring . "
@Rowa
A { " . $bay . " }
B { " . $bed . " }
C { " . $consultant . " }
D { @Tbl
aformat { @Cell width { 8.05c } margin { 0.0f } A | @Cell width { 8.05c } margin { 0.0f } indent { right } B }
margin { 0.0f }
rule { no }
{
@Rowa
A { " . $patient[FirstName] . " " . $patient[Surname] . " (" . $patient[Age] . " yr old " . $patient[Sex] . ") }
B { @Diag
{
0.75d @Scale -90d @Rotate @Node outline { isosceles } " . ($flags1 ? "paint { black }" : "outlinestyle { dashed }") . " { }
0.75d @Scale -90d @Rotate @Node outline { isosceles } " . ($flags2 ? "paint { black }" : "outlinestyle { dashed }") . " { }
0.75d @Scale -90d @Rotate @Node outline { isosceles } " . ($flags3 ? "outlinestyle { dashed }" : "paint { black }") . " { }
0.75d @Scale -90d @Rotate @Node outline { isosceles } " . ($flags4 ? "outlinestyle { dashed }" : "paint { black }") . " { }
0.75d @Scale -90d @Rotate @Node outline { isosceles } " . ($flags5 ? "outlinestyle { dashed }" : "paint { black }") . " { }
0.75d @Scale @Node outlinestyle { noline } { }
0.75d @Scale @Node outline { circle } " . (($waittime > 0) ? "paint { black }" : "outlinestyle { dashed }") . " { }
0.75d @Scale @Node outline { circle } " . (($waittime > 1) ? "paint { black }" : "outlinestyle { dashed }") . " { }
0.75d @Scale @Node outline { circle } " . (($waittime > 2) ? "paint { black }" : "outlinestyle { dashed }") . " { }
0.75d @Scale @Node outline { circle } " . (($waittime > 3) ? "paint { black }" : "outlinestyle { dashed }") . " { }
0.75d @Scale @Node outline { circle } " . (($waittime > 4) ? "paint { black }" : "outlinestyle { dashed }") . " { }
0.75d @Scale @Node outline { circle } " . (($waittime > 5) ? "paint { black }" : "outlinestyle { dashed }") . " { }
}
}
}
@LP
Triage: " . $patient[TriageDiagnosis] . "
@LP
Current plan: " . $patient[StatusReport] . " }";
	}
	
	$patient = mysql_fetch_array($result);
}

$loutstring = $loutstring."
}
@LP
@End @Text";

$outputFileName = uniqid("handover");
$filehandle = fopen ("/tmp/" . $outputFileName . ".txt","w" );

if (!$filehandle) {	
	error( "not able to write handover sheet", "try again");
	}

	fwrite ($filehandle, $loutstring);

	fclose($filehandle);

	exec ("lout /tmp/" . $outputFileName . ".txt > /tmp/" . $outputFileName . ".ps 2> /tmp/lout.log");

	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename="handover-' . date('d-M-Y') . '.pdf"');
	ob_start();
	passthru ("ps2pdf -sPAPERSIZE=a4 /tmp/" . $outputFileName . ".ps -");
	ob_end_flush();

	# unlink("/tmp/" . $outputFileName . ".txt");
	# unlink("/tmp/" . $outputFileName . ".ps");

	exit();
?>