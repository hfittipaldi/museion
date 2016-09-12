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
var i = qual.value;
document.location=('usuario.php?page='+ i);
}}
function direciona()
{
 window.location='usuario_perm1.php?item='+document.getElementById('item').value+'&op=<? echo $_REQUEST[op] ?>&usuario=<? echo $_REQUEST[usuario] ?>';
}
</script>

</head>

<body>
<table width="270"  border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="356" scope="col"><div align="left" class="tit_interno">
      <? 
//teste pra validar se foi passado algum id-usuario como parametro senao retorna....
/*if($_REQUEST[user]=='')
 echo"<script>location.href='usuario1.php'</script>";
else*/
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=$_REQUEST['usuario'];
$op=$_REQUEST['op'];
function converte()
{
//utilizada pra toda vez q ocorrer um update na permissao nao precisar colocar o usuario corrente
// em uma sessao;
global $db;
  $sql="select a.nome from usuario as a where a.usuario='$_REQUEST[usuario]'";
  $db->query($sql);
  $res=$db->dados();
return $res[0];
}  
?>
    </div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td height="24" bgcolor="#ddddd5" class="texto_bold"><div align="center"> <? echo converte($_REQUEST[usuario]) ?></div>            
          <div align="center"></div>            <div align="center"></div>            <div align="center"></div></td>
          </tr>
        <tr>
          <td bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
        <tr class="texto">
          <td colspan="4" align="center" class="texto_bold"><br>
		  Selecione o módulo:
		  <select name="item" class="combo_cadastro" onChange="direciona()">
		  <option value=""></option>
		  <?
		  $sql="SELECT item,nome  from menu_item  where length(item)=1 ORDER by item asc";
		  $db->query($sql);
		  
		  while($row=$db->dados())
		  {
		    //echo "<a href='usuario_perm1.php?item=$item&op=$op&user=$_SESSION[suser]'>$nome</a>";
		  ?>  
		  <option value='<? echo $row[0]?>'><? echo $row[1] ?></option>
          <? } ?>
		  </select>
</td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="left" class="texto">
		  <? echo "<a href=\"usuario.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></td>
          </tr>
        <tr class="texto">
          <td width="50%"></td>
          <td width="26%"></td>
          <td width="12%"></td>
          <td width="12%"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <p>
          <input name="usuario" type="hidden" id="usuario" value="<? echo $usuario ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
          <input name="item" type="hidden" id="item" value="<? echo $item ?>">
</p>
      </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>
