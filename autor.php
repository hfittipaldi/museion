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
 with(document.form1){
    if(nomeetiqueta.value==''){
	  alert('Preencha com o nome do autor!');
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
$op=$_REQUEST['op'];

?>
<body onload="document.form1.nomeetiqueta.focus()">  
<br>    
<table width="546" height="60%" align="center" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td valign="top"><form name="form1" method="get" onsubmit='return valida()' >
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td colspan="2" class="texto"><div align="left"><br><br><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Digite o nome
              do autor a ser alterado :<br></em></div></td>
        </tr>
        <tr>
          <td colspan="2">
          </span></td>
        </tr>
        <tr>
          <td><div align="left"><span class="texto_bold">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Autor:
                    <input name="nomeetiqueta"  align="middle" type="text" class="combo_texto" id="nomeetiqueta" size="60">
                <input name="procurar" type="submit" class="botao" id="enviar" value="Procurar" >
          </span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <div align="left">
              <input type="text" name="textfield" style="display:none" >
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
  //$sql="SELECT a.nomeetiqueta from autor as a where a.nomeetiqueta like '$_REQUEST[nomeetiqueta]%'";
 $sql="SELECT *from autor as a where a.nomeetiqueta like '%$busca%' OR a.nomecatalogo like '%$busca%'";
 $db->query($sql);
 $res=$db->dados();
 $id=$res['autor'];
  $conta=$db->contalinhas();
  if($conta==0)
  { 
     echo"<script> alert('Autor:$busca, não se encontra cadastrado.')</script>";
  }
 if($conta>0)
 {
  echo "<script>location.href='autor_ocorrencia_altera.php?nomeetiqueta=$busca'</script>";
 }
}
?>