<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual) {
	if (qual.selectedIndex.selected != '') {
                document.location=('bibliografia_obra1.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i&nome=<?echo $_REQUEST[nome]?>);


	}
}
function valida()
{
 with(document.form1)
 {
    if(autoria.value==''){
	  alert('Informe a autoria.');
	  autoria.focus();
	  return false;}
    if(descricao.value==''){
	  alert('É necessário preencher com a referência!');
	  descricao.focus();
	  return false;}
  }
}

function cancela()
{


window.opener.location.reload();

document.form1.cancelar.submit=window.close();


  return true;
}
</script>  
</head>

<body>      
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr>
    <td width="100%" height="100%" valign="top"><form name="form1" method="post" onSubmit="return valida()" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db1=new conexao();
$db1->conecta();
$dbreg=new conexao();
$dbreg->conecta();
?>
<script>window.opener.location.reload();</script>
<?
$referencia=$_REQUEST[nome];
      $bib=$_REQUEST['bib'];
     $tipo=$_REQUEST[tipo];
$parametro=$_REQUEST[parametro];
    $valor=$_REQUEST[valor];
     $tipo=$_REQUEST[tipo];
       $_REQUEST[op]="update";

	$movid= $_REQUEST['movid'];
	if ($tipo='obra')  $obrid= $_REQUEST['obrid'];
	if ($tipo='autor') $autid= $_REQUEST['autid'];
	if ($movid <> '') {
		$tipo= 'movimentacao';
		$valor= $movid;
		$parametro= 'movid';
	}
	elseif ($obrid <> '') {
		$tipo= 'obra';
		$valor= $obrid;
		$parametro= 'obrid';
	}
	elseif ($autid <> '') {
		$tipo= 'autor';
		$valor= $autid;
		$parametro= 'autid';
	}




  
   $sql="SELECT a.bibliografia, a.*,b.".$tipo.", b.observacao
                         FROM bibliografia as a INNER JOIN  ".$tipo."_bibliografia as b on  (a.bibliografia=b.bibliografia)
                         where (b.bibliografia='$_REQUEST[bib]') and (b.".$tipo."='$_REQUEST[obrid]')";

   $db->query($sql);
   $res=$db->dados();
   if ($res['bibliografia'] <> '') {
       echo"<script>alert('Bibliografia já associada.')</script>";
       echo"<script>location.href='bibliografia_insere2.php?nome=$referencia&op=insert&".$parametro."=".$valor."&bib=$bib;'</script>";
    }


    $sql="SELECT * FROM bibliografia where bibliografia='$bib'";

   $db->query($sql);
   $res=$db->dados();

?>
          <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">

	     <tr><td>&nbsp;</td></tr>
             <tr width="100%">
                <td colspan="3 class="texto_bold">&nbsp;</td>
             </tr>
             <tr bgcolor="#96ADBE">
                <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
             </tr>

             <tr bgcolor="#96ADBE">


                <td height="24" bgcolor="#96ADBE" class="texto_bold" style="color: white;"><div align="left"> Detalhes da referência bibliográfica a vincular nº <? echo $res['bibliografia']; ?></div></td>
                <td valign="top"><? echo "<a href=\"bibliografia_insere2.php?"."nome=".$referencia."&".$parametro."=".$valor."&tipo=".$tipo."&bib=".$bib."\"'><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar'>"; ?></td>

             </tr>
             <tr>
                <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
             </tr>
          </table>       

        <table width="90%"  border="0" cellpadding="0" cellspacing="4">
	<br>
        <tr class="texto_bold" style="color: navy;" >
          <td><div align="right"><br>Autoria*:</div></td>
          <td colspan="2"><br><? echo $res['autoria'];?></td>
        </tr>

        <tr class="texto_bold" style="color: navy;">
          <td><div align="right">ISBN:</div></td>
          <td colspan="2"><? echo $res['isbn']; ?></td>
        </tr>

        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Referência*:</div></td>
             <td width="100%" colspan="2"><? echo htmlentities($res['referencia'], ENT_QUOTES); ?></td>
        </tr>

        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Local:</div></td>
          <td width="100%" colspan="2"><? echo htmlentities($res['local'], ENT_QUOTES); ?></td>
        </tr>

        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Editora:</div></td>
          <td width="100%" colspan="2"><? echo htmlentities($res['editora'], ENT_QUOTES); ?></td>
        </tr>
        <tr class="texto_bold" style="color: navy;">
          <td width="15%"><div align="right">Ano*:</div></td>
          <td width="100%" colspan="2"><? echo htmlentities($res['ano'], ENT_QUOTES); ?></td>
         </tr>
         
          <td>&nbsp;</td>
        </tr>
      </table>
    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
       <tr>
         <td>
             <tr class="texto_bold">
                 <td width="5%">&nbsp;</td><td width="100%" colspan="2"><? echo "Observações "?></td></tr>

             <tr class="texto_bold">
                 <td width="5%">&nbsp;</td>
                 <td width="100%" colspan="0"><textarea name="observacao" cols="117" rows="3" wrap="VIRTUAL" class="combo_cadastro" id="observacao"><? echo htmlentities($res['observacao'], ENT_QUOTES); ?></textarea></td>
                  <td width="35%">&nbsp;</td>
             </tr>

            <tr>
   	      <td>&nbsp; </td>
            </tr>
           </td>

         </tr>

 
      </table>
   <table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr width="100%" class="texto_bold" style="color: navy;">
                 <td width="100%" align="center" valign="top">
                    <input name="gravar" type="submit" class="botao" id="gravar" value="Gravar">
               </td>

                   <td width="100%" align="center" valign="top"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;</td>
 

       </tr>
   </table>
  <?
     if ($_REQUEST[ano]=='') {$_REQUEST[ano]='0';}



          if  ($_REQUEST['voltar']<>'')   {

 	          echo"<script>alert('Nenhuma associação realizada.')</script>";
  
	          echo"<script>location.href='bibliografia_insere2.php?nome=$referencia&op=insert&".$parametro."=".$valor."&bib=$bib;'</script>";
            }

if($_REQUEST['gravar']<>'')
{
if ($_REQUEST[ano]=='') {$_REQUEST[ano]='0';}
if($_REQUEST[op]=='update')
{
    $sql="INSERT INTO ".$tipo."_bibliografia($tipo,bibliografia,observacao) values('$valor','$bib','$_REQUEST[observacao]')";

	$db->query($sql);

//ATUALIZA ALTERAÇÃO DA OBRA
	$sql="UPDATE $tipo set atualizado='$_SESSION[susuario]', data_catalog2=now() where ".$tipo." = $valor";
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from ".$tipo." where ".$tipo." = ".$valor;
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//



//////////////////////////////Tabela Log_atualizacao/////////////////////////////

   $sqlreg="SELECT * FROM ".$tipo." WHERE ".$tipo."=".$valor;
   $dbreg->query($sqlreg);
   $registro=$dbreg->dados();
   $num_registro=$registro[num_registro];
   $obs1="Alteração ".$tipo." ID={".$valor."}  Registro={".$num_registro."}";
   $obs1=$obs1. "Ação={Inclusão de bibliografia existente:".$_REQUEST[bib]."}";
   if ($tipo='obra') $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('I','$_SESSION[susuario]','0','$valor',now(),'$obs1')";
   if ($tipo='autor') $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('I','$_SESSION[susuario]','$valor','0',now(),'$obs1')";
  $db->query($sql);
   //////////////////////////////////////////////////////////////////
	 echo"<script>alert('Inclusão efetuada com sucesso.')</script>";
         echo"<script>document.form1.gravar.submit=window.close();</script>";



 
 }
}   
?>
  </form>
  </td>
  </tr>
</table>
</body>
</html>