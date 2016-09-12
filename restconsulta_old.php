<? include_once("seguranca.php") ?>
<html>
<head>
<title>Pesquisa de Restauração</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style>
@media print {
	.noprint {
		display: none;
	}
}
</style>
<script>
function obtem_valor(qual,i) {
if (qual.selectedIndex.selected!= '') {
document.location=('restconsulta.php?page='+ i+ 
'&tipo=<? echo trim($_REQUEST[tipo]); ?>
&origem=<? echo $_REQUEST[origem]; ?>
&num_registro=<? echo $_REQUEST[num_registro]; ?>
&ir=<? echo $_REQUEST[ir]; ?>
&seq_restauro=<? echo trim($_REQUEST[seq_restauro]); ?>
&autor=<? echo trim($_REQUEST[autor]); ?>
&titulo=<? echo trim($_REQUEST[titulo]); ?>
&colecao=<? echo trim($_REQUEST[colecao]); ?>
&tecnica=<? echo trim($_REQUEST[tecnica]); ?>
&nome_objeto=<? echo $_REQUEST[nome_objeto]; ?>
&obs=<? echo $_REQUEST[obs]; ?>
&tipo_fundo=<? echo $_REQUEST[tipo_fundo]; ?>
&tecnico=<? echo $_REQUEST[tecnico]; ?>
&tratamento=<? echo $_REQUEST[tratamento]; ?>
&conserva=<? echo $_REQUEST[conserva]; ?>
&suporte=<? echo $_REQUEST[suporte]; ?>
&exame=<? echo $_REQUEST[exame]; ?>
&chassis=<? echo $_REQUEST[chassis]; ?>
&est_fundo=<? echo $_REQUEST[est_fundo]; ?>
&moldura=<? echo $_REQUEST[moldura]; ?>
&camada_pic=<? echo $_REQUEST[camada_pic]; ?>
&camada_prot=<? echo $_REQUEST[camada_prot]; ?>
&suporte2=<? echo $_REQUEST[suporte2]; ?>
&temimg=<? echo $_REQUEST[temimg]; ?>
&temimgad=<? echo $_REQUEST[temimgad]; ?>
&propriedade=<? echo $_REQUEST[propriedade]; ?>');
 }
}

function alternaCampos(val) {
	if (val == 2) {
		document.getElementById('fundo').style.display='';
		document.getElementById('cpapel').style.display='none';
		document.getElementById('cpintura').style.display='';
	} else if (val == 1) {
		document.getElementById('fundo').style.display='none';
		document.getElementById('cpapel').style.display='';
		document.getElementById('cpintura').style.display='none';
	} else {
		document.getElementById('fundo').style.display='none';
		document.getElementById('cpapel').style.display='none';
		document.getElementById('cpintura').style.display='none';
	}
}

function verificar() {
     with(document.form){
	 if(tipo.value==0)
	 {
	   alert('O campo tipo é obrigatório para que se realize a consulta.');
	   return false;
	 }
 }
}
function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-125)+',top='+((window.screen.height/2)-150)+',width=250,height=300, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4)
{
   win.window.focus();
 }
 return true;
}
</script>

</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2 >
  <tr>
    <th width="519" colspan="3" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db2=new conexao();
$db2->conecta();
if ($_REQUEST[pagesize] < 999) {
montalinks();
}
$_SESSION['lnk']= $link;
$deMes= $_REQUEST['deMes'];
$deAno= $_REQUEST['deAno'];
$ateAno= $_REQUEST['ateAno'];
set_time_limit(0);
////
function ret_tipo($valor)
{
 if($valor=='1')
 return 'Papel';
 elseif($valor=='2')
 return 'Pintura';
} 

