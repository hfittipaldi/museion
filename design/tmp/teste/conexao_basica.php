 <?
 $host='192.168.0.135';
 $user='root';
 $dbname='bd_donato';
 $psw='visao03';
 $con=mysql_connect($host,$user,$psw) or die('Erro na conexao');
 mysql_select_db($dbname,$con);
 ?>
