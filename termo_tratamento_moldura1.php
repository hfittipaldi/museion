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
    form1.termo.focus();
	return;
}
function valida()
{
 with(document.form1){
    if(termo.value==''){
	  alert('Preencha com o estado de conservação');
	  termo.focus();
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
$val=$_REQUEST['conserva'];
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
   $sql="SELECT a.* from termo_moldura_tratamento as a where a.termo_moldura_tratamento='$val'";
   $db->query($sql);
   $res=$db->dados();
  }
 if($op=='del')
 {
     $sql="DELETE from termo_moldura_tratamento where termo_moldura_tratamento='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='termo_tratamento_moldura.php'</script>";
	 exit();
  }	 
}
	 ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td colspan="2" class="texto_bold"><div align="center"><br><br><br>Tratamento: &nbsp;              
              <input name="termo" type="text" class="combo_cadastro" id="termo" value="<? echo $res['termo'] ?>" size="48">
          </div></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="val" type="hidden" id="val" value="<? echo $val ?>">
	        <input name="op" type="hidden" id="op" value="<? echo $op ?>">
	        <input name="oculto" type="text" id="oculto" value="" style="display:none">
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
            <div align="left"><? echo "<a href=\"termo_tratamento_moldura.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
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
     $sql="UPDATE termo_moldura_tratamento set termo='$_REQUEST[termo]' 
	 where termo_moldura_tratamento='$_REQUEST[val]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='termo_tratamento_moldura.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
  //   verifica_existencia($_REQUEST[nome]);
     $sql= "INSERT INTO termo_moldura_tratamento(termo) values('".trim($_REQUEST[termo])."')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='termo_tratamento_moldura.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>