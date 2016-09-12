<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function marcar_todas() {
	var marca='start';
	for (i=0; i<document.form1.length; i++) {
		var tempobj= document.form1.elements[i];
		if (tempobj.type == 'checkbox') {
			if (marca=='start') {
				tempobj.checked= !tempobj.checked;
				marca= tempobj.checked;
			} else {
				tempobj.checked= marca;
			}
		}
	}
}
//
</script>

</head>

<body>
<table width="270"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2 >
  <tr>
    <th width="356" scope="col"><div align="left" class="tit_interno">
      <? 

include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=$_REQUEST['usuario'];
$op=$_REQUEST['op'];
$item=$_REQUEST['item'];

/////////////////////////
function converte()
{
//utilizada pra toda vez q ocorrer um update na permissao nao precisar colocar o usuario corrente
// em uma sessao;
global $db;
  $sql="select a.nome from usuario as a where a.usuario='$_REQUEST[usuario]'";
  $db->query($sql);
  $res=$db->dados();
return $res[0];
}  

$sql="SELECT a.item,a.nome,a.posicao from menu_item as a where item like'$item%' ORDER by a.item asc";
$db->query($sql);
$cont_nivel[1]=10000;
$cont_nivel[2]=1000;
$cont_nivel[3]=100;
$cont_nivel[4]=10;
$cont_nivel[5]=1;
while($row=$db->dados())
{
  $nivel=strlen($row[item]); //nivel=nº de algarismos
  $diferenca=strlen($row[item]) - strlen($row[posicao]);	// ex. item=6210, posicao(pai)=62

  if ($diferenca > 1) {
	  $valor=$row[item] * $cont_nivel[$nivel] + 1;
	  $nivel--;
	  while ($vet_ordenacao[$valor]["item"] <> 0)	// evita que um elemento seja sobreescrito
		$valor++;
  }
  else
	  $valor=$row[item] * $cont_nivel[$nivel];

  $vet_ordenacao[$valor]["nome"]=$row[nome];
  $vet_ordenacao[$valor]["item"]=$row[item];
  switch($nivel) {
  	case 1: $espaco="&nbsp;"; break;
 	case 2: $espaco="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; break;
 	case 3: $espaco="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; break;
 	case 4: $espaco="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; break;
 	case 5: $espaco="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; break;
  }
  $vet_ordenacao[$valor]["espaco"]=$espaco;
}

?>
    </div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post">
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td height="24" class="texto_bold"><div align="center" >
             <? echo converte($_REQUEST['usuario']) ?><br><input type="button" name="marcar" value="marcar/desmarcar todas" class="texto" onClick="marcar_todas();"></div>
            <br><div align="center"></div>            <div align="center"></div>            <div align="center"></div></td>
          </tr>
		  <?
		  		ksort($vet_ordenacao);
				foreach ($vet_ordenacao as $x)
				{
		    	  $sql="select distinct(item) from usuario_menu_item where item='$x[item]' and usuario='$_REQUEST[usuario]'";
			      $db->query($sql);
				  $tot=$db->contalinhas();
				  if($tot>0)
				    $tipo="checked";
				   else
				    $tipo="unchecked";
			
			      ?>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#f2f2f2">
        <tr class="texto">
          <td colspan="4" align="" class="texto"><? echo $x['espaco']; ?><input  align="left" type="checkbox" name="item_selected[]" value="<?php echo $x['item']; ?>" <? echo $tipo ?> >
            <? echo $x['nome']; ?></td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="center" class="texto"><? } ?></td>
        </tr>
        <tr> 
          <td height="10" colspan="4" style="border-bottom:2px solid #000000;"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>
        <tr class="texto">
          <td  colspan="4" align="center" class="texto"><br><input name="submit" type="submit" class="botao" value="Enviar"></td>
        </tr>
		<tr>
		  <td colspan="4"><? echo "<a href=\"javascript:history.go(-1)\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></td>
		</tr>
        <tr class="texto">
          <td width="50%"></td>
          <td width="26%"></td>
          <td width="12%"></td>
          <td width="12%"></td>
        </tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <span class="texto">       </span>
       <p>
          <input name="usuario" type="hidden" id="usuario" value="<? echo $_REQUEST['usuario'] ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
        </p>
    </form>
       </td>
  </tr>
</table>
</body>
</html>
<?
if($_REQUEST['submit'])
{
 global $db;
 global $item;
// $_SESSION[name]=$_REQUEST[name];
     if($op=='insert')
      { 
	  while(list($campo,$valor)= each($_REQUEST[item_selected])) 
        {
	      $sql="insert into usuario_menu_item(usuario,item) values('$_REQUEST[usuario]','$valor')";
          $db->query($sql);
		 }
          echo"<script>alert('Inclusão realizada com sucesso!')</script>";
		  //colocar a opcao de desabilitar caso ja tenha selecionado ou forçar a realizar um update naquele menu selecionado.
          echo"<script>location.href='usuario_perm.php?op=$op&usuario=$_REQUEST[usuario]'</script>";
	}
  if($op=='update')
      {
	    $sql="delete from usuario_menu_item where usuario='$_REQUEST[usuario]' and item like '$item%'";
		$db->query($sql);
		if (!empty($_REQUEST[item_selected])) {
	    while(list($campo,$valor)= each($_REQUEST[item_selected]))
	     {
            $sql="insert into usuario_menu_item(usuario,item) values('$val','$valor')";
			$db->query($sql);
	      }
		}
		 echo"<script>alert('Alteração efetuada com sucesso!')</script>";
         echo"<script>location.href='usuario_perm.php?op=$op&usuario=$_REQUEST[usuario]'</script>";
	   }
 } 
?>
