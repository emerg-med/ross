<?php 
include("../common.inc");

$login = $arr_request['login'];
$username = $arr_request['username'];
$password = $arr_request['password'];

switch($login) {

case "Y":
		  
	// check username and password
	$str_sql = " select *  from User where (Username = '$username' and Password = '$password' and Current = 'Yes') AND (UserType LIKE '_S')";

	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

	$resultar = mysql_fetch_array($result);

	if (!$resultar){# if not superuser, check and see if non superuser with password and username
		
		$str_sql = " select *  from User where (Username = '$username' and Password = '$password' and Current = 'Yes')";

		$result = mysql_db_query($dbname, $str_sql, $id_link);
		if (! $result) { affy_error_exit('SQL Select Execution has failed.');}
		$resultar = mysql_fetch_array($result);

		if (!$resultar){# authentication failed
			error ("No $institution user of that name found","click <A HREF=\"https://$hostname/admin.php?login=n\"><FONT COLOR=\"0000FF\"><U>here</U></FONT></A> to try again");

			}else{#valid non-superuser

			# set time out to 15 minutes from now
			$str_sql = "UPDATE User SET AdminTimeOut='".(time()+900)."',AdminIP='".$REMOTE_ADDR."' WHERE Name = '$resultar[Name]'";
			
			$result = mysql_db_query($dbname, $str_sql, $id_link);
			if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

			include("$path/header.inc"); 
			include('adminnavbar.inc'); 
			
			switch ($resultar[UserType]){

				case 'D-':#Doctor not superuser

				include('admindocstd.inc'); 
				break;

				case 'N-':#Nurse not superuser
			
				include('adminnursstd.inc'); 
				break;

				default:
				error ("No $institution user of that name found","click <A HREF=\"$securepath/admin.php?login=n\"><FONT COLOR=\"0000FF\"><U>here</U></FONT></A> to try again");
				break;
				}
			}

	} else {# valid superuser!

		# set time out to 15 minutes from now
		$str_sql = "UPDATE User SET AdminTimeOut='".(time()+900)."',AdminIP='".$REMOTE_ADDR."' WHERE Name = '$resultar[Name]'";
		
		$result = mysql_db_query($dbname, $str_sql, $id_link);
		if (! $result) { affy_error_exit('SQL Select Execution has failed.');}

		include("$path/header.inc"); 
		include("$securepath/adminnavbar.inc"); 

		switch ($resultar[UserType]){

			case 'CS':#Clerical Superuser

			include('adminclerk.inc'); 
			break;			

			case 'DS':#Doctor Superuser

			include('admindoctor.inc'); 
			break;

			case 'AS':#Administrator
 
			include('adminadmin.inc');
			break;

			case 'NS':#Nurse Superuser
		
			include('adminnurse.inc'); 
			break;

			default:
			error ('no user found');
			break;
			}
		}
	break;

	default:

	# display login form
	include("$path/header.inc"); 
	include('adminnavbar.inc'); 
	include("loginform.inc");
	break;
	}

include("$path/footer.inc"); 
?>