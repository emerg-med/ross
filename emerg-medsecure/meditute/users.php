<?php 
include('/home/httpd/html/common.inc');

include('checkvalid.inc');

include('/home/httpd/html/header.inc'); 

$admintype = $arr_request['login'];

switch ($admintype) {

	case (strstr($admintype, "n") !=""):
	$useradmin = "Nursing";
	$optionlist = array ('N-{Nurse - Triage','NS{Nurse - Administrator');
	$sqlsearchstring = "%N%";


	break;

	case (strstr($admintype, "d") !=""):
	$useradmin = "Medical";	
	$optionlist = array ('D-{Doctor','DS{Doctor - Administrator');
	$sqlsearchstring = "%D%";


	break;	

	case (strstr($admintype, "a") !=""):
	$useradmin = "System";
	$optionlist = array ( 'N-{Nurse - Triage','NS{Nurse - Administrator','D-{Doctor','DS{Doctor - Administrator','AS{System Administrator','C-{Clerk','CS{Clerk - Administrator' );
	$sqlsearchstring = "%";

	break;	

	case (strstr($admintype, "c") !=""):
	$useradmin = "Clerical";
	$optionlist = array ( 'C-{Clerk','CS{Clerk - Administrator' );
	$sqlsearchstring = "%C%";

	break;	

	default:
	print "</BODY></HTML>";
	exit;
	break;
}




$action = cleanup($arr_request['action']);

if ($action == "update"){
	
	$key_ID = cleanup($arr_request['key_ID']);
	$Name = cleanup($arr_request['Name']);
	$Email = cleanup($arr_request['Email']);
	$Username = cleanup($arr_request['Username']);
	$UserType = cleanup($arr_request['UserType']);
	$Password = cleanup($arr_request['Password']);
	$Current = cleanup($arr_request['Current']);


	$str_sql = "UPDATE User SET Name = '$Name',Email = '$Email',Username = '$Username',Password = '$Password', Current = '$Current', UserType = '$UserType'  WHERE key_ID= '$key_ID'";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}

}

elseif ($action == "addnew"){

	$Name = cleanup($arr_request['Name']);
	$Email = cleanup($arr_request['Email']);
	$Username = cleanup($arr_request['Username']);
	$Password = cleanup($arr_request['Password']);
	$UserType = cleanup($arr_request['UserType']);
	$Current = cleanup($arr_request['Current']);

	$str_sql = "INSERT INTO User  (Name, Email, Username, Password, Current, UserType) VALUES ('$Name', '$Email','$Username','$Password','Yes','$UserType') ";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}

}

else {}



############### get all users for this administrator

$str_sql = "SELECT * FROM User WHERE UserType LIKE '$sqlsearchstring' ORDER BY Current DESC, UserType, Name";


$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}



############## Display table

print"<CENTER><TABLE width 98% cellspacing=5 cellpadding = 5 border=0 >";

print "<TR><TD colspan=7 width=100%>";

print "<BR><CENTER><H1>$useradmin&nbsp;user&nbsp;administration&nbsp;menu</H1></CENTER><BR>";

print "</TD></TR>";

print "<TR><TD colspan=7 width=100%><HR><HR>";
print "<H3>Insert new user</H3>";
print "</TD></TR>";

print "<TR><TD>";## headings

print "<H5>Name</H5>";
print "</TD><TD>";
print "<H5>Type</H5>";
print "</TD><TD>";
print "<H5>Current</H5>";
print "</TD><TD>";
print "<H5>Username</H5>";
print "</TD><TD>";
print "<H5>Password</H5>";
print "</TD><TD>";
print "<H5>e-mail</H5>";
print "</TD><TD>";
print "";
print "</TD></TR>";

	print "<FORM action=\"users.php\" method=\"post\"><TR><TD>";

	print "<INPUT TYPE=\"hidden\" Name = \"key_ID\" Value = \"$user[key_ID]\">";
	print "<INPUT TYPE=\"hidden\" Name = \"user\" Value = \"$arr_request[user]\">";

	print "<INPUT TYPE = 'HIDDEN' NAME = 'login' VALUE = '$admintype'>";

	print "<INPUT TYPE = 'HIDDEN' NAME = 'action' VALUE = 'addnew'>";

	print "<INPUT TYPE = 'TEXT' NAME= 'Name'  SIZE= '20'>";
	print "</TD><TD>";
	codedropdownbox ($optionlist, "UserType", "");
	print "</TD><TD>Yes";

	print "</TD><TD>";
	print "<INPUT TYPE = 'TEXT' NAME= 'Username'  SIZE= '10'>";

	print "</TD><TD>";
	print "<INPUT TYPE = 'TEXT' NAME= 'Password'  SIZE= '10'>";
	print "</TD><TD>";
	print "<INPUT TYPE = 'TEXT' NAME= 'Email'  SIZE= '20'>";
	print "</TD><TD>";
	print "<INPUT TYPE=\"submit\" value = \"Add\" >";
	print "</TD></TR></FORM>";

print "<TR><TD colspan=7 width=100%>";
print "<HR><HR>";
print "</TD></TR>";

print "<TR><TD>";## headings

print "<H5>Name</H5>";
print "</TD><TD>";
print "<H5>Type</H5>";
print "</TD><TD>";
print "<H5>Current</H5>";
print "</TD><TD>";
print "<H5>Username</H5>";
print "</TD><TD>";
print "<H5>Password</H5>";
print "</TD><TD>";
print "<H5>e-mail</H5>";
print "</TD><TD>";
print "<H5>Update</H5>";
print "</TD></TR>";

while ($user = mysql_fetch_array($result)){ #one row for each user

	print "<FORM action=\"users.php\" method=\"post\"><TR><TD>";

	print "<INPUT TYPE = 'HIDDEN' NAME = 'login' VALUE = '$admintype'>";
	print "<INPUT TYPE=\"hidden\" Name = \"key_ID\" Value = \"$user[key_ID]\">";
	print "<INPUT TYPE=\"hidden\" Name = \"user\" Value = \"$arr_request[user]\">";
	print "<INPUT TYPE = 'TEXT' NAME= 'Name' VALUE= '$user[Name]' SIZE= '20'>";
	print "</TD><TD>";
	codedropdownbox ($optionlist, "UserType", $user[UserType]);
	print "</TD><TD>";
	dropdownbox ($yesnolist, "Current", $user['Current'] );
	print "</TD><TD>";
	print "<INPUT TYPE = 'TEXT' NAME= 'Username' VALUE= '$user[Username]' SIZE= '10'>";

	print "</TD><TD>";
	print "<INPUT TYPE = 'TEXT' NAME= 'Password' VALUE= '$user[Password]' SIZE= '10'>";
	print "</TD><TD>";
	print "<INPUT TYPE = 'TEXT' NAME= 'Email' VALUE= '$user[Email]' SIZE= '20'>";
	print "</TD><TD>";
	print "<INPUT TYPE = 'HIDDEN' NAME = 'action' VALUE = 'update'>";

	print "<INPUT TYPE=\"submit\" value = \"update\" >";
	print "</TD></TR></FORM>";

}



print "<TR><TD>";
print " ";
print "</TD><TD>";
print " ";
print "</TD></TR>";




print"</TABLE></CENTER>"; 

print "</BODY></HTML>"; 
?>