<?

set_time_limit(0);
$foto=$_REQUEST['foto'];
$nomedir='eu';
$nomedir1 = strtolower($nomedir);
$dir ="//192.168.0.135/htdocs/donato/imagens/";
$dir1 = $dir."$nomedir1/";
 if(!is_dir($dir1))
	{
		mkdir($dir1);
		chmod($dir1,0777);
		// mkdir($dir1,7777);
	}
if($foto!='')
{
  copy($foto,$dir1."$foto_name");
}
echo "<script>alert('Subiu')</script>";
?>