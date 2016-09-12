<?
//include_once("seguranca.php"); 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db_mold=new conexao();
$db_mold->conecta();
function exibeDataNegativa($valor) {
	if ($valor < 0)
		return substr($valor,1) . " aC";
	elseif ($valor == 0)
		return "&nbsp;&nbsp;&nbsp;";
	else
		return $valor;
}

$op=$_REQUEST[op];
$obra=$_REQUEST[obra];
 if(isset($_REQUEST[obra]))
 {
  if($op=='view')
   {
    $sql="SELECT a.* from parte as a where a.obra='$_REQUEST[obra]' and parte='$_REQUEST[parte]'";
	$db->query($sql);
    $res=$db->dados();
//data
/*		$datacao= $res['data'];
		$datacao_extra1= $res['data_extra1'];
		$dt_extra2= $res['data_extra2'];
		dtformato_externo($datacao, $datacao_extra1, '', $data['dia'], $data['mes'], $data['ano'], $data['ano2']);
		$dt_dia= $data['dia'];
		$dt_mes= $data['mes'];
		$dt_ano= $data['ano'];
		$dt_extra1= $data['ano2'];*/
		$dt_dia= $res['dt_parte_dia'];
		$dt_mes= $res['dt_parte_mes'];
		$dt_ano= $res['dt_parte_ano1'];
		$dt_extra1= $res['dt_parte_ano2'];
		$dt_extra2= $res['data_extra2'];
//
	}
}
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

<script>

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
<body>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
    </div></th>
  </tr>

  <form name="form1" method="post" action="">
   <div id="obra" style="display:" >
     <table width="100%" border="0" cellpadding="6" cellspacing="3">
       <tr>
         <td colspan="2" nowrap class="texto_bold">Assinada:             
         <? if($res['assinada']=='S'){ echo "<span class='texto'>Sim</span>"; } 
