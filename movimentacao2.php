<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('movimentacao2.php?page='+ i+ '&registro=<? echo $_REQUEST[registro]; ?>&sde=<? echo $_REQUEST[sde]; ?>&sate=<? echo $_REQUEST[sate]; ?>&rde=<? echo $_REQUEST[rde]; ?>&rate=<? echo $_REQUEST[rate]; ?>');
}}
</script>

</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#f2f2f2">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db2=new conexao();
$db2->conecta();
echo $_SESSION['lnk'];

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

if ($sde == '--')
	$sde= "0000-00-00";
if ($rde == '--')
	$rde= "0000-00-00";
if ($sate == '--')
	$sate= "2099-12-31";
if ($rate == '--')
	$rate= "2099-12-31";
?>
    </div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=8;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  if ($_REQUEST['registro'] <> '') {
		  $sql="SELECT a.movimentacao from movimentacao as a, obra_movimentacao as b, obra as c 
				where (a.data_saida >= '$sde' and a.data_saida <= '$sate') AND (a.retorno_provavel >= '$rde' and a.retorno_provavel <= '$rate') 
				AND (a.movimentacao = b.movimentacao and b.obra = c.obra and c.num_registro = '$_REQUEST[registro]') AND a.data_retorno = 0 
				group by a.movimentacao";
	  } else {
		  $sql="SELECT a.movimentacao from movimentacao as a 
				where (a.data_saida >= '$sde' and a.data_saida <= '$sate') AND (a.retorno_provavel >= '$rde' and a.retorno_provavel <= '$rate') 
				AND a.data_retorno = 0 group by a.movimentacao";
	  }
	  $db->query($sql);
	  $numlinhas=$db->contalinhas();
	 
	  /////////////////////
	  if ($_REQUEST['registro'] <> '') {
		  $sql2="SELECT a.* from movimentacao as a, obra_movimentacao as b, obra as c 
				where (a.data_saida >= '$sde' and a.data_saida <= '$sate') AND (a.retorno_provavel >= '$rde' and a.retorno_provavel <= '$rate') 
				AND (a.movimentacao = b.movimentacao and b.obra = c.obra and c.num_registro = '$_REQUEST[registro]') 
				AND a.data_retorno = 0 group by a.movimentacao	order by a.data_saida desc, a.retorno_provavel LIMIT $registroinicial,$pagesize";
	  } else {
		  $sql2="SELECT a.* from movimentacao as a 
				where (a.data_saida >= '$sde' and a.data_saida <= '$sate') AND (a.retorno_provavel >= '$rde' and a.retorno_provavel <= '$rate') 
				AND a.data_retorno = 0 group by a.movimentacao order by a.data_saida desc, a.retorno_provavel LIMIT $registroinicial,$pagesize";
	  }
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
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
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
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['movimentacao'] ?>">
          <td width="40%" align="justify"><? echo $local ?></td>
          <td width="15%" align="center"><? echo $txtTipo ?></td>
          <td width="15%" align="center"><? echo $dtsaida ?></td>
          <td width="15%" align="center"><? echo $dtretorno ?></td>
          <td width="7%" align="center" >&nbsp;</td>
          <td width="8%" align="center" ><? echo "<a href=\"movimento_registrar.php?movid=".$row['movimentacao']."\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Registrar' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[movimentacao]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[movimentacao]."\").style.backgroundColor=\"\";'>"; }?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td colspan="4">&nbsp;</td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="6" height="20" bgcolor="#ddddd5"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

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
$g= " Total de movimentações encontradas: $numlinhas - Página: $page_atual de $numpages $lista_combo &nbsp;";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="6"></td>
        </tr>
      </table>
    </form>
    &nbsp;<? echo "<a href='movreg_retorno.php'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"?></td>
  </tr>
</table>
</body>
</html>