<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function valida() {
	for (i=0; i<document.form1.length; i++) {
		var tempobj= document.form1.elements[i];
		if (tempobj.type=='text' && tempobj.value!='') {
			return true;
		}
	}
	alert('Informe o Título.');
	return false;
}
</script>  
</head>

<body onLoad="document.form1.titulo.focus();">      
<table width="542" border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
montalinks();
$_SESSION['lnk']= $link;
?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" onSubmit='return valida()' action="fotopre_altera.php">
	  <table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td colspan="2" class="texto"><div align="left"><em>Informe o parâmetro de pesquisa:</em></div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2"><div align="left"><span class="tit_interno"> </span>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"> </td>
        </tr>
        <tr>
		 <td width="20%">&nbsp;</td>
          <td class="texto_bold">Título da fotografia: <input type="text" name="titulo" size="30" class="combo_cadastro"> ou</td>
        </tr>
        <tr>
		  <td width="20%">&nbsp;</td>
          <td class="texto_bold">Nome do arquivo da Imagem: <input type="text" name="arqimg" size="30" class="combo_cadastro"></td>
        </tr>

        <tr>
          <td colspan="2" align="center"><br><input type="submit" name="ok" class="botao" id="ok" value="Procurar"><br><br></td>
        </tr>
		<tr>
			<td colspan="2" class="texto_bold"><input type="text" name="textfield" style="display:none "></td>
		</tr>
      </table>
    </form>
	</td>
  </tr>
</table>
<?
if($_REQUEST[ok]<>'') {
 if((trim($_REQUEST[titulo])<>'') || (trim($_REQUEST[arqimg])>'')) {
	 $sql="SELECT * from fotografia where ";
	 $where="";
	 if (trim($_REQUEST[titulo])<>'')
		$where="titulo like '%$_REQUEST[titulo]%'";
	 if (trim($_REQUEST[arqimg])<>'') {
		if ($where=='')
			$where=" nome_arquivo like '%$_REQUEST[arqimg]%'";
                else
			$where=$where." and nome_arquivo like '%$_REQUEST[arqimg]%'";
             }
         $sql=$sql.$where;
	 $db->query($sql);
	 $conta=$db->contalinhas();
	  if($conta==0)
    	echo"<script> alert('Nenhum registro encontrado!')</script>";
	  else
	    echo "<script>location.href='foto_ocorrencia_altera.php?titulo=$_REQUEST[titulo]&arqimg=$_REQUEST[arqimg]'</script>";
}}
?>
</body>
</html>
