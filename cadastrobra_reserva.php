<?
include_once("seguranca.php"); 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
set_time_limit(0);
$db=new conexao();
$db->conecta();
if($_REQUEST[submit]==false && $_REQUEST[op]=='insert')
{
	$libera_status= liberacao_automatica();
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

setTimeout('verifica_carregamento()',60000);

function verifica_carregamento() {
	if (document.getElementById('wait').style.display == '') {
//		alert('Falha no carregamento. Clique OK para tentar novamente.');
		location.href= 'cadastrobra_reserva.php?obra=<? echo $_REQUEST[obra] ?>';
	}
}

function ajustaAbas(index) {
	numAbas= 2;

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
	if( index==2)
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
padrao=/^\d+(,|.\d+)?$/;
function testavalor(e)
{
 if(e.value!='')
 {
      OK = padrao.exec(e.value);
 if (!OK){
    window.alert ("Valor numérico inválido\n Utilize apenas duas casas decimais separados por vírgula ou ponto.");
	ajustaAbas(2);
	e.focus();
	return false;
       
 } else { 
   return true;
    }
}
}
///////////
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
//////////
function Add(i,parametro){
   if(parametro!=''){
  var item=parametro+";";
  document.getElementById(i).value+=item;
  }}
 ////////
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
  	win=window.open('manual_catalog.php?janela=popup&corfundo=CCCCFF&parametro='+parametro,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-150)+',scrollbars=yes, height=365,width=560,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
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
   $sql="select a.* from obra as a where a.obra='$_REQUEST[obra]'";
   $db->query($sql);
   while($row=$db->dados())
	  { 
		$obra=$row['obra'];
		//$museu_origem=$row['museu'];
		$num_registro=$row['num_registro'];
		$destaque=$row['eh_destaque_acervo'];
		$colecao=$row['colecao'];
		$status=$row['status'];
		$forma_aquisicao=$row['forma_aquisicao'];
		$local_fixo=$row['local_fixo'];
		$trainel_gaveta=$row['trainel_gaveta'];
		$objeto=$row['objeto'];
		$copia=$row['copia'];
		$titulo=$row['titulo'];
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
		$dim_obra_altura=trim($row['dim_obra_altura']);
	   	$dim_obra_largura=trim($row['dim_obra_largura']);
	   	$dim_obra_diametro=trim($row['dim_obra_diametro']);
	   	$dim_obra_profund=trim($row['dim_obra_profund']);
	   	$dim_obra_peso=trim($row['dim_obra_peso']);
	   	$dim_obra_formato=$row['dim_obra_formato'];
	   	$aimp_obra_altura=trim($row['aimp_obra_altura']);
	   	$aimp_obra_largura=trim($row['aimp_obra_largura']);
	   	$aimp_obra_diametro=trim($row['aimp_obra_diametro']);
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
//Inclusao na tabela de log de atualizacao.
$sql3="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('I','$_SESSION[susuario]','0','$obra',now())";
$db->query($sql3);
//
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
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>

	<td width="86" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Obra</span></a></div></td>
	<td width="86" height="20" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Partes</span></a></div></td>
	<td width="8" style="border-bottom: 1px solid #34689A;">&nbsp;</td>
    </tr>
      <td colspan="9" align="left" class="texto" bgcolor="#f2f2f2" style="border: 1px solid #34689A; border-top: none; border-left-width: 1px;">
         <table border="0" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2">
		  <tr>
            <td width="530" height="250" valign="top">
			  <div id="wait" align="center" style="width:530px; font-size:12px; font-weight:bold;">
					<br><br><br><br><br>
					&nbsp;&nbsp;<img src="imgs/icons/clock.gif"> &nbsp;&nbsp;Carregando...
			  </div>
			<!-- ABA 1 : Identifica&ccedil;&atilde;o -->
              <div id="quadro1" class="divi1" style="display:none; width:530px;">
			     <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#f2f2f2">
                    <tr>

                      <br><td colspan="2" class="texto"><div align="right"><a class="texto">N&ordm; de
                      registro:</a> </div></td>
                      <td ><input name="num_registro" type="text" class="combo_cadastro" readonly="true" id="num_registro" style="text-align:center;" value="<? echo htmlentities($num_registro, ENT_QUOTES); ?>" size="20"></td>
                    </tr>
					<tr>
                      <td colspan="2" class="texto"><div align="right"><a class="texto">Cole&ccedil;&atilde;o/Classe:</a></div></td>
                      <td colspan="3" class="texto"><select name="colecao" class="combo_cadastro" id="colecao" >
                          <? 
					$sql= "SELECT nivel from usuario where usuario = $_SESSION[susuario]";
					$db->query($sql);
					$niv_usu=$db->dados();
					  if ($niv_usu[0] == 'A') {
						  $sql="select colecao,nome from colecao order by nome";
					  }
					  else {
						  $sql="select distinct(b.colecao),b.nome from (colecao as b,usuario as a)
			                   inner join usuario_colecao as c on(a.usuario=c.usuario)
		                       and (b.colecao=c.colecao) where a.usuario = '$_SESSION[susuario]' order by b.nome";
					  }
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
                          <option value="<? echo $res[0];?>"<? if($colecao==$res[0]) echo "Selected" ?>><? echo $res[1]; ?></option>
                          <? } ?>
                      </select></td>
					</tr>
                    <tr>
                      <td colspan="2" class="texto" nowrap><div align="right"><a class="texto">T&iacute;tulo
                      p/ etiqueta:</a></div></td>
                      <td colspan="3"><input name="titulo_etiq" type="text"  readonly="yes" class="combo_cadastro" id="titulo_etiq" value="<? echo htmlentities($titulo_etiq, ENT_QUOTES); ?>" size="70"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="texto" valign="top"><div align="right"><a class="texto">Material/T&eacute;cnica:</a></div></td>
                      <td colspan="3"><input name="material" type="text"  readonly="yes" class="combo_cadastro" id="material" value="<? echo htmlentities($material, ENT_QUOTES); ?>" size="70"></td>

                    <tr>
                      <td colspan="2"><div align="right"><a href="javascript:abre_manual(6)" tabindex="-1" class="texto_bold_especial">Peso:</a></div></td>
                          
			<td colspan="3"><input name="dim_obra_peso" type="text" class="texto" id="dim_obra_peso" onChange=" return testavalor(this);" value="<?  echo number_format($dim_obra_peso,2,',','.');?>" size="5">
                      </td>
                    </tr>
                    </tr>
			        <tr class="texto_bold">
			          <td colspan="2"><div align="right"><a href="javascript:abre_manual(10)" tabindex="-1" class="texto_bold_especial">Localização fixa:</a></div></td>
			          <td colspan="2"><select name="local_fixo" class="texto" id="local_fixo" >
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
			          <td colspan="2"><input name="trainel_gaveta" type="text" class="texto" id="trainel_gaveta" value="<? echo htmlentities($trainel_gaveta, ENT_QUOTES); ?>" size="70"></td>
			        </tr>
                    <tr>
                    <tr>
                      <td colspan="2" class="texto" ><div align="right">Catalogado
                          por:<br>
                      <br>
                      &nbsp;Atualizado por: </div></td>
                      <td colspan="2" class="texto"><input name="catalogado"  readonly="1" type="text" class="combo_cadastro" id="catalogado" value="<? echo  $catalogado ?>" size="40">
&nbsp;&nbsp;em:
<input name="data_catalog1" type="text" class="combo_cadastro"  readonly="1" id="data_catalog1" value="<? echo $data_catalog1 ?>" size="20">
<br>
<br>
                      
                      <input name="atualizado" type="text" class="combo_cadastro"  readonly="1" id="atualizado" value="<? echo $atualizado ?>" size="40"> 
                      &nbsp;&nbsp;em:
                      <input name="data_catalog2" type="text" class="combo_cadastro" readonly="1" id="data_catalog2" value="<? echo $data_catalog2?>" size="20"></td>
                    </tr>
                </table>
              </div>                
			  <!-- ABA 2 : PARTES -->  
				 <div id="quadro2" class="divi1" style="display: none; width:530px;  ">
				 <table width="100%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
                      <td><iframe name="abas" valign="top" src='parte_obra_reserva.php?obra=<? echo $obra; ?>' width="530" height="300" frameborder="0" scrolling="auto" ALLOWTRANSPARENCY="true"></iframe></td>
                    </tr>
                </table>
            </div> 
			</td>
          </tr>
        </table>
          <table id="rodape" width="100%" border="0" bgcolor="#f2f2f2">
            <tr align='right'>
              <td width="250">&nbsp;<br><input align='middle' name="submit" type="submit" class="botao" value="Gravar">
                <input name="obra" type="hidden" id="obra" value="<? echo $_REQUEST[obra] ?>"><br><br></td>
            </tr>
          </table>
	  </table>
</form>
</body>
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

 if($_REQUEST[aimp_obra_altura]=='')
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
// Envia mensagem de alteração de obra para o responsável pela coleção
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
  $sql="UPDATE obra set
 local_fixo='$_REQUEST[local_fixo]',
 trainel_gaveta='$_REQUEST[trainel_gaveta]',
 catalogado='".id_ret(trim($_REQUEST['catalogado']))."',
 atualizado='$_SESSION[susuario]',
 data_catalog2=now(), 
 dim_obra_peso='".formata_valor(trim($_REQUEST['dim_obra_peso']))."'
	               where obra='$obra'";
$db->query($sql);

//////////////////////////////Tabela Log_atualizacao/////////////////////////////
$sql2="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','0','$obra',now())";
$db->query($sql2);
//////////////////////////////////////////////////////////////////

/* } */ // <- fim do teste totautor

echo "<script>location.href='cadastrobra_reserva.php?obra=$obra'</script>";
 }
?>