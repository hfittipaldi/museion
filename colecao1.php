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
	  alert('Preencha com o nome da coleção.');
	  nome.focus();
	  return false;}
	 if(responsavel.value=='0'){
	   alert('Preencha com o nome do responsável.');
	    responsavel.focus();
	  return false;}
	   if(tecnico.value=='0'){
	     alert('Preencha com o nome do tecnico.');
	     tecnico.focus();
	  return false;}
      if(thesaurus.value==''){
	     alert ('Preencha com o codigo thesaurus.');
	     thesaurus.focus();
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
$val=base64_decode($_REQUEST['colecao']);
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
    $sql="SELECT a.* from colecao as a where a.colecao='$val'";
    $db->query($sql);
    $res=$db->dados();
	}
  if($op=='del')
  {
     $sql="DELETE from colecao where colecao='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='colecao.php'</script>";
	 exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td class="texto_bold"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome: </td>
          <td class="texto_bold"><br><br><br><input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo htmlentities($res[1], ENT_QUOTES); ?>" size="77"></td>
        </tr>
        <tr class="texto_bold">
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Respons&aacute;vel: </td>
		  <td><select name="responsavel" class="combo_cadastro" id="responsavel">
	             <? 
					  $sql="SELECT usuario,nome from usuario order by nome";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($lst=$db->dados())
					  {
				 	 ?>
    	        <option value="<? echo $lst[0] ;?>" <? if($lst[0]==$res[2]) echo "Selected" ?>><? echo $lst[1]; ?></option>
        	    <? } ?>
	          </select>
		  </td>
        </tr>
        <tr class="texto_bold">
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T&eacute;cnico: </td>
		  <td><select name="tecnico" class="combo_cadastro" id="tecnico">
	             <? 
					  $sql="SELECT usuario,nome from usuario order by nome";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($lst=$db->dados())
					  {
				 	 ?>
    	        <option value="<? echo $lst[0] ;?>" <? if($lst[0]==$res[3]) echo "Selected" ?>><? echo $lst[1]; ?></option>
        	    <? } ?>
	          </select>
		  </td>
        </tr>
        <tr class="texto_bold">
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thesaurus: </td>
          <td><input name="thesaurus" type="text" class="combo_cadastro" id="thesaurus" value="<? echo $res[4]  ?>" size="40"></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="val" type="hidden" value="<? echo $val ?>">
          
          <input name="op" type="hidden" value="<? echo $op ?>">
          </span></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold" align="right"><input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td>
            <div align="left"><? echo "<a href=\"colecao.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
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
     $sql="UPDATE colecao set
	  nome='$_REQUEST[nome]',
	  responsavel='$_REQUEST[responsavel]',
	  tecnico='$_REQUEST[tecnico]',
	  thesaurus='$_REQUEST[thesaurus]'
	                    where colecao='$_REQUEST[val]'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='colecao.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
  //   verifica_existencia($_REQUEST[nome]);
     $sql= "INSERT INTO colecao(nome,responsavel,tecnico,thesaurus) 
	 values('$_REQUEST[nome]','$_REQUEST[responsavel]','$_REQUEST[tecnico]','$_REQUEST[thesaurus]')";
	 echo $sql;
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='colecao.php'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
