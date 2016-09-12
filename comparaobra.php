<? include_once("seguranca.php") ?>
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
{
    return true;  
}
	}
	alert('Informe pelo menos um parâmetro de busca.');
	return false;
}
function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-125)+',top='+((window.screen.height/2)-150)+',width=280,height=300, scrollbars=no, resizable=no');
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
echo "<br>";
?>
    </div></th>
  </tr>
 
<form name="form" method="get" action="obraconsulta1.php"  onSubmit="return verificar()" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0">
      <td colspan="7" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="315" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td>
			<!-- ABA 1 : Classificacao -->

                <div id="quadro1" class="divi1" style="display:; width:540px; ">
                  <table width="70%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                     <tr>
                      <td colspan="2" class="texto_bold"><div align="right">T&iacute;tulo:</div></td>
                      <td colspan="2"><input name="titulo" type="text" class="combo_cadastro" id="titulo" size="70"></td>
                    </tr>
                    <tr>
                     </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Sub-Temas:</div></td>
                      <td colspan="2"><input name="sub_tema" type="text" class="combo_cadastro" id="sub_tema" size="70"></td>
                    </tr>
                   </table>
              </div>
                <!-- ABA 2 : Biografia -->
              <div id="quadro2" class="divi1" style="display: ; width:540px; ">
                  <table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td width="736" colspan="4" class="texto_bold">Material/
                        t&eacute;cnica:
                        <input name="material_tecnica" type="text" class="combo_cadastro" id="material_tecnica" size="40"></td>
                    </tr>
                  </table>
              </div>                
			  <!-- ABA 3 : Textos -->
			  <div id="quadro3" class="divi1" style="display: ; width:540px; ">
                          <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                             <tr>
                               <td colspan="2" class="texto_bold"><div align="right">Descri&ccedil;&atilde;o
                                  de conte&uacute;do:</div></td>
                                  <td colspan="2"><input name="desc_conteudo" type="text" class="combo_cadastro" id="desc_conteudo" size="70"></td>
                            </tr>
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

