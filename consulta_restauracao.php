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



include_once("seguranca.php"); 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$obraid=$_REQUEST[obraid];
$tipo2=$_REQUEST[tipo2];




///////////////////////////////////////

$tecnico= $_SESSION['snome'];


if ($obraid > 0)
{
$sql="select a.*,b.*, c.*, d.*, d.obra as obraid from restauro as a, restauro_moldura as b,  moldura as c, parte as d 
             where (a.restauro=b.restauro) and (a.parte=c.parte) and (a.parte=d.parte) and (a.moldura=c.moldura) and a.restauro=$_REQUEST[id]";echo $sql;
 $db->query($sql);
 $res=$db->dados();
 $seq_restauro=$res['seq_restauro'];


 //////////////////////////////////
 ////////////PARTE////////////////
 //////////////////////////////////

     $controle=$res['controle'];
  $nome_objeto=$res['nome_objeto'];
      $moldura=$res['moldura'];
}else{
$sql="select a.*,b.*, c.* from restauro as a, restauro_moldura as b,  moldura as c 
             where (a.restauro=b.restauro) and (a.moldura=c.moldura) and a.restauro=$_REQUEST[id]";
 $db->query($sql);
 $res=$db->dados();
 $seq_restauro=$res['seq_restauro'];
 $obraid=$res['obraid'];

}
     
  //////////////////////////////////
 ////////////RESTAURO////////////////
 //////////////////////////////////

         $obra=$res['obra'];
      $interna=$res['interna'];
 $_REQUEST[ir]=$res['ir'];
     $controle=$res['controle'];
  $nome_objeto=$res['nome_objeto'];
        $autor=$res['autor'];
       $titulo=$res['titulo'];
        $tombo=$res['tombo'];
 $data_entrada=formata_data($res['data_entrada']);
  $data_inicio=formata_data($res['data_inicio']);
   $data_saida=formata_data($res['data_saida']);
      $tecnico=$res['tecnico'];
      $colecao=$res['colecao'];

   //////////////////////////////////
 ////////////RESTAURO_MOLDURA/////////
 //////////////////////////////////
     $restauro=$res['restauro']; 
      $moldura=$res['moldura'];
$mold_registro=$res['mold_registro'];
   $assinatura=$res['assinatura'];
  $conservacao=$res['estado_conservacao'];
   $tratamento=$res['tratamento'];
   


   /////////////////////////////////
 ////////////MOLDURA/////////////////
 //////////////////////////////////

 $parte=$res['parte'];
 $material_tecnica=$res['material_tecnica'];
 $altura_interna=$res['altura_interna'];
 $largura_interna=$res['largura_interna'];
 $altura_externa=$res['altura_externa'];
 $largura_externa=$res['largura_externa'];
 $profundidade_externa=$res['profundidade_externa']; 
 $peso=$res['peso'];
 $formato=$res['formato'];
 $suporte=$res['suporte'];
 $observacao=$res['observacao'];
 $tem_ornamento=$res['tem_ornamento'];
 $tem_acabamento=$res['tem_acabamento'];
 $ornamento=$res['ornamento'];
 $acabamento=$res['acabamento'];
 $suporte=$res['suporte'];
 $observacao=$res['observacao'];
 $catalogado=ret_nome($res['catalogado']);
 $atualizado=ret_nome($res['atualizado']);
 if ($res['catalogado'] > 0  and $res['catalogado'] <> '' ) $data_catalog1= convertedata($res['data_catalog1'],'d/m/Y - h:i');
 if ($res['atualizado'] > 0  and $res['atualizado'] <> '' ) $data_catalog2= convertedata($res['data_catalog2'],'d/m/Y - h:i');
 

if ($tem_ornamento<>'S')  {$ornamento='  ';}
if ($tem_acabamento<>'S') {$acabamento='  ';}
 

   if($data_entrada == '00/00/0000')
	$data_entrada= '';
   
   if($data_inicio == '00/00/0000')
	$data_inicio= '';
   
   if($data_saida == '00/00/0000')
	$data_saida= '';

?>

