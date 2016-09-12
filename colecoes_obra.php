<? include_once("seguranca.php") ?>
<html>
<head>
<title>Obras por Coleção</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual,i) {
if (qual.selectedIndex.selected!= '') {
document.location=('colecoes_obra.php?page='+ i+'&col=<? echo $_REQUEST[col]; ?>');
 }
}
function abre_pagina(idobra,title)
{ 
	win=window.open('consulta_obra.php?nosave=1&titulo='+title+'&obra='+idobra,'PAG','left='+((window.screen.width/2)-512)+',top='+((window.screen.height/2)-240)+',height=480,width=930,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>

</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#f2f2f2">
  <tr>
    <th width="471" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=$_REQUEST['est'];
$op=$_REQUEST['op'];
if ($_REQUEST[pagesize] < 999) {
echo $_SESSION[lnk];
}
?>
    </div></th>
    <th width="45" scope="col"><? if ($_REQUEST[pagesize] < 999) echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"?></th>
  </tr>
  <tr>
    <td colspan="2" valign="top"><form name="form1" method="post" action="">
      <?
	  	  function ret_colecao($valor) 
	  {
           global $db,$res;
	      $sql="SELECT nome from colecao where colecao=$valor";
    	  $db->query($sql);
	      $res=$db->dados();
		  $res=$res['nome'];
       }
	ret_colecao($_REQUEST[col]);

	  /////Paginando
	  $pagesize=10;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT count(DISTINCT(obra)) as total from log_pesquisa where colecao='$_REQUEST[col]'";
	  //echo $sql;
	  //exit;
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	    $sql2="SELECT DISTINCT a.obra,b.titulo FROM (log_pesquisa AS a, obra AS b) 
			WHERE (a.obra = b.obra) and a.colecao='$_REQUEST[col]' order by titulo asc LIMIT $registroinicial,$pagesize"; 
			//echo $sql2;
			//exit;
	    $db->query($sql2);
	  ////////////////////

	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="65%" height="24" bgcolor="#96ADBE" class="texto_bold"><div align="left">&nbsp;Obras
              com cole&ccedil;&atilde;o: <font style="color: white;"><? echo $res; ?></font></div></td>
          <td width="11%" bgcolor="#96ADBE" class="texto_bold"><div align="center"></div></td>
          <td width="11%" bgcolor="#96ADBE" class="texto_bold"><div align="center"></div></td>
          <td width="13%" bgcolor="#96ADBE" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['obra'] ?>">
          <td colspan="3" align="LEFT"><? echo "- ".$row[titulo] ?>            <div align="center">
            </div>
            <div align="center"></div></td>
          <td align="center" width='13%'><? if ($_REQUEST[pagesize] < 999) echo "<a href=\"javascript:abre_pagina($row[obra],'".htmlentities(str_replace("'","`",$row[titulo]), ENT_QUOTES)."');\">
		  <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informa&ccedil;&otilde;es'  
	      onMouseOver='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"#ddddd5\";' 
		  onMouseOut='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"\";'>";}?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td width="63%"></td>
          <td width="13%"></td>
          <td width="11%"></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"colecoes_obra.php?pagesize=999999&page=1&col=".$_REQUEST['col']."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
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

$a="<a href=\"colecoes_obra.php?page=".$first."&col=".$_REQUEST['col']."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"colecoes_obra.php?page=".$menos."&col=".$_REQUEST['col']."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"colecoes_obra.php?page=".$mais."&col=".$_REQUEST['col']."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"colecoes_obra.php?page=".$last."&col=".$_REQUEST['col']."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$txtpagina= "";
if ($_REQUEST[pagesize] < 999) {
	$txtpagina= "- Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;";
}
$g= " Total de registros encontrados: $numlinhas ".$txtpagina.$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
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
          <input name="est" type="hidden" id="est" value="<? echo $est ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>
