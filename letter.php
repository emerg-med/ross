<?php # writes a letter to the gp
require('common.inc');

#phpinfo();

$key_ID  = $arr_request['key_ID'];

$str_sql = "select * from Patients WHERE key_ID = $key_ID ";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) {affy_error_exit('SQL Select Execution has failed 1.');}
$patient=@mysql_fetch_array($result); 

if (!$patient[UR]){$patient[UR]='000000';}

if ($arr_request['action']=='Print'){ 
	include('letterprint.inc');
	exit;
	}
/*
if ($private){
	$procedurearray = array ("13857{intubation & ventilation","41883{surgical airway","38409{intercostal drain","38403{pleural aspiration","17974{therapeutic anaesthetic","13839{arterial puncture","13842{arterial line insertion","13706{blood administration","13709{collect autologous blood","13815{central line insertion","11700{ECG","13400{cardioversion","13818{Swann-Ganz insertion","38406{pericardiocentesis","38256{temporary pacemaker","38418{thoracotomy","42644{removal ofcorneal/scleral FB","41677{packing of nose","41846{direct laryngoscopy","41500{ear FB forceps removal","41659{nose FB removal","39600{lumbar puncture","32072{sigmoidoscopy","36800{bladder catheterization","37011{suprapubic catheter","37041{bladder needle aspiration","30406{peritoneal lavage/ascitic tap","13506{Sengstaaken tube","14200{gastric lavage","73806{urine pregnancy test (in ED)","16518{emergency labour management","18213{i.v. arm block","18270{femoral nerve block","18258{intercostal block x 1 rib","18260{intercostal nerve blocks >1","30023{Debridement deep, dirty wound and suture","30026{care of wound - small, superficial, not face/neck","30038{care of wound - large, superficial, not face/neck","30029{care of wound - small, deep, not face/neck","30041{care of wound - large, deep, not face/neck","30052{care of wound - full thickness lac to ear, eyelid, nose or lip","30032{care of wound - small, superficial, face/neck","30045{care of wound - large, superficial, face/neck","30035{care of wound - small, deep, face/neek","30048{care of wound - large, deep, face/neck","30061{removal of superficial FB","30064{removal subcutaneous FB with LA","30219{incision & drainage","47906{removal of nail","47912{paronychia incision (excl. fu)","47915{toenail wedge resection inc. nailbed","45400{small SSG","45451{full thickness graft","46420{hand, extensor tendon repair","49800{foot, extensor tendon repair","31200{excision tumour/scar (pre-histology)","30003{burns dressing","30006{extensive burns dressing","50124{joint aspiration","47000{reduction of dislocation - mandible","47009{reduction of dislocation - shoulder with GA","47015{reduction of dislocation - shoulder with sedation","47018{reduction of dislocation - elbow","47036{reduction of dislocation - finger: IPJ","47042{reduction of dislocation - finger: MCPJ","47030{reduction of dislocation - hand- other","47048{reduction of dislocation - hip","47057{reduction of dislocation - patella","47054{reduction of dislocation - knee","47063{reduction of dislocation - ankle","47069{reduction of dislocation - toe","47300{management of fracture - distal phalanx UL digit closed reduction","47306{management of fracture - distal phalanx UL open reduction of compound #","47312{management of fracture - middle phalanx-closed reduction","47324{management of fracture - proximal phalanx-closed reduction","47336{management of fracture - metacarpal- closed reduction","47348{management of fracture - carpus","47354{management of fracture - scaphoid","47360{management of fracture - distal radius/ ulna","47363{management of fracture - radius/ ulna","47372{management of fracture - Colle's","47405{management of fracture - radial head","47462{management of fracture - clavicle","47423{management of fracture - proximal humerus","47444{management of fracture - shaft of humerus","47471{management of fracture - ribs","47516{management of fracture - femur","47543{management of fracture - tibial plateau","47561{management of fracture - tibial shaft","47576{management of fracture - fibula","47579{management of fracture - patella","47594{management of fracture - ankle","47597{management of fracture - ankle- closed reduction","47606{management of fracture - calcaneus/ talus","47627{management of fracture - tarsus","47633{management of fracture - metatarsal x1","47642{management of fracture - metatarsals >1","47663{management of fracture - big toe","47672{management of fracture - other toe");
	}
	else{
	$procedurearray = array ("18{Nebuliser","73{ET intubation","80{CPAP/BiPAP","76{Intercostal catheter","82{CPR","78{Surgical airway","01{i.v. cannula","11{i.v. fluids","12{Blood transfusion","04{Arterial Line","02{Central line","03{Intraosseous inf","05{Venous cutdown","17{Drug (po/sl/top/pr)","15{Injection (sc/im/iv)","16{Drug infusion (iv)","83{Eye examination","84{Neuro obs","28{Nasal pack","51{ECG","52{ECG monitoring","13{Thrombolysis","81{Cardioversion/defib","49{Pericardiocentesis","48{Pleural aspiration","47{Peak flow/spirometry","75{Gastric charcoal","72{Nasogastric tube","77{Enema","71{Urinary catheter","58{Proctosigmoidoscopy","74{Gastric lavage","79{Peritoneal dialysis","57{Peritoneal lavage ","45{Venepuncture","46{Arterial blood","55{Blood glucose","53{Urine ward test","56{Lumbar puncture","60{Breath alcohol","54{Suprapubic aspn","59{Venom Detection","41{General X-rays","42{Ultrasound","43{CT scan","44{Nuclear medicine","50{Echocardiagram","14{Tetanus prophylaxis","27{Suture/steristrip ","31{Removal of sutures","29{Incision & drainage","21{Dressing","32{Removal of foreign body","25{nerve block","24{i.v. nerve block","22{Plaster of Paris","30{Removal of plaster","26{Reduction of fracture","23{Other splint","85{Crutches/frame/stick","91{Other (not listed)","99{None");
	}
*/
# UK codes
$procedurearray = array ("I2{continuous monitoring","I3{recording vital signs","I4{Oxygen","I5{Nebuliser/ spacer","G3{CPAP/BiPAP","G1{Nasal airway", "G2{Oral airway","G4{ET intubation","L1{General anaesthetic", "J8{Chest drain/aspiration","I1{i.v. cannula","I6{i.v. fluids","H1{Blood transfusion","G5{Arterial Line","G6{Central line","K1{Active rewarming", "K2{Active cooling","G7{CPR","A6{Urinalysis","A7{Bacteriology C&S","C2{Pregnancy test", "A5{Biochemistry", "B6{Cardiac Enzymes","B8{Toxicology","A3{Haematology","B4{Clotting","A4{G&S / XM","B9{Blood culture","B7{ABG","J4{Lumbar puncture","A1{General X-rays","B3{Ultrasound","A9{CT scan","A8{MR scan","J1{Nosebleed","M5{Thrombolysis","A2{ECG","M5{Thrombolysis","G9{External pacing","G8{Defibrillation","J6{Pericardiocentesis","J9{Urinary catheter/ suprapubic","D1{Clean","D2{Dress wound/burn/eye", "D6{Steristrips","D7{Glue", "D8{Staples","D3{Primary suture","D4{Secondary/complex suture","J2{Incision and drainage","J3{Removal of FB","D5{Removal of sutures/staples","E1{Tetanus booster","D9{Tetanus Ig","F1{Plaster of Paris","F2{Removal of plaster","F3{Splint","F4{Manipulation # upper limb","F5{Manipulation # lower limb", "F6{Manipulation dislocation", "J5{Joint Aspiration", "F7{Sling/ CnC", "F8{Bandage/ support", "F9{Crutches/frame/stick","L6{Medication- oral","M1{Medication- s/l","L9{Medication- p.r.","M2{Medication- nasal","M3{Medication- ear","M4{Medication- topical","L7{Medication i.m.","M6{Medication i.v.","M7{Medication infusion","M8{Medication TTO","L2{Local anaesthetic","L3{regional block/ IVRA" , "L4{Entonox", "L5{Sedation" ,"N1{Occupational Therapy","N2{Social Work","O1{Recall/ Review","P1{Advice only - written","P2{Advice only - verbal","C4{Other investigation","C4{No investigations","P3{No treatments");
	
	
	