else { echo "<span class='texto'>N&atilde;o</span>"; }  ?></td>
         <td colspan="2" nowrap class="texto_bold">Onde: <? 
			$sql="SELECT descricao from posicao where posicao='$res[assinada_onde]'";
		    $db->query($sql);
			$res2=$db->dados();
		    echo "<span class='texto'>$res2[0]</span>";?></td>
         <td width="11%" nowrap class="texto_bold">&nbsp;</td>
         <td width="10%" nowrap class="texto_bold"><? echo "<a href=\"consulta_parte_obra.php?obra=$obra\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></td>
       </tr>
       <tr>
         <td colspan="2" nowrap class="texto_bold">Marcada:             
         <? if($res['marcada']=='S'){echo"<span class='texto'>Sim</span>"; } else { echo"<span class='texto'>N&atilde;o</span>"; }  ?></td>
         <td colspan="4" nowrap class="texto_bold">Onde: <?  
			$sql="SELECT descricao from posicao where posicao='$res[marcada_onde]'";
		    $db->query($sql);
			$res2=$db->dados();
		    echo "<span class='texto'>$res2[0]</span>";?></td>
       </tr>
       <tr>
         <td width="6%" nowrap class="texto_bold"><div align="right">Datada: </div></td>
         <td width="22%" nowrap class="texto"><? if($res['datada']=='S'){ echo "Sim"; } else { echo "N&atilde;o"; }  ?></td>
         <td colspan="4" nowrap class="texto_bold">Onde: <?  
			$sql="SELECT descricao from posicao where posicao='$res[datada_onde]'";
		    $db->query($sql);
			$res2=$db->dados();
		    echo "<span class='texto'>$res2[0]</span>";?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Data: <? echo"<span class='texto'>".exibeDataNegativa($dt_dia)."</span>"; ?>&nbsp;/ <? echo"<span class='texto'>".exibeDataNegativa($dt_mes)."</span>"; ?>&nbsp;/ <? echo"<span class='texto'>".exibeDataNegativa($dt_ano)."</span>"; ?>&nbsp;- <? echo"<span class='texto'>".exibeDataNegativa($dt_extra1)."</span>"; ?> &nbsp;(
           <? if($res['dt_parte_tp']=='circa') echo "<span class='texto'>circa</span>" ; elseif($res['dt_parte_tp']=='?') echo "<span class='texto'>?</span>"; ?>
&nbsp;)
	</td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2" nowrap class="texto_bold">Local de produ&ccedil;&atilde;o identificado:
             <? if($res['localizada']=='S'){ echo "<span class='texto'>Sim</span>"; } else { echo "<span class='texto'>N&atilde;o</span>"; }  ?></td>
         <td colspan="4" nowrap class="texto_bold">Onde:             
         <? 
			$sql="SELECT descricao from posicao where posicao='$res[localizada_onde]'";
		    $db->query($sql);
			$res2=$db->dados();
		    echo "<span class='texto'>$res2[0]</span>";?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Local: <? echo "<span class='texto'>$res[local]</span>"; ?></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="6" class="texto_bold">Estado de conserva&ccedil;&atilde;o:
         <? 
        $sql="SELECT descricao from estado_conserv where estado_conserv='$res[estado_conserv]'";
        $db->query($sql);
        $res2=$db->dados();
        echo "<span class='texto'>$res2[0]</span>"; 
       ?></td>
       </tr>
       <tr>
         <td colspan="6" class="texto_bold">Transcri&ccedil;&atilde;o de assinatura: <? echo "<span class='texto'>$res[transc_assinatura]</span>"; ?></td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Outras inscri&ccedil;&otilde;es: <? echo "<span class='texto'>$res[outras_inscricoes]</span>"; ?></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Material/T&eacute;cnica: <? echo "<span class='texto'>$res[material_tecnica]</span>"; ?></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Descri&ccedil;&atilde;o formal:<br><? echo "<span class='texto'>$res[descr_formal]</span>"; ?></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">Localiza&ccedil;&atilde;o atual: <? echo "<span class='texto'>$res[local_atual]</span>"; ?></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold"><img src="imgs/icons/mais.gif" width="10" height="10" border="0" align="baseline" id="img_par"><a href="#" onClick="controle_lista('parte', 'img_par'); return false"> Dimens&otilde;es
             da parte:</a></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr id='parte' style="display:none">
         <td colspan="4" class="texto_bold">
	Altura: <? echo "<span class='texto'>$res[dim_parte_altura]</span>"; ?>&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Largura: <? echo "<span class='texto'>$res[dim_parte_largura]</span>"; ?>&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Di&acirc;metro: <? echo "<span class='texto'>$res[dim_parte_diametro]</span>"; ?> cm<br>
	Profundidade: <? echo "<span class='texto'>$res[dim_parte_profund]</span>"; ?> &nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Peso: <? echo "<span class='texto'>$res[dim_parte_peso]</span>"; ?>&nbsp;Kg 
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Formato:</a>&nbsp;&nbsp; <select name="dim_parte_formato" class="combo_cadastro" id="dim_parte_formato" onChange="alterouCampo = 1;">
    <option value="" <? if($res['dim_parte_formato']=='') echo "Selected" ?>></option>
   <option value="C" <? if($res['dim_parte_formato']=='C') echo "Selected" ?>>Circular</option>
   <option value="I" <? if($res['dim_parte_formato']=='I') echo "Selected" ?>>Irregular</option>
   <option value="L" <? if($res['dim_parte_formato']=='L') echo "Selected" ?>>Los&acirc;ngico</option>
   <option value="O" <? if($res['dim_parte_formato']=='O') echo "Selected" ?>>Oval</option>
   <option value="T" <? if($res['dim_parte_formato']=='T') echo "Selected" ?>>Triangular</option>
 </select></td>
       </tr>
   <?    
      $sql_mold="SELECT a.* from moldura as a where a.obra='$_REQUEST[obra]' and a.parte='$_REQUEST[parte]'";
      $db_mold->query($sql_mold);
     $res_mold=$db_mold->dados();
   ?>
       <tr>
         <td colspan="4" class="texto_bold"><img src="imgs/icons/mais.gif" width="10" height="10" border="0" align="baseline" id="img_mod"><a href="#" onClick="controle_lista('mold', 'img_mod'); return false"> Dimens&otilde;es
             da moldura:</a></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr id='mold' style="display:none">
         <td colspan="4" class="texto_bold">Moldura:&nbsp;<? if($res['dim_mold_possui']=='S'){ echo "<span class='texto'>Sim</span>"; } 
 else { echo "<span class='texto'>N&atilde;o</span>"; }?>
	<br><br>Altura: <? echo "<span class='texto'>$res_mold[altura_externa]</span>"; ?>&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Largura: <? echo "<span class='texto'>$res_mold[largura_externa]</span>"; ?>&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
	Profundidade: <? echo "<span class='texto'>$res_mold[profundidade_externa]</span>"; ?> &nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Peso: <? echo "<span class='texto'>$res_mold[peso]</span>"; ?>&nbsp;Kg &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Formato:&nbsp;
                                   <select name="formato" class="combo_cadastro" id="formato" onChange="alterouCampo = 1;">
    		       <option value="" <? if($res_mold['formato']=='') echo "Selected" ?>></option>
   		       <option value="C" <? if($res_mold['formato']=='C') echo "Selected" ?>>Circular</option>
   		       <option value="I" <? if($res_mold['formato']=='I') echo "Selected" ?>>Irregular</option>
   		       <option value="L" <? if($res_mold['formato']=='L') echo "Selected" ?>>Los&acirc;ngico</option>
   		       <option value="O" <? if($res_mold['formato']=='O') echo "Selected" ?>>Oval</option>
   		       <option value="T" <? if($res_mold['formato']=='T') echo "Selected" ?>>Triangular</option></select>
	<br><br>Material/Técnica: <? echo "<span class='texto'>$res_mold[material_tecnica]</span>"; ?><br><br>
	Suporte: <? echo "<span class='texto'>$res_mold[suporte]</span>"; ?> 

                              </td>

         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold"><img src="imgs/icons/mais.gif" width="10" height="10" border="0" align="baseline" id="img_base"><a href="#" onClick="controle_lista('base', 'img_base'); return false"> Dimens&otilde;es
             da base</a></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr id='base' style="display:none">
         <td colspan="4" class="texto_bold">Base:&nbsp;
           <? if($res['dim_base_possui']=='S'){ echo "<span class='texto'>Sim</span>"; } 
