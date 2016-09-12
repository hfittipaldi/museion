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
set_time_limit(0);
 $db=new conexao();
 $db->conecta(); 
 $autor=$_REQUEST[id];
 $msg= "Para <u>excluir</u> definitivamente este autor, habilite a caixa de sele&ccedil;&atilde;o abaixo:";

 if($_REQUEST['excluir'])
{
///Tabela de log

//
// PRD10 - Colocado em Observacao do log do sistema os dados do autor exluido
//         Primeiro inclui no log, depois deleta autor
//

 $sql="select nomeetiqueta from autor where autor='$autor'";
 $db->query($sql);
 $row=$db->dados();
 $nome=$row['nomeetiqueta'];

 $obs="Exclusão de Autor ID={".$autor."} Nome={".$nome."}";
//
 $sql2="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('E','$_SESSION[susuario]','$autor','0',now(),'$obs')";
 $db->query($sql2);
//
 $sql="delete from autor where autor = $autor";
 $db->query($sql);
///Deleta bibliografia
 $sql="delete from bibliografia where bibliografia in (select bibliografia from autor_bibliografia where autor = $autor)";
 $db->query($sql);
 $sql="delete from autor_bibliografia where autor = $autor";
 $db->query($sql);
//
///Deleta autor_exposicao
 $sql="delete from autor_exposicao where autor = $autor";
 $db->query($sql);
//
///Deleta fotografia_autor
 $sql="delete from fotografia_autor where autor = $autor";
 $db->query($sql);
//
 echo "<script>alert('Exclusão realizada com sucesso.')</script>";
 echo "<script>location.href='exclusao_autor.php'</script>";
}
?>
<table width="546"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <td width="519" valign="top">
      <?
	  $sql="select nomeetiqueta from autor where autor = $autor";
	  $db->query($sql);
	  $res=$db->dados();
	 ?>
	<form name="form1" method="post" action="<? $PHP_SELF ?>">
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
      <tr class="texto">
          <td colspan="4" align="justify" class="texto_bold">            <div align="left"></div></td>
          </tr>
        <tr class="texto">
          <td width="1%"></td>
          <td width="18%"></td>
          <td width="60%"></td>
          <td width="21%"></td>
        </tr>
        <tr class="texto"><br>
          <td colspan="2" class="texto_bold"><div align="right">Autor:</div></td>
          <td><input name="textfield" type="text" class="combo_cadastro" value="<? echo $res['nomeetiqueta'] ?>" size="60" readonly="true"></td>
          <td align="center">&nbsp;</td>
        </tr>
      <?
	  $sql="select count(*) as total from autor as a INNER JOIN autor_obra as b on (a.autor = b.autor) 
			INNER JOIN obra as c on (b.obra = c.obra) where a.autor = $autor";
	  $db->query($sql);
	  $tot=$db->dados();
	  $tot_obras= $tot['total'];
	  if ($tot_obras > 0)
		$msg= "Este autor não pode ser excluído no momento, pois está <b>associado a $tot_obras obra(s)</b>";
	 ?>
        <tr class="texto">
          <td colspan="3" class="texto_bold"><div align="right">Quantidade de Obras no Acervo: <font style="color:blue;"><? echo $tot_obras; ?></font>&nbsp;</div></td>
          <td align="center">&nbsp;</td>
        </tr>
      <?
	  $sql="select count(*) as total from autor as a INNER JOIN autor_bibliografia as b on (a.autor = b.autor) 
			INNER JOIN bibliografia as c on (b.bibliografia = c.bibliografia) where a.autor = $autor";
	  $db->query($sql);
	  $tot=$db->dados();
	  $tot_bibli= $tot['total'];
	 ?>
        <tr class="texto">
          <td colspan="3" class="texto_bold"><div align="right">Referências Bibliográficas Cadastradas: <font style="color:blue;"><? echo $tot_bibli; ?></font>&nbsp;</div></td>
          <td align="center">&nbsp;</td>
        </tr>
      <?
	  $sql="select count(*) as total from autor as a INNER JOIN autor_exposicao as b on (a.autor = b.autor) 
			INNER JOIN exposicao as c on (b.exposicao = c.exposicao) where a.autor = $autor";
	  $db->query($sql);
	  $tot=$db->dados();
	  $tot_expo= $tot['total'];
	 ?>
        <tr class="texto">
          <td colspan="3" class="texto_bold"><div align="right">Exposições Cadastradas: <font style="color:blue;"><? echo $tot_expo; ?></font>&nbsp;</div></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="2" class="texto_bold">&nbsp;</td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="4" class="texto"><div align="center"><? echo $msg; ?></div></td>
          </tr>
        <tr class="texto">
          <td colspan="2" class="texto_bold">&nbsp;</td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
		<? if ($tot_obras == 0) { ?>
        <tr class="texto">
          <td colspan="2" class="texto_bold"><div align="right"></div></td>
          <td><div id="aguarde" style="display:none;">Aguarde...</div><input type="checkbox" name="checkbox" id="checkbox" value="checkbox" 
		  onclick='if(this.checked) {document.getElementById("excluir").disabled=false} else {document.getElementById("excluir").disabled=true}'>
            <input name="excluir" type="submit" class="botao" id="excluir" disabled value="Excluir" onClick="if (confirm('Confirma a exclusão definitiva do registro <? echo $res['nomeetiqueta'] ?> ?')) { document.getElementById('checkbox').style.display='none'; this.style.display='none'; document.getElementById('aguarde').style.display=''; } else { return false; }">
            <input name="id" type="hidden" id="id" value="<? echo $autor ?>">
			</td>
          <td align="center">&nbsp;</td>
        </tr>
		<? } ?>
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