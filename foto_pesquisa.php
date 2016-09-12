<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function valida() {
/*	for (i=0; i<document.form1.length; i++) {
		var tempobj= document.form1.elements[i];
		if (tempobj.type=='text' && tempobj.value!='') {
			return true;
		}
	}
	alert('Informe o Título.');
	return false;*/
return true;
}
</script>  
</head>

<body>
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
    <td valign="top"><form name="form1" method="post" onSubmit='return valida()' action="foto_pesquisa.php">
	  <table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td colspan="2" class="texto"><div align="left"><em>Informe o(s) parâmetro(s) de pesquisa:</em></div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2"><div align="center"><span class="tit_interno"> </span>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"> </td>
        </tr>
        <tr>
		  <td width="20%">&nbsp;</td>
          <td class="texto_bold">Tipo do vínculo: 
			<select name="vinculo" id="vinculo" class="combo_cadastro">
				<option value="T" selected>Todos</option>
				<option value="S">Sem vínculo</option>
				<option value="O">Obra</option>
				<option value="A">Autor</option>
				<option value="P">Papel</option>
				<option value="R">Pintura</option>
				<option value="I">Instituição</option>
			</select>
		  </td>
        </tr>
        <tr>
		  <td width="20%">&nbsp;</td>
          <td class="texto_bold">Título da fotografia: <input type="text" name="titulo" size="30" class="combo_cadastro"></td>
        </tr>
        <tr>
		  <td width="20%">&nbsp;</td>
          <td class="texto_bold">Função: 
						<select class="combo_cadastro" name="funcao">
							<option value="0" selected>&nbsp;</option>
							<option value="M">Master</option>
							<option value="R">Referência</option>
							<option value="T">Thumbnail</option>
						</select>
		  </td>
        </tr>
        <tr>
		  <td width="20%">&nbsp;</td>
          <td class="texto_bold">Coloração: 
						<select class="combo_cadastro" name="cor">
							<option value="0" selected>&nbsp;</option>
							<option value="PB">P&amp;B</option>
							<option value="COR">Colorido</option>
						</select>
		  </td>
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
	 $sql="SELECT * from fotografia where (titulo like '%$_REQUEST[titulo]%' or '$_REQUEST[titulo]'='') AND 
			(vinculo='$_REQUEST[vinculo]' or '$_REQUEST[vinculo]'='T') AND (funcao='$_REQUEST[funcao]' or '$_REQUEST[funcao]'='0') AND 
			(tipo='$_REQUEST[cor]' or '$_REQUEST[cor]'='0')";
	 $db->query($sql);
	 $conta=$db->contalinhas();
	  if($conta==0)
    	echo"<script> alert('Nenhuma imagem foi encontrada!')</script>";
	  else
	    echo "<script>location.href='foto_ocorrencia_pesq.php?titulo=$_REQUEST[titulo]&vinculo=$_REQUEST[vinculo]&funcao=$_REQUEST[funcao]&cor=$_REQUEST[cor]'</script>";
}
?>
</body>
</html>