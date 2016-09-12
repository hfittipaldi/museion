<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

<script>
function seta_foco()
{
    form1.sigla.focus();
	return;
}
function valida()
{
 with(document.form1){
    if(sigla.value==''){
	  alert('Preencha com a sigla (1 caractere).');
	  sigla.focus();
	  return false;}
    if(nome.value==''){
	  alert('Preencha com a forma de aquisição.');
	  nome.focus();
	  return false;}
 }
}

</script>  
</head>

<body onload='seta_foco()'>      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=base64_decode($_REQUEST['aquisicao']);
$op=$_REQUEST['op'];
echo $_SESSION['lnk'];
?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="<? echo $PHP_SELF ?>" onSubmit="return valida()">
<?
if(isset($val))
{ 
 if($op=='update')
 {
   $sql="SELECT * from forma_aquisicao as a where a.forma_aquisicao='$val'";
   $db->query($sql);
   $res=$db->dados();
  }
 if($op=='del')
 {
     $sql="DELETE from forma_aquisicao where forma_aquisicao='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='aquisicao.php'</script>";
	 exit();
  }	 
}
	 ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td colspan="2" class="texto_bold"><div align="left"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sigla: &nbsp;              
              <input name="sigla" type="text" class="combo_cadastro" id="sigla" value="<? echo $res[0] ?>" size="2" maxlength="1">
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo: &nbsp;&nbsp;              
              <input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo htmlentities($res[1], ENT_QUOTES); ?>" size="78">
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo em Inglês: &nbsp;              
              <input name="nome_ing" type="text" class="combo_cadastro" id="nome_ing" value="<? echo htmlentities($res[2], ENT_QUOTES); ?>" size="67">
          </div></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="val" type="hidden" id="op" value="<? echo $val ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
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
            <div align="left"><? echo "<a href=\"aquisicao.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
      <?
/* Essa funcao nao esta sendo usada temporariamente.
function verifica_existencia($valor)
{
global $db;
  $sql="select distinct(tema) from tema as a where a.tema='".trim($_REQUEST[sigla])."'";
 // echo $sql;
  $db->query($sql);
  $res=$db->contalinhas();
  //echo $res;
if($res >0)  {
 echo "<script>alert('Erro.Registro já cadastrado!')</script>";
 echo"<script>location.href='tema.php'</script>";
 exit();}
 
else{
 return $valor;}
}   */
if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
     $sql="UPDATE forma_aquisicao set nome_ing='$_REQUEST[nome_ing]',nome='$_REQUEST[nome]', forma_aquisicao='$_REQUEST[sigla]' where forma_aquisicao='$_REQUEST[val]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='aquisicao.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert')
  {
     $sql= "INSERT INTO forma_aquisicao(forma_aquisicao,nome, nome_ing) values('$_REQUEST[sigla]', '".trim($_REQUEST[nome_ing])."', '".trim($_REQUEST[nome])."')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='aquisicao.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
