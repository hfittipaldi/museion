<?include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>

</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
	if ($movid <> '') {
		$tipo= 'movimentacao';
		$valor= $movid;
		$parametro= 'movid';
	}
	elseif ($obrid <> '') {
		$tipo= 'obra';
		$valor= $obrid;
		$parametro= 'obrid';
	}
	elseif ($autid <> '') {
		$tipo= 'autor';
		$valor= $autid;
		$parametro= 'autid';
	}
	else
		echo "<script>history.back();</script>";



 ?>

<script>
function abrepopBibliografia(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-230)+',top='+((window.screen.height/2)-200)+',width=700,height=440, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}
function posiciona(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('bibliografia_obra.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);

}}
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('bibliografia_obra.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);

//document.location=('bibliografia_obra.php?obrid=<? echo $_REQUEST[obra] ?>&page='+ i);

}}
</script>
<body>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
 <?
	  /////Paginando
	  $pagesize=8;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
          $sql="SELECT count(*) as total from obra_bibliografia as a inner join bibliografia 
                                                  as b on(a.bibliografia=b.bibliografia) where a.obra=".$obrid;
	  $db->query($sql);
	  $numlinhas=$db->dados();
          $numlinhas=$numlinhas[0];
	  /////////////////////
	  $sql2="SELECT a.*,b.bibliografia, b.referencia,b.autoria,b.local,b.editora,b.ano,a.observacao from obra_bibliografia as a inner join bibliografia as b on(a.bibliografia=b.bibliografia)
	   where a.obra=".$obrid." order by b.ano, a.obra_bibliografia, b.referencia asc LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="70%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Referências bibliográficas </div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto">
          <td width="70%"></td>
          <td width="10%"></td>
          <td width="20%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['bibliografia'] ?>">
          <td colspan="2"><? 
                             echo "<b>(".$row[bibliografia].") - </b>".$row[autoria].".&nbsp;<em><b>".htmlentities($row['referencia'], ENT_QUOTES)."</b></em>.&nbsp;".$row[local].",&nbsp;";
			     if ($row[editora]!='')
					echo $row[editora].",&nbsp;";
			     if ($row[ano]!='0'){
					echo $row[ano].".&nbsp;";}
			     else {
					echo "s/d".".&nbsp;";}
                                               if ($row[observacao]!=''){
			        echo $row[observacao].".";}
                          ?></td>
         <td>
           <div align="center"><? echo "<a href=\"bibliografia_obra1.php?op=del&obrid=".$row['obra']."&bib=".$row['bibliografia']."\"
	       onClick='return confirm(".'"Confirma Exclus&atilde;o do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif'
	       border='0' alt='Excluir' 
	       onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
	       onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";?>
	    </div>
         </td>


           <td align="center"><? echo "<a href=\"bibliografia_obra1.php?op=update&obrid=".$row['obra']."&bib=".$row['bibliografia']."\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>"; }?>
		  </td>

        
        </tr>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>

 
          
        </tr>
  


        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td></td>
                        <td colspan="2" nowrap>
                           <? $ref="bibliografia_insere2.php?op=insert&obrid=".$valor;?>

                           <a href='javascript:;' onClick="abrepopBibliografia('<?echo $ref;?>');">
                                <img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Adicionar bibliografia'>
                          </a>
                       </td>
        </tr>


        <tr>
          <td height="1" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
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

$a="<a href=\"bibliografia_obra.php?".$parametro."=".$valor."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"bibliografia_obra.php?".$parametro."=".$valor."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"bibliografia_obra.php?".$parametro."=".$valor."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"bibliografia_obra.php?".$parametro."=".$valor."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de bibliografias para esta obra: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='003366'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
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
