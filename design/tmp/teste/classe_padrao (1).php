<?
include("classe_conexao.php");
$con= new conexao();
$con->conecta();

$sql="select nome from clientes";
$con->Executar($sql);
while($line=$con->MostrarResultados())
{
  echo $line['nome'];
  echo "<br>";
}
$n_lines = $con->ContarLinhas();
if($n_lines>0)
 echo "ok";
else
 echo "naok";
 


?>
