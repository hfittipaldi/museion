<? include_once("seguranca.php") ?>
<html>
<head>
<title>Pesquisa de Autores</title>
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

<script language="JavaScript">

function obtem_valor(qual,i) {
	if (qual.selectedIndex.selected!= '') {
		document.location=('autorconsulta.php?page='+ i+ '&bibliografia=<? echo trim($_REQUEST[bibliografia]); ?>&bio=<? echo trim($_REQUEST[bio]); ?>&pais_nasc=<? echo $_REQUEST[pais_nasc]; ?>&estadoatua=<? echo trim($_REQUEST[estadoatua]); ?>&paisatua=<? echo trim($_REQUEST[paisatua]); ?>&nome=<? echo trim($_REQUEST[nome]); ?>&deMes=<? echo $_REQUEST[deMes]; ?>&deAno=<? echo $_REQUEST[deAno]; ?>&ateAno=<? echo $_REQUEST[ateAno]; ?>&cid_nasc=<? echo $_REQUEST[cid_nasc]; ?>&cid_morte=<? echo $_REQUEST[cid_morte]; ?>&pais_morte=<? echo $_REQUEST[pais_morte]; ?>');
	}
}

function verificar() {
	for (i=0; i<document.form.length; i++) {
		var tempobj= document.form.elements[i];
		if ((tempobj.type=='text' && tempobj.value!='') || (tempobj.name=='pais_nasc' && tempobj.value!='') || (tempobj.name=='pais_morte' && tempobj.value!='') || (tempobj.name=='estado_morte' && tempobj.value!='')|| (tempobj.name=='estado_nasc' && tempobj.value!='') ) {
			return true;
		}
	}
	alert('Informe pelo menos um parâmetro de busca.');
	return false;
}
function posiciona(valor) {
var i = valor;
document.location=('autorconsulta.php?page='+ i+ '&bibliografia=<? echo trim($_REQUEST[bibliografia]); ?>&bio=<? echo trim($_REQUEST[bio]); ?>&pais_nasc=<? echo $_REQUEST[pais_nasc]; ?>&estadoatua=<? echo trim($_REQUEST[estadoatua]); ?>&paisatua=<? echo trim($_REQUEST[paisatua]); ?>&nome=<? echo trim($_REQUEST[nome]); ?>&deMes=<? echo $_REQUEST[deMes]; ?>&deAno=<? echo $_REQUEST[deAno]; ?>&ateAno=<? echo $_REQUEST[ateAno]; ?>&cid_nasc=<? echo $_REQUEST[cid_nasc]; ?>&deAnoFal=<? echo $_REQUEST[deAnoFal]; ?>&ateAnoFal=<? echo $_REQUEST[ateAnoFal]; ?>&cid_morte=<? echo $_REQUEST[cid_morte]; ?>&pais_morte=<? echo $_REQUEST[pais_morte]; ?>');
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
    <th width="542" colspan="2" scope="col"><div align="left" class="tit_interno">
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
$deAnoFal= $_REQUEST['deAnoFal'];
$ateAnoFal= $_REQUEST['ateAnoFal'];

function exibeDataNegativa($valor) {
	if ($valor < 0)
		return substr($valor,1) . " aC";
	else
		return $valor;
}
////
$condicao= '';

if (trim($_REQUEST['nome']) <> '') {
	$condicao= "AND (a.nomeetiqueta like '%".trim($_REQUEST['nome'])."%' OR a.nomecatalogo like '%".trim($_REQUEST['nome'])."%')";
	$txtpesquisa= "<br>&nbsp;- Nome: <font style='color:brown;'>".trim($_REQUEST['nome'])."</font>";
}

if ($deMes<>'' || $deAno<>'' || $ateAno<>'' || $deAnoFal<>'' || $ateAnoFal<>'' ) {

/*if ($deMes <> '') {
	switch ($deMes) {
		case 1: $Mes='janeiro'; break;
		case 2: $Mes='fevereiro'; break;
		case 3: $Mes='março'; break;
		case 4: $Mes='abril'; break;
		case 5: $Mes='maio'; break;
		case 6: $Mes='junho'; break;
		case 7: $Mes='julho'; break;
		case 8: $Mes='agosto'; break;
		case 9: $Mes='setembro'; break;
		case 10: $Mes='outubro'; break;
		case 11: $Mes='novembro'; break;
		case 12: $Mes='dezembro'; break;
		default: $Mes=$deMes; $deMes='99';
	}
	$condicao= $condicao."AND month(dt_nasc_di) = '$deMes' ";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Nascimento em <font style='color:brown;'>".$Mes."</font>";
}*/

if ($deAno<>'' || $ateAno<>'') {
	if ($deAno<>'' && $ateAno=='') {
		$de= $deAno;
		$ate= date("Y");
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Nascimento entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAno)."</font> e <font style='color:#000000;'>".date("Y")."</fotn>";
	}
	elseif ($deAno=='' && $ateAno<>'') {
		$de= "-9999";
		$ate= $ateAno;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Nascimento até o ano de <font style='color:brown;'>".exibeDataNegativa($ateAno)."</font>";
	}
	if ($deAno<>'' && $ateAno<>'') {
		$de= $deAno;
		$ate= $ateAno;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Nascimento entre os anos de <font style='color:brown;'>".exibeDataNegativa($deAno)."</font> e <font style='color:brown;'>".exibeDataNegativa($ateAno)."</fotn>";
	}

	$condicao= $condicao."AND (((a.dt_nasc_ano1 >= $de and a.dt_nasc_ano1 <= $ate) OR (a.dt_nasc_ano2 >= $de and a.dt_nasc_ano2 <= $ate and a.dt_nasc_ano2 <> 0) OR (a.dt_nasc_ano1 <= $de and a.dt_nasc_ano2 >= $ate and a.dt_nasc_ano2 <> 0)) AND a.dt_nasc_ano1 <> 0) ";
}

if ($deAnoFal<>'' || $ateAnoFal<>'') {
	if ($deAnoFal<>'' && $ateAnoFal=='') {
		$deFal= $deAnoFal;
		$ateFal= date("Y");
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Falecimento entre os anos de <font style='color:#ffffff;'>".exibeDataNegativa($deAnoFal)."</font> e <font style='color:#ffffff;'>".date("Y")."</fotn>";
	}
	elseif ($deAnoFal=='' && $ateAnoFal<>'') {
		$deFal= "-9999";
		$ateFal= $ateAnoFal;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Falecimento até o ano de <font style='color:#ffffff;'>".exibeDataNegativa($ateAnoFal)."</font>";
	}
	if ($deAnoFal<>'' && $ateAnoFal<>'') {
		$deFal= $deAnoFal;
		$ateFal= $ateAnoFal;
		$txtpesquisa= $txtpesquisa."<br>&nbsp;- Falecimento entre os anos de <font style='color:#ffffff;'>".exibeDataNegativa($deAnoFal)."</font> e <font style='color:#ffffff;'>".exibeDataNegativa($ateAnoFal)."</fotn>";
	}

	$condicao= $condicao."AND (((a.dt_morte_ano1 >= $deFal and a.dt_morte_ano1 <= $ateFal) OR (a.dt_morte_ano2 >= $deFal and a.dt_morte_ano2 <= $ateFal and a.dt_morte_ano2 <> 0) OR (a.dt_morte_ano1 <= $deFal and a.dt_morte_ano2 >= $ateFal and a.dt_morte_ano2 <> 0)) AND a.dt_morte_ano1 <> 0) ";
}}

