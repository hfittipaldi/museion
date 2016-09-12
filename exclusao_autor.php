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
    if(nomeetiqueta.value=='')
	{
	 alert('Informe o nome do autor.');
	 nomeetiqueta.focus();
	 return false;
	}
  }
}
</script>
</head>
<body onload='self.document.getElementById("nomeetiqueta").focus()'>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td valign="top" class="tit_interno">
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
    <td width="519" valign="top"><form name="form1" method="post" action="autor_ocorrencia_exclui.php" onSubmit="return valida()">
      
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
      <tr class="texto">
          <td colspan="4" align="left" class="texto"><div align="left"><br><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Informe
            o nome do autor a ser <u>excluído</u>: </em></div></td>
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
          <td align="left">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="texto_bold"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Autor:
                <input name="nomeetiqueta" type="text" class="combo_cadastro" id="nomeetiqueta" size="60">
            &nbsp;
              <input name="enviar" type="submit" class="botao" id="enviar" value="Procurar">
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