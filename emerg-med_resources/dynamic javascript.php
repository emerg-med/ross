Refer comments to the "PX: PHP Code Exchange" at http://www.sklar.com/px/  <HTML>
<HEAD>
</HEAD>
<BODY>
<?
        /***************************************************************/
        /*Code: PHP 3                                                  */
        /*Author: Leon Atkinson <leon@clearink.com>                    */
        /*Creates two form fields based on data from a database        */
        /*Writes javascript that update field 2 based on field 1       */
        /***************************************************************/

        /* To simulate database connectivity, I'll fill some arrays    */
        $store_id = array("1","3","4","5","6");
        $store_state = array("California","California","California","Nevada","Utah");
        $store_city = array("Los Angeles", "San Francisco", "Walnut Creek", "Las Vegas", "Salt Lake City");
        $numStores = 5;
        $distinct_states = array("California","Nevada","Utah");
        
        /* create the javascript function the updates the city list */
        echo "<SCRIPT Language=\"JavaScript\">\n";

        echo "function UpdateCity()\n";
        echo "{\n";
        
        /* clear the city selector */
        echo "\tvar City = document.choose_store.city.options.length;\n";
        echo "\twhile(City > 0)\n";
        echo "\t{\n";
        echo "\t\tCity--;\n";
        echo "\t\tdocument.choose_store.city.options[City].text = '';\n";
        echo "\t\tdocument.choose_store.city.options[City].value = '';\n";
        echo "\t}\n\n";
        echo "\tdocument.choose_store.city.options[0].selected = true;\n\n";

        /* figure out which state is selected*/
        echo "\tvar StateSelected = 0;\n";
        echo "\twhile(document.choose_store.state.options[StateSelected].selected==false) StateSelected++;\n\n";

        $StoreState = "";
        $CityCount = 0;
        
        /* If this weren't a demo, I'd run a query something like: */
        /* select * from store order by State                      */
        /* But since this is a demo, I'll just read from an array  */
        $RowCount = 0;
        while($RowCount < $numStores)
        {
                $store_ID = $store_id[$RowCount];
                $store_State = $store_state[$RowCount];
                $store_City = $store_city[$RowCount];
                
                if($StoreState != $store_State)
                {
                        if($StoreState != "")
                        {
                                echo "\t}\n";
                        }
                                                        
                        echo "\tif(document.choose_store.state.options[StateSelected].value == '$store_State')\n";
                        echo "\t{\n";

                        echo "\t\tdocument.choose_store.city.options[0].value = 0;\n";
                        echo "\t\tdocument.choose_store.city.options[0].text = 'Choose a Store Location';\n\n";
                         
                        $StoreState = $store_State;
                        $CityCount=1;
                }
                
                echo "\t\tdocument.choose_store.city.options[$CityCount].value = '$store_ID';\n";
                echo "\t\tdocument.choose_store.city.options[$CityCount].text = '$store_City';\n\n";
                $CityCount++;
                $RowCount++;
        }

        echo "\t}\n";

        echo "}\n";


        echo "</SCRIPT>\n\n";

        echo "<CENTER><FORM NAME=choose_store>";

        echo "<SELECT NAME=state onChange=\"UpdateCity();\">\n";
        /* This is another place I'd put a query:                    */
        /* select distinct State from store order by State           */
        echo "<OPTION VALUE=0>Choose a State";
        $RowCount = 0;
        while($RowCount < count($distinct_states))
        {
                echo "<OPTION VALUE=\"";
                echo $distinct_states[$RowCount];
                echo "\">";
                echo $distinct_states[$RowCount];
                echo "\n";
                $RowCount++;
        }
        
        echo "</SELECT>\n";

        /* Now we need to know how many cities are listed for the state with the most stores */
        /* select count(*) as items from store group by State order by items desc */
        $MaxItems = 3;
        echo "<SELECT NAME=city width=30>\n";
        $RowCount = 0;
        while($RowCount <= $MaxItems)
        {
                echo "<OPTION VALUE=$RowCount>";
                echo "Choose a Store Location\n";
                $RowCount++;
        }               
        echo "</SELECT><BR><BR>\n";

        echo "</FORM></CENTER>";
        
        echo "<SCRIPT Language=\"JavaScript\">UpdateCity();</SCRIPT>\n";

?>

<BR>
<BR>
<CENTER>
Check out 
<A HREF="http://www.restorationhardware.com/secondary.htmy?id=location">www.RestorationHardware.com</A>
to see this code used to take to a real database.
</CENTER>
</BODY>
</HTML> BACKGROUND="red.gif"