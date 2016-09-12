<?
function corta_valor($valor)
{
 $valor=substr($valor,0,-1);
 return $valor;
 }
$x='12346789';
$n=corta_valor($x);
echo $n
?>
