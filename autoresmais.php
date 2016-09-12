<? include_once("seguranca.php") ?>
<html>
<head>
<title>Autores Mais Consultados</title>
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
document.location=('autoresmais.php?page='+ i+ '&dt_ini=<? echo $_REQUEST[dt_ini]; ?>&dt_fim=<? echo $_REQUEST[dt_fim]; ?>');
 }
}

function posiciona(valor) {
var i = valor;
document.location=('autoresmais.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}

function valida(){
    var mensagem = "";
    var form  = document.form2;
    var campo = "";
    var num_elementos =  form.elements.length;
     for (var i = num_elementos-1; i >= 0 ; i--){	  	   
     var elemento = form.elements[i];
        if (elemento.name == "dt_ini"){
          if(IsEmpty(elemento))
		  {
		    campo = elemento;
            mensagem = "Informe a data inicial \n\n" + mensagem ;
		  }
	      if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data Inicial inválida (dd/mm/aaaa) \n\n" + mensagem;
          }
		  continue;
        }

        if (elemento.name == "dt_fim"){
		   if(IsEmpty(elemento))
		  {
		    campo = elemento;
            mensagem = "Informe a data final \n\n" + mensagem ;
		  }
          if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data Final inválida (dd/mm/aaaa) \n\n" + mensagem;
          }
		  continue;
        }
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
  	win=window.open('consulta_obra.php?nosave=1&titulo='+title+'&obra='+idobra,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-130)+',height=400,width=740,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
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
$db2=new conexao();
$op=$_REQUEST['op'];
if ($_REQUEST[pagesize] < 999) {
montalinks();
}
$_SESSION['lnk']=$link;

function exibeDataNegativa($valor) {
	if ($valor < 0)
		return substr($valor,1) . " aC";
	else
		return $valor;
}
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
		  $sql="SELECT count(distinct a.autor) as total from log_pesquisa as a,autor as b where (a.autor=b.autor) and
		        a.autor<>0 ";
		//  echo $sql;
		//  exit;
/*		  $sql2="SELECT a.autor,a.log_pesquisa,b.nomeetiqueta,b.pais_nasc,b.estado_nasc,b.cidade_nasc,b.dt_nasc_tp,
		          b.dt_nasc_di,b.dt_nasc_df,b.dt_nasc_tp,count(*) as total FROM (log_pesquisa AS a, autor AS b) 
			         WHERE (a.autor=b.autor)group by a.autor order by count(*) desc LIMIT $registroinicial,$pagesize"; */
		  $sql2="SELECT a.autor,a.log_pesquisa,b.nomeetiqueta,b.pais_nasc,b.estado_nasc,b.cidade_nasc,b.dt_nasc_tp,
		          b.dt_nasc_ano1,b.dt_nasc_ano2,b.dt_nasc_tp,sum(A.quantidade) as total FROM (log_pesquisa AS a, autor AS b) 
			         WHERE (a.autor=b.autor)group by a.autor order by sum(A.quantidade) desc LIMIT $registroinicial,$pagesize";
		
		  //$dt_ini= date("d/m/Y", mktime(0, 0, 0, date("m"), date("d")-6, date("Y")));
		  //$dt_fim= date("d/m/Y");
		}
		else {
		  $dti=seta_data($_REQUEST[dt_ini]);
		  $dtii=seta_data($_REQUEST[dt_fim]);
		  
		  $sql="SELECT count(distinct a.autor) as total from log_pesquisa as a,autor as b where (a.autor=b.autor) and a.autor <> 0 
		  and a.data_hora>='$dti' and a.data_hora < DATE_ADD('$dtii',INTERVAL 1 DAY)";
		
		  $sql2="SELECT a.autor,a.log_pesquisa,b.nomeetiqueta,b.pais_nasc,b.estado_nasc,b.cidade_nasc,b.dt_nasc_tp,
		          b.dt_nasc_ano1,b.dt_nasc_ano2,b.dt_nasc_tp,sum(A.quantidade) as total FROM (log_pesquisa AS a, autor b) 
			        WHERE (a.autor=b.autor) and a.data_hora >='$dti' and a.data_hora < DATE_ADD('$dtii',INTERVAL 1 DAY) 
		                group by b.autor order by sum(A.quantidade) desc LIMIT $registroinicial,$pagesize";
					  //echo $sql2;
					  // exit; 
		}
		  $db->query($sql);
		  $numlinhas=$db->dados();
          $numlinhas=$numlinhas[0];

		  $db->query($sql2);
	   ?>
  <tr>
    <td valign="top" class="texto_bold"><form name="form2" method="get" action="autoresmais.php" onSubmit="return valida()">
      <div align="right"><? if ($_REQUEST[pagesize] >= 999) { echo "Autores mais consultados no "; } ?>Per&iacute;odo de busca: de
		<? if ($_REQUEST[pagesize] < 999) { ?>
          <input name="dt_ini" type="text" class="combo_cadastro" id="dt_ini" maxlength="10" size="10" value="<? echo $_REQUEST[dt_ini] ?>"> 
		<? } else { echo $_REQUEST[dt_ini]; } ?>
        at&eacute; 
		<? if ($_REQUEST[pagesize] < 999) { ?>
        <input name="dt_fim" type="text" class="combo_cadastro" id="dt_fim" maxlength="10" size="10" value="<? echo $_REQUEST[dt_fim] ?>">
        &nbsp;&nbsp;<input name="submit" type="submit" class="combo_cadastro" value=" Ok " style="cursor: pointer; border-width: 1px;">
		<? } else { echo $_REQUEST[dt_fim]; } ?>
      </div>
    </form></td>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="11%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">  &nbsp; Autor </div></td>
          <td width="64%" bgcolor="#ddddd5" class="texto_bold"><div align="left"></div></td>
          <td width="14%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Consultas</div></td>
          <td width="11%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {

	  ?>
        <tr id="cor_fundo<? echo $row['autor'] ?>" class="texto">
          <td colspan="2" align="left"><b><? echo $row['nomeetiqueta'] ?></b>
	- <? $nasc='';
					$sql="SELECT nome from pais where pais = '$row[pais_nasc]'";
					$db2->query($sql);
					$pais= $db2->dados();
					$pais= $pais['nome'];
					if (strtoupper($pais) == 'BRASIL') {
						$sql= "SELECT uf from estado where estado = '$row[estado_nasc]'";
						$db2->query($sql);
						$estado= $db2->dados();
						$estado= $estado['uf'];
						$nasc.= $row[cidade_nasc].", ".$estado." ";
					}
					else {
						if ($row[cidade_nasc]=='?' && $pais=='?')
							$nasc.= "? ";
						else
							$nasc.= $row[cidade_nasc].", ".$pais." ";
					}

					if ($row[dt_nasc_tp] == 'circa')
						$nasc.= " circa ";

					if ($row[dt_nasc_ano1] <> '0') {
						$nasc.= exibeDataNegativa($row[dt_nasc_ano1]);
					}
					if ($row[dt_nasc_ano2] <> '0') {
						if ($row[dt_nasc_ano2] <> $row[dt_nasc_ano1])
						$nasc.= " / ".exibeDataNegativa($row[dt_nasc_ano2]);
					}

					if ($row[dt_nasc_tp] == '?')
						$nasc.=" (?) ";
				echo $nasc;
				?>            
  <div align="center"></div></td>
          <td align="left" width='14%'> 
            <div align="center"><? echo $row[total] ?></div></td>
          <td align="center" width='11%'><div align="center">
     <? // nao passar op=view senao fara insert em log_pesquisa 
	 if ($_REQUEST[pagesize] < 999) echo "<a href=\"consulta_autor.php?id=".$row['autor']."&nosave=1\"> 
	 <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informa&ccedil;&otilde;es' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>";} ?>
          </div></td>
        </tr>
        <tr class="texto">
          <td width="53%"></td>
          <td width="22%"></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="2" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"autoresmais.php?pagesize=999999&page=1&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
          <td></td>
          <td align="center">&nbsp;</td>
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

$a="<a href=\"autoresmais.php?page=".$first."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"autoresmais.php?page=".$menos."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"autoresmais.php?page=".$mais."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"autoresmais.php?page=".$last."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$txtpagina= "";
if ($_REQUEST[pagesize] < 999) {
	$txtpagina= "- Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;";
}

$g= " Total de autores encontrados: $numlinhas ".$txtpagina.$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
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
