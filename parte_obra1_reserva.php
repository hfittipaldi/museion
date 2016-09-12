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
			location.href= 'parte_obra_dimensoes_reserva.php?op=update&obra=<? echo $_REQUEST[obra] ?>&parte=<? echo $_REQUEST[parte] ?>';
	}
	else
		location.href= 'parte_obra_dimensoes_reserva.php?op=update&obra=<? echo $_REQUEST[obra] ?>&parte=<? echo $_REQUEST[parte] ?>';
}

function valida(){
    var form  = document.form1;
	if (form.nome_objeto.value == '') {
	    alert('Informe o Nome do Objeto.');
		return false;
	} 

  if(form.dt_dia.value!=''){
	if(form.dt_dia.value>31){
	 alert('Erro!Dia inválido'); 
	 return false;}}//ok
   if(form.dt_mes.value!=''){
   if(form.dt_mes.value>12){
	  alert('Erro.Mês inválido');
	return false;}}
   /// Mes com 31 dias
 if(form.dt_dia.value!='' && form.dt_mes.value!=''){
    if(form.dt_dia.value==31){
	    if((form.dt_mes.value==2)||(form.dt_mes.value==4)||(form.dt_mes.value==6)||
		(form.dt_mes.value==9)||(form.dt_mes.value==11)){
			 alert('Erro.Dia/Mês inválido');
	         return false;}}
  //Mes com 30 dias
  if(form.dt_dia.value==30){
	    if((form.dt_mes.value==1)||(form.dt_mes.value==2)||(form.dt_mes.value==3)||
		(form.dt_mes.value==5)||(form.dt_mes.value==7)||(form.dt_mes.value==8)||(form.dt_mes.value==10)||(form.dt_mes.value==12)){
			 alert('Erro.Dia/Mês inválido');
	         return false;}}}
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

      
<table width="520" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr>
    <td valign="top"><form name="form1" method="post" onSubmit="return valida();" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$op=$_REQUEST['op'];
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
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now())";
$db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='parte_obra_reserva.php?obra=$_REQUEST[obra]'</script>";
	 exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr class="texto"><br><br>
          <td><div align="right">Controle: </div></td>
          <td width="16%"><input name="controle" type="text" readonly=yes class="combo_cadastro" id="controle" value="<? echo htmlentities($res['controle'], ENT_QUOTES); ?>" size="10" onChange="alterouCampo = 1;"></td>
          <td colspan="2" align="right"><? if($op=='update') echo "<a href='javascript:checaAlteracao();' style='color:navy;'>Dimensões</a>"; ?>&nbsp;</td>
          </tr>
        <tr class="texto">
          <td><div align="right">Nome do objeto:</div></td>
          <td colspan="3"><input name="nome_objeto" type="text" readonly=yes class="combo_cadastro" id="nome_objeto" value="<? echo htmlentities($res['nome_objeto'], ENT_QUOTES); ?>" size="62" onChange="alterouCampo = 1;"></td>
          </tr>
        <tr class="texto">
          <td><div align="right"><a class="texto"> Material / t&eacute;cnica:</a></div></td>
          <td colspan="3"><input name="material_tecnica" type="text" readonly=yes class="combo_cadastro" id="material_tecnica" value="<? echo htmlentities($res['material_tecnica'], ENT_QUOTES); ?> " size="62" onChange="alterouCampo = 1;"></td>
          </tr>
        <tr class="texto">
          <td><div align="right"><a class="texto">Movimenta&ccedil;&atilde;o em aberto:</a></div></td>
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
          <td colspan="3"><input name="local_atual" type="text" class="combo_cadastro" id="local_atual" value="<? echo htmlentities($local_atual_movimentacoes, ENT_QUOTES); ?>" readonly size="62"></td>
          </tr>
        <tr class="texto_bold">
          <td><div align="right">Localiza&ccedil;&atilde;o atual:</a></div></td>
          <td colspan="3"><input name="localatu" type="text" class="texto" id="localatu" value="<? echo htmlentities($res['local_atual'], ENT_QUOTES); ?>" size="62" onChange="alterouCampo = 1;"></td>
          </tr>
        <tr class="texto">
          <td><div align="right"><a class="texto">Estado de conserva&ccedil;&atilde;o:</a></div></td>
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
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data da &uacute;ltima avalia&ccedil;&atilde;o:
            <input name="data_ult_aval" type="text" class="combo_cadastro" readonly=yes id="data_ult_aval" value="<? echo formata_data($res['data_ult_aval'])  ?>" size="10" maxlength="10" onChange="alterouCampo = 1;">
			</td>
          </tr>
        <tr>
          <td colspan="4" class="texto" align="center"><br>Data de cataloga&ccedil;&atilde;o:
            <input name="data_catalog" type="text" readonly="true" class="combo_cadastro" id="data_catalog" value="<? echo formata_data($res['data_catalog'])  ?>" size="10">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data de atualização:&nbsp;&nbsp;
<input name="data_ult_altera" readonly="true" type="text" class="combo_cadastro" id="data_ult_altera" value="<? echo formata_data($res['data_ult_altera']); ?>" size="10"> </td>
          </tr>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"><div align="center"><span class="texto_bold">
                <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </span></div></td>
          </tr>
        <tr>
          <td colspan="4">
            <div align="left"><? echo "<a href=\"parte_obra_reserva.php?obra=$_REQUEST[obra]\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
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
        local_atual='$_REQUEST[localatu]',
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
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now())";
$db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='parte_obra1_reserva.php?op=update&obra=$_REQUEST[obra]&parte=$_REQUEST[parte]'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert'){
     $sql= "INSERT INTO parte(obra,controle,nome_objeto,assinada,assinada_onde,marcada,marcada_onde,datada,datada_onde,dt_parte_dia,dt_parte_mes,dt_parte_ano1,dt_parte_ano2,dt_parte_tp, 
	        localizada,localizada_onde,local,transc_assinatura,outras_inscricoes,material_tecnica,
			descr_formal,local_atual,obs,estado_conserv,data_ult_aval,data_catalog)
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
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','0','$_REQUEST[obra]',now())";
$db->query($sql);
//////////////////////////////////////////////////////////////////
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	//Encaminha o usuario para o form de dimensoes da parte.
	 echo"<script>location.href='parte_obra_dimensoes_reserva.php?op=update&obra=$_REQUEST[obra]&parte=$idparte'</script>";
	 
	 }
}   
?>
    </form>
    </td>
  </tr>
</table>
</body>
</html>
