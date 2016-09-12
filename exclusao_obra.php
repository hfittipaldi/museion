<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function valida()
{
  with(document.form1)
  {
    if(num_registro.value=='')
	{
	 alert('Informe o número de registro da obra.');
	 num_registro.focus();
	 return false;
	}
  }
}
</script>
</head>
<body onload='self.document.getElementById("num_registro").focus()'>
<table width="500"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td valign="top" align="center" class="tit_interno" >
	<?
	  include("classes/classe_padrao.php");
      include("classes/funcoes_extras.php");
      $db=new conexao();
      $db->conecta(); 
	  montalinks();
      $_SESSION['lnk']=$link;
	 ?></td>
  </tr>
  <tr>
    <td width="500" valign="top"><form name="form1" method="post" action="exclusao_obra1.php" onSubmit="return valida()">
      
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
      <tr class="texto">
          <td colspan="4" align="center" class="texto"><br><em>            <div>Informe
            o n&uacute;mero de registro para <u>excluir</u>  a obra relacionada: </em></div></td>
          </tr>
        <tr class="texto">
          <td width="42%"></td>
          <td width="34%"></td>
          <td width="12%"></td>
          <td width="12%"></td>
        </tr>
        <tr class="texto">
          <td colspan="2" class="texto_bold">&nbsp;</td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="texto_bold"><br><div align="center">N&ordm; do registro:
                <input name="num_registro" type="text" class="combo_cadastro" id="num_registro" size="20">
            &nbsp;
              <input name="enviar" type="submit" class="botao" id="enviar" value=" Ok ">
          </div></td>
          </tr>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
      </table>
       <p>
		  <br>
        </p>
      <p></p>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>

