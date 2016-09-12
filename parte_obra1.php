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
<script src="js/funcoes_padrao.js"></script>
<script>
var alterouCampo= 0;
function checaAlteracao() {
	if (alterouCampo) {
		if (confirm('O formulário foi alterado. Para salvar clique em Cancelar e depois Gravar. Clicando em OK a alteração será perdida.\n\nTem certeza que deseja prosseguir para o formulário de dimensões agora?'))
			location.href= 'parte_obra_dimensoes.php?op=update&obra=<? echo $_REQUEST[obra] ?>&parte=<? echo $_REQUEST[parte] ?>';
	}
	else
		location.href= 'parte_obra_dimensoes.php?op=update&obra=<? echo $_REQUEST[obra] ?>&parte=<? echo $_REQUEST[parte] ?>';
}

function valida(){
  with(document.form1)
  {  

	if (nome_objeto.value == '') {
	    alert('Informe o Nome do Objeto.');
                nome_objeto.focus();             
		return false;} 

	if (material_tecnica.value == '') {
	    alert('Informe a técnica.');
                material_tecnica.focus();             
		return false;} 


  if(dt_dia.value!=''){
	if(dt_dia.value>31){
	 alert('Erro!Dia inválido'); 
	 return false;}
}
   if(dt_mes.value!=''){
   if(dt_mes.value>12){
	  alert('Erro.Mês inválido');
	return false;}}
   /// Mes com 31 dias
 if(dt_dia.value!='' && dt_mes.value!=''){
    if(dt_dia.value==31){
	    if((dt_mes.value==2)||(dt_mes.value==4)||(dt_mes.value==6)||
		(dt_mes.value==9)||(dt_mes.value==11)){
			 alert('Erro.Dia/Mês inválido');
	         return false;}}
  //Mes com 30 dias
  if(dt_dia.value==30){
	    if((dt_mes.value==2)){
			 alert('Erro.Dia/Mês inválido');
	         return false;}}}


}}
function abre_manual(parametro)
{
  	win=window.open('manual_catalog.php?corfundo=cccccc&parametro='+parametro,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-130)+',height=365,width=560,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>  
</head>

<body onload='document.getElementById("controle").focus();'>      
<table width="450" border="0" align="left" cellpadding="0" cellspacing="2">
  <tr>
    <td valign="top"><form name="form1" method="post" onSubmit="return valida();" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();



$op=$_REQUEST['op'];
$dim_mold_possui='N';
$dim_base_possui='N';
$dim_pasp_possui='N';
 if(isset($_REQUEST[obra]))
 {
  if($op=='update')
   {
    $sql="SELECT a.* from parte as a where a.obra='$_REQUEST[obra]' and parte='$_REQUEST[parte]'";
	$db->query($sql);
    $res=$db->dados();
//data
		$dt_dia= $res['dt_parte_dia'];
		$dt_mes= $res['dt_parte_mes'];
		$dt_ano= $res['dt_parte_ano1'];
		$dt_extra1= $res['dt_parte_ano2'];
		$dt_extra2= $res['dt_parte_tp'];
                            $dim_mold_possui=$res['dim_mold_possui'];
                            $dim_base_possui=$res['dim_base_possui'];
                            $dim_pasp_possui=$res['dim_pasp_possui'];
                            if ($res['dim_mold_possui']=="") $dim_mold_possui='N';
                            if ($res['dim_base_possui']=="") $dim_base_possui='N';
                            if ($res['dim_pasp_possui']=="") $dim_pasp_possui='N';
/*		dtformato_externo($datacao, $datacao_extra1, '', $data['dia'], $data['mes'], $data['ano'], $data['ano2']);
		$dt_dia= $data['dia'];
		$dt_mes= $data['mes'];
		$dt_ano= $data['ano'];
		$dt_extra1= $data['ano2'];*/
		if ($dt_dia == 0)
			$dt_dia= "";
		if ($dt_mes == 0)
			$dt_mes= "";
		if ($dt_ano == 0)
			$dt_ano= "";
		if ($dt_extra1 == 0)
			$dt_extra1= "";
//
	}
  if($op=='del')
  {
     $sql="DELETE from parte where obra='$_REQUEST[obra]' and parte='$_REQUEST[parte]'";
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
$obs1="Deleção parte ID_obra={".$_REQUEST[obra]."}  ID_parte={".$_REQUEST[parte]."}";
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now(),'$obs1')";
$db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='parte_obra.php?lista=1&obra=$_REQUEST[obra]'</script>";
	 exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td colspan="4">
            <div align="left"><? echo "<a href=\"parte_obra.php?lista=1&obra=$_REQUEST[obra]\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          </tr>

        <tr class="texto_bold">
          <td><div align="right">Controle: </div></td>
          <td width="16%"><input name="controle" type="text" class="combo_cadastro" id="controle" value="<? echo htmlentities($res['controle'], ENT_QUOTES); ?>" size="10" onChange="alterouCampo = 1;"></td>
          <td colspan="2" align="right"><? if($op=='update') echo "<a href='javascript:checaAlteracao();' style='color:navy;'>Dimensões</a>"; ?>&nbsp;</td>
          </tr>
        <tr class="texto_bold">
           <td class="texto_bold"><div align="right"><a href="javascript:abre_manual(6)"  tabindex="-1" class="texto_bold_obrig" title="Obrigat&oacute;rio">Nome da parte:</a></div></td>
         
          <td colspan="3"><input name="nome_objeto" type="text" class="combo_cadastro" id="nome_objeto" value="<? echo htmlentities($res['nome_objeto'], ENT_QUOTES); ?>" size="70" onChange="alterouCampo = 1;">
          </td>
          </tr>
        <tr class="texto_bold">
          <td width="18%"><div align="right"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Assinada?</a></div></td>
          <td nowrap>SIM 
            <input name="assinada" type="radio"  onClick='if(this.checked) {document.getElementById("assinada_onde").disabled=false}' value="S" <? if($res['assinada']=='S'){ echo "checked"; } ?> onChange="alterouCampo = 1;">
&nbsp;N&Atilde;O
<input name="assinada" type="radio" onClick='if(this.checked) {document.getElementById("assinada_onde").disabled=true}'  value="N" <? if(($res['assinada']=='N')or($res['assinada']=='')){ echo "checked"; } ?> onChange="alterouCampo = 1;"></td>
          <td colspan="2"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Onde:</a>
            <select name="assinada_onde" class="combo_cadastro" id="assinada_onde" onChange="alterouCampo = 1;">
                  <? 
					  $sql="SELECT * from posicao order by posicao";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($assond=$db->dados())
					  {
				  ?>
                      <option value="<? echo $assond[0];?>"<? if($res['assinada_onde']==$assond[0]) echo "Selected" ?>><? echo $assond[1]; ?></option>
                          <? } ?>
                      </select></td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Marcada?</a></div></td>
          <td>SIM
            <input name="marcada" type="radio" onClick='if(this.checked) {document.getElementById("marcada_onde").disabled=false}' value="S" <? if($res['marcada']=='S'){ echo "checked"; } ?> onChange="alterouCampo = 1;">
&nbsp;N&Atilde;O
<input name="marcada" type="radio" onClick='if(this.checked) {document.getElementById("marcada_onde").disabled=true}'  value="N" <? if(($res['marcada']=='N')or($res['marcada']=='')){ echo "checked"; } ?> onChange="alterouCampo = 1;"></td>
          <td colspan="2"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Onde:</a>
            <select name="marcada_onde" class="combo_cadastro" id="marcada_onde" onChange="alterouCampo = 1;">
                  <? 
					  $sql="SELECT * from posicao order by posicao";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($marond=$db->dados())
					  {
				  ?>
                      <option value="<? echo $marond[0];?>"<? if($res['marcada_onde']==$marond[0]) echo "Selected" ?>><? echo $marond[1]; ?></option>
                          <? } ?>
                      </select>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Datada?</a></div></td>
          <td>SIM
            <input name="datada" type="radio" onClick='if(this.checked) {document.getElementById("datada_onde").disabled=false;}' 
value="S" <? if($res['datada']=='S'){ echo "checked"; } ?> onChange="alterouCampo = 1;">
&nbsp;N&Atilde;O
<input name="datada" type="radio" onClick='if(this.checked) {document.getElementById("datada_onde").disabled=true;}' 
value="N" <? if(($res['datada']=='N')or($res['datada']=='')){ echo "checked"; } ?> onChange="alterouCampo = 1;"></td>
          <td colspan="2"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Onde:</a>
            <select name="datada_onde" class="combo_cadastro" id="datada_onde" onChange="alterouCampo = 1;">
                  <? 
					  $sql="SELECT * from posicao order by posicao";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($datond=$db->dados())
					  {
				  ?>
                      <option value="<? echo $datond[0];?>"<? if($res['datada_onde']==$datond[0]) echo "Selected" ?>><? echo $datond[1]; ?></option>
                          <? } ?>
                      </select>
&nbsp;</td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold" nowrap  title="">Data:</a></div></td>
          <td colspan="3"><input name="dt_dia" type="text" class="combo_cadastro" id="dt_dia" value="<? echo $dt_dia ?>" size="2" onChange="alterouCampo = 1;">
            &nbsp;
            <input name="dt_mes" type="text" class="combo_cadastro" id="dt_mes" value="<? echo $dt_mes ?>" size="2" onChange="alterouCampo = 1;">
            &nbsp;
            <input name="dt_ano" type="text" class="combo_cadastro" id="dt_ano" value="<? echo $dt_ano ?>" size="4" onChange="alterouCampo = 1;">
            &nbsp;- 
            <input name="dt_extra1" type="text" class="combo_cadastro" id="dt_extra1" value="<? echo $dt_extra1 ?>" size="4" onChange="alterouCampo = 1;"> 
            &nbsp;( 
            <select name="dt_extra2" class="combo_cadastro" id="dt_extra2" onChange="alterouCampo = 1;">
              <option value=''></option>
              <option value="circa" <? if($dt_extra2=='circa') echo "Selected" ?>>circa</option>
              <option value="?" <? if($dt_extra2=='?') echo "Selected" ?>>?</option>
            </select>
            &nbsp;)</td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Local de produ&ccedil;&atilde;o identificado?</a></div></td>
          <td>SIM
            <input name="localizada" type="radio"  onClick='if(this.checked) {document.getElementById("localizada_onde").disabled=false; }'  value="S" <? if($res['localizada']=='S'){ echo "checked"; } ?> onChange="alterouCampo = 1;">
&nbsp;N&Atilde;O
<input name="localizada" type="radio" onClick='if(this.checked) {document.getElementById("localizada_onde").disabled=true; }' value="N" <? if(($res['localizada']=='N')or($res['localizada']=='')){ echo "checked"; } ?> onChange="alterouCampo = 1;"></td>
          <td colspan="2"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Onde:</a>
            <select name="localizada_onde" class="combo_cadastro" id="localizada_onde" onChange="alterouCampo = 1;">
                  <? 
					  $sql="SELECT * from posicao order by posicao";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($locond=$db->dados())
					  {
				  ?>
                      <option value="<? echo $locond[0];?>"<? if($res['localizada_onde']==$locond[0]) echo "Selected" ?>><? echo $locond[1]; ?></option>
                          <? } ?>
                      </select>
            &nbsp;</td>
          </tr>


        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Local:</a></div></td>
          <td colspan="3"><input name="local" type="text" class="combo_cadastro" id="local" value="<? echo htmlentities($res['local'], ENT_QUOTES); ?>" size="70" onChange="alterouCampo = 1;"></td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Transcri&ccedil;&atilde;o de assinatura:</a></div></td>
          <td colspan="3"><input name="transc_assinatura" type="text" class="combo_cadastro" id="transc_assinatura" value="<? echo htmlentities($res['transc_assinatura'], ENT_QUOTES); ?>" size="70" onChange="alterouCampo = 1;"></td>
          </tr>
        <tr class="texto_bold">
          <td valign="top"><div align="right"><a href="javascript:abre_manual(4)" tabindex="-1" class="texto_bold_especial">Outras inscri&ccedil;&otilde;es:</a>
          </div></td>
          <td colspan="3"><textarea name="outras_inscricoes" cols="70" wrap="VIRTUAL" class="combo_cadastro" id="outras_inscricoes" onChange="alterouCampo = 1;"><? echo $res['outras_inscricoes'] ?></textarea></td>
          </tr>


        <tr class="texto_bold">
          <td class="texto_bold"><div align="right"><a href="javascript:abre_manual(6)"  tabindex="-1" class="texto_bold_obrig" title="Obrigat&oacute;rio">Material/T&eacute;cnica:</a></div></td>
          <td colspan="3"><select name="material_tecnica" size="1" class="combo_cadastro" id="material_tecnica" title="Material T&eacute;cnica" onChange="alterouCampo = 1;">
          
          <? 
					  $sql="SELECT name from material_tecnica order by name";
					  $db->query($sql);
					  while($mattec=$db->dados())
					  {
				  ?>
                      <option value="<? echo $mattec[0];?>"<? if($res['material_tecnica']==$mattec[0]) echo "Selected" ?>><? echo $mattec[0]; ?></option>
                          <? } ?>
          
    </select>
          
         
          
          </td>
          </tr>
         <tr class="texto_bold">
          <td><div align="right">Descri&ccedil;&atilde;o formal:<br>
            <br>
            <br>
            </div></td>
          <td colspan="3"><textarea name="descr_formal" cols="70" wrap="VIRTUAL" class="combo_cadastro" id="descr_formal" onChange="alterouCampo = 1;"><? echo $res['descr_formal'] ?></textarea></td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(10)" tabindex="-1" class="texto_bold_especial">Movimenta&ccedil;&atilde;o em Aberto:</a></div></td>
		  <?
				$sql="SELECT b.* from obra_movimentacao as a inner join movimentacao as b on (a.movimentacao = b.movimentacao) 
					where a.obra='$_REQUEST[obra]' and a.data_saida <= now() and a.data_retorno = 0 order by a.data_saida DESC";
				//$sql="SELECT b.* from obra_movimentacao as a inner join movimentacao as b on (a.movimentacao = b.movimentacao) 
				//	where a.obra='$_REQUEST[obra]' and a.data_saida <= now() order by a.data_saida DESC";
				$db->query($sql);

				$local_atual_movimentacoes="";
				if($row=$db->dados()) {
					if ($row['tipo_mov']=='EI' || $row['tipo_mov']=='LI') {
						if ($row['tipo_mov']=='LI' && $row['local_int_legado']<>'') {
							$local_atual_movimentacoes= $row['local_int_legado'];
						} else {
							$sql= "SELECT nome from local where local = '$row[local_destino]'";
							$db->query($sql);
							$local_atual_movimentacoes= $db->dados();
							$local_atual_movimentacoes= $local_atual_movimentacoes['nome'];
						}
					}
					elseif ($row['tipo_mov'] == 'EE') {
						$sql= "SELECT a.instituicao from exposicao as a, movimentacao_exposicao as b where a.exposicao = b.exposicao AND b.movimentacao = '$row[movimentacao]'";
						$db->query($sql);
						$local_atual_movimentacoes= $db->dados();
						$local_atual_movimentacoes= $local_atual_movimentacoes['instituicao'];
					}
					elseif ($row['tipo_mov'] == 'LE') {
						$local_atual_movimentacoes= $row['local_externo'];
					}
				}
		  ?>
          <td colspan="3"><input name="local_atual" type="text" class="combo_cadastro" id="local_atual" value="<? echo htmlentities($local_atual_movimentacoes, ENT_QUOTES); ?>" readonly size="70"></td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right">Localiza&ccedil;&atilde;o Atual:</a></div></td>
          <td colspan="3"><input name="localatu" type="text" class="combo_cadastro" id="localatu" value="<? echo htmlentities($res['local_atual'], ENT_QUOTES); ?>" size="70" onChange="alterouCampo = 1;"></td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right"><a href="javascript:abre_manual(10)" tabindex="-1" class="texto_bold_especial">Estado de conserva&ccedil;&atilde;o:</a></div></td>
          <td colspan="3"><select name="estado_conserv" class="combo_cadastro" id="estado_conserv" onChange="alterouCampo = 1;">
                  <? 
					  $sql="SELECT * from estado_conserv order by descricao";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($estcon=$db->dados())
					  {
				  ?>
                      <option value="<? echo $estcon[0];?>"<? if($res['estado_conserv']==$estcon[0]) echo "Selected" ?>><? echo $estcon[1]; ?></option>
                          <? } ?>
                      </select>
            &nbsp;&nbsp;&nbsp;&nbsp;Data de &uacute;ltima avalia&ccedil;&atilde;o:
            <input name="data_ult_aval" type="text" class="combo_cadastro" id="data_ult_aval" value="<? echo formata_data($res['data_ult_aval'])  ?>" size="10" maxlength="10" onChange="alterouCampo = 1;">
			</td>
          </tr>
        <tr>
          <td colspan="4" class="texto_bold"><br>Data de cataloga&ccedil;&atilde;o:
            <input name="data_catalog" type="text" readonly="true" class="combo_cadastro" id="data_catalog" value="<? echo formata_data($res['data_catalog'])  ?>" size="10">
&nbsp;&nbsp;Data de atualização:
<input name="data_ult_altera" readonly="true" type="text" class="combo_cadastro" id="data_ult_altera" value="<? echo formata_data($res['data_ult_altera']); ?>" size="10"> </td>
          </tr>
        <tr>
          <td colspan="4" >&nbsp;</td>
        </tr>


	<tr width="100%"class="texto">




          <td width="18%"><div align="right"><b>Foto?</div></td>
          <td >SIM 
            <input name="tem_foto" type="radio"  value="S" <? if($res['tem_foto']=='S'){ echo "checked"; } ?> onChange="alterouCampo = 1;">
&nbsp;N&Atilde;O
<input name="tem_foto" type="radio" value="N" <? if(($res['tem_foto']=='N')or($res['tem_foto']=='')){ echo "checked"; } ?> onChange="alterouCampo = 1;"></td>





          <td width="25%"><div align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Negativo?</div></td>
          <td>SIM 
            <input name="tem_negativo" type="radio"  value="S" <? if($res['tem_negativo']=='S'){ echo "checked"; } ?> onChange="alterouCampo = 1;">
&nbsp;N&Atilde;O
<input name="tem_negativo" type="radio" value="N" <? if(($res['tem_negativo']=='N')or($res['tem_negativo']=='')){ echo "checked"; } ?> onChange="alterouCampo = 1;"></td>
          </tr>
	<tr class="texto">





          <td width="25%"><div align="right"><b>Diapositivo?</div></td>
          <td >SIM 
            <input name="tem_diapositivo" type="radio"  value="S" <? if($res['tem_diapositivo']=='S'){ echo "checked"; } ?> onChange="alterouCampo = 1;">
&nbsp;N&Atilde;O
<input name="tem_diapositivo" type="radio" value="N" <? if(($res['tem_diapositivo']=='N')or($res['tem_diapositivo']=='')){ echo "checked"; } ?> onChange="alterouCampo = 1;"></td>






          <td width="18%"><div align="right"><b>Restauro?</div></td>
          <td >SIM 
            <input name="tem_restauro" type="radio"  value="S" <? if($res['tem_restauro']=='S'){ echo "checked"; } ?> onChange="alterouCampo = 1;">
&nbsp;N&Atilde;O
<input name="tem_restauro" type="radio" value="N" <? if(($res['tem_restauro']=='N')or($res['tem_restauro']=='')){ echo "checked"; } ?> onChange="alterouCampo = 1;"></td>
          </tr>
        <tr>



          <td colspan="4"><div align="center"><span class="texto_bold">
                <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </span></div></td>
          </tr>
      </table>
      <?

if($_REQUEST['enviar']<>'')
{
/* dtformato_interno($dt_dia, $dt_mes, $dt_ano, $dt_extra1, '', $data['inicial'], $data['final']);
 $dt= $data['inicial'];
 $dt_extra1= $data['final'];
 $dt_extra2=$_REQUEST['dt_extra2'];*/
 $dt_parte_dia=$_REQUEST['dt_dia'];
 $dt_parte_mes=$_REQUEST['dt_mes'];
 $dt_parte_ano1=$_REQUEST['dt_ano'];
 $dt_parte_ano2=$_REQUEST['dt_extra1'];
 $dt_parte_tp=$_REQUEST['dt_extra2'];
		if ($dt_parte_dia == "")
			$dt_parte_dia= 0;
		if ($dt_parte_mes == "")
			$dt_parte_mes= 0;
		if ($dt_parte_ano1 == "")
			$dt_parte_ano1= 0;
		if ($dt_parte_ano2 == "")
			$dt_parte_ano2= 0;
//

 $data_aval= seta_data($_REQUEST['data_ult_aval']);
 if ($data_aval == '')
	$data_aval= '0000-00-00';


  if($_REQUEST[op]=='update')
   {

        $sql="UPDATE parte set
	controle='$_REQUEST[controle]',
	nome_objeto='$_REQUEST[nome_objeto]',
	assinada='$_REQUEST[assinada]',
	assinada_onde='$_REQUEST[assinada_onde]',
	marcada='$_REQUEST[marcada]',
	marcada_onde='$_REQUEST[marcada_onde]',
	datada='$_REQUEST[datada]',
	datada_onde='$_REQUEST[datada_onde]',
	dt_parte_dia='$dt_parte_dia',
	dt_parte_mes='$dt_parte_mes',
	dt_parte_ano1='$dt_parte_ano1',
	dt_parte_ano2='$dt_parte_ano2',
	dt_parte_tp='$dt_parte_tp',

              dim_mold_possui='$dim_mold_possui',
              dim_base_possui='$dim_base_possui',
              dim_pasp_possui='$dim_pasp_possui',

	localizada='$_REQUEST[localizada]',
	localizada_onde='$_REQUEST[localizada_onde]',
	local='$_REQUEST[local]',
	transc_assinatura='$_REQUEST[transc_assinatura]',
	outras_inscricoes='$_REQUEST[outras_inscricoes]',
	material_tecnica='$_REQUEST[material_tecnica]',
        descr_formal='$_REQUEST[descr_formal]',
        local_atual='$_REQUEST[localatu]',
        obs='',
	estado_conserv='$_REQUEST[estado_conserv]',
	data_ult_aval='".$data_aval."',
	tem_foto='$_REQUEST[tem_foto]',
	tem_negativo='$_REQUEST[tem_negativo]',
	tem_diapositivo='$_REQUEST[tem_diapositivo]',
	tem_restauro='$_REQUEST[tem_restauro]',
	data_ult_altera=now()
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
      $obs1="Alteração parte ID_obra={".$_REQUEST[obra]."}  ID_parte={".$_REQUEST[parte]."}";
      $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now(),'$obs1')";
      $db->query($sql);

//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='parte_obra1.php?op=update&obra=$_REQUEST[obra]&parte=$_REQUEST[parte]'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){

     $sql= "INSERT INTO parte(obra,controle,nome_objeto,assinada,assinada_onde,marcada,marcada_onde,datada,datada_onde,dt_parte_dia,dt_parte_mes,dt_parte_ano1,dt_parte_ano2,dt_parte_tp, 
	       dim_mold_possui, dim_base_possui, dim_pasp_possui, localizada,localizada_onde,local,transc_assinatura,outras_inscricoes,material_tecnica,
			descr_formal,local_atual,obs,estado_conserv,tem_foto,tem_negativo,tem_diapositivo,tem_restauro,data_ult_aval,data_catalog)
	values(
	'".$_REQUEST['obra']."',
	'".$_REQUEST['controle']."',
	'".$_REQUEST['nome_objeto']."',
	'".$_REQUEST['assinada']."',
	'".$_REQUEST['assinada_onde']."',
	'".$_REQUEST['marcada']."',
	'".$_REQUEST['marcada_onde']."',
	'".$_REQUEST['datada']."',
	'".$_REQUEST['datada_onde']."',
	'".$dt_parte_dia."',
	'".$dt_parte_mes."',
	'".$dt_parte_ano1."',
	'".$dt_parte_ano2."',
	'".$dt_parte_tp."',
              '".$dim_mold_possui."',
              '".$dim_base_possui."',
              '".$dim_pasp_possui."',
	'".$_REQUEST['localizada']."',
	'".$_REQUEST['localizada_onde']."',
	'".$_REQUEST['local']."',
	'".$_REQUEST['transc_assinatura']."',
	'".$_REQUEST['outras_inscricoes']."',
	'".$_REQUEST['material_tecnica']."',
	'".$_REQUEST['descr_formal']."',
	'".$_REQUEST['localatu']."',
	'',
	'".$_REQUEST['estado_conserv']."',
	'".$_REQUEST['tem_foto']."',
	'".$_REQUEST['tem_negativo']."',
	'".$_REQUEST['tem_diapositivo']."',
	'".$_REQUEST['tem_restauro']."',
	'".$data_aval."',now())";
	$db->query($sql);
	$idparte=$db->lastid();
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
      $obs1="Inclusão parte ID_obra={".$_REQUEST[obra]."}  ID_parte={".$idparte."}";
      $sql2="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now(),'$obs1')";
      $db->query($sql2);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	//Encaminha o usuario para o form de dimensoes da parte.
	 echo"<script>location.href='parte_obra_dimensoes.php?op=update&obra=$_REQUEST[obra]&parte=$idparte'</script>";
	 
	 }
}   
?>
    </form>
    </td>
  </tr>
</table>
</body>
</html>
