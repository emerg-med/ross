<?php
/*
 * Breadcrumbs, version 1.00
 * This code is copyright (c) Peter Bowyer, and is released 
 * under the GNU general public license. Please leave this 
 * notice intact!
 * This code was originally written for the F2S unofficial 
 * support site <http://www.users.f2s.com>  * 
 * If you modify the code, please let me know.  I am always
 * after improvements! Contact me at <xr256205@europe.com>  * 
 */
$str = $PHP_SELF;
ereg("^(.+)/.+\\..+$", $str, $part);
$str = $part[1];
$str = substr($str, 1);
// Define the names you want given to each of the directories
$label =  array("test"=>"Test",
                "faq"=>"FAQ/Tutorials",
                "phorum"=>"Forums",
                "links"=>"Links",
                "asp2php"=>"ASP2PHP",
                "whatsnew"=>"What's New",
                "us"=>"Useful Stuff");
if (ereg("/", $str)){
$arr = split("/", $str);
$num = count($arr);
echo("<a href=\"http://".$HTTP_HOST."\">Home</a>");
    for($i=0; $i < $num; ++$i){
    echo(" > <a href=\"http://".$HTTP_HOST."/".$arr[$i]."\">".$label[$arr[$i]]."</a>");
    }
}elseif (ereg("[a-zA-Z_]{1,}$",$str)){
$arr = $str;
echo(" > <a href=\"http://".$HTTP_HOST."/".$arr."\">".$label[$arr]."</a>");
}else{
echo("");
}
?>
