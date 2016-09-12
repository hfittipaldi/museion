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
document.location=('obra_ocorrencia_altera_reserva.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo]; ?>&numregistro=<? echo $_REQUEST[numregistro]; ?>&emcatalog=<? echo $_REQUEST[emcatalog]; ?>');
}}

function posiciona(valor) {
var i = valor;
document.location=('obra_ocorrencia_altera_reserva.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}

</script>

</head>

<body>
<p>&nbsp;</p>
<table width="546"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td width="546" valign="top"><form name="form1" method="post" action="cadastroautor.php">
      <span class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
?>
      </span>
      <?
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $ocorrencia_catal="";
	  if ($_REQUEST['emcatalog'] == "1") {
		$ocorrencia_catal="obras em catalogação";
	    $sql="SELECT count(*) as total from obra where status = 'C' AND catalogado = '$_SESSION[susuario]'";
	  }
	  else {
		  $sql="SELECT count(*) as total from obra as a where (a.num_registro = '$_REQUEST[numregistro]' or a.num_registro like '$_REQUEST[numregistro] %' or '$_REQUEST[numregistro]'='')  AND 
			(a.titulo like '%$_REQUEST[titulo]%' or '$_REQUEST[titulo]'='')";
	  }
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  if ($_REQUEST['emcatalog'] == "1") {
	    $sql2="SELECT * from obra where status = 'C' AND catalogado = '$_SESSION[susuario]' order by data_catalog1 desc LIMIT $registroinicial,$pagesize";
	  }
	  else {
		  if ($_REQUEST['numregistro'] <> '')
			$order= "num_registro + 0, num_registro";
		  else
			$order= "titulo";
		  $sql2="SELECT a.* from obra as a where (a.num_registro = '$_REQUEST[numregistro]' or a.num_registro like '$_REQUEST[numregistro] %' or '$_REQUEST[numregistro]'='')  AND 
			(a.titulo like '%$_REQUEST[titulo]%' or '$_REQUEST[titulo]'='') 
		    order by $order asc LIMIT $registroinicial,$pagesize";
	  }
	  $db->query($sql2);
	  ?>
      <table width="100%" height="10"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;&nbsp;Ocorr&ecirc;ncias
              encontradas para:<?  echo "<font color=brown>&nbsp;".$_REQUEST[titulo].$_REQUEST[numregistro].$ocorrencia_catal."</font>"; ?></div>            
          <div align="left"></div>            <div align="center"></div>            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['obra'] ?>">
          <td height="24" colspan="3" align="justify"><? echo "<b>".$row[num_registro]."</b>"." - ".$row[titulo] ?><div align="left">
            </div></td>
          <td align="center" width='15%'>
            <div align="center"><? echo "<a href=\"cadastrobra_reserva.php?op=update&obra=".$row[obra]."\">
			 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' 
			 onMouseOver='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"#ddddd5\";' 
			 onMouseOut='document.getElementById(\"cor_fundo".$row[obra]."\").style.backgroundColor=\"\";'>";?></div></td>
        </tr>
        <? } ?>
        <tr class="texto">
          <td width="42%"></td>
          <td width="31%"></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
         
          <td></td>
        </tr>
        <tr>
          <td height="1" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr  class="texto">
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

$a="<a href=\"obra_ocorrencia_altera.php?page=".$first."&titulo=".$_REQUEST[titulo]."&numregistro=".$_REQUEST[numregistro]."&emcatalog=".$_REQUEST[emcatalog]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"obra_ocorrencia_altera?page=".$menos."&titulo=".$_REQUEST[titulo]."&numregistro=".$_REQUEST[numregistro]."&emcatalog=".$_REQUEST[emcatalog]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"obra_ocorrencia_altera?page=".$mais."&titulo=".$_REQUEST[titulo]."&numregistro=".$_REQUEST[numregistro]."&emcatalog=".$_REQUEST[emcatalog]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"obra_ocorrencia_altera?page=".$last."&titulo=".$_REQUEST[titulo]."&numregistro=".$_REQUEST[numregistro]."&emcatalog=".$_REQUEST[emcatalog]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de ocorr&ecirc;ncias: $numlinhas - P&aacute;gina: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?></td>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <p><? echo "<a href=\"alterar_obra.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>"?></p>
    </form>
</td>
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