include('header.inc'); 
# include('navbar.inc'); 

print "<FORM METHOD=POST ACTION='letter.php'>";

print "<BLOCKQUOTE>";

print "<input type = 'hidden' name = 'key_ID' value = '$key_ID'>";

print "<BLOCKQUOTE>";
print "<BR><BR>";
print "Dear ";

if ($patient[GP]){

	$str_sql = "SELECT GPSurname from GP WHERE Code = '$patient[GP]' ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	$gpar = mysql_fetch_row($result);

	$text= "Dr. ".$gpar[0] ;
	}
	else {$text=  "Doctor";}

print "$text,<BR><BR>";
print "<input type = 'hidden' name = 'GPname' value = '$text'>";


print "re your patient: <B>".$patient[FirstName]." ".$patient[Surname];

print "</B>&nbsp;&nbsp; UR ".$patient[UR];
print "<BR>Date of birth ". substr($patient[DateOfBirth],0,2)."/".substr($patient[DateOfBirth],2,2)."/".substr($patient[DateOfBirth],4,4);
print "&nbsp;&nbsp; Age ".$patient[Age];
print "&nbsp;&nbsp; Sex ".$patient[Sex];

print "<BR><BR>";
print "This patient attended the $institution Emergency Department today.";
print "<BR><BR>";

print "At triage, the problem was stated to be: ";

print $patient[TriageDiagnosis];
print "<BR><BR>";


if ($patient[Procedures]){
	$j=""; $i="";
	print "Investigations/ procedures performed included: ";

	$procedurelist = explode("{",$patient[Procedures]);

	foreach($procedurelist as $procedurekey)
	{
	
		foreach($procedurearray as $proceduredescription){
		
		$i= explode("{",$proceduredescription);
		
		if ($procedurekey == $i[0])
			{$j=$j.$i[1].", ";
			}
		}
	}
	if (!$j){
		print "<BR><TEXTAREA NAME=\"procedures\" ROWS=\"4\" COLS=\"50\"></TEXTAREA><BR><BR>";
		
		}

	else{
		$j = substr_replace($j, "." , -2);
		print $j;
		print "<input type = 'hidden' name = 'procedures' value = '$j'>";
		print "<BR><BR>";
		}
}



