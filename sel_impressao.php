<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

<script language="JavaScript">
 totlinhas= 0;
function abrepop1(janela,alt,larg) {
        
	win=window.open(janela,'impressao','left='+((window.screen.width/2)-300)+',top='+((window.screen.height/2)-250)+',width=700,height=500,menubar=no, toolbar=no, scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
 }
function abrepop2(janela,alt,larg) {
        
	win=window.open(janela,'impressao','left='+((window.screen.width/2)-250)+',top='+((window.screen.height/2)-250)+',width=850,height=750,scrollbars=yes,menubar=yes, resizable=yes');
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


function abrepop4(janela,alt,larg) {
	
	win=window.open(janela,'impressao','left=4000,top=4000,width=1,height=5, menubar=none, toolbar=none, scrollbars=none, resizable=true');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
 }

function abrepopvisual(janela,alt,larg) {
        
	win=window.open(janela,'impressao','left='+((window.screen.width/2)-50)+',top='+((window.screen.height/2)-50)+',width=300,height=60,menubar=none, toolbar=none, scrollbars=yes, resizable=none');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
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


function hint($val) {  
   if ($val=='0')
   {            
      if (document.getElementById("hint0").style.display==''){ document.getElementById("hint0").style.display= 'none';}
      if (document.getElementById("hint0").style.display=='none') {document.getElementById("hint0").style.display= '';}
      document.getElementById("hint2").style.display= 'none';
      document.getElementById("hint").style.display= 'none';
      document.getElementById("hint3").style.display= 'none';
      document.getElementById("hint4").style.display= 'none';
   }

   if ($val=='1')
   {            
      if (document.getElementById("hint").style.display==''){ document.getElementById("hint").style.display= 'none';}
      if (document.getElementById("hint").style.display=='none') {document.getElementById("hint").style.display= '';}
      document.getElementById("hint2").style.display= 'none';
      document.getElementById("hint0").style.display= 'none';
      document.getElementById("hint4").style.display= 'none';
      document.getElementById("hint3").style.display= 'none';

   }
   if ($val=='2')
   {            
      if (document.getElementById("hint2").style.display==''){ document.getElementById("hint2").style.display= 'none';}
      if (document.getElementById("hint2").style.display=='none') {document.getElementById("hint2").style.display= '';}
      document.getElementById("hint").style.display= 'none';
      document.getElementById("hint0").style.display= 'none';
      document.getElementById("hint3").style.display= 'none';
      document.getElementById("hint4").style.display= 'none';


   }
   if ($val=='3')
   {            
      if (document.getElementById("hint3").style.display==''){ document.getElementById("hint3").style.display= 'none';}
      if (document.getElementById("hint3").style.display=='none') {document.getElementById("hint3").style.display= '';}
      document.getElementById("hint").style.display= 'none';
      document.getElementById("hint0").style.display= 'none';
      document.getElementById("hint2").style.display= 'none';
      document.getElementById("hint4").style.display= 'none';


   }
   if ($val=='3')
   {            
      if (document.getElementById("hint3").style.display==''){ document.getElementById("hint3").style.display= 'none';}
      if (document.getElementById("hint3").style.display=='none') {document.getElementById("hint3").style.display= '';}
      document.getElementById("hint").style.display= 'none';
      document.getElementById("hint0").style.display= 'none';
      document.getElementById("hint2").style.display= 'none';
      document.getElementById("hint4").style.display= 'none';
   }
   return true;
   }

function inicia_modelo() {     
   document.getElementById("comimagem").value=false;
   document.getElementById("tridimensional").value= false;         
   document.getElementById("tridimensional").checked= false;         
   document.getElementById("traducao").checked= false;
   document.getElementById("traducao").value= false;           
   document.getElementById("rodape").checked= true;
   document.getElementById("rodape").value= true;
   document.getElementById("info_filtro").checked= false;
   document.getElementById("info_filtro").value= false;
   document.getElementById("etiqueta").checked= false;
   document.getElementById("etiqueta").value= false;
   document.getElementById("comimagem").checked= false;


   document.getElementById("hint0").style.display= 'none';
   document.getElementById("hint").style.display = 'none';
   document.getElementById("hint2").style.display= 'none';
   document.getElementById("hint3").style.display= 'none';
   document.getElementById("hint4").style.display= 'none';
   document.getElementById("relatorio").style.display='';
   document.getElementById("relatorioid").style.display='';
   document.getElementById("rel_etiqueta").style.display='none';
   document.getElementById("dow_etiqueta").style.display='none';

 

   return true;
   }

function AtualizaAte(valor) {

   document.getElementById("ate").value=valor;
   return true;

}


function muda_modelo($val) {
 
   if ($val=='1')
      
     { 


        if (document.getElementById("etiqueta").checked==true)
         { 

             document.getElementById("etiqueta").value= true;
             document.getElementById("info_filtro").value= false;
             document.getElementById("info_filtro").checked= false;
             document.getElementById("info_filtro").disabled= true;
             document.getElementById("rodape").value= false;
             document.getElementById("rodape").checked= false;
             document.getElementById("rodape").disabled= true;
             document.getElementById('relatorio').style.display='none';
             document.getElementById('rel_etiqueta').style.display='';
             document.getElementById("dow_etiqueta").style.display='';
             document.getElementById("relatorioid").style.display='none';

          }else{
             document.getElementById("etiqueta").value= false;
             document.getElementById("info_filtro").value= true;
             document.getElementById("info_filtro").disabled= false;
             document.getElementById("rodape").value= true;
             document.getElementById("rodape").disabled= false;
             document.getElementById("relatorio").style.display='';
             document.getElementById("relatorioid").style.display='';
             document.getElementById('rel_etiqueta').style.display='none';
             document.getElementById("dow_etiqueta").style.display='none';

          }
        if (document.getElementById("tridimensional").checked==true)
         { 
   	     document.getElementById("tridimensional").value= true;
                   document.getElementById("comimagem").disabled= true;
                  document.getElementById("comimagem").value=false;


         }else{
    	     document.getElementById("tridimensional").value= false;
                   document.getElementById("comimagem").disabled=false;
           }
       if (document.getElementById("traducao").checked==true)
         { 
   	     document.getElementById("traducao").value= true;
         }else{
    	     document.getElementById("traducao").value= false;
           }

         if (document.getElementById("rodape").checked==true)
         { 
   	     document.getElementById("rodape").value= true;
         }else{
    	     document.getElementById("rodape").value= false;
           }

        if (document.getElementById("info_filtro").checked==true)
         { 
   	     document.getElementById("info_filtro").value= true;
         }else{
    	     document.getElementById("info_filtro").value= false;
           }
        


        if (document.getElementById("comimagem").checked==true)
         { 
   	     document.getElementById("comimagem").value= true;
                   document.getElementById("tridimensional").disabled= true;
                   document.getElementById("tridimensional").value= false;


         }else{
    	     document.getElementById("comimagem").value= false;
                   document.getElementById("tridimensional").disabled= false;
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

	$db9=new conexao();
	$db9->conecta();

	$dbHTML=new conexao();
	$dbHTML->conecta();       
	

	$dbPA=new conexao();
	$dbPA->conecta();       

        $dir_virtual = diretorio_virtual();
        $txtpesquisa = $_REQUEST[pesquisa];
                $num = $_REQUEST[num];
            $usuario = $_REQUEST[usuario];
              $tfont = $_REQUEST[tfont];
             $tfonta = $_REQUEST[tfonta];
                 $de = $_REQUEST[de];
                $ate = $_REQUEST[ate];
     $txtpesquisa_rel= Trim($_REQUEST[txtpesquisa_rel]);
   


             
function temimagem($ob)
{
 global $db;
 $count=0;
 $sql="select distinct obra from fotografia_obra where obra in (".$ob.")";
 $db->query($sql);
 while($row=$db->dados())
 {$count++;}
 return $count;
} 
        $pagesize=5;
        $id_obras= $_SESSION['s_impressao'];
      


        $id_obras= substr($id_obras,1,-1); // colocado o parametro ,-1 para desprezar a ultima virgula da string (PBL - 10/09/2008)
        
        if ($id_obras == '') $id_obras= 0;
        $_SESSION['s_temimagem']=temimagem($id_obras);
        $sql= "SELECT count(*) from obra where obra in ($id_obras) order by num_registro + 0";
        $db->query($sql);
        $numlinhas=$db->dados();
        $numlinhas=$numlinhas[0];
        $numpages=ceil($numlinhas/$pagesize); 
	$modeloR=$_GET['modelo'];
        //echo "Modelo: ".$modeloR;


                     $sqlPA="SELECT VALOR FROM PARAMETRO WHERE parametro='ETAPAS_IMPRESSAO'";
                     $dbPA->query($sqlPA);
                     $resPA=$dbPA->dados();
                     $LIMIT= $resPA[0];

?>



<body onLoad="inicia_modelo()">

   <table width="100%"  height="100%" border="0"  style="border-bottom: 1px solid #34689A;border-top: 1px solid #34689A;border-left: 1px solid #34689A;border-right: 1px solid #34689A;">  
 

           <?$download=$_REQUEST[usuario];
               $usuario=$_REQUEST[usuario];?>
              
           <form name="form1" method="post" action="">
           <input type=hidden id=drodape name=drodape value="true">
           <input type=hidden id=total name=total value="<? echo $num?>">
           
           <input type=hidden id=dcomimagem name=dcomimagem value="true">
           <input type=hidden id=dtridimensional name=dtridimensional value="true">
           <input type=hidden id=dtraducao name=dtraducao value="true">


   <?//  ###################################################    ?>   
       <tr width="100%" height="100%">
         <td width="80%" height="10%">
          <table width="100%" height="10%" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2"> 
             <?echo "<span class='tit_interno'>$_SESSION[lnk]"." / Relatório"."</span>";?>
              <tr width="100%" height="100%" >
	      <td width="70%"  align="left" style="border-bottom: 1px solid #34689A;border-top: 1px solid #34689A;border-left: 1px solid #34689A;">                                        
                        <font bgcolor='#c7c7c7' style='font-family:arial,times new roman;color:blue; font-weight:normal; font-size:12px;'>&nbsp;<? echo $num." obras selecionadas com ".$_SESSION['s_temimagem']." imagens."; ?></span>&nbsp;


              </td> 
	      <td width="30%"  align="right" style="border-bottom: 1px solid #34689A;border-top: 1px solid #34689A;border-right: 1px solid #34689A;">                                        
                    <?
	          $relatorio="pre_impressao_obras.php?txtpesquisa_rel=$txtpesquisa_rel&modelo=$modeloR&totpag=$_SESSION[paginas]";
	          $confimpressao="conf_impressao.php?txtpesquisa_rel=$txtpesquisa_rel&modelo=$modeloR&totpag=$_SESSION[paginas]";
	          $relatorio_exemplo="pre_impressao_exemplo.php?txtpesquisa_rel=$txtpesquisa_rel&modelo=$modeloR&totpag=$_SESSION[paginas]";
                       if ( $num>$LIMIT){  ?>
                     
                               <a style="" id="relatorio"        href="javascript:;" style="text-decoration: none;" onmousemove="hint(1);"onClick="abrepop1('<?echo $relatorio_exemplo;?>&ultpag=0&etiqueta='+document.form1.etiqueta.value+'&info_filtro=' +document.form1.info_filtro.value+'&total=' +document.form1.total.value+'&rodape='+document.form1.rodape.value+'&modelo2=false&comimagem='+document.form1.comimagem.value+'&traducao='+document.form1.traducao.value+'&tridimensional='+document.form1.tridimensional.value+'&tfa='+document.form1.tfonta.value+'&tf='+document.form1.tfont.value+'&distancia=2')"><sub><img src="imgs/icons/lupa.gif" border="0" title="Exemplo"></sub></a>&nbsp; 		                                        
                               <a style="" id="relatorioid"      href="javascript:;" style="text-decoration: none;" onmousemove="hint(3);"onClick="abrepop2('<?echo $relatorio;?>&ultpag=0&etiqueta='+document.form1.etiqueta.value+'&etapas='+document.form1.etapas.value+'&info_filtro=' +document.form1.info_filtro.value+'&total=' +document.form1.total.value+'&rodape='+document.form1.rodape.value+'&modelo2=false&comimagem='+document.form1.comimagem.value+'&traducao='+document.form1.traducao.value+'&tridimensional='+document.form1.tridimensional.value+'&tfa='+document.form1.tfonta.value+'&tf='+document.form1.tfont.value+'&distancia=2')"><sub><img src="imgs/icons/ic_lista.gif" border="0" title="Imprimir"></sub></a>&nbsp;         
                               <a style="" id="rel_etiqueta"   href="javascript:;" style="text-decoration: none;" onmousemove="hint(0);" onClick="abrepop3('pre_impressao_etiq.php?usuario=<?echo $usuario;?>&tfa='+document.form1.tfonta.value+'&tf='+document.form1.tfont.value+'&modelo1=0&modelo2=0&modelo4='+document.form1.traducao.value+'&modelo5='+document.form1.comimagem.value+'&modelo6='+document.form1.comimagem.value+'&modelo7='+document.form1.tridimensional.value+'&etapas='+document.form1.etapas.value)"><sub><img src="imgs/icons/ic_etiq.gif" border="0" title="Etiqueta"></sub></a>&nbsp;                                      
                      <?  }else{?>
                             <a style="" id="relatorio"        href="javascript:;" style="text-decoration: none;" onmousemove="hint(1);"onClick="abrepop1('<?echo $relatorio_exemplo;?>&ultpag=0&etiqueta='+document.form1.etiqueta.value+'&info_filtro=' +document.form1.info_filtro.value+'&total=' +document.form1.total.value+'&rodape='+document.form1.rodape.value+'&modelo2=false&comimagem='+document.form1.comimagem.value+'&traducao='+document.form1.traducao.value+'&tridimensional='+document.form1.tridimensional.value+'&tfa='+document.form1.tfonta.value+'&tf='+document.form1.tfont.value+'&distancia=2')"><sub><img src="imgs/icons/lupa.gif" border="0" title="Exemplo"></sub></a>&nbsp; 		                                        
                               <a style="" id="relatorioid"      href="javascript:;" style="text-decoration: none;" onmousemove="hint(3);"onClick="abrepop2('<?echo $relatorio;?>&ultpag=0&etiqueta='+document.form1.etiqueta.value+'&etapas=&info_filtro=' +document.form1.info_filtro.value+'&total=' +document.form1.total.value+'&rodape='+document.form1.rodape.value+'&modelo2=false&comimagem='+document.form1.comimagem.value+'&traducao='+document.form1.traducao.value+'&tridimensional='+document.form1.tridimensional.value+'&tfa='+document.form1.tfonta.value+'&tf='+document.form1.tfont.value+'&distancia=2')"><sub><img src="imgs/icons/ic_lista.gif" border="0" title="Imprimir"></sub></a>&nbsp;         
                               <a style="" id="rel_etiqueta"   href="javascript:;" style="text-decoration: none;" onmousemove="hint(0);" onClick="abrepop3('pre_impressao_etiq.php?usuario=<?echo $usuario;?>&tfa='+document.form1.tfonta.value+'&tf='+document.form1.tfont.value+'&modelo1=0&modelo2=0&modelo4='+document.form1.traducao.value+'&modelo5='+document.form1.comimagem.value+'&modelo6='+document.form1.comimagem.value+'&modelo7='+document.form1.tridimensional.value)"><sub><img src="imgs/icons/ic_etiq.gif" border="0" title="Etiqueta"></sub></a>&nbsp;                                      
                      <?   }?>
                        <a style="" id="dow_etiqueta"   href="download.php?download=<?echo $download;?>&usuario=<?echo $usuario;?>&tfa=18&tf=12&modelo1=1&modelo2=1;" onmousemove="hint(3);"  style="text-decoration: none;" " onmousemove="hint(4);"  onClick=""><sub><img src="imgs/icons/ic_download.gif" border="0" title="Salvar"></sub></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       
                        <a href="javascript:;" style="text-decoration: none;" onmousemove="hint(2);" onClick="window.close();"><sub><img src="imgs/icons/ic_sair.gif" border="0" title=""></sub></a>&nbsp; 
                    </td>
               </tr>
           </table>
         </td>
      </tr> 



   <?//  ###################################################    ?>   
       <tr width="100%"  height="60%" >
        <td width="100%" height="100%" valign="top" style="border-top: 1px solid #34689A;border-left: 1px solid #34689A;border-right: 1px solid #34689A;" >
           <table width="100%" height="100%" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
               <tr width="100%">
                 <td>             
                    <tr>
                       <td width="2%">&nbsp;</td>
                       <td width="43%" >
                        <div align="left">
                        <span class="texto_bold">&nbsp;Configurar página:
                        </span>
                      </div>
                      </td>
                       <td width="43%" >

                       <?

                        if ($LIMIT>0 and $num>$LIMIT) 
                       {?>

                        <div align="left">
                        <span class="texto_bold">&nbsp;&nbsp;&nbsp;&nbsp;Configurar impressão:
                        </span>
                      </div>
                     <?}?>

                      </td>
                    </tr>
               <tr><td>&nbsp;</td></tr>

               <tr><td width="2%">&nbsp;</td>
                  <td width="43%" >
                    <div align="left">
                        <span class="texto_bold">
                           <input type="checkbox" name="rodape" id="rodape" value="false" onClick="muda_modelo(1); this.focus();">com cabeçalho
                        </span>
                    </div>
                   </td> 
                  <?
                                      
                  if ($LIMIT>0 and $num>$LIMIT) 
                  {?>
                <td width="43%" >
  
                    <div align="left">
                        <span class="texto"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Etapas:</b></span>
  
                        <select class="combo_cadastro" name="etapas" id="etapas"  value=""  onChange=""> 
                        <?   
                        $combo="";
                        $numpages=($num/$LIMIT);
                        $numpages=str_replace(".", ",", $numpages);
                        $sobra=split(',', $numpages);
                        if ($sobra<>'') $numpages=$numpages+1;
                        $page_atual=0;
                        for($i=0;$i<=$numpages;$i++) 
                        {  $y=$i*$LIMIT;
                           if ($i==0) {
                                 $ini='';
                                 $fim='Todas';
                                }else{
                                  $ini=(($y-$LIMIT)+1);
                                  $fim=$y;
                                  if ($sobra<>'' and $i==$numpages) $fim=$num;
                                  
                              }
                           if ($i>0){
                                     $y="de ".$ini." até ".$fim;
                            }else{
                               $y=$fim;
                            }

                           if ($i==$page_atual) {?>                           
                           <option value=<?echo $ini."/".$fim;?> selected ><? echo $y; ?></option>
                       <? }else{?>
                            <option value=<?echo $ini."/".$fim;?>><? echo $y; ?></option>
                        <? }}?>
                         </select>
                    </div>
                   </td>
                   <?}?>
             
                  </tr>
       		 <tr><td width="2%">&nbsp;</td>
                  <td width="43%" >
                    <div align="left">
                        <span class="texto_bold">
                           <input type="checkbox" name="info_filtro" id="info_filtro" value="false" onClick="muda_modelo(1); this.focus();">com detalhes da seleção
                        </span>
                    </div>
                   </td>           
                  </tr>

                <tr><td width="2%">&nbsp;</td>
                  <td width="43%" >
                    <div align="left">
                        <span class="texto_bold">
                           <input type="checkbox" name="comimagem" id="comimagem" value="true" onClick="muda_modelo(1); this.focus();">com imagem
                        </span>
                    </div>
                   </td>

                    </tr>
                <tr><td width="2%">&nbsp;</td>
                   <td width="43%" >
                      <div align="left">
                         <span class="texto_bold">
                            <input type="checkbox" name="tridimensional" id="tridimensional" value="false" onClick="muda_modelo(1); this.focus();">somente com imagem de obra tridimensional
                          </span>
                       </div>
                     </td>
                  </tr>          

        
                  <tr><td width="2%">&nbsp;</td>
                   <td width="43%" >
                      <div align="left">
                         <span class="texto_bold">
                            <input type="checkbox" name="traducao" id="traducao" value="false" onClick="muda_modelo(1); this.focus();">com tradução para o Inglês 
                          </span>
                       </div>
                     </td>
                  </tr>          
  
                <tr><td width="2%">&nbsp;</td>
                  <td width="43%" >
                    <div align="left">
                        <span class="texto_bold">
                           <input type="checkbox" name="etiqueta" id="etiqueta" value="false" onClick="muda_modelo(1); this.focus();">Etiqueta
                        </span>
                    </div>
                   </td>           
                  </tr>
 
                 <tr><td>&nbsp;</td></tr>
                  <tr><td width="2%">&nbsp;</td>
                  <td width="43%" >
                    <div align="left">
                        <span class="texto_bold">
                               <b>&nbsp;fonte:&nbsp;</b>             
                                            
                     </span>
                    </div>
                   </td>           
                  </tr>

                   <tr><td width="2%">&nbsp;</td>
                  <td width="43%" >
                    <div align="left">
                        <span class="texto">&nbsp;&nbsp;&nbsp;autor<input valign="center" name="tfonta" type="text"   id="tfonta" value="18" size="3"></span>
                    </div>
                   </td>
                  </tr>
                  <tr><td width="2%">&nbsp;</td>
                  <td width="43%" >
                    <div align="left">
                        <span class="texto">&nbsp;&nbsp;&nbsp;texto <input valign="center" name="tfont" type="text"   id="tfont" value="13" size="3"></span>
                    </div>
                   </td>           
                  </tr>

  
                  </td>
                </tr>
               </table>
             </td>
<?//##########################################################################?>

       
        </tr>      
      <tr width="50%" height="10%">
         <td   height="10%" valign="top" style="border-bottom: 1px solid #34689A;border-left: 1px solid #34689A;border-right: 1px solid #34689A;" >
            <table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#ffffff" >
               <?if ( $_SESSION['s_temimagem']>100){?>
                     <tr>
                     <td width="100%" valign="bottom" align="left"><font style='font-family:arial,times new roman; color:blue; font-weight:normal; font-size:13px;'><em>Atenção: Verifique no final do relatório se todas as obras foram exibidas. A opção 'etapas' permite imprimir as <?echo $num;?> obras de <?echo $LIMIT;?> em <?echo $LIMIT;?>.</em></font></td>
                     </tr>
                  <?}?>

              </table>
          </td>
        </tr > 
        <tr>
         <td height="10%" valign="bottom" >
            <table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#ffffff" >
                     <tr>
                     <td width="100%" valign="top" align="left" class="texto_bold" id="hint0"><font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;color:brown;'><i>Visualiza e imprime etiqueta de acordo com a seleção acima.</i></font></td>
                     <td width="100%" valign="top" align="left" class="texto_bold" id="hint"> <font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;color:brown;'><i>Visualiza o modelo de impressão gerado de acordo com seleção acima.</i></font></td>
                     <td width="100%" valign="top" align="left" class="texto_bold" id="hint2"><font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;color:brown;'><i>sair</i></font></td>
                     <td width="100%" valign="top" align="left" class="texto_bold" id="hint3"><font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;color:brown;'><i>Imprime relatório de acordo com a seleção acima.</i></font></td>
                     <td width="100%" valign="top" align="left" class="texto_bold" id="hint4"> <font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;color:brown;'><i>Salva etiqueta</i></font></td>
                     </tr> 
              </table>
          </td>

        </tr>
 
  </table>
</body>
</html>
