<?  include_once("seguranca.php");?>
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
-->
</style>
<script src="js/funcoes_padrao.js"></script>
<script language="JavaScript">


function cancela()
{
window.opener.location.reload();

document.form.fechar.submit=window.close();


  return true;
}

function valida()
{
  with(document.frm)
  {           
    if(mold_registro.value==''){
	  ajustaAbas(1);
      alert('Informe o número de registro da moldura!');
         mold_registro.focus();
	  return false;}
  }
 
 }
function ajustaAbas(index) {
	numAbas=2;

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


function inicia_modelo($tipo) { 
     document.form.modelo2.disabled=true;
     document.form.modelo1.disabled=true;

  if ($tipo=='1') {
     document.getElementById("modelo1").checked= true;
   }else{
     document.getElementById("modelo1").checked= false;
  }
  if ($tipo=='2'){
     document.getElementById("modelo2").checked= true;
     document.form.modelo2.disabled=false;
     document.form.modelo1.disabled=false;

  }else{
     document.getElementById("modelo2").checked= false;
  }    
  return true;
 }



function altera_modelo() { 
  if (document.getElementById("modelo1").checked==true) $tipo='1';
  if (document.getElementById("modelo1").checked==false)$tipo='2';
  if (document.getElementById("modelo2").checked==true) $tipo='2';
  if (document.getElementById("modelo2").checked==false)$tipo='1';    
  return true;
 }

function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-50)+',top='+((window.screen.height/2)-50)+',width=400,height=250, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4)
   {      win.window.focus();
    }
 return true;
}



