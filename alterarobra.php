<?
include_once("seguranca.php"); 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
set_time_limit(0);
$db=new conexao();
$db->conecta();
$tituloobra=$_REQUEST['titulo'];
    $dir= diretorio_fisico_rotacao();
if($_REQUEST[submit]==false && $_REQUEST[op]=='insert')
{
        
	$libera_status= liberacao_automatica();

        //
        // Se statusInicial=1, Fixa liberação em P (Publicada) (PBL) PRD17
        //
	if ($_REQUEST[statusInicial]==1) {
            $libera_status="P";
        }
	
        $sql="insert into obra(num_registro,inventario,status,catalogado,data_catalog1) 
        values('$_REQUEST[num]','0','$libera_status','$_SESSION[susuario]',now())"; 
        $db->query($sql);
	$id_obra=$db->lastid();//para obter o id e carregar a pagina ja com o numero setado.
	$_REQUEST['obra']=$id_obra;
}

//Antes de abrir a obra, aplicar a permissão das coleções//
if ($_REQUEST[op] <> 'insert') {
	// Primeiro verifica se o usuário é Administrador //
	$sql= "SELECT nivel from usuario where usuario = $_SESSION[susuario]";
	$db->query($sql);
	$niv_usu=$db->dados();
	if ($niv_usu[0] == 'A') {
		// nada a fazer
	} else {
	//
	$sql= "SELECT colecao,num_registro,status from obra where obra = $_REQUEST[obra]";
	$db->query($sql);
	$col=$db->dados();
	if ($col['colecao'] <> 0) {
		$sql= "SELECT count(*) as tot from usuario_colecao where usuario = $_SESSION[susuario] AND colecao = $col[colecao]";
		$db->query($sql);
		$tot=$db->dados();
		$tot=$tot['tot'];
		if ($tot <> 1) {
			if ($col['status'] == 'P') {
				$_SESSION['lnk']= "&nbsp;Consultas / Obras / Pesquisa";
				echo"<script>if (confirm('Usuário sem permissão para alterar a obra.\\nDeseja abrir no módulo de consulta?')) {
					top.location.href='principal.php?ptarget=obraconsulta1&num_registro=".$col[num_registro]."';}
					else { location.href= 'alterar_obra.php'; }</script>";
			} else {
				echo"<script>alert('Usuário sem permissão para alterar a obra.');
					location.href= 'alterar_obra.php';</script>";
			}
		}
	}
} }
?>
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
}
-->
</style>
<script language="JavaScript">


function abrepopExposicao(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-340)+',top='+((window.screen.height/2)-200)+',width=700,height=440, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}

function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-125)+',top='+((window.screen.height/2)-150)+',width=300,height=300, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4)
    {
        win.window.focus();
    }
 return true;
}

