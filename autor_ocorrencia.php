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
document.location=('autor_ocorrencia.php?page='+ i + '&nomeetiqueta=<? echo $_REQUEST[nomeetiqueta] ?>');
}}

function posiciona(valor) {
var i = valor;
document.location=('autor_ocorrencia.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}

</script>

</head>
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
//$val=$_REQUEST['usuario'];
$op=$_REQUEST['op'];
	
?>
<body onload='document.getElementById("submit").disabled=true'>
<br>
<table width="546"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td valign="top"><form name="form1" method="post" action="cadastroautor.php">
      <?
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT count(*) as total from autor as a where a.nomeetiqueta like '%$_REQUEST[nomeetiqueta]%' OR a.nomecatalogo like '%$_REQUEST[nomeetiqueta]%'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.* from autor as a where a.nomeetiqueta like '%$_REQUEST[nomeetiqueta]%' OR a.nomecatalogo like '%$_REQUEST[nomeetiqueta]%' 
	  order by nomeetiqueta asc LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> Ocorr&ecirc;ncias
              encontradas para:<?  echo "<font color=brown>&nbsp;".ucfirst($_REQUEST[nomeetiqueta])."</font>"; ?></div>            <div align="left"></div>            <div align="center"></div>            <div align="center"></div></td>
          </tr>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
        <tr class="texto">
          <td align="justify"><font color='003366'> <b>Autor</b></td>
          <td align="justify"><font color='003366'> <b>Nome para Catálogo</b></td>
        </tr>
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto">
          <td align="justify"><? echo $row[1] ?></td>
          <td align="justify"><? echo $row[2] ?></td>
        </tr>
		<? } ?>
        <tr class="texto">
          <td></td>
          <td></td>
        </tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
        <tr>
          <td height="1" colspan="2" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto"  bgcolor="#ddddd5">
          <td colspan="2" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"autor_ocorrencia.php?page=".$first."&nomeetiqueta=".$_REQUEST[nomeetiqueta]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"autor_ocorrencia.php?page=".$menos."&nomeetiqueta=".$_REQUEST[nomeetiqueta]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"autor_ocorrencia.php?page=".$mais."&nomeetiqueta=".$_REQUEST[nomeetiqueta]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"autor_ocorrencia.php?page=".$last."&nomeetiqueta=".$_REQUEST[nomeetiqueta]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de ocorr&ecirc;ncias: $numlinhas - P&aacute;gina:$page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?></td>
        </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="2" align="center">&nbsp;Caso o nome do autor n&atilde;o
            conste na lista, clique na caixa de sele&ccedil;&atilde;o e em seguida
            no&nbsp;bot&atilde;o &quot;Avan&ccedil;ar&quot;.</td>
        </tr>
        <tr class="texto">
          <td colspan="2"  align="center"><input name="check" type="checkbox" id="check" value="checkbox" onclick='if(this.checked) {document.getElementById("submit").disabled=false} else {document.getElementById("submit").disabled=true}' >
            <input name="nomeetiqueta" type="hidden" id="nomeetiqueta" value="<? echo troca_percent($_REQUEST[nomeetiqueta]) ?>">
            <input name="op" type="hidden" id="op" value="insert">
            <input name="Submit" type="submit" class="botao" id="submit" value="Avan&ccedil;ar" ></td>
        </tr>
        <tr>
          <td colspan="2"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
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
