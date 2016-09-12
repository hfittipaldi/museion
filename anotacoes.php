<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style type="text/css">
.roll {
	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
</style>
<script>
function seta_foco()
{
    form1.assunto.focus();
	return;}
function valida()
{
 with(document.form1){
    if(assunto.value==''){
	  alert('Preencha o campo Assunto.');
	  assunto.focus();
	  return false;}
	if ('<? echo $_REQUEST['tipo']; ?>' == '2' && '<? echo $_REQUEST['op'] ?>' != 'update') {
	    if(destino.value=='0'){
		  alert('Selecione o destinatário.');
		  destino.focus();
		  return false;}
	}
    if(notas.value==''){
	  alert('Preencha o campo Anotação.');
	  notas.focus();
	  return false;}
    if(aviso.value==''){
	  alert('Preencha o campo Data de aviso.');
	  aviso.focus();
	  return false;}
 }}
</script> 
</head>

<body onload='seta_foco();'>      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="0" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	<? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();


$dbobra=new conexao();
$dbobra->conecta();
$dbrele=new conexao();
$dbrele->conecta();
$dbreli=new conexao();
$dbreli->conecta();

$tipo=$_REQUEST['tipo'];
$notid=$_REQUEST['anot'];
$op=$_REQUEST['op'];
$assunto=$_POST['assunto'];
$lida=$_POST['lida'];
$notas=$_POST['notas'];
$dt_aviso=$_POST['aviso'];
$relacionar=0;
if ($dt_aviso=='' && $tipo=='2')
	$dt_aviso=date("d/m/Y");
$dt_inclusao=$_POST['inclusao'];
if ($tipo=='2' && $op=='update')
	echo "&nbsp;Agenda / Mensagem";
elseif ($tipo == '2')
	echo "&nbsp;Agenda / Enviar mensagem";
else
	echo "&nbsp;Agenda / Anotações";
	?></div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="<? echo $PHP_SELF ?>" onSubmit="return valida();">
		<input type="hidden" name="op" value="<? echo $op; ?>">
		<input type="hidden" name="anot" value="<? echo $notid; ?>">
		<input type="hidden" name="tipo" value="<? echo $tipo; ?>">
<?
if($notid && $op=='update' && $_REQUEST['enviar']=='')
 {
   $sql="SELECT * from agenda where agenda='$notid'";
   $db->query($sql);
	while($col=$db->dados())
	{
	  $assunto=$col['assunto'];
	  $de=$col['usuario_origem'];
          $relacionar=$col['eh_confirma'];
	  $lida=$col['eh_lida'];
	  $notas=$col['texto'];
	  $dt_aviso=$col['data_aviso'];
	  $dt_aviso= explode("-", $dt_aviso);
	  $ano= $dt_aviso[0]; $mes= $dt_aviso[1]; $dia= $dt_aviso[2];
	  $dt_aviso= $dia."/".$mes."/".$ano;
	  $dt_inclusao=$col['data_inclusao'];
	  $dt_inclusao= explode("-", $dt_inclusao);
	  $ano= $dt_inclusao[0]; $mes= $dt_inclusao[1]; $dia= $dt_inclusao[2];
	  $dt_inclusao= $dia."/".$mes."/".$ano;
          $acao=$col['acao'];
	 }}
if($notid && $op=='del')
{
     $sql="DELETE from agenda where agenda in ($notid)";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 ////
	 $hoje= date("Y-m-d");
	 $sql= "SELECT count(*) as total from agenda where usuario = '$_SESSION[susuario]' AND eh_lida = '0' AND data_aviso = '$hoje'";
	 $db->query($sql);
	 $totMSG= $db->dados();
	 if ($totMSG['total'] > 0)
		echo "<script>top.document.getElementById('iconemsg').style.display= '';</script>";
	 else
		echo "<script>top.document.getElementById('iconemsg').style.display= 'none';</script>";
	 ////
	 echo"<script>location.href='notasdodia.php'</script>";
	 exit();
}	 
	 ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td colspan="2" class="texto_bold"><div align="center"><br><br>Assunto:
              <input name="assunto" type="text" class="combo_cadastro" id="assunto" maxlength="100" <? if ($tipo=='2' && $op=='update') { echo "readonly"; } ?> value="<? echo htmlentities($assunto, ENT_QUOTES); ?>" size="<? if ($notid <> '') { echo "64"; } else { echo "78"; } ?>"> 
			  <? if ($notid <> '') { ?>
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lida: <input type="checkbox" name="lida" id="lida" <? if ($lida) { echo "checked"; } ?> value="1">
			  <? } ?>
          </div></td>
        </tr>
		<? if ($tipo=='2' && $op<>'update') { ?>
		<tr>
			<td colspan="2" class="texto_bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para: <select class="combo_cadastro" name="destino" id="destino"><option value="0">&nbsp;&nbsp;</option>
				<?php 
					$sql= "SELECT usuario,nome from usuario where status = 'S' AND usuario <> '$_SESSION[susuario]' order by nome";
					$db->query($sql);
					while ($sel=$db->dados()) {
						if ($_POST['destino'] == $sel['usuario'])
							echo "<option value='$sel[usuario]' selected>$sel[nome]</option>";
						else
							echo "<option value='$sel[usuario]'>$sel[nome]</option>";
					}
				?>
			</select></td>
		</tr>
		<? } ?>
		<? if ($tipo=='2' && $op=='update') { ?>
		<tr>
			<td colspan="2" class="texto_bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;De: <select class="combo_cadastro" name="origem" id="origem">
				<?php 
					$sql= "SELECT nome from usuario where usuario = '$de'";
					$db->query($sql);
					if ($sel=$db->dados()) {
						echo "<option value='$sel[nome]' selected>$sel[nome]</option>";
					}
				?>
			</select></td>
		</tr>
		<? } ?>


 

        <tr>
          <td colspan="2" class="texto_bold"><div align="center"><br>&nbsp;&nbsp;&nbsp;Anotação <br>
              <textarea name="notas" id="notas" class="combo_cadastro roll" <? if ($tipo=='2' && $op=='update') { echo "readonly"; } ?> cols="90" rows="12"><? echo $notas; ?></textarea>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"><div align="center">Data de Aviso: <input name="aviso" type="text" class="combo_cadastro" id="aviso" maxlength="10" <? if ($tipo=='2' && $op=='update') { echo "readonly"; } ?> value="<? echo $dt_aviso; ?>" size="12"> 
			 <? if ($dt_inclusao <> '') { ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Incluída em: <input name="inclusao" type="text" class="combo_cadastro" id="inclusao" readonly value="<? echo $dt_inclusao; ?>" tabindex="-1" size="12">
			 <? } ?>
          </div><br></td>
        </tr>
        <tr>
          <td width="80%">
			<? if ($notid <> 0) { 
	            echo "<a href='javascript:history.back();' tabindex='-1'><img src='imgs/icons/btn_voltar.gif' border='0' alt='Notas do dia' >";
			} else {
	            echo "<a href='notasdodia.php' tabindex='-1'><img src='imgs/icons/btn_voltar.gif' border='0' alt='Notas do dia' >";
			} ?>
		  </td>

               <?if ($acao<>""){
                       if ($relacionar=="0"){?> 
                          <td valign="top"><span class="texto_bold"><input name="relacionar" type="submit" class="botao" id="relacionar" value="Relacionar"></span></td>
                        <?}?>
                <?}?>
               <td valign="top">&nbsp;<span class="texto_bold"><input name="enviar" type="submit" class="botao" id="enviar" value="Gravar"></span></td>
          </tr>
      </table>
      <?


   if ($acao<>''){
   if($_REQUEST['relacionar']<>'')
   {   
      echo "entrou em relacionamento";
      $sqlobra="SELECT obrarel,obra,acao from agenda where agenda='$notid'";
      $dbobra->query($sqlobra);
      $relobra= $dbobra->dados(); 
      $relacionar='1';

            if($relobra['acao']=='E')
            {
	        $sqlrele="DELETE from relacionamento_obra where obrarel='".$relobra['obra']."'and obra='".$relobra['obrarel']."' and relacionamento='1' ";
                $dbrele->query($sqlrele);

                $sql="UPDATE agenda set eh_confirma='$relacionar' where agenda='$notid'";
                $db->query($sql);
                echo"<script>alert('Exclusão de relacionamento efetuada com sucesso.')</script>";
	        echo"<script>location.href='notasdodia.php?tipo=$tipo'</script>";
             }

             if($relobra['acao']=='I')
             {

             $sqlreli= "INSERT INTO relacionamento_obra(obra, relacionamento,obrarel ) 
                        values($relobra[obrarel],'1',$relobra[obra])";
	      $dbreli->query($sqlreli);
              $reli= $dbreli->dados(); 
              $_POST[lida] ='1';
              $relacionar='1';

              $sql="UPDATE agenda set eh_lida='1', eh_confirma='1' where agenda='$notid'";
              $db->query($sql);
              echo"<script>alert('Relacionamento efetuado com sucesso.')</script>";
	      echo"<script>location.href='notasdodia.php?tipo=$tipo'</script>";
             }

        }
     
     }

if($_REQUEST['enviar']<>'')
{
  $Data= explode("/", $_POST[aviso]);
  $ano= $Data[2]; $mes= $Data[1]; $dia= $Data[0];
  $Data= $ano."-".$mes."-".$dia;

  if ($Data == '--')
	 echo "<script>alert('Preencha o campo Data de aviso.');</script>";
  elseif (substr($Data,0,2) == '--')
	 echo "<script>alert('Data de aviso inválida!');</script>";

  elseif($_REQUEST[op]=='update')
   {
	 if ($_POST[lida] == '')
		$lida= 0;

         $sql="UPDATE agenda set assunto='$_POST[assunto]', texto='$_POST[notas]', data_aviso='$Data', eh_lida='$lida', eh_confirma='$relacionar' where agenda='$notid'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 ////
	 $hoje= date("Y-m-d");
	 $sql= "SELECT count(*) as total from agenda where usuario = '$_SESSION[susuario]' AND eh_lida = '0' AND data_aviso = '$hoje'";
	 $db->query($sql);
	 $totMSG= $db->dados();
	 if ($totMSG['total'] > 0)
		echo "<script>top.document.getElementById('iconemsg').style.display= '';</script>";
	 else
		echo "<script>top.document.getElementById('iconemsg').style.display= 'none';</script>";
	 ////
	 echo"<script>location.href='notasdodia.php'</script>";
	}
  else {
	 $dataInc= date("Y-m-d");
	 if ($tipo == '2')
		$usu_destino= $_POST['destino'];
	 else
		$usu_destino= $_SESSION['susuario'];
     $sql= "INSERT INTO agenda(assunto,texto,data_aviso,eh_lida,data_inclusao,usuario_origem,usuario,eh_confirma) 
			values('$_POST[assunto]','$_POST[notas]','$Data','0','$dataInc','$_SESSION[susuario]','$usu_destino','$relacionar')";
	 $db->query($sql);
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='anotacoes.php?tipo=$tipo'</script>";
	 }
}   
?>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
