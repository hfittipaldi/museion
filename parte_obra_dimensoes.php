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
			location.href= 'parte_obra1.php?op=update&obra=<? echo $_REQUEST[obra] ?>&parte=<? echo $_REQUEST[parte] ?>';
	}
	else
		location.href= 'parte_obra1.php?op=update&obra=<? echo $_REQUEST[obra] ?>&parte=<? echo $_REQUEST[parte] ?>';
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



function abrepopmoldura(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-340)+',top='+((window.screen.height/2)-300)+',width=568,height=600, scrollbars=yes, resizable=yes');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}



function muda_modelo($val) {

if ($val=='1')
{
document.getElementById("msg").style.display= 'none';
if (document.getElementById("dim_mold_possui").checked==true) 
  {
            document.getElementById("msg").style.display= '';
       
  }


if (document.getElementById("dim_mold_possui").checked==true)
  {document.getElementById("msg").style.display= '';}
 if (document.getElementById("dim_mold_possui").checked==true)
         { document.getElementById("moldura_edit").style.display= '';
           document.getElementById("moldura_insert").style.display= 'none';
           document.getElementById("reg").style.display= '';

         }else{document.getElementById("moldura_insert").style.display= '';
               document.getElementById("moldura_edit").style.display= 'none';  
               document.getElementById("reg").style.display= 'none';

         }

    
 }
 
}


</script>
</head>
<body>      
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr>
    <td valign="top"><form name="form1" method="post" onSubmit="" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$dbm=new conexao();
$dbm->conecta();

$dbmold=new conexao();
$dbmold->conecta();

$op=$_REQUEST['op'];
 if(isset($_REQUEST[obra])) {
  if($op=='update'){
    $sql="SELECT a.* from parte as a where a.obra='$_REQUEST[obra]' and parte='$_REQUEST[parte]'";
	$db->query($sql);
    $res=$db->dados();}
 }
?>

<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
  <tr class="texto_bold">
     <td width="20%"><div align="left"><u>Parte: </u></div></td>
     <td width="20%">&nbsp;</td>
     <td width="15%">&nbsp;</td>
     <td width="20%">&nbsp;</td>
     <td width="15%">&nbsp;</td>
     <td width="15%"align="right"><a href='javascript:checaAlteracao();' style='color:navy;'>Objeto</a></td>

   </tr>
</table>


<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
  <tr class="texto_bold">
     <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Altura:</a></div></td>
     <td width="10%"><div align="left"><input name="dim_parte_altura" type="text" onChange="return testavalor(this);" value="<?  echo number_format($res[dim_parte_altura],2,',','.');?>" class="combo_cadastro" id="dim_parte_altura" size="5">&nbsp;cm&nbsp;</td>

     <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">&nbsp;&nbsp;Largura:</a></div></td> 
     <td width="10%"><div align="left"><input name="dim_parte_largura" type="text" class="combo_cadastro"  onChange="return testavalor(this);" value="<?  echo number_format($res[dim_parte_largura],2,',','.');?>" id="dim_parte_largura" size="5">&nbsp;cm&nbsp;</div></td>

     <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">&nbsp;&nbsp;Di&acirc;metro:</a></div></td>
     <td width="20%"><div align="left"><input name="dim_parte_diametro" type="text" class="combo_cadastro"  onChange="return testavalor(this);" value="<?  echo number_format($res[dim_parte_diametro],2,',','.');?>" id="dim_parte_diametro" size="5">&nbsp;cm</div></td>
   </tr>

  <tr class="texto_bold">
     <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Profundidade:</a></div></td>
     <td width="10%"><div align="left"><input name="dim_parte_profund" type="text" class="combo_cadastro" onChange="return testavalor(this);"  value="<?echo number_format($res[dim_parte_profund],2,',','.');?>"id="dim_parte_profund" size="5">&nbsp;cm&nbsp;</div></td>

     <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial"> &nbsp;&nbsp;Peso:</a></div></td> 
     <td width="10%"><div align="left"><input name="dim_parte_peso" type="text" class="combo_cadastro" id="dim_parte_peso" onChange="return testavalor(this);" value="<?  echo number_format($res[dim_parte_peso],2,',','.');?>" size="5">&nbsp;kg&nbsp;</div></td>

     <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial"> Formato:</a>&nbsp;</div></td><td><div><select name="dim_parte_formato" class="combo_cadastro" id="dim_parte_formato" onChange="alterouCampo = 1;" align="left">
       <option value="" <? if($res['dim_parte_formato']=='') echo "Selected" ?>></option>
       <option value="C" <? if($res['dim_parte_formato']=='C') echo "Selected" ?>>Circular</option>
       <option value="I" <? if($res['dim_parte_formato']=='I') echo "Selected" ?>>Irregular</option>
       <option value="L" <? if($res['dim_parte_formato']=='L') echo "Selected" ?>>Los&acirc;ngico</option>
       <option value="O" <? if($res['dim_parte_formato']=='O') echo "Selected" ?>>Oval</option>
       <option value="T" <? if($res['dim_parte_formato']=='T') echo "Selected" ?>>Triangular</option>
       </select>
      </div></td>      
   </tr>
   <tr><td><br></td></tr>
