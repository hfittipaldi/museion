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
    form1.estado_camada.focus();
	return;
}
function valida()
{
 with(document.form1){
    if(estado_camada.value==''){
	  alert('Preencha com o estado da camada');
	  estado_camada.focus();
	  return false;}
    if(tipo_camada.value==''){
	   alert('Preencha com o tipo');
	   tipo_camada.focus();
	   return false;}
  }
}

</script>  
</head>

<body onload='seta_foco()'>      
<table width="542" border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=base64_decode($_REQUEST['camada']);
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
   $sql="SELECT a.* from camada as a where a.camada='$val'";
   $db->query($sql);
   $res=$db->dados();
  }
 if($op=='del')
 {
     $sql="DELETE from camada where camada='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='camada.php'</script>";
	 exit();
  }	 
}
	 ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4" bgcolor="#CCCCFF">
        <tr>
          <td colspan="2" class="texto_bold"><div align="left">Estado da camada : &nbsp;              
              <input name="estado_camada" type="text" class="combo_cadastro" id="estado_camada" value="<? echo $res[2] ?>" size="60">
          </div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2">Tipo:
            <input name="tipo_camada" type="text" class="combo_cadastro" id="tipo_camada" value="<? echo $res[3] ?>" size="78"></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="val" type="hidden" id="op" value="<? echo $val ?>">
          
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
          </span></td>
        </tr>
        <tr>
          <td><div align="right"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <div align="left"><? echo "<a href=\"camada.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
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
     $sql="UPDATE camada set estado='$_REQUEST[estado_camada]',tipo='$_REQUEST[tipo_camada]' 
	 where camada='$_REQUEST[val]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='camada.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
  //   verifica_existencia($_REQUEST[nome]);
     $sql= "INSERT INTO camada(estado,tipo) values('".trim($_REQUEST[estado_camada])."','".trim($_REQUEST[tipo_camada])."')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='camada.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
