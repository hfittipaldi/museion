<?  include_once("seguranca.php") ?>
<style type="text/css">
<!--
#abas a {
	font-size: 12px;
	font-weight: bold;
	color: #34689A;
	text-decoration: none;
}
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

select {
  behavior: url("js/select_keydown.htc");
}
-->
</style>

<script language="JavaScript">
var txtCombo = '';

      function PrepEvent(evt)
      {
         evt = evt? evt: (window.event? window.event: null);
         if (evt)
         {
            this.charCode = !isNaN(evt.charCode)? evt.charCode: !isNaN(evt.keyCode)? evt.keyCode: evt.which;
            this.keyCode = !isNaN(evt.keyCode)? evt.keyCode: evt.which;
         }
      }

	function chkCombo(pEvent,obj) {
         var evt = new PrepEvent(pEvent);
         var aux = txtCombo;
         switch(evt.keyCode) {
            case 0:
               break;
            case 8: // Backspace
               txtCombo='';
               break;
            case 33: // Page Up
               txtCombo='';
               return 0;
               break;
            case 34: // Page Down
               txtCombo='';
               return 0;
               break;
            case 35: // End
               txtCombo='';
               return 0;
               break;
            case 36: // Home
               txtCombo='';
               return 0;
               break;
            case 38: // Cima
               txtCombo='';
               return 0;
               break;
            case 40: // Baixo
               txtCombo='';
               return 0;
               break;
            case 46: // Del
               txtCombo='';
               break;
            default:
//               if ((evt.charCode > 48 && evt.charCode < 91) || (evt.keyCode == 32)) {
               if (evt.keyCode > 31) {
                  txtCombo+=String.fromCharCode(evt.keyCode);
               } else {
                  return 1;
               }
               break;
            }
            encontrou=false;
            for (x = 0;x < obj.options.length;x++) {
               if (obj.options[x].text.toUpperCase().substring(0,txtCombo.length) == txtCombo) {
                  obj.value=obj.options[x].value;
                  encontrou=true;
                  break;
               }
            }
            return obj.value;
         }