</table>


<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
  <tr class="texto_bold">
     <td width="20%"><div align="left"><u>&Aacute;rea impressa:</u></div></td>
     <td width="20%">&nbsp;</td>
     <td width="15%">&nbsp;</td>
     <td width="20%">&nbsp;</td>
     <td width="15%">&nbsp;</td>
     <td width="15%"align="right">&nbsp;</td>

   </tr>
</table>


<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
   <tr class="texto_bold">

      <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Altura:</a></div></td>
      <td width="10%"><div align="left"><input name="dim_aimp_altura" type="text" onChange="return testavalor(this);" value="<?  echo number_format($res[dim_aimp_altura],2,',','.');?>" class="combo_cadastro" id="dim_aimp_altura" size="5">&nbspcm&nbsp;</div></td>
 
      <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Largura:</a></div></td>
      <td width="10%"><div align="left"><input name="dim_aimp_largura" type="text" class="combo_cadastro"  onChange="return testavalor(this);" value="<?  echo number_format($res[dim_aimp_largura],2,',','.');?>" id="dim_aimp_largura" size="5">&nbsp;cm&nbsp;</div></td>

      <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Di&acirc;metro:</a></td>
      <td width="20%"><div align="left"><input name="dim_aimp_diametro" type="text" class="combo_cadastro" onChange="return testavalor(this);" value="<?  echo number_format($res[dim_aimp_diametro],2,',','.');?>" id="dim_aimp_diametro" size="5">&nbsp;cm</div></td>
   </tr>
</table>

<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
        <tr class="texto_bold">
           <td width="18%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Formato:</a></div></td>
               <td width="10%"><div align="left"><select name="dim_aimp_formato" class="combo_cadastro" id="dim_aimp_formato" onChange="alterouCampo = 1;">
                   <option value="" <? if($res['dim_aimp_formato']=='') echo "Selected" ?>></option>
                   <option value="C" <? if($res['dim_aimp_formato']=='C') echo "Selected" ?>>Circular</option>
                   <option value="I" <? if($res['dim_aimp_formato']=='I') echo "Selected" ?>>Irregular</option>
                   <option value="L" <? if($res['dim_aimp_formato']=='L') echo "Selected" ?>>Los&acirc;ngico</option>
                   <option value="O" <? if($res['dim_aimp_formato']=='O') echo "Selected" ?>>Oval</option>
                   <option value="T" <? if($res['dim_aimp_formato']=='T') echo "Selected" ?>>Triangular</option>
              </select> 
              </div>
            </td>
           <td width="20%">&nbsp;</td>
           <td width="10%">&nbsp;</td>
           <td width="20%">&nbsp;</td>
           <td width="20%">&nbsp;</td>
        </tr>
      <tr><td><br></td></tr>
</table>


