<?
function loadMenu()
 {
 $db = mysql_connect("localhost","root","visao03");
 mysql_select_db("test",$db);
  $q = mysql_query("SELECT menuID,mName,mLink,parent from tblmenu ORDER BY parent,menuID ASC");
  
  while ($menu = mysql_fetch_array($q)) {

	  // Setting variables 

    $menu[menuID] = "m" . $menu[menuID];

    if($menu[parent] != "") $menu[parent] = "m" . $menu[parent];
	// Make menu

    echo"<script>oCMenu.makeMenu('$menu[menuID]','$menu[parent]','$menu[mName]','$menu[mLink]')\n</script>";
	
	}
	
}

loadMenu();
?>

