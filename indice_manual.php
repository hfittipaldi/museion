<? include_once("seguranca.php") ?>
<html>
<head>
<title>Manual de Catalogação</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('indice_manual.php?corfundo=<? echo $_REQUEST[corfundo]; ?>&page='+ i+ '&busca=<? echo $_REQUEST[busca]; ?>');
}}
function valida(){
with(document.form2)
{
  if(busca.value==''){
    alert('Preencha o campo de busca');
	busca.focus();
	return false;}
 }
}
</script>

</head>

<body style="background-color: #<? echo $_REQUEST[corfundo]; ?>;">
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#f2f2f2" >
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
if($_REQUEST[janela]!='popup')
{
 echo $_SESSION['lnk'];
}
// verbete=indice

?>
    </div></th>
  </tr>
      <?
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;

		if ($_REQUEST['busca']=='') {
		  $sql="SELECT count(*) as total from indice_manual";
		  $sql2="SELECT *from indice_manual order by verbete asc LIMIT $registroinicial,$pagesize";
		 }
		else {
		  $condicao=" verbete like '%".trim($_REQUEST[busca])."%' OR sub_item like '%".trim($_REQUEST[busca])."%'";
		  $sql="SELECT count(*) as total from indice_manual where $condicao ";
		  $sql2="SELECT *from indice_manual where $condicao order by verbete asc LIMIT $registroinicial,$pagesize";
		 }
		  $db->query($sql);
		  $numlinhas=$db->dados();
          $numlinhas=$numlinhas[0];

		  $db->query($sql2);
	   ?>
  <tr>
    <td align="left" class="texto_bold"><form name="form2" method="get" action="indice_manual.php?corfundo=<? echo $_REQUEST[corfundo]; ?>" onSubmit="return valida()">
      &nbsp;&nbsp;&nbsp;Busca por &Iacute;ndice/ Sub-item:
         
        <input name="busca" type="text" class="combo_cadastro" id="busca" size="30">
        &nbsp;&nbsp;<input name="submit" type="submit" class="combo_cadastro" value=" Ok " style="cursor: pointer; border-width: 1px;">
    </form></td>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="get" action="">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="48%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;&nbsp;&Iacute;ndice</div></td>
          <td width="26%" bgcolor="#ddddd5" class="texto_bold"><div align="left">Sub-Item</div></td>
          <td width="14%" bgcolor="#ddddd5" class="texto_bold"><div align="left">&Aacute;rea/&nbsp;Item</div></td>
          <td width="12%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="1" >
		<? while($row=$db->dados())
	  { 
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['indice_manual'] ?>">
          <td align="left" width='48%'>&nbsp;<? echo $row[verbete] ?></td>
          <td align="left">
		  <? echo $row[sub_item] ?>
            <div align="left"></div> 
            <div align="center"></div></td>
          <td align="left"><? echo $row[area];echo $row[item]; ?>            </td>
          <td align="center" width='12%'><div align="center">
            <? // nao passar op=view senao fara insert em log_pesquisa 
	 echo "<a href=\"manual_catalog1.php?corfundo=".$_REQUEST[corfundo]."&tipo=INDICE&area=".$row[area]."&item=".$row['item']."\"> 
	 <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informa&ccedil;&otilde;es' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[indice_manual]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[indice_manual]."\").style.backgroundColor=\"\";'>"; ?>
            <? } ?>
</div></td>
        </tr>
        <tr class="texto">
          <td></td>
          <td width="26%"></td>
          <td width="14%"></td>
          <td></td>
        </tr>
        <tr>
          <td height="1" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="4" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"indice_manual?corfundo=".$_REQUEST[corfundo]."&page=".$first."&busca=".$_REQUEST[busca]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"indice_manual?corfundo=".$_REQUEST[corfundo]."&page=".$menos."&busca=".$_REQUEST[busca]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"indice_manual.php?corfundo=".$_REQUEST[corfundo]."&page=".$mais."&busca=".$_REQUEST[busca]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"indice_manual.php?corfundo=".$_REQUEST[corfundo]."&page=".$last."&busca=".$_REQUEST[busca]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de registros encontrados: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="1" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td>
            <div align="left"><? echo "<a href=\"manual_catalog.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
        </tr>
      </table>
       </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>
