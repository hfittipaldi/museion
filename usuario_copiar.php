<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
<body onload='document.getElementById("ok").disabled=true'>
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
echo $_SESSION['lnk'];
function converte()
{
global $db;
  $sql="select nome from usuario  where usuario='$_REQUEST[usuario]'";
  $db->query($sql);
  $res=$db->dados();
return ucfirst($res[0]);
} 
?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" onSubmit='return valida()'>
<table width="100%"  border="0" cellpadding="0" cellspacing="4" >
        <tr>
          <td colspan="4" class="texto_bold"><br><br>&nbsp;&nbsp;&nbsp;Copiar permiss&otilde;es: </td>
          </tr>
        <tr>
          <td colspan="4" class="texto_bold"> </td>
        </tr>
        <tr>
          <td class="texto_bold"><div align="left">&nbsp;&nbsp;&nbsp;De:</div></td>
          <td colspan="3" class="texto_bold" >
		  <select name='usuario_pai' class="combo_cadastro" id=''>
              <option value="#"></option>
              <? 
			 $sql="SELECT DISTINCT (b.usuario), nome FROM usuario a, usuario_menu_item b
                   WHERE a.usuario = b.usuario AND b.usuario NOT in('$_REQUEST[usuario]') order by nome asc";
			 $db->query($sql);
			 while($row=$db->dados())
			 {
			?>
              <option value="<? echo $row[usuario] ?>"><? echo $row[nome] ?></option>
              <? } ?>
            </select></td>
        </tr>
        <tr>
          <td class="texto_bold">&nbsp;</td>
          <td colspan="3" class="texto_bold" >&nbsp;</td>
        </tr>
        <tr>
          <td class="texto_bold"><div align="left">&nbsp;&nbsp;&nbsp;Para:</div></td>
          <td colspan="3" class="texto_bold" ><span class="texto"><? echo converte(); ?></span>
		</td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td colspan="3" class="texto_bold">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left"><br>
            <input type="checkbox" name="checkbox" value="checkbox" onclick='if(this.checked) {document.getElementById("ok").disabled=false} else {document.getElementById("ok").disabled=true}'>
            <input type="submit" name="ok" class="botao" id="ok" value="Copiar Permiss&otilde;es"><br><br></td>
        </tr>
		<tr>
			<td colspan="4" class="texto">&nbsp;&nbsp;&nbsp;* Para realizar a c&oacute;pia efetiva das permiss&otilde;es,
			  habilite a caixa de sele&ccedil;&atilde;o acima.
		    </td>
		</tr>
        <tr>
          <td colspan="2">
            <div align="left"><br><? echo "<a href=\"usuario.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
        </tr>
      </table>
    </form>
	</td>
  </tr>
</table>
<?
// funcao q limpa a tabela de itens do menu,para a entrada de menus novos para o usuario.
function excluir_item()
{
 global $db;
 $sql="DELETE FROM usuario_menu_item where usuario='$_REQUEST[usuario]'";
 $db->query($sql);
} 
if ($_REQUEST['ok'] <> '') 
{
 //passo1:so ocorre se for um update! 
 if($_REQUEST[op]=='update')
 {
     excluir_item();
 }
 //passo2:
 $sql="select item from usuario_menu_item where usuario='$_REQUEST[usuario_pai]'";
 $db->query($sql);
 while($row=$db->dados()){
   $item[]=$row['item'];}
   
//passo3:copia usuario_pai(de) ->'usuario_filho' (para)
foreach($item as $valor)
{
  $sql="INSERT INTO usuario_menu_item(usuario,item) values ('$_REQUEST[usuario]','$valor')";
  $db->query($sql);
 }

echo "<script>alert('Cópia realizada com sucesso')</script>";
echo "<script>location.href='usuario.php'</script>";
}
?>
<p>&nbsp;</p>
</body>
</html>