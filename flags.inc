<?

	print '<CENTER><TABLE width=90%><TR>';
	print '<TD width="20%" valign="top">';
		print '<TABLE>';
		print '<TR><TD colspan=2><H5>Discharge Screen</H5></TD></TR>';
		print '<TR><TD>&nbsp;</TD><TD>&nbsp;<FONT size="0.8em">y</FONT>&nbsp;&nbsp;<FONT size="0.8em">n</FONT></TD></TR>';
		print '<TR><TD><FONT size="0.8em">&gt; 65</FONT></TD><TD>';
		print '<input type="radio" name="FlagsA1" value="Y" ';
		if ($flagsDischargeScreen[0] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '<input type="radio" name="FlagsA1" value="N" ';
		if ($flagsDischargeScreen[0] == 'N') {
			print 'checked ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD><FONT size="0.8em">ADL</FONT></TD><TD>';
		print '<input type="radio" name="FlagsA2" value="Y" ';
		if ($flagsDischargeScreen[1] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '<input type="radio" name="FlagsA2" value="N" ';
		if ($flagsDischargeScreen[1] == 'N') {
			print 'checked ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD><FONT size="0.8em">Lives alone</FONT></TD><TD>';
		print '<input type="radio" name="FlagsA3" value="Y" ';
		if ($flagsDischargeScreen[2] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '<input type="radio" name="FlagsA3" value="N" ';
		if ($flagsDischargeScreen[2] == 'N') {
			print 'checked ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD><FONT size="0.8em">Dependents</FONT></TD><TD>';
		print '<input type="radio" name="FlagsA4" value="Y" ';
		if ($flagsDischargeScreen[3] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '<input type="radio" name="FlagsA4" value="N" ';
		if ($flagsDischargeScreen[3] == 'N') {
			print 'checked ';
		}
		print '>';
		print '</TD></TR>';
		print '</TABLE>';
	print '</TD>';
	print '<TD width="20%" valign="top">';
		print '<TABLE>';
		print '<TR><TD colspan=2><H5>Treatment</H5></TD></TR>';
		print '<TR><TD>&nbsp;</TD><TD>&nbsp;<FONT size="0.8em">y</FONT>&nbsp;&nbsp;<FONT size="0.8em">n</FONT></TD></TR>';
		print '<TR><TD><FONT size="0.8em">MRSA</FONT></TD><TD>';
		print '<input type="radio" name="FlagsB1" value="Y" ';
		if ($flagsTreatment[0] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '<input type="radio" name="FlagsB1" value="N" ';
		if ($flagsTreatment[0] == 'N') {
			print 'checked ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD><FONT size="0.8em">VTE</FONT></TD><TD>';
		print '<input type="radio" name="FlagsB2" value="Y" ';
		if ($flagsTreatment[1] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '<input type="radio" name="FlagsB2" value="N" ';
		if ($flagsTreatment[1] == 'N') {
			print 'checked ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD><FONT size="0.8em">Med Plan</FONT></TD><TD>';
		print '<input type="radio" name="FlagsB3" value="Y" ';
		if ($flagsTreatment[2] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '<input type="radio" name="FlagsB3" value="N" ';
		if ($flagsTreatment[2] == 'N') {
			print 'checked ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD><FONT size="0.8em">Section 2 sent</FONT></TD><TD>';
		print '<input type="radio" name="FlagsB4" value="Y" ';
		if ($flagsTreatment[3] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '<input type="radio" name="FlagsB4" value="N" ';
		if ($flagsTreatment[3] == 'N') {
			print 'checked ';
		}
		print '>';
		print '</TD></TR>';
		print '</TABLE>';
	print '</TD>';
	print '<TD width="20%" valign="top">';
		print '<TABLE>';
		print '<TR><TD colspan=3><H5>Referral</H5></TD></TR>';
		print '<TR><TD>&nbsp;</TD><TD>&nbsp;</TD><TD>&nbsp;<FONT size="0.8em">y</FONT>&nbsp;&nbsp;<FONT size="0.8em">n</FONT></TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsCr" value="Y" ';
		if ($flagsReferral[0] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">No referral</FONT></TD><TD>';
		print '&nbsp;</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsC1r" value=" " ';
		if ($flagsReferral[1] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Physio</FONT></TD><TD>';
		print '<input type="radio" name="FlagsC1" value="Y" ';
		if ($flagsReferral[1] == 'Y') {
			print 'checked ';
		}
		if ($flagsReferral[1] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsC1" value="N" ';
		if ($flagsReferral[1] == 'N') {
			print 'checked ';
		}
		if ($flagsReferral[1] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsC2r" value=" " ';
		if ($flagsReferral[2] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">OT</FONT></TD><TD>';
		print '<input type="radio" name="FlagsC2" value="Y" ';
		if ($flagsReferral[2] == 'Y') {
			print 'checked ';
		}
		if ($flagsReferral[2] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsC2" value="N" ';
		if ($flagsReferral[2] == 'N') {
			print 'checked ';
		}
		if ($flagsReferral[2] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsC3r" value=" " ';
		if ($flagsReferral[3] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Social work</FONT></TD><TD>';
		print '<input type="radio" name="FlagsC3" value="Y" ';
		if ($flagsReferral[3] == 'Y') {
			print 'checked ';
		}
		if ($flagsReferral[3] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsC3" value="N" ';
		if ($flagsReferral[3] == 'N') {
			print 'checked ';
		}
		if ($flagsReferral[3] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsC4r" value=" " ';
		if ($flagsReferral[4] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Mental health</FONT></TD><TD>';
		print '<input type="radio" name="FlagsC4" value="Y" ';
		if ($flagsReferral[4] == 'Y') {
			print 'checked ';
		}
		if ($flagsReferral[4] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsC4" value="N" ';
		if ($flagsReferral[4] == 'N') {
			print 'checked ';
		}
		if ($flagsReferral[4] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsC5r" value=" " ';
		if ($flagsReferral[5] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Other hosp.</FONT></TD><TD>';
		print '<input type="radio" name="FlagsC5" value="Y" ';
		if ($flagsReferral[5] == 'Y') {
			print 'checked ';
		}
		if ($flagsReferral[5] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsC5" value="N" ';
		if ($flagsReferral[5] == 'N') {
			print 'checked ';
		}
		if ($flagsReferral[5] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsC6r" value=" " ';
		if ($flagsReferral[6] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Speciality</FONT></TD><TD>';
		print '<input type="radio" name="FlagsC6" value="Y" ';
		if ($flagsReferral[6] == 'Y') {
			print 'checked ';
		}
		if ($flagsReferral[6] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsC6" value="N" ';
		if ($flagsReferral[6] == 'N') {
			print 'checked ';
		}
		if ($flagsReferral[6] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '</TABLE>';
	print '</TD>';
	print '<TD width="20%" valign="top">';
		print '<TABLE>';
		print '<TR><TD colspan=3><H5>Diagnostics</H5></TD></TR>';
		print '<TR><TD>&nbsp;</TD><TD>&nbsp;</TD><TD>&nbsp;<FONT size="0.8em">y</FONT>&nbsp;&nbsp;<FONT size="0.8em">n</FONT></TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsDr" value="Y" ';
		if ($flagsDiagnostics[0] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">No diagnostics</FONT></TD><TD>';
		print '&nbsp;</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsD1r" value=" " ';
		if ($flagsDiagnostics[1] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Procedure</FONT></TD><TD>';
		print '<input type="radio" name="FlagsD1" value="Y" ';
		if ($flagsDiagnostics[1] == 'Y') {
			print 'checked ';
		}
		if ($flagsDiagnostics[1] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsD1" value="N" ';
		if ($flagsDiagnostics[1] == 'N') {
			print 'checked ';
		}
		if ($flagsDiagnostics[1] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsD2r" value=" " ';
		if ($flagsDiagnostics[2] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Radiology</FONT></TD><TD>';
		print '<input type="radio" name="FlagsD2" value="Y" ';
		if ($flagsDiagnostics[2] == 'Y') {
			print 'checked ';
		}
		if ($flagsDiagnostics[2] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsD2" value="N" ';
		if ($flagsDiagnostics[2] == 'N') {
			print 'checked ';
		}
		if ($flagsDiagnostics[2] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsD3r" value=" " ';
		if ($flagsDiagnostics[3] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Pathology</FONT></TD><TD>';
		print '<input type="radio" name="FlagsD3" value="Y" ';
		if ($flagsDiagnostics[3] == 'Y') {
			print 'checked ';
		}
		if ($flagsDiagnostics[3] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsD3" value="N" ';
		if ($flagsDiagnostics[3] == 'N') {
			print 'checked ';
		}
		if ($flagsDiagnostics[3] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '</TABLE>';
	print '</TD>';
	print '<TD width="20%" valign="top">';
		print '<TABLE>';
		print '<TR><TD colspan=3><H5>Barriers to Discharge</H5></TD></TR>';
		print '<TR><TD>&nbsp;</TD><TD>&nbsp;</TD><TD>&nbsp;<FONT size="0.8em">y</FONT>&nbsp;&nbsp;<FONT size="0.8em">n</FONT></TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsEr" value="Y" ';
		if ($flagsBarriers[0] == 'Y') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">No barrier</FONT></TD><TD>';
		print '&nbsp;</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsE1r" value=" " ';
		if ($flagsBarriers[1] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Relatives</FONT></TD><TD>';
		print '<input type="radio" name="FlagsE1" value="Y" ';
		if ($flagsBarriers[1] == 'Y') {
			print 'checked ';
		}
		if ($flagsBarriers[1] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsE1" value="N" ';
		if ($flagsBarriers[1] == 'N') {
			print 'checked ';
		}
		if ($flagsBarriers[1] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsE2r" value=" " ';
		if ($flagsBarriers[2] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">TTO</FONT></TD><TD>';
		print '<input type="radio" name="FlagsE2" value="Y" ';
		if ($flagsBarriers[2] == 'Y') {
			print 'checked ';
		}
		if ($flagsBarriers[2] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsE2" value="N" ';
		if ($flagsBarriers[2] == 'N') {
			print 'checked ';
		}
		if ($flagsBarriers[2] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsE3r" value=" " ';
		if ($flagsBarriers[3] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Transport</FONT></TD><TD>';
		print '<input type="radio" name="FlagsE3" value="Y" ';
		if ($flagsBarriers[3] == 'Y') {
			print 'checked ';
		}
		if ($flagsBarriers[3] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsE3" value="N" ';
		if ($flagsBarriers[3] == 'N') {
			print 'checked ';
		}
		if ($flagsBarriers[3] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsE4r" value=" " ';
		if ($flagsBarriers[4] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Careplan</FONT></TD><TD>';
		print '<input type="radio" name="FlagsE4" value="Y" ';
		if ($flagsBarriers[4] == 'Y') {
			print 'checked ';
		}
		if ($flagsBarriers[4] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsE4" value="N" ';
		if ($flagsBarriers[4] == 'N') {
			print 'checked ';
		}
		if ($flagsBarriers[4] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsE5r" value=" " ';
		if ($flagsBarriers[5] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">RH/NH</FONT></TD><TD>';
		print '<input type="radio" name="FlagsE5" value="Y" ';
		if ($flagsBarriers[5] == 'Y') {
			print 'checked ';
		}
		if ($flagsBarriers[5] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsE5" value="N" ';
		if ($flagsBarriers[5] == 'N') {
			print 'checked ';
		}
		if ($flagsBarriers[5] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		
		
		print '<TR><TD>';
		print '<input type="checkbox" name="FlagsE6r" value=" " ';
		if ($flagsBarriers[6] != '-') {
			print 'checked ';
		}
		print '>';
		print '</TD><TD><FONT size="0.8em">Section 5 sent</FONT></TD><TD>';
		print '<input type="radio" name="FlagsE6" value="Y" ';
		if ($flagsBarriers[6] == 'Y') {
			print 'checked ';
		}
		if ($flagsBarriers[6] == '-') {
			print 'disabled ';
		}
		print '>';
		print '<input type="radio" name="FlagsE6" value="N" ';
		if ($flagsBarriers[6] == 'N') {
			print 'checked ';
		}
		if ($flagsBarriers[6] == '-') {
			print 'disabled ';
		}
		print '>';
		print '</TD></TR>';
		print '</TABLE>';
	print '</TD>';
	print '</TR></TABLE></CENTER>';

?>