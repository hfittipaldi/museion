<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css"> 
</head>

<body>      
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <td width="512" valign="top"><form name="form1" method="post" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$id=$_REQUEST['id']; // id do autor corrente
$op=$_REQUEST['op'];
 if(isset($_REQUEST[id]))
 {
  if($op=='view')
   {
    //$sql="SELECT a.* from autor_bibliografia as a where a.autor='$_REQUEST[id]' and bibliografia='$_REQUEST[biblio]'";
     $sql="SELECT a.*,b.* from autor_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
	  where a.autor='$_REQUEST[id]' and a.bibliografia='$_REQUEST[bib]'";
	$db->query($sql);
    $res=$db->dados();
	}
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr class="texto" valign="top">
          <td width="13%"><div align="right">Autoria:</div></td>
          <td width="71%" colspan="2"><? echo $res[autoria] ?></td>
          <td width="16%">&nbsp;</td>
        </tr>
        <tr class="texto" valign="top">
          <td><div align="right">ISBN:</div></td>
          <td colspan="2"><? echo $res[isbn] ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto" valign="top">
          <td><div align="right">Referência: </div></td>
          <td colspan="2"><b><em><? echo htmlentities($res['referencia'], ENT_QUOTES); ?></b></em></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto" valign="top">
          <td><div align="right">Sub-título:</div></td>
          <td colspan="2"><? echo $res[sub_titulo] ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto" valign="top">
          <td><div align="right">Local: </div></td>
          <td colspan="2"><? echo htmlentities($res['local'], ENT_QUOTES); ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto" valign="top">
          <td><div align="right">Editora: </div></td>
          <td colspan="2"><? echo htmlentities($res['editora'], ENT_QUOTES); ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto" valign="top">
          <td><div align="right">Ano: </div></td>
          <td colspan="2"><? echo htmlentities($res['ano'], ENT_QUOTES); ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto" valign="top">
          <td><div align="right">Notas:</div></td>
          <td colspan="2"><? echo $res[notas] ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto" valign="top">
          <td><div align="right">Obs: </div></td>
          <td colspan="2"><? echo htmlentities($res['observacao'], ENT_QUOTES); ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><br><? echo "<a href=\"bibliografia.php?op_autor=view&lista=1&autid=$_REQUEST[id]\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></td>
		  <? if ($res[txt_legado]<>'') { ?>
	          <td id="arealegado" class="texto_bold"><? // echo $res[txt_legado]; ?></td>
	          <? } ?>
   	      <td>&nbsp;</td>
          <td valign="top"><div align="right"><span class="texto_bold">
          </span></div></td>
          <td>&nbsp; </td>
        </tr>
      </table>
      <br>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
