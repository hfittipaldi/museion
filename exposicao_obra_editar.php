<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script>

function valida() {
 with(document.form1)
 {
    if(tipo.value==''){
	  alert('Preencha com o tipo da exposição.');
	   return false;}
	 if(nome.value==''){
	   alert('Preencha com o nome da exposição.');
	    nome.focus();
	  return false;}
	if (!Validar_Campo_Data(dt_inicial,false)) {
		alert('Preencha corretamente o campo "data início"!'); dt_inicial.focus(); return false;
	}
	if (!Validar_Campo_Data(dt_final,false)) {
		alert('Preencha corretamente o campo "data fim"!'); dt_final.focus(); return false;
	}
  }
}
function abrepop(janela)
{
	win=window.open(janela,'lista','left='+((window.screen.width/2)-175)+',top='+((window.screen.height/2)-175)+',width=350,height=350, scrollbars=yes, resizable=no');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
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
$lista=$_REQUEST[lista];
$exposicao=$_REQUEST[nome];

$movid= $_REQUEST['movid'];
$obrid= $_REQUEST['obrid'];
$autid= $_REQUEST['autid'];
$id= $_REQUEST['id'];
$op= $_REQUEST['op'];
$lista=$_REQUEST['lista'];

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


if ($tipo) {
  if ($op == 'update') {
    $sql="SELECT * from exposicao where exposicao='$id'";
    $db->query($sql);
    $row=$db->dados();
	if ($tipo == 'obra') {
	    $sql="SELECT premio from obra_exposicao where obra='$valor' AND exposicao='$id'";
    	$db->query($sql);
	    $prem=$db->dados();
	}
	if ($tipo == 'autor') {
	    $sql="SELECT premio from autor_exposicao where autor='$valor' AND exposicao='$id'";
    	$db->query($sql);
	    $prem=$db->dados();
	}
  }
  elseif($op=='delexp') {
	$sql= "DELETE from exposicao where exposicao = '$id'";
	$db->query($sql);
	echo "<script>location.href='exposicao_$tipo.php?op_obra=".$_REQUEST[op_obra]."&".$parametro."=".$valor."';</script>";
   }
  elseif($op=='del') {
	$sql= "DELETE from ".$tipo."_exposicao where ".$tipo."_exposicao = '$id'";
echo"<script>alert('aqui$sql')</script>";

	$db->query($sql);
//ATUALIZA ALTERAÇÃO DA OBRA
if ($tipo == 'obra') {
	$sql="UPDATE obra set atualizado='$_SESSION[susuario]', data_catalog2=now() where obra = '$valor'";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from obra where obra = '$valor'";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
        //
        //////////////////////////////Tabela Log_atualizacao/////////////////////////////
       
        $sqlreg="SELECT num_registro, titulo_etiq FROM obra WHERE obra='$valor'";
        $dbreg->query($sqlreg);
        $registro=$dbreg->dados();
        $obs1="Alteração obra ID={".$valor."}  Registro={".$registro[num_registro]."}  Titulo="."{".trim($registro[titulo_etiq])."}";
        $obs1=$obs1. "Ação={Excluída da obra a exposição:".$valor."}";
        $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('A','$_SESSION[susuario]','0','$valor',now(),'$obs1')";
        $db->query($sql);
        //////////////////////////////////////////////////////////////////
}

//ATUALIZA ALTERAÇÃO DO AUTOR
if ($tipo == 'autor') {
	$sql="UPDATE autor set atualizado='$_SESSION[snome]', data_catalog2=now() where autor = '$valor'";
	$db->query($sql);
	// atualização na ficha
	$sql="select data_catalog2 from autor where autor = '$valor'";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$_SESSION[snome]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
        $sqlreg="SELECT nomeetiqueta FROM autor WHERE autor='$valor'";
        $dbreg->query($sqlreg);
        $registro=$dbreg->dados(); 
        $obs1="Alteração autor ID={".$valor."}  nome={".trim($registro[nomeetiqueta])."}";
        $obs1=$obs1. "Ação={Excluída do autor a exposição:".$valor."}";
        $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','$valor','0',now(),'$obs1')";
        $db->query($sql);
//////////////////////////////////////////////////////////////////
}
	echo "<script>location.href='exposicao_$tipo.php?op_obra=".$_REQUEST[op_obra]."&".$parametro."=".$valor."';</script>";
   }
 }


if($_REQUEST['enviar']<>'') {
  if($op == 'update') {
      $dt_ref=seta_data($_REQUEST[dt_inicial]);
	  if ($dt_ref == '')
		$dt_ref= "0000-00-00";
      $dt_ref2=seta_data($_REQUEST[dt_final]);
	  if ($dt_ref2 == '')
		$dt_ref2= "0000-00-00";
      $sql= "UPDATE exposicao set 
	  tipo='$_REQUEST[tipo]',
	  dt_inicial='$dt_ref',
	  dt_final='$dt_ref2',
	  nome='$_REQUEST[nome]',
	  instituicao='$_REQUEST[instituicao]',
	  pais='$_REQUEST[pais]',
	  cidade='$_REQUEST[cidade]',
	  estado='$_REQUEST[estado]',
	  periodo='$_REQUEST[periodo]',
	  txt_legado='$_REQUEST[txtlegado]' where exposicao='$id'";
	$db->query($sql);

	if ($tipo == 'obra') {
		$sql2="UPDATE obra_exposicao set premio='$_REQUEST[premio]' where obra='$valor' AND exposicao='$id'";
	    $db->query($sql2); 
	}
	if ($tipo == 'autor') {
		$sql2="UPDATE autor_exposicao set premio='$_REQUEST[premio]' where autor='$valor' AND exposicao='$id'";
	    $db->query($sql2); 
	}
	if ($tipo == 'autor') {
		$sql2="UPDATE autor set atualizado='$_SESSION[snome]', data_catalog2=now() where autor='$valor'";
	    $db->query($sql2); 
	}

//ATUALIZA ALTERAÇÃO DA OBRA
if ($tipo == 'obra') {
	$sql="UPDATE obra set atualizado='$_SESSION[susuario]', data_catalog2=now() where obra = '$valor'";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from obra where obra = '$valor'";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////

        $sqlreg="SELECT num_registro, titulo_etiq FROM obra WHERE obra='$valor'";
        $dbreg->query($sqlreg);
        $registro=$dbreg->dados();
        $obs1="Alteração obra ID={".$valor."}  Registro={".$registro[num_registro]."}  Titulo="."{".trim($registro[titulo_etiq])."}";
        $obs1=$obs1. "Ação={Alteração da exposição:".$valor."}";
        $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('A','$_SESSION[susuario]','0','$valor',now(),'$obs1')";
        $db->query($sql);

//////////////////////////////////////////////////////////////////
}

//ATUALIZA ALTERAÇÃO DO AUTOR
if ($tipo == 'autor') {
	$sql="UPDATE autor set atualizado='$_SESSION[snome]', data_catalog2=now() where autor = '$valor'";
	$db->query($sql);
	// atualização na ficha
	$sql="select data_catalog2 from autor where autor = '$valor'";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$_SESSION[snome]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
        $sqlreg="SELECT nomeetiqueta FROM autor WHERE autor='$valor'";
        $dbreg->query($sqlreg);
        $registro=$dbreg->dados(); 
        $obs1="Alteração autor ID={".$valor."}  nome={".trim($registro[nomeetiqueta])."}";
        $obs1=$obs1. "Ação={Inclusão da exposição:".$valor."}";
        $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','$valor','0',now(),'$obs1')";
        $db->query($sql);


//////////////////////////////////////////////////////////////////
}
	echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	echo "<script>location.href='exposicao_obra.php?op_obra=".$_REQUEST[op_obra]."&tipo=".$tipo."&lista=".$lista."&".$parametro."=".$valor."';</script>";
	}

  else {
	 $dt_ref=seta_data($_REQUEST[dt_inicial]);
	 if ($dt_ref == '')
		$dt_ref= "0000-00-00";
	 $dt_ref2=seta_data($_REQUEST[dt_final]);
	 if ($dt_ref2 == '')
		$dt_ref2= "0000-00-00";
     $sql= "INSERT into exposicao(tipo,dt_inicial,dt_final,nome,instituicao,pais,cidade,estado,periodo,txt_legado) 
	 	values('$_REQUEST[tipo]','$dt_ref','$dt_ref2','$_REQUEST[nome]','$_REQUEST[instituicao]','$_REQUEST[pais]','$_REQUEST[cidade]',
		'$_REQUEST[estado]','$_REQUEST[periodo]','')";
	 $db->query($sql);

	$lastid= $db->lastid();
	$sql= "INSERT into ".$tipo."_exposicao($tipo ,exposicao) values('$valor','$lastid')";
	$db->query($sql);

	if ($tipo == 'obra') {
		$lastid= $db->lastid();
		$sql2="UPDATE obra_exposicao set premio='$_REQUEST[premio]' where obra_exposicao='$lastid'";
	        $db->query($sql2); 
	}
	if ($tipo == 'autor') {
		$lastid= $db->lastid();
		$sql2="UPDATE autor_exposicao set premio='$_REQUEST[premio]' where autor_exposicao='$lastid'";
	        $db->query($sql2); 
	}

	if ($tipo == 'autor') {
		$sql2="UPDATE autor set atualizado='$_SESSION[snome]', data_catalog2=now() where autor='$valor'";
	    $db->query($sql2); 
	}

//ATUALIZA ALTERAÇÃO DA OBRA
if ($tipo == 'obra') {
	$sql="UPDATE obra set atualizado='$_SESSION[susuario]', data_catalog2=now() where obra = '$valor'";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from obra where obra = '$valor'";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////

        $sqlreg="SELECT num_registro, titulo_etiq FROM obra WHERE obra='$valor'";
        $dbreg->query($sqlreg);
        $registro=$dbreg->dados();
        $obs1="Alteração obra ID={".$valor."}  Registro={".$registro[num_registro]."}  Titulo="."{".trim($registro[titulo_etiq])."}";
        $obs1=$obs1. "Ação={Inclusão de uma nova exposição:".$valor."}";
        $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('A','$_SESSION[susuario]','0','$valor',now(),'$obs1')";
        $db->query($sql);

//////////////////////////////////////////////////////////////////
}

//ATUALIZA ALTERAÇÃO DO AUTOR
if ($tipo == 'autor') {
	$sql="UPDATE autor set atualizado='$_SESSION[snome]', data_catalog2=now() where autor = '$valor'";
	$db->query($sql);
	// atualização na ficha
	$sql="select data_catalog2 from autor where autor = '$valor'";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$_SESSION[snome]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
        $sqlreg="SELECT nomeetiqueta FROM autor WHERE autor='$valor'";
        $dbreg->query($sqlreg);
        $registro=$dbreg->dados(); 
        $obs1="Alteração autor ID={".$valor."}  nome={".trim($registro[nomeetiqueta])."}";
        $obs1=$obs1. "Ação={Inclusão de uma nova exposição:".$valor."}";
        $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','$valor','0',now(),'$obs1')";
        $db->query($sql);


//////////////////////////////////////////////////////////////////
}
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo "<script>location.href='exposicao_$tipo.php?op_obra=".$_REQUEST[op_obra]."&".$parametro."=".$valor."';</script>";
	 }
}

?>
 
<table width="100%"  border="0" cellpadding="0" cellspacing="4"><form name="form1" method="post" onSubmit='return valida();' >
        <tr class="texto_bold">
          <td colspan="3"><div align="left" style="color: gray;">
			<? if ($id <> '') { ?><b>Nº da exposição: </b><? echo $id."<br>&nbsp;"; } ?></div>
		  </td>
		  <td width="50%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Tipo:</div></td>
          <td width="10%"><select name="tipo" class="combo_cadastro">
		    <option value=''></option>
            <option value="C" <? if($row[tipo]=='C') echo "Selected" ?>>Coletiva</option>
            <option value="I" <? if($row[tipo]=='I') echo "Selected" ?>>Individual</option>
          </select></td>
          <td width="29%" nowrap>Data início
            <input name="dt_inicial" type="text" class="combo_cadastro" id="dt_inicial" value="<? echo formata_data($row[dt_inicial]) ?>" size="10" maxlength="10">
			Data fim
			<input name="dt_final" type="text" class="combo_cadastro" id="dt_final" value="<? echo formata_data($row[dt_final]) ?>" size="10" maxlength="10">
          </td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Nome:</div></td>

       <? if ($row['nome']==''){?>
          <td colspan="2"><input name="nome" type="text" class="combo_cadastro" id="nome" value='<? echo $exposicao; ?>' size="69"></td>
        <? }else{?>

          <td colspan="2"><input name="nome" type="text" class="combo_cadastro" id="nome" value='<? echo htmlentities($row['nome'], ENT_QUOTES); ?>' size="69"></td>
        <? }?>

        </tr>
        <tr class="texto_bold">
          <td><div align="right">Institui&ccedil;&atilde;o</div></td>
          <td colspan="2"><input name="instituicao" type="text" class="combo_cadastro" id="instituicao" value="<? echo htmlentities($row['instituicao'], ENT_QUOTES); ?>" size="69" maxlength="255"></td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Pa&iacute;s:</div></td>
          <td colspan="2"><select name="pais" class="combo_cadastro" id="pais">
            <? 
					  $sql="SELECT distinct pais,nome from pais order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
            <option value="<? echo $res[0] ;?>" <? if($row['pais']==$res[0]) echo "Selected" ?>><? echo $res[1]; ?></option>
            <? } ?>
          </select></td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Cidade: </div></td>
          <td colspan="2"><input name="cidade" type="text" class="combo_cadastro" id="cidade" value="<? echo htmlentities($row['cidade'], ENT_QUOTES); ?>" size="49" maxlength="100">
