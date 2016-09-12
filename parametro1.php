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
 parametro=self.document.form1.parametro.value;
 descricao=self.document.form1.descricao.value;
    if(parametro==''){
	 alert('Preencha com o parâmetro a ser usado');
	 self.document.form1.parametro.focus();
	 return false;}
    if(descricao==''){
	  alert('Preencha com a descrição do parâmetro.');
	  self.document.form1.descricao.focus();
	  return false;}  
  }
</script>  
</head>
<body onload='self.document.form1.parametro.focus()'>      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=base64_decode($_REQUEST['id']);
$op=$_REQUEST['op'];
echo $_SESSION['lnk'];

	?></div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post">
<?
 if(isset($val))
 {
  if($op=='update')
   {
    $sql="SELECT a.* from parametro as a where a.id='$val'";
    $db->query($sql);
     $res=$db->dados();
	}
  if($op=='del')
  {
     $sql="DELETE from parametro  where id='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='parametro.php'</script>";
	 exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="20%"  align="right" class="texto_bold"><br><br><br>Par&acirc;metro:&nbsp; </td>
		  <td class="texto_bold"><br><br><br><input name="parametro" type="text" class="combo_cadastro" id="parametro" value="<? echo $res[parametro] ?>" size="72"></td>
        </tr>
        <tr>
          <td align="right" class="texto_bold">Descri&ccedil;&atilde;o:&nbsp; </td>
		  <td class="texto_bold"><input name="descricao" type="text" class="combo_cadastro" id="descricao" value="<? echo $res[descricao] ?>" size="72"></td>
        </tr>
        <tr  class="texto_bold">
		  <td align="right"> Valor: &nbsp;</td>
          <td> <input name="valor" type="text" size="72" class="combo_cadastro" id="valor" value="<? echo $res[valor] ?>"></td>
        </tr>
        <tr class="texto_bold">
          <td  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor default:&nbsp; 
          <input name="valor_default" type="text" size="72" class="combo_cadastro" id="valor_default" value="<? echo $res[valor_default] ?>"></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="val" type="hidden" id="op" value="<? echo $val ?>">
          
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
          </span></td>
        </tr>
        <tr>
          <td colspan="2"><div align="right"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar" onClick="return valida()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </span></div></td>
        </tr>
        <tr>
          <td>
            <div align="left"><? echo "<a href=\"parametro.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
      <?
if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
     $sql="UPDATE parametro set 
	 parametro='$_REQUEST[parametro]',
	 descricao='$_REQUEST[descricao]',
	 valor='$_REQUEST[valor]', 
	 valor_default='$_REQUEST[valor_default]'
	 where id='$_REQUEST[val]'";
	 
	 $db->query($sql);
	 
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='parametro.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
  
     $sql= "INSERT INTO parametro(parametro,descricao,valor,valor_default)
	  values('".strtoupper($_REQUEST[parametro])."','".$_REQUEST[descricao]."',
	  '".$_REQUEST[valor]."','".$_REQUEST[valor_default]."')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='parametro.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
