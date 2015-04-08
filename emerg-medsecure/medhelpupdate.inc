<?php
### updates the medhelp database


# PHPINFO(); ## for debugging

### get the pictures, put them into the database

$picsql="";

for ($i = 1; $i<17; $i++){  

	$picarray = $HTTP_POST_FILES["Pic".$i];

	$picfile= $picarray[tmp_name];

	if ($picarray[name] && $picarray[size]<500000){ ### limits pictures to 500kb 

		$fd = fopen($picfile, "r");

		$pic = addslashes(fread($fd, $picarray[size]));

		fclose($fd);
		
		$picsql=$picsql."Pic".$i."= '".$pic."',";

	}
	}



	
	$Title=cleanup($arr_request[Title]); 
	$Important=cleanup($arr_request[Important]);


	$Keywords=cleanup($arr_request[Keywords]);
	$Department=cleanup($arr_request[Department]);
	$Creator=cleanup($arr_request[Creator]);		
	$AddressIP=cleanup($arr_request[AddressIP]);
	$AddressName=cleanup($arr_request[AddressName]);

	$AuthorisedBy=cleanup($arr_request[AuthorisedBy]);
	if ($AuthorisedBy){
	$picsql=$picsql."UpdatedTimestamp = '".time()."', ";
	}
	$MedHelpType=cleanup($arr_request[MedHelpType]);

for ($i = 1; $i<16; $i++){  
	
	$dummy = "Title".$i."Main";
	$$dummy=cleanup($arr_request["Title".$i."Main"]);
	$dummy = "Title".$i."Side";
	$$dummy=cleanup($arr_request["Title".$i."Side"]);
	$dummy = "Para".$i;
	$$dummy=bigcleanup($arr_request["Para".$i]);
	$dummy = "Ref".$i;
	$$dummy=cleanup($arr_request["Ref".$i]);
	$dummy = "Ref".$i."URL";
	$$dummy=cleanup($arr_request["Ref".$i."URL"]);

	}



	$str_sql = "UPDATE MedHelp SET 
	Title='$Title', 
	Important='$Important',
	Keywords='$Keywords',
	Department='$Department',
	Creator='$Creator',		
	AddressIP='$AddressIP',
	AddressName='$AddressName',
	AuthorisedBy='$AuthorisedBy',
	MedHelpType='$MedHelpType',

	Title1Main='$Title1Main',
	Title1Side='$Title1Side',
	Para1='$Para1',
	Ref1='$Ref1',
	Ref1URL='$Ref1URL',

	".$picsql."

	Title2Main='$Title2Main',
	Title2Side='$Title2Side',
	Para2='$Para2',
	Ref2='$Ref2',
	Ref2URL='$Ref2URL',

	Title3Main='$Title3Main',
	Title3Side='$Title3Side',
	Para3='$Para3',
	Ref3='$Ref3',
	Ref3URL='$Ref3URL',

	Title4Main='$Title4Main',
	Title4Side='$Title4Side',
	Para4='$Para4',
	Ref4='$Ref4',
	Ref4URL='$Ref4URL',

	Title5Main='$Title5Main',
	Title5Side='$Title5Side',
	Para5='$Para5',
	Ref5='$Ref5',
	Ref5URL='$Ref5URL',

	Title6Main='$Title6Main',
	Title6Side='$Title6Side',
	Para6='$Para6',
	Ref6='$Ref6',
	Ref6URL='$Ref6URL',

	Title7Main='$Title7Main',
	Title7Side='$Title7Side',
	Para7='$Para7',
	Ref7='$Ref7',
	Ref7URL='$Ref7URL',

	Title8Main='$Title8Main',
	Title8Side='$Title8Side',
	Para8='$Para8',
	Ref8='$Ref8',
	Ref8URL='$Ref8URL',

	Title9Main='$Title9Main',
	Title9Side='$Title9Side',
	Para9='$Para9',
	Ref9='$Ref9',
	Ref9URL='$Ref9URL',

	Title10Main='$Title10Main',
	Title10Side='$Title10Side',
	Para10='$Para10',
	Ref10='$Ref10',
	Ref10URL='$Ref10URL',

	Title11Main='$Title11Main',
	Title11Side='$Title11Side',
	Para11='$Para11',
	Ref11='$Ref11',
	Ref11URL='$Ref11URL',

	Title12Main='$Title12Main',
	Title12Side='$Title12Side',
	Para12='$Para12',
	Ref12='$Ref12',
	Ref12URL='$Ref12URL',

	Title13Main='$Title13Main',
	Title13Side='$Title13Side',
	Para13='$Para13',
	Ref13='$Ref13',
	Ref13URL='$Ref13URL',

	Title14Main='$Title14Main',
	Title14Side='$Title14Side',
	Para14='$Para14',
	Ref14='$Ref14',
	Ref14URL='$Ref14URL',

	Title15Main='$Title15Main',
	Title15Side='$Title15Side',
	Para15='$Para15',
	Ref15='$Ref15',
	Ref15URL='$Ref15URL'

	WHERE key_ID = '".$arr_request[key_ID]."'";
	
	$result = mysql_db_query($dbname, $str_sql, $id_link);
	if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}

?>