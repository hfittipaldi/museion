<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function fecha_pop()
{
 setTimeout('window.close()',60000);

 return true;
}
function cancela()
{
window.opener.location.reload();

document.form1.cancelar.submit=window.close();


  return true;
}

</script>
</head>
<?
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");

	$db=new conexao();
	$db->conecta();

              $dbreg=new conexao();
              $dbreg->conecta();

              $dbbib=new conexao();
              $dbbib->conecta();
      ?>
<script>window.opener.location.reload();</script>
<?
	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
        $nome = $_REQUEST['nome'];
        $autoria = $_REQUEST['autoria'];
        $tipo=$_REQUEST['tipo'];

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

	$expid= $_REQUEST['bib'];
                if ($autid<>'') {$tipo=='autor';}
                if ($obrid<>'') {$tipo=='obra';}
                if ($moviid<>'') {$tipo=='movimento';}
      
    if ($tipo == 'autor') $href='bibliografia';
    if ($tipo == 'obra')  $href='bibliografia_obra';


	
 ?>

<script>


function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;

document.location=('bibliografia_insere2.php?<? echo $parametro; ?>=<? echo $valor; ?>&nome=<?echo $nome?>&autoria=<?echo $autoria?>&page='+ i);

}}
</script>


<body onLoad="fecha_pop(); document.form1.".$href."focus();">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr>
       <td valign="top">
       <form name="form1" method="post" action="">
            <?
	       /////Paginando
	      $pagesize=5;
              $page=1;
              if(!empty($_GET['page']))
                 $page=$_GET['page'];
              $page--;
	      $registroinicial=$page* $pagesize;

	      if ($_REQUEST[nome] <> '')
              { $WhereNome="(referencia like '%$_REQUEST[nome]%')";
              } else {
                $WhereNome='';
              }
              if ($_REQUEST[autoria] <> '')
               { $WhereAutoria= "(autoria like '%$_REQUEST[autoria]%')";
               } else {
                 $WhereAutoria='';
               }
  
              if ($WhereNome<>'') { 
                  $WhereNome=" where ".$WhereNome;
                  if ($WhereAutoria <>'') $WhereAutoria=' AND '.$WhereAutoria;
               }else{            
                  if ($WhereAutoria <>'') $WhereAutoria=' Where '.$WhereAutoria;
               }
              
              if (($WhereNome<>'') or ($WhereAutoria<>'')){
	      $sql= "SELECT count(*) from bibliografia ".$WhereNome.$WhereAutoria." order by referencia";
              
	      $db->query($sql);
	      $numlinhas=$db->dados();
              $numlinhas=$numlinhas[0];
	      ////////////////////
	      }else{$numlinhas=0;}
	      
              $sql2= "SELECT * from bibliografia ".$WhereNome.$WhereAutoria." order by referencia LIMIT $registroinicial,$pagesize";
	      $db->query($sql2);
              ////////////////////
	  
          ?>
          <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
             <tr><td><br></td></tr>
                    <tr bgcolor="#96ADBE">
                       <td colspan="3"width="100%" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100%" height="1"></td>
                    </tr>

                     <tr width="100%" bgcolor="#96ADBE">
                        <td colspan="3" height="24" bgcolor="#96ADBE" class="texto_bold" style="color: white;"><div align="left"> &nbsp;Pesquisa de Bibliografia a Vincular</div></td>
                     </tr>
                     <tr width="100%">
                       <td colspan="3"width="100%" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
                     </tr>
                 <tr><td><br></td></tr>
	     <tr>
               
	      <td width="47%" class="texto_bold" valign="top">&nbsp;Referência:&nbsp;<input type="text" name="nome" value="<? echo $nome;?>" size="40" class="combo_cadastro"> </td>
              <td width="5%">&nbsp;</td>           
              <td width="47%" class="texto_bold">Autoria:&nbsp;<input name="autoria" type="text" class="combo_texto" size="34" value="<?echo $autoria;?>"> 
                      <input type="submit" name="find" value="Avançar" class="botao" >
               </td>
             </tr>
                  <tr><td><br></td></tr>
                     <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">

                       <tr bgcolor="#96ADBE">
                          <td whidth=100%   bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="200%" height="1"></td>
                       </tr>
                       <tr whidth=100% bgcolor="#ddddd5">
                          <td width="50%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Bibliografia </div></td>
		       </tr>
                       <tr>
                          <td  whidth=100% height="2" bgcolor="#000000" ><img src="imgs/transp.gif" width="200%" height="1"></td>
                       </tr>




          </table>       
          <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >

 
   	     <? 
                while($row=$db->dados())
	        {
              if (($_REQUEST[nome]<>"") or ($_REQUEST[autoria])<>""){

	     ?>

             <tr class="texto">
                <td width="90%"></td>
                <td width="10%"></td>
             </tr>
              <tr class="texto" id="cor_fundo<? echo $row['bibliografia']; ?>">
               <td colspan="2"><? 
                            echo "<b>(".$row[bibliografia].") - </b>".$row[autoria].".&nbsp;<em><b>".htmlentities($row['referencia'], ENT_QUOTES)."</b></em>.&nbsp;".$row[local].",&nbsp;";
			     if ($row[editora]!='')
					echo $row[editora].",&nbsp;";
			     if ($row[ano]!='0'){
					echo $row[ano].".&nbsp;";}
			     else {
					echo "s/d".".&nbsp;";} 

                                ?></td>


         <td align="center"><? echo "<a href=\"bibliografia_observacao.php?nome=".$_REQUEST[nome]."&".$parametro."=".$valor."&tipo=".$tipo."&bib=".$row[bibliografia]."\">
						<img src='imgs/icons/ic_adicionar.gif' border='0' alt='Adicionar à lista' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";?>
                </td>
  
               
                </tr>

     <? echo "<script>opener.window.document.getElementById('bibliografia').value=".$row['bibliograifa']."
         </script>";?></option>


   
             </td> 
              
         </tr>
	<?}} ?>

        <tr class="texto">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td height="1" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>

        <tr class="texto">
          <td colspan="4" height="20">
           <? 
		   
//////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"bibliografia_insere2.php?".$parametro."=".$valor."&nome=".$nome."&autoria=".$autoria."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'    border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"bibliografia_insere2.php?".$parametro."=".$valor."&nome=".$nome."&autoria=".$autoria."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0'  alt='Registro Anterior' ></a>";

$c="<a href=\"bibliografia_insere2.php?".$parametro."=".$valor."&nome=".$nome."&autoria=".$autoria."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'    border='0'  alt='Proximo Registro' ></a> ";

$d="<a href=\"bibliografia_insere2.php?".$parametro."=".$valor."&nome=".$nome."&autoria=".$autoria."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'     border='0'  alt='Ultimo Registro' ></a>";
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
 $g= " Total de bibliografias para esta obra: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='003366'>$g</font>"; 	             
             ?>               
             <div align="center"></div>
             </td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>

          <td colspan="0" align="center" class="texto">
            <div align="center">
              <input name="cancelar" type="submit" class="botao" id="cancelar" value="Cancelar" onClick="cancela()">

            </div></td>

  

      </table>
   </form>





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