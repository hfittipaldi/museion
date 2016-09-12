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
    form1.uf.focus();
	return;}
function valida()
{
 with(document.form1){
    if(uf.value==''){
	  alert('Preencha com a UF do Estado');
	  uf.focus();
	  return false;}
  if(nome.value==''){
    alert('Preencha com o nome do Estado');
	nome.focus();
   return false;  }
}}

</script> 
</head>

<body onload='seta_foco()'>      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#f2f2f2">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	<? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=base64_decode($_REQUEST['est']);
$op=$_REQUEST['op'];
echo $_SESSION['lnk'];
	 
	?></div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="<? echo $PHP_SELF ?>" onSubmit="return valida()">
<?
 if($val && $op=='update')
 {
   $sql="SELECT a.* from estado as a where a.estado='".trim($val)."'";
   $db->query($sql);
	while($col=$db->dados())
	{
	  $nome=$col['nome'];
	  $uf=$col['uf'];
	 }}
if($val && $op=='del')
{
     $sql="DELETE from estado where estado='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='estado.php'</script>";
	 exit();
}	 
	 ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td colspan="2" class="texto_bold"><div align="left"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UF:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;              
              <input name="uf" type="text" class="combo_cadastro" id="uf" value="<? echo $uf ?>" size="3" maxlength="3">
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado:
              <input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo $nome ?>" size="78">
          </div></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="val" type="hidden" id="op" value="<? echo $val ?>">
          
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
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
            <div align="left"><? echo "<a href=\"estado.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <?

function verifica_existencia($valor)
{
global $db;
  $sql="select distinct(uf) from estado as a where a.uf='$_REQUEST[uf]'";
 // echo $sql;
  $db->query($sql);
  $res=$db->contalinhas();
  echo $res;
if($res >0)  {
 echo "<script>alert('Erro.Registro já cadastrado!')</script>";
 echo"<script>location.href='estado.php'</script>";
 exit();}
 
else{
 return $valor;}
}   
if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
     $sql="UPDATE estado set nome='$_REQUEST[nome]',uf='$_REQUEST[uf]' where estado='$_REQUEST[val]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='estado.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
   
     $sql= "INSERT INTO estado(uf,nome) values('$_REQUEST[uf]','$_REQUEST[nome]')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='estado.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
