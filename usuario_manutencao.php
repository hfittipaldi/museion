<? include_once("seguranca.php");
if($_REQUEST[nivel]=='')
{
 echo "<script>alert('Usuário sem status definido.\\n Altere o cadastro de usuário informando o status deste usuário.')</script>";
 echo "<script>location.href='usuario1.php?op=update&usuario=$_REQUEST[usuario]'</script>";
} 
 ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
?>
<script>
function valida()
{
 with(document.form1){
    if(radio_tipo[0].checked==false && radio_tipo[1].checked==false && radio_tipo[2].checked==false) {
	  alert('Informe a ação que deseja realizar!');
	  return false;
	}
 }
}
</script>  
</head>
<? 
function permissao_adm($p)
{
 global $db;
 $sql="SELECT item from menu_item";
 $db->query($sql);
 while($row=$db->dados())
 {
   $item[]=$row['item'];
 }
 foreach($item as $valor)
 {
   $sql="INSERT INTO usuario_menu_item(usuario,item)values('$p','$valor')";
   $db->query($sql);
 }
}
function permissao_colecao($p)
{
  global $db;
  $sql="SELECT colecao from colecao";
  $db->query($sql);
  while($row=$db->dados())
  {
    $colecao[]=$row['colecao'];
  }
 foreach($colecao as $valor)
 {
   $sql="INSERT INTO usuario_colecao(usuario,colecao) values('$p','$valor')";
   $db->query($sql);
 }
}

if($_REQUEST['submit']<>'')
{
  // usuario=ADMINISTRADOR....fara update das permissoes caso tenha ocorrido alguma inclusao/exclusao de item do menu.
  $sql="DELETE from usuario_menu_item where usuario='$_REQUEST[usuario]'";
  $db->query($sql);
  $sql2="DELETE FROM usuario_colecao where usuario='$_REQUEST[usuario]'";
  $db->query($sql2);
  //
  permissao_adm($_REQUEST[usuario]);
  permissao_colecao($_REQUEST[usuario]);
  echo "<script>alert('Atualização realizada com sucesso')</script>";
  echo "<script>location.href='usuario.php'</script>";
 }
elseif ($_REQUEST['submit2'] <> '') {
	if ($_REQUEST['radio_tipo'] == '1')
		echo "<script>location.href='usuario_perm.php?op=update&usuario=$_REQUEST[usuario]'</script>";
	elseif ($_REQUEST['radio_tipo'] == '2')
		echo "<script>location.href='usuario_colecao1.php?op=update&usuario=$_REQUEST[usuario]'</script>";
	elseif ($_REQUEST['radio_tipo'] == '3')
	   echo "<script>location.href='usuario_copiar.php?op=update&usuario=$_REQUEST[usuario]'</script>";
}
?>

<body>
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
echo $_SESSION['lnk'];
function converte()
{
global $db;
  $sql="select nome from usuario  where usuario='$_REQUEST[usuario]'";
  $db->query($sql);
  $res=$db->dados();
return ucfirst($res[0]);
} 
?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" onSubmit='return valida()'>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td class="texto_bold"> <div align="right"><br>Usuário:</div></td>
          <td width="51%" class="texto" align="left"><br><? echo converte(); ?></td>
          <td width="10%" class="texto_bold" align="right"><br>Status:</td>
          <td width="29%" class="texto" align="left"><br><? if($_REQUEST[nivel]=='A'){echo "Administrador";} else { echo "Usu&aacute;rio"; } ?></td>
        </tr>
        <tr>
          <td colspan="4" class="texto_bold"> </td>
        </tr>
		<?  if($_REQUEST[nivel]=='A') {?>
        <tr>
          <td colspan="4" class="texto_bold"><p align="center">USU&Aacute;RIO ADMINISTRADOR<br>
            Possui acesso completo a todos itens de menus e cole&ccedil;&otilde;es.</p></td>
          </tr>
        <? } ?>
        <? if($_REQUEST[nivel]=='U'){ ?>
		<tr style="display: none;">
          <td style="display: none;">&nbsp;</td>
          <td colspan="3" class="texto_bold" style="display: none;">Selecione a op&ccedil;&atilde;o:</td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td colspan="3" class="texto_bold"><input type="radio" name="radio_tipo" value="1" >
			  Administrar permiss&otilde;es de menu.</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3" class="texto_bold"><input type="radio" name="radio_tipo" value="2">
Administrar cole&ccedil;&otilde;es.</td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td colspan="3" class="texto_bold"><input type="radio" name="radio_tipo" value="3">
            Copiar
              permiss&otilde;es com base nas permiss&otilde;es de um usu&aacute;rio
              existente.</td>
        </tr><? } ?>
        <tr>
          <td colspan="4" align="left"><? echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"?>
            </td>
        </tr>
        <tr>
          <? if($_REQUEST[nivel]=='A') {?>
		  <td colspan="4" align="center"><input name="submit" type="submit" class="botao" id="submit" value="Atualizar Permiss&otilde;es"></td>
          <? } ?>
		  </tr>
        <tr><? if($_REQUEST[nivel]=='U') { ?>
          <td colspan="4" align="center"><input name="submit2" type="submit" class="botao" id="submit2" value="Avan&ccedil;ar"></td>
          <? }  ?>
	    </tr>
		<tr>
			<td colspan="4" class="texto_bold"><input type="text" name="textfield" style="display:none "></td>
		</tr>
      </table>
    </form>
	</td>
  </tr>
</table>
</body>
</html>