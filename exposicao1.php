<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>

function valida()
{
 with(document.form1)
 {
    if(tipo.value==''){
	  alert('Preencha com o tipo da exposição.');
	   return false;}
	 if(nome.value==''){
	   alert('Preencha com o nome dado à exposição.');
	    nome.focus();
	  return false;}
  }
}
function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-250)+',top='+((window.screen.height/2)-210)+',width=350,height=350, scrollbars=, resizable=no');
 if(parseInt(navigator.appVersion)>=4)
 {
   win.window.focus();
 }
}
</script>  
</head>

<body>      
<table width="546" height="100%"  border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <td width="519" valign="top"><form name="form1" method="post" onSubmit='return valida()' >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$id=$_REQUEST['id']; // id do autor corrente
$op=$_REQUEST['op'];
$tipo=$_REQUEST[tipo];
 if(isset($_REQUEST[id]))
 {
  if($op=='update')
   {
    $sql="SELECT a.* from exposicao as a where a.autor='$_REQUEST[id]' and exposicao='$_REQUEST[exp]'";
	//echo $sql;
    $db->query($sql);
    $row=$db->dados();
	}
  if($op=='del')
  {
     $sql="DELETE from exposicao where autor='$_REQUEST[id]' and exposicao='$_REQUEST[exp]' ";
	 $db->query($sql);
	 echo"<script>alert('Exclusão realizada com sucesso')</script>";
	 echo"<script>location.href='exposicao_teste2.php?id=$_REQUEST[id]&tipo=T'</script>";
	 exit();
   }
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4" bgcolor="#CCCCFF">
        <tr class="texto_bold">
          <td width="15%"><div align="right">Tipo:</div></td>
          <td width="22%"><select name="tipo" class="combo_cadastro">
		    <option value=''></option>
            <option value="C" <? if($row[tipo]=='C') echo "Selected" ?>>Coletiva</option>
            <option value="I" <? if($row[tipo]=='I') echo "Selected" ?>>Individual</option>
          </select></td>
          <td width="44%">Data ref.
            <input name="dt_referencia" type="text" class="combo_cadastro" id="dt_referencia" value="<? echo formata_data($row[dt_referencia]) ?>" size="10">
            (dd/yy/aaaa)</td>
          <td width="19%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Nome:</div></td>
          <td colspan="2"><input name="nome" type="text" class="combo_cadastro" id="nome" value="<? echo $row[nome] ?>" size="40"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Institui&ccedil;&atilde;o</div></td>
          <td colspan="2"><input name="instituicao" type="text" class="combo_cadastro" id="instituicao" value="<? echo $row[instituicao] ?>" size="40"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Pa&iacute;s:</div></td>
          <td colspan="2"><select name="pais" class="combo_cadastro" id="pais">
            <? 
					  $sql="SELECT distinct pais,nome from pais order by nome asc"; 
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res=$db->dados())
					  {
					  ?>
            <option value="<? echo $res[0] ;?>" <? if($row['pais']==$res[0]) echo "Selected" ?>><? echo strtoupper($res[1]); ?></option>
            <? } ?>
          </select></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Cidade: </div></td>
          <td colspan="2"><input name="cidade" type="text" class="combo_cadastro" id="cidade" value="<? echo $row[cidade] ?>" size="40">
&nbsp;Estado:
<select name="estado" class="combo_cadastro" id="estado" >
  <? 
					  $sql="SELECT distinct estado,uf  from estado order by uf asc";
					  $db->query($sql);
					  echo "<option value='0' ></option>";
					  while($res2=$db->dados())
					  { 
					  ?>
  <option value="<? echo $res2[0];?>" <? if($row['estado']==$res2[0]) echo "Selected" ?>><? echo $res2['uf']; ?></option>
  <? } ?>
</select></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Per&iacute;odo:</div></td>
          <td colspan="2"><input name="periodo" type="text" class="combo_cadastro" id="periodo" value="<? echo $row[periodo] ?>" size="40"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Pr&ecirc;mio:</div></td>
          <td colspan="2"><input name="premio" type="text" class="combo_cadastro" id="premio" value="<? echo $row[premio]  ?>" size="40"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><? if($_REQUEST['op']!='insert') echo "<a href=\"exposicao_teste2.php?id=$_REQUEST[id]&tipo=$_REQUEST[tipo]\"'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"  ?></td>
          <td><a href="pop_legado.php?id=<? echo $_REQUEST['id'] ?>" target="_blank" >(Consulta
              sistema Donato 2.4)</a></td>
          <td><div align="right">
            <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td colspan="3"><div align="right">
          </div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
      <?

if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
// Nao esquecer de ver o relacionamento deste campo obra!!!
//Por enquanto receberá o valor igual de $_REQUEST[id].
    $dt_ref=seta_data($_REQUEST[dt_referencia]);	 
     $sql=
	 "UPDATE exposicao set
	  obra='$_REQUEST[id]',
	  tipo='$_REQUEST[tipo]',
	  dt_referencia='$dt_ref',
	  nome='$_REQUEST[nome]',
	  instituicao='$_REQUEST[instituicao]',
	  pais='$_REQUEST[pais]',
	  cidade='$_REQUEST[cidade]',
	  estado='$_REQUEST[estado]',
	  periodo='$_REQUEST[periodo]',
	  premio='$_REQUEST[premio]',
	  txt_legado='$_REQUEST[txt_legado]' where exposicao=$_REQUEST[exp]";
	   
	 $db->query($sql);
	$sql2="UPDATE autor set atualizado='$_SESSION[nome]', data_catalog2=now() where autor=$_REQUEST[id]";
    $db->query($sql2); 
	echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	echo"<script>location.href='exposicao_teste2.php?id=$_REQUEST[id]&tipo=$_REQUEST[tipo]'</script>";
	exit();
	}
  elseif($_REQUEST[op]=='insert'){
  	 
	 
	 $dt_ref=seta_data($_REQUEST[dt_referencia]);	;
	 
     $sql= "INSERT INTO exposicao(obra,autor,tipo,dt_referencia,nome,instituicao,pais,
	 cidade,estado,periodo,premio,txt_legado) 
	 values('$_REQUEST[id]','$_REQUEST[id]','$_REQUEST[tipo]','$dt_ref',
	 '$_REQUEST[nome]','$_REQUEST[instituicao]','$_REQUEST[pais]','$_REQUEST[cidade]',
	 '$_REQUEST[estado]','$_REQUEST[periodo]','$_REQUEST[premio]','$_REQUEST[txt_legado]')";
	
	 $db->query($sql);
	
	 $sql2="UPDATE autor set atualizado='$_SESSION[nome]', data_catalog2=now() where autor=$_REQUEST[id]";
     $db->query($sql2); 
	
	 echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	 echo"<script>location.href='exposicao_teste2.php?id=$_REQUEST[id]&tipo=$_REQUEST[tipo]'</script>";
	 }
}   
?>
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
