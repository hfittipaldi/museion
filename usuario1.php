<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
<!--
function valida() {
  nome=self.document.form1.nome.value;
  email=self.document.form1.email.value;
  loguser=self.document.form1.loguser.value;
  senha = self.document.form1.senha.value;
  nivel=self.document.form1.nivel.value;   
  if (nome == ''){
    alert('O campo nome é obrigatório.');
    self.document.form1.nome.focus();
    return false;
  }
  if (loguser == ''){
    alert('O campo de login é obrigatório.');
    self.document.form1.loguser.focus();
    return false;
  }
   if(senha==''){
    alert('O campo senha é obrigatório.');
	self.document.form1.senha.focus();
	return false;
 }
 if(!self.document.form1.status[0].checked && !self.document.form1.status[1].checked){
	  alert ('Informe o status da conta.');
	  return false;
   }
 if(nivel=='#'){
    alert('O campo status é obrigatório.');
	self.document.form1.nivel.focus();
	return false;
 }
  return true;
}
// -->
</script> 
</head>
<body >      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=$_REQUEST['usuario'];
$op=$_REQUEST['op'];	
echo $_SESSION['lnk'];

	?></div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="<? echo $PHP_SELF ?>">

<?
 if(isset($_REQUEST[usuario]))
 {
  if($op=='update')
   {
    $sql="SELECT a.* from usuario as a where a.usuario='$_REQUEST[usuario]'";
	$db->query($sql);
    while($res=$db->dados())
	{
	 $nome=$res[nome];
	 $dianiver=$res[dianiver];
	 $mesniver=$res[mesniver];
	 $ano=$res[ano];
	 $email=$res[email];
	 $loguser=$res[login];
	 $senha=$res[senha];
	 $status=$res[status];
	 $nivel=$res[nivel];
	 }
 }
  if($op=='del')
  {
     $sql="DELETE from usuario where usuario='$_REQUEST[usuario]'";
	 $db->query($sql);
	 $sql2="DELETE from usuario_menu_item where usuario='$_REQUEST[usuario]'";
	 $db->query($sql2);
	 $sql3="DELETE from usuario_colecao where usuario='$_REQUEST[usuario]'";	
	 $db->query($sql3); 
	 echo"<script>alert('Exclusão realizada com sucesso!')</script>";
	 echo"<script>location.href='usuario.php'</script>";
	 exit();
   }
 }	 
?>

<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td height="30" colspan="3" class="texto_bold"><br><br>&nbsp;&nbsp;&nbsp;Nome:&nbsp;              
            <input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo $nome ?>" size="57">
</td>
        </tr>
        <tr class="texto_bold">
          <td colspan="3">&nbsp;&nbsp;&nbsp;Nascimento:&nbsp;
            <input name="dianiver" type="text" class="combo_cadastro" id="dianiver" value="<? echo $dianiver ?>" size="2" maxlength="2">
            &nbsp;/&nbsp;
            <input name="mesniver" type="text" class="combo_cadastro" id="mesniver" value="<? echo $mesniver  ?>" size="2" maxlength="2"> 
            &nbsp;/&nbsp;
            <input name="ano" type="text" class="combo_cadastro" id="ano" value="<? echo $ano ?>" size="4" maxlength="4"></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="3">&nbsp;&nbsp;&nbsp;Email:&nbsp;
            <input name="email" type="text" class="combo_cadastro" id="email" value="<? echo $email ?>" size="57"></td>
        </tr>
        <tr class="texto_bold">
          <td width="40%">&nbsp;&nbsp;&nbsp;Login:&nbsp;
            <input name="loguser" type="text" class="combo_cadastro" id="loguser" value="<? echo $loguser ?>" size="20"></td>
          <td width="53%">Senha:&nbsp;
            <input name="senha" type="password" class="combo_cadastro" id="senha" value="<? echo $senha ?>" size="15">
