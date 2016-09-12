<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function valida()
{
 with(document.form1)
 {
  if(titulo.value=='' && numregistro.value=='')
  {
    alert('Escolha uma das duas opções.')
	return false;
  }
}}
</script>
</head>
<body onLoad="document.form1.numregistro.focus();"> 
<? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
?><br><br>
<table width="519" height="60%"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td width="519" height="300" valign="top"><form name="form1" method="post">
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="1" ><div align="center">
        <tr>
          <td colspan="4" class="tit_interno"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alteração de local fixo das obras</div><br></td>
	</tr>
        <tr>
          <td colspan="4" class="texto"><em><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selecione o tipo
              de busca abaixo para refinar a pesquisa da obra a ser alterada:</em></div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2">&nbsp;</td>
          <td width="24%">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td colspan="4"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&ordm; de Registro: 
            
            <input name="numregistro"  align="center" type="text" class="combo_texto" id="numregistro" size="20" ></td>
        </tr>
        <tr>
          <td colspan="4" class="texto"><div align="left"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ou<em></div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="4">    <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T&iacute;tulo da Obra:
             
            <input name="titulo" type="text" class="combo_texto" id="titulo" size="65" ></td>
        </tr>
        <tr>
          <td colspan="4">
          </span></td>
        </tr>
        <tr>
          <td colspan="4"><div align="center"><span class="texto_bold">
            <br><input name="procurar" type="submit" class="botao" id="enviar" value="Procurar" onClick="return valida();">
          </span></td>
        </tr>
			<?
			    $sql="SELECT count(*) as total from obra where status = 'C' AND catalogado = '$_SESSION[susuario]'";
				 $db->query($sql);
				 $tot=$db->dados();
				if ($tot['total'] > 0) { 
			?>
        <tr class="texto_bold">
          <td colspan="2">&nbsp;</td>
          <td width="24%">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" height="25" bgcolor="#FFFF66"  class="texto_bold"><div align="center">Catalogador com &nbsp;<font style='color: navy;'><? echo $tot['total']; ?></font>&nbsp; obra(s) não-publicada(s) </div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2">&nbsp;</td>
          <td width="24%">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center"><span class="texto_bold">
            <input name="catal" type="submit" class="botao" id="catal" value="Listar obras em catalogação"><br><br>
          </span></td>
        </tr>
			<? } ?>
        <tr>
          <td colspan="4"><div align="left"><span class="texto_bold">
</span></div>
            <div align="left"><span class="texto_bold">
          </span></div></td>
          </tr>
        <tr>
          <td colspan="3">
            <div align="right"><span class="texto_bold"><span class="tit_interno">
            </span>
              </span>
                <input type="text" name="textfield" style="display:none ">
            </div></td>
          <td width="42%"><span class="texto_bold">
          </span></td>
        </tr>
      </table>
      <br>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
<? 
if($_REQUEST[procurar]<>'')
{
 if($_REQUEST[numregistro]<>'' || $_REQUEST[titulo]<>'')
 {
    $sql="SELECT * from obra where (num_registro = '$_REQUEST[numregistro]' or num_registro like '$_REQUEST[numregistro] %' or '$_REQUEST[numregistro]'='')  AND 
	(titulo like '%$_REQUEST[titulo]%' or '$_REQUEST[titulo]'='')";
 $db->query($sql);
 $conta=$db->contalinhas();
 $res=$db->dados();
  if($conta==0) { 
    echo"<script> alert('Registro não encontrado!')</script>";}
  if($conta==1)
	    echo"<script>location.href='cadastrobra_reserva.php?op=update&obra=$res[obra]'</script>";
  if($conta>1){
   echo "<script>location.href='obra_ocorrencia_altera_reserva.php?titulo=$_REQUEST[titulo]&numregistro=$_REQUEST[numregistro]'</script>"; }
 }
}


if($_REQUEST[catal]<>'')
{
    $sql="SELECT * from obra where status = 'C' AND catalogado = '$_SESSION[susuario]'";
	$db->query($sql);
	$conta=$db->contalinhas();
	$res=$db->dados();
  if($conta==0) { 
    echo"<script> alert('Nenhum registro encontrado!')</script>"; 
  }
  else {
   echo "<script>location.href='obra_ocorrencia_altera_reserva.php?emcatalog=1'</script>"; }
 }

?>