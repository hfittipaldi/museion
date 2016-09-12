<? include_once("seguranca.php");
   if ($_SESSION['s_imp_total'] == '')
		$_SESSION['s_imp_total']= 0;
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style type="text/css">
.rolagem { 
	scrollbar-shadow-color:transparent;
}
</style>
<script language="JavaScript">
 totlinhas= 0;
 modelo= 1;
function muda_modelo($val) {
	if ($val==undefined || $val=='')
		$val= 1;
	document.getElementById("ta_descricao").style.display= 'none';
	document.getElementById("ta_exposicao").style.display= 'none';
	document.getElementById("ta_bibliografia").style.display= 'none';
<? if (strtoupper($_SESSION[snome]) != 'VISITANTE') { ?>
	document.getElementById("ta_seguro").style.display= 'none';
<? } ?>
	document.getElementById("modelo1").checked= false;
	document.getElementById("modelo2").checked= false;
	document.getElementById("modelo3").checked= false;
	document.getElementById("modelo4").checked= false;
<? if (strtoupper($_SESSION[snome]) != 'VISITANTE') { ?>
	document.getElementById("modelo5").checked= false;
<? } ?>
	document.getElementById("modelo"+$val).checked= true;
	modelo= $val;
	if ($val == 2)
		document.getElementById("ta_descricao").style.display= '';
	else if ($val == 3)
		document.getElementById("ta_bibliografia").style.display= '';
	else if ($val == 4) {
		document.getElementById("ta_descricao").style.display= '';
		document.getElementById("ta_exposicao").style.display= '';
		document.getElementById("ta_bibliografia").style.display= '';

	        }
	else if ($val == 5) 
		document.getElementById("ta_seguro").style.display= '';
}



function abreAutor(id) {
 win=window.open('consulta_autor.php?id='+id+'&pop=1','autor','left='+((window.screen.width/2)-300)+',top='+((window.screen.height/2)-250)+',width=590,height=500, scrollbars=yes, resizable=no');
 if(parseInt(navigator.appVersion)>=4) {
   win.window.focus();
 }
 return true;
}
function abrepop(janela,alt,larg) {
	var h=screen.height-100,w=screen.width-50;
	win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}
function abrepop2(janela,alt,larg) {
	win=window.open(janela,'lista_impressao','left='+((window.screen.width/2)-200)+',top='+((window.screen.height/2)-200)+',width=400,height=400,scrollbars=yes, resizable=no');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}
