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
    form1.museu.focus();
	return;}
function valida()
{
 with(document.form1){
    if(museu.value==''){
	  alert('Preencha com o Número da Instituição');
	  museu.focus();
	  return false;}
  if(sigla.value==''){
    alert('Preencha com a Sigla da Instituição');
	sigla.focus();
   return false;  }
  if(nome.value==''){
    alert('Preencha com o Nome da Instituição');
	nome.focus();
   return false;  }
/*   if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))) 
    { 
        alert("Favor informar um email válido.") 
        email.focus() 
        return (false) 
    } */
}}

</script> 
</head>

<body onload='seta_foco()'>      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	<? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=base64_decode($_REQUEST['museu']);
$op=$_REQUEST['op'];
echo $_SESSION['lnk'];	 ?>
</div></th>
  </tr>
  <tr>
    <td valign='top'><form name="form1" method="post" action="<? echo $PHP_SELF ?>" onSubmit="return valida()">
<?

 if(isset($val))
 {
  if($op=='update')
   {
    $sql="SELECT a.* from museu as a where a.museu='".trim($val)."'";
    $db->query($sql);
    $res=$db->dados();
   }
if($val && $op=='del')
 {
     $sql="DELETE from museu  where museu='$val'";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='museu.php'</script>";
	 exit();
  }	
}
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4" >
        <tr>
          <td colspan="3" class="texto_bold"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Museu:
            <input name="museu" type="text" class="combo_cadastro"  value="<? echo $res['museu']; ?>" size="2">          
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sigla:
          <input name="sigla" type="text" class="combo_cadastro" id="sigla" value="<? echo $res['sigla'] ?>" size="8">
          </td>
        </tr>
        <tr>
          <td colspan="3" class="texto_bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome:
            <input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo $res['nome'] ?>" size="84">            </td>
        </tr>
        <tr>
          <td colspan="3" class="texto_bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Endere&ccedil;o:
<input name="endereco" type="text" class="combo_cadastro" id="endereco" value="<? echo $res['endereco'] ?>" size="80">
&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&ordm;:
            <input name="num" type="text" class="combo_cadastro" id="num" value="<? echo $res['numero'] ?>" size="5">
            &nbsp;Complemento:
            <input name="compl" type="text" class="combo_cadastro" id="compl" value="<? echo $res['complemento'] ?>" size="13"> &nbsp;&nbsp;Bairro:
            <input name="bairro" type="text" class="combo_cadastro" id="bairro" value="<? echo $res['bairro'] ?>" size="30"></td>
          </tr>
        <tr class="texto_bold">
          <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cidade:
            <input name="cidade" type="text" class="combo_cadastro" id="cidade" value="<? echo $res['cidade'] ?>" size="48">
&nbsp;UF:
<input name="uf" type="text" class="combo_cadastro" id="uf" value="<? echo $res['uf'] ?>" size="2">
&nbsp;CEP:
<input name="cep" type="text" class="combo_cadastro" id="cep" value="<? echo $res['cep'] ?>" size="8"> &nbsp;</td>
          </tr>
        <tr class="texto_bold">
          <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DDD:
            <input name="ddd" type="text" class="combo_cadastro" id="ddd" value="<? echo $res['ddd'] ?>" size="1">&nbsp;&nbsp;&nbsp;&nbsp;Telefones:
            <input name="tel" type="text" class="combo_cadastro" id="tel" value="<? echo $res['tel'] ?>" size="10"> &nbsp;
            <input name="tel2" type="text" class="combo_cadastro" id="tel2" value="<? echo $res['tel2'] ?>" size="10"> &nbsp;Fax:
            <input name="fax" type="text" class="combo_cadastro" id="fax" value="<? echo $res['fax'] ?>" size="10">
           </tr>
        <tr class="texto_bold">
          <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Internet:
            <input name="internet" type="text" class="combo_cadastro"  id="internet" value="<? echo $res['internet'] ?>" size="40">

           &nbsp;&nbsp;&nbsp;Email: 
            <input name="email" type="text" class="combo_cadastro"  id="email" value="<? echo $res['email']  ?>" size="26"></td>

          </tr>
        <tr>
          <td colspan="3" align="right"><input name="enviar" type="submit" class="botao" value="Gravar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <input name="val" type="hidden" id="op" value="<? echo $val ?>">
          
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
          </span><? echo "<a href=\"museu.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></td>
        </tr>
      </table>
      <?

function verifica_existencia($valor)
{
global $db;
  $sql="select distinct(museu) from museu as a where a.museu='$_REQUEST[museu]'";
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
     $sql="UPDATE museu set 
	 museu='$_REQUEST[museu]',
	 sigla='$_REQUEST[sigla]',
	 nome='$_REQUEST[nome]',
	 endereco='$_REQUEST[endereco]',
	 numero='$_REQUEST[num]',
	 complemento='$_REQUEST[compl]',
	 bairro='$_REQUEST[bairro]',
	 cidade='$_REQUEST[cidade]',
	 uf='$_REQUEST[uf]',
	 cep='$_REQUEST[cep]',
	 ddd='$_REQUEST[ddd]',
	 tel='$_REQUEST[tel]',
	 tel2='$_REQUEST[tel2]',
	 fax='$_REQUEST[fax]',
	 email='$_REQUEST[email]',
	 internet='$_REQUEST[internet]',
	 datainicio=now()
	          where museu='$_REQUEST[val]'";
	
 $db->query($sql);
	if ($db->Errno == 0) {
		echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	}
	 echo"<script>location.href='museu.php'</script>";
	}
  elseif($_REQUEST[op]=='insert'){
    
     $sql= "INSERT INTO museu(
    	museu,
    	sigla,
    	nome, 
    	endereco,
    	numero,
    	complemento,
    	bairro,
    	cidade,
    	uf,
    	cep,
    	ddd,
    	tel,
    	email,
    	internet,
    	datainicio,
    	tel2) 
        values(
        '$_REQUEST[museu]',
        '$_REQUEST[sigla]',
        '$_REQUEST[nome]',
	'$_REQUEST[endereco]',
        '$_REQUEST[num]',
        '$_REQUEST[compl]',
        '$_REQUEST[bairro]',
        '$_REQUEST[cidade]',
	'$_REQUEST[uf]',
        '$_REQUEST[cep]',
        '$_REQUEST[ddd]',
        '$_REQUEST[tel]',
        '$_REQUEST[email]',
	'$_REQUEST[internet]',
         now(),
         '$_REQUEST[tel2]')";
	
	$db->query($sql);
	if ($db->Errno == 0) {
		echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	}
	echo"<script>location.href='museu.php'</script>";
  }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