<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
<tr>


  <tr class="texto_bold">
     <td width="18%"><div align="left"><u>Moldura:</u></div></td>
        <td width="28%">
          <input name="dim_mold_possui" id="dim_mold_possui" type="radio" value="S" onClick="muda_modelo(1);this.focus();" <? if($res['dim_mold_possui']=='S') echo "checked" ?> onChange="alterouCampo = 1;">SIM 
          <input name="dim_mold_possui" id="dim_mold_possui"  type="radio" value="N" onClick="muda_modelo(1);this.focus();"<? if(($res['dim_mold_possui']=='N')or($res['dim_mold_possui']=='')) echo "checked" ?> onChange="alterouCampo = 1;">N&Atilde;O
          
        </td>
       <?
                 $sqlm="SELECT moldura, mold_registro FROM  moldura where moldura='$res[moldura]'";
                 $dbm->query($sqlm);
                 $resm=$dbm->dados();
                 if ($resm[moldura]>0){$mold_registro=$resm[mold_registro];}

        ?>
         <? 
          if ($res['dim_mold_possui']=='S') {
              if ($res['moldura']<>'' and $res['moldura']>0) {
                   
                    $ref="cadastro_moldura.php?op=update&tipo2=1&form=parte&obra=".$_REQUEST[obra]."&parte=".$res[parte]."&mold_registro=".$_REQUEST['mold_registro']."&moldura=".$res[moldura];?>  
                   <td width="27%" name="moldura_edit" id="moldura_edit" style="display:yes; font-weight:normal;"> 
                   <a  class="texto" ><b>Moldura nº&nbsp;&nbsp;</b><?echo $mold_registro;?></a>
                   

                   <a href='javascript:;'onClick="abrepopmoldura('<?echo $ref;?>');muda_modelo(1);">
                   <img src='imgs/icons/ic_alterar.gif' border='0' alt='Editar moldura'></a>
               </td>
               <td width="27%" style="display:yes; font-weight:normal;">&nbsp;</td>
               <td width="27%" style="display:yes; font-weight:normal;">&nbsp;</td>
             <?}else{?>
               <td width="27%" name="moldura_insert" id="moldura_insert" style="display:yes; font-weight:normal;"> 
                   <a class="texto_bold_especial" ></a>
                   <input name="mold_registro" type="text" readonly=yes class="combo_cadastro" onChange="" value="<?echo $mold_registro;?>"  id="mold_registro" size="5">
                    <?                                                         
                    $_REQUEST[tombo]=$res[num_registro];
                    $ref="cadastro_moldura.php?op=insert&tipo2=1&form=parte&obra=".$_REQUEST[obra]."&parte=".$res[parte]."&moldura=".$res[moldura]."&mold_registro=".$_REQUEST['mold_registro'];
                  ?>

                  <a href='javascript:;'onClick="abrepopmoldura('<?echo $ref;?>&mold_registro='+document.form1.mold_registro.value);muda_modelo(1);">
                  <img src='imgs/icons/btn_plus.gif'  width='13' height='13' border='0' alt='Adicionar moldura'></a>
      
               </td>

               <td width="27%">&nbsp;</td>
               <td width="27%">&nbsp;</td>
             <?}
           }else {?>
               <td width="27%">&nbsp;</td>
               <td width="27%">&nbsp;</td>
               <td width="27%">&nbsp;</td>

           <?}?>
         

     
    </tr>
</tr>

