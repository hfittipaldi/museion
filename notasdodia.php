<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual,i) {
if (qual.selectedIndex.selected!= '') {
document.location=('notasdodia.php?page='+ i+ '&dePesq=<? echo $_REQUEST[dePesq]; ?>&atePesq=<? echo $_REQUEST[atePesq]; ?>&status=<? echo $_REQUEST[status]; ?>');
}}

function excluirMarcadas(index) {
	if (confirm('Confirma Exclusão do(s) Registro(s) selecionado(s) ?')) {
		vet_ids= '';
		for (i=0;i<index;i++) {
			if (document.getElementById('marca'+(i+1)).checked) {
				if (vet_ids == '')
					vet_ids= document.getElementById('marca'+(i+1)).value;
				else
					vet_ids= vet_ids + ',' + document.getElementById('marca'+(i+1)).value;
			}
		}
		if (vet_ids == '')
			alert('Nenhuma mensagem selecionada!');
		else
			document.location= ('anotacoes.php?op=del&anot=' + vet_ids);
	}
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

$status=$_REQUEST['status'];
if ($status == '')
	$status= '0';
$dePesq=explode("/", $_REQUEST['dePesq']);
$ano=$dePesq[2]; $mes=$dePesq[1]; $dia=$dePesq[0];
$dePesq=$ano."-".$mes."-".$dia;
$atePesq=explode("/", $_REQUEST['atePesq']);
$ano=$atePesq[2]; $mes=$atePesq[1]; $dia=$atePesq[0];
$atePesq=$ano."-".$mes."-".$dia;
if ($dePesq == '--')
	$dePesq="0000-00-00";
if ($atePesq == '--')
	$atePesq="2099-12-31";

montalinks();
?>
    </div></th>
  </tr>
  <tr>
	<form name="form" method="get" action="notasdodia.php">
	<th align="left" class="texto_bold">&nbsp;&nbsp;&nbsp;Data de aviso a partir de: <input type="text" class="combo_texto" name="dePesq" size="10" maxlength="10" value="<? echo $_REQUEST['dePesq']; ?>"> 
		&nbsp;até: <input type="text" class="combo_texto" name="atePesq" size="10" maxlength="10" value="<? echo $_REQUEST['atePesq']; ?>"> 
		&nbsp;&nbsp;&nbsp;&nbsp;Estado: <select name="status" id="status" class="combo_cadastro">
		<option value="0">Não lida</option><option value="1">Lida</option><option value="2">Todas</option></select>&nbsp;&nbsp;&nbsp;
		<input type="submit" name="ok" value=" Ok " class="combo_cadastro" style="cursor:pointer; border-width: 1px;">
	</th>
	</form>
  </tr>
  <? echo "<script>document.form.status.value= '$status';</script>"; ?>
  <tr>
    <td valign="top"><form name="form1" method="post">
      <?
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT count(*) as total from agenda where usuario = '$_SESSION[susuario]' AND (data_aviso >= '$dePesq' and data_aviso <= '$atePesq') AND (eh_lida = '$status' or '$status' = '2')";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.*,b.nome from agenda a,usuario b where a.usuario_origem = b.usuario AND (data_aviso >= '$dePesq' and data_aviso <= '$atePesq') 
			AND (eh_lida = '$status' or '$status' = '2') AND a.usuario = '$_SESSION[susuario]' order by a.eh_lida, a.data_inclusao desc, a.agenda desc LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="6" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="5%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="center">&nbsp;</div></td>
          <td width="45%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;Assunto</div></td>
          <td width="20%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Origem</div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Lida ?</div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? $indice= 0;
		 while($row=$db->dados()) {
			$indice++;
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['agenda'] ?>">
          <td align="justify" width='5%'><input type="checkbox" name="marca<? echo $indice ?>" id="marca<? echo $indice ?>" value="<? echo $row['agenda'] ?>"></td>
          <td align="justify" width='45%'><? echo $row[assunto] ?></td>
          <td width='20%'><div align="center"><? echo $row[nome] ?>
            </div></td>
          <td width='10%'><div align="center"><? if ($row[eh_lida]) echo "SIM"; else echo "NÃO"; ?>
            </div></td>
          <td align="center" width='10%'><? echo "<a href=\"anotacoes.php?op=del&anot=".$row['agenda']."\"
	onClick='return confirm(".'"Confirma Exclusão do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif' width='20' height='20'
	border='0' alt='Excluir' 
	onMouseOver='document.getElementById(\"cor_fundo".$row[agenda]."\").style.backgroundColor=\"#ddddd5\";' 
	onMouseOut='document.getElementById(\"cor_fundo".$row[agenda]."\").style.backgroundColor=\"\";'>";?>
            <div align="center"></div></td>
			<?php 
				if ($row['usuario'] == $row['usuario_origem'])
					$tipo= 1;
				else
					$tipo= 2;
			?>
          <td align="center" width='10%'><? echo "<a href=\"anotacoes.php?op=update&anot=".$row['agenda']."&tipo=$tipo\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Ler/Alterar' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[agenda]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[agenda]."\").style.backgroundColor=\"\";'>"; }?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="4">&nbsp;<? if ($indice > 0) { ?><img src='imgs/icons/ic_excluir.gif' style="cursor:pointer;" onClick="excluirMarcadas(<? echo $indice; ?>);" width='20' height='20' border='0' alt='Excluir marcadas'><? } ?></td>
          <td></td>
          <td align="center"><? echo "<a href=\"anotacoes.php?tipo=1\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Novo Registro' >"?></td>
        </tr>
        <tr>
          <td height="1" colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
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

$a="<a href=\"notasdodia.php?page=".$first."&dePesq=".$_REQUEST[dePesq]."&atePesq=".$_REQUEST[atePesq]."&status=".$_REQUEST[status]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"notasdodia.php?page=".$menos."&dePesq=".$_REQUEST[dePesq]."&atePesq=".$_REQUEST[atePesq]."&status=".$_REQUEST[status]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"notasdodia.php?page=".$mais."&dePesq=".$_REQUEST[dePesq]."&atePesq=".$_REQUEST[atePesq]."&status=".$_REQUEST[status]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"notasdodia.php?page=".$last."&dePesq=".$_REQUEST[dePesq]."&atePesq=".$_REQUEST[atePesq]."&status=".$_REQUEST[status]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
$combo="";

 for($i=1;$i<=$numpages;$i++)
 {
  if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 } 
  $lista_combo="<select name=i onChange='obtem_valor(this,this.value)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }
//echo"$lista_combo";
$g= " Total de registros encontrados: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
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
    <p></p></td>
  </tr>
</table>
</body>
</html>
