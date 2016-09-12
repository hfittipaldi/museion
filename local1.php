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
	return;}
function valida()
{
 with(document.form1)
 {
    if(nome.value==''){
	  alert('Preencha com o local.');
	  nome.focus();
	  return false;}
    if(!mov[0].checked && !mov[1].checked){
	  alert ('Selecione a característica da movimentação.');
	  return false;}
  }
}

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
$val=base64_decode($_REQUEST['local']);
$op=$_REQUEST['op'];
echo $_SESSION['lnk'];

	?></div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="<? echo $PHP_SELF ?>" onSubmit="return valida()">
<?
 if(isset($val))
 {
  if($op=='update')
   {
    $sql="SELECT a.* from local as a where a.local='$val'";
    $db->query($sql);
     $res=$db->dados();
	}
  if($op=='del')
  {
     $sql="DELETE from local where local='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='local.php'</script>";
	 exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td colspan="2" class="texto_bold"><div align="left"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Local:&nbsp;              
              <input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo htmlentities($res[1], ENT_QUOTES); ?>" size="78">
          </div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Movimenta&ccedil;&atilde;o controlada ? 
            <input name="mov" type="radio" class="texto_bold" value="S" <? if($res[2]=='S'){echo "checked";} ?>>
            SIM 
            <input name="mov" type="radio" class="texto_bold" value="N" <? if($res[2]=='N'){echo "checked";} ?>>
            N&Atilde;O</td>
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
            <div align="left"><? echo "<a href=\"local.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
      <?

/*function verifica_existencia($valor)
{
global $db;
  $sql="select distinct(sigla) from local as a where a.sigla='$_REQUEST[sigla]'";
 // echo $sql;
  $db->query($sql);
  $res=$db->contalinhas();
  //echo $res;
if($res >0)  {
 echo "<script>alert('Erro.Registro já cadastrado!')</script>";
 echo"<script>location.href='local.php'</script>";
 exit();}
 
else{
 return $valor;}
}   */
if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
     $sql="UPDATE local set nome='$_REQUEST[nome]',eh_mov_controlada='$_REQUEST[mov]' where local='$_REQUEST[val]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='local.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
  //   verifica_existencia($_REQUEST[nome]);
     $sql= "INSERT INTO local(nome,eh_mov_controlada) values('$_REQUEST[nome]','$_REQUEST[mov]')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='local.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
