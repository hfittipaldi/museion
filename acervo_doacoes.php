<? include_once("seguranca.php") ?>
<html>
<head>
<title>Acervo / % coleção</title>
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
document.location=('acervo_colecao.php?page='+i);
}}

function posiciona(valor) {
var i = valor;
document.location=('acervo_docoes.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
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

	  $sql="SELECT count(*) as totgeral FROM obra where status='P' and doador<>''";
	  $db->query($sql);
          $row=$db->dados();
          $tot_geral=$row[totgeral];
	 
	  $sql3="select o.doador as doador,count(o.obra) as total,f.nome as forma from obra o,forma_aquisicao f where o.status='P' and o.doador<>'' and o.forma_aquisicao=f.forma_aquisicao group by o.doador order by total desc limit 10";	  
	  $db->query($sql3); 
	 
	 ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="55%" height="24" bgcolor="#96ADBE" class="texto_bold">&nbsp;&nbsp;Doador</td>
          <td width="15%" bgcolor="#96ADBE" class="texto_bold"> <div align="center">Num Obras</div></td>
          <td width="10%" bgcolor="#96ADBE" class="texto_bold"><div align="center">%</div></td>
          <td width="5%" bgcolor="#96ADBE" class="texto_bold"><div align="center">&nbsp;</div></td>
          <td width="15%" bgcolor="#96ADBE" class="texto_bold"><div align="center">Forma</div></td>
        </tr>
        <tr>
          <td colspan="8" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>

      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo "" ?>">
          <td align="justify" width='55%' height="20"><b>&nbsp;<? echo $row[doador] ?></b> 
			</td>
          <td align="right" width='15%'><? echo $row[total] ?></td>
          <td align="right" width='10%'>
		  <? 
		   $percent=($row[total]*100/$tot_geral);
		   echo number_format($percent,2,',','.')."%";
		   ?>
		  </td>
          <td align="center" width='5%'></td>
          <td align="left" width='15%'><? echo $row[forma] ?></td>
        </tr>
       <? } ?>
        <tr class="texto">
          <td colspan="4"></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="8" class="noprint">
                <? echo "<a target='_blank' href=\"acervo_doacoes.php?page=1&pagesize=999999\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?>
                <? echo "<a target='_blank' href=\"graph_perc_doador.php\"><img src='imgs/icons/ic_graph.jpg'  border='0'  alt='Grafico'></a>" ?>
          </td>
        </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="8" height="20">
            <?    
              echo "Total de Obras do Acervo (com Doador): <strong>".$tot_geral."</strong><font color='000000'>$g</font>"; 		  
            ?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="8"></td>
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