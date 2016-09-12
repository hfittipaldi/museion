<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function abre_url_combo(qual)
 {
  if (qual.selectedIndex.selected != '') {
 var campo = qual.value;
 if(campo.value==0)
document.location=('menus.php');
else
document.location=('menus.php?item='+ campo);
 }
}

</script>

</head>

<body>
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
//$val=$_REQUEST['local'];
$op=$_REQUEST['op'];
montalinks();
$_SESSION['lnk']=$link;
?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="5" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="41%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Nome </div></td>
          <td width="13%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Item</div></td>
          <td width="22%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Chamada</div></td>
          <td colspan="2" bgcolor="#ddddd5" class="texto_bold"><div align="left"><span class="tit_interno">
              <?

$sql="SELECT a.* from menu_item as a where length(a.item)=1 order by a.item asc";
$db->query($sql);
$item= $_REQUEST['item'];

while($row=$db->dados())
{
	$x=$row[nome];
	$y=$row[item];
	if ($y == $item) { 
		$combo.="<option value='$y' selected>$y. $x</option>";
	} else {
		$combo.="<option value='$y'>$y. $x</option>";
	}
}
if ($item == 0) { 
	$combo = $combo . "<option value='0' selected>&nbsp;&nbsp;</option>";
}
echo "<select size=\"1\" name=\"campo\" onchange=abre_url_combo(this,this.value)> $combo </select>";

?>
          </span></div></td>
          </tr>
        <tr>
          <td colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr><?
 //////////////////
  function habilita($valor,$b)
{
global $b;// para obter o valor de $linha[menu_item] do while
///Habilita/nao campo excluir se houver/nao dependencia
$sql="SELECT count(posicao) as total from menu_item where posicao='$valor'";
$db=new conexao();
$db->query($sql);
$total=$db->dados();
if($total[0] > 0) {
$img="imgs/icons/ic_bloquear.gif";
echo "<img src='$img'>"; }
else{
echo "<a href=\"menus1.php?op=del&menu_item=$b\" onClick='return confirm(".'"Confirma Exclusão do Registro ?"'.")'>
<img src='imgs/icons/ic_excluir.gif' width='20' height='20'
	   border='0' alt='Excluir' 
		onMouseOver='document.getElementById(\"cor_fundo".$b."\").style.backgroundColor=\"#ddddd5\";' 
		onMouseOut='document.getElementById(\"cor_fundo".$b."\").style.backgroundColor=\"\";'>";}
}
 //////////////////
if($item<>'')
{
$sql="SELECT a.* from menu_item as a where item like'$item%' order by item asc";
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
				$c=array($linha['item']); 
				// $c var extra pra permitir habilitar/nao o botao lixeira<br>
                // se tamanho=1 &eacute; pai e nao pode apagar
		 foreach($c as $valor)
		 {
		?>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
        <tr class="texto" id="cor_fundo<? echo $linha['menu_item'] ?>">
          <td align="justify" width='41%'><span class="marrom10b"><span class="marrom11"><? echo $y ?></span></span></td>
          <td align="center" width='13%'><span class="marrom10b"><? echo $x ?></span></td>
          <td width='22%'><div align="center">
		    <span class="marrom11"><? echo $w ?></span>            </div></td>
          <td align="center" width='12%'><span class="marrom10b">
            <? habilita($valor,$b);?>
          </span>
            <div align="center"></div></td>
          <td align="center" width='12%'><? echo "<a href=\"menus1.php?op=update&menu_item=$linha[menu_item]&item=$linha[item]\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar'
	 onMouseOver='document.getElementById(\"cor_fundo".$linha[menu_item]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$linha[menu_item]."\").style.backgroundColor=\"\";'>"; }}}}?>
	 <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td colspan="2"></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="3">&nbsp;</td>
          <td></td>
          <td align="center"><? echo "<a href=\"menus1.php?op=insert\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Novo Registro' >"?></td>
        </tr> 
        <tr>
          <td height="1" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="5">               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>
       <p><input name="menu_item" type="hidden" id="menu_item" value="<? echo $linha[menu_item] ?>">
          <input name="item" type="hidden" id="item" value="<? echo $linha[item] ?>">

		  <input name="op" type="hidden" id="op" value="<? echo $op ?>">
	    </p>
      </form>
    </td>
  </tr>
</table>
</body>
</html>
