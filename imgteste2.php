<? 
$dir="//192.168.0.135/htdocs/donato/imagens/15.png";
unlink($dir);

/*
$s=$_SERVER['HTTP_HOST'];
echo $s;
exit;

$img ="//192.168.0.135/htdocs/donato/imagens/02.gif";
$dim=array_values(getimagesize("$img"));
/*echo $dim[0];
echo "<br>";
echo $dim[1];
echo "<br>";
echo $dim[2];
$tam=filesize($img);
echo $tam;

/*
set_time_limit(0);

$nomearquivo=$_FILES['imagem']['name'];
//$tamanhoarquivo=$_FILES['imagem']['size'];
$extensoes=array(".gif",".jpeg",".jpg");
$ext=strrchr($nomearquivo,'.');
if(!in_array($ext,$extensoes))
{
 echo "<script>alert('Arquivo Inválido')</script>";
 echo "<script>location.href='imgteste.php'</script>";
 
}
else
{
$dir ="//192.168.0.135/htdocs/donato/imagens/";
$uploadfile = $dir.$nomearquivo;
 if(is_dir($dir))
	{
		move_uploaded_file($_FILES['imagem']['tmp_name'], $dir . $nomearquivo);
	}
	echo Taok;
}
	/*
if($imagem!='')
{
$file = $dir1. $_FILES['imagem']['name'];
if (move_uploaded_file($_FILES['imagem']['tmp_name'], $dir1 . $_FILES['imagem']['name'])) {
echo "<script>alert('Ok')</script>";
}}*/

?>