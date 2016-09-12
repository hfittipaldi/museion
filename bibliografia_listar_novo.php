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
                document.location=('bibliografia_obra1.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i&nome=<?echo $_REQUEST[nome]?>);


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

<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$dbreg=new conexao();
$dbreg->conecta();
$referencia=$_REQUEST[nome];
$bibliografia=$_REQUEST['bib'];
$obra=$_REQUEST['obrid'];


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


if($_REQUEST['op']=='update')
{
 $sql="SELECT a.*,b.* from ".$tipo."_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
  where a.".$tipo."=".$valor." and a.bibliografia='$_REQUEST[bib]'";
  
  $db->query($sql);
  $res=$db->dados();
}
if($_REQUEST['op']=='del')
{
 $sql="DELETE from ".$tipo."_bibliografia where ".$tipo."=".$obrid." and bibliografia='$_REQUEST[bib]'";
 $db->query($sql);
//ATUALIZA ALTERAÇÃO DA OBRA
	$sql="UPDATE ".$tipo." set atualizado='$_SESSION[susuario]', data_catalog2=now() where ".$tipo."=".$valor;
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from ".$tipo." where ".$tipo."= ".$valor;
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//



       //////////////////////////////Tabela Log_atualizacao/////////////////////////////
       $sqlreg="SELECT num_registro, titulo_etiq FROM ".$tipo." WHERE ".$tipo."='$valor'";
       $dbreg->query($sqlreg);
       $registro=$dbreg->dados();
       if ($tipo=='obra') {
          $num_registro=$registro[num_registro];
          $titulo_etiq=$registro[titulo_etiq];
         }else{
          $titulo_etiq=$registro[nomeetiqueta];
           $num_registro=$registro[autor];
         }
       $obs1="Alteração ".$tipo." ID={".$valor."}  Registro={".$num_registro."}  Titulo="."{".htmlentities($titulo_etiq, ENT_QUOTES)."}";
       if ($tipo=='obra') {$obs1=$obs1. "Ação={Excluída da obra a bibliografia:".$_REQUEST[bib]."}";}else{$obs1=$obs1. "Ação={Excluída do autor a bibliografia:".$_REQUEST[bib]."}";}
       $sql="insert into log_atualizacao(operacao,usuario,$autid,$obrid,data, obs)values('A','$_SESSION[susuario]','$_REQUEST[autid]','$_REQUEST[obrid]',now(),'$obs1')";
       $db->query($sql);
       //////////////////////////////////////////////////////////////////
       echo"<script>alert('Exclusão realizada com sucesso')</script>";
       echo"<script>location.href='bibliografia_listar.php?$tipo=$valor'</script>";
 }
?>
         <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">

             <tr width="100%">
                <td colspan="3 class="texto_bold">&nbsp;</td>
             </tr>
             <tr bgcolor="#96ADBE">
                <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
             </tr>

             <tr bgcolor="#96ADBE">


                <td height="24" bgcolor="#96ADBE" class="texto_bold" style="color: white;"><div align="left"> Detalhes da referência bibliográfica a vincular nº <? echo $res['bibliografia']; ?></div></td>
                <td valign="top"><? echo "<a href=\"bibliografia_listar.php?"."nome=".$referencia."&".$parametro."=".$valor."&tipo=".$tipo."&bib=".$bib."\"'><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar'>"; ?></td>

             </tr>
             <tr>
                <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
             </tr>
          </table>       


<table width="103%"  border="0" cellpadding="0" cellspacing="4"><form name="form1" method="post" onSubmit="return valida()" >
	<br>
      <? if($_REQUEST['op']=='update'){?>
        <tr class="texto_bold" style="color: gray;" > <em> Detalhes da referência bibliográfica nº <? echo htmlentities($res['bibliografia'], ENT_QUOTES); ?></em>
        </tr><?}?>

        <tr class="texto_bold" style="color: navy;" >
          <td><div align="right"><br>Autoria*:</div></td>
          <td colspan="2"><br><input name="autoria" type="text" class="combo_cadastro" id="autoria" value="<? echo htmlentities($res['autoria'], ENT_QUOTES); ?>" size="80"></td>
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
            <td width="50%" colspan="2"><input name="descricao" type="text" class="combo_cadastro" id="descricao" value='<? echo htmlentities($res['referencia'], ENT_QUOTES); ?>' size="80"></td>
        <? }?>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Sub-titulo:</div></td>
          <td colspan="2"><input name="sub_titulo" type="text" class="combo_cadastro" id="sub_titulo" value="<? echo htmlentities($res['sub_titulo'], ENT_QUOTES); ?>" size="80"> </td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Local:</div></td>
          <td width="50%" colspan="2"><input name="local" type="text" class="combo_cadastro" id="local" value='<? echo htmlentities($res['local'], ENT_QUOTES); ?>' size="80">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Editora:</div></td>
          <td width="50%" colspan="2"><input name="editora" type="text" class="combo_cadastro" id="editora" value='<? echo htmlentities($res['editora'], ENT_QUOTES); ?>' size="80">
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
          <td><div align="right">Notas:</div></td>
          <td colspan="2"><input name="notas" type="text" class="combo_cadastro" id="notas" value="<? echo htmlentities($res['notas'], ENT_QUOTES); ?>" size="80"> </td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td width="15%"><div align="right">Observa&ccedil;&atildeo:</div></td>
          <td width="50%" colspan="2"><input name="observacao" type="text" class="combo_cadastro" id="observacao" value='<? echo htmlentities($res['observacao'], ENT_QUOTES); ?>' size="80">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr>
 		  <? if ($res[txt_legado]<>'') { ?>
	          <td id="arealegado" class="texto_bold"><textarea cols="70" rows="5" name="legado" class="combo_cadastro" style="border: 1px dashed;" readonly><? echo $res[txt_legado]; ?></textarea><img src="imgs/icons/ic_ok.gif" style="cursor:pointer;" border="0" title="Apagar texto do Sistema Donato 2..4" onClick="if (confirm('Tem certeza que deseja apagar definitivamente o texto?')) {document.form1.txtlegado.value=''; document.form1.legado.style.display='none'; this.style.display='none'; document.getElementById('arealegado').innerHTML='<font style=color:#223366;>O texto será apagado quando a referência for gravada.</font>';}"></td>
		  <? } ?>
   	      <td>&nbsp; </td>
          <td>&nbsp; <input type="hidden" name="txtlegado" value="<? echo $res[txt_legado] ?>"></td>
        </tr>
        <tr class="texto_bold" style="color: navy;">
          <td colspan="2">&nbsp;(*) Campos obrigatórios</td>
          <td valign="top"><div align="right"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </span></div></td>

          <td>&nbsp;</td>
        </tr>
        </form>
      </table>
  <?
     if ($_REQUEST[ano]=='') {$_REQUEST[ano]='0';}

