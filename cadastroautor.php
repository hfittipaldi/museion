<? include_once("seguranca.php") ?>
<style type="text/css">
<!--
#abas a {
	font-size: 12px;
	font-weight: bold;
	color: #34689A;
	text-decoration: none;
}f
.divi {
	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
.divi1 {	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
	background-color: #f2f2f2;
}
-->
</style>
<script language="JavaScript">
function ajustaAbas(index) {
	numAbas= 6;

	if (index == 1)
		document.getElementById("aba1").style.borderLeftColor= "#34689A";
	else
		document.getElementById("aba1").style.borderLeftColor= "#34689A";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("link"+i).style.color= "#34689A";
	}
	document.getElementById("link"+index).style.color= "blue";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("aba"+i).style.borderBottomColor= "#34689A";
		document.getElementById("aba"+i).style.verticalAlign= "bottom";
		document.getElementById("aba"+i).style.backgroundColor= "";
	}
	document.getElementById("aba"+index).style.borderBottomColor= "#f2f2f2";
	document.getElementById("aba"+index).style.verticalAlign= "middle";
	document.getElementById("aba"+index).style.backgroundColor= "#f2f2f2";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("quadro"+i).style.display= "none";
	}
	document.getElementById("quadro"+index).style.display= "";

	if (index==3 || index==4 || index==5 || index==6 )
	{
/*	document.frmautor.submit.style.display="none";*/
	document.getElementById('rodape').style.display="none";
	}
   else
   {
	document.getElementById('rodape').style.display="";
/*	document.frmautor.submit.style.display="";*/
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
/*function abrepop2(janela,alt,larg)
{
 var h=screen.height-100,w=screen.width-50;
 
  win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
 if(parseInt(navigator.appVersion)>=4)
{
   win.window.focus();
 }
 return true;
}*/
function abre_manual(parametro)
{
  	win=window.open('manual_catalog.php?janela=popup&corfundo=f2f2f2&parametro='+parametro,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-150)+',scrollbars=yes, height=350,width=560,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
//

function Numero(e){  
navegador = /msie/i.test(navigator.userAgent);
  if (navegador) 
    var tecla = event.keyCode;
	  else   var tecla = e.which;   
	   if((tecla > 47 && tecla < 58) || tecla == 13 || tecla == 45) // numeros de 0 a 9 / ENTER / -
	    return true;  else    {      if (tecla != 8)
		 // backspace      
		   return false;    
		     else    
			     return true;    }}
//
function data()
{
 var ano= new Date();
 return ano.getFullYear();
}
function valida()
{
   with(document.frmautor)
  {
     if(nomeetiqueta.value==''){
	  ajustaAbas(1);
	  alert('Preencha com o nome do autor!');
	  nomeetiqueta.focus();
	  return false;}
	 if(nomecatalogo.value==''){
	  ajustaAbas(1);
	  alert('Preencha com o nome de catálogo!');
	  nomecatalogo.focus();
	  return false;}
/*	if(sexo.value==''){
	 ajustaAbas(1);
	 alert('Preencha com o sexo!');
	 return false;}*/
// Dt Nascimento.
  if(dt_nascdia.value!=''){
	if(dt_nascdia.value==0 || dt_nascdia.value>31){
	   ajustaAbas(1);
	 alert('Erro!Dia de Nascimento Inválido'); 
     dt_nascdia.focus();
	 return false;}}//ok
   if(dt_nascmes.value!=''){
   if(dt_nascmes.value==0 || dt_nascmes.value>12){
        ajustaAbas(1);
	  alert('Erro.Mês de Nascimento Inválido');
      dt_nascmes.focus();
	return false;}}
/*  if(dt_nascano.value!='' || dt_nasc_extra1.value!=''){
   if(dt_nascano.value<=1000 || dt_nascano.value>data()){
    if(dt_nasc_extra1.value<=1000 || dt_nasc_extra1.value>data()){
      ajustaAbas(1);
	alert('Erro.Ano de Nascimento inválido');
	//dt_nascano.focus();
	return false; }}}*/
   /// Mes com 31 dias
 if(dt_nascdia.value!='' && dt_nascmes.value!=''){
    if(dt_nascdia.value==31){
	    if((dt_nascmes.value==0) ||(dt_nascmes.value==2)||(dt_nascmes.value==4)||(dt_nascmes.value==6)||(dt_mortemes.value==7)||
		(dt_nascmes.value==9)||(dt_nascmes.value==11)){
	           ajustaAbas(1);
			 alert('Erro.Dia/Mês de Nascimento inválido');
	         return false;}}
  //Mes com 30 dias
  if(dt_nascdia.value==30){
	    if((dt_nascmes.value==0) ||(dt_nascmes.value==2)){
	           ajustaAbas(1);
			 alert('Erro.Dia/Mês de Nascimento inválido');
	         return false;}}}
// Caso fevereiro
 if(dt_nascdia.value==29 && dt_nascmes.value==2)
 {
     ajustaAbas(1);
   alert('Erro.Dia/Mês de Nascimento inválido');
   return false;
  }
 /// Dt Falecimento
 if(dt_mortedia.value!=''){
	if(dt_mortedia.value==0 || dt_mortedia.value>31){
	   ajustaAbas(2);
	 alert('Erro.Dia de Falecimento Inválido'); 
     dt_mortedia.focus();
	 return false;}}//ok
   if(dt_mortemes.value!=''){
   if(dt_mortemes.value==0 || dt_mortemes.value>12){
        ajustaAbas(2);
	  alert('Erro.Mês de Falecimento Inválido');
      dt_mortemes.focus();
	return false;}}
/*  if(dt_morteano.value!='' || dt_morte_extra1.value!=''){
   if(dt_morteano.value<=1000 || dt_morteano.value>data()){
   if(dt_morte_extra1.value<=1000 || dt_morte_extra1.value>data()){
      ajustaAbas(1);
	alert('Erro.Ano de Falecimento inválido');
	//dt_morteano.focus();
	return false; }}}*/
   /// Mes com 31 dias
 if(dt_mortedia.value!='' && dt_mortemes.value!=''){
    if(dt_mortedia.value==31){
	    if((dt_mortemes.value==0) ||(dt_mortemes.value==2)||(dt_mortemes.value==4)||(dt_mortemes.value==6)||(dt_mortemes.value==7)||
		(dt_mortemes.value==9)||(dt_mortemes.value==11)){
	           ajustaAbas(2);
			 alert('Erro.Dia/Mês de Falecimento inválido');
	         return false;}}
  //Mes com 30 dias
  if(dt_mortedia.value==30){
	    if((dt_mortemes.value==0) ||(dt_mortemes.value==2)){
	           ajustaAbas(2);
			 alert('Erro.Dia/Mês de Falecimento inválido');
	         return false;}}}
// Caso fevereiro
 if(dt_mortedia.value==29 && dt_mortemes.value==2)
 {
     ajustaAbas(2);
   alert('Erro.Dia/Mês de Falecimento inválido');
   return false;
  }
 
 }}
</script>
<script>

 initFormValues = '';

  // fill this array with the names of the formelements that you want to exclude from the check
  // (or leave it like it is when you don't want to include all)
 skipNames = [];		

  // this functions builds a string of all the values in the forms
 function compareValues()
 {
	var formValues = '';
	if (document.forms[0])
	{
		for (f=0;f<document.forms.length;f++)
		{
			for (x=0;x<document.forms[f].length;x++)
			{
				if (document.forms[f].elements[x].type != 'checkbox' && document.forms[f].elements[x].type != 'radio')
				{
					if (inArray(document.forms[f].elements[x].name, skipNames))
					{
						// these elements are not to be included in the combined form-values
						// so, any change made to them by the user won't result in the alert
					}
					else
					{
						// alert(document.forms[f].elements[x].name+' '+document.forms[f].elements[x].value);
						formValues = formValues+document.forms[f].elements[x].value;
					}
				}
				else
				{
					 // we're dealing with a checkox or radiobutton
					formValues = formValues+document.forms[f].elements[x].checked;
				}
			}
		}
	}
	return formValues;
 }

  // filling a var with the initial values, on loading the page
  // (this function has to be called by onLoad() in the <body>-tag
 function setInitFormValues()
 {
	initFormValues = compareValues();
 }

  // filling another var with the values, on leaving the page, so we can compare them
  // (it will be triggered by the onbeforeunload event (see below)
 function checkValues()
 {
	if (initFormValues == compareValues())
	{
		 // apparently, nothing has changed
		return;
	}
	else
	{
		 // apparently, changes have been made
		return 'Alterações foram realizadas. Deseja sair sem salvar?';
	}
 }
	
/* window.onbeforeunload = checkValues;*/

  // of course, if the form is being submitted, we don't want the alert to be triggered.
  // so, instead of using the normal submit-button, create one that calls this function
 function submitForm(formulier)
 {
	if (document.forms[formulier])
	{
		window.onbeforeunload = null;
		document.forms[formulier].submit();
	}
 }

 function inArray(needle, haystack)
 {
	for (var i in haystack)
	{
		if (needle == haystack[i])
			return true;
	}
 }
</script>

<?php $aba=1; ?>
<link href="css/home.css" rel="stylesheet" type="text/css">
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

      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();

//$dir= diretorio_fisico() . "autores\\";
//$dir_virt= diretorio_virtual() . "autores/";
$dir= diretorio_fisico();
$dir_virt= diretorio_virtual();

$sql="select a.nomeetiqueta from autor as a where a.autor='$_REQUEST[id]'";
$db->query($sql);
$res=$db->dados();
$nomeetiqueta=$_REQUEST['nomeetiqueta'];
$op=$_REQUEST['op'];
?>


<body onLoad='ajustaAbas(<? echo $aba ?>);setInitFormValues() '>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
 <?
 if($_REQUEST[id]<>'')
 {
   $sql="SELECT * from autor as a where a.autor='$_REQUEST[id]'";
   $db->query($sql);
      while($row=$db->dados())
	  {
	        $nomeetiqueta=$row['nomeetiqueta'];
		$nomecatalogo=$row['nomecatalogo'];
		$cidade=$row['cidade_nasc'];
		$estado_nasc=$row['estado_nasc'];
		$pais_nasc=$row['pais_nasc'];
		$sexo=$row['sexo'];
		$naturalizado=$row['naturalizado'];
		$naturalidade=$row['naturalidade'];
		//
		$nasc_dia= $row['dt_nasc_dia'];
		$nasc_mes= $row['dt_nasc_mes'];
		$nasc_ano= $row['dt_nasc_ano1'];
		$nasc_ano2= $row['dt_nasc_ano2'];
		$dt_nasc_tp=$row['dt_nasc_tp'];
/*		dtformato_externo($dt_nasc_di, $dt_nasc_df, '', $data['dia'], $data['mes'], $data['ano'], $data['ano2']);
		$nasc_dia= $data['dia'];
		$nasc_mes= $data['mes'];
		$nasc_ano= $data['ano'];
		$nasc_ano2= $data['ano2'];*/
		if ($nasc_dia == 0)
			$nasc_dia= "";
		if ($nasc_mes == 0)
			$nasc_mes= "";
		if ($nasc_ano == 0)
			$nasc_ano= "";
		if ($nasc_ano2 == 0)
			$nasc_ano2= "";
		//
		$estadoatua=$row['estadoatua'];
		$paisatua=$row['paisatua'];
		$cidade_morte=$row['cidade_morte'];
		$estado_morte=$row['estado_morte'];
		$pais_morte=$row['pais_morte'];
		//
		$morte_dia= $row['dt_morte_dia'];
		$morte_mes= $row['dt_morte_mes'];
		$morte_ano= $row['dt_morte_ano1'];
		$morte_ano2= $row['dt_morte_ano2'];
		$dt_morte_tp=$row['dt_morte_tp'];
/*		dtformato_externo($dt_morte_di, $dt_morte_df, '', $data['dia'], $data['mes'], $data['ano'], $data['ano2']);
		$morte_dia= $data['dia'];
		$morte_mes= $data['mes'];
		$morte_ano= $data['ano'];
		$morte_ano2= $data['ano2'];*/
		if ($morte_dia == 0)
			$morte_dia= "";
		if ($morte_mes == 0)
			$morte_mes= "";
		if ($morte_ano == 0)
			$morte_ano= "";
		if ($morte_ano2 == 0)
			$morte_ano2= "";
		//
		$biografia=$row['biografia'];
		$catalogado=$row['catalogado'];
		$atualizado=$row['atualizado'];
		$data_catalog1=convertedata($row['data_catalog1'],'d/m/y - h:i');
		   
		   if($row[data_catalog2]=='0000-00-00 00:00:00')
		     { $data_catalog2='';}
		   if($row[data_catalog2]!='0000-00-00 00:00:00')
		    { $data_catalog2=convertedata($row[data_catalog2],'d/m/y - h:i');}
			}  
}
  ?>
<form name="frmautor" method="post" onSubmit='return valida();' enctype="multipart/form-data">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Autor</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>(Pág.2)</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Biografia</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Bibliografia</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba5" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(5);"><div class="texto" id="abas"><a href="javascript:;" id="link5" onClick="ajustaAbas(5);" onMouseDown="this.click();"><span>Exposição</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba6" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(6);"><div class="texto" id="abas"><a href="javascript:;" id="link6" onClick="ajustaAbas(6);" onMouseDown="this.click();"><span>Obras</span></a></div></td>
	<!-- <td width="100%" align="center" style="border-bottom: 1px solid #34689A;">&nbsp;<? if ($_GET['nomeetiqueta'] <> '') {$URLvolta='cadprev_autor.php';} else {$URLvolta='javascript:history.back();';} echo "<a href='".$URLvolta."'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"?></td> -->
    </tr>
      <td  width="100%" height="100%" colspan="7" valign="center" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="300" border="0" cellpadding="6" cellspacing="3">
		  <tr>
           <td width="700" height="390" valign="top">
			<!-- ABA 1 : Identifica&ccedil;&atilde;o -->
                <div id="quadro1" class="divi1" style="display:; width:540px; overflow: auto;">
                  <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><a href="javascript:abre_manual(2)" class="texto_bold_especial" tabindex="-1">Nome do autor:</a></td>
                      <td colspan="2"><input name="nomeetiqueta" type="text" class="combo_cadastro" id="nomeetiqueta" value="<? echo htmlentities($nomeetiqueta, ENT_QUOTES); ?>" size="65"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><a href="javascript:abre_manual(2)" class="texto_bold_especial" tabindex="-1">Nome de cat&aacute;logo:</a></td>
                      <td colspan="2"><input name="nomecatalogo" type="text" class="combo_cadastro" id="nomecatalogo" value="<? echo htmlentities($nomecatalogo, ENT_QUOTES); ?>" size="65"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td width="14%"><div align="left"></div>                        
                        <div align="right"><u>Nascimento:</u></div>                        <div align="right"></div></td>
                      <td width="14%"><div align="right">Cidade:</div></td>
                      <td width="50%"><input name="cidade_nasc" type="text" class="combo_cadastro" id="cidade_nasc" value="<?  echo htmlentities($cidade, ENT_QUOTES); ?>" size="44" maxlength="150" >
                      </td>
                      <td width="22%" nowrap>Estado:
					  <select name="estado_nasc" class="combo_cadastro" id="estado_nasc" >
					  <? 
					  $sql="SELECT distinct estado,uf from estado order by uf asc";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res=$db->dados())
					  { 
					  ?>  
					      <option value="<? echo $res[0];?>" <? if($estado_nasc==$res[0]) echo "Selected" ?>><? echo $res[1]; ?></option>
					  <? } ?>
					    </select>
				    </td>
                    </tr>
                    <tr class="texto_bold">
                      <td width="14%">&nbsp;</td>
                      <td><div align="right">Pa&iacute;s:</div></td>
                      <td colspan="2">
                      <select name="pais_nasc" class="combo_cadastro" id="pais_nasc" >
					  <? 
					  $sql="SELECT distinct pais,nome from pais order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
					   <option value="<? echo $res[0]; ?>" <? if($pais_nasc==$res[0]) echo "Selected" ?>><? echo $res[1]; ?></option>
					  <? } ?>
                      </select>
                      &nbsp;&nbsp;</td>
                    </tr>
                    <tr class="texto_bold">
                      <td width="14%">&nbsp;</td>
                      <td><div align="right">Sexo:</div></td>
                      <td colspan="2"><select name="sexo" class="combo_cadastro" id="sexo">
                        <option value=""></option>
						<option value="M" <? if($sexo=='M') echo "Selected" ?> >M</option>
                        <option value="F" <? if($sexo=='F') echo "Selected" ?>>F</option>
                        </select>
