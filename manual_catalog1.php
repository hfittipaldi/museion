<? include_once("seguranca.php");?>
<html>
<head>
<title>Manual de Catalogação</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

</head>

<body style="background-color: #<? echo $_REQUEST[corfundo]; ?>;">      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#f2f2f2">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	<? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
if($_REQUEST['janela']!='popup'){
echo $_SESSION['lnk'];
}
if($_REQUEST[tipo]=='RG')
{
  $sql="SELECT *from regras_gerais where controle='$_REQUEST[controle]'";
  $db->query($sql);
  $row=$db->dados();
}
if($_REQUEST[parametro1]<>'' && $_REQUEST[parametro2]<>'')
{
  $sql="SELECT A.controle,A.definicao,A.item,A.pagina,B.nome_area from manual A,area_manual B
   where A.area=B.area and A.area='$_REQUEST[parametro1]' and A.controle='$_REQUEST[parametro2]'"; 
 $db->query($sql);
 $row=$db->dados();
 } 
if($_REQUEST[tipo]=='INDICE')
{
  // Tab indice = area/item <=> Tab manual= area/controle
 $sql=" select a.item,a.definicao,a.pagina,b.nome_area from manual a,area_manual b 
  where a.area=b.area and a.area='$_REQUEST[area]' and a.controle='$_REQUEST[item]'";
 $db->query($sql);
 $row=$db->dados();
}
?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" >
         <tr>
           <td colspan="3" class="texto_bold"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&Aacute;rea:&nbsp;<? echo $row['nome_area'];?></td>
          </tr>
         <tr>
           <td colspan="3" class="texto_bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item:&nbsp;<? echo $row['controle'];?>&nbsp;&nbsp;&nbsp;<? echo $row['item'];?></td>
          </tr>

         <tr>
           <td width="4%" align="center">&nbsp;</td>
           <td colspan="2"><textarea name="textfield"  readonly cols="90"  rows="17" wrap="VIRTUAL" class="combo_cadastro" ><? echo $row['definicao']; ?></textarea></td>
         </tr>
          <tr>
            <td colspan="2" class="texto_bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;P&aacute;gina:&nbsp;<? echo $row['pagina'] ?></td>
            <td width="12%" class="texto_bold"><? echo "<a href=\"javascript:history.go(-1);\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></td>
          </tr>
          <tr>
          <td colspan="3"></td>
          </tr>
      </table>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