&nbsp;Estado:
<select name="estado" class="combo_cadastro" id="estado" >
  <? 
					  $sql="SELECT distinct estado,uf  from estado order by uf asc";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res2=$db->dados())
					  { 
					  ?>
  <option value="<? echo $res2[0];?>" <? if($row['estado']==$res2[0]) echo "Selected" ?>><? echo $res2['uf']; ?></option>
  <? } ?>
</select></td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Per&iacute;odo:</div></td>
          <td colspan="2"><input name="periodo" type="text" class="combo_cadastro" id="periodo" value="<? echo htmlentities($row['periodo'], ENT_QUOTES); ?>" size="69" maxlength="150"></td>
        </tr>
		<? if (($tipo == 'obra')||($tipo == 'autor')) { ?>
        <tr class="texto_bold">
          <td><div align="right" style="color: navy;">Observação:</div></td>
          <td colspan="2"><input name="premio" type="text" class="combo_cadastro" id="premio" value="<? echo htmlentities($prem['premio'], ENT_QUOTES);  ?>" size="69" maxlength="150"></td>
        </tr>
		<? } ?>
        <tr class="texto_bold">
          <td>&nbsp;</td>
 		  <? if ($row[txt_legado]<>'') { ?>
          <td colspan="2" id="arealegado"><textarea cols="60" rows="4" name="legado" class="combo_cadastro" style="border: 1px dashed;" readonly><? echo $row[txt_legado]; ?></textarea><img src="imgs/icons/ic_ok.gif" style="cursor:pointer;" border="0" title="Apagar texto do Sistema Donato 2..4" onClick="if (confirm('Tem certeza que deseja apagar definitivamente o texto?')) {document.form1.txtlegado.value=''; document.form1.legado.style.display='none'; this.style.display='none'; document.getElementById('arealegado').innerHTML='<font style=color:#223366;>O texto será apagado quando a exposição for gravada.</font>';}"></td>
		  <? } else { ?>
          <td>&nbsp;</td>
		  <? } ?>
          
        </tr>
        <tr><td>
		<input type="hidden" name="txtlegado" value="<? echo $row[txt_legado]; ?>">
		<input type="hidden" name="<? echo $parametro; ?>" value="<? echo $valor; ?>">
		<input type="hidden" name="op" value="<? echo $op; ?>">
		<input type="hidden" name="id" value="<? echo $id; ?>">

        </td></tr>
        <tr><td><br></td></tr>
        <tr>
               <td ><? echo "<a href=\"exposicao_obra.php?op_obra=".$_REQUEST[op_obra]."&lista=".$lista."&".$parametro."=".$valor."&tipo=".$tipo."\"'><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar'>"; ?></td>
               <td  colspan="10" valign="top" align="center"><input name="enviar" type="submit" class="botao" id="enviar" value="Gravar"></td></tr>

        <tr class="texto_bold">
          <td colspan="3"><div align="right">
          </div></form></td>
        </tr>
      </table>
</body>
</html>