&nbsp;&nbsp;&nbsp;&nbsp; Naturalizado? Sim
<input name="naturalizado" type="radio" onClick='if(this.checked) { document.getElementById("naturalidade").disabled=false }' value="S" <? if($naturalizado=='S'){ echo "checked"; } ?>>
                    &nbsp;N&atilde;o&nbsp;
                    <input name="naturalizado" type="radio"  onClick='if(this.checked) { document.getElementById("naturalidade").disabled=true }' value="N" <? if($naturalizado=='N'){ echo "checked"; } ?> >
                      </td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Naturalizado em: </div></td>
                      <td colspan="2"><input name="naturalidade" type="text" class="combo_cadastro" id="naturalidade" value="<? echo  htmlentities($naturalidade, ENT_QUOTES); ?>" size="65"></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Data de nascimento:</div></td>
                      <td colspan="2"><input name="dt_nascdia" type="text" class="combo_cadastro" id="dt_nascdia"  onKeyPress="return Numero(event);" value="<? echo $nasc_dia  ?>" size="2" maxlength="2">
&nbsp;
                    <input name="dt_nascmes" type="text" class="combo_cadastro" id="dt_nascmes"   onKeyPress="return Numero(event);" value="<? echo $nasc_mes ?>" size="2" maxlength="2">
