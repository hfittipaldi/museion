<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script>
function seta_foco()
{
    form1.data.focus();
	return;
}
function valida()
{
 with(document.form1){
	if (data.value=='') { alert('Preencha a data de retorno!'); data.focus(); return false; }
	if (!Validar_Campo_Data(data,false)) {
		alert('Preencha corretamente o campo "data de retorno"!'); data.focus(); return false;
	}
 }
}

</script>  
</head>

<body onload='seta_foco()'>      
<table width="450" border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <th width="419" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$obrid=$_REQUEST['obra'];
$movid=$_REQUEST['movid'];

if ($_REQUEST[op] == 'limpar') {
	$sql="UPDATE obra_movimentacao set data_retorno='0000-00-00' where obra = '$obrid' AND movimentacao = '$movid'";
	$db->query($sql);
	/*echo"<script>alert('Alteração efetuada com sucesso.')</script>";*/
	echo"<script>location.href='obra_lista_retorno.php?movid=".$movid."'</script>";
}
?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="<? echo $PHP_SELF ?>" onSubmit="return valida()">
<?
   $sql="SELECT data_retorno from obra_movimentacao as a where a.obra = '$obrid' AND a.movimentacao = '$movid'";
   $db->query($sql);
   $res=$db->dados();
	$data= explode("-", $res[0]);
	$dia=$data[2]; $mes=$data[1]; $ano=$data[0];
	$data= $dia."/".$mes."/".$ano;
	if ($data=="00/00/0000" || $data=="//")
		$data= "";
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td colspan="2" class="texto_bold"><div align="left">Data de retorno da obra: &nbsp;              
              <input name="data" type="text" class="combo_cadastro" id="data" value="<? echo $data; ?>" size="20" maxlength="10">
          </div></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="obra" type="hidden" id="obra" value="<? echo $obrid ?>">
	        <input name="oculto" type="text" id="oculto" value="" style="display:none">
          </span></td>
        </tr>
        <tr>
          <td><div align="right"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <div align="left"><? echo "<a href=\"obra_lista_retorno.php?movid=".$movid."\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
      <?
if ($_REQUEST['enviar'] <> '') {
	$data= explode("/", $_REQUEST['data']);
	$dia=$data[0]; $mes=$data[1]; $ano=$data[2];
	$data= $ano."-".$mes."-".$dia;
	if ($data == "--")
		$data= "00-00-0000";
     $sql="UPDATE obra_movimentacao set data_retorno='$data' where obra = '$obrid' AND movimentacao = '$movid'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='obra_lista_retorno.php?movid=".$movid."'</script>";
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>