else { echo "<span class='texto'>N&atilde;o</span>"; }?>           <br>
           Altura: <? echo "<span class='texto'>$res[dim_base_altura]</span>"; ?>&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Largura: <? echo "<span class='texto'>$res[dim_base_largura]</span>"; ?>&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Di&acirc;metro: <? echo "<span class='texto'>$res[dim_base_diametro]</span>"; ?> cm<br>
      Profundidade: <? echo "<span class='texto'>$res[dim_base_profund]</span>"; ?> &nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;Peso: <? echo "<span class='texto'>$res[dim_base_peso]</span>"; ?>&nbsp;Kg</td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold"><img src="imgs/icons/mais.gif" width="10" height="10" border="0" align="baseline" id="img_pasp"> <a href="#" onClick="controle_lista('pasp', 'img_pasp'); return false"> Dimens&otilde;es
             do passe partout:</a></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr id='pasp' style="display:none">
         <td colspan="4" class="texto_bold">Passe partout:&nbsp;<? if($res['dim_pasp_possui']=='S'){ echo "<span class='texto'>Sim</span>"; } 
else { echo "<span class='texto'>N&atilde;o</span>"; }?>           <br>
           Altura: <? echo "<span class='texto'>$res[dim_pasp_altura]</span>"; ?>&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Largura: <? echo "<span class='texto'>$res[dim_pasp_largura]</span>"; ?>&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Di&acirc;metro: <? echo "<span class='texto'>$res[dim_pasp_diametro]</span>"; ?>&nbsp;cm<br>
      Profundidade: <? echo "<span class='texto'>$res[dim_pasp_profund]</span>"; ?> &nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;Peso: <? echo "<span class='texto'>$res[dim_pasp_peso]</span>"; ?>&nbsp;Kg</td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold">&nbsp;Data de &uacute;ltima avalia&ccedil;&atilde;o: <? $data_ult_aval=formata_data($res['data_ult_aval']); echo "<span class='texto'>$data_ult_aval</span>";  ?> </td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold"> &nbsp;Data de cataloga&ccedil;&atilde;o: <? $data_catalog=formata_data($res['data_catalog']); echo "<span class='texto'>$data_catalog</span>";  ?>&nbsp;&nbsp;Data
           de atualiza&ccedil;&atilde;o: <? $data_ult_altera=formata_data($res['data_ult_altera']); echo"<span class='texto'>$data_ult_altera</span>"; ?></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="4" class="texto_bold"><? echo "<a href=\"consulta_parte_obra.php?obra=$obra\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></td>
         <td colspan="2" class="texto_bold">&nbsp;</td>
       </tr>
     </table>
   </div>
   <div id='autor' style="display:" > </div>
   <div id='parte' style="display:" > </div>  
   <div id='bio' style="display:" > </div>
   <div id='expo' style="display:" > </div>  
    <div id='img' style="display:" > </div>
 </form>
</body>
