<?
//*********************************************//
//Monta o encadeamento de links da arvore de menus.
function montalinks()
{
global $db;
global $link;	
$path=$_SERVER['PHP_SELF'];
$arq=basename($path);
$extensao=$arq;
$sql="select posicao,nome from menu_item where chamada = '".trim($extensao)."'";
$db->query($sql);
$res=$db->dados();
$valor=$res[0];
$lnkini=$res[1];//$lnkini="link inicial"

do
{
 $sql="select posicao,nome from menu_item where item='$valor'";
 $db->query($sql);
 $res=$db->dados();
 $nome[]=$res[1];
 $valor=$res[0];
 }
while($valor<>0); 

$tot=count($nome);
while($tot>=0)
{ 
 $i=$tot;
 $lnk.=$nome[$i];
 $lnk.="&nbsp;/&nbsp;";
 $i--;
 $tot--;
 }
$l=$lnk.$lnkini;
$link=substr($l,7); //para cortar a / inicial 
echo $link;
}
//*********************************************//
////////////////////////////////////////////////////////////
//Nao esquecer de setar sempre com a tabela de parâmetros //
///////////////////////////////////////////////////////////
function nome_instituicao()
{
  global $db;
  $sql="select a.nome from museu as a where a.museu in (select valor from parametro where parametro = 'LOCAL_INSTAL')";
  //$sql="select a.nome from museu as a where a.museu='15'";
  $db->query($sql);
  $row=$db->dados();
  $nome=$row[0]; 
  return $nome;
}
///////////////////////////////////////////////////
function diretorio_fisico()
{
  global $db;
  $sql="SELECT valor from parametro where parametro='DIR_FOTOGRAFIA'";
  $db->query($sql);
  $row=$db->dados();
  return $row[0];
}
function diretorio_fisico_rotacao()
{
  global $db;
  $sql="SELECT valor from parametro where parametro='DIR_ROTACAO'";
  $db->query($sql);
  $row=$db->dados();
  return $row[0];
}
function diretorio_virtual()
{
  global $db;
  $sql="SELECT valor from parametro where parametro='URL_FOTOGRAFIA'";
  $db->query($sql);
  $row=$db->dados();
  return $row[0];
}
function diretorio_donato()
{
  global $db;
  $sql="SELECT valor from parametro where parametro='DIR_ROTACAO'";
  $db->query($sql);
  $row=$db->dados();
  return $row[0];
}
function raiz_imagem()
{
  global $db;
  $sql="SELECT valor from parametro where parametro='RAIZ_IMAGEM'";
  $db->query($sql);
  $row=$db->dados();
  return $row[0];
}
//////////////////////////////////////////////////
function paginacao_imagem()
{
  global $db;
  $sql="SELECT valor from parametro where parametro='IMG_PAGINACAO'";
  $db->query($sql);
  $row=$db->dados();
  return $row[0];
}
//////////////////////////////////////////////////
function liberacao_automatica()
{
  global $db;
  $sql="SELECT valor from parametro where parametro='STATUS_INICIAL_OBRA'";
  $db->query($sql);
  $row=$db->dados();
  return $row[0];
}
//////////////////////////////////////////////////
function login_visitante()
{
  global $db;
  $sql="SELECT valor from parametro where parametro='LOGIN_VISITANTE'";
  $db->query($sql);
  $row=$db->dados();
  return $row[0];
}
//*********************************************//
//Funcoes pra formatar/desformatar valor
function desformatar($valor)
{
 $valor=str_replace(".", "", $valor);
 $valor=str_replace(",", "", $valor);
 return $valor;
}
//Converte:Ex:215 ->2.1.5
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
//*********************************************//
////////Funcao pra cortar valor da string////
function corta_valor($valor)
{
 $valor=substr($valor,0,-1);
 return $valor;
}
//*********************************************//
///Funcao q verifica se o usuario colocou zero no inicio do campo item
 function ver_item($valor){ 
   global $item;
   $valor=$item{0};
    if($valor==0)
      { 
        echo"<script>alert('Erro!O item de menu não pode ser iniciado com ZERO.')</script>";
 	    echo"<script>history.back(-1)</script>";
		exit;}
     else{
   return $valor;
}} 
//*********************************************//
//Funcao pra verificar a existencia/nao do item inputado.
function avalia_sql($item)
{
 global $posicao;	
 global $ordem;
 global $db; 
 $in=desformatar($_REQUEST['in']); // variavel pra obter valor $res[item] de menus1.php
$tam_item=strlen($item);

 if($tam_item >1)
 { 
    $new=$item{0};
	$sql="SELECT item from menu_item as a where a.item like'$new%' ";
	$db->query($sql);
    $conta=$db->contalinhas();
  //////////////////////////////////
    if($conta >0)
	 { 
	    $sql="SELECT item from  menu_item as a where a.item='$item'";
		$db->query($sql);
        $conta2=$db->contalinhas();
			if($conta2 >0)
			{
			   if($in==$item){
				 return $item;
				 exit(); }
			  if($in<>$item){
			  echo"<script>alert('Erro!Item:".formata($item)." já se encontra cadastrado.')</script>";
              echo"<script>window.history.go(-1)</script>";
              exit();
			  }
			  }
           elseif($conta2==0)
				{
                    return $item;
	                exit();
				}
				 
	     }
    
	////////////////////////////
    elseif($conta==0)
	{
      echo"<script>alert('Erro! Cadastrou um item-filho sem ter pelo menos um item-pai.')</script>";
      echo"<script>window.history.go(-1)</script>";
      exit();
	}
 exit();
 }
 
elseif($tam_item==1)
{
  $sql="SELECT item from menu_item as a where a.item='$item'";
   $db->query($sql);
      $conta=$db->contalinhas();
         if($conta>0)
		 {
          echo"<script>alert('Erro!Menu principal já se encontra cadastrado.')</script>";
          echo"<script>window.history.go(-1)</script>";
          exit(); 
		  }
        if($conta==0)
		 {  
           return $item;
		}
 }
}
/************************************************/
//Funcao para trocar % por espaço nas buscas q levam string%
//Principalmente no cadastro de autor.
function troca_percent($valor)
{
  echo str_replace('%','&nbsp',$valor);
} 
//*********************************************//
///////////////Funcao para trocar , por . em valores numericos
function formata_valor($valor)
{
  $valor=str_replace(",",".",$valor);
  return $valor;
 }
