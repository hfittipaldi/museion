<?
include_once("seguranca.php");
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?
$db= new conexao(); 
$db->conecta();
?>
<title><? nome_instituicao(); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">

body {



margin:0;
padding:0;
background:#ffffff;
text-align:center; /* hack para o IE */	
	}

@media print {
	.noprint {
		display: none;
	}
}
/*@media screen {
	.noscreen {
		display: none;
	}
}*/
</style>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
<link href="css/home.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="tudo">
  <table width="750" height="185"  border="1" cellpadding="0" cellspacing="0">
    <tr>
      <td nowrap height="89" background="imgs/topo_interno.jpg" scope="col" class="noprint">
        <div id="tit_museu_int"><? echo nome_instituicao() ?></div>
	    <div id="sombra_tit_int"><? echo nome_instituicao() ?></div>
	    <div style="font-size:4px;">&nbsp;</div>
		<div id="nome_login" align="right" style="border:0px solid yellow; position:fixed; width:750px; height:18px; z-index:3; top:70px; left: 136px; visibility: visible;">
		<? echo " ".ucfirst($_SESSION[snome]).""; ?> 
		<? if (strtoupper($_SESSION[snome]) == 'VISITANTE') { ?>
        <a href="docdonato/index_visitante.htm" target="_blank"><img src="imgs/icons/ic_ajuda.gif" border="0" title=" Documentação "></a> 
		<? } else { 
		$sql= "SELECT nivel from usuario where usuario = $_SESSION[susuario]";
		$db->query($sql);
		$niv_usu=$db->dados();
		if ($niv_usu[0] == 'A') { ?>
        <a href="docdonato/index_adm.htm" target="_blank"><img src="imgs/icons/ic_ajuda.gif" border="0" title=" Documentação "></a> 
		<? } else { ?>
        <a href="docdonato/index_usuario.htm" target="_blank"><img src="imgs/icons/ic_ajuda.gif" border="0" title=" Documentação "></a> 
		<? } } ?>
        <a id="iconemsg" target="paginas" href="notasdodia.php?dePesq=<? echo date("d/m/Y"); ?>&atePesq=<? echo date("d/m/Y"); ?>" style="display: none; text-decoration: none;"> 
        <img src="imgs/icons/nova_msg.gif" border="0" title=" Notas do Dia "></a> 
        <a href="principal.php"><img src="imgs/icons/ic_home.gif" border="0" title=" Limpar tela "></a> 
        <? echo"<a href=\"logout.php\" onClick='return confirm(".'"Confirma encerramento da sessão ?"'.")'><img src=imgs/icons/btn_sair.gif border='0' title=' Encerrar sessão '></a>"; ?>
		&nbsp;&nbsp;&nbsp;&nbsp;</div>
	  </td>
    </tr>
    <tr>
       <td height="460" valign="top" background="imgs/fundo_interno.jpg">
         <table width="100%" height="460"  border="1" cellpadding="0" cellspacing="0">
          <tr>
             <th width="100%" rowspan="2" valign="top" scope="col">
                <div id="vit" style="position:relative; width:135px; height:50px; z-index:2; left: 12px; top: 374px; visibility: visible;"></div>
		      <div id="menu" style="position:relative; width:150px; height:3px; z-index:1; left: 12px; top: 100px; visibility: visible;"ALLOWTRANSPARENCY="true>
				<? require("menuprincipal.php"); ?></div>


           <iframe src="home.php" name="paginas"  width="100%" height="450"  frameborder="0" scrolling="auto" ALLOWTRANSPARENCY="true">
             </iframe> 


             </th>
          
         </tr>

       </td>
    </tr>
  </table>
<?
	if ($_GET['ptarget'] == 'obraconsulta1')
		echo "<script>frames['paginas'].location='obraconsulta1.php?num_registro=$_REQUEST[num_registro]';</script>";

	if ($_GET['ptarget'] == 'notasdodia')
		echo "<script>document.getElementById('iconemsg').click();</script>";
?>
<!-- Exibe/esconde o icone de nova mensagem -->
  <iframe src="avisomensagem.php" name="mensagens" width="1" height="1" frameborder="0" scrolling="no" style="visibility: hidden;"></iframe>
<!---->

</div>

</body>
</html>
