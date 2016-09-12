<?
////////Arquivo de Funcoes -Donato

function desformatar($valor)
{
 $valor=str_replace(".", "", $valor);
 $valor=str_replace(",", "", $valor);
 return $valor;
}
/////
//Converte:Ex:215 ->2.1.5
////
function formata($valor)
{
$c="";
for($i=0;$i<strlen($valor);$i++)
{
 $c.="$valor[$i]";
if($i<strlen($valor)-1)
  {
  $c.= "." ;
  }
}
return $c;
}
///////
///Funcao pra cortar valor da string
function corta_valor($valor)
{
 $valor=substr($valor,0,-1);
 return $valor;
}
?>
