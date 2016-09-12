<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

<script language="JavaScript">
 totlinhas= 0;

function abrepop3(janela,alt,larg) {
	win=window.open(janela,'impressao','left='+((window.screen.width/2)-370)+',top='+((window.screen.height/2)-290)+',width=740,height=560,menubar=yes, toolbar=yes, scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
 }

function abrepopExcel(janela,alt,larg) {
	win=window.open(janela,'impressao','left='+((window.screen.width/2)-370)+',top='+((window.screen.height/2)-290)+',width=100,height=100,menubar=yes, toolbar=yes, scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
                Win.window.close;
	}
}


function fecha_pop()
{
 setTimeout('window.close()',60000);
 return true;
}
function cancela()
{
 document.form1.cancelar.submit=window.close();
 return true;
}



function inicia_modelo() {              
   document.getElementById("modelo1").checked= true;
   document.getElementById("modelo2").checked= true;
   document.getElementById("modelo3").checked= true;
   document.getElementById("modelo4").checked= false;
   document.getElementById("modelo5").checked= true;
   document.getElementById("modelo6").checked= false;
   document.getElementById("modelo7").checked= false;
   return true;
   }


function muda_modelo($val) {
 
   if ($val=='1')
      
     { 
         if (document.getElementById("modelo1").checked==true)
         { 
            document.form1.dmodelo1.value=1;
         }else{
            document.form1.dmodelo1.value=0;
         }
        if (document.getElementById("modelo2").checked==true)
         { 
            document.form1.dmodelo2.value=1;
            document.form1.dmodelo1.value=1;
         }else{
            document.form1.dmodelo2.value=0;
         }
        if (document.getElementById("modelo3").checked==true)
         { 
            document.form1.dmodelo3.value=1;
         }else{
            document.form1.dmodelo3.value=0;
         }
        if (document.getElementById("modelo4").checked==true)
         { 
            document.form1.dmodelo4.value=1;
         }else{
            document.form1.dmodelo4.value=0;
         }
        if (document.getElementById("modelo5").checked==true)
         { 
            document.form1.dmodelo5.value=1;
         }else{
            document.form1.dmodelo5.value=0;
         }
       if (document.getElementById("modelo6").checked==true)
         { 
            document.form1.dmodelo6.value=1;
         }else{
            document.form1.dmodelo6.value=0;
         }

      if (document.getElementById("modelo7").checked==true)
         { 
            document.form1.dmodelo7.value=1;
         }else{
            document.form1.dmodelo7.value=0;
         }

     }	        
}
</script>

</head>
<?
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");

	$db=new conexao();
	$db->conecta();
 
        $dir_virtual = diretorio_virtual();
        $txtpesquisa = $_REQUEST[pesquisa];
                $num = $_REQUEST[num];
            $usuario = $_REQUEST[usuario];
              $tfont = $_REQUEST[tfont];
             $tfonta = $_REQUEST[tfonta];
 

        $sqldir="SELECT valor from parametro where parametro='URL_ETIQUETA'";
        $db->query($sqldir);
        $url=$db->dados();
        $dirurl=$url[0]."etiqueta_".$usuario.".xls";  
?>



<body onLoad="inicia_modelo(<? echo $_REQUEST['modelo']; ?>)";>
   <table width="100%"  height="100%">
      <tr>
        <td>


           <?$download=$_REQUEST[usuario];?>
           <form name="form1" method="post" action="">
           <input type=hidden id=dmodelo1 name=dmodelo1 value="1">
           <input type=hidden id=dmodelo2 name=dmodelo2 value="1">
           <input type=hidden id=dmodelo3 name=dmodelo3 value="1">
           <input type=hidden id=dmodelo4 name=dmodelo4 value="0">
           <input type=hidden id=dmodelo5 name=dmodelo5 value="1">
           <input type=hidden id=dmodelo6 name=dmodelo6 value="0">
           <input type=hidden id=dmodelo7 name=dmodelo7 value="0">    
           
 
           <table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2"> 
             <?echo "<span class='tit_interno'>$_SESSION[lnk]"." / Etiqueta"."</span>";?>
              <tr width="34%">
	         <td width="30%"  align="left" style="border-bottom: 1px solid #34689A;border-top: 1px solid #34689A;border-left: 1px solid #34689A;">                                        
                    <font bgcolor='#c7c7c7' style='font-family:arial,times new roman;color:brown; font-weight:normal; font-size:12px;'>&nbsp;<? echo $num." obras selecionadas"; ?></span>
                 </td>
 	         <td width="30%" align="right" style="border-bottom: 1px solid #34689A;border-top: 1px solid #34689A;border-right: 1px solid #34689A;">                                        
                    <a href="javascript:;" style="text-decoration: none;" onClick="abrepop3('pre_impressao_etiq.php?usuario=<?echo $usuario;?>&tfa='+document.form1.tfonta.value+'&tf='+document.form1.tfont.value+'&modelo1='+document.form1.dmodelo1.value+'&modelo2='+document.form1.dmodelo2.value+'&modelo3='+document.form1.dmodelo3.value+'&modelo4='+document.form1.dmodelo4.value+'&modelo5='+document.form1.dmodelo5.value+'&modelo6='+document.form1.dmodelo6.value+'&modelo7='+document.form1.dmodelo7.value)"><sub><img src="imgs/icons/ic_etiq.gif" border="0" title="Gera etiqueta de acordo com a seleção abaixo"></sub></a>&nbsp;&nbsp;&nbsp;                      
                    <a href="download.php?download=<?echo $download;?>&usuario=<?echo $usuario;?>&tfa=18&tf=12&modelo1=1&modelo2=1;" style="text-decoration: none;" onClick=""><sub><img src="imgs/icons/ic_download.gif" border="0" title="Download do arquivo gerado no excel"></sub></a>&nbsp;&nbsp;&nbsp;       
                    <a href="javascript:;" style="text-decoration: none;" onClick="window.close();"><sub><img src="imgs/icons/ic_sair.gif" border="0" title="Sair"></sub></a>&nbsp;&nbsp; 
                 </td>
              </tr>
           </table>
        </td>
      </tr>
      <tr>
        <td width="100%" height="100%" valign="top" style="border-bottom: 1px solid #34689A;border-top: 1px solid #34689A;border-left: 1px solid #34689A;border-right: 1px solid #34689A;" >
  
  
          <table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#ffffff" >

             <tr width="100%">
              <td>
               <tr><td>&nbsp;</td></tr>
                <tr>
                  <td width="100%" colspan="1">
                    <div align="left">
                        <span class="texto_bold">
                           <input type="checkbox" name="modelo1" id="modelo1" value="1" onClick="muda_modelo(1); this.focus();">Gera arquivo Excel
                        </span>
                    </div>
                   </td>
                </tr>
                <tr>
                  <td>
                    <table border ="0">
                        <tr>
                         <td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <td width="100%" >
                               <div align="left">
                                  <span class="texto">
                                     <input type="checkbox" name="modelo2" id="modelo2" value="2" onClick="muda_modelo(1); this.focus();">com tradução para o Inglês 
                                  </span>
                               </div>
                            </td>
                          </td>
                        </tr>          
                      </table>
                    </td>
                 </tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                   <td width="100%" colspan="1">
                     <div align="left">
                         <span class="texto_bold">
                             <input type="checkbox" name="modelo3" id="modelo3" value="3" onClick="muda_modelo(1); this.focus();">Gera relatório 
                         </span>
                     </div>
                   </td>        
                 </tr>
                 <tr>
                  <td>
                    <table border ="0">
                        <tr>
                         <td>
                              <td width="50%">
                               <div align="left">
                                  <span class="texto">
                                    <input type="checkbox" name="modelo4" id="modelo4" value="4" onClick="muda_modelo(1); this.focus();">com tradução para o Inglês 
                                  </span>
                               </div>
                            </td>
                               <td class="texto" width="90%" valign="top" style="" ><b>fonte</b> autor:<input valign="center" name="tfonta" type="text" class="combo_cadastro"  id="tfonta" value="18" size="3"></td>                
                               <td>&nbsp;&nbsp;&nbsp;</td>
                              <td>&nbsp;&nbsp;&nbsp;</td>
                          </td>
                        </tr>
                        <tr>                  
                           <td>
                              <td width="100%">
                                 <div align="left">
                                    <span class="texto">
                                      <input type="radio" name="modelo" id="modelo5" value="5" onClick="muda_modelo(1); this.focus();"> sem imagem 
                                    </span>
                                 </div>
                              </td>
                               <td class="texto" width="90%" valign="top" style="" >texto:  <input valign="center" name="tfont" type="text" class="combo_cadastro"  id="tfont" value="12" size="3"></td>                
                               <td>&nbsp;&nbsp;&nbsp;</td>
                              <td>&nbsp;&nbsp;&nbsp;</td>
                           </td>
                        </tr>                 
                        <tr>
                           <td>
                              
                              <td width="100%">
                                 <div align="left"><span class="texto">
                                   <input type="radio" name="modelo" id="modelo6" value="6" onClick="muda_modelo(1); this.focus();"> com imagem 
                                 </div>
                              </td>
                           </td>
                        </tr>                  
                        <tr>
                         <td>
                           <td width="100%" colspan="1">
                             <div align="left"><span class="texto">
                                <input type="radio" name="modelo" id="modelo7" value="7" onClick="muda_modelo(1); this.focus();"> somente com imagem de obra tridimencional 
                              </div>
                          </td>
                         </td>
                        </tr>
                       </td>
                      </tr> 
                     </table>
                   </td>
                  </tr>
               </table>
            </form>
         </td>
      </tr>
   </table>
</body>
</html>