if($_REQUEST['enviar']<>'')
{
if($_REQUEST[op]=='insert')
  {
     $sql= "INSERT INTO bibliografia(referencia,isbn,autoria,txt_legado,local,editora,data,ano,sub_titulo,notas) 
	 values('$_REQUEST[descricao]','$_REQUEST[isbn]','$_REQUEST[autoria]','','$_REQUEST[local]','$_REQUEST[editora]','','$_REQUEST[ano]','$_REQUEST[sub_titulo]','$_REQUEST[notas]')";
    

	 $db->query($sql);
	 $idbib=$db->lastid(); //id da bibliografia
	//Vinculo 
     $sql="INSERT INTO ".$tipo."_bibliografia(".$tipo.",bibliografia,observacao) values('$valor','$idbib','$_REQUEST[observacao]')";
   

	$db->query($sql);
//ATUALIZA ALTERAÇÃO DA OBRA
	$sql="UPDATE ".$tipo." set atualizado='$_SESSION[susuario]', data_catalog2=now() where ".$tipo."= $valor";
     

	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
     

	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from ".$tipo." where ".$tipo."= $valor";
 

	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";



   //
   //////////////////////////////Tabela Log_atualizacao/////////////////////////////
   if ($tipo=="obra"){
        $sqlreg="SELECT num_registro FROM obra WHERE obra=".$obrid;
        $dbreg->query($sqlreg);
        $registro=$dbreg->dados();
        $num=$registro[num_registro];
        $obs1="Alteração obra ID={".$obrid."}  Registro={".$num."}";
        $obs1=$obs1. "Ação={Inclusão da bibliografia:".$idbib."}";

    }
   if ($tipo=="autor"){
        $sqlreg="SELECT autor FROM autor WHERE autor=".$autid;
        $dbreg->query($sqlreg);
        $registro=$dbreg->dados();
        $num=$registro[autor];
        $obs1="Alteração autor ID={".$autid."}  Registro={".$num."}";
        $obs1=$obs1. "Ação={Inclusão da bibliografia:".$idbib."}";

    }

   if ($obs1<>''){
   if ($tipo=="autor")   $obs1=$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','$autid','0',now(),'$obs1')";
   if ($tipo=="obra")   $obs1=$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','0','$obrid',now(),'$obs1')";
   

      $db->query($sql);}
   //////////////////////////////////////////////////////////////////
   echo"<script>alert('Inclusão realizada com sucesso.')</script>";
   echo"<script>location.href='bibliografia_listar.php?obrid=$obrid'</script>";

    }
if ($_REQUEST[ano]=='') {$_REQUEST[ano]='0';}
if($_REQUEST[op]=='update')
{
      $sql="UPDATE bibliografia set
	  isbn='$_REQUEST[isbn]',
	  autoria='$_REQUEST[autoria]',
	  referencia='$_REQUEST[descricao]',
	  txt_legado='$_REQUEST[txtlegado]',
	  local='$_REQUEST[local]',
	  editora='$_REQUEST[editora]',
	  ano='$_REQUEST[ano]'
	  sub_titulo='$_REQUEST[sub_titulo]',
	                    where bibliografia='$_REQUEST[bib]'";
     $db->query($sql);
      $sql="UPDATE ".$tipo."_bibliografia set
	  observacao='$_REQUEST[observacao]'
	                    where bibliografia='$_REQUEST[bib]' and $tipo=$valor";
     $db->query($sql);


//ATUALIZA ALTERAÇÃO DA OBRA
	$sql="UPDATE ".$tipo." set atualizado='$_SESSION[susuario]', data_catalog2=now() where ".$tipo."= $valor";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from ".$tipo." where ".$tipo." = ".$valor;
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//



//////////////////////////////Tabela Log_atualizacao/////////////////////////////

   if ($tipo=="obra") {
       $sqlreg="SELECT num_registro FROM ".$tipo." WHERE ".$tipo."='$valor'";
       $dbreg->query($sqlreg);
       $registro=$dbreg->dados();
       $num=$registro[num_registro];
   }
  if ($tipo=="autor") {
       $sqlreg="SELECT autor FROM ".$tipo." WHERE ".$tipo."='$valor'";
       $dbreg->query($sqlreg);
       $registro=$dbreg->dados();
       $num=$registro[autor];
   }

   if ($tipo=="obra") $obs1="Alteração ".$tipo." ID={".$valor."}  Registro={".$num."}";
   if ($tipo=="autor") $obs1="Alteração ".$tipo." ID={".$valor."}  Registro={".$num."}";
   $obs1=$obs1. "Ação={Inclusão de bibliografia existente:".$_REQUEST[bib]."}";
   if ($tipo=="obra") $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('A','$_SESSION[susuario]','0','$obrid',now(),'$obs1')";
   if ($tipo=="autor") $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('A','$_SESSION[susuario]','$autid','0',now(),'$obs1')";
   echo $sql;
 $db->query($sql);
   //////////////////////////////////////////////////////////////////
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='bibliografia_listar.php?tipo=$valor'</script>";

 }
}   
?>


</body>
</html>