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
document.location=('usuario.php?page='+ i+'&busca=<? echo $_REQUEST[busca]; ?>');
}}

function posiciona(valor) {
var i = valor;
document.location=('usuario.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}

</script>

<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
</style>
</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$val=$_REQUEST['usuario'];
$op=$_REQUEST['op'];
montalinks();
$_SESSION['lnk']=$link;

?>
</div></th>
  </tr>
  <tr>
    <th width="519" scope="col"><form name="form2" method="get" action="usuario.php" >
      <p align="right" class="texto_bold">Filtro por inicial do nome:
        <select name="busca" class="combo_cadastro">
          <option value="#" <? if($_REQUEST[busca]=='#') echo "Selected" ?>>Todos</option>
          <option value="a" <? if($_REQUEST[busca]=='a') echo "Selected" ?>>A</option>
          <option value="b" <? if($_REQUEST[busca]=='b') echo "Selected" ?>>B</option>
          <option value="c" <? if($_REQUEST[busca]=='c') echo "Selected" ?>>C</option>
          <option value="d" <? if($_REQUEST[busca]=='d') echo "Selected" ?>>D</option>
          <option value="e" <? if($_REQUEST[busca]=='e') echo "Selected" ?>>E</option>
          <option value="f" <? if($_REQUEST[busca]=='f') echo "Selected" ?>>F</option>
          <option value="g" <? if($_REQUEST[busca]=='g') echo "Selected" ?>>G</option>
          <option value="h" <? if($_REQUEST[busca]=='h') echo "Selected" ?>>H</option>
          <option value="i" <? if($_REQUEST[busca]=='i') echo "Selected" ?>>I</option>
          <option value="j" <? if($_REQUEST[busca]=='j') echo "Selected" ?>>J</option>
          <option value="k" <? if($_REQUEST[busca]=='k') echo "Selected" ?>>K</option>
          <option value="l" <? if($_REQUEST[busca]=='l') echo "Selected" ?>>L</option>
		  <option value="m" <? if($_REQUEST[busca]=='m') echo "Selected" ?>>M</option>
          <option value="n" <? if($_REQUEST[busca]=='n') echo "Selected" ?>>N</option>
          <option value="o" <? if($_REQUEST[busca]=='o') echo "Selected" ?>>O</option>
          <option value="p" <? if($_REQUEST[busca]=='p') echo "Selected" ?>>P</option>
          <option value="q" <? if($_REQUEST[busca]=='q') echo "Selected" ?>>Q</option>
          <option value="r" <? if($_REQUEST[busca]=='r') echo "Selected" ?>>R</option>
          <option value="S" <? if($_REQUEST[busca]=='s') echo "Selected" ?>>S</option>
          <option value="t" <? if($_REQUEST[busca]=='t') echo "Selected" ?>>T</option>
          <option value="u" <? if($_REQUEST[busca]=='u') echo "Selected" ?>>U</option>
          <option value="v" <? if($_REQUEST[busca]=='v') echo "Selected" ?>>V</option>
          <option value="w" <? if($_REQUEST[busca]=='w') echo "Selected" ?>>W</option>
          <option value="x" <? if($_REQUEST[busca]=='x') echo "Selected" ?>>X</option>
		  <option value="y" <? if($_REQUEST[busca]=='y') echo "Selected" ?>>Y</option>
          <option value="z" <? if($_REQUEST[busca]=='z') echo "Selected" ?>>Z</option>
        </select>
        &nbsp;
        <input name="sub_nome" type="submit" class="combo_cadastro" id="sub_nome" value=" Ok ">
      </p>
    </form></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  if($_REQUEST['busca']=='' || $_REQUEST[busca]=='#')
	  {
	  $sql="SELECT count(*) as total from usuario";
	  $sql2="SELECT *from usuario  order by nome asc LIMIT $registroinicial,$pagesize";
	  }
	  else{
	  $sql="SELECT count(*) as total from usuario where nome like '$_REQUEST[busca]%'";
	  $sql2="SELECT *from usuario where nome like '$_REQUEST[busca]%' order by nome asc LIMIT $registroinicial,$pagesize";
	  }
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="46%" height="24" rowspan="2" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Nome
              do Usu&aacute;rio</div>            <div align="left"></div></td>
          <td width="25%" rowspan="2" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;
            </div></td>
          <td width="29%" bgcolor="#ddddd5" class="texto_bold"><div align="center"><span class="style1"><? echo "<img  width='8' height='8'  src='imgs/icons/ic_star.gif'></img>" ?> -
            administrador</span></div></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td bgcolor="#ddddd5" class="texto_bold">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto" id="cor_fundo<? echo $row['usuario'] ?>">
     <?  if  ($row[status]=='S') { ?> <td align="justify"><? echo $row[1] ?> <? if($row[nivel]=='A') echo "<img  width='8' height='8' alt='Administrador' src='imgs/icons/ic_star.gif'></img>" ?>           
                                       <div align="left">
                                       </div></td><?}?>
     <?  if ( $row[status]=='N') {?>  <td align="justify"><font style="color:#9B9B9B"><? echo $row[1] ?> <? if($row[nivel]=='A') echo "<img  width='8' height='8' alt='Administrador' src='imgs/icons/ic_star.gif'></img>" ?>           
                                       <div align="left">
                                       </div></font></td><?}?>
          <td width="9%" align="center"><? echo "<a href=\"usuario1.php?op=del&usuario=".($row['usuario'])."\"
	onClick='return confirm(".'"Confirma Exclus&atilde;o do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif' width='20' height='20'
	border='0' alt='Excluir' 
	onMouseOver='document.getElementById(\"cor_fundo".$row[usuario]."\").style.backgroundColor=\"#ddddd5\";' 
	onMouseOut='document.getElementById(\"cor_fundo".$row[usuario]."\").style.backgroundColor=\"\";'>";?></td>
          <td align="center" width='10%'>
            <div align="center"><? echo "<a href=\"usuario1.php?op=update&usuario=".($row['usuario'])."\">
	 <img src='imgs/icons/ic_alterar.gif' width='20' height='20' border='0' alt='Alteração de Cadastro' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[usuario]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[usuario]."\").style.backgroundColor=\"\";'>"; ?></div></td>
          <td align="center" width='10%'>
            <div align="center"><? echo "<a href=\"usuario_manutencao.php?op=update&nivel=".$row[nivel]."&usuario=".($row['usuario'])."\">
	 <img src='imgs/icons/ic_tools.gif' border='0' alt='Manutenção de Permissões' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[usuario]."\").style.backgroundColor=\"#ddddd5\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[usuario]."\").style.backgroundColor=\"\";'>"; } ?></div></td>
        </tr>
        <tr class="texto">
          <td></td>
          <td width="9%"></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="2">&nbsp;</td>
          <td></td>
          <td align="center"><? echo "<a href=\"usuario1.php?op=insert\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Novo Registro' >"?></td>
        </tr>
        <tr>
          <td height="1" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="4" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"usuario.php?page=".$first."&busca=".$_REQUEST[busca]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"usuario.php?page=".$menos."&busca=".$_REQUEST[busca]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"usuario.php?page=".$mais."&busca=".$_REQUEST[busca]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"usuario.php?page=".$last."&busca=".$_REQUEST[busca]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
$combo="";

 for($i=1;$i<=$numpages;$i++)
 {
  if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 }
  $lista_combo="<select name=i value=$i onChange='obtem_valor(this)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }
//echo"$lista_combo";
$g= " Total de usuários cadastrados: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <p>
          <input name="usuario" type="hidden" id="usuario" value="<? echo $usuario ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">

		  <br>
        </p>
      <p></p>
    </form>
    <p></p></td>
  </tr>
</table>
<script language="JavaScript">

document.onkeyup=handleKeyboardAction;

function handleKeyboardAction(e){

   var code;

  // Obtém o evento. No caso do Firefox, este
  // evento é passado como argumento, e no caso do IE,
  // deve ser obtido através do objeto window.
   if (!e) var e = window.event; 

   // Detecta o target da tecla
   var targ;
   if (e.target) targ = e.target;
   else if (e.srcElement) targ = e.srcElement;

   // Este código previne um erro do navegador Safari:
  // Se o usuari clica num DIV com texto, os outros browsers
  // retornam o DIV como sendo o target. Safari retorna  o nó contendo
  // o texto (nodeType 3). Nesse caso, o target que nos interessa é o pai.
   if (targ.nodeType == 3) // defeat Safari bug
      targ = targ.parentNode;

  // Obtém o nome da TAG HTML do target do evento
   tag = targ.tagName.toUpperCase();

  // Verifica se o evento não esta sendo acionado em nenhum
  // campo como campo de texto e combobox.
  // Esta verificação é importante, pois o handler pode bloquear
  // o funcionamento adqueado desses campos (por exemplo, em vez de escrever
  // a letra no campo, executa uma função).
   if (tag == "INPUT")
      return;

   if (tag == "SELECT")
		return;

   // Detecta o codigo da tecla
   if (e.keyCode) code = e.keyCode;
   else if (e.which) code = e.which;

   var character = String.fromCharCode(code);

       //Home
	if(code == 36) {
          posiciona('<? echo $first; ?>');
          return;
	} 

       //End
	if(code == 35) {
          posiciona('<? echo $last; ?>');
          return;
	} 


       //PgDw
	if(code == 34) {
          posiciona('<? echo $mais; ?>');
          return;
	} 

	//PgUp
	if(code == 33) {
          posiciona('<? echo $menos; ?>');
          return;
	} 

   return;
}

</script>
</body>
</html>