&nbsp;
                    <input name="dt_nascano" type="text" class="combo_cadastro" id="dt_nascano"  onKeyPress="return Numero(event);"  value="<? echo $nasc_ano ?>" size="4">
                    -&nbsp;
                    <input name="dt_nasc_extra1" type="text" class="combo_cadastro" id="dt_nasc_extra1"  onKeyPress="return Numero(event);" value="<? echo $nasc_ano2 ?>" size="4">
&nbsp;(
                    <select name="dt_nasc_extra2" class="combo_cadastro">
					  <option value=''></option>
                      <option value="circa" <? if($dt_nasc_tp=='circa') echo "Selected" ?>>circa</option>
                      <option value="?"<? if($dt_nasc_tp=='?') echo "Selected" ?>>?</option>
                    </select>
                    ) </td>
                    </tr>
 

                  </table>
                  <br>
 
              </div>
			<!-- ABA 2 : Página 2 -->
                <div id="quadro2" class="divi1" style="display:none; width:540px; overflow: auto;">
                  <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr class="texto_bold">
                      <td colspan="2">Estados de atua&ccedil;&atilde;o:</td>
                      <td colspan="2" nowrap>                     
					  <input name="estadoatua" type="text" class="combo_cadastro" readonly="true" id="estadoatua" value="<? echo $estadoatua ?>" size="59">
					   <a href='javascript:;' onClick="abrepop('pop_estado.php?estado_atua='+document.frmautor.estadoatua.value); ""><img src="imgs/icons/lupa.gif" title="Selecionar..." border=0 )"></a> </td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2">Pa&iacute;ses de atua&ccedil;&atilde;o:</td>
                      <td colspan="2" nowrap><input name="paisatua" type="text" class="combo_cadastro"  readonly="true "id="paisatua" value="<? echo $paisatua ?>" size="59">
                      <a href='javascript:;' onClick="abrepop('pop_pais.php?pais_atua='+document.frmautor.paisatua.value); ""><img src="imgs/icons/lupa.gif" title="Selecionar..." border=0 )"></a></td>
                    </tr>
                    <tr class="texto_bold">
                      <td align="right"><u>Falecimento:</u></td>
                      <td align="right">Cidade:</td>
                      <td><input name="cidade_morte" type="text" class="combo_cadastro" id="cidade_morte" value="<? echo htmlentities($cidade_morte, ENT_QUOTES); ?>" size="44" maxlength="20"></td>
                      <td nowrap>Estado:
                          <select name="estado_morte" class="combo_cadastro" id="estado_morte">
                          <? 
					  $sql="SELECT distinct estado,uf from estado order by uf asc";
					  $db->query($sql);
					   echo "<option value='0'></option>";
					  while($res=$db->dados())
					  { 
					  ?>
						 <option value="<? echo $res[0];?>" <? if($estado_morte==$res[0]) echo "Selected" ?>><? echo $res[1]; ?></option>
					  <? } ?>
						  </select>
					</td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Pa&iacute;s:</div></td>
                      <td colspan="2"><div align="left">
                     <select name="pais_morte" class="combo_cadastro" id="pais_morte" >
					  <? 
					  $sql="SELECT distinct pais,nome from pais order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
					   <option value="<? echo $res[0];?>"<? if($pais_morte==$res[0]) echo "Selected" ?>><? echo $res[1]; ?></option>
					  <? } ?>
                      </select>
                          </div></td>
                    </tr>
                    <tr class="texto_bold">
                      <td colspan="2"><div align="right">Data de falecimento:</div></td>
                      <td colspan="2"><input name="dt_mortedia" type="text" class="combo_cadastro" id="dt_mortedia"  onKeyPress="return Numero(event);" value="<? echo $morte_dia ?>" size="2" maxlength="2">
