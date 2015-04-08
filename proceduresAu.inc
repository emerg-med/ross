<? #note: when changing this file, change letter.php  

print "<CENTER><TABLE WIDTH= 98% BORDER=0>"; 
print "<TR><TD COLSPAN = 4 ><H3>Procedures/ Investigations</H3></TD></TR>";
print "<TR><TD VALIGN = TOP><H6><!--			Col 1		 -->";


 
print "<B>Airway/ Breathing </B><BR>";

print "<I>";

$procs = array( "18{nebuliser","47{peak flow/spirometry","48{pleural aspiration","73{ET intubation","80{CPAP/BiPAP","76{intercostal catheter","82{CPR","78{surgical airway" );
procedureboxes ($procs, $Procedures);



/*
foreach ($procs as $procarray){
	$procar = explode( "{" , $procarray);
	print procedurebox ($procar[0], $Procedures);
	print $procar[1]."<BR>";
	}
*/

print "</I><B>Circulation</B><BR><I>";

$procs = array("01{i.v. cannula","11{i.v. fluids","12{blood transfusion","04{arterial Line","02{central line ","03{intraosseous inf","05{venous cutdown");

procedureboxes ($procs, $Procedures);

print "</I><B>Drugs/ Infusions</B><BR><I>";

$procs = array("17{drug (po/sl/top/pr)","15{injection (sc/im/iv)","16{drug infusion (iv)");
procedureboxes ($procs, $Procedures);


print "</I></H6>";

print "</TD><TD VALIGN=TOP><H6><!--		Col 2		-->";

print "<B>Head</B><BR><I>";
$procs = array("83{eye examination","84{neuro obs","28{nasal pack");
procedureboxes ($procs, $Procedures);


print "</I><B>Heart</B><BR><I>";
$procs = array("51{ECG","52{ECG monitoring","13{thrombolysis","81{cardioversion/defib","49{pericardiocentesis","50{echocardiagram");
procedureboxes ($procs, $Procedures);


print "</I><B>Abdomen</B><BR><I>";
$procs = array("75{gastric charcoal","72{nasogastric tube","77{enema","71{urinary catheter","58{proctosigmoidoscopy","74{gastric lavage","79{peritoneal dialysis","57{peritoneal lavage ");
procedureboxes ($procs, $Procedures);


print "</I></H6>";
print "</TD><TD VALIGN=TOP><H6><!--		 Col 3		-->";

print "<B>Pathology</B><BR><I>";
$procs = array("45{venepuncture","46{arterial blood","55{blood glucose","53{urine ward test","56{lumbar puncture","60{breath alcohol","54{suprapubic aspn","59{venom Detection");
procedureboxes ($procs, $Procedures);






print "</I><B>Radiology</B><BR><I>";
$procs = array("41{general X-rays","42{ultrasound","43{CT scan","44{nuclear medicine");
procedureboxes ($procs, $Procedures);


print "</I><BR><BR><BR>";
print "<input type=\"submit\" name = \"action\" value=\"Update\">";
print "<BR></H6>";
print "</TD><TD VALIGN=TOP><H6><!--		Col 4		 -->";

print "<B>Wounds</B><BR><I>";
$procs = array("14{tetanus prophylaxis","27{suture/steristrip","31{removal of sutures","29{incision & drainage","21{dressing","32{removal of foreign body");
procedureboxes ($procs, $Procedures);

print "</I><B>Local Anaesthesia</B><BR><I>";
$procs = array( "25{nerve block" , "24{i.v. nerve block" );
procedureboxes ($procs, $Procedures);

print "</I><B>Bones</B><BR><I>";
$procs = array("22{plaster of Paris","30{removal of plaster","26{reduction of fracture","23{other splint","85{crutches/frame/stick");
procedureboxes ($procs, $Procedures);

print "</I><B>Other/ None</B><BR><I>";
$procs = array("91{other (not listed)","99{did nothing");
procedureboxes ($procs, $Procedures);

print "</I></H6></TD></TR></TABLE></CENTER>";