</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
  <tr>
    <td width="100%" name="msg" id="msg" style="display:none; font-weight:normal;">Atenção: Você só poderá incluir ou editar a moldura depois de salvar a Parte.</td>
  </tr>
  <tr>
    <td width="100%">&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
        <tr class="texto_bold">
          <td width="18%"><div align="left"><u>Base:</u></div></td>
          <td width="28%">
              <input name="dim_base_possui" type="radio" value="S" <? if($res['dim_base_possui']=='S') echo "checked" ?> onChange="alterouCampo = 1;">SIM
              <input name="dim_base_possui" type="radio" value="N" <? if(($res['dim_base_possui']=='N')or($res['dim_base_possui']=='')) echo "checked" ?> onChange="alterouCampo = 1;">N&Atilde;O
          </td>
          <td width="58%">&nbsp;</td>
       </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
        <tr class="texto_bold">

          <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Altura:</a></div></td>
          <td width="10%"><div align="left"><input name="dim_base_altura" type="text" class="combo_cadastro"  onChange="return testavalor(this);" id="dim_base_altura" value="<?  echo number_format($res[dim_base_altura],2,',','.');?>" size="5">&nbsp;cm&nbsp;</div></td>

          <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Largura:</a></div></td>
          <td width="10%"><div align="left"><input name="dim_base_largura" type="text" class="combo_cadastro"  onChange="return testavalor(this);" id="dim_base_largura" value="<?  echo number_format($res[dim_base_largura],2,',','.');?>" size="5">&nbsp;cm&nbsp;</div></td>

          <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Di&acirc;metro:</a></div></td>
          <td width="20%"><div align="left"><input name="dim_base_diametro" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="dim_base_diametro" value="<?  echo number_format($res[dim_base_diametro],2,',','.');?>" size="5">&nbsp;cm</div></td>
        </tr>
        <tr class="texto_bold">
          <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Profundidade:</a></div></td>
          <td width="10%"><div align="left"><input name="dim_base_profund" type="text" class="combo_cadastro"  onChange="return testavalor(this);" id="dim_base_profund" value="<?  echo number_format($res[dim_base_profund],2,',','.');?>" size="5">&nbsp;cm&nbsp;</div></td>
	  <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Peso:</a></div></td>
          <td width="20%"><div align="left"><input name="dim_base_peso" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="dim_base_peso" value="<?  echo number_format($res[dim_base_peso],2,',','.');?>" size="5"> kg</div></td>
        </tr>
        <tr><td><br></td></tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">
        <tr class="texto_bold">
          <td width="18%"><div align="right"><u>Passe partout:</u></div></td>
          <td width="28%">
               <input name="dim_pasp_possui" type="radio" value="S" <? if($res['dim_pasp_possui']=='S') echo "checked" ?> onChange="alterouCampo = 1;">SIM &nbsp;
               <input name="dim_pasp_possui" type="radio" value="N" <? if(($res['dim_pasp_possui']=='N') or ($res['dim_pasp_possui']==''))echo "checked" ?> onChange="alterouCampo = 1;">N&Atilde;O
          </td>
          <td width="58%">&nbsp;</td>
         </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="1"  class="texto_bold">

          <td>&nbsp;</td>
        </tr>
         <tr class="texto_bold">
          <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Altura:</a></div></td>
          <td width="10%"><div align="left"><input name="dim_pasp_altura" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="dim_pasp_altura" value="<?  echo number_format($res[dim_pasp_altura],2,',','.');?>" size="5">&nbsp;cm&nbsp;</div></td>
	  <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Largura:</a></div></td>
          <td width="10%"><div align="left"><input name="dim_pasp_largura" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="dim_pasp_largura" value="<?  echo number_format($res[dim_pasp_largura],2,',','.');?>" size="5">&nbsp;cm&nbsp;</div></td>
          <td width="20%"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Di&acirc;metro:</a></div></td>
          <td width="10%"><div align="left"><input name="dim_pasp_diametro" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="dim_pasp_diametro" value="<?  echo number_format($res[dim_pasp_diametro],2,',','.');?>" size="5">&nbsp;cm</div></td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"></div></td>
          <td colspan="3">
            <input name="dim_pasp_profund" type="hidden" value="<?  echo number_format($res[dim_pasp_profund],2,',','.');?>" size="5">
            <input name="dim_pasp_peso" type="hidden" value="<?  echo number_format($res[dim_pasp_peso],2,',','.');?>" size="5">
           </td>
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
       </table>
      <?