&nbsp;
                    <input name="dt_mortemes" type="text" class="combo_cadastro" id="dt_mortemes"  onKeyPress="return Numero(event);"  value="<? echo $morte_mes ?>" size="2" maxlength="2">
&nbsp;
                    <input name="dt_morteano" type="text" class="combo_cadastro" id="dt_morteano"  onKeyPress="return Numero(event);" value="<? echo $morte_ano ?>" size="4" maxlength="4">
                    -&nbsp;
                    <input name="dt_morte_extra1" type="text" class="combo_cadastro" id="dt_morte_extra1"  onKeyPress="return Numero(event);" value="<? echo $morte_ano2 ?>" size="4" maxlength="4">
&nbsp;(
<select name="dt_morte_extra2" class="combo_cadastro" id="dt_morte_extra2">
  <option value=''></option>
  <option value="circa" <? if($dt_morte_extra2=='circa') echo "Selected" ?>>circa</option>
  <option value="?" <? if($dt_morte_extra2=='?') echo "Selected" ?>>?</option>
</select>
                    ) </td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><br>Catalogado por: </td>
                      <td colspan="2" class="texto_bold"><br><input name="catalogado" type="text" readonly="true" class="combo_cadastro" id="catalogado" value="<? echo $catalogado ?>" size="30">
						&nbsp;em: <input name="data_catalog1" type="text" class="combo_cadastro" readonly="true" id="data_catalog1" size="16" value="<? echo $data_catalog1 ?>"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold">Atualizado por: </td>
                      <td colspan="2" class="texto_bold"><input name="atualizado" type="text" readonly="true" class="combo_cadastro" id="atualizado" value="<? echo $atualizado ?>" size="30">
						&nbsp;em: <input name="data_catalog2" readonly="true" type="text" class="combo_cadastro" id="data_catalog2" size="16" value="<? echo $data_catalog2  ?>"></td>
                    </tr>
					</table>

 <table width="540" id="rodape" border="0" style="background-color: #f2f2f2;">
            <tr>
              <td width="83" height="36">&nbsp;</td>
              <td width="149">&nbsp;</td>
              <td width="134" valign="top"><input align='middle' name="submit"  type="submit" class="botao" value="Gravar" <? if ($_REQUEST[nosave] == 1) echo "disabled style='display:none;'"; ?>>
                <input name="op" type="hidden" value="<? echo $op ?>"></td>
              <td width="168">&nbsp;</td>
            </tr>
          </table>

				</div>
                <!-- ABA 3 : Biografia -->
              <div id="quadro3" class="divi1" style="display: none; width:700px; overflow: auto;">
                  <table width="100%"  border="0" cellpadding="6" cellspacing="3" class="texto_bold">
                    <tr>
                      <td width="100%" rowspan="2" align="center" ><textarea name="biografia" cols="120" rows="25" wrap="VIRTUAL" class="combo_cadastro"  id="biografia"><? echo $biografia ?></textarea></td>
                    </tr>
                    <tr>
                      <td width="100%" valign="top">&nbsp;</td>
                    </tr>
                </table>
 
  		      </div> 

               
			  <!-- ABA 4 : BiBliografia -->
			  <div id="quadro4" class="divi1" style="display: none; width:680px; overflow: auto;">
			    <table width="100%"  height="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                      </tr>
                    <tr>
					<? if($_REQUEST['id']<>''){ 
					echo "<iframe name='abas' align='middle' src='bibliografia.php?op_autor=insert&lista=1&autid=$_REQUEST[id]' width='680' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
					} else { ?>
                       <tr>
    	                  <td align="center" class="texto_bold" style="color:#333333;">É necessário salvar o autor <br>para poder incluir uma bibliografia. </td>
        	            </tr>
					<? } ?>
				</table>
              </div>
	      <!-- ABA 5 : Exposição -->  
	      <div id="quadro5" class="divi1" style="display: none; width:700px; overflow: auto;">
		<table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                             
		   <? if ($_REQUEST['id'] <> '') {?>
                                <?echo "<iframe name='abas' align='middle' src='exposicao_autor.php?op_autor=insert&lista=1&autid=$_REQUEST[id]' width='680' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
			} else { ?>
    	                    <td align="center" class="texto_bold" style="color:#333333;">É necessário salvar o autor <br>para poder incluir uma exposição. </td></tr>
		        <? } ?>
                </table>
              </div>
			

			 <!-- ABA 7 : Obras do autor -->  
	       <div id="quadro6" class="divi1" style="display: none; width:700px; overflow: auto;">
	         <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
 		     <?echo "<iframe name='abas' align='middle' src='lista_obras_autor.php?op_autor=insert&lista=1&id=<? echo $_REQUEST[id];?>' width='680' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";?>
                  </table>
                 </div>




			</td>
          </tr>
          </table>
    </table>
