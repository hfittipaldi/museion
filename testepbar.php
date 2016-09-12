<html>
<head>
</head>
<body>
<?
$maindir = "." ;
$mydir = opendir($maindir) ;

// SORT
$directorios = array();
while (false !== ($fn = readdir($mydir)))
{
   if (is_dir($fn) && $fn != "." && $fn != "..") 
   {
       $directory = getcwd()."/$fn";
       $key = date("Y\-m\-d\-His ", filectime($directory));
       $directorios[$key] = $directory;
   }
}

ksort($directorios);
$cronosdir = array();
$cronosdir = array_reverse($directorios);

while (list($key, $directory) = each($cronosdir)) {
   echo "$key = $directory<bR>";
}
echo "<br><br>";
foreach ($cronosdir as $arq) {
  echo "$arq<br>";
}
?>
</body>
</html>