function ret_origem($valor)
{
 if($valor=='I')
 return 'Acervo';
 elseif($valor=='E')
 return 'Não Acervo';
} 
function ret_propriedade($valor)
{
 if($valor=='S')
 return 'Sim';
 elseif($valor=='N')
 return 'Não';
} 
///
$condicao= '';
$joinpintura= '';
$joinrest_foto= '';
if($_REQUEST['tipo']<> '')
{  
   $condicao="AND a.tipo='$_REQUEST[tipo]'";
   $txtpesquisa= "<br>&nbsp;- Tipo: <font style='color:#000000;'>".ret_tipo($_REQUEST['tipo'])."</font>";
}
if($_REQUEST['origem']<> '')
{  
   $condicao=$condicao." AND a.interna='$_REQUEST[origem]' ";
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Origem: <font style='color:#000000;'>".ret_origem($_REQUEST['origem'])."</font>";
}
if($_REQUEST['tipo_fundo']<> '')
{  
   $condicao=$condicao." AND b.tipo_fundo like '%$_REQUEST[tipo_fundo]%'";
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Tipo de fundo: <font style='color:#000000;'>".$_REQUEST['tipo_fundo']."</font>";
   $joinpintura= "INNER JOIN pintura as b on(a.restauro=b.restauro)";
}
if($_REQUEST['num_registro']<> '')
{  
   $condicao=$condicao." AND a.tombo like '".trim($_REQUEST['num_registro'])."%'";
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Nº de registro: <font style='color:#000000;'>".trim($_REQUEST['num_registro'])."</font>";
}
if($_REQUEST['controle']<> '')
{  
   $condicao=$condicao." AND a.controle='".trim($_REQUEST['controle'])."'";
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Controle: <font style='color:#000000;'>".trim($_REQUEST['controle'])."</font>";
}
if($_REQUEST['ir']<> '')
{  
   $condicao=$condicao." AND a.ir like '".trim($_REQUEST[ir])."%'";
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- IR: <font style='color:#000000;'>".trim($_REQUEST['ir'])."</font>";
}
if($_REQUEST['temimg']<> '')
{  
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Com imagem: <font style='color:#000000;'>Sim</font>";
	$joinrest_foto= " INNER JOIN restauro_fotografia as c on(a.restauro=c.restauro) ";
}
if($_REQUEST['propriedade']<> '')
{  
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Propriedade do Museu: <font style='color:#000000;'>".ret_propriedade($_REQUEST['propriedade'])."</font>";
   	$condicao=$condicao." AND a.propriedade='".trim($_REQUEST[propriedade])."'";
}
if($_REQUEST['temimgad']<> '')
{  
   $condicao=$condicao." AND (SELECT tipo
		FROM restauro_fotografia AS x
		WHERE tipo =1
		AND x.restauro=a.restauro
		GROUP BY tipo
		HAVING tipo > 0) AND 
		(SELECT tipo
		FROM restauro_fotografia AS x
		WHERE tipo =3
		AND x.restauro=a.restauro
		GROUP BY tipo
		HAVING tipo > 0)";
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Com imagem antes/depois: <font style='color:#000000;'>Sim</font>";
	$joinrest_foto= " INNER JOIN restauro_fotografia as c on(a.restauro=c.restauro) ";
}
if (trim($_REQUEST['autor']) <> '') {
	$condicao=$condicao." AND a.autor like '%".trim($_REQUEST['autor'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Autor: <font style='color:#000000;'>".trim($_REQUEST['autor'])."</font>";
}
if (trim($_REQUEST['titulo']) <> '') {
	$condicao=$condicao." AND a.titulo like '%".trim($_REQUEST['titulo'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Título: <font style='color:#000000;'>".trim($_REQUEST['titulo'])."</font>";
}
if ($_REQUEST['colecao'] <> '') {
	$colexao= "'" . $_REQUEST['colecao'] . "'";
	$colexao= str_replace(",","','",$colexao);
    $condicao=$condicao." AND a.colecao in ($colexao) ";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Coleções: <font style='color:#000000;'>".str_replace(",",", ",trim($_REQUEST['colecao']))."</font>";
}
/*if (trim($_REQUEST['colecao']) <> '') {
	$condicao=$condicao." AND a.colecao like '%".trim($_REQUEST['colecao'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Coleção: <font style='color:#000000;'>".trim($_REQUEST['colecao'])."</font>";
}*/
if (trim($_REQUEST['tecnica']) <> '') {
	$condicao=$condicao." AND a.tecnica like '%".trim($_REQUEST['tecnica'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Técnica: <font style='color:#000000;'>".trim($_REQUEST['tecnica'])."</font>";
}
if (trim($_REQUEST['nome_objeto']) <> '') {
	$condicao=$condicao." AND a.nome_objeto like '%".trim($_REQUEST['nome_objeto'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Nome Objeto: <font style='color:#000000;'>".trim($_REQUEST['nome_objeto'])."</font>";
}
if (trim($_REQUEST['obs']) <> '') {
	$condicao=$condicao." AND a.obs like '%".trim($_REQUEST['obs'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Obs: <font style='color:#000000;'>".trim($_REQUEST['obs'])."</font>";
}
if (trim($_REQUEST['tecnico']) <> '') {
	$condicao=$condicao." AND a.tecnico like '%".trim($_REQUEST['tecnico'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Técnico: <font style='color:#000000;'>".trim($_REQUEST['tecnico'])."</font>";
}
if ($_REQUEST[tipo] == 1) {	// PAPEL
if (trim($_REQUEST['suporte2']) <> '') {
	$condicao=$condicao." AND b.suporte like '%".trim($_REQUEST['suporte2'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Suporte: <font style='color:#000000;'>".trim($_REQUEST['suporte2'])."</font>";
	$joinpintura= "INNER JOIN papel as b on(a.restauro=b.restauro)";
}
if (trim($_REQUEST['conserva']) <> '') {
	$condicao=$condicao." AND b.texto_estado like '%".trim($_REQUEST['conserva'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Est. de conservação: <font style='color:#000000;'>".trim($_REQUEST['conserva'])."</font>";
	$joinpintura= "INNER JOIN papel as b on(a.restauro=b.restauro)";
}
}
if ($_REQUEST[tipo] == 2) {	// PINTURA
if (trim($_REQUEST['exame']) <> '') {
	$condicao=$condicao." AND b.exames like '%".trim($_REQUEST['exame'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Exames: <font style='color:#000000;'>".trim($_REQUEST['exame'])."</font>";
	$joinpintura= "INNER JOIN pintura as b on(a.restauro=b.restauro)";
}
if (trim($_REQUEST['chassis']) <> '') {
	$condicao=$condicao." AND (b.chassis like '%".trim($_REQUEST['chassis'])."%' or b.estado_chassis like '%".trim($_REQUEST['chassis'])."%') ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Chassis: <font style='color:#000000;'>".trim($_REQUEST['chassis'])."</font>";
	$joinpintura= "INNER JOIN pintura as b on(a.restauro=b.restauro)";
}
if (trim($_REQUEST['est_fundo']) <> '') {
	$condicao=$condicao." AND b.estado_fundo like '%".trim($_REQUEST['est_fundo'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Est. do fundo: <font style='color:#000000;'>".trim($_REQUEST['est_fundo'])."</font>";
	$joinpintura= "INNER JOIN pintura as b on(a.restauro=b.restauro)";
}
if (trim($_REQUEST['moldura']) <> '') {
	$condicao=$condicao." AND (b.moldura like '%".trim($_REQUEST['moldura'])."%' or b.obs_moldura like '%".trim($_REQUEST['moldura'])."%') ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Moldura: <font style='color:#000000;'>".trim($_REQUEST['moldura'])."</font>";
	$joinpintura= "INNER JOIN pintura as b on(a.restauro=b.restauro)";
}
if (trim($_REQUEST['camada_pic']) <> '') {
	$condicao=$condicao." AND (b.camada_pic like '%".trim($_REQUEST['camada_pic'])."%' or b.carac_camada_pic like '%".trim($_REQUEST['camada_pic'])."%' or b.estado_camada_pic like '%".trim($_REQUEST['camada_pic'])."%') ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Camada pictórica: <font style='color:#000000;'>".trim($_REQUEST['camada_pic'])."</font>";
	$joinpintura= "INNER JOIN pintura as b on(a.restauro=b.restauro)";
}
if (trim($_REQUEST['camada_prot']) <> '') {
	$condicao=$condicao." AND (b.camada_prot like '%".trim($_REQUEST['camada_prot'])."%' or b.estado_camada like '%".trim($_REQUEST['camada_prot'])."%') ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Camada de proteção: <font style='color:#000000;'>".trim($_REQUEST['camada_prot'])."</font>";
	$joinpintura= "INNER JOIN pintura as b on(a.restauro=b.restauro)";
}
if (trim($_REQUEST['suporte']) <> '') {
	$condicao=$condicao." AND (b.suporte like '%".trim($_REQUEST['suporte'])."%' or b.estado_suporte like '%".trim($_REQUEST['suporte'])."%') ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Suporte: <font style='color:#000000;'>".trim($_REQUEST['suporte'])."</font>";
	$joinpintura= "INNER JOIN pintura as b on(a.restauro=b.restauro)";
}
}
if (trim($_REQUEST['tratamento']) <> '') {
	if ($_REQUEST[tipo] == 1) {	// PAPEL
		$condicao=$condicao." AND b.tratamento like '%".trim($_REQUEST['tratamento'])."%' ";
		$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Tratamento: <font style='color:#000000;'>".trim($_REQUEST['tratamento'])."</font>";
		$joinpintura= "INNER JOIN papel as b on(a.restauro=b.restauro)";
	} else {	// PINTURA
		$condicao=$condicao." AND b.tratamento like '%".trim($_REQUEST['tratamento'])."%' ";
		$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Tratamento: <font style='color:#000000;'>".trim($_REQUEST['tratamento'])."</font>";
		$joinpintura= "INNER JOIN pintura as b on(a.restauro=b.restauro)";
	}
}
?>
	</div></th>
  </tr>
  <tr>
	<? if ($_REQUEST['ok']=='' && $_REQUEST[page]=='') { ?>
	<form name="form" method="get" action="restconsulta.php" onSubmit="return verificar();">
	<th align="left" bgcolor="#f2f2f2" class="texto_bold"><br>&nbsp;&nbsp;&nbsp;
	  Tipo:
	    <select name="tipo" class="combo_cadastro" id="tipo" onChange="alternaCampos(this.value);">
	      <option value=""></option>
	      <option value="1">Papel</option>
	      <option value="2">Pintura</option>
        </select>
	     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Origem:
         <select name="origem" class="combo_cadastro" id="origem">
		    <option value=""></option>
		   <option value="I">Acervo</option>
           <option value="E">Não Acervo</option>
        </select>
        &nbsp;&nbsp;&nbsp;IR:
        <input name="ir" type="text" class="combo_cadastro" id="ir"  size="6">

	&nbsp;&nbsp;Do Museu:&nbsp;
        <select name="propriedade" class="combo_cadastro" id="propriedade">
		    <option value=""></option>
		    <option value="S">Sim</option>
                    <option value="N">Não</option>
        </select>

<label id="fundo" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fundo:
<select name="tipo_fundo" id='tipo_fundo' class="combo_cadastro">
  <option value='' ></option>
  <option value="cola">cola</option>
  <option value="óleo">óleo</option>
  <option value="cola e óleo">cola e óleo</option>
  <option value="sintético">sintético</option>
  <option value="não identificado">não identificado</option>
</select></label>
&nbsp;&nbsp;<br>
	    <br>
	 &nbsp;&nbsp;&nbsp; N&ordm; de Registro:
        <input name="num_registro" type="text" class="combo_cadastro" id="num_registro"  size="6">
	&nbsp;&nbsp;Controle:
        <input name="controle" type="text" class="combo_cadastro" id="controle"  size="6">
        &nbsp;&nbsp;N&ordm; da Restauração: 
        <input name="seq_restauro" type="text" class="combo_cadastro" id="seq_restauro" size="6">
        <br>
	  <br>
	  &nbsp;&nbsp;&nbsp;Com Imagem: <input type="checkbox" name="temimg" id="temimg" onClick="if (this.checked) { document.getElementById('temimgad').checked=false; }">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  Com imagem antes/depois: <input type="checkbox" name="temimgad" id="temimgad" onClick="if (this.checked) { document.getElementById('temimg').checked=false; }">
        <br>
	  <br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Autor: 
	  <input name="autor" type="text" class="combo_cadastro" id="autor" size="66">
		<br>
		&nbsp;&nbsp;&nbsp;T&iacute;tulo da Obra:
        <input name="titulo" type="text" class="combo_cadastro" id="titulo" size="66">
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cole&ccedil;&atilde;o:
		<input name="colecao" type="text" class="combo_cadastro" id="colecao" size="66">
        <a href='javascript:;' onClick="abrepop('pop_colecao.php?colecao='+document.form.colecao.value);""><img src="imgs/icons/lupa.gif" title="Selecionar..." width="27" border=0 height="16")"></a>
        <input name="idcolecoes" type="hidden" id="idcolecoes">
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T&eacute;cnica:
        <input name="tecnica" type="text" class="combo_cadastro" id="tecnica" size="66">
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome-objeto:
<input name="nome_objeto" type="text" class="combo_cadastro" id="nome_objeto" size="66">
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs:
		<input name="obs" type="text" class="combo_cadastro" id="obs" size="66">
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T&eacute;cnico: 
		<input name="tecnico" type="text" class="combo_cadastro" id="tecnico" size="66">
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tratamento:
		<input name="tratamento" type="text" class="combo_cadastro" id="tratamento" size="66">
		<br>
<label id="cpapel" style="display:none;">&nbsp;&nbsp;&nbsp;Est. conservação:
		<input name="conserva" type="text" class="combo_cadastro" id="conserva" size="62">
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Suporte: 
		<input name="suporte2" type="text" class="combo_cadastro" id="suporte2" size="66">
		<br>
</label>
<label id="cpintura" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Exames:
		<input name="exame" type="text" class="combo_cadastro" id="exame" size="66">
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Est. do fundo:
		<input name="est_fundo" type="text" class="combo_cadastro" id="est_fundo" size="66">
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chassis:
		<input name="chassis" type="text" class="combo_cadastro" id="chassis" size="66">
		<a href="javascript:;" onClick="abrepop('pop_chassis.php');"><img src="imgs/icons/btn_plus.gif" title="Adicionar da lista..." width="14" border=0 height="14"></a>
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Moldura:
		<input name="moldura" type="text" class="combo_cadastro" id="moldura" size="66">
		<a href="javascript:;" onClick="abrepop('pop_moldura.php');"><img src="imgs/icons/btn_plus.gif" title="Adicionar da lista..." width="14" border=0 height="14"></a>
		<br>
		&nbsp;&nbsp;&nbsp;Camada pictórica:
		<input name="camada_pic" type="text" class="combo_cadastro" id="camada_pic" size="62">
		<a href="javascript:;" onClick="abrepop('pop_pictorica.php');"><img src="imgs/icons/btn_plus.gif" title="Adicionar da lista..." width="14" border=0 height="14"></a>
		<br>
		&nbsp;&nbsp;&nbsp;Camada de proteção:
		<input name="camada_prot" type="text" class="combo_cadastro" id="camada_prot" size="58">
		<a href="javascript:;" onClick="abrepop('pop_protecao.php');"><img src="imgs/icons/btn_plus.gif" title="Adicionar da lista..." width="14" border=0 height="14"></a>
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Suporte:
		<input name="suporte" type="text" class="combo_cadastro" id="suporte" size="66">
		<a href="javascript:;" onClick="abrepop('pop_suporte.php');"><img src="imgs/icons/btn_plus.gif" title="Adicionar da lista..." width="14" border=0 height="14"></a>
		<br>
</label>
		<div align="right"><input type="submit" name="ok" value="Pesquisar" class="texto_bold">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
		<br>
	</th>

	<? } else {
		echo "<form name='form' method='post' action='restconsulta.php'>";
		echo "<th colspan='4' align='right' valign='bottom' class='texto_bold'>";
		if ($_REQUEST[pagesize] < 999) echo "<input type='submit' name='nova' value='Nova consulta' class='combo_cadastro' style='cursor:pointer; border-width: 1px;'>";
		echo "</th>";
	} ?>

	</form>
  </tr>

<? if ($_REQUEST['ok']<>'' || $_REQUEST[page]<>'') { ?>
  <tr>
    <td valign="top" colspan="4"><form name="form1" method="post">
      <?
	  /////Paginando
	  $pagesize=6;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
/*	  $sql="SELECT count(*) as total from restauro as a $joinpintura $joinrest_foto where 1 $condicao";
	 // echo $sql;
	//  exit;
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];*/
	  $sql="SELECT distinct a.* from restauro as a $joinpintura $joinrest_foto where 1 $condicao";
	  $db->query($sql);
	  $numlinhas=$db->contalinhas();
	  /////////////////////
          $sql2="SELECT distinct a.* from restauro as a $joinpintura $joinrest_foto where 1 $condicao order by a.ir + 0, a.tombo, a.seq_restauro, a.titulo LIMIT $registroinicial,$pagesize";
          
//echo $sql2;
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="6" bgcolor="#000000" class="texto"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="70%" height="40" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;Obras
              do restauro com: <? echo $txtpesquisa; ?></div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold" valign="bottom"><div align="center">IR-controle</div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<?
		 while($row=$db->dados())
	  { 
	     $tipo=$row['tipo'];
	     $origem=$row['interna']; // apenas para ajudar a montar a pagina correta.
		  if($tipo==1){
			  if($origem=='I'){
		           $cabecalho='restauracao_papel_interna.php';}
			  elseif($origem=='E'){
			       $cabecalho='restauracao_papel_externa.php';}
	      }
		  elseif($tipo==2){
		      if($origem=='I'){
		           $cabecalho='restauracao_pintura_interna.php';}
			  elseif($origem=='E'){
			       $cabecalho='restauracao_pintura_externa.php';}
	      }
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['restauro'] ?>">
          <td align="justify" width='70%' height="40"><b><? echo $row['tombo']." ".$row[controle] ?></b> - <? echo $row['titulo'] ?><? if ($row['nome_objeto']<>'') echo ' - '.$row['nome_objeto']; ?><br><em><? echo $row['autor']; ?></em></td>
          <td align="center" width='15%'><? echo $row['ir']."-".$row['seq_restauro'] ?></td>
          <td align="center" width='15%'><? if ($_REQUEST[pagesize] < 999) echo "<a href=\"".$cabecalho."?op=view&id=".$row['restauro']."\">
	 <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informações' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[restauro]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[restauro]."\").style.backgroundColor=\"\";'>"; }?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"restconsulta.php?pagesize=999999&page=1&tipo=".trim($_REQUEST[tipo])."&origem=".$_REQUEST[origem]."&num_registro=".trim($_REQUEST[num_registro])."
&ir=".trim($_REQUEST[ir])."&seq_restauro=".trim($_REQUEST[seq_restauro])."&autor=".$_REQUEST[autor]."&titulo=".$_REQUEST[titulo]."
&colecao=".trim($_REQUEST[colecao])."&tecnica=".trim($_REQUEST[tecnica])."&nome_objeto=".$_REQUEST[nome_objeto]."
&obs=".$_REQUEST[obs]."&tipo_fundo=".$_REQUEST[tipo_fundo]."&tecnico=".$_REQUEST[tecnico]."&tratamento=".$_REQUEST[tratamento]."&conserva=".$_REQUEST[conserva]."&suporte=".$_REQUEST[suporte]."&exame=".$_REQUEST[exame]."&chassis=".$_REQUEST[chassis]."&est_fundo=".$_REQUEST[est_fundo]."&moldura=".$_REQUEST[moldura]."&camada_pic=".$_REQUEST[camada_pic]."&camada_prot=".$_REQUEST[camada_prot]."&suporte2=".$_REQUEST[suporte2]."&temimg=".$_REQUEST[temimg]."&temimgad=".$_REQUEST[temimgad]."&propriedade=".$_REQUEST[propriedade]."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
        </tr>
        <tr>
          <td height="1" colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto" bgcolor="#ddddd5">
          <td colspan="6" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"restconsulta.php?page=".$first."&tipo=".trim($_REQUEST[tipo])."&origem=".$_REQUEST[origem]."&num_registro=".trim($_REQUEST[num_registro])."
&ir=".trim($_REQUEST[ir])."&seq_restauro=".trim($_REQUEST[seq_restauro])."&autor=".$_REQUEST[autor]."&titulo=".$_REQUEST[titulo]."
&colecao=".trim($_REQUEST[colecao])."&tecnica=".trim($_REQUEST[tecnica])."&nome_objeto=".$_REQUEST[nome_objeto]."
&obs=".$_REQUEST[obs]."&tipo_fundo=".$_REQUEST[tipo_fundo]."&tecnico=".$_REQUEST[tecnico]."&tratamento=".$_REQUEST[tratamento]."&conserva=".$_REQUEST[conserva]."&suporte=".$_REQUEST[suporte]."&exame=".$_REQUEST[exame]."&chassis=".$_REQUEST[chassis]."&est_fundo=".$_REQUEST[est_fundo]."&moldura=".$_REQUEST[moldura]."&camada_pic=".$_REQUEST[camada_pic]."&camada_prot=".$_REQUEST[camada_prot]."&suporte2=".$_REQUEST[suporte2]."&temimg=".$_REQUEST[temimg]."&temimgad=".$_REQUEST[temimgad]."&propriedade=".$_REQUEST[propriedade]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial'></a>";

$b="<a href=\"restconsulta.php?page=".$menos."&tipo=".trim($_REQUEST[tipo])."&origem=".$_REQUEST[origem]."&num_registro=".trim($_REQUEST[num_registro])."
&ir=".trim($_REQUEST[ir])."&seq_restauro=".trim($_REQUEST[seq_restauro])."&autor=".$_REQUEST[autor]."&titulo=".$_REQUEST[titulo]."
&colecao=".trim($_REQUEST[colecao])."&tecnica=".trim($_REQUEST[tecnica])."&nome_objeto=".$_REQUEST[nome_objeto]."
&obs=".$_REQUEST[obs]."&tipo_fundo=".$_REQUEST[tipo_fundo]."&tecnico=".$_REQUEST[tecnico]."&tratamento=".$_REQUEST[tratamento]."&conserva=".$_REQUEST[conserva]."&suporte=".$_REQUEST[suporte]."&exame=".$_REQUEST[exame]."&chassis=".$_REQUEST[chassis]."&est_fundo=".$_REQUEST[est_fundo]."&moldura=".$_REQUEST[moldura]."&camada_pic=".$_REQUEST[camada_pic]."&camada_prot=".$_REQUEST[camada_prot]."&suporte2=".$_REQUEST[suporte2]."&temimg=".$_REQUEST[temimg]."&temimgad=".$_REQUEST[temimgad]."&propriedade=".$_REQUEST[propriedade]."\"><img src='imgs/icons/btn_anterior.gif' border='0'  alt='Registro Anterior'></a>";

$c="<a href=\"restconsulta.php?page=".$mais."&tipo=".trim($_REQUEST[tipo])."&origem=".$_REQUEST[origem]."&num_registro=".trim($_REQUEST[num_registro])."
&ir=".trim($_REQUEST[ir])."&seq_restauro=".trim($_REQUEST[seq_restauro])."&autor=".$_REQUEST[autor]."&titulo=".$_REQUEST[titulo]."
&colecao=".trim($_REQUEST[colecao])."&tecnica=".trim($_REQUEST[tecnica])."&nome_objeto=".$_REQUEST[nome_objeto]."
&obs=".$_REQUEST[obs]."&tipo_fundo=".$_REQUEST[tipo_fundo]."&tecnico=".$_REQUEST[tecnico]."&tratamento=".$_REQUEST[tratamento]."&conserva=".$_REQUEST[conserva]."&suporte=".$_REQUEST[suporte]."&exame=".$_REQUEST[exame]."&chassis=".$_REQUEST[chassis]."&est_fundo=".$_REQUEST[est_fundo]."&moldura=".$_REQUEST[moldura]."&camada_pic=".$_REQUEST[camada_pic]."&camada_prot=".$_REQUEST[camada_prot]."&suporte2=".$_REQUEST[suporte2]."&temimg=".$_REQUEST[temimg]."&temimgad=".$_REQUEST[temimgad]."&propriedade=".$_REQUEST[propriedade]."\"><img src='imgs/icons/btn_proximo.gif'  border='0'  alt='Proximo Registro'></a>";

$d="<a href=\"restconsulta.php?page=".$last."&tipo=".trim($_REQUEST[tipo])."&origem=".$_REQUEST[origem]."&num_registro=".trim($_REQUEST[num_registro])."
&ir=".trim($_REQUEST[ir])."&seq_restauro=".trim($_REQUEST[seq_restauro])."&autor=".$_REQUEST[autor]."&titulo=".$_REQUEST[titulo]."
&colecao=".trim($_REQUEST[colecao])."&tecnica=".trim($_REQUEST[tecnica])."&nome_objeto=".$_REQUEST[nome_objeto]."
&obs=".$_REQUEST[obs]."&tipo_fundo=".$_REQUEST[tipo_fundo]."&tecnico=".$_REQUEST[tecnico]."&tratamento=".$_REQUEST[tratamento]."&conserva=".$_REQUEST[conserva]."&suporte=".$_REQUEST[suporte]."&exame=".$_REQUEST[exame]."&chassis=".$_REQUEST[chassis]."&est_fundo=".$_REQUEST[est_fundo]."&moldura=".$_REQUEST[moldura]."&camada_pic=".$_REQUEST[camada_pic]."&camada_prot=".$_REQUEST[camada_prot]."&suporte2=".$_REQUEST[suporte2]."&temimg=".$_REQUEST[temimg]."&temimgad=".$_REQUEST[temimgad]."&propriedade=".$_REQUEST[propriedade]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0'  alt='Ultimo Registro'></a>";

$combo="";

 for($i=1;$i<=$numpages;$i++)
 {
  if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 } 
  $lista_combo="<select name=i onChange='obtem_valor(this,this.value)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }
//echo"$lista_combo";
$txtpagina= "";
if ($_REQUEST[pagesize] < 999) {
	$txtpagina= "- Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;";
}
$g= " Total de registros encontrados: $numlinhas ".$txtpagina.$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="6" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="6"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
<? } ?>
</table>
</body>
</html>