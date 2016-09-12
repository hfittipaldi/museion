<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style type="text/css">
select {
  behavior: url("js/select_keydown.htc");
}
</style>
<script>

function abre_pagina(idobra,title)
{ 
  	win=window.open('consulta_obra_2.php?nosave=1&num_registro='+title+'&obra='+idobra,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-240)+',height=520,width=780,scrollbars=yes,status=no,toolbar=no,menubar=no,location=yes');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}

function cancela()
{
window.opener.location.reload();

window.close();



  return true;
}
function consulta()
{
if ($_REQUEST['consultar']==0){
    $_REQUEST['consultar']="consultar";

  }else{
    $_REQUEST['consultar']="consultar";
  }

location.reload();
}

function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-230)+',top='+((window.screen.height/2)-200)+',width=460,height=400, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}

function valida()
{
 with(document.form1)
 {
    if(obra.value==''){
	  alert('Selecione a obra!');
	  return false;}
	if(relacionamento.value==''){
	alert('Informe o relacionamento');
	return false;}
	
  }
}
function abre_manual(parametro)
{
  	win=window.open('manual_catalog.php?corfundo=cccccc&parametro='+parametro,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-130)+',height=450,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>  
</head>

      
 <?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");

$db=new conexao();
$db->conecta();
$db1=new conexao();
$db1->conecta();
$obrid=$_REQUEST['obrid'];
$tipo=$_REQUEST['tipo'];
$op=$_REQUEST['op'];
$db2=new conexao();
$db2->conecta();
$db3=new conexao();
$db3->conecta();
$op=$_REQUEST[op];
$obra=$_REQUEST[obra];
$obrarelORI=$_REQUEST['obrarelORI'];
$_REQUEST['consultar']="consultar";
$enviar=$_REQUEST['enviar'];

$obrarel=$_REQUEST['obrarel'];
$obranome=$_REQUEST['obranome'];

$obraSel=$_REQUEST[obraSel];
$nomeSel=$_REQUEST[nomeSel];
$susuario=$_SESSION[susuario];

    $sql2="SELECT num_registro, titulo_etiq FROM obra where obra='".$obra."'";
    $db2->query($sql2);
    $res2=$db2->dados();
    $_REQUEST[num_registro]=$res2[num_registro];
    $_REQUEST[titulo_etiq]=$res2[titulo_etiq];



	/////Paginando
	$pagesize=4;
        $page=1;
        if(!empty($_GET['page']))
            $page=$_GET['page'];
        $page--;
	$registroinicial=$page* $pagesize;

    $sql2="SELECT relacionamento FROM relacionamento r";
    $db2->query($sql2);
    $res2=$db2->dados();
    $_REQUEST[relacionamento]=$res2[relacionamento];





 if(isset($_REQUEST[obra]))
 {
  
  if($op=='update')
  {
    $sql="SELECT a.titulo,a.num_registro,b.* FROM obra AS a INNER JOIN relacionamento_obra as b on (a.obra=b.obrarel) where b.obra='$_REQUEST[obra]' and b.relacionamento='$_REQUEST[relacionamento]'";
    $db->query($sql);
    $res=$db->dados();



    $sql="select nome,relacionamento from relacionamento where relacionamento='$res[relacionamento]'";
    $db->query($sql);
    $resp=$db->dados();


    //
    // Salva os parametros de entrada para UPDATE
    //

    echo "<input type=hidden name=obrarelORI value='$_REQUEST[obrarelORI]'>";
    echo "<input type=hidden name=relacionamentoORI value='$_REQUEST[relacionamento]'>";
 
  }
  if($op=='del')
  {

	     $sql="DELETE from relacionamento_obra where obrarel='$_REQUEST[obrarel]' and obra='$_REQUEST[obra]' and relacionamento='$_REQUEST[relacionamento]' ";
             $db->query($sql);

             $sql="select obra,titulo,num_registro,colecao from obra where obra='$_REQUEST[obrarel]'";

             $db->query($sql);
             $resp=$db->dados();
             $obraDest=$resp[num_registro];
             $colecao=$resp[colecao];
             $titObraDest=str_replace($resp[titulo],'"','');
             $colrel=$colecao;

             $idObra=$resp[obra];

             $sql="select responsavel,nome from colecao where colecao='$colecao'";
 
             $db->query($sql);
             $resp=$db->dados();
             $usuario=$resp[responsavel]; 
             $colecaoDest=$resp[nome];     

             $sql="select obra,titulo,num_registro,colecao from obra where obra='$_REQUEST[obra]'";
             $db->query($sql);
             $resp=$db->dados();
             $obraOri=$resp[num_registro];
             $titObraOri=str_replace($resp[titulo],'"','');
             $colecao=$resp[colecao];
             $col=$colecao;

             if ($col==$colrel) {
	     	$sql="DELETE from relacionamento_obra where obrarel='$_REQUEST[obra]' and obra='$_REQUEST[obrarel]' and relacionamento='$_REQUEST[relacionamento]' ";
             	$db->query($sql);
             }

             $sql="select responsavel,nome from colecao where colecao='$colecao'";
             $db->query($sql);
             $resp=$db->dados(); 
             $colecaoOri=$resp[nome];

             $sql="select nome from relacionamento where relacionamento='$_REQUEST[relacionamento]'";
             $db->query($sql);
             $resp=$db->dados();
             $textoRel=$resp[nome];  

             $hoje=date("Y-m-d");

          

             $sql="insert into agenda(assunto, texto,data_aviso,eh_lida,data_inclusao,usuario_origem,usuario,eh_confirma,obrarel,obra,acao) 
                              values('Aviso de Relacionamento - Exclusão',
                                     'Ocorreu a Exclusão do relacionamento entre as obras $obraOri - $titObraOri ($colecaoOri) e $obraDest - $titObraDest ($colecaoDest)',
                                     '$hoje',
                                     0,
                                     '$hoje',
                                     $susuario,
                                     $usuario,0,$idObra,$_REQUEST[obra],'E')";
             $db->query($sql);



	     echo"<script>location.href='relacionamento_obra.php?lista=1&obra=$_REQUEST[obra]'</script>";
	     exit();
  }
 }	 
?>
           <body>

          <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
          <tr>
           <td valign="top">
            <form name="form1" method="post" onSubmit="return valida()" >

              <tr><td><br></td></tr>
                    <tr bgcolor="#96ADBE">
                       <td colspan="9" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
                    </tr>

                     <tr bgcolor="#96ADBE">
                        <td height="24" colspan="9" bgcolor="#96ADBE" class="texto_bold" style="color: white;"><div align="left"> &nbsp;Pesquisa de obra a relacionar com: <?echo $_REQUEST[num_registro]?>&nbsp;<?echo $_REQUEST[titulo_etiq] ?></div></td>
                 
                     </tr>
                     <tr>
                       <td colspan="9"width="100%" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
                     </tr>
                 <tr><td><br></td></tr>
 
   

         </table>
         

         <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">      

         <tr>
          <td><div align="right" class="texto_bold">Nº registro:</div></td>
          <td><input name="obrarel" type="text" class="combo_cadastro" id="obrarel" style="text-align:center;"tabindex="-1"  value="<?echo $obrarel;?>" size="8" maxlength="10"></td>
          <td><div align="center" class="texto_bold">Titulo:</div></td>
          <td><input name="obranome"type="text" class="combo_cadastro" id="obranome" style="text-align:center;"tabindex="-1"  value="<?echo $obranome;?>"  size="70" maxlength="45"></td>
          <td>&nbsp;&nbsp;&nbsp;</td>
         <td>
              <div align="right" tabindex="-1">
                <span class="texto_bold">
                   <input name="consultar" type="submit" class="botao" id="consultar" value="Consultar">
                </span>
              </div>
           </td>
           <td>&nbsp;&nbsp;&nbsp;</td>
         </tr>


         <tr><td><br></td></tr>
               



        
             <tr bgcolor="#96ADBE">
               <td colspan="9" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
            </tr>
            <tr width="100%" bgcolor="#ddddd5">
               <td colspan="9" width="100%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;&nbsp;Descrição da obra</div></td>
            </tr>
           <tr>
              <td height="2" colspan="9" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
           </tr>
 




        </table>


         <table width="100%" height="10%"  border="0" colspan="0" cellpadding="0" cellspacing="0" >
          <tr class="texto">
           <td width="1%"></td>
            <td width="94%"></td>
            <td width="5%"></td>
           </tr>






          <?
           if($_REQUEST['consultar']<>'')
             {  
                   
                if (($_REQUEST[obrarel]!='')and($_REQUEST[obranome]=='')) 
                {
                   $whereconsulta= "where num_registro='$_REQUEST[obrarel]'";                  
                }
                if (($_REQUEST[obranome]!= '') and ($_REQUEST[obrarel]== '')) 
                {
                   $whereconsulta= "where titulo_etiq like '%".$_REQUEST['obranome']."%'";
                }
                if (($_REQUEST[obrarel]!= '')  and ($_REQUEST[obranome]!='')) 
                {
                   $whereconsulta= "where (num_registro='$_REQUEST[obrarel]') and (titulo_etiq like '%".$_REQUEST['obranome']."%')";
                } 
                if ($whereconsulta <>'') 
                   { 
                      $whereconsulta=$whereconsulta." and "."(obra<>'$_REQUEST[obra]')" ;
                    }
             }


             if($_REQUEST['consultar']<>'')
             {
  
  

              
     

               if ($whereconsulta <> '')
                {

              $sql= "select count(*) from obra ".$whereconsulta;
                
	        $db->query($sql);
	        $numlinhas=$db->dados();
                $numlinhas=$numlinhas[0];


                $sql="select obra,titulo_etiq,num_registro,colecao from obra ".$whereconsulta." LIMIT $registroinicial,$pagesize";      
                $db->query($sql);
                while ($resp=$db->dados())
                {
                   $titObraDest=$resp[titulo_etiq];
                   $sqlautob="select autor from autor_obra where obra='$resp[obra]'";
                   $db3->query($sqlautob);            
                   $resautob=$db3->dados();
  

                   $sqlautor="select nomeetiqueta from autor where autor='$resautob[autor]'";  
                   $db3->query($sqlautor);          
                   $resautor=$db3->dados();
                   $autor=$resautor[nomeetiqueta];     

                   $sqlcolecao="select nome from colecao where colecao='$resp[colecao]'";  
                   $db3->query($sqlcolecao);          
                   $respcolecao=$db3->dados();
        
              ?>

             <tr><td>&nbsp;</td></tr>

              <tr whidth="100%" class="texto" id="cor_fundo<? echo $resp['obra'] ?>">
            
 
         
           <td>&nbsp;</td>
           <td><b><? echo "&nbsp".$resp['num_registro']."&nbsp"." - " ?></b><?echo $autor."&nbsp"?><b><? echo $titObraDest."&nbsp" ?></b><? echo $respcolecao[nome];?></td>
             </td>


  
         <td align="center"><? echo "<a href=\"relacionamento_obra1.php?obra"."=".$_REQUEST[obra]."&op"."=".$_REQUEST[op]."&obrarel=".$resp[num_registro]."&enviar=enviar"."&consultar=".$_REQUEST['consultar']."&obraSel"."=".$resp[num_registro]."&nomeSel"."=".$resp[titulo_etiq]."\">
						<img src='imgs/icons/ic_adicionar.gif' border='0' alt='Adicionar à lista' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";?>
                
                </td>
         


      
                   <td  align="center">
 
                           <a href='javascript:;' onClick="abre_pagina(<? echo $resp['num_registro'] ?>,'<? echo htmlentities(str_replace("'","`",$resp['num_registro']), ENT_QUOTES); ?>');">
                                <img src='imgs/icons/ic_alterar.gif' width='20' height='20' border='0' alt='Ficha técnica'>
                          </a>
                       </td>


              </tr>
           
	    <?}
           }}?>
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('relacionamento_obra1.php?op=<?echo $op;?>&obra=<?echo $_REQUEST[obra];?>&tipo=<?echo $tipo;?>&obranome=<?echo $obranome;?>&obrarel=<?echo $obrarel;?>&page='+ i);

}}
</script>
           <tr class="texto">
              <td colspan="5">&nbsp;</td>
              <td></td>  
  
            </tr>

                      
                      <tr><td align="center">&nbsp;</td></tr>
                      <tr>
                         <td height="1" colspan="6" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
                      </tr>
                      <tr whidth="100%" class="texto">
                         <td align="left" whidth="100%" border="0" colspan="5" height="10">

                         <? 
                         //////Retomando a Paginacao
                         $numpages=ceil($numlinhas/$pagesize); 
                         $page_atual=$page+1;
                         $mais=$page_atual+1;
                         $menos=$page_atual-1;
                         $first=1;  
                         $last=$numpages;
                         if($mais>$numpages)
                         $mais=$numpages;

                          
                         $a="<a href=\"relacionamento_obra1.php?page=".$first."&op=".$op."&obra=".$_REQUEST[obra]."&tipo=".$tipo."&obranome=".$obranome."&obrarel=".$obrarel."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";
                         $b="<a href=\"relacionamento_obra1.php?page=".$menos."&op=".$op."&obra=".$_REQUEST[obra]."&tipo=".$tipo."&obranome=".$obranome."&obrarel=".$obrarel."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";
                         $c="<a href=\"relacionamento_obra1.php?page=".$mais."&op=".$op."&obra=".$_REQUEST[obra]."&tipo=".$tipo."&obranome=".$obranome."&obrarel=".$obrarel."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";
                         $d="<a href=\"relacionamento_obra1.php?page=".$last."&op=".$op."&obra=".$_REQUEST[obra]."&tipo=".$tipo."&obranome=".$obranome."&obrarel=".$obrarel."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
			 $combo="";
 			 for($i=1;$i<=$numpages;$i++)
 			 {
  			 if ($i==$page_atual) {
    			    $combo = $combo . "<option value='$i' selected >$i</option>";}
  			 else{
  			    $combo.="<option value='$i'>$i</option>";}
 			  }
  			  $lista_combo="<select name=i value=$i onChange='obtem_valor(this)'; >$combo</select>";  
 			  if ($last < 2) {
				$lista_combo= "";
				$a= "";
				$b= "";
				$c= "";
				$d= "";
				  }

		            $g= " Total de registros encontrados: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
			    ".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
			    echo"&nbsp";

                            echo"<font color='003366'>$g</font>";   
                           ?>
                       <div align="center"></div></td>
                           
                   </tr>
                   <tr>
                      <td height="2" colspan="6" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
                   </tr>
                   <tr>

                   </tr>

          <tr class="texto">
            <td width="1%"></td>
            <td width="40%"></td>
            <td width="40%"></td>
            <td width="10%"></td>
          </tr>

        </table>
        <table width="100%" height="10%"  border="0" colspan="0" cellpadding="0" cellspacing="0" >
          <tr class="texto">

          <tr class="texto">
            <td width="100%"></td>

          </tr>
 <tr>
   
          <td colspan="0"> 
                <div align="center">
                  <span class="texto_bold">
                   <input name="cancelar" type="submit" class="botao" id="cancelar" value="Cancelar" onClick="cancela();">
                  </span>
                </div>
              </td>

   
  
	</tr>         




              </table>
             

 
      </table>

      
      <br>
      <?

         if($_REQUEST['enviar']<>'') {

         
           if($_REQUEST[op]=='update')
            {

             //
             // Primeiro deleta o registro com os dados da chamada do form
             //
	     $sql="DELETE from relacionamento_obra  where obrarel='$_REQUEST[obrarelORI]' and obra='$_REQUEST[obra]' and relacionamento='$_REQUEST[relacionamentoORI]' ";
             $db->query($sql);
 

             $sql="select obra,titulo,num_registro,colecao from obra where obra='$_REQUEST[obrarelORI]'";
             $db->query($sql);
             $resp=$db->dados();
             $obraDest=$resp[num_registro];
             $colecao=$resp[colecao];
             $titObraDest=str_replace($resp[titulo],'"','');
 

             $idObra=$resp[obra];

             $sql="select responsavel,nome from colecao where colecao='$colecao'";
             $db->query($sql);
             $resp=$db->dados();
             $usuario=$resp[responsavel]; 
             $colecaoDest=$resp[nome]; 
    

             $sql="select obra,titulo,num_registro,colecao from obra where obra='$_REQUEST[obra]'";
             $db->query($sql);
             $resp=$db->dados();
             $obraOri=$resp[num_registro];
             $titObraOri=str_replace($resp[titulo],'"','');
             $colecao=$resp[colecao];


             $sql="select responsavel,nome from colecao where colecao='$colecao'";
             $db->query($sql);
             $resp=$db->dados(); 
             $colecaoOri=$resp[nome];


             $sql="select nome from relacionamento where relacionamento='$_REQUEST[relacionamentoORI]'";
             $db->query($sql);
             $resp=$db->dados();
             $textoRel=$resp[nome];  


             $hoje=date("Y-m-d");



	     //
             // Depois inclui o registro com os dados do Form
             //
             $sql="select obra from obra where num_registro='$_REQUEST[obrarel]'";
             $db->query($sql);
             $resp=$db->dados();
             $idObra=$resp[obra];
             $sql= "INSERT INTO relacionamento_obra(obra, relacionamento, obrarel) values('$obra','$_REQUEST[relacionamento]','$idObra')";
	     $db->query($sql);


             $sql="select obra,titulo,num_registro,colecao from obra where obra='$idObra'";
             $db->query($sql);
             $resp=$db->dados();
             $obraDest=$resp[num_registro];
             $colecao=$resp[colecao];
             $titObraDest=str_replace($resp[titulo],'"','');
 

             $sql="select responsavel,nome from colecao where colecao='$colecao'";
             $db->query($sql);
             $resp=$db->dados();
             $usuario=$resp[responsavel]; 
             $colecaoDest=$resp[nome];  

             $sql="select obra,titulo,num_registro,colecao from obra where obra='$_REQUEST[obra]'";
             $db->query($sql);
             $resp=$db->dados();
             $obraOri=$resp[num_registro];
             $titObraOri=str_replace($resp[titulo],'"','');
             $colecao=$resp[colecao];


             $sql="select responsavel,nome from colecao where colecao='$colecao'";
             $db->query($sql);
             $resp=$db->dados(); 
             $colecaoOri=$resp[nome];

             $sql="select nome from relacionamento where relacionamento='$_REQUEST[relacionamento]'";
             $db->query($sql);
             $resp=$db->dados();
             $textoRel=$resp[nome];  

             $hoje=date("Y-m-d");

             $sql="insert into agenda(assunto, texto,data_aviso,eh_lida,data_inclusao,usuario_origem,usuario,eh_confirma,obrarel,obra,acao) 
                              values('Aviso de Relacionamento - Inclusão',
                                     'Ocorreu a criação de um relacionamento entre as obras $obraOri - $titObraOri ($colecaoOri) e $obraDest - $titObraDest ($colecaoDest)',
                                     '$hoje',
                                     0,
                                     '$hoje',
                                     $susuario,
                                     $usuario,0,$idObra,$_REQUEST[obra],'I')";

             $db->query($sql);


	     echo"<script>alert('Relacionamento efetuado com sucesso.')</script>";
                   echo"<script>window.opener.location.reload()</script>";
                   echo"<script>window.close()</script>";
             


           }

          elseif($_REQUEST[op]=='insert'){
             $sql="select obra,titulo,num_registro,colecao from obra where num_registro='$_REQUEST[obrarel]'";
             $db->query($sql);
             $resp=$db->dados();
             $obraDest=$resp[num_registro];
             $colecao=$resp[colecao];
             $titObraDest=str_replace($resp[titulo],'"','');
             $colrel=$colecao;

             $idObra=$resp[obra];

             $sql="select responsavel,nome from colecao where colecao='$colecao'";
             $db->query($sql);
             $resp=$db->dados();
             $usuario=$resp[responsavel]; 
             $colecaoDest=$resp[nome];     

             $sql="select obra,titulo,num_registro,colecao from obra where obra='$obra'";
             $db->query($sql);
             $resp=$db->dados();
             $obraOri=$resp[num_registro];
             $titObraOri=str_replace($resp[titulo],'"','');
             $colecao=$resp[colecao];
             $col=$colecao;

             $sql="select responsavel,nome from colecao where colecao='$colecao'";
             $db->query($sql);
             $resp=$db->dados(); 
             $colecaoOri=$resp[nome];

             $sql="select nome from relacionamento where relacionamento='$_REQUEST[relacionamento]'";
             $db->query($sql);
             $resp=$db->dados();
             $textoRel=$resp[nome];  

             $sql= "INSERT INTO relacionamento_obra(obra, relacionamento, obrarel) values('$obra','$_REQUEST[relacionamento]','$idObra')";
	     $db->query($sql);

             if ($col==$colrel) {
             	$sql= "INSERT INTO relacionamento_obra(obra, relacionamento, obrarel) values('$idObra','$_REQUEST[relacionamento]','$obra')";
	     	$db->query($sql);
             }

             $hoje=date("Y-m-d");

             $sql="insert into agenda(assunto, texto,data_aviso,eh_lida,data_inclusao,usuario_origem,usuario,eh_confirma,obrarel,obra,acao) 
                              values('Aviso de Relacionamento - Inclusão',
                                     'Ocorreu a criação de um relacionamento entre as obras $obraOri - $titObraOri ($colecaoOri) e $obraDest - $titObraDest ($colecaoDest)',
                                     '$hoje',
                                     0,
                                     '$hoje',
                                     $susuario,
                                     $usuario,0,$idObra,$obra,'I')";
             
             $db->query($sql);
            

             //
	     echo"<script>alert('Inclusão realizada com sucesso.')</script>";
                   echo"<script>window.opener.location.reload()</script>";
                   echo"<script>window.close()</script>";
            }
	 
         }   




	             
             

      ?>


               
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>


    </td>

  </tr>
</table>
</body>

</html>
