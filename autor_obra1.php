<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style type="text/css">
select {
  behavior: url("js/select_keydown.htc");
}
</style>
<script>
function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-230)+',top='+((window.screen.height/2)-200)+',width=460,height=400, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}

function valida()
{
 with(document.form1)
 {
    if(autor.value=='0'){
	  alert('Selecione o autor!');
	  return false;}
	if(!atribuido[0].checked && !atribuido[1].checked){
	 alert('Favor marcar a opção de atribuição.');
    return false;}
	if(hierarquia.value==''){
	alert('Informe a hierarquia do autor da obra!');
	hierarquia.focus();
	return false;}
	if(hierarquia.value==0){
	alert('Informe um valor diferente de zero!');
	hierarquia.focus();
	return false;}
	
  }
}
function abre_manual(parametro)
{
  	win=window.open('manual_catalog.php?corfundo=cccccc&parametro='+parametro,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-130)+',height=450,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>  
</head>

<body>      
<table width="528" height="60%"  border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <td width="512" height="318" valign="top"><form name="form1" method="post" onSubmit="return valida()" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$op=$_REQUEST['op'];
 if(isset($_REQUEST[obra]))
 {
  if($op=='update')
   {
    $sql="SELECT a.nomeetiqueta,b.* FROM autor  AS a INNER JOIN  autor_obra as b on (a.autor=b.autor) where obra='$_REQUEST[obra]' 
	and b.autor='$_REQUEST[autor]' ";
	$db->query($sql);
    $res=$db->dados();
	}
  if($op=='del')
  {
	 // Se status = Publicada(liberada) verifica se a obra possui outro(s) autor(es); se não possui, impede o delete //
	  $sql="SELECT status from obra where obra='$_REQUEST[obra]'";
	  $db->query($sql);
	  $status_obra= $db->dados();
	  $status_obra= $status_obra['status'];
	  $sql="SELECT count(*) as tot from autor_obra where obra='$_REQUEST[obra]' AND autor <> '$_REQUEST[autor]'";
	  $db->query($sql);
	  $totautor=$db->dados();
	  if ($totautor['tot']==0 && $status_obra=='P') {
		echo "<script>alert('Não foi possível excluir!\\n\\nObra publicada não pode ficar sem autoria!');</script>";
	  }
	  else
	   {
	     $sql="DELETE from autor_obra  where autor='$_REQUEST[autor]' and obra='$_REQUEST[obra]' ";
		 $db->query($sql);
//ATUALIZA ALTERAÇÃO DA OBRA
	$sql="UPDATE obra set atualizado='$_SESSION[susuario]', data_catalog2=now() where obra = $_REQUEST[obra]";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from obra where obra = $_REQUEST[obra]";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
      $obs1="Deleção autor da obra ID_obra={".$_REQUEST[obra]."}  ID_autor={".$_REQUEST[autor]."}";
      $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now(),'$obs1')";
      $db->query($sql);

//////////////////////////////////////////////////////////////////
		 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	   }
	  echo"<script>location.href='autor_obra.php?lista=1&obra=$_REQUEST[obra]'</script>";
	  exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="2">
      <tr>
          <td colspan="2">
            <div align="left"><? echo "<a href=\"autor_obra.php?lista=1&obra=$_REQUEST[obra]\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>

        <tr class="texto_bold">
          <td width="15%"><div align="right"><a href="javascript:abre_manual(2)" tabindex="-1" class="texto_bold_especial">Autor:</a></div></td>
          <td width="50%" nowrap>
		  <select name="autor" class="combo_cadastro" id="autor" >
		 <? 
		 if($_REQUEST['op']=='update')
		 {
		  $sql="SELECT autor,nomeetiqueta from autor as a where a.autor=$_REQUEST[autor]";
		  }
		 else
		 {
		  $sql="SELECT autor,nomeetiqueta from autor as a order by a.nomeetiqueta asc";
		  echo "<option value='0' ></option>";
		  }
		  $db->query($sql);
		  
		  while($row=$db->dados())
		 {
		  ?>
		  <option  value="<? echo $row[0];?>"<? if($res[autor]==$row[0]) echo "Selected"  ?> ><? echo $row[1]; ?></option>
          <? } ?>
          </select> <? if($_REQUEST['op']!='update') { ?><a href='javascript:;' onClick="abrepop('pop_autor.php');""><img src="imgs/icons/lupa.gif" title="Pesquisar..."  border=0 )"></a><? } ?>
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(2)" tabindex="-1" class="texto_bold_especial">Fun&ccedil;&atilde;o:</a></div></td>
          <td><input name="funcao" type="text" class="combo_cadastro"  id="funcao" value="<? echo htmlentities($res['funcao'], ENT_QUOTES); ?>" size="40"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(2)" tabindex="-1" class="texto_bold_especial">Atribu&iacute;do:</a></div></td>
          <td> Sim
            <input name="atribuido" type="radio" value="S" <? if($res[atribuido]=='S'){ echo "checked"; } ?>>
&nbsp;N&atilde;o&nbsp;
<input name="atribuido" type="radio" value="N" <? if($res[atribuido]=='N'){ echo "checked"; } ?> ></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(2)" tabindex="-1" class="texto_bold_especial">Hierarquia:</a></div></td>
          <td><input name="hierarquia" type="text" class="combo_cadastro" id="hierarquia" value="<? echo $res[hierarquia] ?>" size="2" maxlength="3"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><div align="right"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </span></div></td>
          <td>&nbsp;</td>
        </tr>
        </table>
      <br>
      <?

if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
     $sql="UPDATE autor_obra set
	  autor='$_REQUEST[autor]',
	  atribuido='$_REQUEST[atribuido]',
	  funcao='$_REQUEST[funcao]',
	  hierarquia='$_REQUEST[hierarquia]'
	                    where obra='$_REQUEST[obra]' and autor='$_REQUEST[autor]'";
	 $db->query($sql);
//ATUALIZA ALTERAÇÃO DA OBRA
	$sql="UPDATE obra set atualizado='$_SESSION[susuario]', data_catalog2=now() where obra = $_REQUEST[obra]";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from obra where obra = $_REQUEST[obra]";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
      $obs1="Alteração autor da obra ID_obra={".$_REQUEST[obra]."}  ID_autor={".$_REQUEST[autor]."}";
      $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now(),'$obs1')";
      $db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='autor_obra.php?lista=1&obra=$_REQUEST[obra]'</script>";
	}

  elseif($_REQUEST[op]=='insert'){
     $sql= "INSERT INTO autor_obra(autor,obra,atribuido,funcao,hierarquia) 
	 values('$_REQUEST[autor]','$_REQUEST[obra]','$_REQUEST[atribuido]','$_REQUEST[funcao]','$_REQUEST[hierarquia]')";
	 $db->query($sql);
//ATUALIZA ALTERAÇÃO DA OBRA
	$sql="UPDATE obra set atualizado='$_SESSION[susuario]', data_catalog2=now() where obra = $_REQUEST[obra]";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from obra where obra = $_REQUEST[obra]";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
      $obs1="Inclusão autor da obra ID_obra={".$_REQUEST[obra]."}  ID_autor={".$_REQUEST[autor]."}";
      $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now(),'$obs1')";
      $db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='autor_obra.php?lista=1&obra=$_REQUEST[obra]'</script>";
	 
	 }
}   
?>
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
