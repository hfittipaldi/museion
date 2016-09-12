<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('obra_lista_retorno.php?movid=<? echo $_REQUEST[movid] ?>&page='+ i);

}}

function valida() {
	if(document.form1.data.value=='') { alert('Preencha a data de retorno efetivo!'); document.form1.data.focus(); return false; }

	if (!Validar_Campo_Data(document.form1.data,false)) {
		alert('Preencha corretamente o campo "data de retorno efetivo"!'); document.form1.data.focus(); return false;
	}
}
</script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();

	if ($_REQUEST['Submit'] <> '') {
		$data= explode("/", $_REQUEST['data']);
		$dia=$data[0]; $mes=$data[1]; $ano=$data[2];
		$data= $ano."-".$mes."-".$dia;
		$sql="UPDATE obra_movimentacao set data_retorno='$data' where movimentacao = '$_REQUEST[movid]'";
		$db->query($sql);
	}
 ?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="" onSubmit="return valida();">
      <?
	  /////Paginando
	  $pagesize=8;
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
	  $sql2="SELECT a.num_registro,a.titulo,b.*,b.data_retorno as retorno_obra FROM obra as a  INNER JOIN  obra_movimentacao as b on (a.obra=b.obra) where movimentacao='$_REQUEST[movid]' order by a.titulo LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
		<tr>
          <td height="28" colspan="4" class="texto_bold"><div align="right">&nbsp;Data de retorno: 
			<input name="data" type="text" class="combo_cadastro" id="data" size="12" maxlength="10">
            <input name="movid" type="hidden" id="movid" value="<? echo $_REQUEST[movid]; ?>">
			<input name="oculto" type="text" id="oculto" value="" style="display:none">
			&nbsp;<input name="Submit" type="submit" class="texto_bold" value="Atualizar todas">
		  </div></td>
		</tr>
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"  ><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="5%" nowrap height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;"><div align="left"> &nbsp;Nº reg / </div></td>
          <td width="70%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Obra</div></td>
          <td width="20%" bgcolor="#ddddd5" class="texto_bold"><div align="left">Data de retorno</div></td>
          <td width="5%" nowrap height="24" bgcolor="#ddddd5" class="texto_bold" style="border-right: 1px solid #121212;"><div align="center" ></div></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000" ><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
			$dtretorno= explode("-", $row['retorno_obra']);
			$dia=$dtretorno[2]; $mes=$dtretorno[1]; $ano=$dtretorno[0];
			$dtretorno= $dia."/".$mes."/".$ano;
			if ($dtretorno=="00/00/0000" || $dtretorno=="//")
				$dtretorno= "--/--/----";
	  ?>
        <tr class="texto">
          <td width="5%" nowrap></td>
          <td width="70%"></td>
          <td width="20%"></td>
          <td width="5%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['obra_movimentacao'] ?>">
          <td height="23" align="right"><? echo $row['num_registro']; ?>. </td>
          <td ><? echo $row['titulo']; ?></td>
          <td align="center"><? echo $dtretorno; ?>&nbsp;&nbsp;
					<? if ($dtretorno <> "--/--/----") {
						 echo "<a href=\"mov_obra_data1.php?op=limpar&movid=".$_REQUEST['movid']."&obra=".$row['obra']."\">
						 <img src='imgs/icons/ic_apagar.gif' border='0' alt='Limpar data' 
						 onMouseOver='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"#ddddd5\";' 
						 onMouseOut='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"\";'></a>"; } ?>
		  </td>
          <td align="center">
					<? echo "<a href=\"mov_obra_data1.php?movid=".$_REQUEST['movid']."&obra=".$row['obra']."\">
					 <img src='imgs/icons/ic_calendar.gif' border='0' alt='Alterar data' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"#ddddd5\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[obra_movimentacao]."\").style.backgroundColor=\"\";'></a>";?>
		  </td>
        </tr>
		<? } ?>
        <tr class="texto">
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr bgcolor="#ddddd5" class="texto">
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

$a="<a href=\"obra_lista_retorno.php?movid=".$_REQUEST[movid]."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"obra_lista_retorno.php?movid=".$_REQUEST[movid]."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"obra_lista_retorno.php?movid=".$_REQUEST[movid]."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"obra_lista_retorno.php?movid=".$_REQUEST[movid]."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de obras da movimentação: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>";   
?>               
            <div align="center"></div></td>
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