&nbsp; </td>
          <td width="7%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td>&nbsp;&nbsp;&nbsp;Ativo?&nbsp;
            <input name="status" type="radio" value="S"  <? if($status=='S'){echo "checked";} ?>>
            SIM 
            <input name="status" type="radio" value="N"  <? if($status=='N'){echo "checked";} ?>>
N&Atilde;O </td>
          <td>Status:&nbsp;
			<? if ($nivel == 'P') { ?>
				&nbsp;Perfil<input type="hidden" name="nivel" value="P">
			<? } else { ?>
            <select name="nivel" class="combo_cadastro">
              <option value="#"></option>
              <option value="A" <? if($nivel=='A') echo "Selected"; ?>>Administrador</option>
              <option value="U" <? if($nivel=='U') echo "Selected";?>>Usu&aacute;rio</option>
            </select> <? } ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" class="texto_bold"></td>
        </tr>
        <tr>
          <td colspan="3" class="texto_bold">
		  <?
		 /* if($_REQUEST[op]=='update')
		  {		   echo "<a href=\"usuario_perm.php?op=$_REQUEST[op]&usuario=$_REQUEST[usuario]\" style='color: navy;'>Administrar Permissões</a> | 
		  <a href='usuario_colecao1.php?op=update&id=$_REQUEST[usuario]' style='color: navy;'>Administrar Coleções</a>";}*/
		  ?></td>
        </tr>
        <tr>
          <td colspan="2"><div align="center"><span class="texto_bold">
              <input name="val" type="hidden" id="op" value="<? echo $_REQUEST[usuario] ?>">
              <input name="op" type="hidden" id="op" value="<? echo $op ?>">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar" onClick="return valida()">
          </span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">
            <div align="left"><? echo "<a href=\"javascript:history.back();\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
<?
// seta direto todas as permissoes caso o usuario seja administrador.

function permissao_adm($p)
{
 global $db,$id;
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
if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
    if($_REQUEST[nivel]=='A')
	{ 
	  $sql="DELETE from usuario_menu_item where usuario='$_REQUEST[usuario]'"; // apaga para gerar as novas configuracoes completas
	  $db->query($sql);
	   $sql2="DELETE FROM usuario_colecao where usuario='$_REQUEST[usuario]'";
      $db->query($sql2);
	  //
	  permissao_adm($_REQUEST[usuario]);
	  permissao_colecao($_REQUEST[usuario]);
	}
     $sql="UPDATE usuario set
	  nome='$_REQUEST[nome]',
	  dianiver='$_REQUEST[dianiver]',
	  mesniver='$_REQUEST[mesniver]',
	  ano='$_REQUEST[ano]',
	  email='$_REQUEST[email]',
	  login='$_REQUEST[loguser]',
	  senha='$_REQUEST[senha]',
	  status='$_REQUEST[status]',
	  nivel='$_REQUEST[nivel]'
	                    where usuario='$_REQUEST[usuario]'";
				
	$db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='usuario.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
     $sql= "INSERT INTO usuario(nome,dianiver,mesniver,ano,email,login,senha,status,nivel) 
	 values('$_REQUEST[nome]','$_REQUEST[dianiver]','$_REQUEST[mesniver]','$_REQUEST[ano]',
	 '$_REQUEST[email]','$_REQUEST[loguser]','$_REQUEST[senha]','$_REQUEST[status]','$_REQUEST[nivel]')";
	 $db->query($sql);
	 $id=$db->lastid();
	 $msg="<script>alert('Inclusão realizada com sucesso.')</script>";
	
	 if($_REQUEST[nivel]=='A')
	 { 
	    permissao_adm($id); 
	    $dest="<script>location.href='usuario.php'</script>";
	    echo $msg;
		echo $dest;
	 }
	 elseif($_REQUEST[nivel]=='U'){
	  
	  $dest="<script>location.href='usuario_permissao.php?usuario=$id&nivel=$_REQUEST[nivel]&op=$_REQUEST[op]'</script>";
	  echo $msg;
	  echo $dest; 
	 /*echo"<script>location.href='usuario_perm.php?user=$id&op=$_REQUEST[op]'</script>";*/
	 
	 }
	}
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
