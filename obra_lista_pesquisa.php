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
document.location=('obra_lista_pesquisa.php?movid=<? echo $_REQUEST[movid] ?>&page='+ i);

}}
</script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
 ?>
<body>
<table width="<? if ($_REQUEST[pagesize] < 999) echo "100%"; else echo "520"; ?>" border="0" align="left" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=9;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	 $sql="SELECT count(*) as total from obra_movimentacao where movimentacao='$_REQUEST[movid]'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  ////////////////////
	  $sql2="SELECT a.num_registro,a.titulo,b.*,b.data_saida as saida_obra,b.data_retorno as retorno_obra FROM obra as a  INNER JOIN  obra_movimentacao as b on (a.obra=b.obra) where movimentacao='$_REQUEST[movid]' order by a.titulo LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="10%" nowrap height="24" class="texto_bold"><div align="left"> &nbsp;Nº reg /</div></td>
          <td width="60%" height="24" class="texto_bold"><div align="left">Obra</div></td>
          <td width="15%" class="texto_bold"><div align="center">Data de saída</div></td>
          <td width="15%" class="texto_bold"><div align="center">Data de retorno</div></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
		<? while($row=$db->dados())
	  {
			$dtsaida= explode("-", $row['saida_obra']);
			$dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
			$dtsaida= $dia."/".$mes."/".$ano;
			if ($dtsaida=="00/00/0000" || $dtsaida=="//")
				$dtsaida= "--/--/----";
			$dtretorno= explode("-", $row['retorno_obra']);
			$dia=$dtretorno[2]; $mes=$dtretorno[1]; $ano=$dtretorno[0];
			$dtretorno= $dia."/".$mes."/".$ano;
			if ($dtretorno=="00/00/0000" || $dtretorno=="//")
				$dtretorno= "--/--/----";
	  ?>
        <tr class="texto">
          <td width="10%" nowrap></td>
          <td width="60%"></td>
          <td width="15%"></td>
          <td width="15%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['obra_movimentacao'] ?>">
          <td height="23" align="left"><? echo "<b>".$row['num_registro']."</b>"; ?></td>
          <td >&nbsp;&nbsp;<? echo $row['titulo']; ?></td>
          <td align="center"><? echo $dtsaida; ?></td>
          <td align="center"><? echo $dtretorno; ?></td>
        </tr>
		<? } ?>
        <tr class="texto">
          <td colspan="4" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"obra_lista_pesquisa_1.php?page=1&pagesize=999999&movid=".$_REQUEST[movid]."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5" " class="texto">
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

$a="<a href=\"obra_lista_pesquisa.php?movid=".$_REQUEST[movid]."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"obra_lista_pesquisa.php?movid=".$_REQUEST[movid]."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"obra_lista_pesquisa.php?movid=".$_REQUEST[movid]."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"obra_lista_pesquisa.php?movid=".$_REQUEST[movid]."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
	$txtpagina= "- Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;";
}
$g= " Total de obras da movimentação: $numlinhas ".$txtpagina.$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>";   
?>               
            <div align="center"></div></td>
          </tr>
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>