if ($patient[Diagnosis1]){
	print "The final diagnosis was: ";


	
	$str_sql = "SELECT Diagnosis from UDDA WHERE UDDAUniqueID = '".$patient[Diagnosis1]."' ";
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
	$diagnosisar = @mysql_fetch_row($result);
	
	if ($patient[Diagnosis1Certainty] == 1) {
		$diagnosisar[0] = $diagnosisar[0] . " (possible)";
	} else if ($patient[Diagnosis1Certainty] == 2) {
		$diagnosisar[0] = $diagnosisar[0] . " (probable)";
	} else if ($patient[Diagnosis1Certainty] == 3) {
		$diagnosisar[0] = $diagnosisar[0] . " (proven)";
	}
	
	print "$diagnosisar[0]";
	print "<input type = 'hidden' name = 'diagnosis' value = '$diagnosisar[0]'>";
	print "<BR><BR>";
}

if ($patient[DischargedStatus]){
	if ($patient[Sex]=='M'){$text= "He ";} else {$text= "She ";}

	switch ($patient[DischargedStatus])
	{
		case "2":
		$text= $text. "was admitted to ";
		if ($patient[AdmitWard]) {$text= $text."the ". $patient[AdmitWard]." ward of ".$institution.".";}
		else {$text= $text. "the ward.";}
		$followup="";
		break;
		
		case "5":
		$text= $text. "took ";
		if ($patient[Sex]=='M'){$text= $text. "his";} else{$text= $text. "her";}
		$text= $text." own discharge against medical advice, having been counselled on the risks of doing this.";
		$followup=1;
		break;

		case "6":
		$text= $text. "left before being seen.";
		$followup="";
		break;

		case "8":
		$text= $text. "was dead on arrival.";
		$followup="";
		break;

		case "7":
		$text= $text. "died in the Emergency Department.";
		$followup="";
		break;

		case "4":
		$str_sql = "SELECT Hospital from Hospitals WHERE Code = '".$patient[TransHosp]."' ";
		$result = mysql_db_query($dbname, $str_sql, $id_link);
		if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
		$transhosp = @mysql_fetch_row($result);

		$text= $text. "was transferred to another hospital: ".$transhosp[0];
		$followup="";
		break;

		case "3":
		$text= $text. "was admitted to the short stay/ observation/ chest pain unit.";
		$followup=1;
		break;

		default:
		$text= $text. "was discharged home.";
		$followup=1;
		
	}
	print $text;
	print "<input type = 'hidden' name = 'dischargedto' value = '$text'>";
	print "<BR><BR>";
}


if ($followup){

	$text= "Follow-up should be ";
	switch ($patient[DischargedTo]){

		case "3":
		$text= $text."through hospital outpatients(inc. fracture clinic).";
		break;

		case "5":
		$text= $text."through private rooms of Dr/ Mr.............................";
		break;

		case "7":
		$text= $text."by the district nurse.";
		break;

		case "1":
		$text= $text."through the Emergency Department. Time......... Date........";
		break;

		case "2":
		$text= $text."through the Emergency Department as necessary.";
		break;

		case "6":
		$text= $text."through a para-medical specialist e.g. Physiotherapy/ Dental.";
		break;

		case "8":
		$text= $text."through community services - e.g. pyschiatric/ detox.";
		break;

		default:
		$text= $text."at your surgery.";
		break;
		}
	print $text;
	print "<input type = 'hidden' name = 'followup' value = '$text'>";
	print "<BR><BR>";



	$text= "I would be grateful if you could review ";

	if ($patient[Sex]=='M'){$text=$text."him ";} else{$text=$text."her ";}
	print $text;
	print "<input type = 'hidden' name = 'gpfollowup' value = '$text'>";
	 
	$i=array ( "if necessary", "tomorrow","in the next few days","next week","in a week's time","in 2 weeks");
	dropdownbox($i, "gpreviewdate", "if necessary");
	print "";
}



print "<BR><BR>";
print"Additional information:<BR><TEXTAREA NAME=\"letterinfo\" ROWS=\"4\" COLS=\"50\"></TEXTAREA>";

print "<BR><BR>";

if ($patient[GP]){
	$text= "Yours sincerely";
	}
	else{
	$text= "Yours faithfully";
	}

print $text;
print "<input type = 'hidden' name = 'signoff' value = '$text'>";

print "<BR><BR><BR><BR><BR>";


print "$patient[Doctor]";
print "<BR><BR><INPUT TYPE=\"submit\" NAME=\"action\" VALUE=\"Print\">";

print "</BLOCKQUOTE></BLOCKQUOTE>";
print "<BR><BR><BR>";
print "</FORM>";


print "</BODY></HTML>";
?>