padrao=/^[+-]?((\d+|\d{1,3}(\.\d{3})+)(\,\d*)?|\,\d+)$/;
function testavalor(e)
{
 if(e.value!='')
 {
      OK = padrao.exec(e.value);
 if (!OK){
    window.alert ("Valor numérico inválido!");
	ajustaAbas(1);
	e.value='';
	e.focus();
	return false;
       
 } else {  
   $valor= e.value;
   return true;
    }
}
}
function ajustaAbas(index) {
	numAbas= 7;

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
}
function verificar() {

     for (i=0; i<document.form.length; i++) {
	var tempobj= document.form.elements[i];

     if ((tempobj.type=='text' && tempobj.value!='') || (tempobj.name=='colecao' && tempobj.value!='')|| (tempobj.name=='autor' && tempobj.value!='')
	|| (tempobj.name=='destaque' && tempobj.value!='')|| (tempobj.name=='moldura' && tempobj.value!='')|| (tempobj.name=='base' && tempobj.value!='')
	|| (tempobj.name=='pasp' && tempobj.value!='')|| (tempobj.name=='foto' && tempobj.value!='')
	|| (tempobj.name=='localizada' && tempobj.value!='')|| (tempobj.name=='estado_conserv' && tempobj.value!='')
	|| (tempobj.name=='forma_aquisicao' && tempobj.value!='') || (tempobj.name=='local_fixo' && tempobj.value!='') || (tempobj.name=='expo_pais' && tempobj.value!='') || (tempobj.name=='expo_estado' && tempobj.value!='') || (tempobj.name=='exprop' && tempobj.value!='')
        || (tempobj.name=='temfoto' && tempobj.value!='') || (tempobj.name=='temnegativo' && tempobj.value!='') || (tempobj.name=='temdiapositivo' && tempobj.value!='') || (tempobj.name=='temrestauro' && tempobj.value!='') || (tempobj.name=='periodo' && tempobj.value!='')
        || (tempobj.name=='multi_autor' && tempobj.value!='') || (tempobj.name=='outras_inscr' && tempobj.value!='') || (tempobj.name=='atribuida' && tempobj.value!='')
        || (tempobj.name=='dim_obra_altura_ini' && tempobj.value!='') || (tempobj.name=='dim_obra_largura_ini' && tempobj.value!='') || (tempobj.name=='dim_obra_diametro_ini' && tempobj.value!='') || (tempobj.name=='dim_obra_profundidade_ini' && tempobj.value!='') || (tempobj.name=='dim_obra_peso_ini' && tempobj.value!='')
        || (tempobj.name=='aimp_obra_altura_ini' && tempobj.value!='')|| (tempobj.name=='aimp_obra_largura_ini' && tempobj.value!='') || (tempobj.name=='aimp_obra_diametro_ini' && tempobj.value!='')
	|| (tempobj.name=='dim_obra_altura_fim' && tempobj.value!='') || (tempobj.name=='aimp_obra_altura_fim' && tempobj.value!='')|| (tempobj.name=='dim_obra_largura_fim' && tempobj.value!='')|| (tempobj.name=='aimp_obra_largura_fim' && tempobj.value!='')|| (tempobj.name=='dim_obra_diametro_fim' && tempobj.value!='')
	|| (tempobj.name=='aimp_obra_diametro_fim' && tempobj.value!='')|| (tempobj.name=='dim_obra_profundidade_fim' && tempobj.value!='')|| (tempobj.name=='dim_obra_peso_fim' && tempobj.value!=''))
{
    return true;  
}
	}
	alert('Informe pelo menos um parâmetro de busca.');
	return false;
}
function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-125)+',top='+((window.screen.height/2)-150)+',width=350,height=370, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}
function abrepop2(janela,alt,larg)
{
 var h=screen.height-100,w=screen.width-50;
 
  win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
 return true;
}
function abrepopAutor(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-230)+',top='+((window.screen.height/2)-200)+',width=460,height=400, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
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
<body onLoad='ajustaAbas(<? echo $aba ?>);'>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
montalinks();
$_SESSION['lnk']=$link;
// limpa variavel de sessao de obras marcadas para impressao //
$_SESSION['s_impressao']= "";
$_SESSION['s_imp_total']= 0;
////
$op=$_REQUEST['op'];
$captiont=$REQUEST['captiont'];
$id_obra_altura_fim = $_REQUEST[id_obra_altura_fim];
echo "<br>";
?>
    </div></th>
  </tr>
 