</form>
</body>
<? 
   if($_REQUEST['submit']<>'')
      {
	/* $dt_nascano=$_REQUEST['dt_nascano'];
 	$dt_nascmes=$_REQUEST['dt_nascmes'];
 	$dt_nascdia=$_REQUEST['dt_nascdia'];
 	$dt_nasc_extra1=$_REQUEST['dt_nasc_extra1'];
 	dtformato_interno($dt_nascdia, $dt_nascmes, $dt_nascano, $dt_nasc_extra1, '', $data['inicial'], $data['final']);
 	$dt_nasc= $data['inicial'];
 	$dt_nasc_extra1= $data['final'];
 	$dt_nasc_tp=$_REQUEST['dt_nasc_extra2'];*/
 	$dt_nascano=$_REQUEST['dt_nascano'];
 	$dt_nascmes=$_REQUEST['dt_nascmes'];
 	$dt_nascdia=$_REQUEST['dt_nascdia'];
 	$dt_nasc_extra1=$_REQUEST['dt_nasc_extra1'];
 	$dt_nasc_tp=$_REQUEST['dt_nasc_extra2'];
		if ($dt_nascano == "")
			$dt_nascano= 0;
		if ($dt_nascmes == "")
			$dt_nascmes= 0;
		if ($dt_nascdia == "")
			$dt_nascdia= 0;
		if ($dt_nasc_extra1 == "")
			$dt_nasc_extra1= 0;
	//

	/* $dt_morteano=$_REQUEST['dt_morteano'];
 	$dt_mortemes=$_REQUEST['dt_mortemes'];
 	$dt_mortedia=$_REQUEST['dt_mortedia'];
 	$dt_morte_extra1=$_REQUEST['dt_morte_extra1'];
 	dtformato_interno($dt_mortedia, $dt_mortemes, $dt_morteano, $dt_morte_extra1, '', $data['inicial'], $data['final']);
 	$dt_morte= $data['inicial'];
 	$dt_morte_extra1= $data['final'];
 	$dt_morte_tp=$_REQUEST['dt_morte_extra2'];*/
 	$dt_morteano=$_REQUEST['dt_morteano'];
 	$dt_mortemes=$_REQUEST['dt_mortemes'];
 	$dt_mortedia=$_REQUEST['dt_mortedia'];
 	$dt_morte_extra1=$_REQUEST['dt_morte_extra1'];
 	$dt_morte_tp=$_REQUEST['dt_morte_extra2'];
		if ($dt_morteano == "")
			$dt_morteano= 0;
		if ($dt_mortemes == "")
			$dt_mortemes= 0;
		if ($dt_mortedia == "")
			$dt_mortedia= 0;
		if ($dt_morte_extra1 == "")
			$dt_morte_extra1= 0;
 
 	////////////////////////////////////////////////////

 	if($_REQUEST['id']<>'')
 	   { 

  	      $sql="UPDATE autor set
 	      nomeetiqueta='$_REQUEST[nomeetiqueta]', 
 	      nomecatalogo='$_REQUEST[nomecatalogo]', 		
	      cidade_nasc='$_REQUEST[cidade_nasc]',
 	      estado_nasc='$_REQUEST[estado_nasc]',
 	      pais_nasc='$_REQUEST[pais_nasc]',
 	      sexo='$_REQUEST[sexo]',
 	      naturalizado='$_REQUEST[naturalizado]',
 	      naturalidade='$_REQUEST[naturalidade]',
 	      dt_nasc_dia='$dt_nascdia',
 	      dt_nasc_mes='$dt_nascmes',
 	      dt_nasc_ano1='$dt_nascano',
 	      dt_nasc_ano2='$dt_nasc_extra1',
 	      dt_nasc_tp='$dt_nasc_tp',
 	      estadoatua='$_REQUEST[estadoatua]',
 	      paisatua='$_REQUEST[paisatua]',
 	      cidade_morte='$_REQUEST[cidade_morte]',
 	      estado_morte='$_REQUEST[estado_morte]',
 	      pais_morte='$_REQUEST[pais_morte]',
 	      dt_morte_dia='$dt_mortedia',
              dt_morte_mes='$dt_mortemes',
              dt_morte_ano1='$dt_morteano',
              dt_morte_ano2='$dt_morte_extra1',
              dt_morte_tp='$dt_morte_tp',
              biografia='$_REQUEST[biografia]',
              atualizado='$_SESSION[snome]',
              data_catalog2=now() 
              where autor=$_REQUEST[id]";

              $db->query($sql);

              ////////////////Tabela de Log de Atualizacao  //////////////////////////////////////////////////////////

              $obs="Alteração de Autor - Id={".$_REQUEST[id]."} Nome={".$_REQUEST[nomeetiqueta]."}";
              $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','$_REQUEST[id]','0',now(),'$obs')";
              $db->query($sql);
              //////////////////////////////////////////////////////////////////////////////////////////////////////////
              echo "<script>location.href='cadastroautor.php?id=$_REQUEST[id]'</script>";
          }
       else
         {

          //  if($_REQUEST[op]=='insert')
         //   {
	
              $sql="INSERT INTO autor(nomeetiqueta,nomecatalogo,cidade_nasc,estado_nasc,pais_nasc,sexo,naturalizado,
	      naturalidade,dt_nasc_dia,dt_nasc_mes,dt_nasc_ano1,dt_nasc_ano2,dt_nasc_tp,estadoatua,paisatua,
	      cidade_morte,estado_morte,pais_morte,dt_morte_dia,dt_morte_mes,dt_morte_ano1,dt_morte_ano2,dt_morte_tp,
	      biografia,catalogado,data_catalog1)
	 
	      values(
	     '$_REQUEST[nomeetiqueta]',
	     '$_REQUEST[nomecatalogo]',
	     '$_REQUEST[cidade_nasc]',
	     '$_REQUEST[estado_nasc]',
	     '$_REQUEST[pais_nasc]',
	     '$_REQUEST[sexo]',
	     '$_REQUEST[naturalizado]',
	     '$_REQUEST[naturalidade]',
	     '$dt_nascdia',
	     '$dt_nascmes',
	     '$dt_nascano',
	     '$dt_nasc_extra1',
	     '$dt_nasc_tp',
             '$_REQUEST[estadoatua]',
	     '$_REQUEST[paisatua]',
	     '$_REQUEST[cidade_morte]',
	     '$_REQUEST[estado_morte]', 
             '$_REQUEST[pais_morte]',
	     '$dt_mortedia',
	     '$dt_mortemes',
	     '$dt_morteano',
	     '$dt_morte_extra1',
             '$dt_morte_tp',
	     '$_REQUEST[biografia]',
	     '$_SESSION[snome]',now())";	 

              $db->query($sql);	
              $iduser=$db->lastid();


              /////////////////////////////////Tabela de Log de Atualizacao///////////////////////////
              //I=insert
              $obs="Inclusão de Autor - Id={".$iduser."} Nome={".$_REQUEST[nomeetiqueta]."}";
              $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('I','$_SESSION[susuario]','$iduser','0',now(),'$obs')";
              $db->query($sql);
              /////////////////////////////////////////////////////////////
              echo "<script>location.href='cadastroautor.php?id=$iduser'</script>";

     	   }// se ID diferente de nulo

       }// se botão gravar 
?>
