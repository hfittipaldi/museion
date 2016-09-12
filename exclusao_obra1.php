<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
<body>
<br>
<br>
<?
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
 $db=new conexao();
 $db->conecta(); 
 $num_registro=$_REQUEST[num_registro];

//Antes de excluir a obra, aplicar a permissão das coleções//
	// Primeiro verifica se o usuário é Administrador //
	$sql= "SELECT nivel from usuario where usuario = $_SESSION[susuario]";
	$db->query($sql);
	$niv_usu=$db->dados();
	if ($niv_usu[0] == 'A') {
		// nada a fazer
	} else {
	//
	$sql= "SELECT colecao,num_registro from obra where num_registro = $num_registro";
	$db->query($sql);
	$col=$db->dados();
	if ($col['colecao'] <> 0) {
		$sql= "SELECT count(*) as tot from usuario_colecao where usuario = $_SESSION[susuario] AND colecao = $col[colecao]";
		$db->query($sql);
		$tot=$db->dados();
		$tot=$tot['tot'];
		if ($tot <> 1) {
			echo"<script>alert('Usuário sem permissão para excluir a obra.');
				location.href= 'exclusao_obra.php';</script>";
		}
	}
}
////

 if($_REQUEST['excluir'])
{
// Tabela de log

//
// PRD10 - Incluido em Observacao no log do Sistema dos dados da obra excluida
//         Primeiro inclui no log depois deleta a obra
//

 $obra=$_REQUEST[obra];
 $sql="select titulo from obra where num_registro='$num_registro'";
 $db->query($sql);
 $row=$db->dados();
 $titulo=$row['titulo'];

 $obs="Excluida Obra ID={".$obra."} Registro={".$num_registro."} Titulo={".$titulo."}";
 $sql2="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('E','$_SESSION[susuario]','0','$obra',now(),'$obs')";
 $db->query($sql2);
//
//
 $sql="delete from obra where num_registro='$num_registro'";
 $db->query($sql);
//
 echo "<script>alert('Exclusão realizada com sucesso.')</script>";
 echo "<script>location.href='exclusao_obra.php'</script>";
}
?>
<table width="546"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td width="519" valign="top"><form name="form1" method="post" action="<? $PHP_SELF ?>" >
      <?
	  $sql="select obra,titulo,num_registro,colecao from obra where num_registro='$_REQUEST[num_registro]'";
	  $db->query($sql);
	  $res=$db->dados();
	  $conta=$db->contalinhas();
	  if($conta==0)
	  {
	    echo "<script>alert('Registro $_REQUEST[num_registro] não encontrado!')</script>";
		echo "<script>location.href='exclusao_obra.php'</script>";
	 }
	 ?>
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="1">
      <tr class="texto">
          <td colspan="4" align="justify" class="texto_bold">            <div align="left"></div></td>
          </tr>
        <tr class="texto">
          <td width="10%"></td>
          <td width="18%"></td>
          <td width="60%"></td>
          <td width="11%"></td>
        </tr>
		<? 
			$sql= "SELECT nome from colecao where colecao = $res[colecao]";
			$db->query($sql);
			$col=$db->dados();
			$colecao= $col['nome'];
		?>
        <tr class="texto"><br><br>
          <td colspan="2" class="texto_bold"><div align="right">Coleção:</div></td>
          <td><input name="textfield" type="text" class="combo_cadastro" value="<? echo $colecao  ?>" size="30" readonly="true"></td>
          <td align="center">&nbsp;</td>
        </tr>
		<? 
			$sql= "SELECT a.nomeetiqueta from autor as a, autor_obra as b where a.autor = b.autor AND b.obra = $res[obra] order by b.hierarquia";
			$db->query($sql);
			$aut=$db->dados();
			$nome_autor= $aut['nomeetiqueta'];
		?>
        <tr class="texto">
          <td colspan="2" class="texto_bold"><div align="right">Autor:</div></td>
          <td><input name="textfield" type="text" class="combo_cadastro" value="<? echo $nome_autor  ?>" size="70" readonly="true"></td>
          
        </tr>
        <tr class="texto">
          <td colspan="2" class="texto_bold"><div align="right">Registro:</div></td>
          <td><input name="textfield" type="text" class="combo_cadastro" value="<? echo $res[num_registro]  ?>" size="30" readonly="true"></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="2" class="texto_bold"><div align="right">T&iacute;tulo
            da obra:</div></td>
          <td colspan="2"><input name="textfield" type="text" class="combo_cadastro" value="<? echo htmlentities($res[titulo], ENT_QUOTES) ?>" size="70"  readonly="true"></td>          </tr>
        <tr class="texto">
          <td colspan="2" class="texto_bold">&nbsp;</td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="texto"><em>
              <div align="center">Para <u>excluir</u> definitivamente esta obra, 
                habilite a caixa de sele&ccedil;&atilde;o abaixo: </div></td>
          </tr>
        <tr class="texto">
          <td colspan="2" class="texto_bold">&nbsp;</td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="2" class="texto_bold"><div align="center"></div></td>
          <td><input type="checkbox" name="checkbox" value="checkbox" 
		  onclick='if(this.checked) {document.getElementById("excluir").disabled=false} else {document.getElementById("excluir").disabled=true}'>
            <input name="excluir" type="submit" class="botao" id="excluir" disabled value="Excluir" onClick="return confirm('Confirma a exclusão definitiva do registro <? echo $res[num_registro] ?>?')">
            <input name="num_registro" type="hidden" id="num_registro" value="<? echo $num_registro ?>">
            <input name="obra" type="hidden" id="obra" value="<? echo $res[obra] ?>"></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>


