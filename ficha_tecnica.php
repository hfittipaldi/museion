<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Família Ferrez</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 1px;
}
-->
</style>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<link href="estilo.css" rel="stylesheet" type="text/css">
</head>

<?php
	include("classe/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
	$IdFichaTecnica= '';
	$IdFichaTecnica= $_REQUEST['IdF'];
	$fichaAtual= '';
	if ($IdFichaTecnica <> '')
		$fichaAtual= "&nbsp;".$IdFichaTecnica."&nbsp;";
?>

<body>
<table width="750" height="560" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td height="48" colspan="2"><?php require_once('topo.php'); ?></td>
  </tr>
  <tr>
    <td width="130" height="15" valign="top" bgcolor="#34689A" style="border-right: 2px solid #DFDFDF;"><img src="imgs/transp.gif" width="130" height="10"></td>
    <td width="700" rowspan="3" valign="top"><table width="100%"  border="0" cellspacing="20" cellpadding="1" style="border-top: 2px solid #DFDFDF;">
      <tr>
        <td height="19"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
                <td width="99%" class="titulo" style="border-bottom: 2px solid #336799;">Ficha Técnica</td>
				<td class="texto" align="right" style="border: 2px solid #336799; border-top-width: 1px; border-left-width: 1px;"><? echo $fichaAtual ?></td>
          </tr>
        </table></td>
      </tr>
	<form name="frm_Ficha" method="post" onSubmit="">
      <tr>
        <td valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
		  <input type='hidden' name='op' value=''>
		  <input type='hidden' name='IdF' value='<?php echo $IdFichaTecnica; ?>'>
          <tr bgcolor="#D8ECFA">
            <td bgcolor="#FFFFFF" align="left"><? require("menuaba.php")?></td>
          </tr>
        </table></td>
      </tr>
	  <tr>
		<td align="center"><input type="submit" name="salvar" value=" Salvar " style="font-weight: bold;">
		</td>
	  </tr>
	</form>
    </table></td>
  </tr>
  <tr>
    <td height="430" bgcolor="#34689A" style="border-right: 2px solid #DFDFDF;"><? require("menu.php")?>&nbsp;</td>
  </tr>
  <tr>
    <td height="70" valign="top" bgcolor="#34689A" style="border-bottom: 1px solid #000000; border-right: 2px solid #DFDFDF;"><div align="center">&nbsp;</div></td>
  </tr>
</table>

<!-- SUBMIT SALVAR (Layer de salvamento da Ficha) -->
<?php if ($_REQUEST["salvar"] <> '') { ?>
<div id="menu" style="background-color: #FFFFFF; position:absolute; left:220px; top:108px; width:440px; height:10px; z-index:2;" onDblClick="document.getElementById('menu').style.display= 'none';">
	<table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td style="border: 2px solid #FF3333; border-top-width: 0px;" valign="top" class="texto_bold_azul">
		<div align="right" style="background-color: #FF3333; color: white; cursor:hand; cursor:pointer;" onMouseDown="if (event.button <= 1) { document.getElementById('menu').style.display= 'none'; }">X&nbsp;</div>
		<div align="center" style="background-color: #FFFFFF;">
			<?php 
					if ($IdFichaTecnica <> '') {
/*						$sql= "UPDATE produtor set nome='$_REQUEST[nome]', biografia='$_REQUEST[biografia]',
							 ano_nascimento='$_REQUEST[nasc]', ano_falecimento='$_REQUEST[fale]',
							 historico_arq='$_REQUEST[historico]', procedencia='$_REQUEST[proc]' where produtor = '$produtor'";
						$db->query($sql);
						echo "<script>alert('Produtor alterado.');</script>";
						echo "<script>location.href='produtor.php?page=".$pagina."'</script>";*/
					}
					else {
						//$timestamp = strtotime('2006-03-07 12:12:12');
						//echo date('d/m/Y', $timestamp);
						$dataInc= date("Y-m-d H:i:s");
						//
						$De= explode("/", $_REQUEST[de]);
						$ano= $De[2]; $mes= $De[1]; $dia= $De[0];
						$De= $ano."-".$mes."-".$dia;
						$Ate= explode("/", $_REQUEST[ate]);
						$ano= $Ate[2]; $mes= $Ate[1]; $dia= $Ate[0];
						$Ate= $ano."-".$mes."-".$dia;
						//
						$sql= "INSERT INTO ficha_tecnica(arranjo,nivel_descricao,seq_catalogo,data_descr,data_ref_ini,data_ref_fim,usuario_inclusao,dt_inclusao,entrada_principal,ambito_conteudo,data_conteudo,local_conteudo,dim_suporte,anexo,notas,idioma,fontes_relacionadas,estado_conservacao,estado_conserv_obs,localizacao,cond_acesso,cond_reprod)
							 values('$_REQUEST[referencia]','$_REQUEST[nivel_desc]','$_REQUEST[catalogo]','$_REQUEST[data_desc]','$De','$Ate',\"anonimo\",'$dataInc','$_REQUEST[entrada]','$_REQUEST[ambito]','$_REQUEST[dt_conteudo]','$_REQUEST[local_conteudo]','$_REQUEST[suporte]','$_REQUEST[anexo]','$_REQUEST[notas]','$_REQUEST[idioma]','$_REQUEST[fontes]','$_REQUEST[estado]','$_REQUEST[estado_obs]','$_REQUEST[localiza]','$_REQUEST[acesso]','$_REQUEST[reprod]')";
						$db->query($sql);
						echo "<script>alert('Ficha salva com sucesso.');</script>";
						echo "<script>location.href='ficha_tecnica.php?IdF=".$db->lastid()."'</script>";
					}
			?>
		</div>
		</td>
      </tr>
	</table>
</div>
<script>
	//Serve para esconder a layer caso não haja msg de erro a ser exibida.
	//obs.: esta linha só será executada se não der erro na query (devido ao uso do 'die')!!
	document.getElementById("menu").style.display= 'none';
</script>
<?php } ?>

<!-- SUBMIT INCLUIR/ALTERAR (Layer de salvamento de Autor/Assunto) -->
<?php if ($_REQUEST["salvar"]=='' && $opcao<>'') { ?>
<div id="menu2" style="background-color: #FFFFFF; position:absolute; left:220px; top:108px; width:440px; height:10px; z-index:3;" onDblClick="document.getElementById('menu2').style.display= 'none';">
	<table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td style="border: 2px solid #FF3333; border-top-width: 0px;" valign="top" class="texto_bold_azul">
		<div align="right" style="background-color: #FF3333; color: white; cursor:hand; cursor:pointer;" onMouseDown="if (event.button <= 1) { document.getElementById('menu2').style.display= 'none'; }">X&nbsp;</div>
		<div align="center" style="background-color: #FFFFFF;">
			<?php 
				//INSERT
				if ($opcao=='insAutor') {
					$sql= "INSERT INTO ficha_tecnica_autor(nome,ficha_tecnica,sequencia) values('$_REQUEST[autor_novo]','$IdFichaTecnica','$_REQUEST[autor_ordem]')";
					$db->query($sql);
					/*echo "<script>alert('Autor salvo com sucesso.');</script>";*/
					echo "<script>location.href='ficha_tecnica.php?IdF=".$IdFichaTecnica."&aba=".$aba."'</script>";
				}
				elseif ($opcao=='insAssunto') {
					$sql= "INSERT INTO ficha_tecnica_assunto(nome,ficha_tecnica,sequencia) values('$_REQUEST[assunto_novo]','$IdFichaTecnica','$_REQUEST[assunto_ordem]')";
					$db->query($sql);
					/*echo "<script>alert('Assunto salvo com sucesso.');</script>";*/
					echo "<script>location.href='ficha_tecnica.php?IdF=".$IdFichaTecnica."&aba=".$aba."'</script>";
				}
				//UPDATE
				elseif ($opcao=='altAutor') {
					$sql= "UPDATE ficha_tecnica_autor set nome='$_REQUEST[autor_alter]' where ficha_tecnica = '$IdFichaTecnica' AND sequencia = '$_REQUEST[aut]'";
					$db->query($sql);
					/*echo "<script>alert('Autor alterado.');</script>";*/
					echo "<script>location.href='ficha_tecnica.php?IdF=".$IdFichaTecnica."&aba=".$aba."'</script>";
				}
				elseif ($opcao=='altAssunto') {
					$sql= "UPDATE ficha_tecnica_assunto set nome='$_REQUEST[assunto_alter]' where ficha_tecnica = '$IdFichaTecnica' AND sequencia = '$_REQUEST[ass]'";
					$db->query($sql);
					/*echo "<script>alert('Assunto alterado.');</script>";*/
					echo "<script>location.href='ficha_tecnica.php?IdF=".$IdFichaTecnica."&aba=".$aba."'</script>";
				}
				//DELETE
				elseif ($opcao=='del') {
					if ($_REQUEST['aut']<>'') {
						$sql= "DELETE from ficha_tecnica_autor where ficha_tecnica = '$IdFichaTecnica' AND sequencia = '$_REQUEST[aut]'";
						$db->query($sql);
						/*echo "<script>alert('Registro excluído.');</script>";*/
						echo "<script>location.href='ficha_tecnica.php?IdF=".$IdFichaTecnica."&aba=".$aba."'</script>";
					}
					elseif ($_REQUEST['ass']<>'') {
						$sql= "DELETE from ficha_tecnica_assunto where ficha_tecnica = '$IdFichaTecnica' AND sequencia = '$_REQUEST[ass]'";
						$db->query($sql);
						/*echo "<script>alert('Registro excluído.');</script>";*/
						echo "<script>location.href='ficha_tecnica.php?IdF=".$IdFichaTecnica."&aba=".$aba."'</script>";
					}
				}
			?>
		</div>
		</td>
      </tr>
	</table>
</div>
<script>
	//Serve para esconder a layer caso não haja msg de erro a ser exibida.
	//obs.: esta linha só será executada se não der erro na query (devido ao uso do 'die')!!
	document.getElementById("menu2").style.display= 'none';
</script>
<?php } ?>

</body>
</html>