if (trim($_REQUEST['paisatua']) <> '') {
	$paises= explode(",", trim($_REQUEST['paisatua']));
	$tot= count($paises);
	if ($paises[0] == '')
		$tot= 0;
	if ($tot > 0)
		$condicao= $condicao."AND (";
	for ($i=1; $i<=$tot; $i++) {
		$condicao= $condicao."a.paisatua like '%".$paises[$i-1]."%' ";
		if ($i < $tot)
			$condicao= $condicao."or ";
	}
	if ($tot > 0)
		$condicao= $condicao.") ";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Países de atuação: <font style='color:brown;'>".str_replace(",",", ",trim($_REQUEST['paisatua']))."</font>";
}

if (trim($_REQUEST['estadoatua']) <> '') {
	$estados= explode(",", trim($_REQUEST['estadoatua']));
	$tot= count($estados);
	if ($estados[0] == '')
		$tot= 0;
	if ($tot > 0)
		$condicao= $condicao."AND (";
	for ($i=1; $i<=$tot; $i++) {
		$condicao= $condicao."a.estadoatua like '%".$estados[$i-1]."%' ";
		if ($i < $tot)
			$condicao= $condicao."or ";
	}
	if ($tot > 0)
		$condicao= $condicao.") ";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Estados de atuação: <font style='color:brown;'>".str_replace(",",", ",trim($_REQUEST['estadoatua']))."</font>";
}

