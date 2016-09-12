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
document.location=('graph_autorlista.php?page='+i);
}}


function posiciona(valor) {
var i = valor;
document.location=('graph_autorlista.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}

function abre_grafico(p1,p2,p3)
{
  win=window.open('graphautor.php?p1='+p1+'&p2='+p2+'&p3='+p3,'Grafico','left='+((window.screen.width/2)-370)+',top='+((window.screen.height/2)-225)+',scrollbars=no, height=450,width=740,status=no,toolbar=no,menubar=no,location=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
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
montalinks();
$_SESSION['lnk']= $link;

?>
    </div></th>
  </tr>
  <tr>
    <td valign="top" colspan="2"><form name="form1"  method="post">
    <?
	  set_time_limit(0);
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT a.autor T  FROM  autor a,autor_obra b,obra o
            WHERE (a.autor = b.autor) AND (o.obra=b.obra)  GROUP BY a.autor ORDER BY T DESC ";
	  $db->query($sql);
	  $numlinhas=$db->contalinhas();
	  $sql2="SELECT count(a.autor) FROM autor a, autor_obra b,obra o WHERE (b.obra=o.obra) AND(a.autor = b.autor)";
	  $db->query($sql2);
	  $tot_geral=$db->dados();
	 
	  $sql3="SELECT a.nomeetiqueta,count( * ) T,a.autor  FROM autor a, autor_obra b, obra o
      WHERE (a.autor = b.autor) AND (b.obra=o.obra)  GROUP BY b.autor ORDER BY T desc  LIMIT $registroinicial,$pagesize";
	  $db->query($sql3); 
	 
	 ?>
<table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="7" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td height="24" bgcolor="#ddddd5" class="texto_bold">&nbsp;&nbsp;Autor <div align="center"></div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">              </div></td>
          <td width="14%" bgcolor="#ddddd5" class="texto_bold"><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
          <td colspan="7" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row[autor] ?>">
          <td align="justify" height="20"><b>&nbsp;<? echo $row[nomeetiqueta] ?></b> 
		  </td>
          <td align="center" width='14%'><? // nao passar op=view senao fara insert em log_pesquisa 
	 echo "<a href=\"javascript:;\" OnClick=\"abre_grafico(".$tot_geral[0].",".$row[T].",'".$row[nomeetiqueta]."')\" > 
	 <img src='imgs/icons/ic_graph.gif' border='0' alt='Visualizar gráfico' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";} ?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="3"></td>
        </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
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

$a="<a href=\"graph_autorlista.php?page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial'></a>";

$b="<a href=\"graph_autorlista.php?page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior'></a>";

$c="<a href=\"graph_autorlista.php?page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro'></a>";

$d="<a href=\"graph_autorlista.php?page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro'></a>";

 for($i=1;$i<=$numpages;$i++)
 {
  if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 } 
  $lista_combo="<select style='text-align:center;' name=i onChange='obtem_valor(this,this.value)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }
$g= "<b>".$numlinhas."</b> autores encontrados - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
<? //} ?>
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