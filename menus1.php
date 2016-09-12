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
    if(nome.value==''){
	  alert('Preencha com o nome do menu.');
	  nome.focus();
	  return false;}
	 if(item.value=='')
	 {
	   alert('Preencha com o item do menu.');
	   item.focus();
	  return false;}
  }
}
</script>  
</head>
<body onload='self.document.form1.nome.focus();'>      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
//$val=base64_decode($_REQUEST['item']);
$val=$_REQUEST['menu_item'];
$item=$_REQUEST['item'];
$op=$_REQUEST['op'];
echo $_SESSION['lnk'];

	?></div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post">
<?
 if(isset($val))
 {
  if($op=='update')
   {
    $sql="SELECT a.* from menu_item as a where a.menu_item='$val'";
	$db->query($sql);
    $res=$db->dados();
	}
  if($op=='del')
  {
     $sql="DELETE from menu_item where menu_item='".desformatar($val)."'";
     $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='menus.php'</script>";
	 exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4" >
        <tr>
          <td height="30" colspan="2" class="texto_bold"><div align="left"><br><br><br>&nbsp;&nbsp;&nbsp;Nome:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;              
              <input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo $res[nome] ?>" size="30">
&nbsp;          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item:&nbsp;
          <input name="item" type="text" class="combo_cadastro" id="item" value="<? echo formata($res[item]) ?>" size="5">
          </div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2">&nbsp;&nbsp;&nbsp;Chamada:            
            <input name="chamada" type="text" class="combo_cadastro" id="chamada" value="<? echo $res[chamada] ?>" size="53"></td>
        </tr>
        <tr>
          <td colspan="2">
            <input name="val" type="hidden" id="op" value="<? echo $val ?>">
          
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
          <input name="in" type="hidden" id="in" value="<? echo formata($res[item]) ?>">
          </span></td>
        </tr>
        <tr>
          <td>
            <div align="left"><? echo "<a href=\"javascript:history.go(-1)\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td><div align="center"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar" onclick='return valida()'>
          </span></div></td>
        </tr>
      </table>
      <br>
<?
   /////////////////TRATANDO CAMPO ITEM //////
	$item=desformatar($_REQUEST['item']);
    $posicao=corta_valor($item);
    $ordem=substr($item,-1);
   //////////////////////////////////////////

if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
     ver_item($item);
	 avalia_sql($item);
	 if($posicao=='')
	 { $posicao=0;}
     $sql="UPDATE menu_item set
	  item='$item', 
	  nome='$_REQUEST[nome]',
	  chamada='$_REQUEST[chamada]',
	  posicao='$posicao',
	  ordenacao='$ordem' 	
	    where menu_item='$_REQUEST[val]'";
	 $db->query($sql);
	
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='menus.php'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert')
  {
    ver_item($item);
	avalia_sql($item);
   if($posicao=='')
   { $posicao=0;}
   
	 $sql= "INSERT INTO menu_item(item,nome,chamada,posicao,ordenacao) 
	 values('$item','$_REQUEST[nome]','$_REQUEST[chamada]','$posicao','$ordem')";
	 $db->query($sql);
	
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='menus.php'</script>";
	 }
}   
?>
    </form>

    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
