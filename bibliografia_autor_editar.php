<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual) {
	if (qual.selectedIndex.selected != '') {
                document.location=('bibliografia1.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);
	}
}
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

<body>      
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr>
    <td width="100%" height="100%" valign="top"><form name="form1" method="post" onSubmit="return valida()" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();

$dbreg=new conexao();
$dbreg->conecta();
$autoria=$_REQUEST[autoria];

$tipo=$_REQUEST[tipo];

       $op=$_REQUEST[op];


$referencia=$_REQUEST[nome];
$bibliografia=$_REQUEST['bib'];
$autor=$_REQUEST['autid'];
$parametro="autor";
$obs=$_REQUEST['observacao'];
$autor=$_REQUEST['autor'];
	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
	if ($movid <> '') {
		$tipo= 'movimentacao';
		$valor= $movid;
		$parametro= 'movid';
	}
	elseif ($obrid <> '') {
		$tipo= 'autor';
		$valor= $obrid;
		$parametro= 'obrid';
	}
	elseif ($autid <> '') {
		$tipo= 'autor';
		$valor= $autid;
		$parametro= 'autid';
	}

$sql="SELECT a.bibliografia, a.*,b.autor, b.observacao
                         FROM bibliografia as a INNER JOIN autor_bibliografia as b on  (a.bibliografia=b.bibliografia)
                         where (b.bibliografia='$_REQUEST[bib]') and (b.autor='$_REQUEST[autid]')";

   $db->query($sql);
   $res=$db->dados();
   if ($res['bibliografia'] <> '') {
       echo"<script>alert('Bibliografia já associada.')</script>";
       echo"<script>location.href='bibliografia_insere2.php?lista=1&autor=$autor&nome=$referencia&op=insert&".$parametro."=".$valor."&bib=$bib;'</script>";
    }

$sql1="SELECT a.bibliografia,  b.observacao
                         FROM bibliografia as a INNER JOIN  autor_bibliografia as b on  (a.bibliografia=b.bibliografia)
                         where (b.bibliografia='$_REQUEST[bib]') and (b.autor='$_REQUEST[obrid]')";

   $db->query($sql1);
   $resobs=$db->dados();
   $obs=$resobs[observacao]; 

if($_REQUEST['op']=='update')
{

 $sql="SELECT * from bibliografia  where bibliografia='$_REQUEST[bib]'";
  $db->query($sql);
  $res=$db->dados();
}
if($_REQUEST['op']=='del')
{
 $sql="DELETE from autor_bibliografia where autor=".$autid." and bibliografia='$_REQUEST[bib]'";
 $db->query($sql);
//ATUALIZA ALTERAÇÃO DA AUTOR
	$sql="UPDATE autor set atualizado='$_SESSION[susuario]', data_catalog2=now() where autor =".$autid;
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from autor where autor = ".$autid;
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
$sqlreg="SELECT nomeetiqueta FROM autor WHERE autor='$autor'";
$dbreg->query($sqlreg);
$registro=$dbreg->dados();
$obs1="Alteração autor ID={".$autid."}";
$obs1=$obs1. "Ação={Excluída a bibliografia:".$_REQUEST[bib]."}";
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('A','$_SESSION[susuario]','$_REQUEST[autid]','0',now(),'$obs1')";
$db->query($sql);
//////////////////////////////////////////////////////////////////
 echo"<script>alert('Exclusão realizada com sucesso')</script>";
 echo"<script>location.href='bibliografia.php?lista=1&autid=$autid'</script>";
 }
?>

         <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">

	     <tr><td>&nbsp;</td></tr>
             <tr width="100%">
                <td colspan="3 class="texto_bold">&nbsp;</td>
             </tr>
             <tr bgcolor="#96ADBE">
                <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
             </tr>

             <tr bgcolor="#96ADBE">


                <td height="24" bgcolor="#96ADBE" class="texto_bold" style="color: white;"><div align="left"> Detalhes da referência bibliográfica a vincular nº <? echo $res['bibliografia']; ?></div></td>
                <td valign="top"><? echo "<a href=\"bibliografia_insere2.php?lista=1&autoria=".$autoria."&nome=".htmlentities($referencia, ENT_QUOTES)."&".$parametro."=".$valor."&tipo=".$tipo."&bib=".$bib."\"'><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar'>"; ?></td>

             </tr>
             <tr>
                <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
             </tr>
          </table>       

<table width="100%"  border="0" cellpadding="0" cellspacing="4">
	<br>
        <tr class="texto_bold" style="color: gray;" > <em> Detalhes da referência bibliográfica nº <? echo htmlentities($res['bibliografia'], ENT_QUOTES); ?></em>
        </tr>
        <tr class="texto_bold" style="color: navy;" >
          <td><div align="right"><br>Autoria*:</div></td>
          <td colspan="2"><br><input name="autoria" type="text" class="combo_cadastro" id="autoria" value="<? echo htmlentities($res['autoria'], ENT_QUOTES); ?>" size="75"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">ISBN:</div></td>
          <td colspan="2"><input name="isbn" type="text" class="combo_cadastro" id="isbn" value="<? echo htmlentities($res['isbn'], ENT_QUOTES); ?>" size="40"> </td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Referência*:</div></td>
        <? if(($_REQUEST[op]=='insert')and ($res['referencia']=='')){?>
             <td width="50%" colspan="2"><input name="descricao" type="text" class="combo_cadastro" id="descricao" value='<?echo $referencia?>' size="80"></td>
        <? }else{?>
            <td width="50%" colspan="2"><input name="descricao" type="text" class="combo_cadastro" id="descricao" value='<? echo htmlentities($res['referencia'], ENT_QUOTES); ?>' size="75"></td>
        <? }?>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Sub-título:</div></td>
          <td width="50%" colspan="2"><input name="sub_titulo" type="text" class="combo_cadastro" id="sub_titulo" value='<? echo htmlentities($res['sub_titulo'], ENT_QUOTES); ?>' size="75">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Local:</div></td>
          <td width="50%" colspan="2"><input name="local" type="text" class="combo_cadastro" id="local" value='<? echo htmlentities($res['local'], ENT_QUOTES); ?>' size="75">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Editora:</div></td>
          <td width="50%" colspan="2"><input name="editora" type="text" class="combo_cadastro" id="editora" value='<? echo htmlentities($res['editora'], ENT_QUOTES); ?>' size="75">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Ano*:</div></td>
          <td width="50%" colspan="2"><input name="ano" type="text" class="combo_cadastro" id="ano" value='<? echo htmlentities($res['ano'], ENT_QUOTES); ?>' size="5">
		 <em> (preencha com '0' para referência sem data)</em></td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Notas:</div></td>
          <td width="50%" colspan="2"><input name="notas" type="text" class="combo_cadastro" id="notas" value='<? echo htmlentities($res['notas'], ENT_QUOTES); ?>' size="75">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Observa&ccedil;&atildeo:</div></td>
          <td width="50%" colspan="2"><input name="observacao" type="text" class="combo_cadastro" id="observacao" value='<? echo htmlentities($resobs['observacao'], ENT_QUOTES); ?>' size="75">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><br></td>
		  <? if ($res[txt_legado]<>'') { ?>
	          <td id="arealegado" class="texto_bold"><textarea cols="70" rows="5" name="legado" class="combo_cadastro" style="border: 1px dashed;" readonly>
                  <? echo $res[txt_legado]; ?></textarea><img src="imgs/icons/ic_ok.gif" style="cursor:pointer;" border="0" title="Apagar texto do Sistema Donato 2..4" onClick="if (confirm('Tem certeza que deseja apagar definitivamente o texto?')) {document.form1.txtlegado.value=''; document.form1.legado.style.display='none'; this.style.display='none'; document.getElementById('arealegado').innerHTML='<font style=color:#223366;>O texto será apagado quando a referência for gravada.</font>';}"></td>
		  <? } ?>
   	      <td>&nbsp; </td>
          <td>&nbsp; <input type="hidden" name="txtlegado" value="<? echo $res[txt_legado] ?>"></td>
        </tr>
        <tr class="texto_bold" style="color: navy;">
          <td colspan="0">&nbsp;(*) Campos obrigatórios</td>

        <td valign="top"><div align="right"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </span></div></td> 

          <td>&nbsp;</td>
        </tr>
      </table>
  <?
if ($_REQUEST[ano]=='') {$_REQUEST[ano]='0';}
if($_REQUEST['enviar']<>'')
{
if($_REQUEST[op]=='insert')
  {
     $sql= "INSERT INTO bibliografia(referencia,isbn,autoria,txt_legado,local,editora,ano,sub_titulo,notas) 
	 values('$_REQUEST[descricao]','$_REQUEST[isbn]','$_REQUEST[autoria]','','$_REQUEST[local]','$_REQUEST[editora]','$_REQUEST[ano]','$_REQUEST[sub_titulo]','$_REQUEST[notas]')";
	 $db->query($sql);
	 $idbib=$db->lastid(); //id da bibliografia
	//Vinculo 
     $sql="INSERT INTO autor_bibliografia(autor,bibliografia,observacao) values('$valor','$idbib','$_REQUEST[observacao]')";
	$db->query($sql);
//ATUALIZA ALTERAÇÃO DA AUTOR
	$sql="UPDATE autor set atualizado='$_SESSION[susuario]', data_catalog2=now() where autor = $valor";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from autor where autor = $valor";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
   $sqlreg="SELECT nomeetiqueta FROM autor WHERE autor='$autor'";
   $dbreg->query($sqlreg);
   $registro=$dbreg->dados();
   $obs1="Alteração autor ID={".$valor."}";
   $obs1=$obs1. "Ação={Inclusão de nova bibliografia:".$idbib."}";
   if ($obs1<>''){
      $obs1=$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','$_REQUEST[autid]','0',now(),'$obs1')";
      $db->query($sql);}
//////////////////////////////////////////////////////////////////
	echo"<script>alert('Inclusão realizada com sucesso.')</script>";
               echo"<script>location.href='bibliografia_insere2.php?lista=1&autor=$autor&nome=$referencia&op=insert&".$parametro."=".$valor."&bib=$bib;'</script>";

  }
if ($_REQUEST[ano]=='') {$_REQUEST[ano]='0';}
if($_REQUEST[op]=='update')
{

   $sql1="INSERT INTO autor_bibliografia(autor,bibliografia,observacao) values('$_REQUEST[autid]','$_REQUEST[bib]','$_REQUEST[observacao]')";
  
	$db->query($sql1);


      $sql="UPDATE bibliografia set
	  isbn='$_REQUEST[isbn]',
	  autoria='$_REQUEST[autoria]',
	  referencia='$_REQUEST[descricao]',
	  txt_legado='$_REQUEST[txtlegado]',
	  local='$_REQUEST[local]',
	  editora='$_REQUEST[editora]',
	  sub_titulo='$_REQUEST[sub_titulo]',
	  notas='$_REQUEST[notas]',
	  ano='$_REQUEST[ano]'
	                    where bibliografia='$_REQUEST[bib]'";
     $db->query($sql);
      $sql="UPDATE autor_bibliografia set
	  observacao='$_REQUEST[observacao]'
	                    where bibliografia='$_REQUEST[bib]' and $tipo=$valor";
     $db->query($sql);


//ATUALIZA ALTERAÇÃO DA AUTOR
	$sql="UPDATE autor set atualizado='$_SESSION[susuario]', data_catalog2=now() where autor = $valor";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from autor where autor = ".$valor;
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
   $sqlreg="SELECT nomeetiqueta FROM autor WHERE autor='$autor'";
   $dbreg->query($sqlreg);
   $registro=$dbreg->dados();
   $obs1="Alteração autor ID={".$valor."}";
   $obs1=$obs1. "Ação={Inclusão da bibliografia:".$_REQUEST[bib]."}";
   if ($obs1<>''){
      $obs1=$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','$_REQUEST[autid]','0',now(),'$obs1')";
      $db->query($sql);}


//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
               echo"<script>location.href='bibliografia_insere2.php?lista=1&$tipo=$valor&autoria=$autoria&autor=$autor&nome=$referencia&op=insert&".$parametro."=".$valor."&bib=$bib;'</script>";

 }
}   
?>
                </form>
	</td>
  </tr>
</table>
</body>
</html>