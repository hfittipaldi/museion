<? include_once("seguranca.php"); ?>
<html>
<head>
<title>Manual de Catalogação</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/ajax2.js" type="text/javascript"></script>
</head>
<script>
function direciona()
{
   window.location='manual_catalog1.php?corfundo=<? echo $_REQUEST[corfundo]; ?>&janela=<? echo $_REQUEST[janela] ?>&parametro1='+document.getElementById('area').value+'&parametro2='+document.getElementById('item').value;
}
</script>
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
montalinks();
$_SESSION['lnk']=$link;
}
?>
</div></th>
  </tr>
  <tr>
    <td valign="top">
      <table width="100%"  border="0" cellpadding="0" cellspacing="4">
         <tr>
           <td class="texto_bold">&nbsp; Regras Gerais:&nbsp; </td>
           <td width="31%" class="texto_bold"><div align="right">
           </div></td>
           <td width="31%" class="texto_bold"><input name="Submit" type="submit" class="botao" value="&Iacute;ndice"   onClick="javascript:location.href='indice_manual.php?janela=<? echo $_REQUEST['janela'];?>&corfundo=<? echo $_REQUEST[corfundo]; ?>'"></td>
         </tr>
         
         <tr>
		 <? 
		 $sql="SELECT *from regras_gerais order by controle asc";
		 $db->query($sql);
		 while($row=$db->dados())
		 {
		 ?>
           <td colspan="3" align="center"><div align="left"><span class="texto">&nbsp;&nbsp;<? echo $row['controle'] ?>&nbsp;</span><span class="texto"><? echo "-"; ?>&nbsp;<? echo "<a href=\"manual_catalog1.php?janela=".$_REQUEST[janela]."&corfundo=".$_REQUEST[corfundo]."&tipo=RG&controle=".$row[controle]."\">$row[item]</a>"; ?></span></div></td>
        </tr><? } ?>
          <tr>
            <td>&nbsp;&nbsp;<span class="texto_bold">&Aacute;reas:</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">
			&nbsp;
			<select name="area" id="area" class="combo_cadastro"  onChange="atualiza_manual(this.value)">
			<option value='0'></option>
			<? 
			if($_REQUEST[parametro]<>'')
			{
			  $p=$_REQUEST[parametro];
			  $sql="SELECT area,nome_area from area_manual where area='$p'";
			}
			else {
			$sql="SELECT area,nome_area from area_manual order by area_manual asc";
			} 
			   $db->query($sql);
			   while($row=$db->dados())
			   {
			    ?>
			<option value="<? echo $row[0]?>" <? if($row[0]==$p) { echo "selected"; } ?>><? echo $row[1]?></option>
            <? } ?>
		    </select></td>
			<? if($_REQUEST[parametro]<>'')
			{ 
			 echo "<script>atualiza_manual('$p')</script>";
			}
			?>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;<span class="texto_bold">Itens:</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
          <td colspan="3" ><div id='atualiza_manual'>
            &nbsp;
            <select  size="1" multiple class="combo_menu" >
            <option value="#" ></option>
			</select>
          </div></td>
          </tr>
      </table>
      <br>
	</td>
  </tr>
</table>
</body>
</html>
