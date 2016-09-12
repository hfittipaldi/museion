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
	  alert('Preencha com o tipo_relação.');
	  nome.focus();
	  return false;}
	 if(origem.value==''){
	   alert('Preencha com a descrição de origem.');
	    origem.focus();
	  return false;}
	   if(destino.value==''){
	   alert('Preencha com a descrição de destino.');
	    destino.focus();
	  return false;}
    if(!nominal[0].checked && !nominal[1].checked){
	  alert ('Selecione se é nominal.');
	  return false;}
  }
}

</script>  
</head>

<body onload='seta_foco()'>      
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=base64_decode($_REQUEST['relac']);
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
    $sql="SELECT a.* from tipo_relacao as a where a.tipo_relacao='$val'";
    $db->query($sql);
    $res=$db->dados();
	}
  if($op=='del')
  {
     $sql="DELETE from tipo_relacao where tipo_relacao='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='tiporelac.php'</script>";
	 exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4" >
        <tr>
          <td colspan="2" class="texto_bold"><div align="left"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome:&nbsp;&nbsp;&nbsp;              
              <input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo htmlentities($res[1], ENT_QUOTES); ?>" size="78">
          </div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Origem:
            <input name="origem" type="text" class="combo_cadastro" id="origem" value="<? echo htmlentities($res[2], ENT_QUOTES); ?>" size="78"></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destino:
            <input name="destino" type="text" class="combo_cadastro" id="destino" value="<? echo htmlentities($res[3], ENT_QUOTES); ?>" size="78"></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nominal ? 
            <input name="nominal" type="radio" class="texto_bold" value="S" <? if($res[4]=='S'){echo "checked";} ?>>
            SIM 
            <input name="nominal" type="radio" class="texto_bold" value="N" <? if($res[4]=='N'){echo "checked";} ?>>
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
            <div align="left"><? echo "<a href=\"tiporelac.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
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
     $sql="UPDATE tipo_relacao set
	  nome='$_REQUEST[nome]',
	  desc_origem='$_REQUEST[origem]',
	  desc_destino='$_REQUEST[destino]',
	  eh_nominal='$_REQUEST[nominal]'
	                    where tipo_relacao='$_REQUEST[val]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='tiporelac.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
  //   verifica_existencia($_REQUEST[nome]);
     $sql= "INSERT INTO tipo_relacao(nome,desc_origem,desc_destino,eh_nominal) values('$_REQUEST[nome]','$_REQUEST[origem]','$_REQUEST[destino]','$_REQUEST[nominal]')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='tiporelac.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