<form name="form" method="get" action="obraconsulta1.php"  onSubmit="return verificar()" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="96" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Classifica&ccedil;&atilde;o</span></a></div></td>
      <td width="99" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Caracter&iacute;sticas</span></a></div></td>
      <td width="78" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Textos</span></a></div></td>
      <td width="96" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Proced&ecirc;ncia</span></a></div></td>
      <td width="96" align="center" valign="bottom" id="aba5" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(5);"><div class="texto" id="abas"><a href="javascript:;" id="link5" onClick="ajustaAbas(5);" onMouseDown="this.click();"><span>Identifica&ccedil;&atilde;o</span></a></div></td>
      <td width="96" align="center" valign="bottom" id="aba6" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(6);"><div class="texto" id="abas"><a href="javascript:;" id="link6" onClick="ajustaAbas(6);" onMouseDown="this.click();"><span>Exposição</span></a></div></td>
      <td width="96" align="center" valign="bottom" id="aba7" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(7);"><div class="texto" id="abas"><a href="javascript:;" id="link7" onClick="ajustaAbas(7);" onMouseDown="this.click();"><span>Dimens&otilde;es</span></a></div></td>
    </tr>
      <td colspan="7" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="310" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td>
			<!-- ABA 1 : Classificacao -->

                <div id="quadro1" class="divi1" style="display:; width:540px; ">
                  <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Cole&ccedil;&atilde;o:</div></td>
                      <td width="83%" colspan="2"><input name="colecao" type="text" class="combo_cadastro"  readonly="true" id="colecao" size="70">
                      <span class="texto_bold"><a href='javascript:;' onClick="abrepop('pop_colecao.php?colecao='+document.form.colecao.value);""><img src="imgs/icons/lupa.gif" title="Selecionar..." border="0"></a>
                      <input name="idcolecoes" type="hidden" id="idcolecoes">
                      </span></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Autor:</div></td>
                      <td colspan="2" nowrap><select name="autor" class="combo_cadastro" id="autor" onKeyUp="chkCombo(event,this);" onBlur="txtCombo = '';">
                        <? 
					  $sql="select autor,nomeetiqueta from autor order by nomeetiqueta asc";
					  $db->query($sql);
					  echo "<option value='' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
                        <option  value="<? echo $res[0];?>"><? echo $res[1]; ?></option>
                        <? } ?>
                      </select> <a href='javascript:;' onClick="abrepopAutor('pop_autor.php');""><img src="imgs/icons/lupa.gif" title="Pesquisar..."  border="0"></a></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">T&iacute;tulo:</div></td>
                      <td colspan="2"><input name="titulo" type="text" class="combo_cadastro" id="titulo" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Tema:</div></td>
                      <td colspan="2"><input name="tema" type="text" class="combo_cadastro"  readonly="true" id="tema" size="70">
                      <span class="texto_bold"><a href='javascript:;' onClick="abrepop('pop_tema.php?consultaobra=1&tema='+document.form.tema.value);""><img src="imgs/icons/lupa.gif" title="Selecionar..."  border="0"></a>
                      <input name="idtemas" type="hidden" id="idtemas">
                      </span></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Sub-Temas:</div></td>
                      <td colspan="2"><input name="sub_tema" type="text" class="combo_cadastro" id="sub_tema" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Movimento:</div></td>
                      <td colspan="2"><input name="movimento" type="text" class="combo_cadastro" id="movimento" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Estilo:</div></td>
                      <td colspan="2"><input name="estilo" type="text" class="combo_cadastro" id="estilo" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Escola:</div></td>
                      <td colspan="2"><input name="escola" type="text" class="combo_cadastro" id="escola" size="70"></td>
                    </tr>
                  </table>
              </div>
                <!-- ABA 2 : Biografia -->
              <div id="quadro2" class="divi1" style="display: ; width:540px; ">
                  <table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="4" class="texto_bold">Data da obra: 
					&nbsp;&nbsp;Entre os anos de:
<input type="text" class="combo_cadastro" name="deAnoParte" size="6" style="text-align: right;">
e
<input type="text" class="combo_cadastro" name="ateAnoParte" size="6"></td>
                    </tr>
                    <tr>
                      <td width="736" colspan="4" class="texto_bold">Material/
                        t&eacute;cnica:
                        <input name="material_tecnica" type="text" class="combo_cadastro" id="material_tecnica" size="40"></td>
                    </tr>
                    <tr>
                      <td colspan="4" class="texto_bold">Objeto:
                      <input name="objeto" type="text" class="combo_cadastro" id="objeto" size="40"></td>
                    </tr>
                    <tr>
                      <td class="texto_bold" nowrap>Destaque do acervo?
                        <select name="destaque" class="combo_cadastro" id="destaque">
                          <option value=""></option>
                          <option value="S">SIM</option>
                          <option value="N">NAO</option>
                        </select>
		        &nbsp;&nbsp;Per&iacuteodo:&nbsp;<input name="periodo" type="text" class="combo_cadastro" id="periodo" size="20">
		     </td>
                    </tr>
                    <tr>
                      <td colspan="4" class="texto_bold" nowrap>Moldura? 
                        <select name="moldura" class="combo_cadastro" id="moldura">
                          <option value=""></option>
                          <option value="S">SIM</option>
                          <option value="N">NAO</option>
                        </select>
                      &nbsp;&nbsp;&nbsp;Base?
                      <select name="base" class="combo_cadastro" id="base">
                        <option value=""></option>
                        <option value="S">SIM</option>
                        <option value="N">NAO</option>
                      </select>
                      &nbsp;&nbsp;Passe-partout?
                      <select name="pasp" class="combo_cadastro" id="pasp">
                        <option value=""></option>
                        <option value="S">SIM</option>
                        <option value="N">NAO</option>
                      </select>
                      &nbsp;&nbsp;Imagens?
                      <select name="foto" class="combo_cadastro" id="foto">
                        <option value=""></option>
						<option value="S">SIM</option>
                        <option value="N">NAO</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="4" class="texto_bold" nowrap>Foto? 
                        <select name="temfoto" class="combo_cadastro" id="temfoto">
                          <option value=""></option>
                          <option value="S">SIM</option>
                          <option value="N">NAO</option>
                        </select>
                      &nbsp;&nbsp;&nbsp;Negativo?
                      <select name="temnegativo" class="combo_cadastro" id="temnegativo">
                        <option value=""></option>
                        <option value="S">SIM</option>
                        <option value="N">NAO</option>
                      </select>
                      &nbsp;&nbsp;Diapositivo?
                      <select name="temdiapositivo" class="combo_cadastro" id="temdiapositivo">
                        <option value=""></option>
                        <option value="S">SIM</option>
                        <option value="N">NAO</option>
                      </select>
                      &nbsp;&nbsp;Restauro?
                      <select name="temrestauro" class="combo_cadastro" id="temrestauro">
                        <option value=""></option>
			<option value="S">SIM</option>
                        <option value="N">NAO</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="4" class="texto_bold" nowrap>Local de Produ&ccedil;&atilde;o: 
                        <input name="local" type="text" class="combo_cadastro" id="local" size="40"> 
                      &nbsp;Identificado?
                      <select name="localizada" class="combo_cadastro" id="localizada">
                        <option value=""></option>
                        <option value="S">SIM</option>
                        <option value="N">NAO</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="texto_bold" nowrap>Estado de Conserva&ccedil;&atilde;o:
                        <select name="estado_conserv" class="combo_cadastro" id="estado_conserv" >
                          <? 
					  $sql="select  estado_conserv,descricao from estado_conserv";
					  $db->query($sql);
					  echo "<option value='' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
                          <option value="<? echo $res[0];?>"><? echo $res[1]; ?></option>
                          <? } ?>
                        </select>
                      &nbsp;&nbsp;Multi Autoria?&nbsp;
                        <select name="multi_autor" class="combo_cadastro" id="multi_autor">
                          <option value=""></option>
                          <option value="S">SIM</option>
                          <option value="N">NAO</option>
                        </select>
			&nbsp;&nbsp;Atribu&iacute;da?&nbsp;
                        <select name="atribuida" class="combo_cadastro" id="atribuida">
                          <option value=""></option>
                          <option value="S">SIM</option>
                          <option value="N">NAO</option>
                        </select>
                    </tr>
                  </table>
              </div>     
			  <!-- ABA 3 : Textos -->
			  <div id="quadro3" class="divi1" style="display: ; width:540px; ">
<table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Observa&ccedil;&otilde;es:</div></td>
                      <td width="166%" colspan="2"><input name="obs" type="text" class="combo_cadastro" id="obs" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Descri&ccedil;&atilde;o
                          de conte&uacute;do:</div></td>
                      <td colspan="2"><input name="desc_conteudo" type="text" class="combo_cadastro" id="desc_conteudo" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Descri&ccedil;&atilde;o
                      formal: </div></td>
                      <td colspan="2"><input name="descr_formal" type="text" class="combo_cadastro" id="descr_formal" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Referência bibliográfica: </div></td>
                      <td colspan="2"><input name="ref_biblio" type="text" class="combo_cadastro" id="ref_biblio" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Autoria: </div></td>
                      <td colspan="2"><input name="ref_autor" type="text" class="combo_cadastro" id="ref_autor" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Outras Inscri&ccedil;&otilde;es: </div></td>
                      <td colspan="2"><input name="outras_inscr" type="text" class="combo_cadastro" id="outras_inscr" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold">&nbsp;</td>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                  </table>
              </div>
				 <div id="quadro4" class="divi1" style="display:; width:540px; ">
			    <table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Per&iacute;odo
                      de aquisi&ccedil;&atilde;o: </div></td>
                      <td width="81%" colspan="2" class="texto_bold">Entre os anos de:
