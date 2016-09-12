<? include_once("seguranca.php") ?>
<html>
<head>
<title>Pesquisa de Movimentação</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('movimentacao3.php?page='+ i+ '&registro=<? echo $_REQUEST[registro]; ?>&sde=<? echo $_REQUEST[sde]; ?>&sate=<? echo $_REQUEST[sate]; ?>&rde=<? echo $_REQUEST[rde]; ?>&rate=<? echo $_REQUEST[rate]; ?>&retde=<? echo $_REQUEST[retde]; ?>&retate=<? echo $_REQUEST[retate]; ?>&local=<? echo $_REQUEST[local]; ?>&nome=<? echo $_REQUEST[nome]; ?>&prazo=<? echo $_REQUEST[prazo]; ?>&prevde=<? echo $_REQUEST[prevde]; ?>&prevate=<? echo $_REQUEST[prevate]; ?>&ausente=<? echo $_REQUEST[ausente]; ?>');
}}

function posiciona(valor) {
var i = valor;
document.location=('movimentacao3.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}

</script>

</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db2=new conexao();
$db2->conecta();
if ($_REQUEST[pagesize] < 999) {
echo $_SESSION['lnk'];
}

$sde= explode("/", $_REQUEST['sde']);
$dia=$sde[0]; $mes=$sde[1]; $ano=$sde[2];
$sde= $ano."-".$mes."-".$dia;
$sate= explode("/", $_REQUEST['sate']);
$dia=$sate[0]; $mes=$sate[1]; $ano=$sate[2];
$sate= $ano."-".$mes."-".$dia;
$rde= explode("/", $_REQUEST['rde']);
$dia=$rde[0]; $mes=$rde[1]; $ano=$rde[2];
$rde= $ano."-".$mes."-".$dia;
$rate= explode("/", $_REQUEST['rate']);
$dia=$rate[0]; $mes=$rate[1]; $ano=$rate[2];
$rate= $ano."-".$mes."-".$dia;
$prevde= explode("/", $_REQUEST['prevde']);
$dia=$prevde[0]; $mes=$prevde[1]; $ano=$prevde[2];
$prevde= $ano."-".$mes."-".$dia;
$prevate= explode("/", $_REQUEST['prevate']);
$dia=$prevate[0]; $mes=$prevate[1]; $ano=$prevate[2];
$prevate= $ano."-".$mes."-".$dia;

if ($sde == '--')
	$sde= "0000-00-00";
if ($rde == '--')
	$rde= "0000-00-00";
if ($prevde == '--')
	$prevde= "0000-00-00";
if ($sate == '--')
	$sate= "2099-12-31";
if ($rate == '--')
	$rate= "2099-12-31";
if ($prevate == '--')
	$prevate= "2099-12-31";

$retde= explode("/", $_REQUEST['retde']);
$dia=$retde[0]; $mes=$retde[1]; $ano=$retde[2];
$retde= $ano."-".$mes."-".$dia;
$retate= explode("/", $_REQUEST['retate']);
$dia=$retate[0]; $mes=$retate[1]; $ano=$retate[2];
$retate= $ano."-".$mes."-".$dia;

if ($retde == '--')
	$retde= "0000-00-00";
if ($retate == '--')
	$retate= "2099-12-31";
?>
    </div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=8;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;

	  $addprazo= "";
	  $addausente= "";
	  if ($_REQUEST['prazo'] == 'marcou')
		$addprazo= "AND (a.retorno_provavel < now() and a.retorno_provavel <> 0 and a.data_retorno = 0) ";
	  elseif ($_REQUEST['ausente'] == 'marcou')
		$addausente= "AND (a.data_saida < now() and a.data_saida <> 0 and a.data_retorno = 0) ";

	  $addsaida= "";
	  if ($_REQUEST['sde']<>'' || $_REQUEST['sate']<>'')
		$addsaida= "AND (b.data_saida >= '$sde' and b.data_saida <= '$sate' and b.data_saida > 0) ";

	  $addretorno= "";
	  if ($_REQUEST['retde']<>'' || $_REQUEST['retate']<>'')
		$addretorno= "AND (b.data_retorno >= '$retde' and b.data_retorno <= '$retate' and b.data_retorno > 0) ";

	  if ($_REQUEST['registro'] <> '') {
		  $sql="SELECT a.* from movimentacao as a, obra_movimentacao as b, obra as c 
				where (a.data_saida >= '$prevde' and a.data_saida <= '$prevate') AND (a.retorno_provavel >= '$rde' and a.retorno_provavel <= '$rate') $addsaida $addretorno $addprazo $addausente
				AND (a.movimentacao = b.movimentacao and b.obra = c.obra and c.num_registro = '$_REQUEST[registro]') 
				group by a.movimentacao order by a.data_saida desc, a.retorno_provavel";
	  } else {
		  $sql="SELECT a.* from movimentacao as a, obra_movimentacao as b 
				where (a.data_saida >= '$prevde' and a.data_saida <= '$prevate') AND (a.retorno_provavel >= '$rde' and a.retorno_provavel <= '$rate') $addsaida $addretorno $addprazo $addausente
				AND (a.movimentacao = b.movimentacao) 
				group by a.movimentacao order by a.data_saida desc, a.retorno_provavel";
	  }
	  $db->query($sql);
	  $numlinhas=$db->contalinhas();
	//////////
	  $ids_movimentacao= '';
	  while ($row=$db->dados()) {
			if ($_REQUEST[nome] <> '') {
				if ($row['tipo_mov']=='EI' || $row['tipo_mov']=='EE') {
					$sql= "SELECT count(*) as tot from exposicao as a, movimentacao_exposicao as b where a.exposicao = b.exposicao AND a.nome like '%$_REQUEST[nome]%' AND b.movimentacao = '$row[movimentacao]'";
					$db2->query($sql);
					$local= $db2->dados();
					$local= $local['tot'];
					if ($local == 0) {
						$numlinhas--;
						continue;
					}
				}
				else {
					$numlinhas--;
					continue;
				}
			}

			if ($_REQUEST[local] <> '') {
				if ($row['tipo_mov']=='EI' || $row['tipo_mov']=='LI') {
					if ($row['tipo_mov']=='LI' && $row['local_int_legado']<>'')
						$sql= "SELECT count(*) as tot from movimentacao where local_int_legado like '%$_REQUEST[local]%' AND movimentacao = '$row[movimentacao]'";
					else
						$sql= "SELECT count(*) as tot from local as a, movimentacao as b where a.local=b.local_destino AND a.nome like '%$_REQUEST[local]%' AND b.movimentacao = '$row[movimentacao]'";
					$db2->query($sql);
					$local= $db2->dados();
					$local= $local['tot'];
					if ($local == 0) {
						$numlinhas--;
						continue;
					}
				}
				elseif ($row['tipo_mov'] == 'EE') {
					$sql= "SELECT count(*) as tot from exposicao as a, movimentacao_exposicao as b where a.exposicao = b.exposicao AND a.instituicao like '%$_REQUEST[local]%' AND b.movimentacao = '$row[movimentacao]'";
					$db2->query($sql);
					$local= $db2->dados();
					$local= $local['tot'];
					if ($local == 0) {
						$numlinhas--;
						continue;
					}
				}
				elseif ($row['tipo_mov'] == 'LE') {
					$sql= "SELECT count(*) as tot from movimentacao where local_externo like '%$_REQUEST[local]%' AND movimentacao = '$row[movimentacao]'";
					$db2->query($sql);
					$local= $db2->dados();
					$local= $local['tot'];
					if ($local == 0) {
						$numlinhas--;
						continue;
					}
				}
			}
			$ids_movimentacao= $ids_movimentacao . "," . $row['movimentacao'];
	   }
	   $ids_movimentacao= substr($ids_movimentacao,1);
	   if ($ids_movimentacao == '')
			$ids_movimentacao= 0;
	  /////////////////////
	  $sql2="SELECT a.* from movimentacao as a where a.movimentacao in ($ids_movimentacao)
			group by a.movimentacao	order by a.data_saida desc, a.retorno_provavel LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="6" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td height="24" width="40%" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;Local</div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Tipo</div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Saída prev.</div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Ret. prov.</div></td>
          <td width="7%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="8%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados()) {
			$local="";
			if ($row['tipo_mov']=='EI' || $row['tipo_mov']=='LI') {
				if ($row['tipo_mov']=='LI' && $row['local_int_legado']<>'') {
					$txtTipo= '<font style="color:navy;">Interna</font>';
					$local= $row['local_int_legado'];
				} else {
					$txtTipo= '<font style="color:navy;">Interna</font>';
					$sql= "SELECT nome from local where local = '$row[local_destino]'";
					$db2->query($sql);
					$local= $db2->dados();
					$local= $local['nome'];
				}
			}
			elseif ($row['tipo_mov'] == 'EE') {
				$txtTipo= '<font style="color:maroon;">Externa</font>';
				$sql= "SELECT a.instituicao from exposicao as a, movimentacao_exposicao as b where a.exposicao = b.exposicao AND b.movimentacao = '$row[movimentacao]'";
				$db2->query($sql);
				$local= $db2->dados();
				$local= $local['instituicao'];
			}
			elseif ($row['tipo_mov'] == 'LE') {
				$txtTipo= '<font style="color:maroon;">Externa</font>';
				$local= $row['local_externo'];
			}

			if (strlen($local) > 50)
				$local= substr($local,0,50)."...";

			$dtsaida= explode("-", $row['data_saida']);
			$dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
			$dtsaida= $dia."/".$mes."/".$ano;
			$dtretorno= explode("-", $row['retorno_provavel']);
			$dia=$dtretorno[2]; $mes=$dtretorno[1]; $ano=$dtretorno[0];
			$dtretorno= $dia."/".$mes."/".$ano;

			$dtretorno2= explode("-", $row['data_retorno']);
			$dia=$dtretorno2[2]; $mes=$dtretorno2[1]; $ano=$dtretorno2[0];
			$dtretorno2= $dia."/".$mes."/".$ano;
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['movimentacao'] ?>">
          <td width="40%" align="justify"><? echo $local ?></td>
          <td width="15%" align="center"><? echo $txtTipo ?></td>
          <td width="15%" align="center"><? echo $dtsaida ?></td>
          <td width="15%" align="center"><? echo $dtretorno ?></td>
          <td width="7%" align="center" ><? if ($row['data_retorno'] <> 0) { echo "<img src='imgs/icons/ic_ok.gif' width='20' height='20' 
	border='0' title='Movimentação concluída em ".$dtretorno2."'>"; } else { echo "&nbsp;"; } ?>
            <div align="center"></div></td>
          <td width="8%" align="center" ><? if ($_REQUEST[pagesize] < 999) echo "<a href=\"movimento_consultar.php?movid=".$row['movimentacao']."\">
	 <img src='imgs/icons/relat.gif' width='20' height='20'border='0' alt='Informações' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[movimentacao]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[movimentacao]."\").style.backgroundColor=\"\";'>"; }?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"movimentacao3.php?pagesize=999999&page=1&registro=$_REQUEST[registro]&sde=$_REQUEST[sde]&sate=$_REQUEST[sate]&rde=$_REQUEST[rde]&rate=$_REQUEST[rate]&retde=$_REQUEST[retde]&retate=$_REQUEST[retate]&local=$_REQUEST[local]&nome=$_REQUEST[nome]&prazo=$_REQUEST[prazo]&prevde=$_REQUEST[prevde]&prevate=$_REQUEST[prevate]&ausente=$_REQUEST[ausente]\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto"  bgcolor="#ddddd5">
          <td colspan="6" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"movimentacao3.php?page=".$first."&titulo=".$_REQUEST[titulo]."&vinculo=".$_REQUEST[vinculo]."&funcao=".$_REQUEST[funcao]."&cor=".$_REQUEST[cor]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"movimentacao3?page=".$menos."&titulo=".$_REQUEST[titulo]."&vinculo=".$_REQUEST[vinculo]."&funcao=".$_REQUEST[funcao]."&cor=".$_REQUEST[cor]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"movimentacao3?page=".$mais."&titulo=".$_REQUEST[titulo]."&vinculo=".$_REQUEST[vinculo]."&funcao=".$_REQUEST[funcao]."&cor=".$_REQUEST[cor]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"movimentacao3?page=".$last."&titulo=".$_REQUEST[titulo]."&vinculo=".$_REQUEST[vinculo]."&funcao=".$_REQUEST[funcao]."&cor=".$_REQUEST[cor]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";

$combo="";

 for($i=1;$i<=$numpages;$i++)
 {
  if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 }
  $lista_combo="<select name=i value=$i onChange='obtem_valor(this)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }
$txtpagina= "";
if ($_REQUEST[pagesize] < 999) {
	$txtpagina= "- Página: $page_atual de $numpages $lista_combo &nbsp;";
}
$g= " Total de movimentações encontradas: $numlinhas ".$txtpagina;
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            </td>
          </tr>
        <tr>
          <td height="2" colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="6"></td>
        </tr>
      </table>
    </form>
    &nbsp;<? if ($_REQUEST[pagesize] < 999) echo "<a href='movpre_consulta.php'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"?></td>
  </tr>
</table>
<script language="JavaScript">

document.onkeyup=handleKeyboardAction;

function handleKeyboardAction(e){

   var code;

  // Obtém o evento. No caso do Firefox, este
  // evento é passado como argumento, e no caso do IE,
  // deve ser obtido através do objeto window.
   if (!e) var e = window.event; 

   // Detecta o target da tecla
   var targ;
   if (e.target) targ = e.target;
   else if (e.srcElement) targ = e.srcElement;

   // Este código previne um erro do navegador Safari:
  // Se o usuari clica num DIV com texto, os outros browsers
  // retornam o DIV como sendo o target. Safari retorna  o nó contendo
  // o texto (nodeType 3). Nesse caso, o target que nos interessa é o pai.
   if (targ.nodeType == 3) // defeat Safari bug
      targ = targ.parentNode;

  // Obtém o nome da TAG HTML do target do evento
   tag = targ.tagName.toUpperCase();

  // Verifica se o evento não esta sendo acionado em nenhum
  // campo como campo de texto e combobox.
  // Esta verificação é importante, pois o handler pode bloquear
  // o funcionamento adqueado desses campos (por exemplo, em vez de escrever
  // a letra no campo, executa uma função).
   if (tag == "INPUT")
      return;

   if (tag == "SELECT")
		return;

   // Detecta o codigo da tecla
   if (e.keyCode) code = e.keyCode;
   else if (e.which) code = e.which;

   var character = String.fromCharCode(code);

       //Home
	if(code == 36) {
          posiciona('<? echo $first; ?>');
          return;
	} 

       //End
	if(code == 35) {
          posiciona('<? echo $last; ?>');
          return;
	} 


       //PgDw
	if(code == 34) {
          posiciona('<? echo $mais; ?>');
          return;
	} 

	//PgUp
	if(code == 33) {
          posiciona('<? echo $menos; ?>');
          return;
	} 

   return;
}

</script>
</body>
</html>