function muda_modelo($val) {

if ($val=='3')
{
      if (document.getElementById("tem_ornamento").checked==true)
         { 
           document.getElementById("ornamento").style.display= '';
          }else{
            document.getElementById("ornamento").style.display= 'none';
         }

      if (document.getElementById("tem_acabamento").checked==true)
         { 
           document.getElementById("acabamento").style.display= '';
          }else{
            document.getElementById("acabamento").style.display= 'none';
         }

}
 
   if ($val=='1')
      
     { 
       if (document.getElementById("modelo1").checked==true)
         { 
            document.form.modelo1.value=1;
            
         }else{
            document.form.modelo1.value=0;
         }
        if (document.getElementById("modelo2").checked==true)
         { 
            document.form.modelo2.value=1;
            
          }else{
            document.form.modelo2.value=0;
          }
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
<body onLoad='document.getElementById("wait").style.display="none"; ajustaAbas(<? echo $aba ?>);inicia_modelo(<?echo $_REQUEST[tipo2];?>);'>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
  </div>
  <div id="wait" align="center" class="texto" style="width:450px; height:420px; font-size:12px; font-weight:bold;">
		<br><br><br><br><br><br><br><br>
		&nbsp;&nbsp;<img src="imgs/icons/clock.gif"> &nbsp;&nbsp;Carregando...
  </div>
</th>

<? 


  function ret_nome($idnome)
   {
    if ($idnome<>"")
    {
      global $db;
      $sql="select nome from usuario where usuario=$idnome";

      $db->query($sql);
      $nome=$db->dados();
      return $nome[0];
     }
   }


include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$dbn=new conexao();
$dbn->conecta();


$tipo2=$_REQUEST['tipo2'];
$form=$_REQUEST['form'];
$obra=$_REQUEST['obra'];
$parte=$_REQUEST['parte'];
$moldura=$_REQUEST[moldura];
$mold_registro=$_REQUEST[mold_registro];

if ($tipo2==1 and ($obra <> '' or $obra <>'0')){
   $sql="select num_registro from obra where obra='".$obra."'";
   $db->query($sql);
   $res=$db->dados();
   $_REQUEST[tombo]=$res[num_registro];
}



echo $mold_registro;
       if ($mold_registro>0 and $form=='parte')
       {
            $sql1="select moldura from moldura where mold_registro='".$mold_registro."'";echo $sql1;
            $db->query($sql1);
            $resm=$db->dados();
            $moldura_mold=$resm[moldura];
            

            $sql2="select obra,moldura from parte where moldura='".$resm[moldura]."'";echo $sql2;
            $db->query($sql2);
            $res1=$db->dados();
            $moldura_parte=$res1[moldura];          
  
            $sql3="select num_registro from obra where obra='".$res1[obra]."'";echo $sql3;
            $db->query($sql3);
            $resob=$db->dados();
            $_REQUEST[num_registro]=$resob[num_registro];

            if ( $moldura_parte > 0 and  $_REQUEST[num_registro]> 0 ){
               echo "<script> alert('Moldura já cadastrada. Obra '. $_REQUEST[num_registro]')</script>";

               }
             if ($moldura_mold > 0 and ( $_REQUEST[num_registro]=='0' or $_REQUEST[num_registro]=='')  ){
                 echo "<script> alert('Moldura '. $_REQUEST[num_registro]')</script>";
                  $sql="Update parte set moldura='$moldura_mold', dim_mold_possui='S' where parte='$parte'";
                  $db->query($sql); 
                  $sql="Update moldura set obra='$obra', parte='$parte', dim_mold_possui='S' where moldura='$moldura_mold'";
                  $db->query($sql); 
                  $moldura=$moldura_mold;
                 $_REQUEST[op]='update'; $op='update';
               }
         
       }

$mold_registro=$_REQUEST[mold_registro];

if ($_REQEUST[atualizado]=="") {
    $_REQEUST[atualizado]=$_SESSION[susuario];
    }
if ($_REQEUST[catalogado]=="") {
   $_REQEUST[catalogado]=$_SESSION[susuario];
 }

$catalogado=$_REQUEST[catalogado];
$atualizado=$_REQUEST[atualizado];



$tombo=$_REQUEST['tombo'];


 

   

if ($moldura>0) $op="update";


///////////////////////////INSERE A MOLDURA: MOLD_REGISTRO VAI SER IGUAL A MOLDURA///////////////////////
   if ($_REQUEST[op]=='insert' )
{
   if ($tipo2==1)
   {  

       if ($_REQUEST[mold_registro]<>'')
       {

                 $sql="insert into moldura(mold_registro, parte, obra, catalogado, data_catalog1)values($_REQUEST[mold_registro],'0','0','$_SESSION[susuario]',now())";echo $sql;
                 $db->query($sql);
                 $mold=$db->lastid();
                 $moldura=$mold;

          $sql="Update parte set moldura='$moldura', dim_mold_possui='S' where parte='$parte'";
          $db->query($sql);   
      }else{
           if (($moldura=='' or $moldura=='0') and ($obra=='' or $obra==0))
           {
             $sql="insert into moldura(parte, obra, catalogado, data_catalog1)values('0','0','$_SESSION[susuario]',now())"; 
             $db->query($sql);
             $mold=$db->lastid();
             $mold_registro=$mold;
             $moldura=$mold;

              $sql="Update moldura set mold_registro='$mold_registro' where moldura='$mold_registro'";
              $db->query($sql);
          }else{
             $sql="insert into moldura(parte, obra, catalogado, data_catalog1)values('$parte','$_REQUEST[obra]','$_SESSION[susuario]',now())"; 
             $db->query($sql);
             $mold=$db->lastid();
             $mold_registro=$mold;
             $moldura=$mold;
          
             $sql="Update moldura set mold_registro='$mold_registro' where moldura='$mold_registro'";
             $db->query($sql);

             $sql="Update parte set moldura='$moldura', dim_mold_possui='S' where parte='$parte'";
            $db->query($sql);    
          }
       }
   }
    if ($tipo2==2)
    {   
       if ($_REQUEST[mold_registro]<>'')
       {
          $sql="insert into moldura(mold_registro, parte, obra, catalogado, data_catalog1)values($_REQUEST[mold_registro],'0','0','$_SESSION[susuario]',now())"; 
          $db->query($sql);
          $mold=$db->lastid();
          $moldura=$mold;
        }else{
          $sql="insert into moldura(parte, obra, catalogado, data_catalog1)values('0','0','$_SESSION[susuario]',now())"; 
          $db->query($sql);
          $mold=$db->lastid();
          $mold_registro=$mold;
          $moldura=$mold;

          $sql="Update moldura set mold_registro='$mold_registro' where moldura='$mold_registro'";
          $db->query($sql);
        }
    }

      $op='update';       
       echo "<script>location.href='cadastro_moldura.php?op=update&tipo2=$tipo2&form=$form&obra=$obra&moldura=$moldura&mold_registro=$mold_registro'</script>";

}
////////////////////////////////////////////////  UPDATE //////////////////////////////////////////////
   
     $sql="select * from moldura where moldura=$moldura"; 
     $db->query($sql);
     $res=$db->dados();
     $mold_registro=$res[mold_registro];
     $_REQUEST[mold_registro]=$mold_registro;

     $parte=$res['parte'];
     $obra=$res[obra];
     $observacao=$res[observacao];
     $formato=$res[formato];
     $material_tecnica=$res[material_tecnica];
     $altura_interna=$res[altura_interna];
     $largura_interna=$res[largura_interna];
     $altura_externa=$res[altura_externa];
     $largura_externa=$res[largura_externa];
     $profundidade_externa=$res[profundidade_externa];
     $peso=$res[peso];
     $suporte=$res[suporte];
     $acabamento=$res[acabamento];
     $ornamento=$res[ornamento];
     $tem_ornamento=$res[tem_ornamento];
     $tem_acabamento=$res[tem_acabamento];
     $catalogado=ret_nome($res[catalogado]);
     $atualizado=ret_nome($res[atualizado]);
     $num_registro=$res[num_registro];
     $controle=$res[controle];
     $propriedade=$res[propriedade];

     if ( $res[data_catalog1]<>'0000-00-00 00:00:00' and $res[data_catalog1]<>''){
                 $data_catalog1= convertedata($res[data_catalog1],'d/m/Y - h:i');}

     if ( $res[data_catalog2]<>'0000-00-00 00:00:00'  and $res[data_catalog2]<>''){
                 $data_catalog2= convertedata($res[data_catalog2],'d/m/Y - h:i'); }


 


?>
</tr>
  <br>

   
<form name="form" method="post" onSubmit='return valida()' enctype="multipart/form-data">

  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
       <td width="100" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Moldura</span></a></div></td>
       <td width="96" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Restaurações</span></a></div></td>
        <td width="70" align="right" style="border-bottom: 1px solid #34689A;">&nbsp;
<?if ($_REQUEST[form]<>'parte') { 
     
      if ($_REQUEST[chama]<>'moldura'){
          echo "<a href=\"inclusao_restauro.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";
        }else{
          echo "<a href=\"restauro_altera_moldura.php?op=update&tipo=$_REQUEST[tipo]&moldura=$mold_registro\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";
        }
   }?>
   </td>
    </tr>
    <td colspan="6" align="left" class="texto" bgcolor="#f2f2f2" style="border: 1px solid #34689A; border-top: none; border-left-width: 1px;">
      <table border="0" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2">
         <tr><br>
            <td width="100%" height="100%" valign="top">
	       <!-- ABA 1 : Identifica&ccedil;&atilde;o -->
                  <div id="quadro1" class="divi1" style="display:none; width:540px;">

	     <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                        <tr width="100%">
                          <td width="100%"><div align="left"> 
                            <?if ($tipo2<>2 and $obra<>'0' ){?>                            
                               <span class="texto">
                                 <font style="color:#9B9B9B">&nbsp;&nbsp;Objeto:</font>
                               </span>
                               <?if ($tipo2==1 and $obra<>'0' ){
                                    $sql="Select nome_objeto from parte where parte=$parte";
		                    $db->query($sql);
                                    $res=$db->dados();
                                    $nomeparte=$res[0];
                                  }
                                ?>
                               <span class="texto">
                                  <font style="color:#9B9B9B"><? echo htmlentities($nomeparte, ENT_QUOTES); ?></font>
  		               </span>
                             <?}?>
                         </div></td>
                          <td  width="100%">
                           </td>
                       </tr>
                   </table>

	           <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                        <tr width="100%">
                          <td width="20%"><div align="left">                            
                              <?if ($tipo2<>2  and $obra<>'0' ){?> 
                                      <span class="texto">
                                        <font style="color:#9B9B9B">&nbsp;&nbsp;Tombo:</font>
                                      </span>
                              
                                      <span class="texto">
                                      <font style="color:#9B9B9B"><? echo htmlentities($_REQUEST[tombo], ENT_QUOTES); ?></font>
  		                      </span>
 			       <?}?>
                           </div>
                       </td>
                       <?if ($tipo2=='1' and $obra<>'0'){?>
                          <td colspan="2" width="28%">
                             <div align="left">
                                <span class="texto">
                                 <font style="color:#9B9B9B">N&ordm; Moldura:</font>
                               </span>
                               <span class="texto">
                                  <font style="color:#9B9B9B"><? echo htmlentities($_REQUEST[mold_registro], ENT_QUOTES); ?></font>
  		              </span>
                           </div>
                          </td>
                       <?}else{?>
                        <td colspan="2" width="30%"><div align="left">&nbsp;</div></td>
                       <?}?>
                       <?if ($_REQUEST[op]=="update")
                         {?>
                          <td colspan="2" width="28%">
                             <div align="left">
                                <span class="texto" readonly="1">                     
                                   <input type="radio" name="modelo"  id="modelo1" onClick="muda_modelo('1');<?$tipo2='1';$mudou=true;?>" value="1">Interna
                                </span>
                              </div>
                           </td>
                         <td colspan="2" width="28%">
                            <div align="left">
                               <span class="texto" readonly="1">
                                 <input type="radio" name="modelo" id="modelo2" onClick="muda_modelo('1');" value="2"> externa 
                               </span>
                            </div>
                        </td>
                        <?}else{?>
                         <td colspan="2" width="28%">
                             <div align="left">
                                <span class="texto" readonly="1" >
                                   <input type="radio" name="modelo" id="modelo1" disabled=true >Interna
                                </span>
                              </div>
                           </td>
                         <td colspan="2" width="28%">
                            <div align="left">
                               <span class="texto"  readonly="1" >
                                 <input type="radio" name="modelo"  id="modelo2" disabled=true > Externa 
                               </span>
                            </div>
                        </td>
                       <?}?>
                        
                       </tr>
                      </table>



                   <?if ($tipo2=='2'){?>

                      <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                        <tr class="texto_bold">

                           <td width="32%"><div align="right">N&ordm; Moldura:</div></td>
                           <td align="left"><input name="mold_registro" type="text" class="combo_cadastro"  id="mold_registro"  size="4" value="<? echo htmlentities(trim($mold_registro), ENT_QUOTES); ?>"></td>
 
                           <td  width="27%"><div align="right">N&ordm; registro:</div></td>
                           <td align="left"><input name="num_registro" type="text" class="combo_cadastro"  id="tombo"  size="9" value="<? echo htmlentities($num_registro, ENT_QUOTES); ?>"></td>

                           <td width="40%"><div align="right">Controle:</div></td>                        
                           <td align="left"><input name="controle" type="text" class="combo_cadastro"  id="controle"  size="4" value="<? echo htmlentities(trim($controle), ENT_QUOTES); ?>"></td>
                        
                         </tr>
                       </table>
                   <?}else{?>
                        
                      <?if ($tipo2==1 and $obra==0){?>
                      <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                        <tr class="texto_bold">

                           <td width="20%"><div align="right">N&ordm; Moldura:</div></td>
                           <td align="left"><input name="mold_registro" type="text" class="combo_cadastro"  id="mold_registro"  size="4" value="<? echo htmlentities(trim($mold_registro), ENT_QUOTES); ?>"></td>
                           
                         </tr>
                       </table>
                     <?}?>

                   <?}?>
                    <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                      <tr class="texto_bold">                      
                         <td width="20%"><div align="right">Material/T&eacute;cnica:</div></td>
                         <td align="left"><input name="material_tecnica" type="text" class="combo_cadastro" id="material_tecnica"  value="<? 
                                   echo htmlentities(trim($material_tecnica), ENT_QUOTES);
                             ?>" size="78">
                         </td>
                     </tr>
                    </table>
 
                   <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                  <tr class="texto"><br>
                       <td colspan="2" width="100%"><div align="left">&nbsp;&nbsp;Dimensões (cm):</div></td>
                    </tr>
                    <tr class="texto_bold">
                       <td  colspan="0"  width="23%" class="texto_bold"><div align="right">Externas:</div></td>
                       <td  colspan="0" width="37%" align="right">Altura:&nbsp;&nbsp;<input name="altura_externa" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="altura_externa"  value=" <? echo number_format($altura_externa,2,',','.'); ?>" size="6"></td>
                       <td  colspan="0" width="14%">Largura:&nbsp;&nbsp;<input name="largura_externa" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="largura_externa"  value="  <? echo number_format($largura_externa,2,',','.'); ?>" size="6"></td>
                       <td  colspan="0" width="51% align="left">Profundidade:&nbsp;&nbsp;<input name="profundidade_externa" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="profundidade_externa"  value="  <? echo number_format($profundidade_externa,2,',','.'); ?>" size="6"></td>
                    </tr>
                    <tr class="texto_bold">
                       <td  colspan="0"  width="23%" class="texto_bold"><div align="right">Internas:</div></td>
                       <td  colspan="0" width="37%" align="right">Altura:&nbsp;&nbsp;<input name="altura_interna" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="altura_interna"  value=" <? echo number_format($altura_interna,2,',','.');?>" size="6"></td>
                       <td  colspan="0" width="14%">Largura:&nbsp;&nbsp;<input name="largura_interna" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="largura_interna"  value=" <? echo number_format($largura_interna,2,',','.');?>" size="6"></td>
                       <td  colspan="0" width="51%">&nbsp;</td>
                     </tr>
                    <tr class="texto_bold">
	                <td colspan="0"  width="23%" class="texto_bold"><div align="right">&nbsp;</div></td>
                        <td colspan="0" width="37%" align="right">Peso(kg):&nbsp;&nbsp;<input name="peso" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="peso"  value="<? echo number_format($peso,2,',','.');?>" size="6"></td>
                        <td colspan="0" width="55%"><span class="texto_bold"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Formato:&nbsp;</a>
                        <select name="formato" class="combo_cadastro" id="dim_obra_formato">
  		      		<option value="" <? if($formato=='') echo "selected" ?>></option>
  		      		<option value="C" <? if($formato=='C') echo "selected" ?>>Circular</option>
  		      		<option value="I" <? if($formato=='I') echo "selected" ?>>Irregular</option>
  		      		<option value="L" <? if($formato=='L') echo "selected" ?>>Losângulo</option>
  		      		<option value="O" <? if($formato=='O') echo "selected" ?>>Oval</option>
  		      		<option value="T" <? if($formato=='T') echo "selected" ?>>Triangular</option>
		   	      </select>
                          </span>
                      </td>
                   </tr>
                   </table>
                    <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                      <tr width="100%"><br>
                      <tr class="texto_bold">                      
                         <td width="60%"><div align="right">&nbsp;&nbsp;&nbsp;Suporte:</div></td>
                        <td width="40%"><div align="right"><input name="suporte" type="text" class="combo_cadastro" id="suporte" value="<? echo  $suporte ?>" size="78"></div></td> 
                      </tr>
                      <tr class="texto_bold">                    
                         <td width="60%"><div align="right"><input type="checkbox" name="tem_ornamento" id="tem_ornamento" value="S" onClick="muda_modelo(3); this.focus();" <? if($tem_ornamento=='S') echo "checked" ?>>&nbsp;&nbsp; Ornamento:</div></td>
                         <?if($tem_ornamento=='S') {?><td width="40%" id="ornamento" style="display:yes; font-weight:normal;"><divalign="right"><input name="ornamento"   type="text" class="combo_cadastro" id="ornamento" value="<? echo  $ornamento ?>" size="78"></div></td>
                         <?}else{?><td width="40%" id="ornamento" style="display:none; font-weight:normal;"><divalign="right"><input name="ornamento"   type="text" class="combo_cadastro" id="ornamento" value="<? echo  $ornamento ?>" size="78"></div></td><?}?>

                      </tr>
                      <tr class="texto_bold">                      
                         <td width="60%"><div align="right"><input type="checkbox" name="tem_acabamento" id="tem_acabamento" value="S" onClick="muda_modelo(3); this.focus();" <? if ($tem_acabamento == 'S') echo "checked"; ?>>Acabamento:</div></td>
                         <?if($tem_acabamento=='S') {?><td width="40%"  id="acabamento" style="display:yes; font-weight:normal;"><div align="right"><input name="acabamento"  type="text" class="combo_cadastro" id="acabamento" value="<? echo  $acabamento ?>" size="78"></div></td>
                        <?}else{?><td width="40%" id="acabamento" style="display:none; font-weight:normal;"><divalign="right"><input name="acabamento"   type="text" class="combo_cadastro" id="acabamento" value="<? echo  $acabamento ?>" size="78"></div></td><?}?>
                       </tr>
                     </tr>
                   </table>

                    <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                        <tr>
                           <td  width="60%" class="texto_bold" valign="top"><div align="right">&nbsp;&nbsp;&nbsp;Observação:</div></td>
                           <td><textarea name="observacao" cols="80" rows="5" wrap="VIRTUAL" class="combo_cadastro" id="observacao"><? echo $observacao ?></textarea></td>
                        </tr>
                      </table>

                   <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                      <tr width="100%"><br>
                      <tr class="texto_bold">                      
                         <td width="20%"><div align="right">&nbsp;&nbsp;&nbsp;Atualizado por:</div></td>
                        <td width="50%"><div align="right"><input name="atualizado"  readonly="1" type="text" class="combo_cadastro" id="atualizado" value="<? echo  $atualizado ?>" size="45"></div></td>
                        <td width="10%"><div align="right">em:</div></td>
                        <td width="20%"><div align="right""><input name="data_catalog2"  readonly="1" type="text" class="combo_cadastro" id="data_catalog2" value="<? echo   $data_catalog2?>" size="15"></div></td>
                      </tr>
                      <tr class="texto_bold">                      
                         <td width="20%"><div align="right">&nbsp;&nbsp;&nbsp;Catalogado por:</div></td>
                        <td width="50%"><div align="right"><input name="catalogado"  readonly="1" type="text" class="combo_cadastro" id="catalogado" value="<? echo  $catalogado ?>" size="45"></div></td>
                        <td width="10%"><div align="right">em:</div></td>
                        <td width="20%"><div align="right"><input name="data_catalog1"  readonly="1" type="text" class="combo_cadastro" id="data_catalog1" value="<? echo  $data_catalog1 ?>" size="15"></div></td>
                      </tr>
                      </table>
                     <?if ($_REQUEST[form]=='parte') {?>
                     <table width="100%" id="rodape" border="0" style="background-color: #f2f2f2;">
                        <tr width="100%">
                             <td width="50%"><div align="center"><input align='middle' name="submit" type="submit"  style="visibility:<? if($_REQUEST[op]=='view') echo 'hidden' ?> " class="botao" value="Gravar">
                             </div><input name="op" type="hidden" value="<? echo $op ?>"></td>
                             <td width="50%"><div align="center"><input name="fechar" type="submit" onClick="cancela()"  class="botao" id="fechar" value="Fechar" >
                            </div></td>
                        <tr><td>&nbsp;</td></tr>
                        </tr>
                      </table>   
                     <?}else{?>
                     <table width="100%" id="rodape" border="0" style="background-color: #f2f2f2;">
                        <tr width="100%">
                             <td width="45%"><div align="right"><input align='middle' name="submit" type="submit"   onClick="cancela()" style="visibility:<? if($_REQUEST[op]=='view') echo 'hidden' ?> " class="botao" value="Gravar">
                             </div><input name="op" type="hidden" value="<? echo $op ?>"></td>
                             <td width="10%">&nbsp;</td>
                            <td width="45%"><div align="left"><input align='middle' name="restauro" type="submit"   onClick="restauro()" style="visibility:<? if($_REQUEST[op]=='view') echo 'hidden' ?> " class="botao" value="Incluir restauro">
                             </div></td>

                       <tr><td>&nbsp;</td></tr>
                          </tr>
                      </table>   

                     <?}?>
                    </div>                 



	   <!-- ABA 2 : IMAGEM -->


	  <!-- ABA 3: Lista de restauros : -->
	
             <div id="quadro2" height="100%" class="divi1" style="display:;  width:540px; ">
	     <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="f2f2f2" class="texto_bold">
                       <tr> 
                                  
                            <? if ($tipo2==1){$tipo2_2='I';}else{$tipo2_2='E';}?>

                                       <td><iframe name="abas" align="middle" src='lista_obras_restauro.php?lista=0&moldura=<?echo $_REQUEST[moldura];?>&tipo=4&tombo=<?echo $_REQUEST[tombo];?>&tipo2=<?echo $tipo2_2;?>' width="100%" height="400" frameborder="0" scrolling="auto" ALLOWTRANSPARENCY="true"></iframe></td>

                                                                           
                          </tr>             
                     </table>
                  </div>
        

</tr>
</table>
</td>
</table>
</form>
</body>
<? $val_altura_externa=formata_valor_1($_REQUEST['altura_externa']);
$val_largura_externa=formata_valor_1($_REQUEST['largura_externa']);
$val_profundidade_externa=formata_valor_1($_REQUEST['profundidade_externa']);

$val_altura_interna=formata_valor_1($_REQUEST['altura_interna']);
$val_largura_interna=formata_valor_1($_REQUEST['largura_interna']);

$val_peso=formata_valor_1($_REQUEST['peso']);

if ($_REQUEST[restauro]==true){
   if ($form=='restauro' or $form=='restauro_altera_ir' or $form=='restauro_altera_moldura')
      { 

       if ($form=='restauro_altera_ir')
       {
          echo "<script>location.href='restauro_altera_ir.php?op=update&tipo=4&ir=$_REQUEST[ir]'</script>";
       }
      if ($form=='restauro_altera_moldura')
       {
          echo "<script>location.href='restauro_altera_moldura.php?op=update&tipo=4&moldura=$mold_registro'</script>";

       }else{
          if ($tipo2==1 and ($obra>0) )
          {

 
             echo "<script>location.href='restauracao_moldura_interna.php?op=insert&tipo2=1&pnum_registro=$num_registro&controle=$controle&pId_parte=$parte&tipo=4&obra=$_REQUEST[obra]&moldura=$moldura&mold_registro=$mold_registro'</script>";
          }
             if ($tipo2==1 and ($obra>0) )
             {
                echo "<script>location.href='restauracao_moldura_interna.php?tipo2=1&tipo=4&moldura=$moldura&mold_registro=$mold_registro'</script>";
             }
            if ($tipo2==1 and ($obra<1) )
             {
                echo "<script>location.href='restauracao_moldura_externa.php?tipo2=1&tipo=4&moldura=$moldura&mold_registro=$mold_registro'</script>";
             }
               if ($tipo2==2)
                {
                   echo "<script>location.href='restauracao_moldura_externa.php?tipo2=2&tipo=4&moldura=$moldura&mold_registro=$mold_registro'</script>";
                }
             }
         } 
     

}
      

  if ($_REQUEST[op]=='update')
  {
     if($_REQUEST[submit]==true)
      {         
        if (trim($_REQUEST[peso])=='') $_REQUEST[peso]='0';
         $sql="update moldura set
              altura_interna='$val_altura_interna',
              largura_interna='$val_largura_interna',
 	      altura_externa='$val_altura_externa',
              largura_externa='$val_largura_externa',
              profundidade_externa='$val_profundidade_externa',
              peso='$val_peso',
              material_tecnica='$_REQUEST[material_tecnica]',
              suporte='$_REQUEST[suporte]', 
              observacao='$_REQUEST[observacao]',
              tem_ornamento='$_REQUEST[tem_ornamento]',
              tem_acabamento='$_REQUEST[tem_acabamento]', 
              ornamento='$_REQUEST[ornamento]', 
              acabamento='$_REQUEST[acabamento]', 
              formato='$_REQUEST[formato]',
              atualizado='$_SESSION[susuario]',
              data_catalog2=now(), 
              acabamento='$_REQUEST[acabamento]',
              num_registro='$_REQUEST[num_registro]',
              controle='$_REQUEST[controle]' where moldura='$_REQUEST[moldura]'";
              
        $db->query($sql);
        if ($mudou=true){
           $sql="update restauro set interna='I' where moldura='$moldura' and tipo='4'";
           $db->query($sql);
         }
         
        $atualizado=$_SESSION[susuario];
        $atualizado= ret_nome($atualizado);
        echo "<script>location.href='cadastro_moldura.php?op=update&tipo2=$tipo2&form=$form&obra=$obra&moldura=$moldura'</script>";
           
          
   
      }


  
    }

  
?>