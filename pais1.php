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
	return;}
function valida()
{
 with(document.form1){
    if(sigla.value==''){
	  alert('Preencha com a sigla do Pais');
	  sigla.focus();
	  return false;}
  if(nome.value==''){
    alert('Preencha com o nome do Pais');
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
$val=$_REQUEST['pais'];
$op=$_REQUEST['op'];
echo $_SESSION['lnk'];

	?></div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="<? echo $PHP_SELF ?>" onSubmit="return valida()">
<?
/*require("bkp/classes/classe_padrao.php");
$db=new conexao();
$db->conecta();*/

 if($val && $op=='update')
 {
   $sql="SELECT a.* from pais as a where a.pais='".trim($val)."'";
   $db->query($sql);
	while($col=$db->dados())
	{
	  $nome=$col['nome'];
	  $sigla=$col['sigla'];
	 }}
if($val && $op=='del')
{
     $sql="DELETE from pais where pais='$val'";
	 echo $sql;
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='pais.php'</script>";
	 exit();
}	 
	 ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="1" >
        <tr>
          <td colspan="2" class="texto_bold"><div align="left"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sigla:              
              <input name="sigla" type="text" class="combo_cadastro" id="sigla" value="<? echo $sigla ?>" size="3" maxlength="3">
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pa&iacute;s:&nbsp;              
            <input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo $nome ?>" size="82">
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
            <div align="left"><? echo "<a href=\"pais.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
      <?

function verifica_existencia($valor)
{
global $db;
  $sql="select distinct(sigla) from pais as a where a.sigla='$_REQUEST[sigla]'";
 // echo $sql;
  $db->query($sql);
  $res=$db->contalinhas();
  //echo $res;
if($res >0)  {
 echo "<script>alert('Erro.Registro já cadastrado!')</script>";
 echo"<script>location.href='pais.php'</script>";
 exit();}
 
else{
 return $valor;}
}   
if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
     $sql="UPDATE pais set nome='$_REQUEST[nome]',sigla='$_REQUEST[sigla]' where pais='$_REQUEST[val]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='pais.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
  //   verifica_existencia($_REQUEST[nome]);
     $sql= "INSERT INTO pais(sigla,nome) values('$_REQUEST[sigla]','$_REQUEST[nome]')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='pais.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
