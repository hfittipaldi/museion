<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style type="text/css">
.box {
	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
	background-color: #cccccc;
}
</style>
<script>
var alterouCampo= 0;
function checaAlteracao() {
	if (alterouCampo) {
		if (confirm('O formulário foi alterado. Para salvar clique em Cancelar e depois Gravar. Clicando em OK a alteração será perdida.\n\nTem certeza que deseja prosseguir para o formulário de objeto agora?'))
			location.href= 'parte_obra1_reserva.php?op=update&obra=<? echo $_REQUEST[obra] ?>&parte=<? echo $_REQUEST[parte] ?>';
	}
	else
		location.href= 'parte_obra1_reserva.php?op=update&obra=<? echo $_REQUEST[obra] ?>&parte=<? echo $_REQUEST[parte] ?>';
}
padrao=/^\d+(,|.\d+)?$/;
function testavalor(e)
{
 if(e.value!='')
 {
      OK = padrao.exec(e.value);
 if (!OK){
    window.alert ("Valor numérico inválido\n Utilize apenas duas casas decimais separados por vírgula ou ponto.");
	return false;
       
 } else { 
	alterouCampo = 1;
   return true;
    }
}
}
function abre_manual(parametro)
{
  	win=window.open('manual_catalog.php?corfundo=cccccc&parametro='+parametro,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-130)+',height=365,width=560,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>
</head>
<body>      
<table width="500" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr>
    <td valign="top"><form name="form1" method="post" onSubmit="" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$op=$_REQUEST['op'];
 if(isset($_REQUEST[obra])) {
  if($op=='update'){
    $sql="SELECT a.* from parte as a where a.obra='$_REQUEST[obra]' and parte='$_REQUEST[parte]'";
	$db->query($sql);
    $res=$db->dados();}
 }
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4"  class="texto_bold">
        <tr class="texto_bold">
          <td><div align="left"><u>Da parte:</u></div></td>
          <td>&nbsp;</td>
          <td align="right"><a href='javascript:checaAlteracao();' style='color:navy;'>Objeto</a>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td colspan="3">Peso</a>:&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="dim_parte_peso" type="text" class="texto" id="dim_parte_peso" onChange="return testavalor(this);" value="<?  echo number_format($res[dim_parte_peso],2,',','.');?>" size="5">&nbsp;kg
 </td>
        <tr class="texto_bold">
          <td width="20%"><div align="right"></div></td>
          <td width="24%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
          <td width="31%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="left"><u>Da moldura: </u></div></td>
          <td colspan="3">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Possui moldura?</a></div></td>
          <td colspan="2"><input name="dim_mold_possui" type="radio" value="S" <? if($res['dim_mold_possui']=='S') echo "checked" ?> onChange="alterouCampo = 1;">
            SIM 
            <input name="dim_mold_possui" type="radio" value="N" <? if($res['dim_mold_possui']=='N') echo "checked" ?> onChange="alterouCampo = 1;">
            N&Atilde;O</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Altura:</a></div></td>
          <td colspan="3"><input name="dim_mold_altura" type="text" onChange="return testavalor(this);" class="texto" value="<?  echo number_format($res[dim_mold_altura],2,',','.');?>" id="dim_mold_altura" size="5">
            cm            &nbsp;&nbsp;            &nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Largura:</a>
            <input name="dim_mold_largura" type="text" class="texto" onChange="return testavalor(this);" id="dim_mold_largura" value="<?  echo number_format($res[dim_mold_largura],2,',','.');?>" size="5">
            cm
            &nbsp;&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Di&acirc;metro:</a>            
            <input name="dim_mold_diametro"   onChange="return testavalor(this);" value="<?  echo number_format($res[dim_mold_diametro],2,',','.');?>" type="text" class="texto" id="dim_mold_diametro" size="5">
            cm</td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Profundidade:</a></div></td>
          <td colspan="3"><input name="dim_mold_profund" type="text"  onChange="return testavalor(this);" class="texto" id="dim_mold_profund"  value="<?  echo number_format($res[dim_mold_profund],2,',','.');?>" size="5">
            cm
&nbsp;            &nbsp;&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Peso:</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="dim_mold_peso" type="text" class="texto" onChange="return testavalor(this);" id="dim_mold_peso" value="<?  echo number_format($res[dim_mold_peso],2,',','.');?>" size="5">
            kg</td>
          </tr>
        <tr class="texto_bold">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="left"><u>Da base:</u></div></td>
          <td colspan="3">&nbsp;</td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Possui base?</a></div></td>
          <td colspan="2"><input name="dim_base_possui" type="radio" value="S" <? if($res['dim_base_possui']=='S') echo "checked" ?> onChange="alterouCampo = 1;">
SIM
<input name="dim_base_possui" type="radio" value="N" <? if($res['dim_base_possui']=='N') echo "checked" ?> onChange="alterouCampo = 1;">
N&Atilde;O</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Altura:</a></div></td>
          <td colspan="2" nowrap>
            <input name="dim_base_altura" type="text" class="texto"  onChange="return testavalor(this);" id="dim_base_altura" value="<?  echo number_format($res[dim_base_altura],2,',','.');?>" size="5">
            cm
            &nbsp;&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Largura:</a>
            <input name="dim_base_largura" type="text" class="texto"  onChange="return testavalor(this);" id="dim_base_largura" value="<?  echo number_format($res[dim_base_largura],2,',','.');?>" size="5">
            cm
&nbsp;&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Di&acirc;metro:</a>&nbsp;
<input name="dim_base_diametro" type="text" class="texto" onChange="return testavalor(this);" id="dim_base_diametro" value="<?  echo number_format($res[dim_base_diametro],2,',','.');?>" size="5">
cm</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Profundidade:</a></div></td>
          <td colspan="3">
            <input name="dim_base_profund" type="text" class="texto"  onChange="return testavalor(this);" id="dim_base_profund" value="<?  echo number_format($res[dim_base_profund],2,',','.');?>" size="5">
cm&nbsp;&nbsp;            <a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Peso:</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="dim_base_peso" type="text" class="texto" onChange="return testavalor(this);" id="dim_base_peso" value="<?  echo number_format($res[dim_base_peso],2,',','.');?>" size="5"> 
kg
&nbsp;            </td>
          </tr>
        <tr class="texto_bold">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><u>Do passe partout:</u></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Possui passe partout?</a></div></td>
          <td colspan="3"><input name="dim_pasp_possui" type="radio" value="S" <? if($res['dim_pasp_possui']=='S') echo "checked" ?> onChange="alterouCampo = 1;">
SIM &nbsp;
<input name="dim_pasp_possui" type="radio" value="N" <? if($res['dim_pasp_possui']=='N')echo "checked" ?> onChange="alterouCampo = 1;">
N&Atilde;O</td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Altura:</a> </div></td>
          <td colspan="3" nowrap><input name="dim_pasp_altura" type="text" class="texto" onChange="return testavalor(this);" id="dim_pasp_altura" value="<?  echo number_format($res[dim_pasp_altura],2,',','.');?>" size="5">
            cm
            &nbsp;&nbsp;&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Largura:</a>&nbsp;            <input name="dim_pasp_largura" type="text"  onChange="return testavalor(this);" class="texto" id="dim_pasp_largura" value="<?  echo number_format($res[dim_pasp_largura],2,',','.');?>" size="5">
            cm
            &nbsp;&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Di&acirc;metro:</a>
            <input name="dim_pasp_diametro" type="text" class="texto" onChange="return testavalor(this);" id="dim_pasp_diametro" value="<?  echo number_format($res[dim_pasp_diametro],2,',','.');?>" size="5">
            cm</td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Profundidade:</a></div></td>
          <td colspan="3"><input name="dim_pasp_profund" type="text" class="texto" id="dim_pasp_profund"  onChange="return testavalor(this);" value="<?  echo number_format($res[dim_pasp_profund],2,',','.');?>" size="5">
            cm&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Peso:</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;            <input name="dim_pasp_peso" type="text" onChange="return testavalor(this);" class="texto" id="dim_pasp_peso" value="<?  echo number_format($res[dim_pasp_peso],2,',','.');?>" size="5">
            kg</td>
          </tr>
        <tr class="texto_bold">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"><div align="center">
                <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </div></td>
          </tr>
        <tr>
          <td colspan="4">
            <div align="left"><? echo "<a href=\"parte_obra_reserva.php?obra=$_REQUEST[obra]\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          </tr>
      </table>
      <?

if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
   //Tratamento dos campos
 //Parte
 if($_REQUEST[dim_parte_altura]=='')
  { $_REQUEST[dim_parte_altura]='0.00';}
 if($_REQUEST[dim_parte_largura]=='')
  { $_REQUEST[dim_parte_largura]='0.00'; }
 if($_REQUEST[dim_parte_diametro]=='')
  { $_REQUEST[dim_parte_diametro]='0.00';}
 if($_REQUEST[dim_parte_profund]=='')
  { $_REQUEST[dim_parte_profund]='0.00';}
 if($_REQUEST[dim_parte_peso]=='')
  { $_REQUEST[dim_parte_peso]='0.00'; }
//Aimp
 if($_REQUEST[dim_aimp_altura]=='')
  { $_REQUEST[dim_aimp_altura]='0.00';}
 if($_REQUEST[dim_aimp_largura]=='')
  { $_REQUEST[dim_aimp_largura]='0.00'; }
 if($_REQUEST[dim_aimp_diametro]=='')
  { $_REQUEST[dim_aimp_diametro]='0.00';}
 //Moldura
 if($_REQUEST[dim_mold_altura]=='')
  { $_REQUEST[dim_mold_altura]='0.00';}
 if($_REQUEST[dim_mold_largura]=='')
  { $_REQUEST[dim_mold_largura]='0.00'; }
 if($_REQUEST[dim_mold_diametro]=='')
  { $_REQUEST[dim_mold_diametro]='0.00';}
 if($_REQUEST[dim_mold_profund]=='')
  { $_REQUEST[dim_mold_profund]='0.00';}
 if($_REQUEST[dim_mold_peso]=='')
  { $_REQUEST[dim_mold_peso]='0.00';}
 //Base
  if($_REQUEST[dim_base_altura]=='')
  { $_REQUEST[dim_base_altura]='0.00';}
 if($_REQUEST[dim_base_largura]=='')
  { $_REQUEST[dim_base_largura]='0.00'; }
 if($_REQUEST[dim_base_diametro]=='')
  { $_REQUEST[dim_base_diametro]='0.00';}
 if($_REQUEST[dim_base_profund]=='')
  { $_REQUEST[dim_base_profund]='0.00';}
 if($_REQUEST[dim_base_peso]=='')
  { $_REQUEST[dim_base_peso]='0.00';}
 //PASP
   if($_REQUEST[dim_pasp_altura]=='')
  { $_REQUEST[dim_pasp_altura]='0.00';}
 if($_REQUEST[dim_pasp_largura]=='')
  { $_REQUEST[dim_pasp_largura]='0.00'; }
 if($_REQUEST[dim_pasp_diametro]=='')
  { $_REQUEST[dim_pasp_diametro]='0.00';}
 if($_REQUEST[dim_pasp_profund]=='')
  { $_REQUEST[dim_pasp_profund]='0.00';}
 if($_REQUEST[dim_pasp_peso]=='')
  { $_REQUEST[dim_pasp_peso]='0.00';}
	///  
  $sql="UPDATE parte set
     dim_parte_peso='".formata_valor(trim($_REQUEST['dim_parte_peso']))."',
     dim_mold_possui='".$_REQUEST['dim_mold_possui']."',
     dim_mold_altura='".formata_valor(trim($_REQUEST['dim_mold_altura']))."',
     dim_mold_largura='".formata_valor(trim($_REQUEST['dim_mold_largura']))."',
     dim_mold_diametro='".formata_valor(trim($_REQUEST['dim_mold_diametro']))."',
     dim_mold_profund='".formata_valor(trim($_REQUEST['dim_mold_profund']))."',
	 dim_mold_peso='".formata_valor(trim($_REQUEST['dim_mold_peso']))."',
     dim_base_possui='".$_REQUEST['dim_base_possui']."',
     dim_base_altura='".formata_valor(trim($_REQUEST['dim_base_altura']))."',
     dim_base_largura='".formata_valor(trim($_REQUEST['dim_base_largura']))."',
     dim_base_diametro='".formata_valor(trim($_REQUEST['dim_base_diametro']))."',
     dim_base_profund='".formata_valor(trim($_REQUEST['dim_base_profund']))."',
	 dim_base_peso='".formata_valor(trim($_REQUEST['dim_base_peso']))."',
     dim_pasp_possui='".$_REQUEST['dim_pasp_possui']."',
     dim_pasp_altura='".formata_valor(trim($_REQUEST['dim_pasp_altura']))."',
     dim_pasp_largura='".formata_valor(trim($_REQUEST['dim_pasp_largura']))."',
     dim_pasp_diametro='".formata_valor(trim($_REQUEST['dim_pasp_diametro']))."',
     dim_pasp_profund='".formata_valor(trim($_REQUEST['dim_pasp_profund']))."',
     dim_pasp_peso='".formata_valor(trim($_REQUEST['dim_pasp_peso']))."'
             where obra=$_REQUEST[obra] and parte=$_REQUEST[parte]";
   $db->query($sql);
//ATUALIZA ALTERAÇÃO DA OBRA
	$sql="UPDATE obra set atualizado='$_SESSION[susuario]', data_catalog2=now() where obra = $_REQUEST[obra]";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from obra where obra = $_REQUEST[obra]";
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now())";
$db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo "<script>location.href='parte_obra_dimensoes_reserva.php?op=update&obra=$_REQUEST[obra]&parte=$_REQUEST[parte]'</script>";
	 }
}   
?>
    </form>
    </td>
  </tr>
</table>
</body>
</html>
