<?
 $host='192.168.0.135';
 $user='root';
 $dbname='donato';
 $psw='visao03';
 $con=mysql_connect($host,$user,$psw) or die('Erro na conexao');
 mysql_select_db($dbname,$con);

$de=$_REQUEST['campo1'];
$para=$_REQUEST['campo2'];
if($de==$para)
{
  echo"Erro!Nao se pode copiar acessos identicos";
}
else
{
 $sql="DELETE from usuario_menu_item where usuario='$para'";
 mysql_query($sql,$con);
 $sql2= "SELECT t1.item FROM usuario_menu_item AS t1 where t1.usuario = 
'$de'";
 $res=mysql_query($sql2,$con);
 while($row=mysql_fetch_array($res))
 {
   $sql3="INSERT INTO usuario_menu_item(usuario,item) 
values('$para','$row[0]')";
   mysql_query($sql3,$con);
 }
}
 ?>

