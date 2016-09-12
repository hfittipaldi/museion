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
    form1.nome.focus();
	return;
}
function valida()
{
 with(document.form1){
    if(nome.value==''){
	  alert('Preencha com o nome do relacionamento');
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
$db1=new conexao();
$db1->conecta();
$val=base64_decode($_REQUEST['relacionamento']);
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
   $sql="SELECT nome from relacionamento as a where a.relacionamento='$val'";
   $db->query($sql);
   $res=$db->dados();
  }
 if($op=='del')
 {
     $sql="select count(*) as total from relacionamento_obra where relacionamento='$val'";
     $db->query($sql);
     $res=$db->dados();
     if ($res[total]==0) {
         $sql="DELETE from relacionamento where relacionamento='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='relacionamento.php'</script>";
	 exit();
     } else {
	 echo"<script>alert('Impossível excluir. Relacionamento em uso.')</script>";
	 echo"<script>location.href='relacionamento.php'</script>";
	 exit();
     }
  }	 
}
	 ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4" >
        <tr>
          <td colspan="2" class="texto_bold"><div align="left"><br>&nbsp;&nbsp;T&iacute;tulo do relacionamento: &nbsp;              
              <input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo htmlentities($res[0], ENT_QUOTES); ?>" size="70">
          </div></td>
        </tr>
        <tr>
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
            <div align="left"><? echo "<a href=\"relacionamento.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
      <?
/* Essa funcao nao esta sendo usada temporariamente.
function verifica_existencia($valor)
{
global $db;
  $sql="select distinct(relacionamento) from relacionamento as a where a.relacionamento='".trim($_REQUEST[sigla])."'";
 // echo $sql;
  $db->query($sql);
  $res=$db->contalinhas();
  //echo $res;
if($res >0)  {
 echo "<script>alert('Erro.Registro já cadastrado!')</script>";
 echo"<script>location.href='relacionamento.php'</script>";
 exit();}
 
else{
 return $valor;}
}   */
if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
     $sql="UPDATE relacionamento set nome='$_REQUEST[nome]' where relacionamento='$_REQUEST[val]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='relacionamento.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert')
  {
         $sql= "INSERT INTO relacionamento(nome) values('".trim($_REQUEST[nome])."')";
         echo $sql;
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='relacionamento.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
