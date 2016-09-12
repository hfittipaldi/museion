<html>
<head>
</head>
<body>
<?
function getPrinter($SharedPrinterName) {
   global $REMOTE_ADDR;
   $host  =  getHostByAddr($REMOTE_ADDR);
   return "\\\\".$host."\\".$SharedPrinterName;
}

echo getPrinter("Eltron");
$handle  =  printer_open(getPrinter("Eltron"));

?>
</body>
</html>