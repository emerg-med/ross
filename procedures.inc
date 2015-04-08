<? #note: when changing this file, change letter.php  and 

print "<CENTER><TABLE WIDTH= 98% BORDER=0>"; 
print "<TR><TD COLSPAN = 4 ><H3>Procedures/ Investigations</H3></TD></TR>";
print "<TR><TD VALIGN = TOP><H6><!--			Col 1		 -->";


print "</I><B>Monitoring</B><BR><I>";
$procs = array("I2{continuous monitoring","I3{recording vital signs");

procedureboxes ($procs, $Procedures);

 
 
print "<B>Airway/ Breathing </B><BR>";
print "<I>";
$procs = array( "I4{Oxygen","I5{Nebuliser/ spacer","G3{CPAP/BiPAP","G1{Nasal airway", "G2{Oral airway","G4{ET intubation","L1{General anaesthetic", "J8{Chest drain/aspiration" );
procedureboxes ($procs, $Procedures);


print "</I><B>Circulation</B><BR><I>";
$procs = array("I1{i.v. cannula","I6{i.v. fluids","H1{Blood transfusion","G5{Arterial Line","G6{Central line","K1{Active rewarming", "K2{Active cooling","G7{CPR");
procedureboxes ($procs, $Procedures);


print "</I><B>Radiology</B><BR><I>";
$procs = array("A1{General X-rays","B3{Ultrasound","A9{CT scan","A8{MR scan");
procedureboxes ($procs, $Procedures);


print "</I></H6>";
print "</TD><TD VALIGN=TOP><H6><!--		Col 2		-->";

print "<B>Pathology</B><BR><I>";
$procs = array("A6{Urinalysis","A7{Bacteriology C&S","C2{Pregnancy test", "A5{Biochemistry", "B6{Cardiac Enzymes","B8{Toxicology","A3{Haematology","B4{Clotting","A4{G&S / XM","B9{Blood culture","B7{ABG","J4{Lumbar puncture");
procedureboxes ($procs, $Procedures);


print "<B>Head</B><BR><I>";
$procs = array("J1{Nosebleed","M5{Thrombolysis");
procedureboxes ($procs, $Procedures);


print "</I><B>Heart</B><BR><I>";
$procs = array("A2{ECG","M5{Thrombolysis","G9{External pacing","G8{Defibrillation","J6{Pericardiocentesis");
procedureboxes ($procs, $Procedures);


print "</I><B>Abdomen</B><BR><I>";
$procs = array("J9{Urinary catheter/ suprapubic");
procedureboxes ($procs, $Procedures);



print "</I><BR><BR>";
print "<input type=\"submit\" name = \"action\" value=\"Update\">";
print "<BR></H6>";


print "</I></H6>";
print "</TD><TD VALIGN=TOP><H6><!--		 Col 3		-->";


print "<B>Wounds</B><BR><I>";
$procs = array("D1{Clean","D2{Dress wound/burn/eye", "D6{Steristrips","D7{Glue", "D8{Staples","D3{Primary suture","D4{Secondary/complex suture","J2{Incision and drainage","J3{Removal of FB","D5{Removal of sutures/staples","E1{Tetanus booster","D9{Tetanus Ig");
procedureboxes ($procs, $Procedures);

print "</I><B>Bones</B><BR><I>";
$procs = array( "F1{Plaster of Paris","F2{Removal of plaster","F3{Splint","F4{Manipulation # upper limb","F5{Manipulation # lower limb", "F6{Manipulation dislocation", "J5{Joint Aspiration", "F7{Sling/ CnC", "F8{Bandage/ support", "F9{Crutches/frame/stick"   );
procedureboxes ($procs, $Procedures);


print "</TD><TD VALIGN=TOP><H6><!--		Col 4		 -->";


print "</I><B>Drugs/ Infusions</B><BR><I>";

$procs = array("L6{Medication- oral","M1{Medication- s/l","L9{Medication- p.r.","M2{Medication- nasal","M3{Medication- ear","M4{Medication- topical","L7{Medication i.m.","M6{Medication i.v.","M7{Medication infusion","M8{Medication TTO");
procedureboxes ($procs, $Procedures);



print "</I><B>Anaesthesia</B><BR><I>";
$procs = array(  "L2{Local anaesthetic","L3{regional block/ IVRA" , "L4{Entonox", "L5{Sedation" );
procedureboxes ($procs, $Procedures);




print "</I><B>Miscellaneous</B><BR><I>";
$procs = array("N1{Occupational Therapy","N2{Social Work","O1{Recall/ Review","P1{Advice only - written","P2{Advice only - verbal","C4{Other investigation","C3{No investigations","P3{No treatments");
procedureboxes ($procs, $Procedures);

print "</I></H6></TD></TR></TABLE></CENTER>";