///////////////
//*********************************************/
///////////////Funcao para trocar , por . em valores numericos
function formata_valor_1($valor)
{
  if ($valor<> "" ){
    $valor=str_replace(".","",$valor);
    $valor=str_replace(",",".",$valor);
  }  
  return $valor;
 }

function formata_valor_2($valor)
{
  if ($valor<> "" ){
     $valor=str_replace(".","",$valor);
     $valor=str_replace(",",".",$valor);
 
  } else {
    $valor=0;
  }  
  return $valor;
 }


function formata_valor_3($valor)
{
   if ($valor==0.00) {
      $valor="";
   } else {
      $valor=number_format($valor,2,',','.');
   }
   // Valida se decimal="00" e se verdadeiro, mostra só a parte inteira - (PBL - 25/02/2009)
   $teste=split(",",$valor,2);
   if ($teste[1]=="00") {
	$valor=$teste[0];
       }else{
       $posvirgula=$teste[1];
       $num=substr($posvirgula,-2, 1);
       $zero=substr($posvirgula, -1); 
       if ($zero=='0'){
          $valor=$teste[0].",".$num; } 
       if ($valor==","){
          $valor="";
        }
    }

   return $valor;
}
///////////////
//*********************************************/
function convertedata($old_date, $layout) 
{ 
$old_date = ereg_replace('[^0-9]', '', $old_date); 

$_year = substr($old_date,0,4); 
$_month = substr($old_date,4,2); 
$_day = substr($old_date,6,2); 
$_hour = substr($old_date,8,2); 
$_minute = substr($old_date,10,2); 
$_second = substr($old_date,12,2); 

$new_date = date($layout, mktime($_hour, $_minute, $_second, $_month, $_day, $_year)); 
return $new_date; 
} 

