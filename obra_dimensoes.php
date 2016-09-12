<? include_once("seguranca.php") ?>
<html>
<head>
<title>Pesquisa de Obras por Dimensões</title>
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

function abrepopAutor(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-230)+',top='+((window.screen.height/2)-200)+',width=460,height=400, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}

function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-125)+',top='+((window.screen.height/2)-150)+',width=280,height=300, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}

function verificar() {

     if (document.form.dimIni.value =='')
     {
	alert('Informe a Dimensão Inicial.');
	return false;
     }

     if (document.form.dimFim.value =='')
     {
	alert('Informe a Dimensão Final.');
	return false;
     }

     if (document.form.dimConsulta.value =='')
     {
	alert('Informe a Dimensão a verificar.');
	return false;
     }

     if ((document.form.colecao.value =='') && (document.form.autor.value ==''))
     {
	alert('Informe Coleção ou Autor.');
	return false;
     }
	
     return true;
}

</script>

</head>

<body>

<?
// limpa variavel de sessao de obras marcadas para impressao 

$_SESSION['s_impressao']= "";
$_SESSION['s_imp_total']= 0;

?>

<form name="form" method="get" action="obra_dimensoes_1.php"  onSubmit="return verificar()" enctype="multipart/form-data">
<table width="500" border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col">
        <div align="left" class="tit_interno">
<? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
montalinks();
$_SESSION['lnk']= $link;
?>
       </div>
    </th>
  </tr>
  <tr><td>
               <table border="0" align="center" cellpadding="5" cellspacing="2" bgcolor=#f2f2f2>
                    <tr>
                      <td colspan="1" class="texto_bold"><div align="right">Autor:</div></td>
                      <td colspan="1" nowrap><select name="autor" class="combo_cadastro" id="autor" onKeyUp="chkCombo(event,this);" onBlur="txtCombo = '';">
                        <? 
					  $sql="select autor,nomeetiqueta from autor order by nomeetiqueta asc";
					  $db->query($sql);
					  echo "<option value='' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
                        <option  value="<? echo $res[0];?>"><? echo $res[1]; ?></option>
                        <? } ?>
                      </select> <a href='javascript:;' onClick="abrepopAutor('pop_autor.php');""><img src="imgs/icons/lupa.gif" title="Pesquisar..." width="27" border=0 height="16")"></a></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Cole&ccedil;&atilde;o:</div></td>
                      <td width="70%" colspan="1"><input name="colecao" type="text" class="combo_cadastro"  readonly="true" id="colecao" size="60">
                      <span class="texto_bold"><a href='javascript:;' onClick="abrepop('pop_colecao.php');""><img src="imgs/icons/lupa.gif" title="Selecionar..." width="27" border=0 height="16")"></a>
                      <input name="idcolecoes" type="hidden" id="idcolecoes">
                      </span></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Consulta por:</div></td>
                      <td width="70%" colspan="1">
                             <select name="dimConsulta" class="combo_cadastro">
				<option value=1>Altura</option>
                                <option value=2>Largura</option>
                                <option value=3>Profundidade</option>
                             </select>
                      </td>
                    </tr>
                      <td colspan="2" class="texto_bold"><div align="right">Medidas</div></td>
                      <td width="70%" colspan="1">
                             Dimens&otilde;es entre <input  type="text" size=4 name="dimIni" class="combo_cadastro">cm
                             &nbsp;e&nbsp;&nbsp;<input  type="text" size=4 name="dimFim"class="combo_cadastro">cm
                      </td>
                    </tr>

         </table>
         <table id="rodape" border="0" style="background-color: #f2f2f2;">
            <tr>
              <td width="70">&nbsp;</td>
              <td width="130">&nbsp;</td>
              <td width="120" valign="top"><input name="ok"  type="submit" class="botao" id="ok" value="Pesquisar" align='middle'>
              <td width="150">&nbsp;</td>
            </tr>
          </table>
 </td></tr>
</table>
</form>
</body>
</html>