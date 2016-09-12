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
    if(autoria.value==''){
	  alert('Informe a autoria.');
	  autoria.focus();
	  return false;}
    if(descricao.value==''){
	  alert('É necessário preencher com a referência!');
	  descricao.focus();
	  return false;}
  }
}
</script>  
</head>

<body  onload='document.form1.autoria.focus()'>      
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <td width="512" valign="top"><form name="form1" method="post" onSubmit="return valida()" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$id=$_REQUEST['id']; // id do autor corrente
$op=$_REQUEST['op'];
$obra=$_REQUEST['obra'];

	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
	if ($movid <> '') {
		$tipo= 'movimentacao';
		$valor= $movid;
		$parametro= 'movid';
	}
	elseif ($obrid <> '') {
		$tipo= 'obra';
		$valor= $obrid;
		$parametro= 'obrid';
	}
	elseif ($autid <> '') {
		$tipo= 'autor';
		$valor= $autid;
		$parametro= 'autid';
	}
	else
		echo "<script>alert('Tipo não informado!'); history.back();</script>";



 if(isset($_REQUEST[id]))
 {
  if($op=='update')
   {
    //$sql="SELECT a.* from autor_bibliografia as a where a.autor='$_REQUEST[id]' and bibliografia='$_REQUEST[biblio]'";
     $sql="SELECT a.*,b.* from autor_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
	  where a.autor='$_REQUEST[id]' and a.bibliografia='$_REQUEST[bib]'";
	$db->query($sql);
    $res=$db->dados();
	}
  if($op=='del')
  {
     $sql="DELETE from autor_bibliografia where autor='$_REQUEST[id]' and bibliografia='$_REQUEST[bib]'";
	 $db->query($sql);
//ATUALIZA ALTERAÇÃO DO AUTOR
	$sql="UPDATE autor set atualizado='$_SESSION[snome]', data_catalog2=now() where autor = $_REQUEST[id]";
	$db->query($sql);
	// atualização na ficha
	$sql="select data_catalog2 from autor where autor = $_REQUEST[id]";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$_SESSION[snome]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','$_REQUEST[id]','0',now())";
$db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='bibliografia.php?id=$_REQUEST[id]'</script>";
	 exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr class="texto_bold" style="color: gray;" > <em> Detalhes da referência bibliográfica nº <? echo htmlentities($res['bibliografia'], ENT_QUOTES); ?></em>
        </tr>
        <tr class="texto_bold" style="color: navy;">
          <td width="13%"><div align="right">Autoria*:</div></td>
          <td width="71%" colspan="2"><input name="autoria" type="text" class="combo_cadastro" id="autoria" value="<? echo htmlentities($res['autoria'], ENT_QUOTES); ?>" size="64" maxlength="255"></td>
          <td width="16%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">ISBN:</div></td>
          <td colspan="2"><input name="isbn" type="text" class="combo_cadastro" id="isbn" value="<? echo htmlentities($res['isbn'], ENT_QUOTES); ?>" size="40"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right" style="color: navy;">Referência*: </div></td>
          <td colspan="2"><input name="descricao" type="text" class="combo_cadastro" id="descricao" value="<? echo htmlentities($res['referencia'], ENT_QUOTES); ?>" size="64"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Local: </div></td>
          <td colspan="2"><input name="local" type="text" class="combo_cadastro" id="local" value="<? echo htmlentities($res['local'], ENT_QUOTES); ?>" size="64"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Editora: </div></td>
          <td colspan="2"><input name="editora" type="text" class="combo_cadastro" id="editora" value="<? echo htmlentities($res['editora'], ENT_QUOTES); ?>" size="64"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right" style="color: navy;">Ano*: </div></td>
          <td colspan="2"><input name="ano" type="text" class="combo_cadastro" id="ano" value="<? echo htmlentities($res['ano'], ENT_QUOTES); ?>" size="5"><em> (preencha com '0' para referência sem data)</em></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Observa&ccedil;&atilde;o: </div></td>
          <td colspan="2"><input name="observacao" type="text" class="combo_cadastro" id="observacao" value="<? echo htmlentities($res['observacao'], ENT_QUOTES); ?>" size="64"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><br><? echo "<a href=\"bibliografia_insere1.php?obra=$obra\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></td>

 		  <? if ($res[txt_legado]<>'') { ?>
	          <td id="arealegado" class="texto_bold"><textarea cols="60" rows="2" name="legado" class="combo_cadastro" style="border: 1px dashed;" readonly><? echo $res[txt_legado]; ?></textarea><img src="imgs/icons/ic_ok.gif" style="cursor:pointer;" border="0" title="Apagar texto do Sistema Donato 2..4" onClick="if (confirm('Tem certeza que deseja apagar definitivamente o texto?')) {document.form1.txtlegado.value=''; document.form1.legado.style.display='none'; this.style.display='none'; document.getElementById('arealegado').innerHTML='<font style=color:#223366;>O texto será apagado quando a referência for gravada.</font>';}"></td>
		  <? } ?>
   	      <td>&nbsp;</td>
          <td valign="top"><div align="right"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </span></div></td>
          <td>&nbsp; <input type="hidden" name="txtlegado" value="<? echo $res[txt_legado] ?>"></td>
        </tr>
        <tr class="texto_bold" style="color: navy;">
          <td colspan="2">&nbsp;(*) Campos obrigatórios</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
      <?

if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
     $sql="UPDATE bibliografia set
	  isbn='$_REQUEST[isbn]',
	  autoria='$_REQUEST[autoria]',
	  referencia='$_REQUEST[descricao]',
	  local='$_REQUEST[local]',
	  editora='$_REQUEST[editora]',
	  ano='$_REQUEST[ano]',
	  observacao='$_REQUEST[observacao]',
	  txt_legado='$_REQUEST[txtlegado]'
	                    where bibliografia='$_REQUEST[bib]'";
     $db->query($sql);
//ATUALIZA ALTERAÇÃO DO AUTOR
	$sql="UPDATE autor set atualizado='$_SESSION[snome]', data_catalog2=now() where autor = $_REQUEST[id]";
	$db->query($sql);
	// atualização na ficha
	$sql="select data_catalog2 from autor where autor = $_REQUEST[id]";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$_SESSION[snome]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','$_REQUEST[id]','0',now())";
$db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='bibliografia.php?id=$_REQUEST[id]'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
	   $sql= "INSERT INTO bibliografia(referencia,isbn,autoria,txt_legado,local,editora,ano,observacao) 
	 values('$_REQUEST[descricao]','$_REQUEST[isbn]','$_REQUEST[autoria]','','$_REQUEST[local]','$_REQUEST[editora]','$_REQUEST[ano]','$_REQUEST[observacao]')";
	 $db->query($sql);
     $idbib=$db->lastid(); //id da bibliografia
	 //Associando autor à bibliografia
	  $sql="INSERT INTO autor_bibliografia(autor,bibliografia)values('$_REQUEST[id]','$idbib')";
	  $db->query($sql);
//ATUALIZA ALTERAÇÃO DO AUTOR
	$sql="UPDATE autor set atualizado='$_SESSION[snome]', data_catalog2=now() where autor = $_REQUEST[id]";
	$db->query($sql);
	// atualização na ficha
	$sql="select data_catalog2 from autor where autor = $_REQUEST[id]";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$_SESSION[snome]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','$_REQUEST[id]','0',now())";
$db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='bibliografia.php?id=$_REQUEST[id]'</script>";
	 
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
