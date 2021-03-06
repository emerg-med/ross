<? #note: when changing this file, change letter.php  

print "<CENTER><TABLE WIDTH= 98% BORDER=0>"; 
print "<TR><TD COLSPAN = 4 ><H3>Procedures/ Investigations</H3></TD></TR>";
print "<TR><TD VALIGN = TOP><H6><!--			Col 1		 -->";

print "<B>Consultation</B><BR><I>";

print "<input type=checkbox name=proceduresar[] value=\"FacFee\" ";
if ($Procedures) {
	if (ereg("FacFee", "$Procedures")){
		print ' checked > ';
		} else print '> '; 
	} else print 'checked > ';

print "Facility fee<BR>";

$procs = array( "00053{5-25 minute","00054{25-45 minute","00057{> 45 minute","00160{1-2hour exclusive","00161{2-3hour exclusive","00162{3-4hour exclusive","00163{4-5hour exclusive","00164{> 5hour exclusive","00104{FACEM initial referred","00105{FACEM f/u referred" );
procedureboxes ($procs, $Procedures);
 
print "</I><B>Airway/ Breathing </B><BR><I>";

$procs = array( "13857{intubation & ventilation","41883{surgical airway","38409{intercostal drain","38403{pleural aspiration","17974{therapeutic anaesthetic","17503{therapeutic anaesthetic (asst)" );
procedureboxes ($procs, $Procedures);

print "</I><B>Circulation</B><BR><I>";
#"11600{pressure-monitoring",
$procs = array("13839{arterial puncture","13842{arterial line insertion","13706{blood administration","13709{collect autologous blood","13815{CVC insertion");

procedureboxes ($procs, $Procedures);

print "</I><B>Head</B><BR><I>";
$procs = array("42644{corneal/scleral FB (x1 only)","41677{packing of nose","41846{direct laryngoscopy","41500{ear FB forceps removal","41659{nose FB removal","39600{lumbar puncture");
procedureboxes ($procs, $Procedures);


print "</I></H6>";

print "</TD><TD VALIGN=TOP><H6><!--		Col 2		-->";

print "<B>Heart</B><BR><I>";
$procs = array("11700{ECG1  tracing and report","ECG2{ECG2 (>1 hr after ECG1)*","13400{cardioversion","13818{Swann-Ganz insertion","38406{pericardiocentesis","38256{temporary pacemaker","38418{thoracotomy");
procedureboxes ($procs, $Procedures);

print "</I><B>Abdomen</B><BR><I>";
$procs = array("32072{sigmoidoscopy","36800{bladder catheterization","37011{suprapubic catheter","37041{bladder needle aspiration","30406{peritoneal lavage/ascitic tap","13506{Sengstaaken tube","14200{gastric lavage","73806{urine pregnancy test (in ED)","16518{emergency labour management");
procedureboxes ($procs, $Procedures);

print "</I><B>Surgical</B><BR><I>";
$procs = array("30023{Debridement deep,dirty wound and suture","30026{body, superficial < 7cm","30038{body, superficial > 7cm","30029{body, deep wound < 7cm","30041{body, deep wound > 7cm","30052{full thickness lac to ear, eyelid, nose or lip","30032{face/neck, superficial, < 7 cm","30045{face/neck, superficial > 7cm","30035{face/neek, deep < 7 cm","30048{face/neck, deep > 7 cm",
"30061{removal of superficial FB","30064{removal subcut FB with LA","30219{incision & drainage","47906{removal of nail","47912{paronychia incision (excl. fu)","47915{toenail wedge resection inc. nailbed");
procedureboxes ($procs, $Procedures);


print "</I></H6>";
print "</TD><TD VALIGN=TOP><H6><!--		 Col 3		-->";



print "</I><B>Plastics/ Burns</B><BR><I>";
$procs = array( "45400{small SSG","45451{full thickness graft","46420{hand, extensor tendon repair","49800{foot, extensor tendon repair","31200{excision tumour/scar (pre-histology)","30003{burns dressing","30006{extensive burns dressing" );
procedureboxes ($procs, $Procedures);

print "</I><B>Local Anaesthesia</B><BR><I>";
$procs = array( "18213{i.v. arm block","18270{femoral nerve block","18258{intercostal block x 1 rib","18260{intercostal nerve blocks >1" );
procedureboxes ($procs, $Procedures);


print "</I><BR><BR>";
print "<input type=\"submit\" name = \"action\" value=\"Update\">";
print "<BR><BR><BR>";

print "<B>Orthopaedics</B><BR><I>";
$procs = array("50124{joint aspiration");
procedureboxes ($procs, $Procedures);

print "</I><B>Dislocations</B><BR><I>";
$procs = array("47000{mandible","47009{shoulder with GA","47015{shoulder with sedation","47018{elbow","47036{finger: IPJ","47042{finger: MCPJ","47030{hand- other","47048{hip","47057{patella","47054{knee","47063{ankle","47069{toe");
procedureboxes ($procs, $Procedures);

print "<BR></H6>";
print "</TD><TD VALIGN=TOP><H6><!--		Col 4		 -->";






print "</I><B>Fractures</B><BR><I>";
$procs = array("47300{distal phalanx UL digit closed red.","47306{distal phalanx UL open red. of compound #","47312{middle phalanx-closed red.","47324{proximal phalanx-closed red.","47336{metacarpal- closed red.","47348{carpus","47354{scaphoid","47360{distal rad/ulna","47363{red. radius/ulna","47372{Colle's red.","47405{radial head","47462{clavicle","47423{proximal humerus","47444{shaft of humerus","47471{ribs","47516{femur -red.","47543{tibial plateau","47561{tibial shaft","47576{fibula","47579{patella","47594{ankle","47597{ankle- closed red.","47606{calcaneus/ talus","47627{tarsus","47633{metatarsal x1","47642{metatarsals >1","47663{big toe red.","47672{other toe red.");
procedureboxes ($procs, $Procedures);


print "</I></H6></TD></TR></TABLE></CENTER>";