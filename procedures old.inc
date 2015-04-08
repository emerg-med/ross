<? #note: when changing this file, change letter.php  

print "<CENTER><TABLE WIDTH= 98% BORDER=0>"; 
print "<TR><TD COLSPAN = 4 ><H3>Procedures/ Investigations</H3></TD></TR>";
print "<TR><TD VALIGN = TOP><H6><!--			Col 1		 -->";


 
print "<B>Airway/ Breathing </B><BR>";

print "<I>";

$procs = array( "18{Nebuliser","47{Peak flow/spirometry","48{Pleural aspiration","73{ET intubation","80{CPAP/BiPAP","76{Intercostal catheter","82{CPR","78{Surgical airway" );





foreach ($procs as $procarray){
	$procar = explode( "{" , $procarray);
	print procedurebox ($procar[0], $Procedures);
	print $procar[1]."<BR>";
	}
/*
print procedurebox (18, $Procedures); 
print "Nebuliser<BR>";
print procedurebox (47, $Procedures);
print "Peak flow/spirometry<BR>";
print procedurebox (48, $Procedures);
print "Pleural aspiration<BR>";
print procedurebox (73, $Procedures);
print "ET intubation<BR>";
print procedurebox (80, $Procedures);
print "CPAP/ BiPAP<BR>";
print procedurebox (76, $Procedures);
print "Intercostal catheter<BR>";
print procedurebox (82, $Procedures);
print "CPR<BR>";
print procedurebox (78, $Procedures);
print "Surgical airway<BR> ";

*/
print "</I><B>Circulation</B><BR><I>";

$procs = array( "01{iv cannula","11{iv fluids","12{Blood transfusion","04{arterial line","02{central line","03{intraosseus inf.","05{venous cutdown","","","","","","","","")



$procs = array( "01{iv cannula","11{iv fluids","04{Blood transfusion","","","","","","","","","","","","")


<? procedurebox (04, $Procedures) ?>
Arterial line<BR>
<? procedurebox (02, $Procedures) ?> 
Central line<BR> 
<? procedurebox (03, $Procedures) ?>
Intraosseous inf<BR>
<? procedurebox (05, $Procedures) ?>
Venous cutdown<BR>
</I> 

<B>Drugs/ Infusions</B><BR>

<I>
<? procedurebox (17, $Procedures) ?>
Drug (po/sl/top/pr)<BR> 
<? procedurebox (15, $Procedures) ?>
Injection (sc/im/iv)<BR> 
<? procedurebox (16, $Procedures) ?>
Drug infusion (iv)<BR>

</I>


</H6>

</TD><TD VALIGN=TOP><H6><!--		Col 2		-->

<B>Head</B><BR>

<I>
<? procedurebox (83, $Procedures) ?>
Eye examination<BR>
<? procedurebox (84, $Procedures) ?> 
Neuro obs<BR>
<? procedurebox (28, $Procedures) ?>
Nasal pack<BR>
</I>

<B>Heart</B><BR>

<I>

<? procedurebox (51, $Procedures) ?> 
ECG<BR>
<? procedurebox (52, $Procedures) ?>
ECG monitoring<BR>
<? procedurebox (13, $Procedures) ?>
Thrombolysis<BR> 
<? procedurebox (81, $Procedures) ?>
Cardioversion/defib<BR> 
<? procedurebox (49, $Procedures) ?> 
Pericardiocentesis<BR>

<? procedurebox (50, $Procedures) ?>
Echocardiagram<BR>
</I>



<B>Abdomen</B><BR>

<I>

<? procedurebox (75, $Procedures) ?>
Gastric charcoal<BR>
<? procedurebox (72, $Procedures) ?> 
Nasogastric tube<BR> 
<? procedurebox (77, $Procedures) ?>
Enema<BR>
<? procedurebox (71, $Procedures) ?>
Urinary catheter<BR>
<? procedurebox (58, $Procedures) ?>
Proctosigmoidoscopy<BR> 
<? procedurebox (74, $Procedures) ?>
Gastric lavage<BR>
<? procedurebox (79, $Procedures) ?>
Peritoneal dialysis<BR> 
<? procedurebox (57, $Procedures) ?>
Peritoneal lavage<BR> 
</I>


</H6>
</TD><TD VALIGN=TOP><H6><!--		 Col 3		-->

<B>Pathology</B><BR>

<I>
<? procedurebox (45, $Procedures) ?>
Venepuncture<BR> 
<? procedurebox (46, $Procedures) ?>
Arterial blood<BR> 
<? procedurebox (55, $Procedures) ?>
Blood glucose<BR>
<? procedurebox (53, $Procedures) ?>
Urine ward test<BR>
<? procedurebox (56, $Procedures) ?>
Lumbar puncture<BR>
<? procedurebox (60, $Procedures) ?>
Breath alcohol<BR>
<? procedurebox (54, $Procedures) ?>
Suprapubic aspirate<BR> 
<? procedurebox (59, $Procedures) ?> 
Venom Detection<BR>
</I>

<B>Radiology</B><BR>

<I>
<? procedurebox (41, $Procedures) ?>
General X-rays<BR> 
<? procedurebox (42, $Procedures) ?>
Ultrasound<BR> 
<? procedurebox (43, $Procedures) ?>
CT scan<BR>
<? procedurebox (44, $Procedures) ?> 
Nuclear medicine<BR>

</I>
<BR><BR><BR>
<input type="submit" name = "action" value="Update">
<BR>
</H6>

</TD><TD VALIGN=TOP><H6><!--		Col 4		 -->

<B>Wounds</B><BR>

<I>
<? procedurebox (14, $Procedures) ?>
Tetanus prophylaxis<BR>
<? procedurebox (27, $Procedures) ?>
Suture/steristrip<BR> 
<? procedurebox (31, $Procedures) ?> 
Removal of sutures<BR>
<? procedurebox (29, $Procedures) ?>
Incision & drainage<BR> 
<? procedurebox (21, $Procedures) ?>
Dressing<BR> 
<? procedurebox (32, $Procedures) ?>
Removal of foreign body<BR>
</I>

<B>Local Anaesthesia</B><BR>

<I>
<? procedurebox (25, $Procedures) ?>
nerve block<BR>
<? procedurebox (24, $Procedures) ?>
i.v. nerve block<BR>
</I> 

<B>Bones</B><BR>

<I>
<? procedurebox (22, $Procedures) ?>
Plaster of Paris<BR>
<? procedurebox (30, $Procedures) ?>
Removal of plaster<BR>
<? procedurebox (26, $Procedures) ?>
Reduction of fracture<BR> 
<? procedurebox (23, $Procedures) ?>
Other splint<BR> 
<? procedurebox (85, $Procedures) ?>
Crutches/frame/stick<BR>
</I>

<B>Other/ None</B><BR>

<I>
<? procedurebox (91, $Procedures) ?>
Other (not listed)<BR>
<? procedurebox (99, $Procedures) # note update function clears all others if this set 
?>
None
</I> 
</H6>
</TD></TR>
</TABLE></CENTER>