if (trim($_REQUEST['cid_nasc']) <> '') {
	$condicao= $condicao."AND a.cidade_nasc like '%".trim($_REQUEST['cid_nasc'])."%' ";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Cidade de nascimento: \"<font style='color:brown;'>".trim($_REQUEST['cid_nasc'])."</font>\"";
}

if ($_REQUEST['estado_nasc'] <> '') {
	$condicao= $condicao."AND a.estado_nasc = '$_REQUEST[estado_nasc]' ";
	$sql= "SELECT nome from estado where estado = '$_REQUEST[estado_nasc]'";
	$db->query($sql);
	$estadon= $db->dados();
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Estado de nascimento: <font style='color:brown;'>".$estadon['nome']."</font>";
}


if ($_REQUEST['pais_nasc'] <> '') {
	$condicao= $condicao."AND a.pais_nasc = '$_REQUEST[pais_nasc]' ";
	$sql= "SELECT nome from pais where pais = '$_REQUEST[pais_nasc]'";
	$db->query($sql);
	$paisn= $db->dados();
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- País de nascimento: <font style='color:brown;'>".$paisn['nome']."</font>";
}

if (trim($_REQUEST['cid_morte']) <> '') {
	$condicao= $condicao."AND a.cidade_morte like '%".trim($_REQUEST['cid_morte'])."%' ";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Cidade de falecimento: \"<font style='color:brown;'>".trim($_REQUEST['cid_morte'])."</font>\"";
}


if ($_REQUEST['estado_morte'] <> '') {
	$condicao= $condicao."AND a.estado_morte = '$_REQUEST[estado_morte]' ";
	$sql= "SELECT nome from estado where estado = '$_REQUEST[estado_morte]'";
	$db->query($sql);
	$estadom= $db->dados();
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Estado de falecimento: <font style='color:brown;'>".$estadom['nome']."</font>";
}

if ($_REQUEST['pais_morte'] <> '') {
	$condicao= $condicao."AND a.pais_morte = '$_REQUEST[pais_morte]' ";
	$sql= "SELECT nome from pais where pais = '$_REQUEST[pais_morte]'";
	$db->query($sql);
	$paism= $db->dados();
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- País de falecimento: <font style='color:brown;'>".$paism['nome']."</font>";
}

if (trim($_REQUEST['bio']) <> '') {
	$condicao= $condicao."AND a.biografia like '%".trim($_REQUEST['bio'])."%' ";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Texto em biografia: \"<font style='color:brown;'>".trim($_REQUEST['bio'])."</font>\"";
}

$join= "";
if (trim($_REQUEST['bibliografia']) <> '') {
	$join= "INNER JOIN autor_bibliografia as b on (a.autor=b.autor) INNER JOIN bibliografia as c on (b.bibliografia=c.bibliografia)";
	$condicao= $condicao."AND (c.referencia like '%".trim($_REQUEST['bibliografia'])."%' or c.txt_legado like '%".trim($_REQUEST['bibliografia'])."%') ";
	$txtpesquisa= $txtpesquisa."<br>&nbsp;- Referência em bibliografia: \"<font style='color:brown;'>".trim($_REQUEST['bibliografia'])."</font>\"";
}
////

/*if ($_REQUEST['ok'] == '') {
	montalinks();
	$_SESSION['lnk']= $link;
}
else*/
	//echo $_SESSION['lnk'];
