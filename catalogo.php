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
document.location=('catalogo.php?page='+ i);
}}
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
$val=$_REQUEST['catalogo'];
$op=$_REQUEST['op'];
montalinks();
$_SESSION['lnk']=$link;
?>
    </div></th>
  </tr>
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
	  $sql="SELECT count(*) as total from catalogo";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.* from catalogo as a order by nome asc LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td height="24" bgcolor="#96ADBE" class="texto_bold"><div align="left">&nbsp;Cat&aacute;logo</div></td>
          <td width="12%" bgcolor="#96ADBE" class="texto_bold"><div align="center"></div></td>
          <td width="12%" bgcolor="#96ADBE" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['catalogo'] ?>">
          <td colspan="2" align="justify"><? echo $row[nome] ?></td>
          <td align="center" width='12%'><? echo "<a href=\"catalogo1.php?op=del&catalogo=".base64_encode($row['catalogo'])."\"
	onClick='return confirm(".'"Confirma Exclusão do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif' width='20' height='20'
	border='0' alt='Excluir' 
	onMouseOver='document.getElementById(\"cor_fundo".$row[catalogo]."\").style.backgroundColor=\"#ddddd5\";' 
	onMouseOut='document.getElementById(\"cor_fundo".$row[catalogo]."\").style.backgroundColor=\"\";'>";?>
            <div align="center"></div></td>
          <td align="center" width='12%'><? echo "<a href=\"catalogo1.php?op=update&catalogo=".base64_encode($row['catalogo'])."\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[catalogo]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[catalogo]."\").style.backgroundColor=\"\";'>"; }?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td width="65%"></td>
          <td width="12%"></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td></td>
          <td align="right"><? echo "<a href=\"catalogo1.php?op=insert\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Novo Registro' >"?></td>
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

$a="<a href=\"catalogo.php?page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"catalogo.php?page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"catalogo.php?page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"catalogo.php?page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de catálogos cadastrados: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <p>
          <input name="catalogo" type="hidden" id="catalogo" value="<? echo $catalogo ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">

		  <br>
        </p>
      <p></p>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>
