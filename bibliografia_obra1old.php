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

function confirmar()
{
 document.form1.cancelar.submit=window.close();
 return true;
}
</script>  
</head>

<body>      
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr>
    <td width="100%" height="318" valign="top"><form name="form1" method="post" onSubmit="return valida()" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db2=new conexao();
$db2->conecta();
$db3=new conexao();
$db3->conecta();

$dbreg=new conexao();
$dbreg->conecta();
$dbbib=new conexao();
$dbbib->conecta();
$referencia=$_REQUEST[nome];
$bibliografia=$_REQUEST['bib'];
$expid=$_REQUEST['bib'];
$obra=$_REQUEST['obrid'];
$parametro="obra";

	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
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

	else
		echo "<script>alert('Tipo não informado!'); history.back();</script>";




/////////////////////////////////////////////

 $sql="SELECT a.*,b.* from obra_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
  where a.obra=".$obrid." and a.bibliografia='$_REQUEST[bib]'";
  $db->query($sql);
  $res=$db->dados();


	$sql2= "SELECT count(*) from ".$tipo."_bibliografia where $tipo = '$valor' AND bibliografia = '$expid'";             
	$db2->query($sql2);
	$tot= $db2->dados();
	$tot= $tot[0];


	if (($_REQUEST['op'] == 'insert') and ($tot == 0)) 
{
	   $sql3= "INSERT into ".$tipo."_bibliografia($tipo ,bibliografia, observacao) values('$valor','$expid', '')";
	   $db3->query($sql3);
          echo"<script>alert('Inclusão realizada com sucesso')</script>";
         echo"<script>location.href='bibliografia_insere2.php?obrid=$obrid'&nome='$referencia'</script>";

		

       //////////////////////////////Tabela Log_atualizacao/////////////////////////////

       $sqlreg="SELECT num_registro, titulo_etiq FROM obra WHERE obra='$obra'";
       $dbreg->query($sqlreg);
       $registro=$dbreg->dados();
       $num_registro=$registro[num_registro];
       $obs1="Alteração Obra ID={".$obra."}  Registro={".$num_registro."}  Titulo="."{".htmlentities($registro[titulo_etiq], ENT_QUOTES)."}";
       $obs1=$obs1. "Ação={Inclusão de bibliografia existente:".$_REQUEST[bib]."}";
       $sql3="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('A','$_SESSION[susuario]','0','$_REQUEST[obrid]',now(),'$obs1')";
       $db3->query($sql3);
        //////////////////////////////////////////////////////////////////


     if($_REQUEST[submit]<>'')
             
              echo"<script>location.href='bibliografia_obra.php?$parametro=$valor'</script>";
 



    }






if($_REQUEST['op']=='del')
{
 $sql="DELETE from obra_bibliografia where obra=".$obrid." and bibliografia='$_REQUEST[bib]'";
 $db->query($sql);
//ATUALIZA ALTERAÇÃO DA OBRA
	$sql="UPDATE obra set atualizado='$_SESSION[susuario]', data_catalog2=now() where obra =".$obrid;
	$db->query($sql);
	// atualização na ficha
	$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
	$db->query($sql);
	$nome=$db->dados();
	$sql="select data_catalog2 from obra where obra = ".$obrid;
	$db->query($sql);
	$data=$db->dados();
	$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
	echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
	echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
//



       //////////////////////////////Tabela Log_atualizacao/////////////////////////////
       $sqlreg="SELECT num_registro, titulo_etiq FROM obra WHERE obra='$obra'";
       $dbreg->query($sqlreg);
       $registro=$dbreg->dados();
       $num_registro=$registro[num_registro];
       $obs1="Alteração Obra ID={".$obra."}  Registro={".$num_registro."}  Titulo="."{".htmlentities($registro[titulo_etiq], ENT_QUOTES)."}";
       $obs1=$obs1. "Ação={Excluída da obra a bibliografia:".$_REQUEST[bib]."}";
       $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('A','$_SESSION[susuario]','0','$_REQUEST[obrid]',now(),'$obs1')";
       $db->query($sql);
       //////////////////////////////////////////////////////////////////
       echo"<script>alert('Exclusão realizada com sucesso')</script>";
       echo"<script>location.href='bibliografia_obra.php?obrid=$obrid'</script>";
 }


?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
	<br>
         <tr class="texto_bold" style="color: gray;" > <em> Detalhes da referência bibliográfica nº <? echo htmlentities($res['bibliografia'], ENT_QUOTES); ?></em>
        </tr>

        <tr class="texto">
          <td><div align="right"><br>Autoria*:</div></td>
         <td colspan="2"><br><b><? echo htmlentities($res['autoria'], ENT_QUOTES); ?></b></td>
         <td>&nbsp;</td>
        </tr>
        <tr class="texto">
          <td><div align="right">ISBN:</div></td>
          <td colspan="2"><b><? echo htmlentities($res['isbn'], ENT_QUOTES); ?></b></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto">
          <td width="15%"><div align="right">Referência*:</div></td>
        <? if(($_REQUEST[op]=='insert')and ($res['referencia']=='')){?>
             <td width="50%" colspan="2"><b><?echo $referencia?></b></td>
        <? }else{?>
            <td width="50%" colspan="2"><b><? echo htmlentities($res['referencia'], ENT_QUOTES); ?></b></td>
        <? }?>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td width="15%"><div align="right">Local:</div></td>
          <td width="50%" colspan="2"><b><? echo htmlentities($res['local'], ENT_QUOTES); ?></b>
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td width="15%"><div align="right">Editora:</div></td>
          <td width="50%" colspan="2"><b><? echo htmlentities($res['editora'], ENT_QUOTES); ?></b>
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td width="15%"><div align="right">Ano*:</div></td>
          <td width="50%" colspan="2"><b><? echo htmlentities($res['ano'], ENT_QUOTES); ?></b>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td width="15%"><div align="right">Observa&ccedil;&atildeo:</div></td>
          <td width="50%" colspan="2"><input name="observacao" type="text" class="combo_cadastro" id="observacao" value='<? echo htmlentities($res['observacao'], ENT_QUOTES); ?>' size="80">
		  </td>
          <td width="35%">&nbsp;</td>
        </tr>
        <tr>&nbsp;</tr>
        <tr>&nbsp;</tr>
        <tr>
        <td>&nbsp;</td>

             
           <?if  ($_REQUEST['op']=='update')   {?>
                         <td valign="top"><br><? echo "<a href=\"bibliografia_obra.php?".$parametro."=".$valor."\"'>
                              <img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar'>"; ?> 
                        </td>
              <?}?>
   	      <td>&nbsp; </td>
          <tr class="texto_bold" style="color: navy;">

    
          <td>&nbsp;</td>
        </tr>
      </table>


  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr width="100%" class="texto_bold" style="color: navy;">
                 <td width="60%" align="center" valign="top">
                    <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
               </td>

               <td width="100%" align="left" valign="top">
                     <input name="cancelar" type="submit" class="botao" id="cancelar" value="Cancelar">
               </td>
                 <td width="100%" align="center" valign="top"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;</td>


       </tr>
   </table>

  <?
     if ($_REQUEST[ano]=='') {$_REQUEST[ano]='0';}





   
?>


                </form>
	</td>
  </tr>
</table>
</body>
</html>