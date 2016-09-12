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
    if(numregistro.value==''){
	  alert('Preencha com o registro da obra.');
	  numregistro.focus();
	  return false;}
      }
}

</script>  
</head>

<body onLoad="document.form1.numregistro.focus();">      
<br>
<table width="519" height="60%"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td width="519" height="300" valign="top"><form name="form1" method="post" onSubmit='return valida()' >
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="1" >
        <tr>
          <td colspan="2" class="texto"><div align="center"><em>Certifique-se
                inicialmente se o registro da obra j&aacute;  est&aacute;
              cadastrado no sistema:<em><br><br></div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2"><div align="center"><span class="tit_interno">
            <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
?>
          </span>
          </div></td>
        </tr>
        <tr>
          <td colspan="2">
          </span></td>
        </tr>
        <tr>
          <td width="58%"><div align="center"><span class="texto_bold">
                Registro da Obra:
                    <input name="numregistro"  align="center" type="text" class="combo_texto" id="numregistro" size="15">
            </span></div></td>
          <td width="42%"><div align="center"><span class="texto_bold">
                <input name="procurar" type="submit" class="botao" id="enviar" value="Procurar">
          </span></div></td>
        </tr>
   <tr><td>&nbsp;</td></p>
    <tr><td>&nbsp;</td></p>

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
 $num=$_REQUEST[numregistro];
 //
 // Criando statusInicial (Inclusão de Obra com Publicação). Mais abaixo, na chamada do cadastrobrareg.php passando este parâmetro (PBL) PRD17
 //
 $statusInicial=$_SESSION[statusInicial];
 //
 //$sql="SELECT a.nomeetiqueta from autor as a where a.nomeetiqueta like '$_REQUEST[nomeetiqueta]%'";
 $sql="SELECT a.num_registro from obra as a where a.num_registro='".trim($num)."'";
 $db->query($sql);
  $conta=$db->contalinhas();
  if($conta==0)
  { 
     echo"<script>
	 var ok=confirm('Obra disponível para inclusão.Continua?')
	 if(ok)
	 window.location='cadastrobrareg.php?op=insert&num=$num&statusInicial=$statusInicial';
	 </script>";
	/*echo"<script>location.href='cadastroautor.php?autor=troca_percent($busca)'</script>";*/
 }
  if($conta!=0)
  {
    echo"<script> alert('Registro:$num já se encontra cadastrado!')</script>";
    
 }
}
?>