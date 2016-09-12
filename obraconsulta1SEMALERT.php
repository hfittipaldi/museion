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


function submitenter(myfield,e,first,last,mais,menos)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;
//alert(keycode);

     //Home
	if(keycode == 36) {
          obtem_valor("/",first,document.forms.frm_imprime.modelo);
          return;
	} 

       //End
	if(keycode == 35) {
          obtem_valor("/",last,document.forms.frm_imprime.modelo);
          return;
	} 


       //PgDw
	if(keycode == 34) {
          obtem_valor("/",mais,document.forms.frm_imprime.modelo);
          return;
	} 

	//PgUp
	if(keycode == 33) {
          obtem_valor("/",menos,document.forms.frm_imprime.modelo);
          return;
	} 


        if (keycode == 13){
         obtem_valor("",localiza(document.forms.pesquisa.NumeroReg),document.forms.frm_imprime.modelo);
         return false;
        }

   return true;
}
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
function abrepop3D(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-270)+',top='+((window.screen.height/2)-180)+',width=550,height=400, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4)
    {
        win.window.focus();
    }
 return true;
}



function abrepopetiq(janela)
{
  if (document.getElementById("modelo1").checked==true) {
	valor=1;
  }
  if (document.getElementById("modelo2").checked==true) {
	valor=2;
  }
  if (document.getElementById("modelo3").checked==true) {
	valor=3;
  }
  if (document.getElementById("modelo4").checked==true) {
	valor=4;
  }
  if (document.getElementById("modelo5").checked==true) {
	valor=5;
  }

  janela=janela+'&modelo='+valor;
  win=window.open(janela,'lista','left='+((window.screen.width/2)-170)+',top='+((window.screen.height/2)-170)+',width=600,height=500, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4)
   {      win.window.focus();
    }
 return true;
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
&local=<? echo trim($_REQUEST[local]);?>
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
&dim_obra_altura_ini=<? echo (trim($_REQUEST[dim_obra_altura_ini]));?>
&dim_obra_largura_ini=<? echo (trim($_REQUEST[dim_obra_largura_ini]));?>
&dim_obra_diametro_ini=<? echo trim($_REQUEST[dim_obra_diametro_ini]);?>
&dim_obra_profundidade_ini=<? echo (trim($_REQUEST[dim_obra_profundidade_ini]));?>
&dim_obra_peso_ini=<? echo (trim($_REQUEST[dim_obra_peso_ini]));?>
&dim_obra_altura_fim=<? echo(trim($_REQUEST[dim_obra_altura_fim]));?>
&dim_obra_largura_fim=<? echo (trim($_REQUEST[dim_obra_largura_fim]));?>
&dim_obra_diametro_fim=<? echo (trim($_REQUEST[dim_obra_diametro_fim]));?>
&dim_obra_profundidade_fim=<? echo (trim($_REQUEST[dim_obra_profundidade_fim]));?>
&dim_obra_peso_fim=<? echo (trim($_REQUEST[dim_obra_peso_fim]));?>
&aimp_obra_altura_ini=<? echo (trim($_REQUEST[aimp_obra_altura_ini]));?>
&aimp_obra_largura_ini=<? echo (trim($_REQUEST[aimp_obra_largura_ini]));?>
&aimp_obra_diametro_ini=<? echo(trim($_REQUEST[aimp_obra_diametro_ini]));?>
&aimp_obra_altura_fim=<? echo (trim($_REQUEST[aimp_obra_altura_fim]));?>
&aimp_obra_largura_fim=<? echo(trim($_REQUEST[aimp_obra_largura_fim]));?>
&aimp_obra_diametro_fim=<? echo (trim($_REQUEST[aimp_obra_diametro_fim]));?>
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

function compara_imagem(img1,img2)
{
  	win=window.open('pop_compara_imagem.php?img1='+img1+'&img2='+img2,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-240)+',height=480,width=780,scrollbars=yes,status=yes,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}

function abre_pagina(idobra,title)
{

  	win=window.open('consulta_obra.php?op=view&nosave=1&titulo='+title+'&obra='+idobra,'PAG','left='+((window.screen.width/2)-512)+',top='+((window.screen.height/2)-240)+',height=480,width=930,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);

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

<script>
function trim_value(&$value) 
{ 
    $value = trim($value); 
}
</script>
</head>
<body onLoad="if (totlinhas > 0) { muda_modelo(<? echo $_REQUEST['modelo']; ?>); }">
<table width="540"  border="1" align="left" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2">
  <tr>
    <th width="486" colspan="1" scope="col" class="tit_interno">
	    <?

		echo "<form name='form' method='post' action='obraconsulta.php'>";
		unset($_SESSION['paginas']);
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
$db5=new conexao();
$db5->conecta();
$dbusu=new conexao();
$dbusu->conecta();

$rotacao=$_REQUEST[rotacao3d];
$dirrotacao= diretorio_fisico_rotacao();
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

$dimobraalturade=$_REQUEST['dim_obra_altura'];
$dimobralargurade=$_REQUEST['dim_obra_largura'];
$dimobradiametrode=$_REQUEST['dim_obra_diametro'];
$dimobraprofundidade=$_REQUEST['dim_obra_profundidade'];
$dimobrapesode=$_REQUEST['dim_obra_peso'];
$dimobraalturaate=$_REQUEST['dim_obra_altura'];
$dimobralarguraate=$_REQUEST['dim_obra_largura'];
$dimobradiametroate=$_REQUEST['dim_obra_diametro'];
$dimobraprofundidadeate=$_REQUEST['dim_obra_profundidade'];
$dimobrapesoate=$_REQUEST['dim_obra_peso'];
$aimpobraalturade=$_REQUEST['aimp_obra_altura'];
$aimpobralargurade=$_REQUEST['aimp_obra_largura'];
$aimpobradiametrode=$_REQUEST['aimp_obra_diametro'];
$aimpobraalturaate=$_REQUEST['aimp_obra_altura'];
$aimpobralarguraate=$_REQUEST['aimp_obra_largura'];
$aimpobradiametroate=$_REQUEST['aimp_obra_diametro'];



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
function ret_rotacao_obra($obrid)
{
 global $db;
 $sql="SELECT rotacao3d from obra as a where a.obra='$obrid'";
 $db->query($sql);
 $res=$db->dados();
 return $res[0];
}
function ret_autor($valor)
{
 global $db;
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
$txtpesquisa_rel=$txtpesquisa_rel."- Coleções:".str_replace(",",", ",trim($_REQUEST['colecao']));
}

if($_REQUEST['autor']<> '')
{
   $condicao=$condicao." AND B.autor=$_REQUEST[autor]";
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Autor: <font style='color:brown;'>".ret_autor($_REQUEST['autor'])."</font>";
   $joinautor=1;
   $txtpesquisa_rel=$txtpesquisa_rel."- Autor:".ret_autor($_REQUEST['autor']);

 }

if($_REQUEST['atribuida']<> '')
{
   if ($_REQUEST['autor']<> '') {
	$condicao=$condicao." AND B.autor=$_REQUEST[autor] AND B.atribuido='$_REQUEST[atribuida]'";
   } else {
	$condicao=$condicao." AND B.atribuido='$_REQUEST[atribuida]'";
   }
   $txtpesquisa=$txtpesquisa. "<br>&nbsp;- Atribuido: <font style='color:#ffffff;'>".ret_booleano($_REQUEST['atribuida'])."</font>";
   $txtpesquisa_rel=$txtpesquisa_rel."- Atribuido:".ret_booleano($_REQUEST['atribuida']);

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
               $txtpesquisa_rel=$txtpesquisa_rel. "- Titulo:".trim($_REQUEST['titulo']);
}

if (trim($_REQUEST['idtemas']) <> '') {
    $condicao=$condicao." AND T.tema in ($_REQUEST[idtemas])";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Temas: <font style='color:brown;'>".str_replace(",",", ",trim($_REQUEST['tema']))."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Temas:".str_replace(",",", ",trim($_REQUEST['tema']));

    $jointema=1;
}

if (trim($_REQUEST['sub_tema']) <> '') {
	$condicao=$condicao. " AND sub_tema like '%".trim($_REQUEST['sub_tema'])."%' ";
	$txtpesquisa=$txtpesquisa. "<br>&nbsp;- Sub-Temas: <font style='color:brown;'>".trim($_REQUEST['sub_tema'])."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Sub_Temas:".trim($_REQUEST['sub_tema']);

}
if (trim($_REQUEST['movimento']) <> '') {
	$condicao=$condicao. " AND movimento like '%".trim($_REQUEST['movimento'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Movimento: <font style='color:brown;'>".trim($_REQUEST['movimento'])."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Movimento:".trim($_REQUEST['movimento']);

}
if (trim($_REQUEST['estilo']) <> '') {
	$condicao=$condicao." AND estilo like '%".trim($_REQUEST['estilo'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Estilo: <font style='color:brown;'>".trim($_REQUEST['estilo'])."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Estilo:".trim($_REQUEST['estilo']);

}
if (trim($_REQUEST['escola']) <> '') {
	$condicao=$condicao." AND escola like '%".trim($_REQUEST['escola'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Escola: <font style='color:brown;'>".trim($_REQUEST['escola'])."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Escola:".trim($_REQUEST['escola']);

}
if ($_REQUEST['destaque'] <> '') {
	$condicao=$condicao." AND eh_destaque_acervo='$_REQUEST[destaque]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Destaque do Acervo: <font style='color:brown;'>".ret_booleano($_REQUEST['destaque'])."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Destaque do Acervo: ".ret_booleano($_REQUEST['destaque']);

}

//Aba Características
if (trim($_REQUEST['material_tecnica']) <> '') {
	$condicao=$condicao." AND ( P.material_tecnica
 like '%".trim($_REQUEST['material_tecnica'])."%' ";
$condicao=$condicao." OR O.material_tecnica
 like '%".trim($_REQUEST['material_tecnica'])."%') ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Material/técnica: <font style='color:brown;'>".trim($_REQUEST['material_tecnica'])."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Material/técnica: ".trim($_REQUEST['material_tecnica']);

    $joinparte=1;
}
if (trim($_REQUEST['objeto']) <> '') {
	$condicao=$condicao." AND objeto like '%".trim($_REQUEST['objeto'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Objeto: <font style='color:brown;'>".trim($_REQUEST['objeto'])."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Objeto: ".trim($_REQUEST['objeto']);

}
if ($_REQUEST['moldura'] <> '') {
     $condicao=$condicao." AND dim_mold_possui='$_REQUEST[moldura]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Moldura: <font style='color:brown;'>".ret_booleano($_REQUEST['moldura'])."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Moldura: ".ret_booleano($_REQUEST['moldura']);

    $joinparte=1; 
}
if ($_REQUEST['base'] <> '') {
	$condicao=$condicao." AND dim_base_possui='$_REQUEST[base]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Base: <font style='color:brown;'>".ret_booleano($_REQUEST['base'])."</font>";
        $txtpesquisa_rel=$txtpesquisa_rel."- Base: ".ret_booleano($_REQUEST['base']);

    $joinparte=1;
}
if ($_REQUEST['pasp'] <> '') {
	$condicao=$condicao." AND dim_pasp_possui='$_REQUEST[pasp]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Passe-partout: <font style='color:brown;'>".ret_booleano($_REQUEST['pasp'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Passe-partout: ".ret_booleano($_REQUEST['pasp']);

    $joinparte=1; 
}

if ($_REQUEST['foto'] =='S') {
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Fotografia: <font style='color:brown;'>".ret_booleano($_REQUEST['foto'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Fotografia: ".ret_booleano($_REQUEST['foto']);

    $joinfoto=1;
}
elseif ($_REQUEST['foto'] =='N') {
	$condicao=$condicao." AND O.obra NOT IN (select distinct obra from fotografia_obra)";
//	$condicao=$condicao." AND F.fotografia IS NULL";	// pro caso do LEFT JOIN
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Fotografia: <font style='color:brown;'>".ret_booleano($_REQUEST['foto'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Fotografia: ".ret_booleano($_REQUEST['foto']);


//    $joinfoto=2;  // pro caso do LEFT JOIN
}
if ($_REQUEST['temfoto'] <> '') {
     $condicao=$condicao." AND tem_foto='$_REQUEST[temfoto]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Foto: <font style='color:#ffffff;'>".ret_booleano($_REQUEST['temfoto'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Foto: ".ret_booleano($_REQUEST['temfoto']);

    $joinparte=1; 
}
if ($_REQUEST['temnegativo'] <> '') {
     $condicao=$condicao." AND tem_negativo='$_REQUEST[temnegativo]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Negativo: <font style='color:#ffffff;'>".ret_booleano($_REQUEST['temnegativo'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Negativo: ".ret_booleano($_REQUEST['temnegativo']);

    $joinparte=1; 
}
if ($_REQUEST['temdiapositivo'] <> '') {
     $condicao=$condicao." AND tem_diapositivo='$_REQUEST[temdiapositivo]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Diapositivo: <font style='color:#ffffff;'>".ret_booleano($_REQUEST['temdiapositivo'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Diapositivo: ".ret_booleano($_REQUEST['temdiapositivo']);

    $joinparte=1; 
}
if ($_REQUEST['temrestauro'] <> '') {
     $condicao=$condicao." AND tem_restauro='$_REQUEST[temrestauro]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Restauro: <font style='color:#ffffff;'>".ret_booleano($_REQUEST['temrestauro'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Restauro: ".ret_booleano($_REQUEST['temrestauro']);

    $joinparte=1; 
}
if (trim($_REQUEST['periodo']) <> '') {
	$condicao=$condicao." AND periodo like '%".trim($_REQUEST['periodo'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Per&iacute;odo: <font style='color:#ffffff;'>".trim($_REQUEST['periodo'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Período: ".trim($_REQUEST['periodo']);

}
if ($_REQUEST['estado_conserv'] <> '') {
	$condicao=$condicao." AND estado_conserv=$_REQUEST[estado_conserv]";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Estado de conservação: <font style='color:brown;'>".ret_estado($_REQUEST['estado_conserv'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Estado de conservação: ".ret_estado($_REQUEST['estado_conserv']);

    $joinparte=1;   
}
if ($_REQUEST['local'] <> '') {
	$condicao=$condicao." AND local like '%".trim($_REQUEST['local'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Local de produção: <font style='color:brown;'>".trim($_REQUEST['local'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Local de produção: ".trim($_REQUEST['local']);

    $joinparte=1;
}
if ($_REQUEST['localizada'] <> '') { //identificado=localizada
	$condicao=$condicao." AND localizada='$_REQUEST[localizada]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Identificado: <font style='color:brown;'>".ret_booleano($_REQUEST['localizada'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Identificado: ".ret_booleano($_REQUEST['localizada']);

    $joinparte=1;
}
//Aba Textos
if ($_REQUEST['obs'] <> '') {
	$condicao=$condicao." AND O.obs like '%".trim($_REQUEST['obs'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Observações: <font style='color:brown;'>".trim($_REQUEST['obs'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Observações: ".trim($_REQUEST['obs']);



}
if ($_REQUEST['desc_conteudo'] <> '') {
	$condicao=$condicao." AND desc_conteudo like '%".trim($_REQUEST['desc_conteudo'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Descrição de conteúdo: <font style='color:brown;'>".trim($_REQUEST['desc_conteudo'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Descrição de conteúdo: ".trim($_REQUEST['desc_conteudo']);

}
if (trim($_REQUEST['ref_biblio']) <> '') {
	$condicao=$condicao." AND (R.referencia like '%".trim($_REQUEST['ref_biblio'])."%' or R.txt_legado like '%".trim($_REQUEST['ref_biblio'])."%') ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Referência em bibliografia: <font style='color:brown;'>".trim($_REQUEST['ref_biblio'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Referência em bibliografia: ".trim($_REQUEST['ref_biblio']);

    $joinbibliografia=1;
}
if (trim($_REQUEST['ref_autor']) <> '') {
	$condicao=$condicao." AND (R.autoria like '%".trim($_REQUEST['ref_autor'])."%') ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Autoria em bibliografia: <font style='color:brown;'>".trim($_REQUEST['ref_autor'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Autoria em bibliografia: ".trim($_REQUEST['ref_autor']);

    $joinbibliografia=1;
}
if (trim($_REQUEST['outras_inscr']) <> '') {
	$condicao=$condicao." AND (outras_inscricoes like '%".trim($_REQUEST['outras_inscr'])."%') ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Outras Inscri&ccedil;&otilde;es: <font style='color:#ffffff;'>".trim($_REQUEST['outras_inscr'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Outras Inscri&ccedil;&otilde;es: ".trim($_REQUEST['outras_inscr']);

    $joinparte=1;
}
if ($_REQUEST['descr_formal'] <> '') {
	$condicao=$condicao." AND descr_formal like '%".trim($_REQUEST['descr_formal'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Descrição formal: <font style='color:brown;'>".trim($_REQUEST['descr_formal'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Descrição formal: ".trim($_REQUEST['descr_formal']);

    $joinparte=1; 
} // continua no final da aba procedencia
// Aba Procedencia
if ($_REQUEST['forma_aquisicao'] <> '') {
	$condicao=$condicao." AND forma_aquisicao='$_REQUEST[forma_aquisicao]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Forma de aquisição: <font style='color:brown;'>".ret_forma($_REQUEST['forma_aquisicao'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Forma de aquisição: ".ret_forma($_REQUEST['forma_aquisicao']);

}
if ($_REQUEST['local_fixo'] <> '') {
	$condicao=$condicao." AND local_fixo='$_REQUEST[local_fixo]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Localiza&ccedil;&atilde;o Fixa: <font style='color:#ffffff;'>".ret_local($_REQUEST['local_fixo'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Localiza&ccedil;&atilde;o Fixa: ".ret_local($_REQUEST['local_fixo']);

}
if ($_REQUEST['impressor'] <> '') {
	$condicao=$condicao." AND impressor like '%".trim($_REQUEST['impressor'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Impressor: <font style='color:brown;'>".trim($_REQUEST['impressor'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Impressor: ".trim($_REQUEST['impressor']);

}
if ($_REQUEST['editor'] <> '') {
	$condicao=$condicao." AND editor like '%".trim($_REQUEST['editor'])."%' ";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Editor: <font style='color:brown;'>".trim($_REQUEST['editor'])."</font>";
}
if ($_REQUEST['num_registro'] <> '') {
	$condicao=$condicao." AND (num_registro like '$_REQUEST[num_registro] %') or (num_registro='$_REQUEST[num_registro]')";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Nº de registro: <font style='color:brown;'>".trim($_REQUEST['num_registro'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Nº de registro: ".trim($_REQUEST['num_registro']);

}
if ($_REQUEST['lista_registro'] <> '') {
        $_REQUEST[lista_registro]=str_Replace(", ",",",$_REQUEST[lista_registro]);
        $vetor_registro=explode(",",trim($_REQUEST[lista_registro]));
        $lista_registro="'".implode("','",$vetor_registro)."'";
	$condicao=$condicao." AND num_registro in ($lista_registro)";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Lista de Registros: <font style='color:brown;'>".trim($_REQUEST['lista_registro'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Lista de Registros: ".trim($_REQUEST['lista_registro']);

}

if ($_REQUEST['inventario'] <> '') {
	$condicao=$condicao." AND inventario='$_REQUEST[inventario]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Nº do inventario: <font style='color:brown;'>".trim($_REQUEST['inventario'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Nº do inventario: ".trim($_REQUEST['inventario']);

}
if ($_REQUEST['ctrlinv'] <> '') {
	$condicao=$condicao." AND controle_inv='$_REQUEST[ctrlinv]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Controle Inventário: <font style='color:brown;'>".trim($_REQUEST['ctrlinv'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Controle Inventário: ".trim($_REQUEST['ctrlinv']);

}
if ($_REQUEST['num_processo'] <> '') {
	$condicao=$condicao." AND num_processo='$_REQUEST[num_processo]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Nº do processo: <font style='color:brown;'>".trim($_REQUEST['num_processo'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Nº do processo: ".trim($_REQUEST['num_processo']);

}
if ($_REQUEST['num_edicao'] <> '') {
	$condicao=$condicao." AND num_edicao ='$_REQUEST[num_edicao]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Nº de edição: <font style='color:brown;'>".trim($_REQUEST['num_edicao'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Nº de edição: ".trim($_REQUEST['num_edicao']);

} 
if ($_REQUEST['num_serie'] <> '') {
	$condicao=$condicao." AND num_serie='$_REQUEST[num_serie]'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Nº de série: <font style='color:brown;'>".trim($_REQUEST['num_serie'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Nº de série: ".trim($_REQUEST['num_serie']);

}
if ($_REQUEST['exprop'] <> '') {
	$condicao=$condicao." AND ex_proprietarios like '%$_REQUEST[exprop]%'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Ex Proprietários: <font style='color:brown;'>".trim($_REQUEST['exprop'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Ex Proprietários: ".trim($_REQUEST['exprop']);

}
if ($_REQUEST['doador'] <> '') {
	$condicao=$condicao." AND forma_aquisicao='D' AND doador like '%$_REQUEST[doador]%'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Doador: <font style='color:#ffffff;'>".trim($_REQUEST['doador'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Doador: ".trim($_REQUEST['doador']);

}
// Aba EXPOSICAO
if ($_REQUEST['expo_nome'] <> '') {
	$condicao=$condicao." AND E.nome like '%$_REQUEST[expo_nome]%'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Nome da exposição: <font style='color:brown;'>".trim($_REQUEST['expo_nome'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Nome da exposição: ".trim($_REQUEST['expo_nome']);

	$joinexposicao= 1;
}
if ($_REQUEST['expo_ins'] <> '') {
	$condicao=$condicao." AND E.instituicao like '%$_REQUEST[expo_ins]%'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Nome da instituição: <font style='color:brown;'>".trim($_REQUEST['expo_ins'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Nome da instituição: ".trim($_REQUEST['expo_ins']);
	$joinexposicao= 1;
}
if ($_REQUEST['expo_pais'] <> '') {
	$condicao=$condicao." AND E.pais = '$_REQUEST[expo_pais]'";
	$sql="SELECT nome from pais where pais = '$_REQUEST[expo_pais]'";
	$db->query($sql);
	$pais_nome= $db->dados();
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- País da exposição: <font style='color:brown;'>".$pais_nome['nome']."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- País da exposição: ".$pais_nome['nome'];
	$joinexposicao= 1;
}
if ($_REQUEST['expo_estado'] <> '') {
	$condicao=$condicao." AND E.estado = '$_REQUEST[expo_estado]'";
	$sql="SELECT nome from estado where estado = '$_REQUEST[expo_estado]'";
	$db->query($sql);
	$estado_nome= $db->dados();
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Estado da exposição: <font style='color:brown;'>".$estado_nome['nome']."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Estado da exposição: ".$estado_nome['nome'];
	$joinexposicao= 1;
}
if ($_REQUEST['expo_periodo'] <> '') {
	$condicao=$condicao." AND E.periodo like '%$_REQUEST[expo_periodo]%'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Período da exposição: <font style='color:brown;'>".trim($_REQUEST['expo_periodo'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Período da exposição: ".trim($_REQUEST['expo_periodo']);
	$joinexposicao= 1;
}
if ($_REQUEST['expo_premio'] <> '') {
	$condicao=$condicao." AND D.premio like '%$_REQUEST[expo_premio]%'";
	$txtpesquisa=$txtpesquisa."<br>&nbsp;- Prêmio da exposição: <font style='color:brown;'>".trim($_REQUEST['expo_premio'])."</font>";
	$txtpesquisa_rel=$txtpesquisa_rel."- Prêmio da exposição: ".trim($_REQUEST['expo_premio']);
	$joinexposicao= 1;
}

// Continuacao da Aba Textos
if ($deAno<>'' || $ateAno<>'') {
	if ($deAno<>'' && $ateAno=='') {
		$de= $deAno;
		$ate= date("Y");
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Aquisição entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAno)."</font> e <font style='color:brown;'>".date("Y")."</fotn>";
	        $txtpesquisa_rel=$txtpesquisa_rel."- Aquisição entre os anos de: ".exibeDataNegativa($deAno)." e ".date("Y");


	}
	elseif ($deAno=='' && $ateAno<>'') {
		$de= "-9999";
		$ate= $ateAno;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Aquisição até o ano de <font style='color:brown;'>".exibeDataNegativa($ateAno)."</font>";
	        $txtpesquisa_rel=$txtpesquisa_rel."- Aquisição até o ano de: ".exibeDataNegativa($ateAno);


	}
	if ($deAno<>'' && $ateAno<>'') {
		$de= $deAno;
		$ate= $ateAno;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Aquisição entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAno)."</font> e <font style='color:brown;'>".exibeDataNegativa($ateAno)."</fotn>";
	        $txtpesquisa_rel=$txtpesquisa_rel."- Aquisição até o ano de: ".exibeDataNegativa($deAno)." e ".exibeDataNegativa($ateAno);

	}

	$condicao= $condicao." AND (((dt_aquisicao_ano1 >= $de and dt_aquisicao_ano1 <= $ate) OR (dt_aquisicao_ano2 >= $de and dt_aquisicao_ano2 <= $ate and dt_aquisicao_ano2 <> 0) OR (dt_aquisicao_ano1 <= $de and dt_aquisicao_ano2 >= $ate and dt_aquisicao_ano2 <> 0)) AND dt_aquisicao_ano1 <> 0) ";
}
///
if ($deAnoParte<>'' || $ateAnoParte<>'') {
	if ($deAnoParte<>'' && $ateAnoParte=='') {
		$deParte= $deAnoParte;
		$ateParte= date("Y");
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Data da obra entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAnoParte)."</font> e <font style='color:brown;'>".date("Y")."</fotn>";
	        $txtpesquisa_rel=$txtpesquisa_rel."- Data da obra entre os anos de: ".exibeDataNegativa($deAnoParte);

	}
	elseif ($deAnoParte=='' && $ateAnoParte<>'') {
		$deParte= "-9999";
		$ateParte= $ateAnoParte;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Data da obra até o ano de <font style='color:brown;'>".exibeDataNegativa($ateAnoParte)."</font>";
	        $txtpesquisa_rel=$txtpesquisa_rel."- Data da obra até o ano de: ".exibeDataNegativa($ateAnoParte);

	}
	if ($deAnoParte<>'' && $ateAnoParte<>'') {
		$deParte= $deAnoParte;
		$ateParte= $ateAnoParte;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Data da obra entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAnoParte)."</font> e <font style='color:brown;'>".exibeDataNegativa($ateAnoParte)."</fotn>";
	        $txtpesquisa_rel=$txtpesquisa_rel."- Data da obra entre os anos de: ".exibeDataNegativa($deAnoParte);

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
	        $txtpesquisa_rel=$txtpesquisa_rel."- Exposição entre as datas de:".$deExpo." e ".date("d/m/Y");
	}
	elseif ($deExpo=='' && $ateExpo<>'') {
		$de= "0000-00-00";
		$ate= $ateExpo;
		 $ate= explode("/", $ate);
		 $ano= $ate[2]; $mes= $ate[1]; $dia= $ate[0];
		 $ate= $ano."-".$mes."-".$dia;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Exposição até a data de <font style='color:brown;'>".$ateExpo."</font>";
	        $txtpesquisa_rel=$txtpesquisa_rel."- Exposição até a data de:".$ateExpo;

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
	        $txtpesquisa_rel=$txtpesquisa_rel."- Exposição entre as datas de: ".$deExpo." e ".$ateExpo;


	}

	$condicao= $condicao." AND (((E.dt_inicial >= '$de' and E.dt_inicial <= '$ate') OR (E.dt_final >= '$de' and E.dt_final <= '$ate' and E.dt_final <> 0) OR (E.dt_inicial <= '$de' and E.dt_final >= '$ate' and E.dt_final <> 0)) AND E.dt_inicial <> 0) ";
    $joinexposicao=1;
}

///// FORMATA VALORES COM PONTO EX PBL
$_REQUEST['dim_obra_altura_ini']=formata_valor_1($_REQUEST['dim_obra_altura_ini']);
$_REQUEST['dim_obra_largura_ini']=formata_valor_1($_REQUEST['dim_obra_largura_ini']);
$_REQUEST['dim_obra_diametro_ini']=formata_valor_3($_REQUEST['dim_obra_diametro_ini']);
$_REQUEST['dim_obra_profundidade_ini']=formata_valor_3($_REQUEST['dim_obra_profundidade_ini']);
$_REQUEST['dim_obra_peso_ini']=formata_valor_1($_REQUEST['dim_obra_peso_ini']);
$_REQUEST['aimp_obra_altura_ini']=formata_valor_1($_REQUEST['aimp_obra_altura_ini']);
$_REQUEST['aimp_obra_largura_ini']=formata_valor_1($_REQUEST['aimp_obra_largura_ini']);
$_REQUEST['aimp_obra_diametro_ini']=formata_valor_1($_REQUEST['aimp_obra_diametro_ini']);

$_REQUEST['dim_obra_altura_fim']=formata_valor_1($_REQUEST['dim_obra_altura_fim']);
$_REQUEST['dim_obra_largura_fim']=formata_valor_1($_REQUEST['dim_obra_largura_fim']);
$_REQUEST['dim_obra_diametro_fim']=formata_valor_1($_REQUEST['dim_obra_diametro_fim']);
$_REQUEST['dim_obra_profundidade_fim']=formata_valor_1($_REQUEST['dim_obra_profundidade_fim']);
$_REQUEST['dim_obra_peso_fim']=formata_valor_1($_REQUEST['dim_obra_peso_fim']);
$_REQUEST['aimp_obra_altura_fim']=formata_valor_1($_REQUEST['aimp_obra_altura_fim']);
$_REQUEST['aimp_obra_largura_fim']=formata_valor_1($_REQUEST['aimp_obra_largura_fim']);
$_REQUEST['aimp_obra_diametro_fim']=formata_valor_1($_REQUEST['aimp_obra_diametro_fim']);


if (($_REQUEST['dim_obra_altura_ini'] <> '')&  ($_REQUEST['dim_obra_altura_fim'] =='') ) { $_REQUEST['dim_obra_altura_fim']= $_REQUEST['dim_obra_altura_ini'];}
if (($_REQUEST['dim_obra_altura_ini'] == '') & ($_REQUEST['dim_obra_altura_fim'] <> '') )  { $_REQUEST['dim_obra_altura_ini']=$_REQUEST['dim_obra_altura_fim'];}

if (($_REQUEST['dim_obra_largura_ini'] <> '') & ($_REQUEST['dim_obra_largura_fim'] == '')) { $_REQUEST['dim_obra_largura_fim']=$_REQUEST['dim_obra_largura_ini'];}
if (($_REQUEST['dim_obra_largura_ini'] == '') & ($_REQUEST['dim_obra_largura_fim'] <> '')) { $_REQUEST['dim_obra_largura_ini']=$_REQUEST['dim_obra_largura_fim'];}

if (($_REQUEST['dim_obra_diametro_ini'] <> '') & ($_REQUEST['dim_obra_diametro_fim'] == '')) { $_REQUEST['dim_obra_diametro_fim']=$_REQUEST['dim_obra_diametro_ini'];}
if (($_REQUEST['dim_obra_diamentro_ini'] = '') & ($_REQUEST['dim_obra_diametro_fim'] <> '')) {$_REQUEST['dim_obra_diametro_ini']=$_REQUEST['dim_obra_diametro_fim'];}

if (($_REQUEST['dim_obra_profundidade_ini'] <> '') & ($_REQUEST['dim_obra_profundidade_fim'] == '')) {$_REQUEST['dim_obra_profundidade_fim']=$_REQUEST['dim_obra_profundidade_ini'];}
if (($_REQUEST['dim_obra_profundidade_ini'] == '') & ($_REQUEST['dim_obra_profundidade_fim'] <> '')) {$_REQUEST['dim_obra_profundidade_ini']=$_REQUEST['dim_obra_profundidade_fim'];}

if (($_REQUEST['dim_obra_peso_ini'] <> '') & ($_REQUEST['dim_obra_peso_fim'] == '')) {$_REQUEST['dim_obra_peso_fim']=$_REQUEST['dim_obra_peso_ini'];}
if (($_REQUEST['dim_obra_peso_ini'] == '') & ($_REQUEST['dim_obra_peso_fim'] <> '')) {$_REQUEST['dim_obra_peso_ini']=$_REQUEST['dim_obra_peso_fim'];}

if (($_REQUEST['aimp_obra_altura_ini'] <> '') & ($_REQUEST['aimp_obra_altura_fim'] == '')) {$_REQUEST['aimp_obra_altura_fim']=$_REQUEST['aimp_obra_altura_ini'];}
if (($_REQUEST['aimp_obra_altura_ini'] == '') & ($_REQUEST['aimp_obra_altura_fim'] <> '')) {$_REQUEST['aimp_obra_altura_ini']=$_REQUEST['aimp_obra_altura_fim'];}

if (($_REQUEST['aimp_obra_largura_ini'] <> '') & ($_REQUEST['aimp_obra_largura_fim'] == '')) {$_REQUEST['aimp_obra_largura_fim']=$_REQUEST['aimp_obra_largura_ini'];}
if (($_REQUEST['aimp_obra_largura_ini'] == '') & ($_REQUEST['aimp_obra_largura_fim'] <> '')) {$_REQUEST['aimp_obra_largura_ini']=$_REQUEST['aimp_obra_largura_fim'];}

if (($_REQUEST['aimp_obra_diametro_ini'] <> '') & ($_REQUEST['aimp_obra_diametro_fim'] == '')) {$_REQUEST['aimp_obra_diametro_fim']=$_REQUEST['aimp_obra_diametro_ini'];}
if (($_REQUEST['aimp_obra_diametro_ini'] == '') & ($_REQUEST['aimp_obra_diametro_fim'] <> '')) {$_REQUEST['aimp_obra_diametro_ini']=$_REQUEST['aimp_obra_diametro_fim'];}

if ($_REQUEST['dim_obra_altura_ini']<>'')
{
   $condicao=$condicao." AND ((dim_obra_altura >= '$_REQUEST[dim_obra_altura_ini]') AND (dim_obra_altura <= '$_REQUEST[dim_obra_altura_fim]'))";

   $txtpesquisa=$txtpesquisa."<br>&nbsp;- altura: <font style='color:brown;'>".'de '.number_format($_REQUEST[dim_obra_altura_ini], 2, ',', '.').' até '.number_format($_REQUEST[dim_obra_altura_fim], 2, ',', '.')."</font>";
   $txtpesquisa_rel=$txtpesquisa_rel."- altura: de ".number_format($_REQUEST[dim_obra_altura_ini], 2, ',', '.')." até ".number_format($_REQUEST[dim_obra_altura_fim], 2, ',', '.');

}
if ($_REQUEST['dim_obra_largura_ini']<>'')
{
   $condicao=$condicao." AND ((dim_obra_largura >= '$_REQUEST[dim_obra_largura_ini]') AND (dim_obra_largura <= '$_REQUEST[dim_obra_largura_fim]'))"; 
   $txtpesquisa=$txtpesquisa."<br>&nbsp;- largura: <font style='color:brown;'>".'de '.number_format($_REQUEST[dim_obra_largura_ini], 2, ',', '.').' até '.number_format($_REQUEST[dim_obra_largura_fim], 2, ',', '.')."</font>";
   $txtpesquisa_rel=$txtpesquisa_rel."- largura: de ".number_format($_REQUEST[dim_obra_largura_ini], 2, ',', '.')." até ".number_format($_REQUEST[dim_obra_largura_fim], 2, ',', '.');
}
if ($_REQUEST['dim_obra_diametro_ini']<>'')
{
   $condicao=$condicao." AND ((dim_obra_diametro >= '$_REQUEST[dim_obra_diametro_ini]') AND (dim_obra_diametro <= '$_REQUEST[dim_obra_diametro_fim]'))";
   $txtpesquisa=$txtpesquisa."<br>&nbsp;- diametro: <font style='color:brown;'>".'de '.number_format($_REQUEST[dim_obra_diametro_ini], 2, ',', '.').' até '.number_format($_REQUEST[dim_obra_diametro_fim], 2, ',', '.')."</font>";
   $txtpesquisa_rel=$txtpesquisa_rel."- diametro: de ".number_format($_REQUEST[dim_obra_diametro_ini], 2, ',', '.')." até ".number_format($_REQUEST[dim_obra_diametro_fim], 2, ',', '.');
}
if ($_REQUEST['dim_obra_profundidade_ini']<>'')
{
   $condicao=$condicao." AND ((dim_obra_profund >= '$_REQUEST[dim_obra_profundidade_ini]') AND (dim_obra_profund <= '$_REQUEST[dim_obra_profundidade_fim]'))";
   $txtpesquisa=$txtpesquisa."<br>&nbsp;- profundidade: <font style='color:brown;'>".'de '.formata_valor_3($_REQUEST[dim_obra_profundidade_ini]).' até '.formata_valor_3($_REQUEST[dim_obra_profundidade_fim])."</font>";
   $txtpesquisa_rel=$txtpesquisa_rel."- profundidade: de ".formata_valor_3($_REQUEST[dim_obra_profundidade_ini])." até ".formata_valor_3($_REQUEST[dim_obra_profundidade_fim]);
}

if ($_REQUEST['dim_obra_peso_ini']<>'')
{
   $condicao=$condicao." AND ((dim_obra_peso >= '$_REQUEST[dim_obra_peso_ini]') AND (dim_obra_peso <= '$_REQUEST[dim_obra_peso_fim]'))";
   $txtpesquisa=$txtpesquisa."<br>&nbsp;- peso: <font style='color:brown;'>".'de '.number_format($_REQUEST[dim_obra_peso_ini], 2, ',', '.').' até '.number_format($_REQUEST[dim_obra_peso_fim], 2, ',', '.')."</font>";
   $txtpesquisa_rel=$txtpesquisa_rel."- peso: de ".number_format($_REQUEST[dim_obra_peso_ini], 2, ',', '.')." até ".number_format($_REQUEST[dim_obra_peso_fim], 2, ',', '.');
}

if ($_REQUEST['aimp_obra_altura_ini']<>'')
{
   $txtpesquisa=$txtpesquisa."<br>&nbsp;- area impressa (altura): <font style='color:brown;'>".'de '.number_format($_REQUEST[aimp_obra_altura_ini], 2, ',', '.').' até '.number_format($_REQUEST[aimp_obra_altura_fim], 2, ',', '.')."</font>";
   $condicao=$condicao." AND ((aimp_obra_altura >= '$_REQUEST[aimp_obra_altura_ini]') AND (aimp_obra_altura <= '$_REQUEST[aimp_obra_altura_fim]'))";
   $txtpesquisa_rel=$txtpesquisa_rel."- area impressa (altura): de ".number_format($_REQUEST[aimp_obra_altura_ini], 2, ',', '.')." até ".number_format($_REQUEST[aimp_obra_altura_fim], 2, ',', '.');

}
if ($_REQUEST['aimp_obra_largura_ini']<>'')
{
   $condicao=$condicao." AND ((aimp_obra_largura >= '$_REQUEST[aimp_obra_largura_ini]') AND (aimp_obra_largura <= '$_REQUEST[aimp_obra_largura_fim]'))";
   $txtpesquisa=$txtpesquisa."<br>&nbsp;- area impressa (largura): <font style='color:brown;'>".'de '.number_format($_REQUEST[aimp_obra_largura_ini], 2, ',', '.').' até '.number_format($_REQUEST[aimp_obra_largura_fim], 2, ',', '.')."</font>";
}
if ($_REQUEST['aimp_obra_diametro_ini']<>'')
{
   $condicao=$condicao." AND ((aimp_obra_diametro >= '$_REQUEST[aimp_obra_diametro_ini]') AND (aimp_obra_diametro <= '$_REQUEST[aimp_obra_diametro_fim]'))";
   $txtpesquisa=$txtpesquisa."<br>&nbsp;- area impressa (diametro): <font style='color:brown;'>".'de '.number_format($_REQUEST[aimp_obra_diametro_ini], 2, ',', '.').' até '.number_format($_REQUEST[aimp_obra_diametro_fim], 2, ',', '.')."</font>";
   $txtpesquisa_rel=$txtpesquisa_rel."- area impressa (diametro): de ".number_format($_REQUEST[aimp_obra_diametro_ini], 2, ',', '.')." até ".number_format($_REQUEST[aimp_obra_diametro_fim], 2, ',', '.');
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
	
//   Salva o SQL em outra variavel para consulta pelo numero do registro
    $sqlPesq="SELECT DISTINCT O.* $from where status='P' $condicao order by num_registro + 0 asc";

    echo "<script>";
    echo "var numreg = new Array()"."\r\n";
    $db4->query($sqlPesq);
    $i=0;
    while ($row=$db4->dados()) {
    		$i=$i+1;
    		echo "numreg[$i]='".$row[num_registro]."'"."\r\n";
    }
    echo "numreg[0]=".$i."\r\n";
    echo "function localiza(e) {
              slot=0;
              pos=e.value;
              fim=numreg[0]+1;
              for (v1=1;(v1<fim);v1++) {
                  if (numreg[v1]==pos) {
                     slot=v1;
                  }
              }
              if (slot==0) {
		pos=e.value.toUpperCase();
              	for (v1=1;(v1<fim);v1++) {
                  if (numreg[v1]==pos) {
                     slot=v1;
                  }
              	}
              }	
              if (slot==0) {
		pos=e.value.toLowerCase();
              	for (v1=1;(v1<fim);v1++) {
                  if (numreg[v1]==pos) {
                     slot=v1;
                  }
              	}
              }	
              if (slot==0) {
		slot=1;
              }	
              return slot;
          }";
    echo "function valor(objeto) {
    		      alert(objeto)
              return objeto
          }";
    echo "</script>";
	  $db->query($sql);
	// marcar/desmarcar todas as obras para impressão \\
	  if ($_REQUEST['marcar_todas'] == '1') {
			$_SESSION['s_impressao']='';
			$_SESSION['s_temimagem']='';
			$_SESSION['s_imp_total']= 0;
			while ($row=$db->dados()) {
				$_SESSION['s_impressao']= $_SESSION['s_impressao'] . "," . $row['obra'];
                                
				$_SESSION['s_imp_total']++;
 
			}
			$_SESSION['s_impressao']= $_SESSION['s_impressao'] . ",";
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

//		$select2="DISTINCT O.obra,O.titulo,O.num_registro,A.nomeetiqueta"; 
		$select2="DISTINCT O.*"; 
//  		$sql2="SELECT $select2 $from where status='P' and (B.hierarquia = 1 or B.hierarquia IS null) $condicao order by  titulo asc LIMIT $registroinicial,$pagesize";
  		$sql2="SELECT $select2 $from where status='P' $condicao order by num_registro + 0 asc LIMIT $registroinicial,$pagesize";
              // echo $sql2;
  //  echo "<br>";



       $db->query($sql2);

	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
         <tr  width="100%"  bgcolor="#96ADBE">
          <td height="24" bgcolor="#ddddd5" valign="top" class="texto_bold"><div align="left">&nbsp;<img src="imgs/icons/mais.gif" width="10" height="10" border="0" align="baseline" id="img_mod"><a href="javascript:;" style="color:blue;" onClick="mostra_parametros(); return false;"> Obras com...</a></div><span id="parametros" style="display:none;"><? echo substr($txtpesquisa,4); ?></span></td>
        </tr>
        <tr bgcolor="#f2f2f2">
        </tr>
         </table>       
        <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="6" bgcolor="#f2f2f2">
          <? while($row=$db->dados())
	  {
				$seguro=$row[val_seguro];

				$sql="SELECT a.nome_arquivo,a.diretorio_imagem,a.forma_exibicao,b.eh_principal,a.fotografia from fotografia as a, fotografia_obra as b 
					   where a.fotografia = b.fotografia AND b.obra = '$row[obra]' order by b.eh_mini desc , eh_principal desc";
				$db3->query($sql);
				$dim= $db3->dados();
				$principal= $dim['eh_principal'];
				$forma_exibicao= $dim['forma_exibicao'];
				$altu= number_format($row['dim_obra_altura'],1,",",".");
				$larg= number_format($row['dim_obra_largura'],1,",",".");
				$diam= formata_valor_3($row['dim_obra_diametro']);
				$prof= Formata_valor_3($row['dim_obra_profund']);
				if ($altu == '0,0')
					$altu= '';
				if ($larg == '0,0')
					$larg= '';
				if ($diam == '0,0')
					$diam= '';
				if ($prof == '0,0')
					$prof= '';

                                $idImagem=$dim[fotografia];

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
                $sql="select * from autor_obra where obra=".$row[obra]." and autor=".$lista[autor];
                $db5->query($sql);
                $lista1=$db5->dados();
                $atribuido="";
                if ($lista1[atribuido] == "S") {
                    $atribuido=" (atribuido)";
                }
		if ($lista[dt_morte_tp] == '?')
			$mort.=" (?) ";
		$lista_autoria .= "<b>".$lista['nomeetiqueta']."</b><em>".$atribuido."<br>".$nasc." - ".$mort.  "</em></b><br>";
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
	<? 
               
                if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . formata_valor_3($row['dim_obra_altura']). " x " . formata_valor_3($row['dim_obra_largura']). " x " . formata_valor_3($row['dim_obra_profund']) . " cm"; 
	   elseif ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm ; " . formata_valor_3($row['dim_obra_profund']) . " cm (profundidade)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm";
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
		echo $row[material_tecnica].", " . formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
		echo $row[material_tecnica].", " . formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)" ; 
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
							If ($_SESSION['s_impressao'] == '') {
								$_SESSION['s_impressao'] = ",";
							}
							$_SESSION['s_impressao']= $_SESSION['s_impressao'] . $row['obra'] . ",";
							$_SESSION['s_imp_total']++;
						}

						$marcou= "";
						if (stristr($_SESSION['s_impressao'], ",".$row['obra'].",")) {
							$marcou= "checked";
							if ($_REQUEST['clicou_marcar'] && $_REQUEST['imprime']=='') {
								$marcou= "";
								$_SESSION['s_impressao']= str_replace(",".$row['obra'].",",",",$_SESSION['s_impressao']);
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
			$sql="SELECT b.referencia,b.autoria,b.local,b.editora,a.observacao,b.ano from obra_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
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

                <?
                  if ($_REQUEST[imagem1]!="") {
                      $_SESSION[img1]=$_REQUEST[imagem1];
                  }
                  if ($_REQUEST[imagem2]!="") {
                      $_SESSION[img2]=$_REQUEST[imagem2];
                  }
                ?>

        <tr bgcolor="#ddddd5">
          <td colspan="2" bgcolor="#96ADBE" class="texto_bold"><img src="file:///C|/Documents%20and%20Settings/Administrator/Desktop/imgs/transp.gif" width="100" height="1"></td>
        </tr>


		<? $sqlusu="SELECT usuario FROM usuario WHERE nome='".$_SESSION[snome]."'";
                                $dbusu->query($sqlusu);
                                $usu=$dbusu->dados();
                             
                   if (strtoupper($_SESSION[snome]) != 'VISITANTE') { ?>
                        	
			<td colspan="2" nowrap class="texto" >&nbsp;Marcada:<input type="checkbox" name="imprime" value="marcou" <? echo $marcou; ?> onClick="document.frm_imprime.submit();"> 
			<a href="#" style="text-decoration: none;" onClick="document.getElementById('marcar_todas').value='1'; document.frm_imprime.submit();"><sub><img src="imgs/icons/ic_marca_todas.gif" border="0" title="Marcar todas"></sub></a>
			<a href="#" style="text-decoration: none;" onClick="document.getElementById('marcar_todas').value='2'; document.frm_imprime.submit();"><sub><img src="imgs/icons/ic_desmarca_todas.gif" border="0" title="Desmarcar todas"></sub></a>
			&nbsp;&nbsp;<a href="javascript:;" style="color:black; text-decoration: none;" onClick="abrepop2('lista_impressao.php');">(<em><? echo $_SESSION['s_imp_total']; ?></em>)</a>
			
                                         &nbsp;&nbsp;<a href="javascript:;" style="text-decoration: none;" onClick="
                                          <?if ($_SESSION['s_imp_total'] =='0'){
                                              echo"<script>alert('As obras foram desmarcadas!');</script>";}
                                            else {?>         
			        abrepopetiq('sel_impressao.php?<?echo "num=".$_SESSION['s_imp_total']?><?echo "&usuario=".$usu['usuario']?><?echo "&txtpesquisa_rel=".$txtpesquisa_rel;?>
                                              <?}?>');"><sub><img src="imgs/icons/ic_salvar_impressao.gif" border="0" title="Gravar/imprimir etiqueta da lista de registros"></sub></a>
                                           
			<font style="color: #859CBE;">|</font>
			<a href="javascript:;" style="text-decoration: none;" onClick="abrepop3('pre_impressao_resumida.php');"><sub><img src="imgs/icons/ic_ficha_res.gif" border="0" title="Gravar/imprimir FICHA RESUMIDA (individual)"></sub></a>
			<a href="javascript:;" style="text-decoration: none;" onClick="abrepop3('pre_impressao_completa.php');"><sub><img src="imgs/icons/ic_ficha_completa.gif" border="0" title="Gravar/imprimir FICHA COMPLETA (individual)"></sub></a>
			<a href="javascript:;" style="text-decoration: none;" onClick="abre_pagina('<? echo $row[obra]; ?>','<? echo htmlentities(str_replace("'","`",$row[titulo]), ENT_QUOTES); ?>');"><sub><img src="imgs/icons/busca.gif" border="0" title="Abrir FICHA COMPLETA"></sub></a>
			<font style="color: #859CBE;">|</font>&nbsp;&nbsp;&nbsp;Modelo 1<input type="checkbox" name="modelo" id="modelo1" value="1" onClick="muda_modelo(1); this.focus();">
			2<input type="checkbox" name="modelo" id="modelo2" value="2" onClick="muda_modelo(2); this.focus();">
			3<input type="checkbox" name="modelo" id="modelo3" value="3" onClick="muda_modelo(3); this.focus();">
			4<input type="checkbox" name="modelo" id="modelo4" value="4" onClick="muda_modelo(4); this.focus();">
			5<input type="checkbox" name="modelo" id="modelo5" value="5" onClick="muda_modelo(5); this.focus();">






               <? } ?>

	         <? 
                           $_REQUEST[obra_3d]=$row[obra]?>

                       <input type="hidden" name=imagem1 value=<? echo $_SESSION[img1] ?>>
                        <input type="hidden" name=imagem2 value=<? echo $_SESSION[img2] ?>>
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
			<input type="hidden" name="escola" value="<? echo htmlentities(str_replace("\\","",$_REQUEST[escola]), ENT_QUOTES);?>">
			<input type="hidden" name="estilo" value="<? echo htmlentities(str_replace("\\","",$_REQUEST[estilo]), ENT_QUOTES);?>">
			<input type="hidden" name="movimento" value="<? echo htmlentities(str_replace("\\","",$_REQUEST[movimento]), ENT_QUOTES);?>">
			<input type="hidden" name="sub_tema" value="<? echo htmlentities(str_replace("\\","",$_REQUEST[sub_tema]), ENT_QUOTES);?>">
			<input type="hidden" name="idtemas" value="<? echo trim($_REQUEST[idtemas]); ?>">
			<input type="hidden" name="titulo" value="<? echo htmlentities(str_replace("\\","",$_REQUEST[titulo]), ENT_QUOTES);?>">
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

<tr><td colspan="2" align="left" nowrap class="texto" style="border-top: 1px solid #96ADBE;">
      <form name=pesquisa action="" method=post>

		      &nbsp;Digite o Nº de Registro:&nbsp;<input type=text name=NumeroReg size="12" class="combo_texto" onKeyup="return submitenter(this,event,<? echo $first; ?>,<? echo $last; ?>,<? echo $mais; ?>,<? echo $menos; ?>)">


      <?
          $comando="<a href='#' onClick='obtem_valor(\"\",localiza(NumeroReg),modelo)'>";
          echo $comando;
      ?>
            <img src='imgs/icons/lupa.gif'  border='0'  alt='Localiza obra pelo Nº de Registro' ></a>

			<font style="color: #859CBE;">|</font>
                      <a colspan="0" align="center" nowrap class="texto">&nbsp;Comparar imagens:
                      <a href="#" style="text-decoration: none;" onClick="document.getElementById('imagem1').value=<? echo $idImagem; ?>;document.frm_imprime.submit();"><sub><img src="imgs/icons/image2_1.gif" border="0" title="Imagem Comparada 1"></sub></a>
                      <a href="#" style="text-decoration: none;" onClick="document.getElementById('imagem2').value=<? echo $idImagem; ?>;document.frm_imprime.submit();"><sub><img src="imgs/icons/image2_2.gif" border="0" title="Imagem Comparada 2"></sub></a>
		      <a href="javascript:;" style="text-decoration: none;" onClick="compara_imagem('<? echo $_SESSION[img1]; ?>','<? echo $_SESSION['img2']; ?>');"><sub><img src="imgs/icons/busca.gif" border="0" title="Compara Imagens"></sub></a>
                       <font style="color: #859CBE;">|</font>               
           
                           
	     <? if (($diam <> '0,0')and ($larg<> '0,0') and ($altu<> '0,0') and ($larg<> '') and ($altu<> '') and ($prof <> '') ){
                             if (file_exists($dirrotacao.$_REQUEST[obra_3d].'.zip')) {
   				echo "<b><a href='javascript:;' onClick=";
                                echo '"';
				echo "abrepop3D('rotate/rotacao.php?id=";
				echo $_REQUEST[obra_3d];
				echo "'); ";
				echo '"';
				echo '"';
				echo " ><img src=imgs/icons/btn_3d_azul.gif title='Visualiza rotação...' border=0></a>";?>
                                </b>                          
                      <?}}?>                     



	
</form>
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
