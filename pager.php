<?php 
require('common.inc');
include('header.inc'); 

#phpinfo();
if ($arr_request[message]){

$pageremail = 'TomH@bhs.grampianshealth.org.au';

#"TomH","kelsey"
$mailbox = @imap_open("{mail.bhs.grampianshealth.org.au:143}inbox", "tomh","kelsey");
if (!$mailbox){
		print "<script language=\"JavaScript\">
		alert(\"Connection to Paging System not working\");
		window.close();
		</script>";
		exit;
		}

#$boxes=imap_getmailboxes($mailbox, "{mail.bhs.grampianshealth.org:25}", "*");

# mail("nobody@aol.com", "the subject", $message, "From: webmaster@$SERVER_NAME\nReply-To: webmaster@$SERVER_NAME\nX-Mailer: PHP/" . phpversion());

#print $pageremail. $arr_request[pager].$arr_request[message];

	if (imap_mail($pageremail, $arr_request[pager], $arr_request[message],"From: tomh@bhs.grampianshealth.org.au" )){
		print "<script language=\"JavaScript\">
		alert(\"Message Sent $mailbox\");
		</script>";#		window.close();

	}else{
		print "<script language=\"JavaScript\">
		alert(\"Message NOT sent, there is a problem with the message system\");
		</script>";
	}

print imap_last_error(). "<BR><BR><BR>";

for ($i=141; $i<160; $i++){
$header = imap_header($mailbox,$i);
print "$header->date . <BR>\n";
print "$i . <BR>\n";
print "$header->subject . <BR>\n";

}


imap_close($mailbox);
}




print"<CENTER><TABLE cellpadding=1 cellspacing=1 WIDTH =98% border=0><TR><TD><!-- main table -->";

print"<FORM action=pager.php method=\"post\">";

print"Name: ".$arr_request[name].'<BR><BR>';

print"Pager: ".$arr_request[pager].'<BR><BR>';

print "<INPUT TYPE=HIDDEN NAME=pager VALUE=$arr_request[pager]>";

print"Message: ";

print"<INPUT TYPE='text' name='message' size='25'><BR><BR>";

print "<INPUT TYPE='submit' value='Send Message'>";

print"</TD></TR></TABLE></CENTER><!-- Finish Main Table -->";



 
print"</BODY></HTML>";
?>