?>
    </div></th>
  </tr>

	<? if ($_REQUEST['ok']=='' && $_REQUEST[page]=='') { ?>
	<form name="form" method="get" action="autorconsulta.php" onSubmit="return verificar();">
	<th align="left" class="texto_bold" ><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome: <input type="text" class="combo_cadastro" name="nome" size="71">
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nascimento entre os anos de: <input type="text" class="combo_cadastro" name="deAno" size="6" style="text-align: right;"> 
		e <input type="text" class="combo_cadastro" name="ateAno" size="6"> 
		
        <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           
      
  
                 Países de atuação: &nbsp;&nbsp;
                 <input name="paisatua" type="text" class="combo_cadastro" readonly size="49">
	       <a href='javascript:;' onClick="abrepop('pop_pais.php?consultaautor=1&pais_atua='+document.form.paisatua.value); ""><img src="imgs/icons/lupa.gif" title="Selecionar..." border="0" align="bottom"></a> 
     
        

		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Estados de atuação: 
                                 <input name="estadoatua" type="text" class="combo_cadastro" readonly size="49">
		              <a href='javascript:;' onClick="abrepop('pop_estado.php?consultaautor=1&estado_atua='+document.form.estadoatua.value); ""><img src="imgs/icons/lupa.gif" title="Selecionar..." align="bottom" border="0"></a>

     
    
                <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cidade de nascimento: <input type="text" class="combo_cadastro" name="cid_nasc" size="53">

		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado de nascimento: <select name="estado_nasc" class="combo_cadastro">
				  <? 
					  $sql="SELECT distinct estado,nome from estado order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='' selected></option>";
					  while($res=$db->dados()) {
					  ?>
					   <option value="<? echo $res[0]; ?>"><? echo $res[1]; ?></option>
				  <? } ?>
                      </select>

          
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;País de nascimento: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="pais_nasc" class="combo_cadastro">
				  <? 
					  $sql="SELECT distinct pais,nome from pais order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='' selected></option>";
					  while($res=$db->dados()) {
					  ?>
					   <option value="<? echo $res[0]; ?>"><? echo $res[1]; ?></option>
				  <? } ?>
                      </select>
                <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Falecimento entre os anos de: <input type="text" class="combo_cadastro" name="deAnoFal" size="6" style="text-align: right;"> 
		e <input type="text" class="combo_cadastro" name="ateAnoFal" size="6">
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cidade de falecimento: <input type="text" class="combo_cadastro" name="cid_morte" size="53">


		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado de falecimento: <select name="estado_morte" class="combo_cadastro">
				  <? 
					  $sql="SELECT distinct estado,nome from estado order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='' selected></option>";
					  while($res=$db->dados()) {
					  ?>
					   <option value="<? echo $res[0]; ?>"><? echo $res[1]; ?></option>
				  <? } ?>
                      </select>


		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;País de falecimento: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="pais_morte" class="combo_cadastro">
				  <? 
					  $sql="SELECT distinct pais,nome from pais order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='' selected></option>";
					  while($res=$db->dados()) {
					  ?>
					   <option value="<? echo $res[0]; ?>"><? echo $res[1]; ?></option>
				  <? } ?>
                      </select>
		<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Texto em biografia: <input type="text" class="combo_cadastro" name="bio" size="57">
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ref. bibliográfica: &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="combo_cadastro" name="bibliografia" size="57">
		<br><br><div align="right"><input type="submit" name="ok" value="Pesquisar" class="texto_bold">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
		<br>
	</th>

	<? } else {
		echo "<form name='form' method='post' action='autorconsulta.php'>";
		echo "<th colspan='3' align='right' valign='bottom' class='texto_bold'>";
		if ($_REQUEST[pagesize] < 999) echo "<input type='submit' name='nova' value='Nova consulta' class='combo_cadastro' style='cursor:pointer; border-width: 1px;'>";
		echo "</th>";
	} ?>

	</form>


