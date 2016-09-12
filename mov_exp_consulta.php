<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function abrepop(janela)
{
	win=window.open(janela,'lista','left='+((window.screen.width/2)-175)+',top='+((window.screen.height/2)-175)+',width=350,height=350, scrollbars=yes, resizable=no');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}
</script>  
</head>
<body>      
<table width="100%" border="0" cellpadding="0" cellspacing="8">
  <tr>
    <td width="519" valign="top"><form name="form1" method="post" onSubmit='' >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
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
	echo "<script>alert('Tipo não informado!'); history.back();</script>";

$id= $_REQUEST['id'];
$op= $_REQUEST['op'];

if ($tipo) {
  if ($op == 'view') {
    $sql="SELECT * from exposicao where exposicao='$id'";
    $db->query($sql);
    $row=$db->dados();
  }
 }

?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr class="texto">
          <td width="17%" valign="top"><div align="right">Tipo:</div></td>
          <td colspan="2" id="arealegado"><b><? if($row[tipo]=='C') { echo "Coletiva"; }
		     elseif($row[tipo]=='I') { echo "Individual"; }
		   ?></b></td>
          <td width="1%" align="right" valign="top">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td valign="top"><div align="right">Data ref.:</div></td>
          <td colspan="2" id="arealegado"><b><? echo "de " . formata_data($row[dt_inicial]) . " a " . formata_data($row[dt_final]); ?></b></td>
          <td valign="top" align="right">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td valign="top"><div align="right">Nome:</div></td>
          <td colspan="2" id="arealegado"><b><? echo str_replace('"',chr(ord('"')),$row[nome]); ?></b></td>
          <td valign="top" align="right">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td valign="top"><div align="right">Institui&ccedil;&atilde;o:</div></td>
          <td colspan="2" id="arealegado"><b><? echo $row[instituicao] ?></b></td>
          <td valign="top" align="right">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td valign="top"><div align="right">Pa&iacute;s:</div></td>
          <td colspan="2" id="arealegado"><b><? 
					  $sql="SELECT nome from pais where pais='$row[pais]'"; 
					  $db->query($sql);
					  $row2=$db->dados();
					  echo $row2['nome'];
		 ?></b></td>
          <td valign="top" align="right">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td valign="top"><div align="right">Cidade: </div></td>
          <td colspan="2" id="arealegado"><b><? echo $row[cidade] ?></b></td>
          <td valign="top" align="right">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td valign="top"><div align="right">Estado:</div></td>
          <td colspan="2" id="arealegado"><b><? 
		  $sql="SELECT uf from estado where estado='$row[estado]'";
		  $db->query($sql);
		  $row2=$db->dados();
		  echo $row2['uf'];
	 ?></b></td>
          <td valign="top" align="right">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td valign="top"><div align="right">Per&iacute;odo:</div></td>
          <td colspan="2" id="arealegado"><b><? echo $row[periodo] ?></b></td>
          <td valign="top" align="right">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td valign="top">&nbsp;</td>
          <td id="arealegado">&nbsp;</td>
          <td width="45%">&nbsp;</td>
          <td valign="top" align="right">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td valign="top"><br>
		  <? 
		   echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar'>";
		  ?></td>
		  <? if ($row[txt_legado]<>'') { ?>
          <td colspan="2" id="arealegado"><? //echo $row[txt_legado]; ?></td>
          <? } else { ?>
          <? } ?>
          <td valign="top" align="right">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2"><div align="right">
          </div></td>
        </tr>
      </table>
		</form>
	</td>
  </tr>
</table>
</body>
</html>