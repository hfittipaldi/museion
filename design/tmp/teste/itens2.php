<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Itens</title>
<style type="text/css">
<!--
.style5 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>

<script>
function abre_url_combo(qual)
 {
  if (qual.selectedIndex.selected != '') {
 var campo = qual.value;
 if(campo.value==0)
document.location=('itens2.php');
else
document.location=('itens2.php?item='+ campo);
 }
}
function critica_in_or_up()//criticar o insert ou update do form
{
with(document.form1)
{
  if(item.value=='')
 {
    alert('Preencha campo item.')
    item.focus()
    return false;
 }
 if(item.value==0)
 {
    alert('Erro.Selecione um valor para item que seja >0')
    item.focus();
    return false; 
}
  if(nome.value=='')
  {
    alert('Preencha campo nome.')
    nome.focus()
    return false;
  }
 }   
}
</script>
</head>
<body>
<p><br>
    <span class="style5"><? $img="http://192.168.0.135/donato/teste/imgs/ic_novo.gif"; echo "<img src='$img'>"; ?>
	<a href="itens2.php?op=insert">Incluir novo registro <br></a></span><br>
     <span class="style5">Menu Principal:</span>
     <?
require("classe_padrao.php");
require("classes_extras.php");
include("funcoes_inc.php");
$db=new conexao();
$db->conecta();
$sql="SELECT a.* from menu_item as a where length(a.item)=1 order by a.item asc";
$db->query($sql);

while($row=$db->dados())
{
 
 $x=$row[nome];
 $y=$row[item];
 $combo = $combo . "<option value='$y'>$y.$x</option>";
}
$combo.="<option value='0' selected></option>";
echo "<select size=\"1\" name=\"campo\" onchange=abre_url_combo(this)> $combo</select>";

?>
<table width="644" border="0" align="left" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
   <tr align="center" class="style5">
     <td bgcolor="#00FFFF"><strong>Item</strong></td>
     <td bgcolor="#00FFFF"><strong>Nome</strong></td>
     <td bgcolor="#00FFFF"><strong>Chamada </strong></td>
     <td bgcolor="#00FFFF"><strong>Excluir</strong></td>
     <td bgcolor="#00FFFF"><strong>Alterar</strong></td>
   </tr>
   <?
 echo"<br>";
$item=$_REQUEST['item'];
if($item<>'')
{
echo"<br>";
$sql="SELECT a.* from menu_item as a where item like'$item%' order by item asc";

///// classe_extras.php ///
$cor_linha= new linha_cor();
$cor_linha->adicionar_cor('66CCFF');
$cor_linha->adicionar_cor('00FFFF');
/////////////////////////////////
$db->query($sql);
$i=$db->contalinhas();
  if ($i > 0)
   {
     while ($linha = $db->dados())
      {
                
				$x=formata($linha['item']);
				$y=$linha['nome'];
				$w=$linha['chamada'];
				$a=$linha['ordenacao'];
	            $b=$linha['menu_item'];   
				

?>

   <tr bgcolor='<? echo $cor_linha->exibir_cor(); ?>' class="style5">
     <td width="63" class="marrom10b">     <? echo $x ?>
       <div align="center"></div></td>
     <td width="276" class="marrom10b"><div align="left"><span class="marrom11"><? echo $y ?></span></div></td>
     <td width="166" class="marrom10b"><div align="left"><span class="marrom11"><? echo $w ?></span></div></td>
     <td width="60" align="left" class="marrom11"><div align="center"><span class="marrom10b">
         <? 
echo "<a href=\"itens2.php?op=del&menu_item=".($b)."&item=".desformatar($x)."\"
	  onClick='return confirm(".'"Confirma Exclusao do Registro ?"'.")'><img src=./imgs/ic_excluir.gif width='20' height='20'
	   border='0' alt='Excluir'>" ?>
     </span></div></td>
     <td width="62" align="left" class="marrom11"><div align="center"><span class="marrom10b"><? echo "<a href=\"itens2.php?op=update&item=$x\">
	 <img src=./imgs/ic_alterar.gif width='20' height='20'
	   border='0' alt='Alterar'>" ?></span></div></td>
   </tr>
   <? } }}?>
</table>
 <p>&nbsp;</p>
 <br>
 <p>&nbsp;<? if($_REQUEST['op']=='insert')
             { 
print"<form name='form1' action='itens3.php' method=\'get\' onSubmit='return critica_in_or_up()'>
<table width='300' border='0'>
    <tr>
      <td><table width='300' border='0'>
          <tr>
            <td width='77' class='style5'>Item: </td>
            <td width='413' class='style5'><input name='item' type='text' id='item' size='7' class='style5'>
            </td>
          </tr>
        </table>
          <table width='300' border='0'>
            <tr>
              <td width='59' class='style5'>Nome:</td>
              <td width='231'><input name='nome' type='text' id='nome'  class='style5'></td>
            </tr>
          </table>
          <table width='300' border='0'>
            <tr>
              <td width='87' class='style5'>Chamada:</td>
              <td width='403'><input name='chamada' type='text' class='style5' id='chamada'></td>
            </tr>
          </table>
          <table width='300' border='0'>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input name='Submit' type='submit' class='style5' value='Enviar'></td>
            </tr>
        </table></td>
    </tr>
  </table>
</form>";
}
elseif($_REQUEST['op']=='update')
	{
	//$sql="select * from menu_item as a where a.item='".desformatar($x)."'";
	$sql="select * from menu_item as a where a.item='".desformatar($_REQUEST[item])."'"; 
   // echo $sql;
	 $db->query($sql);
     while($row=$db->dados())
	 {
	    print
		"<form name='form1' method='post' action='itens3.php' onSubmit='return critica_in_or_up()'>
  <table width='300' border='0'>
    <tr>
      <td><table width='300' border='0'>
          <tr>
            <td width='77' class='style5'>Item: </td>
            <td width='413' class='style5'><input name='item' type='text' class='style5' id='item' value='".formata($row[item])."' size='5'>
            </td>
          </tr>
        </table>
          <table width='300' border='0'>
            <tr>
              <td width='59' class='style5'>Nome:</td>
              <td width='231'><input name='nome' type='text' class='style5' id='nome' value='$row[nome]'></td>
            </tr>
          </table>
          <table width='300' border='0'>
            <tr>
              <td width='60' class='style5'>Chamada:</td>
              <td width='230'><input name='chamada' type='text' class='style5' id='chamada' value='$row[chamada]'></td>
            </tr>
          </table>
          <table width='300' border='0'>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input name='Submit' type='submit' class='style5' value='Atualizar'></td>
            </tr>
        </table></td>
    </tr>
  </table>
</form>";
 }}  
 elseif($_REQUEST['op']=='del')
 {
   $sql="SELECT count(posicao) as total from menu_item where posicao='$_REQUEST[item]'";
   $db->query($sql);
   $total=$db->dados();
     if($total[0] > 0)
        {
           echo"<script>alert('Menu hierarquico para o item:".formata($_REQUEST[item]).".Apague primeiramente as dependências!')</script>";
           echo"<script>location.href='itens2.php?item=".$_REQUEST[item]{0}."'</script>";
         }
     else
     { 
         $sql="DELETE from menu_item where item='$_REQUEST[item]'";
	     $db->query($sql);
		 echo"<script>alert('Exclusao do item:".formata($_REQUEST[item])." realizada com sucesso!')</script>";
         echo"<script>location.href='itens2.php?item=".$_REQUEST[item]{0}."'</script>";
     }
	}
 ?>

 </p>
</body>
</html>