<? if ($_REQUEST['ok']<>'' || $_REQUEST[page]<>'') { ?>
  <tr>
    <td valign="top" colspan="3"><form name="form1" method="post">
      <?
	  /////Paginando
	  $pagesize=9;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT count(*) as total from autor as a $join where 1 $condicao";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT * from autor as a $join where 1 $condicao order by a.nomeetiqueta LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="5" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="85%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;Autores com <? echo $txtpesquisa; ?></div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
          <td colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['autor'] ?>">
          <td align="justify" width='85%'><b><? echo $row[nomeetiqueta] ?></b> 

			</td>
          <td align="center" width='15%'><? if ($_REQUEST[pagesize] < 999) echo "<a href=\"consulta_autor.php?op=view&id=".$row['autor']."&nosave=1&nome=".$_REQUEST['nome']."&deAno=".$_REQUEST[deAno]."&ateAno=".$_REQUEST[ateAno]."&paisatua=".$_REQUEST[paisatu]."&estadoatua=".$_REQUEST[estadoatua]."&cid_nasc=".$_REQUEST[cid_nasc]."&estado_nasc=".$_REQUEST[estado_nasc]."&pais_nasc=".$_REQUEST[pais_nasc]."&deAnoFal=".$_REQUEST[deAnoFal]."&ateAnoFal=".$_REQUEST[ateAnoFal]."&cid_morte=".$_REQUEST[cid_morte]."&estado_morte=".$_REQUEST[estado_morte]."&pais_morte=".$_REQUEST[pais_morte]."&bio=".$_REQUEST[bio]."&bibliografia=".$_REQUEST[bibliografia]."&ok=".$_REQUEST[ok]."\">
	 <img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informações' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[autor]."\").style.backgroundColor=\"\";'>"; }?>
            <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="3" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"autorconsulta.php?page=1&pagesize=999999&bibliografia=".trim($_REQUEST[bibliografia])."&bio=".trim($_REQUEST[bio])."&pais_nasc=".$_REQUEST[pais_nasc]."&estadoatua=".trim($_REQUEST[estadoatua])."&paisatua=".trim($_REQUEST[paisatua])."&nome=".trim($_REQUEST[nome])."&deMes=".$_REQUEST[deMes]."&deAno=".$_REQUEST[deAno]."&ateAno=".$_REQUEST[ateAno]."&pais_morte=".$_REQUEST[pais_morte]."&cid_nasc=".$_REQUEST[cid_nasc]."&cid_morte=".$_REQUEST[cid_morte]."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
        </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="5" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"autorconsulta.php?page=".$first."&bibliografia=".trim($_REQUEST[bibliografia])."&bio=".trim($_REQUEST[bio])."&pais_nasc=".$_REQUEST[pais_nasc]."&estadoatua=".trim($_REQUEST[estadoatua])."&paisatua=".trim($_REQUEST[paisatua])."&nome=".trim($_REQUEST[nome])."&deMes=".$_REQUEST[deMes]."&deAno=".$_REQUEST[deAno]."&ateAno=".$_REQUEST[ateAno]."&pais_morte=".$_REQUEST[pais_morte]."&cid_nasc=".$_REQUEST[cid_nasc]."&cid_morte=".$_REQUEST[cid_morte]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial'></a>";

$b="<a href=\"autorconsulta.php?page=".$menos."&bibliografia=".trim($_REQUEST[bibliografia])."&bio=".trim($_REQUEST[bio])."&pais_nasc=".$_REQUEST[pais_nasc]."&estadoatua=".trim($_REQUEST[estadoatua])."&paisatua=".trim($_REQUEST[paisatua])."&nome=".trim($_REQUEST[nome])."&deMes=".$_REQUEST[deMes]."&deAno=".$_REQUEST[deAno]."&ateAno=".$_REQUEST[ateAno]."&pais_morte=".$_REQUEST[pais_morte]."&cid_nasc=".$_REQUEST[cid_nasc]."&cid_morte=".$_REQUEST[cid_morte]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior'></a>";

$c="<a href=\"autorconsulta.php?page=".$mais."&bibliografia=".trim($_REQUEST[bibliografia])."&bio=".trim($_REQUEST[bio])."&pais_nasc=".$_REQUEST[pais_nasc]."&estadoatua=".trim($_REQUEST[estadoatua])."&paisatua=".trim($_REQUEST[paisatua])."&nome=".trim($_REQUEST[nome])."&deMes=".$_REQUEST[deMes]."&deAno=".$_REQUEST[deAno]."&ateAno=".$_REQUEST[ateAno]."&pais_morte=".$_REQUEST[pais_morte]."&cid_nasc=".$_REQUEST[cid_nasc]."&cid_morte=".$_REQUEST[cid_morte]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro'></a>";

$d="<a href=\"autorconsulta.php?page=".$last."&bibliografia=".trim($_REQUEST[bibliografia])."&bio=".trim($_REQUEST[bio])."&pais_nasc=".$_REQUEST[pais_nasc]."&estadoatua=".trim($_REQUEST[estadoatua])."&paisatua=".trim($_REQUEST[paisatua])."&nome=".trim($_REQUEST[nome])."&deMes=".$_REQUEST[deMes]."&deAno=".$_REQUEST[deAno]."&ateAno=".$_REQUEST[ateAno]."&pais_morte=".$_REQUEST[pais_morte]."&cid_nasc=".$_REQUEST[cid_nasc]."&cid_morte=".$_REQUEST[cid_morte]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro'></a>";
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
$g= " Total de autores encontrados: $numlinhas ".$txtpagina.$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
<? } ?>
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
          posiciona('<? echo $first; ?>');
          return;
	} 

       //End
	if(code == 35) {
          posiciona('<? echo $last; ?>');
          return;
	} 


       //PgDw
	if(code == 34) {
          posiciona('<? echo $mais; ?>');
          return;
	} 

	//PgUp
	if(code == 33) {
          posiciona('<? echo $menos; ?>');
          return;
	} 

   return;
}
</script>
</body>
</html>