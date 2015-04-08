<?php

$medicaresuffixlist = array ('C-U{Card unavailable','N-E{Not eligible for Medicare','P-N{Prisoner','BAB{Un-named baby');


$visitlist = array ("1{Emergency presentation","2{Return visit - planned","3{Unplanned re-attendance","4{Outpatient clinic","5{Privately referred and treated","8{Pre-arranged admission","9{Patient in transit","10{Dead on arrival");

$compenslist = array ("6{Medicare/ Overseas eligible","1{Transport Accident Commission","2{Department of Veterans Affairs","3{WorkCover","4{Common Law/ Service","5{Ineligible not compensable","7{Compensable status unknown");

$indiglist = array ("2{Not indigenous","5{Indigenous - Aborig, NOT Torres SI","6{Indigenous - Torres SI, NOT Aborig","7{Indigenous - Aborig AND Torres SI");


#$currindiclist = array ("B{Acute & GPS MR","A{Acute MR only","C{Cas card only","G{GPS MR only","X{No medical record");

#$histindiclist = array ("D{Destroyed","P{Optdisk & Current MR","O{Optdisk only");

$maritallist = array ("M{Married","S{Single","F{Defacto","W{Widowed","D{Divorced","P{Seperated","U{Unknown");

### get list of clerical staff

$str_sql = "SELECT Name FROM User WHERE UserType LIKE '%C%' AND Current = 'Yes' ORDER BY Name";

$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');} else{}

$clericallist = array ();
$dummy=0;
while ($dummy1 =  mysql_fetch_array($result)){
	$clericallist[$dummy] = $dummy1[Name];
	$dummy++;
	}

### get list of insurers

$str_sql = "SELECT Insurance FROM Private ORDER BY Insurance";
$result = mysql_db_query($dbname, $str_sql, $id_link);
if (! $result) { affy_error_exit('SQL Select Execution has failed.');} 

$privlist = array ("none","other");
$dummy=2;
while ($dummy1 =  mysql_fetch_array($result)){
	$privlist[$dummy] = $dummy1[Insurance];
	$dummy++;
	}


$religeonlist = array ("E{Anglican","A{Athiest","B{Baptist","D{Buddist","R{Catholic","F{Christian Fellowship","C{Church Of Christ","G{Congregational","O{Greek Orthodox","H{Hindu","W{Jehovah's Witness","J{Jewish","Y{Latter Day Saints","L{Lutheran","M{Methodist","X{Moslem","V{Pentecostal","P{Presbyterian","S{Salvation Army","T{Seventh Day Adventist","U{Unitarian","F{Uniting Church","N{None","K{Not Stated/ Unknown","Z{Other");

$languagelist = array ("19{English","0{Afrikaans","1{Albanian","2{Alyawarr (Alyawarra)","3{Arabic (including Lebanese)","4{Armenian","5{Arrernte (Aranda)","6{Assyrian (including Aramaic)","7{Australian Indigenous, NEC","8{Bengali","9{Bisaya","10{Bosnian","11{Bulgarian","12{Burarra","13{Burmese","14{Cantonese","15{Cebuano","16{Croatian","17{Czech","18{Danish","20{Estonian","21{Fijian","22{Finnish","23{French","24{German","25{Gilbertese","26{Greek","27{Gujarati","28{Hakka","29{Hebrew","30{Hindi","31{Hmong","32{Hokkien","33{Hungarian","34{Indonesian","35{Irish","36{Italian","37{Japanese","38{Kannada","39{Khmer","40{Korean","41{Kriol","42{Kuurinji (Gurindji)","43{Lao","44{Latvian","45{Lithuanian","46{Macedonian","47{Malay","48{Maltese","49{Mandarin","50{Mauritian Creole","51{Netherlandic","52{Norwegian","53{Persian","54{Pintupi","55{Pitjantjatjara","56{Polish","57{Portuguese","58{Punjabi","59{Romanian","60{Russian","61{Samoan","62{Serbian","63{Sinhalese","64{Slovak","65{Slovene","66{Somali","67{Spanish","68{Swahili","69{Swedish","70{Tagalog (Filipino)","71{Tamil","72{Telugu","73{Teochew","74{Thai","75{Timorese","76{Tiwi","77{Tongan","78{Turkish","79{Ukranian","80{Urdu","81{Vietnamese","82{Walmajarri (Walmadjari)","83{Warlpiri","84{Welsh","85{Wik-Mungkan","86{Yiddish","95{Other languages, nfd","96{Inadequately described","97{Non verbal, inc. Sign Languages","98{Not stated");

$referredbylist = array ("1{Self, family, friends","2{GP","3{Outpatients","4{Private Specialist","5{ED review from this hospital","7{Nursing Home","8{Prison/ custodial care","9{Psychiaric Service (eg CAT)","10{Other communtity services","11{Hospital in the home service","12{Inpatient ward in this hosp","19{Other","6{Transfer from another hospital");

$dobyearlist = array ();
for ( $n=0; $n<120; $n++) {
	$dobyearlist[]= $todayyear-$n;
	}









?>