function abrepop3(janela,alt,larg) {
	win=window.open(janela,'impressao','left='+((window.screen.width/2)-370)+',top='+((window.screen.height/2)-290)+',width=740,height=560,menubar=yes, toolbar=yes, scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}
function abrepop4(janela) {
	win=window.open(janela,'lista_imagem','left='+((window.screen.width/2)-740/2)+',top='+((window.screen.height/2)-520/2)+',width=720,height=460,scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}
function mostra_parametros() {
	if (document.getElementById('parametros').style.display == '') {
		document.getElementById('parametros').style.display= 'none';
		document.getElementById('img_mod').src="imgs/icons/mais.gif";
	}
	else {
		document.getElementById('parametros').style.display= '';
		document.getElementById('img_mod').src="imgs/icons/menos.gif";
	}
}

function Imprimir() {
	parent.frames[0].focus();
	parent.frames[0].print();
	return
}
function obtem_valor(qual,i,modelo) {
//if (qual.selectedIndex.selected!= '') {
document.location=('obraconsulta1.php?page='+ i+ '&modelo='+modelo+
'&num_serie=<? echo trim($_REQUEST[num_serie]); ?>
&num_edicao=<? echo trim($_REQUEST[num_edicao]); ?>
&num_processo=<? echo trim($_REQUEST[num_processo]); ?>
&inventario=<? echo trim($_REQUEST[inventario]); ?>
&ctrlinv=<? echo trim($_REQUEST[ctrlinv]); ?>
&num_registro=<? echo trim($_REQUEST[num_registro]);?>
&editor=<? echo trim($_REQUEST[editor]);?>
&impressor=<? echo trim($_REQUEST[impressor]);?>
&forma_aquisicao=<? echo trim($_REQUEST[forma_aquisicao]);?>
&local_fixo=<? echo trim($_REQUEST[local_fixo]);?>
&deAno=<? echo $_REQUEST[deAno]; ?>
&ateAno=<? echo $_REQUEST[ateAno]; ?>
&deAnoParte=<? echo $_REQUEST[deAnoParte]; ?>
&ateAnoParte=<? echo $_REQUEST[ateAnoParte]; ?>
&descr_formal=<? echo trim($_REQUEST[descr_formal]);?>
&desc_conteudo=<? echo trim($_REQUEST[desc_conteudo]);?>
&obs=<? echo trim($_REQUEST[obs]);?>
&estado_conserv=<? echo trim($_REQUEST[estado_conserv]);?>
&localizada=<? echo trim($_REQUEST[localizada]);?>
&foto=<? echo trim($_REQUEST[foto]);?>
&pasp=<? echo trim($_REQUEST[pasp]);?>
&base=<? echo trim($_REQUEST[base]);?>
&moldura=<? echo trim($_REQUEST[moldura]);?>
&temfoto=<? echo trim($_REQUEST[temfoto]);?>
&temnegativo=<? echo trim($_REQUEST[temnegativo]);?>
&temdiapositivo=<? echo trim($_REQUEST[temdiapositivo]);?>
&temrestauro=<? echo trim($_REQUEST[temrestauto]);?>
&periodo=<? echo trim($_REQUEST[periodo]);?>
&multi_autor=<? echo trim($_REQUEST[multi_autor]);?>
&dim_obra_altura=<? echo trim($_REQUEST[dim_obra_altura]);?>
&dim_obra_largura=<? echo trim($_REQUEST[dim_obra_largura]);?>
&dim_obra_diametro=<? echo trim($_REQUEST[dim_obra_diametro]);?>
&dim_obra_profundidade=<? echo trim($_REQUEST[dim_obra_profundidade]);?>
&dim_obra_peso=<? echo trim($_REQUEST[dim_obra_peso]);?>
&aimp_obra_altura=<? echo trim($_REQUEST[aimp_obra_altura]);?>
&aimp_obra_largura=<? echo trim($_REQUEST[aimp_obra_largura]);?>
&aimp_obra_diametro=<? echo trim($_REQUEST[aimp_obra_diametro]);?>
&doador=<? echo trim($_REQUEST[doador]);?>
&outras_inscr=<? echo trim($_REQUEST[outras_inscr]);?>
&atribuida=<? echo trim($_REQUEST[atribuida]);?>
&objeto=<? echo trim($_REQUEST[objeto]);?>
&material_tecnica=<? echo trim($_REQUEST[material_tecnica]);?>
&destaque=<? echo trim($_REQUEST[destaque]);?>
&escola=<? echo trim($_REQUEST[escola]);?>
&estilo=<? echo trim($_REQUEST[estilo]);?>
&movimento=<? echo trim($_REQUEST[movimento]);?>
&sub_tema=<? echo trim($_REQUEST[sub_tema]);?>
&idtemas=<? echo trim($_REQUEST[idtemas]);?>
&titulo=<? echo trim($_REQUEST[titulo]);?>
&autor=<? echo trim($_REQUEST[autor]);?>
&tema=<? echo trim($_REQUEST[tema]);?>
&colecao=<? echo trim($_REQUEST[colecao]);?>
&ref_biblio=<? echo trim($_REQUEST[ref_biblio]);?>
&ref_autor=<? echo trim($_REQUEST[ref_autor]);?>
&expo_ini=<? echo trim($_REQUEST[expo_ini]);?>
&expo_fim=<? echo trim($_REQUEST[expo_fim]);?>
&expo_nome=<? echo trim($_REQUEST[expo_nome]);?>
&expo_ins=<? echo trim($_REQUEST[expo_ins]);?>
&expo_pais=<? echo trim($_REQUEST[expo_pais]);?>
&expo_estado=<? echo trim($_REQUEST[expo_estado]);?>
&expo_periodo=<? echo trim($_REQUEST[expo_periodo]);?>
&expo_premio=<? echo trim($_REQUEST[expo_premio]);?>
&idcolecoes=<? echo trim($_REQUEST[idcolecoes]); ?>
&exprop=<? echo trim($_REQUEST[exprop]); ?>
&lista_registro=<? echo trim($_REQUEST[lista_registro]); ?>');
// }
}
function abre_pagina(idobra,title)
{
  	win=window.open('consulta_obra.php?op=view&nosave=1&titulo='+title+'&obra='+idobra,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-240)+',height=480,width=780,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
function abre_pagina2(parametro)
{
  	win=window.open('consulta_frame.php?'+parametro,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-130)+',height=100,width=250,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>
</head>
<body onLoad="if (totlinhas > 0) { muda_modelo(<? echo $_REQUEST['modelo']; ?>); }">
<table width="540"  border="1" align="left" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2">
  <tr>
    <th width="486" colspan="1" scope="col" class="tit_interno">
	    <?
		echo "<form name='form' method='post' action='obraconsulta.php'>";
		echo "<th align='right' valign='bottom' class='texto_bold'>";
		echo "<input type='submit' name='nova' value='Nova consulta' class='combo_cadastro' style='cursor:pointer; border-width: 1px;'>";
		echo "</th></form>";
      ?>
    </th>
  </tr>
<? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db2=new conexao();
$db2->conecta();
$db3=new conexao();
$db3->conecta();
$db4=new conexao();
$db4->conecta();

function exibeDataNegativa($valor) {
	if ($valor < 0)
		return substr($valor,1) . " aC";
	else
		return $valor;
}

$dir= diretorio_fisico();
$dir_virtual= diretorio_virtual();

echo "<span class='tit_interno'>$_SESSION[lnk]</span>";
$deAno= $_REQUEST['deAno'];
$ateAno= $_REQUEST['ateAno'];
$deAnoParte= $_REQUEST['deAnoParte'];
$ateAnoParte= $_REQUEST['ateAnoParte'];
$deExpo= $_REQUEST['expo_ini'];
$ateExpo= $_REQUEST['expo_fim'];
set_time_limit(0);

function percente_obras($achadas)
{
 global $db;
 $sql="SELECT count(*) from obra where status = 'P'";
 $db->query($sql);
 $res=$db->dados();
 $tot= $res[0];
 $percent= ($achadas * 100) / $tot;
 return number_format($percent,2,",",".") . "|||" . $tot;
}
function ret_aquisicao($sigla)
{
 global $db;
 $sql="SELECT nome from forma_aquisicao where forma_aquisicao = '$sigla'";
 $db->query($sql);
 $res=$db->dados();
 return $res[0];
}
function ret_local($sigla)
{
 global $db;
 $sql="SELECT nome from local where local = '$sigla'";
 $db->query($sql);
 $res=$db->dados();
 return $res[0];
}
function ret_data_obra($obrid)
{
 global $db;
 $sql="SELECT dt_parte_ano1,dt_parte_ano2,dt_parte_tp from parte where obra='$obrid' order by controle";
 $db->query($sql);
 $res=$db->dados();
 return $res[0]."|".$res[1]."|".$res[2];
}
function ret_colecao()
{
 global $db;
 $sql="SELECT nome from colecao where colecao=$_REQUEST[colecao]";
 $db->query($sql);
 $res=$db->dados();
 return $res[0];
}
function ret_colecao_obra($obrid)
{
 global $db;
 $sql="SELECT nome from colecao as a, obra as b where a.colecao=b.colecao AND b.obra='$obrid'";
 $db->query($sql);
 $res=$db->dados();
 return $res[0];
}
function ret_autor($valor)
{
 global $db;
// $sql="SELECT A.nomeetiqueta from autor A,autor_obra B WHERE (A.autor=B.autor) AND B.autor='$_REQUEST[autor]'";
 //$sql="SELECT A.nomeetiqueta from autor A,autor_obra B WHERE (A.autor=B.autor) AND (B.autor='$_REQUEST[autor]' OR B.obra='$row[obra]')";
/* $sql="SELECT A.nomeetiqueta from autor A,autor_obra B WHERE (A.autor=B.autor) AND (B.obra='$valor')"; */
 $sql="SELECT nomeetiqueta from autor WHERE autor='$valor'";
 $db->query($sql);
 $res=$db->dados();
 return $res[0];
}

function parte_ass($obrid)
{
 global $db2;
 $sql="SELECT assinada,transc_assinatura from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 if ($res['assinada'] == 'S') {
	$ass= "assinada <em>".$res['transc_assinatura']."</em>";
 }
 else {
	$ass= "sem assinatura";
 }
 return $ass;
}


function ret_booleano($valor)
{
 if($valor=='S')
 return 'Sim';
 else
 return 'Não';
} 
function ret_estado()
{
 global $db;
  $sql="SELECT descricao from estado_conserv where estado_conserv=$_REQUEST[estado_conserv]";
  $db->query($sql);
  $res=$db->dados();
return $res[0];
}
function ret_forma()
{
global $db;
 $sql="SELECT nome from forma_aquisicao where forma_aquisicao='$_REQUEST[forma_aquisicao]'";
 $db->query($sql);
 $res=$db->dados();
 return $res[0];
}
function atualizaQuantidadeColecao($col) {
global $db;
 $sql="UPDATE colecao set quantidade=(quantidade+1) where colecao in ($col)";
 $db->query($sql);
}
 $condicao= '';
 $joinautor=1;
 $joinparte=0;
 $jointema=0;
 $joinfoto=0;
 $joinbibliografia=0;
 $joinexposicao=0;
 $joinmulti=0;
//Aba Classificacao
/*if($_REQUEST['colecao']<> 0)
{  
   $condicao=" AND colecao=$_REQUEST[colecao] ";
   $txtpesquisa= "<br>&nbsp;- Coleção: <font style='color:brown>".ret_colecao($_REQUEST['colecao'])."</font>";
}*/
if (trim($_REQUEST['idcolecoes']) <> '') {
    $condicao=$condicao." AND colecao in ($_REQUEST[idcolecoes])";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Coleções: <font style='color:brown;'>".str_replace(",",", ",trim($_REQUEST['colecao']))."</font>";
	atualizaQuantidadeColecao($_REQUEST[idcolecoes]);
}

if($_REQUEST['autor']<> '')
{
   $condicao=$condicao." AND B.autor=$_REQUEST[autor]";
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Autor: <font style='color:brown;'>".ret_autor($_REQUEST['autor'])."</font>";
   $joinautor=1;
 }

if($_REQUEST['atribuida']<> '')
{
   if ($_REQUEST['autor']<> '') {
	$condicao=$condicao." AND B.autor=$_REQUEST[autor] AND B.atribuido='$_REQUEST[atribuida]'";
   } else {
	$condicao=$condicao." AND B.atribuido='$_REQUEST[atribuida]'";
   }
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Atribuido: <font style='color:#ffffff;'>".ret_booleano($_REQUEST['atribuida'])."</font>";
   $joinautor=1;
 }

if($_REQUEST['multi_autor']== 'S')
{
   $condicao=$having." GROUP BY O.obra HAVING count(B.autor)>1";
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Multi Autoria: <font style='color:#ffffff;'>Sim</font>";
   $joinmulti=1;
 }

if (trim($_REQUEST['titulo']) <> '') {
	$condicao=$condicao. " AND (titulo like '%".trim($_REQUEST['titulo'])."%' OR titulo_etiq like '%".trim($_REQUEST['titulo'])."%') ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Titulo: <font style='color:brown;'>".trim($_REQUEST['titulo'])."</font>";
}

if (trim($_REQUEST['idtemas']) <> '') {
    $condicao=$condicao." AND T.tema in ($_REQUEST[idtemas])";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Temas: <font style='color:brown;'>".str_replace(",",", ",trim($_REQUEST['tema']))."</font>";
    $jointema=1;
}

if (trim($_REQUEST['sub_tema']) <> '') {
	$condicao=$condicao. " AND sub_tema like '%".trim($_REQUEST['sub_tema'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Sub-Temas: <font style='color:brown;'>".trim($_REQUEST['sub_tema'])."</font>";
}
if (trim($_REQUEST['movimento']) <> '') {
	$condicao=$condicao. " AND movimento like '%".trim($_REQUEST['movimento'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Movimento: <font style='color:brown;'>".trim($_REQUEST['movimento'])."</font>";
}
if (trim($_REQUEST['estilo']) <> '') {
	$condicao=$condicao." AND estilo like '%".trim($_REQUEST['estilo'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Estilo: <font style='color:brown;'>".trim($_REQUEST['estilo'])."</font>";
}
if (trim($_REQUEST['escola']) <> '') {
	$condicao=$condicao." AND escola like '%".trim($_REQUEST['escola'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Escola: <font style='color:brown;'>".trim($_REQUEST['escola'])."</font>";
}
if ($_REQUEST['destaque'] <> '') {
	$condicao=$condicao." AND eh_destaque_acervo='$_REQUEST[destaque]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Destaque do Acervo: <font style='color:brown;'>".ret_booleano($_REQUEST['destaque'])."</font>";
}


// Continuacao da Aba Textos
if ($deAno<>'' || $ateAno<>'') {
	if ($deAno<>'' && $ateAno=='') {
		$de= $deAno;
		$ate= date("Y");
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Aquisição entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAno)."</font> e <font style='color:brown;'>".date("Y")."</fotn>";
	}
	elseif ($deAno=='' && $ateAno<>'') {
		$de= "-9999";
		$ate= $ateAno;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Aquisição até o ano de <font style='color:brown;'>".exibeDataNegativa($ateAno)."</font>";
	}
	if ($deAno<>'' && $ateAno<>'') {
		$de= $deAno;
		$ate= $ateAno;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Aquisição entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAno)."</font> e <font style='color:brown;'>".exibeDataNegativa($ateAno)."</fotn>";
	}

	$condicao= $condicao." AND (((dt_aquisicao_ano1 >= $de and dt_aquisicao_ano1 <= $ate) OR (dt_aquisicao_ano2 >= $de and dt_aquisicao_ano2 <= $ate and dt_aquisicao_ano2 <> 0) OR (dt_aquisicao_ano1 <= $de and dt_aquisicao_ano2 >= $ate and dt_aquisicao_ano2 <> 0)) AND dt_aquisicao_ano1 <> 0) ";
}
///
if ($deAnoParte<>'' || $ateAnoParte<>'') {
	if ($deAnoParte<>'' && $ateAnoParte=='') {
		$deParte= $deAnoParte;
		$ateParte= date("Y");
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Data da obra entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAnoParte)."</font> e <font style='color:brown;'>".date("Y")."</fotn>";
	}
	elseif ($deAnoParte=='' && $ateAnoParte<>'') {
		$deParte= "-9999";
		$ateParte= $ateAnoParte;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Data da obra até o ano de <font style='color:brown;'>".exibeDataNegativa($ateAnoParte)."</font>";
	}
	if ($deAnoParte<>'' && $ateAnoParte<>'') {
		$deParte= $deAnoParte;
		$ateParte= $ateAnoParte;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Data da obra entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAnoParte)."</font> e <font style='color:brown;'>".exibeDataNegativa($ateAnoParte)."</fotn>";
	}

	$condicao= $condicao." AND (((P.dt_parte_ano1 >= $deParte and P.dt_parte_ano1 <= $ateParte) OR (P.dt_parte_ano2 >= $deParte and P.dt_parte_ano2 <= $ateParte and P.dt_parte_ano2 <> 0) OR (P.dt_parte_ano1 <= $deParte and P.dt_parte_ano2 >= $ateParte and P.dt_parte_ano2 <> 0)) AND P.dt_parte_ano1 <> 0) ";
    $joinparte=1;
}
///
if ($deExpo<>'' || $ateExpo<>'') {
	if ($deExpo<>'' && $ateExpo=='') {
		$de= $deExpo;
		 $de= explode("/", $de);
		 $ano= $de[2]; $mes= $de[1]; $dia= $de[0];
		 $de= $ano."-".$mes."-".$dia;
		$ate= date("Y-m-d");
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Exposição entre as datas de <font style='color:brown;'>".$deExpo."</font> e <font style='color:brown;'>".date("d/m/Y")."</fotn>";
	}
	elseif ($deExpo=='' && $ateExpo<>'') {
		$de= "0000-00-00";
		$ate= $ateExpo;
		 $ate= explode("/", $ate);
		 $ano= $ate[2]; $mes= $ate[1]; $dia= $ate[0];
		 $ate= $ano."-".$mes."-".$dia;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Exposição até a data de <font style='color:brown;'>".$ateExpo."</font>";
	}
	if ($deExpo<>'' && $ateExpo<>'') {
		$de= $deExpo;
		 $de= explode("/", $de);
		 $ano= $de[2]; $mes= $de[1]; $dia= $de[0];
		 $de= $ano."-".$mes."-".$dia;
		$ate= $ateExpo;
		 $ate= explode("/", $ate);
		 $ano= $ate[2]; $mes= $ate[1]; $dia= $ate[0];
		 $ate= $ano."-".$mes."-".$dia;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Exposição entre as datas de <font style='color:brown;'>".$deExpo."</font> e <font style='color:brown;'>".$ateExpo."</fotn>";
	}

	$condicao= $condicao." AND (((E.dt_inicial >= '$de' and E.dt_inicial <= '$ate') OR (E.dt_final >= '$de' and E.dt_final <= '$ate' and E.dt_final <> 0) OR (E.dt_inicial <= '$de' and E.dt_final >= '$ate' and E.dt_final <> 0)) AND E.dt_inicial <> 0) ";
    $joinexposicao=1;
}

if ($_REQUEST['dim_obra_altura'] <> '') {
	$condicao=$condicao." AND dim_obra_altura='$_REQUEST[dim_obra_altura]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Altura da Obra: <font style='color:#ffffff;'>".trim($_REQUEST['dim_obra_altura'])."</font>";

}
if ($_REQUEST['dim_obra_largura'] <> '') {
	$condicao=$condicao." AND dim_obra_largura='$_REQUEST[dim_obra_largura]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Largura da Obra: <font style='color:#ffffff;'>".trim($_REQUEST['dim_obra_largura'])."</font>";

}
if ($_REQUEST['dim_obra_diametro'] <> '') {
	$condicao=$condicao." AND dim_obra_diamentro='$_REQUEST[dim_obra_diamentro]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Diâmetro da Obra: <font style='color:#ffffff;'>".trim($_REQUEST['dim_obra_diamentro'])."</font>";

}
if ($_REQUEST['dim_obra_profundidade'] <> '') {
	$condicao=$condicao." AND dim_obra_profundidade='$_REQUEST[dim_obra_profundidade]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Profundidade da Obra: <font style='color:#ffffff;'>".trim($_REQUEST['dim_obra_profundidade'])."</font>";

}
if ($_REQUEST['dim_obra_peso'] <> '') {
	$condicao=$condicao." AND dim_obra_peso='$_REQUEST[dim_obra_peso]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Peso da Obra: <font style='color:#ffffff;'>".trim($_REQUEST['dim_obra_peso'])."</font>";

}
if ($_REQUEST['aimp_obra_altura'] <> '') {
	$condicao=$condicao." AND aimp_obra_altura='$_REQUEST[aimp_obra_altura]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Altura da &Aacute;rea Impressa: <font style='color:#ffffff;'>".trim($_REQUEST['aimp_obra_altura'])."</font>";

}
if ($_REQUEST['aimp_obra_largura'] <> '') {
	$condicao=$condicao." AND aimp_obra_largura='$_REQUEST[aimp_obra_largura]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Largura da &Aacute;rea Impressa: <font style='color:#ffffff;'>".trim($_REQUEST['aimp_obra_largura'])."</font>";

}
if ($_REQUEST['aimp_obra_diametro'] <> '') {
	$condicao=$condicao." AND aimp_obra_diamentro='$_REQUEST[aimp_obra_diamentro]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Diâmetro da &Aacute;rea Impressa: <font style='color:#ffffff;'>".trim($_REQUEST['aimp_obra_diamentro'])."</font>";

}
?>
  <tr>
    <td valign="top" colspan="2"></td>
  </tr>
  <tr>
    <td valign="top" colspan="2"><!--<form name="form1" method="post" >-->
      <?
	  $pagesize=1;
      if(!empty($_REQUEST['pagesize']))
         $pagesize=$_REQUEST['pagesize'];
      $page=1;
      if(!empty($_REQUEST['page']))
         $page=$_REQUEST['page'];
      $page--;
	/*  $impressao = 0;
      if(!empty($_GET['impressao']))
         $impressao=$_GET['impressao'];

	  /////Paginando
      $page=1;
  
      if(!empty($_GET['page']))
         $page=$_GET['page'];
	  $pagesize=10;
      if($impressao!='') {
         $pagesize=999999;
		 $page=1;
	   }
      $page--;*/
	  $registroinicial=$page* $pagesize;
//	  $select="count(DISTINCT O.obra) as total";
	  $select="DISTINCT O.obra, O.num_registro";
	  if ($joinmulti==1) { 
		$select = $select.", count(B.autor)";
          }
	  $from='from obra as O';
	  if($joinautor==1){
	    $from = $from.' INNER JOIN autor_obra as B ON (O.obra = B.obra)';
	    $from = $from.' INNER JOIN autor as A ON (B.autor = A.autor)';
	   }
	  if($joinparte==1){
	     $from = $from.' INNER JOIN parte as P ON (O.obra = P.obra)';
	  }
	  if($joinbibliografia==1){
	    $from = $from.' INNER JOIN obra_bibliografia as C ON (O.obra = C.obra)';
	    $from = $from.' INNER JOIN bibliografia as R ON (R.bibliografia = C.bibliografia)';
	   }
	  if($joinexposicao==1){
	    $from = $from.' INNER JOIN obra_exposicao as D ON (O.obra = D.obra)';
	    $from = $from.' INNER JOIN exposicao as E ON (E.exposicao = D.exposicao)';
	   }
	  if($jointema==1){
	     $from = $from.' INNER JOIN tema_obra as T ON (O.obra = T.obra)';
	  }

	 if($joinfoto==1){
	     $from = $from.' INNER JOIN fotografia_obra as F ON (O.obra = F.obra)';
	  }
/*	 elseif($joinfoto==2){
	     $from = $from.' LEFT JOIN fotografia_obra as F ON (O.obra = F.obra)';
	  }*/
//	   $sql="SELECT $select $from where O.status='P' and (B.hierarquia = 1 or B.hierarquia IS null) $condicao";
	   $sql="SELECT $select $from where O.status='P' $condicao";
        if ($joinmulti==1) {
		$sql = $sql.$having;
        }
	//echo $sql;
//   Salva o SQL em outra variavel para consulta pelo numero do registro
    $sqlPesq="SELECT DISTINCT num_registro $from where status='P' $condicao order by num_registro + 0 asc";
    //echo "<br>sqlPesq=".$sqlPesq;
    echo "<script>";
    echo "var numreg = new Array()"."\r\n";
    $db4->query($sqlPesq);
    $i=0;
    while ($row=$db4->dados()) {
    		$i=$i+1;
    		echo "numreg[$i]='".$row[num_registro]."'"."\r\n";
    }
    echo "numreg[0]=".$i."\r\n";
    echo "function localiza(pos) {
              slot=1
              fim=numreg[0]+1
              for (v1=1;(v1<fim);v1++) {
                  if (numreg[v1]==pos) {
                     slot=v1
                  }
              }
              return slot
          }";
    echo "function valor(objeto) {
    		      alert(objeto)
              return objeto
          }";
    echo "</script>";
	  $db->query($sql);
          //echo "<br>sql=".$sql;
	// marcar/desmarcar todas as obras para impressão \\
	  if ($_REQUEST['marcar_todas'] == '1') {
			$_SESSION['s_impressao']='';
			$_SESSION['s_imp_total']= 0;
			while ($row=$db->dados()) {
				$_SESSION['s_impressao']= $_SESSION['s_impressao'] . "," . $row['obra'];
				$_SESSION['s_imp_total']++;
			}
			$marcou= 'checked';
/*			echo "<script>alert('Todas as obras da pesquisa foram marcadas!');</script>";*/
	  }
	  elseif ($_REQUEST['marcar_todas'] == '2') {
			$_SESSION['s_impressao']='';
			$_SESSION['s_imp_total']= 0;
			$marcou= '';
/*			echo "<script>alert('As obras foram desmarcadas!');</script>";*/
	  }
	////
	  $numlinhas=$db->contalinhas();
	  echo "<script> totlinhas = ".$numlinhas.";</script>";

		$select2="DISTINCT O.*"; 
  		$sql2="SELECT $select2 $from where status='P' $condicao order by num_registro + 0 asc LIMIT $registroinicial,$pagesize";
		//echo "<br>sql2=".$sql2;
       $db->query($sql2);
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="2" bgcolor="#000000" class="texto_bold"><img src="file:///C|/Documents%20and%20Settings/Administrator/Desktop/imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td height="24" bgcolor="#ddddd5" valign="top" class="texto_bold"><div align="left">&nbsp;<img src="imgs/icons/mais.gif" width="10" height="10" border="0" align="baseline" id="img_mod"><a href="javascript:;" style="color:blue;" onClick="mostra_parametros(); return false;"> Obras com...</a></div><span id="parametros" style="display:none;"><? echo substr($txtpesquisa,4); ?></span></td>
        </tr>
        <tr bgcolor="#f2f2f2">
        </tr>
        <tr>
          <td colspan="2" bgcolor="#000000"><img src="file:///C|/Documents%20and%20Settings/Administrator/Desktop/imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
        <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="6" bgcolor="#f2f2f2">
          <? while($row=$db->dados())
	  {
				$seguro=$row[val_seguro];

				$sql="SELECT a.nome_arquivo,a.diretorio_imagem,a.forma_exibicao,b.eh_principal from fotografia as a, fotografia_obra as b 
					   where a.fotografia = b.fotografia AND b.obra = '$row[obra]' order by b.eh_principal desc";
				$db3->query($sql);
				$dim= $db3->dados();
				$principal= $dim['eh_principal'];
				$forma_exibicao= $dim['forma_exibicao'];
				$altu= number_format($row['dim_obra_altura'],1,",",".");
				$larg= number_format($row['dim_obra_largura'],1,",",".");
				$diam= number_format($row['dim_obra_diametro'],1,",",".");
				$prof= number_format($row['dim_obra_profund'],1,",",".");
				if ($altu == '0,0')
					$altu= '';
				if ($larg == '0,0')
					$larg= '';
				if ($diam == '0,0')
					$diam= '';
				if ($prof == '0,0')
					$prof= '';


				$aimp_altu= number_format($row['aimp_obra_altura'],1,",",".");
				$aimp_larg= number_format($row['aimp_obra_largura'],1,",",".");
				$aimp_diam= number_format($row['aimp_obra_diametro'],1,",",".");

				$imagem= '';
				if ($dim['nome_arquivo'] <> '') {
					$imagem= $dim['nome_arquivo'];
					$diretorio_imagem=$dim['diretorio_imagem'];
					 $sql="SELECT url from diretorio_imagem where diretorio_imagem='$diretorio_imagem'";
					 $db3->query($sql);
					 $url=$db3->dados();
					 $noimage= '';
					// echo $dir.$url[0].'\\'.$imagem;
					 //exit;
					 if (file_exists($dir.$url[0].'\\'.$imagem)) {
						list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url[0].'/'.$imagem);
						$Ao= $height;
						$Lo= $width;

						//150 é a altura max da área de exibição da imagem; 150 é a largura máxima.//
						$cA= $Ao / 150;
						$cL= $Lo / 150;

						if ($Ao > 150 || $Lo > 150) {
							if (cL < cA) {
								$percent= (150 * 100) / $Lo;
								$Lo= 200;
								$Ao= ($Ao * $percent) / 100;
								if ($Ao > 150) {
									$percent= (150 * 100) / $Ao;
									$Ao= 150;
									$Lo= ($Lo * $percent) / 100;
								}

							} else {
								$percent= (150 * 100) / $Ao;
								$Ao= 150;
								$Lo= ($Lo * $percent) / 100;
								if ($Lo > 150) {
									$percent= (150 * 100) / $Lo;
									$Lo= 150;
									$Ao= ($Ao * $percent) / 100;
								}
							}
						}
					} else
						$noimage= "<br>Arquivo não encontrado no servidor";
				}
	  ?>
          <tr class="texto"> 
            <? if ($imagem<>'' && $noimage=='') { ?>
            <!--<td width="30%" valign="middle" align="center" nowrap class="texto"><a href="javascript:;" onClick="abrepop('pop_imagem.php?exibicao=<? echo $forma_exibicao; ?>&principal=<? echo $principal; ?>&imagem=<? echo $url[0].'/'.$imagem; ?>&altura=<? echo $altu; ?>&largura=<? echo $larg; ?>&diametro=<? echo $diam; ?>&profundidade=<? echo $prof; ?>', <? echo $height; ?>, <? echo $width; ?>);"><img src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0'></a></td>-->
				<td width="30%" valign="middle" align="center" nowrap class="texto"><a href="javascript:;" onClick="abrepop4('imagem_lista.php?obra=<? echo $row[obra]; ?>');"><img src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0'></a></td>
            <? } else { 
			echo "<td width='30%' class='texto' align='center' valign='middle' nowrap style='border: 1px dashed #ABABAB; color:#444444;'><sup>Imagem não disponível</sup></td>";
		   } ?> 
            <td width="70%" align="justify" valign="top" class="texto_bold" style="font-weight:normal;"> 
              <!--<label id="popAutor" onClick="abreAutor(<? echo $row[autor]; ?>);">--> 
              <?     
	$sql="SELECT a.* from autor as a INNER JOIN autor_obra as b on (a.autor=b.autor) 
	where b.obra=$row[obra] order by b.hierarquia asc";
	$db->query($sql);
	$lista_autoria= "";
	while ($lista=$db->dados()) {
	        $nasc='';
	        $mort='';
		$sql= "SELECT nome from pais where pais = '$lista[pais_nasc]'";
		$db2->query($sql);
		$pais= $db2->dados();
		$pais= $pais['nome'];
		if (strtoupper($pais) == 'BRASIL') {
			$sql= "SELECT uf from estado where estado = '$lista[estado_nasc]'";
			$db2->query($sql);
			$estado= $db2->dados();
			$estado= ", ".$estado['uf'];
			$nasc.= $lista[cidade_nasc].$estado." ";
	}
		else {
			if ($lista[cidade_nasc]=='?' && $pais=='?')
				$nasc.= "? ";
			elseif ($row[cidade_nasc]==''&& $pais=='')
				$nasc.= "";
			else
				$nasc.= $lista[cidade_nasc].", ".$pais." ";
		}

		if ($lista[dt_nasc_tp] == 'circa')
			$nasc.= " circa ";
		if ($lista[dt_nasc_ano1] <> '0') {
			$nasc.= $lista[dt_nasc_ano1];
		}
		if ($lista[dt_nasc_ano2] <> '0') {
			if ($lista[dt_nasc_ano2] <> $lista[dt_nasc_ano1])
				$nasc.= " / ".$lista[dt_nasc_ano2];
		}
		if ($lista[dt_nasc_tp] == '?')
			$nasc.=" (?) ";
		if ($lista[cidade_nasc] <> $lista[cidade_morte]) {
			$sql= "SELECT nome from pais where pais = '$lista[pais_morte]'";
			$db2->query($sql);
			$pais= $db2->dados();
			$pais= $pais['nome'];
			if (strtoupper($pais) == 'BRASIL') {
				$sql= "SELECT uf from estado where estado = '$lista[estado_morte]'";
				$db2->query($sql);
				$estado= $db2->dados();
				$estado= ", ".$estado['uf'];
				$mort.= $lista[cidade_morte].$estado." ";
			}
			else {
				if ($lista[cidade_morte]=='?' && $pais=='?')
					$mort.= "? ";
				else
					$mort.= $lista[cidade_morte].", ".$pais." ";
			}
		}
		if ($lista[dt_morte_tp] == 'circa')
			$mort.= " circa ";
			if ($lista[dt_morte_ano1] <> '0') {
			$mort.= $lista[dt_morte_ano1];
			}
			if ($lista[dt_morte_ano2] <> '0') {
			if ($lista[dt_morte_ano2] <> $lista[dt_morte_ano1])
				$mort.= " / ".$lista[dt_morte_ano2];
		}
		if ($lista[dt_morte_tp] == '?')
			$mort.=" (?) ";
		$lista_autoria .= "<b>".$lista['nomeetiqueta']."<br></b><em>".$nasc." - ".$mort.  "</em></b><br>";
	}
		echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'>" . $lista_autoria . "</font>";

				?><!--</label>-->
              <br><? echo ret_colecao_obra($row[obra]); ?></em> <br> 
              <b><font style="color:navy;"><? echo $row[num_registro]; ?></font></b> <? if ($row['eh_destaque_acervo'] == 'S') echo "<b><font style='color:maroon;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(destaque do acervo)</b></font>"; ?>
              <br> <b><? echo $row[titulo_etiq];?></b>
              <?
					if ($row[periodo] <> '')
						echo ', '. $row[periodo];
					else
					$p_datas= ret_data_obra($row['obra']);
					$p_datas= explode("|",$p_datas);
					$p_data= $p_datas[0];
					$p_data_extra1= $p_datas[1];
					$p_data_extra2= $p_datas[2];

					if ($p_data_extra2 == 'circa')
						$dat.= " circa ";

					if ($p_data <> '0') {
						$dat.= exibeDataNegativa($p_data);
					}
					if ($p_data_extra1 <> '0') {
						if ($p_data_extra1 <> $p_data)
							$dat.= " / ".exibeDataNegativa($p_data_extra1);
					}

					if ($p_data_extra2 == '?')
						$dat.=" (?) ";

					if (strlen($dat) > 3)
						echo ", " . $dat;
				?>
              <br>
	<? if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . number_format($row['dim_obra_altura'],1,",",".") . " x " . number_format($row['dim_obra_largura'],1,",","."). " x " . number_format($row['dim_obra_profund'],1,",",".") . " cm"; 
	   elseif ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", ". "&Oslash; = " . number_format($row['dim_obra_diametro'],1,",",".") . " cm ; " . number_format($row['dim_obra_profund'],1,",",".") . " cm (profundidade)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . number_format($row['dim_obra_diametro'],1,",",".") . " cm";
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . number_format($row['dim_obra_altura'],1,",",".") . " x " . number_format($row['dim_obra_largura'],1,",",".") . " cm"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
		echo $row[material_tecnica].", " . number_format($row['aimp_obra_altura'],1,",",".") . " x " . number_format($row['aimp_obra_largura'],1,",",".") . " cm (área impressa); ". number_format($row['dim_obra_altura'],1,",",".") . " x " . number_format($row['dim_obra_largura'],1,",",".") . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . number_format($row['aimp_obra_diametro'],1,",",".") . " cm (área impressa); ". "&Oslash; = " . number_format($row['dim_obra_diametro'],1,",",".") . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . number_format($row['aimp_obra_diametro'],1,",",".") . " cm (área impressa); ". number_format($row['dim_obra_altura'],1,",",".") . " x " . number_format($row['dim_obra_largura'],1,",",".") . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
		echo $row[material_tecnica].", " . number_format($row['aimp_obra_altura'],1,",",".") . " x " . number_format($row['aimp_obra_largura'],1,",",".") . " cm (área impressa); ". "&Oslash; = " . number_format($row['dim_obra_diametro'],1,",",".") . " cm (suporte)" ; 
           else 
		echo $row[material_tecnica].", (ERRO - verificar dimensões na ficha técnica)"; 

	?>
              <br> 
              <?
		echo parte_ass($row['obra'])."<br>";
					$dat='';
					if ($row['dt_aquisicao_tp'] == 'circa')
						$dat.= " circa ";

					if ($row['dt_aquisicao_ano1'] <> '0') {
						$dat.= exibeDataNegativa($row['dt_aquisicao_ano1']);
					}
					if ($row['dt_aquisicao_ano2'] <> '0') {
						if ($row['dt_aquisicao_ano2'] <> $row['dt_aquisicao_ano1'])
							$dat.= " / ".exibeDataNegativa($row['dt_aquisicao_ano2']);
					}

					if ($row['dt_aquisicao_tp'] == '?')
						$dat.=" (?) ";

					$aquisicao= strtolower(ret_aquisicao($row[forma_aquisicao]));
					if ($aquisicao == '')
						$aquisicao= 'procedência desconhecida';
					echo $aquisicao . ", " . $row['doador'];
					if (strlen($dat) > 3)
						echo ", " . $dat;
					echo "<br>";

					if ($row['texto_etiq'] <> '') {
						echo "<font style='color:#ABABAB;'>_______________________________________________</font><br><em>" . $row['texto_etiq'] . "</em>";
						echo "<br>";
					}
					echo "&nbsp;";

					if ($_REQUEST['marcar_todas'] == 0) {
						// verifica/monta variavel de sessao das obras marcadas para impressao //
						if ($_REQUEST['imprime'] == 'marcou') {
							$_SESSION['s_impressao']= $_SESSION['s_impressao'] . "," . $row['obra'];
							$_SESSION['s_imp_total']++;
						}

						$marcou= "";
						if (stristr($_SESSION['s_impressao'], ",".$row['obra'])) {
							$marcou= "checked";
							if ($_REQUEST['clicou_marcar'] && $_REQUEST['imprime']=='') {
								$marcou= "";
								$_SESSION['s_impressao']= str_replace(",".$row['obra'],"",$_SESSION['s_impressao']);
								$_SESSION['s_imp_total']--;
							}
						}
					}
				?>
            </td>
          </tr>
		<!-- Text Area Descricao -->
		<tr id="ta_descricao" style="display:none; font-weight:normal;" valign="top" class="texto_bold">
			<td valign="middle" align="right">&nbsp;<em>Descrição:</em></td>
			<td><textarea name='descri' id="descri" class="combo_cadastro rolagem" readonly style=" border:1px solid #ABABAB;" cols='65' rows='2'><? echo $row['desc_conteudo']; ?></textarea></td>
		</tr>
		<!-- Text Area Exposicoes -->
		<?
			$sql="SELECT b.* from obra_exposicao as a inner join exposicao as b on (a.exposicao=b.exposicao) 
				where a.obra=$row[obra] order by a.exposicao asc";
			$db2->query($sql);
			$exposicao= "";
			while ($exp=$db2->dados()) {
						$pais=$exp['pais'];
						$sqlPais="select nome from pais where pais=$pais";
						$db3->query($sqlPais);
						$dados=$db3->dados();
						$pais=$dados['nome'];
						$exposicao .= "- ".$exp['nome'].". ". $exp['instituicao'] . ", " .$exp['cidade'].$estado.", ". $pais.". ".$exp['periodo'] . ". " .$exp['premio']. "|||";
			}
		?>
		<tr id="ta_exposicao" style="display:none; font-weight:normal;" valign="top" class="texto_bold">
			<td valign="middle" align="right">&nbsp;<em>Exposições:</em></td>
			<td><textarea name='exposic' id="exposic" class="combo_cadastro rolagem" readonly style=" border:1px solid #ABABAB;" cols='65' rows='2'><? echo str_replace("|||","\n",$exposicao); ?></textarea></td>
		</tr>
		<!-- Text Area Bibliografia -->
		<?
			$sql="SELECT b.referencia,b.autoria,b.local,b.editora,b.observacao,b.ano from obra_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
				where a.obra=$row[obra] order by b.ano asc";
			$db2->query($sql);
			$bibliografia= "";
			while ($bib=$db2->dados()) {
				$ano_bib= $bib['ano'];
				if ($ano_bib == 0)
					$ano_bib= 's/d';

				$bibliografia .= "- ".$bib['autoria'].". ".$bib['referencia'] .". ".$bib['local'].", ".$bib['editora'].", ".$ano_bib.". ".$bib['observacao']. "|||";
			}
		?>
		<tr id="ta_bibliografia" style="display:none; font-weight:normal;" valign="top" class="texto_bold">
			<td valign="middle" align="right">&nbsp;<em>Bibliografia:</em></td>
			<td><textarea name='biblio' id="biblio" class="combo_cadastro rolagem" readonly style=" border:1px solid #ABABAB;" cols='65' rows='2'><? echo str_replace("|||","\n",$bibliografia); ?></textarea></td>

		</tr>
		<tr id="ta_seguro" style="display:none; font-weight:normal;" valign="top" class="texto_bold">
			<td valign="middle" align="right">&nbsp;<em>Valor Seguro:</em></td>
			<td><input type name='seguro' id="seguro" class="combo_cadastro" readonly style="font-style: border:1px solid #ABABAB;" value='<? echo $seguro; ?>'></td>
		</tr>
		<!---->
		<tr>
		<form name="frm_imprime" method="post">

        <tr bgcolor="#ddddd5">
          <td colspan="2" bgcolor="#96ADBE" class="texto_bold"><img src="file:///C|/Documents%20and%20Settings/Administrator/Desktop/imgs/transp.gif" width="100" height="1"></td>
        </tr>


		<? if (strtoupper($_SESSION[snome]) != 'VISITANTE') { ?>	
			<td colspan="2" nowrap class="texto" >&nbsp;Marcada para impressão:<input type="checkbox" name="imprime" value="marcou" <? echo $marcou; ?> onClick="document.frm_imprime.submit();"> 
			<a href="#" style="text-decoration: none;" onClick="document.getElementById('marcar_todas').value='1'; document.frm_imprime.submit();"><sub><img src="imgs/icons/ic_marca_todas.gif" border="0" title="Marcar todas"></sub></a>
			<a href="#" style="text-decoration: none;" onClick="document.getElementById('marcar_todas').value='2'; document.frm_imprime.submit();"><sub><img src="imgs/icons/ic_desmarca_todas.gif" border="0" title="Desmarcar todas"></sub></a>
			<a href="javascript:;" style="color:black; text-decoration: none;" onClick="abrepop2('lista_impressao.php');">(<em><? echo $_SESSION['s_imp_total']; ?></em>)</a>
			<a href="javascript:;" style="text-decoration: none;" onClick="abrepop3('pre_impressao_obras.php');"><sub><img src="imgs/icons/ic_salvar_impressao.gif" border="0" title="Gravar/imprimir os registros marcados"></sub></a>
			<a href="javascript:;" style="text-decoration: none;" onClick="abrepop3('pre_impressao_resumida.php');"><sub><img src="imgs/icons/ic_ficha_res.gif" border="0" title="Gravar/imprimir FICHA RESUMIDA (individual)"></sub></a>
			<a href="javascript:;" style="text-decoration: none;" onClick="abrepop3('pre_impressao_completa.php');"><sub><img src="imgs/icons/ic_ficha_completa.gif" border="0" title="Gravar/imprimir FICHA COMPLETA (individual)"></sub></a>
			<a href="javascript:;" style="text-decoration: none;" onClick="abre_pagina('<? echo $row[obra]; ?>','<? echo htmlentities(str_replace("'","`",$row[titulo]), ENT_QUOTES); ?>');"><sub><img src="imgs/icons/busca.gif" border="0" title="Abrir FICHA COMPLETA"></sub></a>
			<font style="color: #859CBE;">|</font>&nbsp;Modelo 1<input type="checkbox" name="modelo" id="modelo1" value="1" onClick="muda_modelo(1); this.focus();">
			2<input type="checkbox" name="modelo" id="modelo2" value="2" onClick="muda_modelo(2); this.focus();">
			3<input type="checkbox" name="modelo" id="modelo3" value="3" onClick="muda_modelo(3); this.focus();">
			4<input type="checkbox" name="modelo" id="modelo4" value="4" onClick="muda_modelo(4); this.focus();">
			5<input type="checkbox" name="modelo" id="modelo5" value="5" onClick="muda_modelo(5); this.focus();">

               <? } ?>

			<input type="hidden" name="page" value="<? echo $page + 1; ?>">
			<input type="hidden" name="clicou_marcar" value="1">
			<input type="hidden" name="marcar_todas" value="0">
			<input type="hidden" name="num_serie" value="<? echo trim($_REQUEST[num_serie]); ?>">
			<input type="hidden" name="num_edicao" value="<? echo trim($_REQUEST[num_edicao]); ?>">
			<input type="hidden" name="num_processo" value="<? echo trim($_REQUEST[num_processo]); ?>">
			<input type="hidden" name="inventario" value="<? echo trim($_REQUEST[inventario]); ?>">
			<input type="hidden" name="num_registro" value="<? echo trim($_REQUEST[num_registro]); ?>">
			<input type="hidden" name="lista_registro" value="<? echo trim($_REQUEST[lista_registro]); ?>">
			<input type="hidden" name="editor" value="<? echo trim($_REQUEST[editor]); ?>">
			<input type="hidden" name="impressor" value="<? echo trim($_REQUEST[impressor]); ?>">
			<input type="hidden" name="forma_aquisicao" value="<? echo trim($_REQUEST[forma_aquisicao]); ?>">
			<input type="hidden" name="deAno" value="<? echo trim($_REQUEST[deAno]); ?>">
			<input type="hidden" name="ateAno" value="<? echo trim($_REQUEST[ateAno]); ?>">
			<input type="hidden" name="deAnoParte" value="<? echo trim($_REQUEST[deAnoParte]); ?>">
			<input type="hidden" name="ateAnoParte" value="<? echo trim($_REQUEST[ateAnoParte]); ?>">
			<input type="hidden" name="descr_formal" value="<? echo trim($_REQUEST[descr_formal]); ?>">
			<input type="hidden" name="desc_conteudo" value="<? echo trim($_REQUEST[desc_conteudo]); ?>">
			<input type="hidden" name="obs" value="<? echo trim($_REQUEST[obs]); ?>">
			<input type="hidden" name="estado_conserv" value="<? echo trim($_REQUEST[estado_conserv]); ?>">
			<input type="hidden" name="localizada" value="<? echo trim($_REQUEST[localizada]); ?>">
			<input type="hidden" name="foto" value="<? echo trim($_REQUEST[foto]); ?>">
			<input type="hidden" name="pasp" value="<? echo trim($_REQUEST[pasp]); ?>">
			<input type="hidden" name="base" value="<? echo trim($_REQUEST[base]); ?>">
			<input type="hidden" name="moldura" value="<? echo trim($_REQUEST[moldura]); ?>">
			<input type="hidden" name="objeto" value="<? echo trim($_REQUEST[objeto]); ?>">
			<input type="hidden" name="material_tecnica" value="<? echo trim($_REQUEST[material_tecnica]); ?>">
			<input type="hidden" name="destaque" value="<? echo trim($_REQUEST[destaque]); ?>">
			<input type="hidden" name="escola" value="<? echo trim($_REQUEST[escola]); ?>">
			<input type="hidden" name="estilo" value="<? echo trim($_REQUEST[estilo]); ?>">
			<input type="hidden" name="movimento" value="<? echo trim($_REQUEST[movimento]); ?>">
			<input type="hidden" name="sub_tema" value="<? echo trim($_REQUEST[sub_tema]); ?>">
			<input type="hidden" name="idtemas" value="<? echo trim($_REQUEST[idtemas]); ?>">
			<input type="hidden" name="titulo" value="<? echo trim($_REQUEST[titulo]); ?>">
			<input type="hidden" name="autor" value="<? echo trim($_REQUEST[autor]); ?>">
			<input type="hidden" name="idcolecoes" value="<? echo trim($_REQUEST[idcolecoes]); ?>">
			<input type="hidden" name="colecao" value="<? echo trim($_REQUEST[colecao]); ?>">
			<input type="hidden" name="tema" value="<? echo trim($_REQUEST[tema]); ?>">
			<input type="hidden" name="ref_biblio" value="<? echo trim($_REQUEST[ref_biblio]); ?>">
			<input type="hidden" name="ref_autor" value="<? echo trim($_REQUEST[ref_autor]); ?>">
			<input type="hidden" name="expo_ini" value="<? echo trim($_REQUEST[expo_ini]); ?>">
			<input type="hidden" name="expo_fim" value="<? echo trim($_REQUEST[expo_fim]); ?>">
			<input type="hidden" name="expo_nome" value="<? echo trim($_REQUEST[expo_nome]); ?>">
			<input type="hidden" name="expo_ins" value="<? echo trim($_REQUEST[expo_ins]); ?>">
			<input type="hidden" name="expo_pais" value="<? echo trim($_REQUEST[expo_pais]); ?>">
			<input type="hidden" name="expo_estado" value="<? echo trim($_REQUEST[expo_estado]); ?>">
			<input type="hidden" name="expo_periodo" value="<? echo trim($_REQUEST[expo_periodo]); ?>">
			<input type="hidden" name="expo_premio" value="<? echo trim($_REQUEST[expo_premio]); ?>">
			</td>
		</form>
		</tr>

          <? } ?>
          <!--        <tr class="texto">
		<?
		  $pg=$_SERVER['REQUEST_URI'];
		  $base=basename($pg);
		  $parte=explode('?',$base);
		  $url=$parte[1].'&pagesize=999999';
		  ?> 
          <td colspan="2">
<div align="right">
</div></td>
          <td>&nbsp;</td>
          <td><? echo"<a  class='texto_bold' href=\"javascript:abre_pagina2('$url')\";>Imprimir lista</a>"?></td>
          <td>&nbsp;</td>
        </tr>		-->
          <tr bgcolor="#ddddd5" class="texto" align="center"> 
            <td colspan="2" height="22"> 
              <? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href='#' onClick='obtem_valor(\"\",".$first.",modelo)'><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href='#' onClick='obtem_valor(\"\",".$menos.",modelo)'><img src='imgs/icons/btn_anterior.gif'  border='0'  alt='Registro Anterior' ></a>";

$c="<a href='#' onClick='obtem_valor(\"\",".$mais.",modelo)'><img src='imgs/icons/btn_proximo.gif'  border='0'  alt='Próximo Registro' ></a>";

$d="<a href='#' onClick='obtem_valor(\"\",".$last.",modelo)'><img src='imgs/icons/btn_ultimo.gif'  border='0'  alt='Último Registro' ></a>";

$combo="";
 for($i=1;$i<=$numpages;$i++)
 {
  if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 } 
  $lista_combo="<select name=i onChange='obtem_valor(this,this.value,modelo)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }
//echo"$lista_combo";
$v_total= explode("|||",percente_obras($numlinhas));
$percentual= $v_total[0];
$totobras= $v_total[1];
$g= "<b>$numlinhas</b> obra(s) de $totobras &nbsp;(<b>$percentual %</b> do acervo) - $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a.$b.$c.$d."";
echo"&nbsp";
echo"<font color='#000000'>$g</font>"; 		  
?>			</td>
          </tr>
        </table>
<!--    </form>-->
	</td>
  </tr>
<? //} ?>
<tr><td colspan="2" align="center" nowrap class="texto" style="border-top: 1px solid #96ADBE;">
		      Digite o N&uacute;mero de Registro:&nbsp;<input type=text name=NumeroReg size="10" class="combo_texto">
      <?
          $comando="<a href='#' onClick='obtem_valor(\"\",localiza(NumeroReg.value),modelo)'>";
          echo $comando;
      ?>
            <img src='imgs/icons/lupa.gif'  border='0'  alt='Localiza obra pelo Número de Registro' ></a>
</td></tr>
</table>

<script language="JavaScript">

document.onkeyup=handleKeyboardAction;

function handleKeyboardAction(e){

   var code;

  // Obtém o evento. No caso do Firefox, este
  // evento é passado como argumento, e no caso do IE,
  // deve ser obtido através do objeto window.
   if (!e) var e = window.event; 

   // Detecta o target da tecla
   var targ;
   if (e.target) targ = e.target;
   else if (e.srcElement) targ = e.srcElement;

   // Este código previne um erro do navegador Safari:
  // Se o usuari clica num DIV com texto, os outros browsers
  // retornam o DIV como sendo o target. Safari retorna  o nó contendo
  // o texto (nodeType 3). Nesse caso, o target que nos interessa é o pai.
   if (targ.nodeType == 3) // defeat Safari bug
      targ = targ.parentNode;

  // Obtém o nome da TAG HTML do target do evento
   tag = targ.tagName.toUpperCase();

  // Verifica se o evento não esta sendo acionado em nenhum
  // campo como campo de texto e combobox.
  // Esta verificação é importante, pois o handler pode bloquear
  // o funcionamento adqueado desses campos (por exemplo, em vez de escrever
  // a letra no campo, executa uma função).
   if (tag == "INPUT")
      return;

   if (tag == "SELECT")
		return;

   // Detecta o codigo da tecla
   if (e.keyCode) code = e.keyCode;
   else if (e.which) code = e.which;

   var character = String.fromCharCode(code);

       //Home
	if(code == 36) {
          obtem_valor("/",'<? echo $first; ?>',modelo);
          return;
	} 

       //End
	if(code == 35) {
          obtem_valor("/",'<? echo $last; ?>',modelo);
          return;
	} 


       //PgDw
	if(code == 34) {
          obtem_valor("/",'<? echo $mais; ?>',modelo);
          return;
	} 

	//PgUp
	if(code == 33) {
          obtem_valor("/",'<? echo $menos; ?>',modelo);
          return;
	} 

   return;
}

</script>
</body>
</html>
