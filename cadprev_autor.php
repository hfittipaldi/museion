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
    if(nomeetiqueta.value==''){
	  alert('Preencha o campo nome');
	  nomeetiqueta.focus();
	  return false;}
      }
}

</script>  
</head>
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=base64_decode($_REQUEST['camada']);
$op=$_REQUEST['op'];

?>
<body onLoad="document.form1.nomeetiqueta.focus();">        
<br>    
<table width="546" height="50%"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td valign="top"><form name="form1" method="get" onSubmit='return valida()' >
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1" ><br><br>
        <tr>
          <td colspan="2" class="texto"><div align="center"><em>Certifique-se
                inicialmente se o registro do autor j&aacute;  est&aacute;
              cadastrado no sistema:</em></div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2"><div align="center">
          </div></td>
        </tr>
        <tr>
          <td colspan="2">
          </span></td>
        </tr>
        <tr>
          <td><div align="center"><span class="texto_bold"><br>
              Nome do autor:
              <input name="nomeetiqueta"  align="middle" type="text" class="combo_texto" id="nomeetiqueta" size="60">
              <input name="procurar" type="submit" class="botao" id="enviar" value="Procurar">
          </span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <div align="left">
              <input type="text" name="textfield" style="display:none ">
</div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<? 
if($_REQUEST[procurar]<>'')
{
//Obs: Para nao confundir,a variavel nomeetiqueta='nome do autor da obra';
  global $db;
 $nome=$_REQUEST[nomeetiqueta];
 $busca=trim($nome);
 $sql="SELECT a.nomeetiqueta from autor as a where a.nomeetiqueta like '%$busca%' OR a.nomecatalogo like '%$busca%'";
  $db->query($sql);
  $conta=$db->contalinhas();
  if($conta==0)
  { 
     echo"<script>
	 var ok=confirm('Nome do autor disponível para inclusão.Continua?')
	 if(ok)
	 window.location='cadastroautor.php?nomeetiqueta=$busca';

	 </script>";
 }
  else
  {
    echo"<script>location.href='autor_ocorrencia.php?nomeetiqueta=$busca'</script>";
  }
}
?>