if($_REQUEST['incluir']<>'')
{ 
   $sqlm="SELECT moldura, mold_registro FROM  moldura where mold_registro='$_REQUEST[mold_registro]'";
   $dbm->query($sqlm);
   $resm=$dbm->dados();
   if ($resm[moldura]>0) {
           echo"<script>alert('Informe outro número de registro. Moldura $_REQUEST[mold_registro], já se encontra cadastrada.')</script>";
    }else{echo $ref;
        echo "<script>location.href=abrepopmoldura($ref)</script>";
   
     }
}


   $dimaltura=formata_valor_2(trim($_REQUEST[dim_parte_altura]));
   $dimlargura=formata_valor_2(trim($_REQUEST[dim_parte_largura]));
   $dimdiametro=formata_valor_2(trim($_REQUEST[dim_parte_diametro]));


   $aimpaltura=formata_valor_2(trim($_REQUEST[dim_aimp_altura]));
   $aimplargura=formata_valor_2(trim($_REQUEST[dim_aimp_largura]));
   $aimpdiametro=formata_valor_2(trim($_REQUEST[dim_aimp_diametro]));


   if ( ($aimpaltura > $dimaltura) or 
       ($aimplargura > $dimlargura) or
          ($aimpdiametro > $dimdiametro) )

    {
       echo "<script>alert( 'Dimensões da área impressa não pode ser maior que dimensões da obra.');</script>";
 
    }else{
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
	 dim_parte_altura='".formata_valor_1(trim($_REQUEST['dim_parte_altura']))."',
     dim_parte_largura='".formata_valor_1(trim($_REQUEST['dim_parte_largura']))."',
     dim_parte_diametro='".formata_valor_1(trim($_REQUEST['dim_parte_diametro']))."',
     dim_parte_profund='".formata_valor_1(trim($_REQUEST['dim_parte_profund']))."',
     dim_parte_peso='".formata_valor_1(trim($_REQUEST['dim_parte_peso']))."',
	 dim_parte_formato='".$_REQUEST['dim_parte_formato']."',
     dim_aimp_altura='".formata_valor_1(trim($_REQUEST['dim_aimp_altura']))."',
     dim_aimp_largura='".formata_valor_1(trim($_REQUEST['dim_aimp_largura']))."',
     dim_aimp_diametro='".formata_valor_1(trim($_REQUEST['dim_aimp_diametro']))."',
     dim_aimp_formato='".$_REQUEST['dim_aimp_formato']."',
     dim_mold_possui='".$_REQUEST['dim_mold_possui']."',
     dim_mold_altura='".formata_valor_1(trim($_REQUEST['dim_mold_altura']))."',
     dim_mold_largura='".formata_valor_1(trim($_REQUEST['dim_mold_largura']))."',
     dim_mold_diametro='".formata_valor_1(trim($_REQUEST['dim_mold_diametro']))."',
     dim_mold_profund='".formata_valor_1(trim($_REQUEST['dim_mold_profund']))."',
	 dim_mold_peso='".formata_valor_1(trim($_REQUEST['dim_mold_peso']))."',
     dim_base_possui='".$_REQUEST['dim_base_possui']."',
     dim_base_altura='".formata_valor_1(trim($_REQUEST['dim_base_altura']))."',
     dim_base_largura='".formata_valor_1(trim($_REQUEST['dim_base_largura']))."',
     dim_base_diametro='".formata_valor_1(trim($_REQUEST['dim_base_diametro']))."',
     dim_base_profund='".formata_valor_1(trim($_REQUEST['dim_base_profund']))."',
	 dim_base_peso='".formata_valor_1(trim($_REQUEST['dim_base_peso']))."',
     dim_pasp_possui='".$_REQUEST['dim_pasp_possui']."',
     dim_pasp_altura='".formata_valor_1(trim($_REQUEST['dim_pasp_altura']))."',
     dim_pasp_largura='".formata_valor_1(trim($_REQUEST['dim_pasp_largura']))."',
     dim_pasp_diametro='".formata_valor_1(trim($_REQUEST['dim_pasp_diametro']))."',
     dim_pasp_profund='".formata_valor_1(trim($_REQUEST['dim_pasp_profund']))."',
     dim_pasp_peso='".formata_valor_1(trim($_REQUEST['dim_pasp_peso']))."'
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
      $obs1="Alteração dimensões parte ID_obra={".$_REQUEST[obra]."}  ID_parte={".$_REQUEST[parte]."}";
      $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now(),'$obs1')";
      $db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo "<script>location.href='parte_obra_dimensoes.php?op=update&obra=$_REQUEST[obra]&parte=$_REQUEST[parte]'</script>";
	 }
}}   
?>
    </form>
    </td>
  </tr>
</table>
</body>
</html>
