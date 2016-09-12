<? include_once("seguranca.php") ?>
<html>
<head>
<title>Obras Mais Consultadas</title>
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
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('obrasmais.php?page='+ i+ '&dt_ini=<? echo $_REQUEST[dt_ini]; ?>&dt_fim=<? echo $_REQUEST[dt_fim]; ?>');
 }
}


function posiciona(valor) {
var i = valor;
document.location=('obrasmais.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}

function valida(){
    var mensagem = "";
    var form  = document.form2;
    var campo = "";
    var num_elementos =  form.elements.length;
     for (var i = num_elementos-1; i >= 0 ; i--){	  	   
     var elemento = form.elements[i];
     }	  
    
	 if (mensagem != ""){
        alert(mensagem);
        campo.focus();
        return false;
     } else return true;
}
//
function abre_pagina(idobra,title)
{ 
  	win=window.open('consulta_obra_2.php?nosave=1&num_registro='+title+'&obra='+idobra,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-240)+',height=520,width=780,scrollbars=yes,status=no,toolbar=no,menubar=no,location=yes');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
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
$val=$_REQUEST['log_atualizacao'];
$op=$_REQUEST['op'];
if ($_REQUEST[pagesize] < 999) {
montalinks();
}
$_SESSION['lnk']=$link;
?>
    </div></th>
  </tr>
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

		if ($_REQUEST['dt_ini']=='' && $_REQUEST['dt_fim']=='') {
		  $sql="SELECT count(distinct a.obra) as total from log_pesquisa as a,obra as b where (a.quantidade<>'0')and(a.obra=b.obra) and a.obra>0";
		  
		  $sql2="SELECT B.obra,B.num_registro,log_pesquisa,titulo,sum(A.quantidade) as total FROM (log_pesquisa AS a, obra AS b) 
			WHERE  (a.quantidade<>'0') and (a.obra = b.obra) group by B.obra order by sum(A.quantidade) desc LIMIT 0,10";
		
		}
		else {
		  $dti=seta_data($_REQUEST[dt_ini]);
		  $dtii=seta_data($_REQUEST[dt_fim]);
		  
		  $sql="SELECT count(distinct a.obra) as total from log_pesquisa as a,obra as b where (a.quantidade>0) and (a.obra=b.obra) and a.obra <> 0 
		  and a.data_hora>='$dti' and data_hora < DATE_ADD('$dtii',INTERVAL 1 DAY)";
		
		  $sql2="SELECT B.obra,B.num_registro,log_pesquisa,titulo,sum(A.quantidade) as total FROM (log_pesquisa AS a, obra AS b) 
			WHERE (A.quantidade<>'0') and (a.obra = b.obra) and a.data_hora >='$dti' and data_hora < DATE_ADD('$dtii',INTERVAL 1 DAY) 
		     group by B.obra order by sum(A.quantidade) desc LIMIT 0,10";
		}
		  $db->query($sql);
		  $numlinhas=$db->dados();
                  $numlinhas=$numlinhas[0];

		  $db->query($sql2);
	   ?>
  <tr>
    <td valign="top" class="texto_bold"><form name="form2" method="post" action="obrasmais.php" onSubmit="return valida()">
    </form></td>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="11%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">  &nbsp;Registro </div></td>
          <td bgcolor="#ddddd5" class="texto_bold">&nbsp;T&iacute;tulo
            <div align="left"></div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Consultas</div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados())
	  {
 	  ?>
        <tr id="cor_fundo<? echo $row['log_pesquisa'] ?>" class="texto">
          <td align="left" width='11%'><? echo $row['num_registro'] ?></td>
          <td colspan="2" align="left"><? echo $row['titulo'] ?>
            <div align="center"></div></td>
          <td align="left" width='15%'> 
            <div align="center"><? echo $row[total] ?></div></td>
          <td align="center" width='15%'><div align="center">
            <? if ($_REQUEST[pagesize] < 999) echo "<a href=\"javascript:abre_pagina($row[obra],'');\">
		  <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informações'  
	      onMouseOver='document.getElementById(\"cor_fundo".$row[log_pesquisa]."\").style.backgroundColor=\"#ddddd5\";' 
		  onMouseOut='document.getElementById(\"cor_fundo".$row[log_pesquisa]."\").style.backgroundColor=\"\";'>";?>
            <? }?>
          </div></td>
        </tr>


        <tr class="texto">
          <td colspan="3" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"obrasmais.php?pagesize=999999&page=1&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
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

$a="<a href=\"obrasmais.php?page=".$first."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"obrasmais.php?page=".$menos."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"obrasmais.php?page=".$mais."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"obrasmais.php?page=".$last."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
$combo="";

?>               
            </td>
          </tr>
        </table>
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