//*********************************************//
function seta_data($data) {
 if (($data != '') and ($data != '00/00/0000')) { 
   if ((substr($data, 1, 1) == '/')OR(substr($data, 1, 1) == '-')) { 
   		$dia = substr($data, 0, 1); 
   } else { 
		$dia = substr($data, 0, 2); 
   }   
   if ((substr($data, 3, 1) == '/')OR(substr($data, 3, 1) == '-')) { 
    	$mes = substr($data, 4, 1); $ano = substr($data, 4, 4); 
   } else { 
		$mes = substr($data, 3, 2); $ano = substr($data, 6, 4); 
   }
   return $ano.'-'.$mes.'-'.$dia;
   //return date( "Y-m-d", mktime( 0, 0, 0, $mes , $dia, $ano));
 } else { return ''; }
}
////////////////////////////////////////////////
function formata_data($data,$formato="") {
 if ($data != '0000-00-00') { 
    // DD/MM/AAAA Formato Padrão
    $ano = substr($data, 0, 4);
    $mes = substr($data, 5, 2);
    $dia = substr($data, 8, 2);
    if (($formato=='')AND($ano!='')){ return $dia.'/'.$mes.'/'.$ano; }
 } else {return '';}	
}
///////////////////////////////////////////
// explode uma data formatando no padrao do mysql (Y-m-d)
function explode_data($valor)
{
 $val=explode('/',$valor);
 return $val[2].'-'.$val[1].'-'.$val[0];

}
//////////////////////////////////////////////

// Recebe arquivo com diretório virtual e trata espaços e acentuação
function combarra_encode ($path) {
 return implode("/", array_map("rawurlencode", explode("/", $path)));
}
//////////////////////////////////////////////

// Converte valor interno de data para valor externo
/*function dtformato_externo($di, $df, $tp, &$dd, &$mm, &$aaaa1, &$aaaa2) {
	$dtini= explode('-',$di);
	$dd= $dtini[2];
	if ($dd == '00')
		$dd= '';
	$mm= $dtini[1];
	if ($mm == '00')
		$mm= '';
	$aaaa1= $dtini[0];
	if ($aaaa1 == '0000')
		$aaaa1= '';

	$dtfim= explode('-',$df);
	$aaaa2= $dtfim[0];
	if ($aaaa2 == $aaaa1)
		$aaaa2= '';
	if ($aaaa2 == '0000')
		$aaaa2= '';

	// Este return é alternativo (para o caso de exibir a data inicial em um só campo)
	$dia= $dd;
	if ($dia == '')
		$dia= '00';
	$mes= $mm;
	if ($mes == '')
		$mes= '00';
	$ano= $aaaa1;
	if ($ano == '')
		$ano= '0000';
	return $dia."/".$mes."/".$ano;
}*/

// Converte valor externo de data para valor interno
/*function dtformato_interno($dd, $mm, $aaaa1, $aaaa2, $tp, &$dtinicial, &$dtfinal) {
	$dia= $dd;
	if ($dia=='' || $dia==0)
		$dia= '00';
	$mes= $mm;
	if ($mes=='' || $mes==0)
		$mes= '00';
	$ano= $aaaa1;
	if ($ano=='' || $ano==0)
		$ano= '0000';
	if ($aaaa2=='' || $aaaa2==0)
		$aaaa2= $ano;
	if ($aaaa2<>'' && $ano=='0000')
		$ano= $aaaa2;
	$dtinicial= $ano."-".$mes."-".$dia;

 	if ($mes == '00')
	  $mes= '12';
	if ($dia == '00') {
		switch ($mes) { 
	       case 1: $dia= '31'; break; 
    	   case 2: $dia= '28'; break; 
	       case 3: $dia= '31'; break; 
    	   case 4: $dia= '30'; break; 
	       case 5: $dia= '31'; break; 
    	   case 6: $dia= '30'; break; 
	       case 7: $dia= '31'; break; 
    	   case 8: $dia= '31'; break; 
	       case 9: $dia= '30'; break; 
    	   case 10: $dia= '31'; break; 
	       case 11: $dia= '30'; break; 
    	   case 12: $dia= '31'; break; 
	   }
	}
	if ($aaaa2=='0000' && $ano=='0000') {
		$dia= '00';
		$mes= '00';
	}
	$dtfinal= $aaaa2."-".$mes."-".$dia;
}*/

?>