function abre_manual(parametro)
{
  	win=window.open('manual_catalog.php?janela=popup&corfundo=f2f2f2&parametro='+parametro,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-150)+',scrollbars=yes, height=365,width=560,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}

function copia_campo()
{
  with(document.frmobra)
  {
    if(titulo_etiq.value=='')
	{
	  titulo_etiq.value=titulo.value;
	 }
 }
}
setTimeout('verifica_carregamento()',60000);

function verifica_carregamento() {
	if (document.getElementById('wait').style.display == '') {
//		alert('Falha no carregamento. Clique OK para tentar novamente.');
		location.href= 'alterarobra.php?obra=<? echo $_REQUEST[obra] ?>';
	}
}

function ajustaAbas(index) {
	numAbas= 8;

	if (index == 1)
		document.getElementById("aba1").style.borderLeftColor= "";
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

	if( index==3 || index==4 || index==5 || index==6 || index==7 || index==8 )
	{
	document.frmobra.submit.style.display="none";
	document.getElementById('rodape').style.display="none";
	}
   else
   {
	document.getElementById('rodape').style.display="";
	document.frmobra.submit.style.display="";
	}
}

function valida()
{
  with(document.frmobra)
  {           
    if(eh_destaque_acervo.value=='#'){
	  ajustaAbas(1);
      alert('Informe se a obra é de destaque ou não!');
	  return false;}
    if(colecao.value=='0'){
	  ajustaAbas(1);
      alert('Preencha com o tipo da coleção!');
	  return false;}
	if(forma_aquisicao.value==''){
	  ajustaAbas(2);
	  alert('Preencha com a forma de aquisição!');
	  return false;}
	if(local_fixo.value==0){
	  ajustaAbas(2);
	  alert('Preencha com a localização fixa!');
	  return false;}

  if (material.value==''){
	  ajustaAbas(1);
                alert('Informe o material!');
                material.focus();
	  return false;}

    if(titulo.value==''){
	  ajustaAbas(1);
	  alert('Preencha com o título da obra!');
	  titulo.focus();
	  return false;}
 	/*if(titulo_etiq.value==''){
	  ajustaAbas(1);
	  alert('Preencha com o título para etiqueta!');
	  titulo_etiq.focus();
	  return false;}*/
    if(dt_aqano.value!='' && dt_aq_extra1.value!='')
	 {
	   if(dt_aqano.value>dt_aq_extra1.value)
	     {
	        ajustaAbas(2);
			alert('Primeiro campo-ano não pode ser maior do que o segundo campo-ano.');
	        dt_aqano.focus();
	        return false;}
      }
     }

 
 }
</script>
<script>

function filler(x) {
	return true;
}

padrao=/^[+-]?((\d+|\d{1,3}(\.\d{3})+)[(\,\d*)?|\,\d+)]$/;


function testavalor(e)
{
 
 if(e.value!='')
 {
      OK = padrao.exec(e.value);
 if (!OK){
    window.alert ("Valor numérico inválido\n Utilize apenas duas casas decimais separados por virgula.");
	ajustaAbas(1);
	e.value='';
	e.focus();
	return false;
       
 } else { 
   return true;
    }
}
}
///////////

//////////
function Add(i,parametro){
   if(parametro!=''){
  var item=parametro+";";
  document.getElementById(i).value+=item;
  }}
 ////////


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
<body onLoad='document.getElementById("wait").style.display="none"; ajustaAbas(<? echo $aba ?>);'>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
    </div></th>
  </tr>
 <?
   /// Funcao q troca o usuario da sessao pelo seu nome correspondente.
   function ret_nome($idnome)
   {
    global $db;
	$sql="select nome from usuario where usuario=$idnome";
	$db->query($sql);
	$nome=$db->dados();
	return $nome[0];
    }

   $anotacao="";
   $sql="select texto from obra_anotacao where obra='$_REQUEST[obra]' and usuario='$_SESSION[susuario]'";
   $db->query($sql);
   while($row=$db->dados())
   {
      $anotacao=$row['texto'];
   }

   $sql="select a.* from obra as a where a.obra='$_REQUEST[obra]'";
   $db->query($sql);
   while($row=$db->dados())
	  { 
		$obra=$row['obra'];
		//$museu_origem=$row['museu'];
		$num_registro=$row['num_registro'];
		$destaque=$row['eh_destaque_acervo'];
		$colecao=$row['colecao'];
		$inventario=$row['inventario'];
		if ($inventario == "0,00")
			$inventario= '';
		$controle_inv=$row['controle_inv'];
		$status=$row['status'];
		$forma_aquisicao=$row['forma_aquisicao'];
		$local_fixo=$row['local_fixo'];
		$trainel_gaveta=$row['trainel_gaveta'];
		$objeto=$row['objeto'];
		$copia=$row['copia'];
		$titulo=$row['titulo'];
                            $requisito_detalhe=$row['requisito_detalhe'];
		$num_serie=$row['num_serie'];
		$material=$row['material_tecnica'];
		$titulo_ingles=$row['titulo_ingles'];
		$titulo_etiq=$row['titulo_etiq'];
		$texto_etiq=$row['texto_etiq']; //ultimo reg da tabela
		$periodo=$row['periodo'];
		$escola=$row['escola'];
        	$movimento=$row['movimento'];
	        $estilo=$row['estilo'];
		$impressor=$row['impressor'];
        	$editor=$row['editor'];
	    	$num_edicao=$row['num_edicao'];
		$desc_conteudo=$row['desc_conteudo'];
		$subtema=$row['sub_tema'];
//data
		$dt_aqdia= $row['dt_aquisicao_dia'];
		$dt_aqmes= $row['dt_aquisicao_mes'];
		$dt_aqano= $row['dt_aquisicao_ano1'];
		$dt_aq_extra1= $row['dt_aquisicao_ano2'];
		$dt_aq_extra2= $row['dt_aquisicao_tp'];
/*		dtformato_externo($dt_aq_di, $dt_aq_df, '', $data['dia'], $data['mes'], $data['ano'], $data['ano2']);
		$dt_aqdia= $data['dia'];
		$dt_aqmes= $data['mes'];
		$dt_aqano= $data['ano'];
		$dt_aq_extra1= $data['ano2'];*/
		if ($dt_aqdia == 0)
			$dt_aqdia= "";
		if ($dt_aqmes == 0)
			$dt_aqmes= "";
		if ($dt_aqano == 0)
			$dt_aqano= "";
		if ($dt_aq_extra1 == 0)
			$dt_aq_extra1= "";
//
		$num_processo=$row['num_processo'];
		$doador=$row['doador'];
		$val_compra=$row['val_compra'];
		$val_seguro=$row['val_seguro'];
		$ex_proprietarios=$row['ex_proprietarios'];
		$obs=$row['obs'];
		$catalogado=ret_nome($row['catalogado']);
		$atualizado= ret_nome($row['atualizado']);
//
		$dim_obra_altura=formata_valor_3(trim($row['dim_obra_altura']));
	   	$dim_obra_largura=formata_valor_3(trim($row['dim_obra_largura']));
	   	$dim_obra_diametro=formata_valor_3(trim($row['dim_obra_diametro']));
	   	$dim_obra_profund=formata_valor_3(trim($row['dim_obra_profund']));
	   	$dim_obra_peso=formata_valor_3(trim($row['dim_obra_peso']));
	   	$dim_obra_formato=$row['dim_obra_formato'];
	   	$aimp_obra_altura=formata_valor_3(trim($row['aimp_obra_altura']));
	   	$aimp_obra_largura=formata_valor_3(trim($row['aimp_obra_largura']));
	   	$aimp_obra_diametro=formata_valor_3(trim($row['aimp_obra_diametro']));
	   	$aimp_obra_formato=$row['aimp_obra_formato'];

       ///
	 $data_catalog1=convertedata($row['data_catalog1'],'d/m/Y - h:i');
	 if($row[data_catalog2]=='0000-00-00 00:00:00')
		{ $data_catalog2='';}
	 if($row[data_catalog2]!='0000-00-00 00:00:00')
		 { $data_catalog2=convertedata($row[data_catalog2],'d/m/Y - h:i');}
	   //
		  }
		  
$sql2="SELECT a.nome
FROM tema AS a INNER JOIN tema_obra AS b, obra AS c
WHERE (b.obra = c.obra and b.tema=a.tema)AND b.obra = '$obra'";
$db->query($sql2);
while($temas=$db->dados())
{
 $t[]=$temas[0];
}
$tot=count($t);
for($i=0;$i<=$tot;$i++){
$tema.=$t[$i];
if($i<$tot-1)
  {
   $tema.=',';
   }
}
///////////////////////////////////////////////////////////
/////////Inclusao na tabela tema_obra com o id gerado e na tabela de log
//Nao confundir,pois esse passo nao tem nada a ver com o sql2 acima!
if($_REQUEST[submit]==false && $_REQUEST[op]=='insert')
{
$sql="insert into tema_obra(tema,obra) values('0',$obra)";
$db->query($sql);

}
 
////////SQL para obter museu fixo////////
  $sql="select a.nome,a.museu from museu as a where a.museu in (select valor from parametro where parametro = 'LOCAL_INSTAL')";
  $db->query($sql);
  $museu=$db->dados();
  $museu_origem=$museu[0]; 
  $museu_id=$museu[1];					
/////////////////////////////////////////
  ?>

<form name="frmobra" method="post" onSubmit='return valida()'>
 <table width="100%" valign="top" border="0" cellpadding="0" cellspacing="0">
   <tr height="100%" valign="top" heght="1">

       <td align="center" valign="top" bgcolor="#ffffff" style="width:1px;border-right: 1px solid #34689A;">
 

           <? echo "<iframe valign='top' align='center' src='imagem_lista_consulta.php?obra=$_REQUEST[obra]' width='155' height='100%'  frameborder='0' scrolling='off' ALLOWTRANSPARENCY='true'></iframe>";?>
        </td>
      <td width="80%" align="center" border="0" valign="top" >
      <table width="100%" align="right" border="0" cellpadding="0" cellspacing="0">



 



      <tr>   
	<td width="30" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>&nbsp;&nbsp;Obra</span></a></div></td>
	<td width="30" height="20" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>&nbsp;&nbsp;(cont.)</span></a></div></td>
	<td width="20" height="20" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>&nbsp;&nbsp;Partes</span></a></div></td>
	<td width="30" height="20" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>&nbsp;&nbsp;Autoria</span></a></div></td>
	<td width="30" height="20" align="center" valign="bottom" id="aba5" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(5);"><div class="texto" id="abas"><a href="javascript:;" id="link5" onClick="ajustaAbas(5);" onMouseDown="this.click();"><span>&nbsp;&nbsp;Bibliografia</span></a></div></td>
	<td width="30" height="20" align="center" valign="bottom" id="aba6" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(6);"><div class="texto" id="abas"><a href="javascript:;" id="link6" onClick="ajustaAbas(6);" onMouseDown="this.click();"><span>&nbsp;&nbsp;Exposição</span></a></div></td>
	<td width="30" height="20" align="center" valign="bottom" id="aba7" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(7);"><div class="texto" id="abas"><a href="javascript:;" id="link7" onClick="ajustaAbas(7);" onMouseDown="this.click();"><span>&nbsp;&nbsp;Movimentação</span></a></div></td>
	<td width="30" height="20" align="center" valign="bottom" id="aba8" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(8);"><div class="texto" id="abas"><a href="javascript:;" id="link8" onClick="ajustaAbas(8);" onMouseDown="this.click();"><span>&nbsp;&nbsp;Relacionamento</span></a></div></td>
	<td width="8" style="border-bottom: 1px solid #34689A;">&nbsp;</td>
      </tr>
       <td colspan="9" align="left" class="texto" bgcolor="#f2f2f2" style="border: 0px solid #34689A; border-top: none; border-left-width: 0px;">
       <table  border="0" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2">
          <tr>
             <td width="724" height="700" valign="top">
	        <div id="wait" align="center" style="width100px; font-size:15px; font-weight:bold;"><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><img src="imgs/icons/clock.gif"> 
                     &nbsp;&nbsp;Carregando...
                </div>

	        <!-- ABA 1 : IDENTIFICAÇÃO  -->
                <div id="quadro1" class="divi1" style="display:none; width:562px;">
                   <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">


                   <tr>
                      <td colspan="2"  class="texto_bold"><div align="right"><a href="javascript:abre_manual(1)" tabindex="-1" class="texto_bold_especial" title="Usado na Etiqueta">N&ordm; de registro:</a> </div></td>
                      <td  colspan="1" ><input name="num_registro" type="text" class="combo_cadastro" readonly id="num_registro" style="text-align:center;" value="<? echo htmlentities($num_registro, ENT_QUOTES); ?>" size="20"></td>

   


                     <? $liberar= $_SESSION['liberar'];
		      if ($liberar) { ?>
		           <td colspan="0" class="texto_bold">
                             <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status: 
                                <select name="status" class="combo_cadastro">
                                   <option value="C" <? if ($status=='C') echo "selected"; ?>>Em cataloga&ccedil;&atilde;o</option>
                                   <option value="P" <? if ($status=='P') echo "selected"; ?>>Publicada</option>
                                </select>
		              </span> 
                            </td>
		       <? } else {
		               if ($status == 'C') $txtstatus= 'EM CATALOGAÇÃO';elseif ($status == 'P') $txtstatus= 'PUBLICADA';
			    echo "<td  colspan='0' class='texto_bold' style='color: navy;'>$txtstatus</td>";
			} ?>                                       


                   </tr>



	           <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(1)" tabindex="-1" class="texto_bold_especial">N&ordm; de  inventário:</a> </div></td>
                      <td colspan="0"><input name="inventario" type="text" class="combo_cadastro" id="inventario" style="text-align:center;" value="<? echo htmlentities($inventario, ENT_QUOTES); ?>" size="20" <? /*if ($liberar && $status=='P') echo "readonly";*/ ?>></td>


                        <td colspan="0" align="left" class="texto_bold_obrig" nowrap><a title="Usado na Etiqueta e Obrigat&oacute;rio">Destaque do acervo? 
                         <select name="eh_destaque_acervo" class="combo_cadastro" id="eh_destaque_acervo">
                            <option value="#"></option>
                            <option value="S" <? if ($destaque=='S') echo "selected"; ?>>SIM</option>
                            <option value="N" <? if ($destaque=='N') echo "selected"; ?>>NAO</option>
                          </select> 
                     </td>



	           </tr>

	           <tr>
  	              <td colspan="2" class="texto_bold"><div align="right">Controle inventário: </div></td>     
                      <td colspan="0"><input name="controle_inv" type="text" class="combo_cadastro" id="controle_inv" value="<? echo htmlentities($controle_inv, ENT_QUOTES); ?>" size="13"></td>                




	           </tr>
 
	          <tr>
                     <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(1)"  tabindex="-1" class="texto_bold_obrig" title="Usado na Etiqueta e Obrigat&oacute;rio">Cole&ccedil;&atilde;o/Classe:</a></div></td>
                     <td colspan="0" class="texto_bold" >
                        <select name="colecao" class="combo_cadastro" id="colecao" >
                            <? $sql= "SELECT nivel from usuario where usuario = $_SESSION[susuario]";
			       $db->query($sql);
			       $niv_usu=$db->dados();
			       if ($niv_usu[0] == 'A') {$sql="select colecao,nome from colecao order by nome";}
			       else {$sql="select distinct(b.colecao),b.nome from (colecao as b,usuario as a)inner join usuario_colecao as c on(a.usuario=c.usuario) and (b.colecao=c.colecao) where a.usuario = '$_SESSION[susuario]' order by b.nome";}
			       $db->query($sql);
			       echo "<option value='0' ></option>";
			       while($res=$db->dados())
			          { ?><option value="<? echo $res[0];?>"<? if($colecao==$res[0]) echo "Selected" ?>><? echo $res[1]; ?></option><? } ?>
                         </select>
                      </td>
 	           </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Museu:</div></td>
                      <td colspan="2"><input name="museu_origem" readonly type="text" class="combo_cadastro" id="museu_origem" value="<? echo htmlentities($museu_origem, ENT_QUOTES); ?>" size="70"> </td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Objeto:</div></td>
                      <td colspan="2"><select name="objeto" size="1" class="combo_cadastro" id="objeto" title="Objeto" onChange="alterouCampo = 1;">
          
          <? 
					  $sql="SELECT name from categoria_objeto order by name";
					  $db->query($sql);
					  while($catobj=$db->dados())
					  {
				  ?>
                      <option value="<? echo $catobj[0];?>"<? if($objeto==$catobj[0]) echo "Selected" ?>><? echo $catobj[0]; ?></option>
                          <? } ?>       
</select></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(3)" tabindex="-1" class="texto_bold_obrig" title="Obrigat&oacute;rio">T&iacute;tulo/Título da série</a></div></td>
                      <td colspan="3"><input name="titulo" type="text" class="combo_cadastro" id="titulo" value="<? echo htmlentities($titulo, ENT_QUOTES); ?>" onBlur="copia_campo()" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(3)" tabindex="-1" class="texto_bold_especial">N&ordm; de
                      s&eacute;rie:</a></div></td>
                      <td colspan="3"><input name="num_serie" type="text" class="combo_cadastro" id="num_serie" value="<? echo htmlentities($num_serie, ENT_QUOTES); ?>" size="50"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">T&iacute;tulo em ingl&ecirc;s: </div></td>
                      <td colspan="3"><input name="titulo_ingles" type="text" class="combo_cadastro" id="titulo_ingles" value="<? echo htmlentities($titulo_ingles, ENT_QUOTES); ?>" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold" nowrap><div align="right"><a href="javascript:abre_manual(3)" tabindex="-1" class="texto_bold_especial" title="Usado na Etiqueta">T&iacute;tulo
                      p/ etiqueta:</a></div></td>
                      <td colspan="3"><input name="titulo_etiq" type="text" class="combo_cadastro" id="titulo_etiq" value="<? echo htmlentities($titulo_etiq, ENT_QUOTES); ?>" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(2)" tabindex="-1" class="texto_bold_especial">Cópia:</a></div></td>
                      <td colspan="3" class="texto_bold"><input name="copia" type="text" class="combo_cadastro" id="copia" value="<? echo htmlentities($copia, ENT_QUOTES); ?>" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Per&iacute;odo:</div></td>
                      <td colspan="3"><input name="periodo" type="text" class="combo_cadastro" id="periodo" value="<? echo htmlentities($periodo, ENT_QUOTES); ?>" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(5)" tabindex="-1" class="texto_bold_especial" >Impressor/Fundição<br>/Fabricante:</a></div></td>
                      <td colspan="3"><input name="impressor" type="text" class="combo_cadastro" id="impressor" value="<? echo htmlentities($impressor, ENT_QUOTES); ?>" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(5)" tabindex="-1" class="texto_bold_especial">Editor:</a></div></td>
                      <td colspan="3"><input name="editor" type="text" class="combo_cadastro" id="editor" value="<? echo htmlentities($editor, ENT_QUOTES); ?>" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(5)" tabindex="-1" class="texto_bold_especial">N&ordm; de edi&ccedil;&atilde;o (tiragem):</a></div></td>
                      <td colspan="3" class="texto_bold"><input name="num_edicao" type="text" class="combo_cadastro" id="num_edicao" value="<? echo htmlentities($num_edicao, ENT_QUOTES); ?>" size="50"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold" valign="top"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_obrig" nowrap  title="Usado na Etiqueta e Obrigat&oacute;rio">Material / T&eacute;cnica:</a></div></td>
                      <td colspan="3"><input name="material" type="text" class="combo_cadastro" id="material" value="<? echo htmlentities($material, ENT_QUOTES); ?>" size="70"></td>
                    </tr>


                   <tr>
                      <td colspan="2" class="texto_bold_obrig" nowrap  title="Usado na Etiqueta e Obrigat&oacute;rio"  valign="top">
                               <div align="right">Dimens&otilde;es:</div>
                      </td>
                      <td colspan="2">
                         <b>
                             <a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Altura</a>
                             <input name="dim_obra_altura" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="dim_obra_altura"  value=" <? echo $dim_obra_altura;?>" size="3"><font size="2"> cm&nbsp;&nbsp;</font>

                            <a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Largura</a>
                            <input name="dim_obra_largura" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="dim_obra_largura" value="<?  echo $dim_obra_largura;?>" size="3"><font size="2"> cm&nbsp;&nbsp;</font>

                            <a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Di&acirc;metro</a>
                           <input name="dim_obra_diametro" type="text" class="combo_cadastro" id="dim_obra_diametro" onChange="return testavalor(this);" value="<?  echo $dim_obra_diametro;?>" size="3"><font size="2"> cm&nbsp;&nbsp;</font>
                          </b>
                       </td>
                     </tr>

                    <tr>
                       <td colspan="2" class="texto_bold" valign="top">&nbsp;
                      </td>
                      <td colspan="2">
                         <b>

                            <a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Profundidade</a>
                            <input name="dim_obra_profund" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="dim_obra_profund" value="<?  echo $dim_obra_profund;?>" size="3"><font size="2"> cm&nbsp;&nbsp;<font>
                            <a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Peso</a>

                            <input name="dim_obra_peso" type="text" class="combo_cadastro" id="dim_obra_peso" onChange=" return testavalor(this);" value="<?  echo $dim_obra_peso;?>" size="3"><font size="2"> Kg&nbsp;<font>
                       </b>
                    </td>
                 </tr>

                             <td colspan="2"></td>
                             <td colspan="3"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Formato</a>
                                  <select name="dim_obra_formato" class="combo_cadastro" id="dim_obra_formato">
                                    <option value="" <? if($dim_obra_formato=='') echo "selected" ?>></option>
                                    <option value="C" <? if($dim_obra_formato=='C') echo "selected" ?>>Circular</option>
                                    <option value="I" <? if($dim_obra_formato=='I') echo "selected" ?>>Irregular</option>
                                    <option value="L" <? if($dim_obra_formato=='L') echo "selected" ?>>Los&acirc;ngico</option>
                                   <option value="O" <? if($dim_obra_formato=='O') echo "selected" ?>>Oval</option>
                                    <option value="T" <? if($dim_obra_formato=='T') echo "selected" ?>>Triangular</option>
                                  </select>
                             </td>



                    <tr>
                      <td colspan="2" class="texto_bold" valign="top"><div align="right">Dim. da &aacute;rea impressa:</div></td>
                      <td colspan="2" >
                         <span class="texto_bold"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Altura</a>
                             <input name="aimp_obra_altura" type="text"  onChange="return testavalor(this);" class="combo_cadastro" id="aimp_obra_altura"  value="<?  echo $aimp_obra_altura;?>" size="3"> cm&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Largura</a>
                             <input name="aimp_obra_largura" type="text" class="combo_cadastro" onChange="return testavalor(this);" id="aimp_obra_largura" value="<?  echo $aimp_obra_largura;?>" size="3"> cm&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Di&acirc;metro</a>
                             <input name="aimp_obra_diametro" type="text" class="combo_cadastro" size="3" id="aimp_obra_diametro" onChange="return testavalor(this);" value="<?  echo $aimp_obra_diametro;?>" size="3"> cm
                           <tr>
                             <td colspan="2"></td>
                             <td colspan="3"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Formato</a>
                                  <select name="aimp_obra_formato" class="combo_cadastro" id="aimp_obra_formato">
                                      <option value="" <? if($aimp_obra_formato=='') echo "selected" ?>></option>
                                      <option value="C" <? if($aimp_obra_formato=='C') echo "selected" ?>>Circular</option>
                                      <option value="I" <? if($aimp_obra_formato=='I') echo "selected" ?>>Irregular</option>
                                      <option value="L" <? if($aimp_obra_formato=='L') echo "selected" ?>>Los&acirc;ngico</option>
                                      <option value="O" <? if($aimp_obra_formato=='O') echo "selected" ?>>Oval</option>
                                      <option value="T" <? if($aimp_obra_formato=='T') echo "selected" ?>>Triangular</option>
                                  </select>
                             </td>
                          </tr>
                        </span>
                     </td>
                   </tr>

                   <tr>
                      <td colspan="2" class="texto_bold" valign="top"><div align="right">Descrição de conte&uacute;do:</div></td>
                      <td colspan="3"><textarea name="desc_conteudo" cols="70" rows="8" wrap="VIRTUAL" class="combo_cadastro" id="desc_conteudo"><? echo $desc_conteudo ?></textarea></td>
                    </tr>

                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Temas:</div></td>
                      <td colspan="3"><input name="tema" type="text" class="combo_cadastro"  readonly="1" id="tema" value="<? echo $tema;  ?>" size="65">
                      <a href='javascript:;' onClick="abrepop('pop_tema.php?tipo_tema='+document.frmobra.tema.value); ""><img src="imgs/icons/lupa.gif" title="Selecionar..." border=0 )"></a> </td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold" valign="top"><div align="right">Sub-temas:</div></td>
                      <td colspan="3"><textarea name="subtema" cols="70" rows="3" wrap="VIRTUAL" class="combo_cadastro" id="subtema"><? echo $subtema ?></textarea></td>
                    </tr>


 
                   </table>
                </div>

                <!-- ABA 2 : Biografia -->
              <div id="quadro2" class="divi1" style="display:none; width:562px;">

                  <table border="0" cellpadding="4" cellspacing="3" bgcolor="#f2f2f2">
                     <tr>
                        <td colspan="2" class="texto_bold" nowrap><div align="right"><a href="javascript:abre_manual(8)" tabindex="-1" class="texto_bold_obrig" title="Usado na Etiqueta e Obrigat&oacute;rio">Forma de aquisi&ccedil;&atilde;o:</a></div></td>
                        <td colspan="2">
                           <select name="forma_aquisicao" class="combo_cadastro" id="forma_aquisicao" >
                                                                  <?  $sql="SELECT distinct forma_aquisicao,nome from forma_aquisicao as a order by a.forma_aquisicao asc"; 
				                $db->query($sql);
					  echo "<option value='' ></option>";
					  while($res=$db->dados())
					  {  ?> <option value="<? echo $res[0];?>" <? if($forma_aquisicao==$res[0]) echo "Selected" ?>><? echo $res[1] ?></option><? } ?>
                           </select>
                        </td>
                     </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(8)"  tabindex="-1" class="texto_bold_especial" title="Usado na Etiqueta">Doador/Vendedor:</a></div></td>
                      <td colspan="2"><input name="doador" type="text" class="combo_cadastro" id="doador" value="<? echo htmlentities($doador, ENT_QUOTES); ?>" size="75"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(8)" tabindex="-1" class="texto_bold_especial">N&ordm; do processo:</a></div></td>
                      <td colspan="2"><input name="num_processo" type="text" class="combo_cadastro" id="num_processo" value="<? echo htmlentities($num_processo, ENT_QUOTES); ?>" size="45"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(8)"  tabindex="-1" class="texto_bold_especial" title="Usado na Etiqueta">Data de aquisi&ccedil;&atilde;o:</a></div></td>
                      <td colspan="2"><input name="dt_aqdia" type="text" class="combo_cadastro" id="dt_aqdia" value="<? echo $dt_aqdia ?>" size="2">&nbsp;
                          <input name="dt_aqmes" type="text" class="combo_cadastro" id="dt_aqmes" value="<? echo $dt_aqmes ?>" size="2">&nbsp;
                          <input name="dt_aqano" type="text" class="combo_cadastro" id="dt_aqano" value="<? echo $dt_aqano ?>" size="4">-
                          <input name="dt_aq_extra1" type="text" class="combo_cadastro" id="dt_aq_extra1" value="<? echo $dt_aq_extra1 ?>" size="4">&nbsp;(
                          <select name="dt_aq_extra2" class="combo_cadastro" id="dt_aq_extra2">
                                <option value=''></option>
                                <option value="circa" <? if($dt_aq_extra2=='circa') echo "Selected" ?>>circa</option>
                                <option value="?" <? if($dt_aq_extra2=='?') echo "Selected" ?>>?</option>
                          </select>) 
                        </td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(8)" tabindex="-1" class="texto_bold_especial">Valor de compra:</a></div></td>
                      <td colspan="2"><input name="val_compra" type="text" class="combo_cadastro" id="val_compra" value="<? echo $val_compra ?>" size="45"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(8)" tabindex="-1" class="texto_bold_especial">Valor de seguro:</a></div></td>
                      <td colspan="2"><input name="val_seguro" type="text" class="combo_cadastro" id="val_seguro" value="<? echo $val_seguro ?>" size="45"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold" valign="top"><div align="right">
                        <p>Ex-propriet&aacute;rio:
                      </div></td>
                      <td colspan="2"><textarea name="ex_proprietarios" cols="75" rows="3" wrap="VIRTUAL" class="combo_cadastro" id="ex_proprietarios"><? echo $ex_proprietarios ?></textarea></td>
                    </tr>
			        <tr class="texto_bold">
			          <td colspan="2"><div align="right"><a href="javascript:abre_manual(10)" tabindex="-1" class="texto_bold_obrig" title="Usado na Etiqueta e Obrigat&oacute;rio">Localização fixa:</a></div></td>
			          <td colspan="2"><select name="local_fixo" class="combo_cadastro" id="local_fixo" >
			                  <? 
								  $sql="SELECT * from local order by local";
								  $db->query($sql);
								  echo "<option value='0' ></option>";
								  while($loc=$db->dados())
								  {
							  ?>
			                      <option value="<? echo $loc[0];?>"<? if($local_fixo==$loc[0]) echo "Selected" ?>><? echo $loc[1]; ?></option>
			                          <? } ?>
			                  </select></td>
			        </tr>
			        <tr class="texto_bold">
			          <td colspan="2"><div align="right"><a href="javascript:abre_manual(10)" tabindex="-1" class="texto_bold_especial">Trainel/Gaveta<br>/Estante:</a></div></td>
			          <td colspan="2"><input name="trainel_gaveta" type="text" class="combo_cadastro" id="trainel_gaveta" value="<? echo htmlentities($trainel_gaveta, ENT_QUOTES); ?>" size="75"></td>
			        </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(2)" tabindex="-1" class="texto_bold_especial">Escola/Grupo cultural:</a></div></td>
                      <td colspan="2"><input name="escola" type="text" class="combo_cadastro" id="escola" value="<? echo htmlentities($escola, ENT_QUOTES); ?>" size="75"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(7)"  tabindex="-1" class="texto_bold_especial">Movimento:</a></div></td>
                      <td colspan="2"><input name="movimento" type="text" class="combo_cadastro" id="movimento" value="<? echo htmlentities($movimento, ENT_QUOTES); ?>" size="75"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right"><a href="javascript:abre_manual(7)"  tabindex="-1" class="texto_bold_especial">Estilo:</a></div></td>
                      <td colspan="2"><input name="estilo" type="text" class="combo_cadastro" id="estilo" value="<? echo htmlentities($estilo, ENT_QUOTES); ?>" size="75"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold" valign="top"><div align="right">Observação:</div></td>
                      <td colspan="2"><textarea name="obs" cols="75" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="obs"><? echo $obs ?></textarea></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold" valign="top"><div align="right">Anota&ccedil;&atilde;o:</div></td>
                      <td colspan="2"><textarea name="anotacao" cols="75" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="obs"><? echo $anotacao; ?></textarea></td>
                    </tr>

                    <tr>
                      <td colspan="2" class="texto_bold" valign="top"><div align="right">Montagem:</div></td>
                      <td colspan="2"> <textarea name="requisito_detalhe" cols="75" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="requisito_detalhe"><? echo $requisito_detalhe ?></textarea>
                                <font size="2"><em> (Requisitos de manutenção, manuseio e montagem)</em></font>
                       </td>
                    </tr>


                    <tr>
                      <td colspan="2" class="texto_bold" valign="top"><div align="right"><a href="javascript:abre_manual(10)" tabindex="-1" class="texto_bold_especial">Texto p/ etiqueta:</a></div></td>
                      <td colspan="2"><textarea name="texto_etiq" cols="75" rows="6" wrap="VIRTUAL" class="combo_cadastro" id="texto_etiq"><? echo $texto_etiq ?></textarea></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Catalogado por:</div></td>
                      <td colspan="2"><input name="catalogado"  readonly="1" type="text" class="combo_cadastro" id="catalogado" value="<? echo  $catalogado ?>" size="65"></td>
                    </tr>
                    <tr>
                      <td colspan="2"class="texto_bold"><div align="right">em:</div></td>
                      <td colspan="2"><input name="data_catalog1" type="text" class="combo_cadastro"  readonly="1" id="data_catalog1" value="<? echo $data_catalog1 ?>" size="20"></td>
                    </tr>


                    <tr>
                      <td colspan="2" class="texto_bold"><div align="right">Atualizado por:</div></td>
                      <td colspan="2"><input name="atualizado" type="text" class="combo_cadastro"  readonly="1" id="atualizado" value="<? echo $atualizado ?>" size="65"></td>
                    </tr>
                    <tr>
                      <td colspan="2"class="texto_bold"><div align="right">em:</div></td>
                      <td colspan="2"><input name="data_catalog2" type="text" class="combo_cadastro" readonly id="data_catalog2" value="<? echo $data_catalog2?>" size="20"></td>
                    </tr>



                </table>

    <table id="rodape" width="100%" border="0" bgcolor="#f2f2f2">
            <tr>
              <td width="300">&nbsp;<br><br></td>
              <td><input align='middle' name="submit" type="submit" class="botao" value="Gravar">
                <input name="obra" type=hidden id="obra" value="<? echo $_REQUEST[obra] ?>"><br><br></td>
                          </tr>
          </table>

              </div>                
			  <!-- ABA 3 : PARTES -->  
				 <div id="quadro3" class="divi1" style="display: none; width:550px;  ">
				 <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
                      <td><iframe name="abas" align="middle" src='parte_obra.php?op_obra=update&obra=<? echo $obra; ?>' width="543" height="400" frameborder="0" scrolling="auto" ALLOWTRANSPARENCY="true"></iframe></td>
                    </tr>
                </table>
            </div> 
			  <!-- ABA 4 : Autores -->
			  <div id="quadro4" class="divi1" style="display: none; width:550px;">
			    <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                      </tr>
                    <tr>
                      <td><iframe name="abas" align="middle" src='autor_obra.php?op_obra=update&obra=<? echo $obra; ?>' width="543" height="400" frameborder="0" scrolling="auto" ALLOWTRANSPARENCY="true"></iframe></td>
                    </tr>
                </table>
			  </div>
				 <!-- ABA 5 : Bibliografia - Obra -->  
				 <div id="quadro5" class="divi1" style="display: none; width:550px; ">
			    <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
                      <td><iframe name="abas" align="middle" src='bibliografia_obra.php?op_obra=update&obrid=<? echo $obra; ?>' width="543" height="400" frameborder="0" scrolling="auto" ALLOWTRANSPARENCY="true"></iframe></td>
                    </tr>
                </table>
              </div>
			
			  <!-- ABA 6 : Exposição -->
				 <div id="quadro6" class="divi1" style="display: none; width:550px;  ">
				 <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
   	                  <td><iframe name='abas' align='middle' src='exposicao_obra.php?op_obra=update&obrid=<? echo $obra; ?>' width='543' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe></td>
       	            </tr>
                </table>
            </div> 
			  <!-- ABA 7 : Movimentação -->
				 <div id="quadro7" class="divi1" style="display: none; width:550px;  ">
				 <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
   	                  <td><iframe name='abas' align='middle' src='movimento_lista_obra.php?op_obra=update&obrid=<? echo $obra; ?>' width='543' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe></td>
       	            </tr>
                </table>
            </div> 
 			  <!-- ABA 9 : Relacionamento -->
				 <div id="quadro8" class="divi1" style="display: none; width:550px;  ">
				 <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
   	                  <td><iframe name='abas' align='middle' src='relacionamento_obra.php?op_obra=update&obra=<? echo $obra; ?>&susuario=<?echo $_SESSION[susuario];?>' width='543' height='400' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe></td>
       	            </tr>

                    </table>
                </div> 
	</td>
          </tr>   
        </table>
    </table>
</td>
</tr>
</table>          


</form>
</body>

<?
//
//Inclusao na tabela de log de atualizacao.
//


$obs1="Inclusão Inicial de Obra ID={".$obra."}  Registro={".trim($num_registro)."}";
if($_REQUEST[submit]==false && $_REQUEST[op]=='insert') {
	$sql3="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('I','$_SESSION[susuario]','0','$obra',now(),'$obs1')";
	$db->query($sql3);
}
?>

<? 
if($_REQUEST['submit']<>'')
{
 /////////////////////////////////////////////////////
 $dt_aqano=$_REQUEST['dt_aqano'];
 $dt_aqmes=$_REQUEST['dt_aqmes'];
 $dt_aqdia=$_REQUEST['dt_aqdia'];
 $dt_aq_extra1=$_REQUEST['dt_aq_extra1'];
/* dtformato_interno($dt_aqdia, $dt_aqmes, $dt_aqano, $dt_aq_extra1, '', $data['inicial'], $data['final']);
 $dt_aquisicao_di= $data['inicial'];
 $dt_aquisicao_df= $data['final'];*/
 $dt_aquisicao_tp=$_REQUEST['dt_aq_extra2'];
		if ($dt_aqano == "")
			$dt_aqano= 0;
		if ($dt_aqmes == "")
			$dt_aqmes= 0;
		if ($dt_aqdia == "")
			$dt_aqdia= 0;
		if ($dt_aq_extra1 == "")
			$dt_aq_extra1= 0;

 /////////////////////////////////////
 //Tosco mas funciona(rs)
 if($_REQUEST[dim_obra_altura]=='')
  { $_REQUEST[dim_obra_altura]='0.00';}
 if($_REQUEST[dim_obra_largura]=='')
  { $_REQUEST[dim_obra_largura]='0.00'; }
 if($_REQUEST[dim_obra_diametro]=='')
  { $_REQUEST[dim_obra_diametro]='0.00';}
 if($_REQUEST[dim_obra_profund]=='')
  { $_REQUEST[dim_obra_profund]='0.00';}
 if($_REQUEST[dim_obra_peso]=='')
  { $_REQUEST[dim_obra_peso]='0.00'; }

 if($_REQUEST[aimp_obra_altura]=='0.00')
  { $_REQUEST[aimp_obra_altura]='0.00';}
 if($_REQUEST[aimp_obra_largura]=='')
  { $_REQUEST[aimp_obra_largura]='0.00';}
 if($_REQUEST[aimp_obra_diametro]=='')
  { $_REQUEST[aimp_obra_diametro]='0.00';}

 if($_REQUEST[inventario]=='')
	$_REQUEST[inventario]=0;
 ///

 // Se estiver liberando obra, status recebe o request[status]; senão, status continua o mesmo //
 if ($liberar)
	$status= $_REQUEST['status'];

 ////
 function id_ret($valor) // Faz o processo inverso da funcao ret_nome ->obtem o nome do usuario e transforma no id correspondente.
 {
  global $db;
  $sql="select usuario from usuario where nome='$valor'";
  $db->query($sql);
  $res=$db->dados();
  echo $res[0]." :: ".$valor;
  return $res[0];
 }
 ///

 // Se status = Publicada(liberada) verifica se a obra possui autor; se não possui, impede a Publicação (mantém em catalogação) //
  $sql="SELECT count(*) as tot from autor_obra where obra='$obra'";
  $db->query($sql);
  $totautor=$db->dados();
 // Se status = Publicada(liberada) verifica se os campos SIM/NÃO de partes forão marcados; se não, impede a Publicação (mantém em catalogação) //
  $sql="SELECT count(*) as tot from parte where obra='$obra' AND ((assinada='' or assinada IS NULL) OR (marcada='' or marcada IS NULL) 
		OR (datada='' or datada IS NULL) OR (localizada='' or localizada IS NULL) OR (dim_mold_possui='' or dim_mold_possui IS NULL) 
		OR (dim_base_possui='' or dim_base_possui IS NULL) OR (dim_pasp_possui='' or dim_pasp_possui IS NULL))";
  $db->query($sql);
  $totparte=$db->dados();

  if ($totautor['tot']==0 && $status=='P') {
    $status= 'C';
	echo "<script>alert('Não foi possível publicar!\\n\\nTentativa de publicar obra sem autor!');</script>";
  }
  elseif ($totparte['tot'] > 0 && $status=='P') {
    $status= 'C';
	echo "<script>alert('Não foi possível publicar!\\n\\nNo cadastro de partes, os campos com opções \"Sim/Não\" devem estar todos preenchidos.');</script>";
  }
/*  else
   {*/
// Envia mensagem de inclusão de obra para o responsável pela coleção
	if ($colecao == 0) {
		$sql="SELECT nome,responsavel from colecao where colecao = '$_REQUEST[colecao]'";
		$db->query($sql);
		$usu_responsavel=$db->dados(); 
		$nome_da_col=$usu_responsavel['nome'];
		$usu_responsavel=$usu_responsavel['responsavel'];
		//
		$texto='Inclusão de Ficha de Obra\n';
		$texto.='Nº DE REGISTRO: '.$_REQUEST['num_registro'].'\n';
		$texto.='TÍTULO: '.$_REQUEST['titulo'].'\n';
		$texto.='COLEÇÃO: '.$nome_da_col.'\n';
		$dataInc= date("Y-m-d");
		$assunto='Ficha de Obra - Nº de registro: '.$_REQUEST['num_registro'].'';
		$sql= "INSERT INTO agenda(assunto,texto,data_aviso,eh_lida,data_inclusao,usuario_origem,usuario) 
			values('$assunto','$texto',now(),'0','$dataInc','$_SESSION[susuario]','$usu_responsavel')";
		$db->query($sql);
	}
	else {
// Envia mensagem de 3 de obra para o responsável pela coleção
		$sql="SELECT nome,responsavel from colecao where colecao = '$_REQUEST[colecao]'";
		$db->query($sql);
		$usu_responsavel=$db->dados(); 
		$nome_da_col=$usu_responsavel['nome'];
		$usu_responsavel=$usu_responsavel['responsavel'];
		//
		$texto='Alteração de Ficha de Obra\n';
		$texto.='Nº DE REGISTRO: '.$_REQUEST['num_registro'].'\n';
		$texto.='TÍTULO: '.$_REQUEST['titulo'].'\n';
		$texto.='COLEÇÃO: '.$nome_da_col.'\n';
		$texto.='Alterada por '.$_SESSION[snome].'\n';
		$dataInc= date("Y-m-d");
		$assunto='Ficha de Obra - Nº de registro: '.$_REQUEST['num_registro'].'';
		$sql= "INSERT INTO agenda(assunto,texto,data_aviso,eh_lida,data_inclusao,usuario_origem,usuario) 
			values('$assunto','$texto',now(),'0','$dataInc','$_SESSION[susuario]','$usu_responsavel')";
		$db->query($sql);
	}
//




   $dimaltura=formata_valor_2(trim($_REQUEST[dim_obra_altura]));
   $dimlargura=formata_valor_2(trim($_REQUEST[dim_obra_largura]));
   $dimdiametro=formata_valor_2(trim($_REQUEST[dim_obra_diametro]));


   $aimpaltura=formata_valor_2(trim($_REQUEST[aimp_obra_altura]));
   $aimplargura=formata_valor_2(trim($_REQUEST[aimp_obra_largura]));
   $aimpdiametro=formata_valor_2(trim($_REQUEST[aimp_obra_diametro]));


   if ( ($aimpaltura > $dimaltura) or 
       ($aimplargura > $dimlargura) or
          ($aimpdiametro > $dimdiametro) )

    {
       echo "<script>alert( 'Dimensões da área impressa não pode ser maior que dimensões da obra.');</script>";
 
    }else{



  $sql="UPDATE obra set
 museu='$museu_id',
 num_registro='$_REQUEST[num_registro]', 
 colecao='$_REQUEST[colecao]',
 inventario='$_REQUEST[inventario]',
 controle_inv='$_REQUEST[controle_inv]',
 eh_destaque_acervo='$_REQUEST[eh_destaque_acervo]',
 status='$status',
 forma_aquisicao='$_REQUEST[forma_aquisicao]',
 local_fixo='$_REQUEST[local_fixo]',
 trainel_gaveta='$_REQUEST[trainel_gaveta]',
 copia='$_REQUEST[copia]',
 objeto='$_REQUEST[objeto]',
 titulo='$_REQUEST[titulo]',
 num_serie='$_REQUEST[num_serie]',
 material_tecnica= '$_REQUEST[material]',
 titulo_ingles='$_REQUEST[titulo_ingles]',
 titulo_etiq='$_REQUEST[titulo_etiq]',
 texto_etiq='$_REQUEST[texto_etiq]',
 periodo='$_REQUEST[periodo]',
 escola='$_REQUEST[escola]',
 movimento='$_REQUEST[movimento]', 
 estilo='$_REQUEST[estilo]',    
 impressor='$_REQUEST[impressor]',
 editor='$_REQUEST[editor]',
 num_edicao='$_REQUEST[num_edicao]',
 desc_conteudo='$_REQUEST[desc_conteudo]',
 sub_tema='$_REQUEST[subtema]',
 num_processo='$_REQUEST[num_processo]',
 doador='$_REQUEST[doador]',
 val_compra='$_REQUEST[val_compra]',
 val_seguro='$_REQUEST[val_seguro]',
 ex_proprietarios='$_REQUEST[ex_proprietarios]',
 obs='$_REQUEST[obs]',
 catalogado='".id_ret(trim($_REQUEST['catalogado']))."',
 atualizado='$_SESSION[susuario]',
 requisito_detalhe='$_REQUEST[requisito_detalhe]',
 dt_aquisicao_dia='$dt_aqdia',
 dt_aquisicao_mes='$dt_aqmes',
 dt_aquisicao_ano1='$dt_aqano',
 dt_aquisicao_ano2='$dt_aq_extra1',
 dt_aquisicao_tp='$dt_aquisicao_tp',
 data_catalog2=now(), 
 dim_obra_altura='".formata_valor_2(trim($_REQUEST['dim_obra_altura']))."',
 dim_obra_largura='".formata_valor_2(trim($_REQUEST['dim_obra_largura']))."',
 dim_obra_diametro='".formata_valor_2(trim($_REQUEST['dim_obra_diametro']))."',
 dim_obra_profund='".formata_valor_2(trim($_REQUEST['dim_obra_profund']))."',
 dim_obra_peso='".formata_valor_2(trim($_REQUEST['dim_obra_peso']))."',
 dim_obra_formato='".formata_valor(trim($_REQUEST['dim_obra_formato']))."',
 aimp_obra_altura='".formata_valor_2(trim($_REQUEST['aimp_obra_altura']))."',
 aimp_obra_largura='".formata_valor_2(trim($_REQUEST['aimp_obra_largura']))."',
 aimp_obra_diametro='".formata_valor_2(trim($_REQUEST['aimp_obra_diametro']))."',
 aimp_obra_formato='".formata_valor(trim($_REQUEST['aimp_obra_formato']))."'
	               where obra='$obra'";
 
 $db->query($sql);

//
// Anotações da Obra por Usuario
//

 $sql="select count(*) as total from obra_anotacao where obra='$obra' and usuario='$_SESSION[susuario]'";
 $db->query($sql);
 while($row=$db->dados())
 {
    $totAnot=$row['total'];
 }
 if ($totAnot==0) {
    $sql="insert into obra_anotacao (obra, usuario, texto) values ('$obra','$_SESSION[susuario]','')";
    echo $sql;
    $db->query($sql);
 }


 $sql="update obra_anotacao set texto='$_REQUEST[anotacao]' where obra='$obra' and usuario='$_SESSION[susuario]'";
 $db->query($sql);

//////////////////////////////Tabela tema_obra/////////////////////////////

function limpa_tema_obra() //Limpa  primeiramente a tabela para nao guardar lixo
{
 global $db,$obra;
  $sql="delete from tema_obra where obra='$obra'";
 $db->query($sql);
}
////////
function retid($x) // Funcao necessaria para obter o id de cada tema(string) passado no textarea.
{ 
 global $db;
 $sql="SELECT tema from tema where nome='".trim($x)."'";
 $db->query($sql);
 $tema=$db->dados();
 return $tema[0];
}
////
$str=explode(',',$_REQUEST[tema]);
$tot=count($str);
if($str[0]=='')
{ $tot=0; }
limpa_tema_obra();
for($i=1;$i<=$tot;$i++)
{
 $val=retid(trim($str[$i-1]));
 $sql="INSERT INTO tema_obra(tema,obra) values('$val','$obra')";
 $db->query($sql);
 }

//////////////////////////////Tabela Log_atualizacao/////////////////////////////


$obs1="Alteração Obra ID={".$obra."}  Registro={".$num_registro."}  Titulo="."{".trim($_REQUEST[titulo])."}";
$sql2="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','0','$obra',now(),'$obs1')";
$db->query($sql2);
//////////////////////////////////////////////////////////////////

/* } */ // <- fim do teste totautor

echo "<script>location.href='alterarobra.php?op_obra=update&obra=$obra'</script>";
 }
}
?>