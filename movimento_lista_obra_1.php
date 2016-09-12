<? //include_once("seguranca.php") ?>
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
document.location=('movimento_lista_obra.php?obrid=<? echo $_REQUEST[obrid] ?>&page='+ i);

}}
</script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
	$db2=new conexao();
	$db2->conecta();
 ?>
<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
 <?
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	 $sql="SELECT count(*) as total from obra_movimentacao where obra='$_REQUEST[obrid]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.data_saida as saida_obra,a.data_retorno as retorno_obra,b.* from obra_movimentacao as a inner join movimentacao as b on(a.movimentacao=b.movimentacao) 
	   		where a.obra='$_REQUEST[obrid]' order by a.data_saida desc LIMIT $registroinicial,$pagesize ";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="5" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="51%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Local/Instituição </div></td>
          <td width="14%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Tipo</div></td>
          <td width="11%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Data saída</div></td>
          <td width="13%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Ret. provável</div></td>
          <td width="11%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Ret. efetivo</div></td>
        </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados())
	  {
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

			$dtsaida= explode("-", $row['saida_obra']);
			$dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
			$dtsaida= $dia."/".$mes."/".$ano;
			if ($dtsaida=='00/00/0000' || $dtsaida=="//")
				$dtsaida= "--/--/----";
			$dtretp= explode("-", $row['retorno_provavel']);
			$dia=$dtretp[2]; $mes=$dtretp[1]; $ano=$dtretp[0];
			$dtretp= $dia."/".$mes."/".$ano;
			if ($dtretp=='00/00/0000' || $dtretp=="//")
				$dtretp= "--/--/----";
			$dtrete= explode("-", $row['retorno_obra']);
			$dia=$dtrete[2]; $mes=$dtrete[1]; $ano=$dtrete[0];
			$dtrete= $dia."/".$mes."/".$ano;
			if ($dtrete=='00/00/0000' || $dtrete=="//")
				$dtrete= "--/--/----";
	  ?>
        <tr class="texto">
          <td width="51%"></td>
          <td width="14%"></td>
          <td width="11%"></td>
          <td width="13%"></td>
          <td width="11%"></td>
        </tr>
        <tr class="texto">
          <td height="23"><? echo $local; ?></td>
          <td align="center"><? echo $txtTipo; ?></td>
          <td align="center"><? echo $dtsaida; ?>
          <td align="center"><? echo $dtretp; ?>
          <td align="center"><? echo $dtrete; ?>
		  </td>
        </tr>
		<? } ?>
        <tr class="texto">
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="5" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"movimento_lista_obra.php?obrid=$_REQUEST[obrid]&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"movimento_lista_obra.php?obrid=$_REQUEST[obrid]&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"movimento_lista_obra.php?obrid=$_REQUEST[obrid]&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"movimento_lista_obra.php?obrid=$_REQUEST[obrid]&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
//echo"$lista_combo";
$g= " Total de movimentações desta obra: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='003366'>$g</font>";
?>
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>
    </form>
	</td>
  </tr>
</table>
</body>
</html>