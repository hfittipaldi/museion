<? include_once("seguranca.php") ?>
<html>
<head>
<title>Autores por Coleção</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style>
@media print {
	.noprint {
		display: none;
	}
}
</style>
<script>
function obtem_valor(qual,i) {
if (qual.selectedIndex.selected!= '') {
document.location=('colecoes_autor.php?page='+i+'&colecao=<? echo $_REQUEST[colecao]; ?>');
}}

function posiciona(valor) {
var i = valor;
document.location=('colecoes_autor.php?page='+i+'&colecao=<? echo $_REQUEST[colecao]; ?>');
}

function verificar() {
	with(document.form){
	 if(colecao.value=='')
	 {
	   alert('Informe a coleção.');
	   return false;
	 }
	return true;
 }
}
function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-125)+',top='+((window.screen.height/2)-150)+',width=250,height=300, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4)
{
   win.window.focus();
 }
 return true;
}
</script>

</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="5%" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
if ($_REQUEST[pagesize] < 999) {
montalinks();
}
$_SESSION['lnk']= $link;

if ($_REQUEST['colecao'] <> '') {
	$sql= "SELECT nome from colecao where colecao='$_REQUEST[colecao]'";
	$db->query($sql);
	$res= $db->dados();
	$txtpesquisa="Autores com coleção: <font style='color:brown;'>".$res['nome']."</font>";
}
?>
    </div></th>
  </tr>
  <tr>
	<? // if ($_REQUEST['ok']=='' && $_REQUEST[page]=='') { ?>
	<form name="form" method="get" action="colecoes_autor.php" onSubmit="return verificar();">
	<th>	  <div align="left"><span class="texto_bold"><? if ($_REQUEST[pagesize] < 999) { ?>Selecione&nbsp;a cole&ccedil;&atilde;o:
          <select name="colecao" class="combo_cadastro">
				    <? 
					  $sql="SELECT colecao,nome from colecao order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='' selected></option>";
					  while($res=$db->dados()) {
					  ?>
					     <option value="<? echo $res[0]; ?>"><? echo $res[1]; ?></option>
		            <? } ?>
          </select>
		  <input type="submit" name="ok" value="Pesquisar" class="combo_cadastro"><br>&nbsp;<? } ?>
	  </span></div></th>
	<? /*} else {
		echo "<form name='form' method='post' action='colecoes_autor.php'>";
		echo "<th colspan='3' align='right' valign='bottom' class='texto_bold'>";
		echo "<input type='submit' name='nova' value='Nova consulta' class='combo_cadastro' style='cursor:pointer; border-width: 1px;'>";
		echo "</th>";
	} */ ?>

	</form>
  </tr>

<? if ($_REQUEST['ok']<>'' || $_REQUEST[page]<>'') { ?>
  <tr>
    <td valign="top" colspan="2"><form name="form1"  method="get">
    <?
	  /////Paginando
	  $pagesize=10;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT count(DISTINCT a.autor)  as total FROM autor a, autor_obra b, obra c
            WHERE (a.autor = b.autor) AND (b.obra = c.obra) AND c.colecao = '$_REQUEST[colecao]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  $sql2="SELECT DISTINCT (a.nomeetiqueta),count(*) AS total,a.autor FROM autor a, autor_obra b, obra c WHERE a.autor = b.autor
             AND b.obra = c.obra AND c.colecao='$_REQUEST[colecao]' GROUP BY a.nomeetiqueta 
			 ORDER BY count(*) DESC LIMIT $registroinicial,$pagesize";
	  $db->query($sql2); 
	 ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="6" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="71%" height="24" bgcolor="#ddddd5" class="texto_bold"><? echo $txtpesquisa; ?></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">N&ordm; de obras </div></td>
          <td width="14%" bgcolor="#ddddd5" class="texto_bold"><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['autor'] ?>">
          <td align="justify" width='71%'><b><? echo $row[nomeetiqueta] ?></b> 
			</td>
          <td align="center" width='15%'><? echo $row[total] ?></td>
          <td align="center" width='14%'><? if ($_REQUEST[pagesize] < 999) echo "<a href=\"consulta_autor.php?id=".$row['autor']."&nosave=1\">
	 <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informações' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>"; }?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td colspan="2"></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"colecoes_autor.php?pagesize=999999&page=1&colecao=".$_REQUEST['colecao']."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
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

$a="<a href=\"colecoes_autor.php?page=".$first."&colecao=".$_REQUEST['colecao']."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial'></a>";

$b="<a href=\"colecoes_autor.php?page=".$menos."&colecao=".$_REQUEST['colecao']."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior'></a>";

$c="<a href=\"colecoes_autor.php?page=".$mais."&colecao=".$_REQUEST['colecao']."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro'></a>";

$d="<a href=\"colecoes_autor.php?page=".$last."&colecao=".$_REQUEST['colecao']."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro'></a>";

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
          <td height="2" colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="6"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
<? } ?>
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