<input type="text" class="combo_cadastro" name="deAno" size="6" style="text-align: right;">
e
<input type="text" class="combo_cadastro" name="ateAno" size="6"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Forma
                      de aquisi&ccedil;&atilde;o :</div></td>
                      <td colspan="2"><select name="forma_aquisicao" class="combo_cadastro" id="forma_aquisicao" >
                        <? 
					  $sql="select forma_aquisicao,nome from forma_aquisicao";
					  $db->query($sql);
					  echo "<option value='' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
                        <option value="<? echo $res[0];?>"><? echo $res[1]; ?></option>
                        <? } ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Localização Fixa :</div></td>
                      <td colspan="2"><select name="local_fixo" class="combo_cadastro" id="local_fixo" >
                        <? 
					  $sql="select local,nome from local";
					  $db->query($sql);
					  echo "<option value='' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
                        <option value="<? echo $res[0];?>"><? echo $res[1]; ?></option>
                        <? } ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Impressor:</div></td>
                      <td colspan="2"><input name="impressor" type="text" class="combo_cadastro" id="impressor" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Editor:</div></td>
                      <td colspan="2"><input name="editor" type="text" class="combo_cadastro" id="editor" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Ex Proprietário:</div></td>
                      <td colspan="2"><input name="exprop" type="text" class="combo_cadastro" id="exprop" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Doador:</div></td>
                      <td colspan="2"><input name="doador" type="text" class="combo_cadastro" id="doador" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"></div></td>
                      
                    </tr>
                </table>
                  <!-- ABA 5 : Identificacao -->
			  </div>
			  <div id="quadro5" class="divi1" style="display: ; width:540px; ">
                    <table width="95%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                    <tr width="100%" >
                      <td   width="8%" class="texto_bold"><div align="right">N&ordm; de registro: </div></td>
                      <td width="10%" ><input name="num_registro" type="text" class="combo_cadastro" id="num_registro" size="20"></td>
                    </tr>
                     <tr width="100%" >
                      <td  width="8%" class="texto_bold"><div align="right">Lista de registros: </div></td>
                      <td width="10%"><input name="lista_registro" type="text" class="combo_cadastro" id="num_registro" size="20"></td>
                    </tr>
                    <tr width="100%" >
                      <td  width="8%" class="texto_bold"><div align="right">Registros de:</div></td>
                      <td width="10%" ><input name="num_registro_de" type="text" class="combo_cadastro" id="num_registro_de" size="20"></td>
                      <td width="5%"   class="texto_bold" ><div align="center"> até:</div></td>
                      <td width="13%" ><input name="num_registro_ate" type="text" class="combo_cadastro" id="num_registro_ate" size="20"></td>

                    </tr>
                    <tr width="100%" >
                      <td   width="8%" class="texto_bold"><div align="right">N&ordm;de invent&aacute;rio: </div></td>
                      <td   width="10%"><input name="inventario" type="text" class="combo_cadastro" id="inventario" size="20"></td>
                    </tr>
                    <tr width="100%" >
                      <td   width="8%" class="texto_bold"><div align="right">Controle Inv.: </div></td>
                      <td    width="10%"><input name="ctrlinv" type="text" class="combo_cadastro" id="ctrlinv" size="20"></td>
                    </tr>
                    <tr width="100%" >
                      <td   width="8%" class="texto_bold"><div align="right">N&ordm;do processo: </div></td>
                      <td  width="10%" ><input name="num_processo" type="text" class="combo_cadastro" id="num_processo" size="20"></td>
                    </tr>
                    <tr>
                      <td   width="8%" class="texto_bold"><div align="right">N&ordm; de edi&ccedil;&atilde;o: </div></td>
                      <td   width="10%"><input name="num_edicao" type="text" class="combo_cadastro" id="num_edicao" size="20"></td>
                    </tr>
                    <tr width="100%" >
                      <td   width="8%" class="texto_bold"><div align="right">N&ordm; de s&eacute;rie: </div></td>
                      <td   width="10%"><input name="num_serie" type="text" class="combo_cadastro" id="num_serie" size="20"></td>
                    </tr>
                     </table>
			  </div>
				 <div id="quadro6" class="divi1" style="display:; width:540px; ">
			    <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Data do início: </div></td>
                      <td width="81%" colspan="2" class="texto_bold"><input type="text" class="combo_cadastro" name="expo_ini" size="10" maxlength="10" style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;Data do fim: <input type="text" class="combo_cadastro" name="expo_fim" size="10" maxlength="10" style="text-align: right;"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Nome: </div></td>
                      <td colspan="2"><input name="expo_nome" type="text" class="combo_cadastro" id="expo_nome" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Instituição: </div></td>
                      <td colspan="2"><input name="expo_ins" type="text" class="combo_cadastro" id="expo_ins" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">País :</div></td>
                      <td colspan="2"><select name="expo_pais" class="combo_cadastro" id="expo_pais" >
                        <? 
					  $sql="SELECT distinct pais,nome from pais order by nome asc";
					  $db->query($sql);
					  echo "<option value='' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
                        <option value="<? echo $res[0];?>"><? echo $res[1]; ?></option>
                        <? } ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Estado :</div></td>
                      <td colspan="2"><select name="expo_estado" class="combo_cadastro" id="expo_estado" >
                        <? 
					  $sql="SELECT distinct estado,nome from estado order by uf asc";
					  $db->query($sql);
					  echo "<option value='' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
                        <option value="<? echo $res[0];?>"><? echo $res[1]; ?></option>
                        <? } ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Período: </div></td>
                      <td colspan="2"><input name="expo_periodo" type="text" class="combo_cadastro" id="expo_periodo" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Prêmio: </div></td>
                      <td colspan="2"><input name="expo_premio" type="text" class="combo_cadastro" id="expo_premio" size="70"></td>
                    </tr>
                </table>
		</div>
		<div id="quadro7" class="divi1" style="display: ; width:540px; ">
                    <table width="100%" border="0" cellpadding="1" cellspacing="4" bgcolor="#f2f2f2">
                    <tr class="texto_bold"><td colspan="2">Dimensões da Obra:</td></tr>         			
                      <td colspan="0" class="texto_bold "> <div align="right">altura entre:</div></td>
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_altura_ini" type="text"class="combo_cadastro"id="dim_obra_altura_ini" onChange="return testavalor(this);" size=2>&nbsp;cm
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_altura_fim" type="text"class="combo_cadastro"id="dim_obra_altura_fim" onChange="return testavalor(this);" size=2>&nbsp;cm			
                      <td colspan="0" class="texto_bold"> <div align="right">Largura entre:</div></td>
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_largura_ini" type="text"class="combo_cadastro"id="dim_obra_largura_ini" onChange="return testavalor(this);" size=2>&nbsp;cm
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_largura_fim" type="text"class="combo_cadastro"id="dim_obra_largura_fim" onChange="return testavalor(this);" size=2>&nbsp;cm
		      <tr>
                      <td colspan="0" class="texto_bold"><div align="right">Diâmentro entre:</div></td>
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_diametro_ini" type="text"class="combo_cadastro"id="dim_obra_diametro_ini" onChange="return testavalor(this);" size=2>&nbsp;cm
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_diametro_fim" type="text"class="combo_cadastro"id="dim_obra_diametro_fim" onChange="return testavalor(this);" size=2>&nbsp;cm
	
                      <td colspan="0" class="texto_bold"><div align="right">Profundidade entre:</div></td>
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_profundidade_ini" type="text"class="combo_cadastro"id="dim_obra_profundidade_ini" onChange="return testavalor(this);" size=2>&nbsp;cm
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_profundidade_fim" type="text"class="combo_cadastro"id="dim_obra_profundidade_fim" onChange="return testavalor(this);" size=2>&nbsp;cm
		      </tr>
                      <tr>
                      <td colspan="0" class="texto_bold"><div align="right">Peso entre:</div></td>
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_peso_ini" type="text"class="combo_cadastro"id="dim_obra_peso_ini" onChange="return testavalor(this);" size=2>&nbsp;kg
                      <td colspan="0" class="texto_bold"> <input name="dim_obra_peso_fim" type="text"class="combo_cadastro"id="dim_obra_peso_fim" onChange="return testavalor(this);" size=2>&nbsp;kg 
		   </tr>
		    <tr class="texto_bold"><td colspan="2">&Aacute;rea Impressa:</td> 
		    <td colspan="2"></td>
		   <!-- retirado para desenvolver depois ver com Gilson <td colspan="2">Operação

                      <select name="operacao" class="combo_cadastro" id "operacao" value="<?$_REQUEST['captiont'];?>">
          		<option value="E"<?if ($captiont==E) echo "selected";?>>entre</option>
	  		<option value="P"<?if ($captiont==I) echo "selected";?>>a pardir de</option>
          		<option value="A"<?if ($captiont==A) echo "selected";?>>antes de</option>
        	      </select>

		   </td>-->
                    <tr>
		      <tr>	
                      <td colspan="0" class="texto_bold"> <div align="right">Altura entre:</div></td>
                      <td colspan="0" class="texto_bold"> <input name="aimp_obra_altura_ini" type="text"class="combo_cadastro"id="aimp_obra_altura_ini" onChange="return testavalor(this);" size=2>&nbsp;cm
                      <td colspan="0" class="texto_bold"> <input name="aimp_obra_altura_fim" type="text"class="combo_cadastro"id="aimp_obra_altura_fim" size=2>&nbsp;cm	
    		      <td valign="top" class="texto"><form name="form2" method="get" action="logsistema.php"
		      </tr>
                      <tr>
		      <td colspan="0" class="texto_bold"><div align="right">Largura entre:</div></td>
                      <td colspan="0" class="texto_bold"> <input name="aimp_obra_largura_ini" type="text"class="combo_cadastro"id="aimp_obra_largura_ini" onChange="return testavalor(this);" size=2>&nbsp;cm
                      <td colspan="0" class="texto_bold"> <input name="aimp_obra_largura_fim" type="text"class="combo_cadastro"id="aimp_obra_largura_fim" onChange="return testavalor(this);" size=2>&nbsp;cm
		      </tr>
		      <tr>
                      <td colspan="0" class="texto_bold"><div align="right">Diâmetro entre:</div></td>
                      <td colspan="0" class="texto_bold"> <input name="aimp_obra_diametro_ini" type="text"class="combo_cadastro"id="aimp_obra_diametro_ini" onChange="return testavalor(this);" size=2>&nbsp;cm
                      <td colspan="0" class="texto_bold"> <input name="aimp_obra_diametro_fim" type="text"class="combo_cadastro"id="aimp_obra_diametro_fim" onChange="return testavalor(this);" size=2>&nbsp;cm


		      </tr>
		      <tr>	


		     </tr>
                    </tr>
                    </tr>
                </table>
		</div>
			</td>
          </tr>


        </table>
          <table width="540" id="rodape" border="0" style="background-color: #f2f2f2;">
            <tr>
              <td width="83">&nbsp;</td>
              <td width="149">&nbsp;</td>
              <td width="134" valign="top"><input name="ok"  type="submit" class="botao" id="ok" value="Pesquisar" align='middle' <? if ($_REQUEST[nosave] == 1) echo "disabled style='display:none;'"; ?>>
		<input name="captiont" type="hidden" value="<?$op?>"><br></td>
              <td width="168">&nbsp;</td>
            </tr>
          </table>
  </table>
</form>
</body>

