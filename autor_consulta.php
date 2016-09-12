<? include_once("seguranca.php") ?>
<html>
<head>
<title>Autores / % por consulta</title>
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
document.location=('autor_consulta.php?page='+i);
}}

function posiciona(valor) {
var i = valor;
document.location=('autor_consulta.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
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
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2 >
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
	  /////Paginando
	  $pagesize=10;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;

	  $registroinicial=$page* $pagesize;
 	  if ( strtoupper(trim($_REQUEST['nome'])) <>'' ) 
          { 
	     $Autor = str_replace(".", "",trim($_REQUEST['nome']));    
	     $whereAutor="f.nomeetiqueta like '%$Autor%' and ";
             $whereAutorCount="nome like '%$Autor%' and ";

	   } else {
	     $whereAutor="";
             $whereAutorCount="";
	   }

	   // TOTAL DE CONSULTA ( SOMA CAMPO QUANTIDADE com filtro ) 
           $sql2="select sum(o.quantidade) as totgeral from log_pesquisa o,autor f
                          where o.autor=f.autor and ".$whereAutor." o.quantidade<>'0';";
 	  $db->query($sql2);
          $row=$db->dados();
          $tot_geral_1=$row[totgeral];

	   // TOTAL DE CONSULTA ( SOMA CAMPO QUANTIDADE sem filtro )  
          $sql="select sum(quantidade) as totgeral from log_pesquisa where quantidade<>'0'";
	  $db->query($sql);
          $row=$db->dados();
          $tot_geral=$row[totgeral];



          $sql="select o.autor as autor,
                    o.quantidade as quantidade,
                      sum(quantidade) as entradas,
                        f.nomeetiqueta as nome from log_pesquisa o,autor f 
                          where ".$whereAutor." o.quantidade<>'0' and o.autor=f.autor group by o.autor order by quantidade DESC";
	  $db->query($sql);
	  $numlinhas=$db->contalinhas();
          
 



          $sql3="select o.autor as autor,o.quantidade as quantidade,count(o.quantidade) as total,
                 sum(quantidade) as entradas,f.nomeetiqueta as nome from log_pesquisa o,autor f 
                 where " .$whereAutor." o.quantidade <> '0' and o.autor=f.autor group by o.autor order by quantidade DESC LIMIT $registroinicial,$pagesize";// desc limit 10";		
          $db->query($sql3); 
	 
	 ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="7" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
         &nbsp;Autor:&nbsp;
	<input name="nome" type="text" class="combo_texto" size="36" value="<?echo $_REQUEST['nome'];?>">
        &nbsp;&nbsp;<input name="submit" type="submit" class="combo_cadastro" value=" Ok " style="cursor: pointer; border-width: 1px;">   


          <td width="56%" height="24" bgcolor="#ddddd5" class="texto_bold">&nbsp;Autor</td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold">Quantidade</td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">              %</div></td>
          <td width="14%" bgcolor="#ddddd5" class="texto_bold"><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
          <td colspan="7" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row[nome] ?>">
          <td align="justify" width='56%'><b>&nbsp;<? echo $row[nome] ?></b> 
			</td>
          <td align="center" width='15%'><? echo $row[entradas] ?></td>
          <td align="center" width='15%'>
		  <? 
		   $percent=($row[entradas]*100/$tot_geral);
		   echo number_format($percent,2,',','.');
		   ?>
		  </td>

          <td align="center" width='14%'><? if ($_REQUEST[pagesize] < 999) echo "<a href=\"consulta_autor.php?id=".$row['autor']."&nosave=1\">
	 <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informações' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[nome]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[nome]."\").style.backgroundColor=\"\";'>"; }?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td colspan="3"></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="7" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"autor_consulta.php?page=1&pagesize=999999\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
        </tr>
        <tr>
          <td height="1" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="7" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"autor_consulta.php?page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial'></a>";

$b="<a href=\"autor_consulta.php?page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior'></a>";

$c="<a href=\"autor_consulta.php?page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro'></a>";

$d="<a href=\"autor_consulta.php?page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro'></a>";

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
$txtpagina= "";
if ($_REQUEST[pagesize] < 999) {
	$txtpagina= "- Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;";
}
$g= "(".$tot_geral.") total de ".$tot_geral_1." para ".$numlinhas." autor(es) ".$txtpagina.$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="7"></td>
        </tr>
      </table>
    </form>
    </td>
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