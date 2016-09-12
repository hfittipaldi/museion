<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language=JavaScript>
<!--
function valida() {
  nome = self.document.form1.nome.value;
  login = self.document.form1.logi.value;
  senha = self.document.form1.senha.value;
  cfsenha = self.document.form1.cfsenha.value;
  if (nome == ''){
    alert('O campo Nome é obrigatório.');
    self.document.form1.nome.focus();
    return false;
  }
  if (login == ''){
    alert('O campo Login é obrigatório.');
    self.document.form1.logi.focus();
    return false;
  }
  if (senha == ''){
    alert('O campo senha é obrigatório.');
    self.document.form1.senha.focus();
    return false;
  }
 if(cfsenha==''){
    alert('O campo para confirmação de senha é obrigatório.');
	self.document.form1.cfsenha.focus();
	return false;
 }
  if (senha != cfsenha) {
    alert('Você digitou duas senhas diferentes. Por favor, tente novamente.');
    self.document.form1.senha.value = '';
    self.document.form1.cfsenha.value = '';
    self.document.form1.senha.focus();
    return false;
  }
/*  if (senha == self.document.form1.senha_original.value) {
     alert('A senha não foi alterada');
	 self.document.form1.senha.focus();
	 return false;
  }*/
  return true;
}
// -->
</script>
</head>
<body>      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=base64_decode($_REQUEST['relac']);
$id_sessao=$_SESSION[susuario];
if($_REQUEST['submit']==true)
{
     $sql="UPDATE usuario set nome='$_REQUEST[nome]', senha='$_REQUEST[senha]', login='$_REQUEST[logi]' where usuario='$id_sessao'";
	$db->query($sql);
	echo"<script>alert('Alteração realizada com sucesso!')</script>";
}
else
montalinks();
$sql="SELECT a.* from usuario as a where a.usuario='$id_sessao'";
$db->query($sql);
$res=$db->dados();
	?>
	  </div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="<? echo $PHP_SELF ?>">
	  <table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr> 
	     <br>  <td class="texto_bold" align="right">Nome: </td>
           <td class="texto_bold"><input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo $res[nome] ?>" size="40"></td>
        </tr>
        <tr class="texto_bold">
          <td align="right">Login: </td>
		  <td><input name="logi" type="text" class="combo_cadastro" id="logi" value="<? echo $res[login] ?>" size="40"></td>
        </tr>
        <tr class="texto_bold">
          <td align="right">Senha: </td>
          <td><input name="senha_original" type="hidden" id="senha_original" value="<? echo $res[senha] ?>">
            <input name="senha" type="password" class="combo_cadastro" id="senha" value="<? echo $res[senha] ?>" size="12" ></td>
        </tr>
        <tr class="texto_bold">
          <td align="right">Confirmar senha: </td>
          <td><input name="cfsenha" type="password" class="combo_cadastro" id="cfsenha" value="<? echo $res[senha] ?>" size="12"></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="id" type="hidden" id="op" value="<? echo $id_sessao ?>"></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><input name="submit" type="submit" class="botao"  value="Gravar" onClick="return valida()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td>
            <div align="left">
            </div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
 </form>
	</td>
  </tr>
</table>

</body>
</html>