<style type="text/css">
<!--
#abas a {
	font-size: 12px;
	font-weight: bold;
	color: #f2f2f2;
	text-decoration: none;
}
.divi {
	scrollbar-arrow-color:#f2f2f2;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#f2f2f2;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
.divi1 {	scrollbar-arrow-color:#f2f2f2;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#f2f2f2;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
-->
</style>

<script>
function esconde()
{
   document.getElementById("moldura").style.display="";
   document.getElementById("conservacao").style.display="none";
   document.getElementById("tratamento").style.display="none";
}
function navega(opcao)
{
 switch(opcao)
 {
    case 0: //Moldura
	{
	  with(document)
	   {
	     getElementById("moldura").style.display="";
	     getElementById("conservacao").style.display="none";
		 getElementById("tratamento").style.display="none";
	   } 
      break;
	}
    case 1: //Estado de conservação
	{
	  with(document)
	  {
	   getElementById("conservacao").style.display="";
	   getElementById("moldura").style.display="none";
	   getElementById("tratamento").style.display="none";

	  }
    break;
   }
      case 2: //tratamento
	{
	  with(document)
	  {
	   getElementById("tratamento").style.display="";
	   getElementById("moldura").style.display="none";
	   getElementById("conservacao").style.display="none";
	  }
    break;
   }
 
 }
} 
//
function getobject(obj){
   if (document.getElementById)
      return document.getElementById(obj)
   else if (document.all)
      return document.all[obj]
}
function controle_lista(lista,imagem){
 obj=getobject(lista);
 if (obj.style.display == "block"){ 
    obj.style.display = "none"; 
    getobject(imagem).src="imgs/icons/mais.gif"
 } else {
   obj.style.display = "block";
  getobject(imagem).src="imgs/icons/menos.gif"
 }
}
</script>

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
<title><? echo str_replace('\"','"',$_REQUEST['titulo']); ?></title><body class="combo_cadastro" onload='esconde()' >
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
    </div></th>
  </tr>
 <?
 // retorna o valor da colecao referente à obra q esta sendo passada para ser incluida no log_pesquisa
 






?>
<table align="top" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" bgcolor="#f2f2f2">
   <tr align="top">
       <td align="center" colspan="0" width="20%"  height="100%" bgcolor="#ffffff">
        <table width="150" height="100%" border="0" colspan="0"  align="center">

           <tr align="center"  height="100%" >
               <td valign="center" width="100" border="1"  cellpadding="0" cellspacing="0" >
                 <? echo "<iframe align='center' src='imagem_lista_consulta_mold.php?tipo2=$tipo2&id=$restauro&obraid=$obraid' width='200' height='100%'  frameborder='0' scrolling='off' ALLOWTRANSPARENCY='true'></iframe>";?>
               </td>
           </tr> 
          </table> 
      </td>

      <td colspan="0" width="80%"  height="100%" border="0" bgcolor="#f2f2f2">
         <table  border="0" width="100%" heigth="100%" bgcolor="#f2f2f2">
            <tr>
               <td nowrap class="combo_cadastro">
                 <table colspan="0" width="100%" border="0">
                    <tr>
                       <td nowrap class="combo_cadastro" width="100%" >
                          <input name="Submit" type="submit" onClick="navega(0);"class="text" style="width: 180px;" value=" Moldura " >
                          <input name="Submit" type="submit" onClick="navega(1);"class="text" style="width: 180px;" value="Estado de conservação">
                          <input name="Submit" type="submit" onClick="navega(2);"class="text" style="width: 180px;" value="Tratamento"> 
                          <a href="javascript:window.close()" class="texto_bold"><? echo "<img src=imgs/icons/ic_remover.gif border=0 alt='Fechar' align='baseline'>&nbsp;&nbsp;Fechar</a>"; ?></a>
                       </td>
                    </tr>
                 </table>

 		   <div id="moldura" height="444" style="display:">
    		      <table width="100%" height='100%' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
       		         <tr>
                            <?if ($interna=='I'){?><td width="20%"class="texto_bold" align="right">INTERNA</td><?}?>
                            <?if ($interna=='E'){?><td width="20%"class="texto_bold" align="right">EXTERNA</td><?}?>
                           <td width="20%"class="texto_bold" align="right">Moldura nº:&nbsp;</td>
                            <td width="60%" class="texto_bold" align="left"><? echo "<span class='texto'>$mold_registro</span>"; ?></td>
     			 </tr>
                       </table>                                

                       <table width="100%" height='100%' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
      		         <tr>
                           <td width="20%"class="texto_bold" align="right">Material técnica:&nbsp;</td>
                           <td width="80%" class="texto_bold" align="left"><? echo "<span class='texto'>$material_tecnica</span>"; ?></td>
       		         </tr>
   		          <tr>
                           <td width="20%"class="texto_bold" align="right">Dimensões:&nbsp;</td>
                           <td width="80%" class="texto_bold" align="left">&nbsp;</td>
                           </tr>

                       </table>

                       <table width="100%" height='100%' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
   		          <tr>
                           <td width="25%"class="texto_bold" align="right">Externas&nbsp;</td>
                           <td width="75%" class="texto_bold" align="left">&nbsp;</td>
                           </tr>
                       </table>
                       <table width="100%" height='100%' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                          <tr>
                            <td width="30%"class="texto_bold" align="right">largura:</td>
                            <td width="10%" class="texto_bold" align="left"><? echo "<span class='texto'>$largura_externa</span>"; ?></td>
                            <td width="20%"class="texto_bold" align="right">Altura:</td>
                            <td width="10%" class="texto_bold" align="left"><? echo "<span class='texto'>$altura_externa</span>"; ?></td>
                            <td width="20%"class="texto_bold" align="right">Profundidade:</td>
			    <td width="10%" class="texto_bold" align="left"><? echo "<span class='texto'>$profundidade_externa</span>"; ?></td>
      			  </tr>
                        </table>
                        <table width="100%" height='100%' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
      		          <tr>
                            <td width="25%"class="texto_bold" align="right">Internas&nbsp;</td>
                            <td width="75%" class="texto_bold" align="left">&nbsp;</td>
                          </tr>
                        </table>
                        <table width="100%" height='100%' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                          <tr>
                            <td width="30%"class="texto_bold" align="right">largura:</td>
                            <td width="10%" class="texto_bold" align="left"><? echo "<span class='texto'>$largura_interna</span>"; ?></td>
                            <td width="20%"class="texto_bold" align="right">Altura:</td>
                            <td width="10%" class="texto_bold" align="left"><? echo "<span class='texto'>$altura_interna</span>"; ?></td>
                            <td width="20%"class="texto_bold" align="right">Peso(kg):</td>
                            <td width="10%" class="texto_bold" align="left"><? echo "<span class='texto'>$peso</span>"; ?></td>
                       </table>
                        <table width="100%" height='100%' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                            <td width="30%"class="texto_bold" align="right">Formato:<?
                                 if($formato=='')  $nome_formato='';
  		      		 if($formato=='C') $nome_formato='Circular';
  		      		 if($formato=='I') $nome_formato='Irregular';
  		      		 if($formato=='L') $nome_formato='Losângulo';
  		      		 if($formato=='O') $nome_formato='Oval';
  		      		 if($formato=='T') $nome_formato='Triangular';
                                 echo "<span class='texto'>$nome_formato</span>"; ?>
                             </td>
                             <td width="10%" class="texto_bold" align="right">&nbsp;</td>
                             <td width="20%"class="texto_bold" align="right">&nbsp;</td>
                             <td width="10%" class="texto_bold" align="right">&nbsp;</td>
                             <td width="20%"class="texto_bold" align="right">&nbsp;</td>
                             <td width="10%" class="texto_bold" align="right">&nbsp;</td>
       			  </tr>
    		       </table>

                   
                       <table width="100%" height='100%' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
      		         <tr>
                           <td width="20%"class="texto_bold" align="right" valign="top">Observação:&nbsp;</td>
                           <td width="90%"class="texto_bold" align="left"><textarea cols="90" rows="5" wrap="VIRTUAL" class="combo_cadastro" ><? echo $observacao ?></textarea></td></tr>

       		         </tr>
                       </table>

                      <table width="100%" height='100%' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
      		         <tr>
                           <td width="20%"class="texto_bold" align="right">Catalogado por:&nbsp;</td>
                           <td width="45%"class="texto_bold" align="left"><? echo "<span class='texto'>$catalogado</span>"; ?></td>
                           <td width="5%"class="texto_bold" align="right">em:&nbsp</td>
                           <td width="20%"class="texto_bold" align="left"><? echo "<span class='texto'>$data_catalog1</span>"; ?></td>
       		         </tr>

     		         <tr>
                           <td width="20%"class="texto_bold" align="right">Alterado por:&nbsp;</td>
                           <td width="50%"class="texto_bold" align="left"><? echo "<span class='texto'>$atualizado</span>"; ?></td>
                           <td width="5%"class="texto_bold" align="right">em:&nbsp</td>
                           <td width="20%"class="texto_bold" align="left"><? echo "<span class='texto'>$data_catalog2</span>"; ?></td>
       		         </tr>

                       </table>


  		   </div>
 

 		   <div id="conservacao" style="display:">

                    <table width="100%" height='414' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                        <tr height='50%'>
                           <td width="10%"class="texto_bold" valign="top" align="right">Estado:&nbsp;</td>
                           <td width="90%"class="texto_bold" align="left"><textarea cols="90" rows="10" wrap="VIRTUAL" class="combo_cadastro" ><? echo $conservacao ?></textarea><br><br><br><br><br><br><br><br><br></td>
                         </tr>
      	             <tr height='30%'>
                            <td width="10%"class="texto_bold" align="right">Suporte:&nbsp;</td>
                            <td width="90%"class="texto_bold" align="left"><? echo "<span class='texto'>$suporte</span>"; ?></td>
        		</tr>
     		<tr height='10%'>
                            <td width="10%"class="texto_bold" align="right">Ornamento:&nbsp;</td>
                            <td width="90%"class="texto_bold" align="left"><? echo "<span class='texto'>$ornamento</span>"; ?></td>
        		 </tr>
 		<tr height='10%'>
                             <td width="10%"class="texto_bold" align="right">&nbsp;</td>
                             <td width="90%"class="texto_bold" align="left">&nbsp;</td>
        		 </tr>
 		 <tr height='10%'>
                              <td width="10%"class="texto_bold" align="right">&nbsp;</td>
                               <td width="90%"class="texto_bold" align="left">&nbsp;</td>
        		 </tr>

                       </table>

    		   </div>

 	        <div id="tratamento" style="display:">
    	         <table width="100%" height='400' border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">       		         
                         <tr height='50%'>
                           <td width="10%" class="texto_bold" valign="top"><div align="left">Tratamento:&nbsp</div></td>
                           <td width="90%"class="texto_bold" align="left"><textarea cols="90" rows="10" wrap="VIRTUAL" class="combo_cadastro" ><? echo $tratamento?></textarea><br><br><br><br><br></td>
                         </tr>
                         <tr height='50%'>           
                          <td width="10%"class="texto_bold" align="right">Restaurador:&nbsp</td>
                          <td width="20%"class="texto_bold" align="left"><? echo "<span class='texto'>$assinatura</span>"; ?></td>      		        
      		         </tr>
    		      </table>

                      <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#f2f2f2">
                         <tr width="100%">
                               <td class="texto_bold" align="right"><div align="right">Data de Entrada:</div></td>
                               <td class="texto_bold" align="left"><? echo "<span class='texto'>$data_entrada</span>"; ?></td>
		               <td class="texto_bold" align="right"><div align="right">In&iacute;cio:</div></td>
			       <td class="texto_bold" align="left"><? echo "<span class='texto'>$data_inicio</span>"; ?></td>
			       <td class="texto_bold" align="right"><div align="right">Sa&iacute;da:</div></td>
			       <td class="texto_bold" align="left"><? echo "<span class='texto'>$data_saida</span>"; ?></td>
                           </tr>
                      </table>

  		   </div>
               </td>
           </tr>
         </table> 
      </td>
    </tr>
</table>
</body>
