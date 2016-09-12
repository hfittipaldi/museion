<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
<?
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();
	$expid= $_REQUEST['id'];

	if ($_REQUEST['op'] == 'add') {
		$sql= "SELECT count(*) from ".$tipo."_bibliografia where $tipo = '$valor' AND bibliografia = '$expid'";
		$db->query($sql);
		$tot= $db->dados();
		$tot= $tot[0];
		if ($tot == 0) {
			$sql= "INSERT into ".$tipo."_bibliografia($tipo ,bibliografia) values('$valor','$expid')";
			$db->query($sql);
			//ATUALIZA ALTERAÇÃO DA OBRA
			if ($tipo == 'obra') {
				$sql="UPDATE obra set atualizado='$_SESSION[susuario]', data_catalog2=now() where obra = '$valor'";
				$db->query($sql);
				// atualização na ficha
				$sql="select nome from usuario where usuario='$_SESSION[susuario]'";
				$db->query($sql);
				$nome=$db->dados();
				$sql="select data_catalog2 from obra where obra = '$valor'";
				$db->query($sql);
				$data=$db->dados();
				$data=convertedata($data[data_catalog2],'d/m/Y - h:i');
				echo "<script>parent.document.getElementById('atualizado').value='".$nome[0]."';</script>";
				echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
			//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','0','$valor',now())";
$db->query($sql);
//////////////////////////////////////////////////////////////////
			}

			//ATUALIZA ALTERAÇÃO DO AUTOR
			if ($tipo == 'autor') {
				$sql="UPDATE autor set atualizado='$_SESSION[snome]', data_catalog2=now() where autor = '$valor'";
				$db->query($sql);
				// atualização na ficha
				$sql="select data_catalog2 from autor where autor = '$valor'";
				$db->query($sql);
				$data=$db->dados();
				$data=convertedata($data[data_catalog2],'d/m/y - h:i');
				echo "<script>parent.document.getElementById('atualizado').value='".$_SESSION[snome]."';</script>";
				echo "<script>parent.document.getElementById('data_catalog2').value='".$data."';</script>";
			//
//////////////////////////////Tabela Log_atualizacao/////////////////////////////
$sql="insert into log_atualizacao(operacao,usuario,autor,obra,data)values('A','$_SESSION[susuario]','$valor','0',now())";
$db->query($sql);
//////////////////////////////////////////////////////////////////
			}
		}
		if ($tipo == 'obra')
			echo "<script>location.href='bibliografia_obra1.php?op=update&obrid=".$valor."&id=".$expid."';</script>";
		else
			echo "<script>location.href='bibliografia_obra.php?".$parametro."=".$valor."';</script>";
	}
 ?>

<script>
function obtem_valor(qual) {
//if (qual.selectedIndex.selected != '') {
//var i = qual.value;
document.location=('bibliografia_obra2.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ qual+ '&nome=<? echo $_REQUEST[nome] ?>');
}
//}}
</script>

<body>
<? if (trim($_REQUEST['nome']) <> '') { ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=8;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	 $sql= "SELECT count(*) from bibliografia where nome like '%$_REQUEST[nome]%'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
     $numlinhas=$numlinhas[0];
	 
	  ////////////////////
	  $sql2= "SELECT bibliografia,nome,periodo,instituicao,cidade from bibliografia where nome like '%$_REQUEST[nome]%' order by nome LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td height="24" bgcolor="#96ADBE" class="texto_bold" style="color: white;"><div align="left"> &nbsp;Pesquisa de Bibliografia a Vincular</div></td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados())
	  {
	  ?>
        <tr class="texto">
          <td width="90%"></td>
          <td width="10%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['bibliografia']; ?>">
          <td><? echo "<b>"."- ". $row['nome'].", "."</b>".$row['instituicao'].", ".$row['cidade'].", ".$row['periodo']."."."<br>"."<b>";
          echo  "<font color='darkred'>".$row['premio']; ?></td>
          <td align="center"><? echo "<a href=\"bibliografia_insere2.php?op=add&".$parametro."=".$valor."&id=".$row['bibliografia']."\">
						<img src='imgs/icons/ic_adicionar.gif' border='0' alt='Adicionar à lista' 
					 onMouseOver='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"#ddddd5\";' 
					 onMouseOut='document.getElementById(\"cor_fundo".$row[bibliografia]."\").style.backgroundColor=\"\";'>";?></td>
        </tr>
		<? } ?>
        <tr>
          <td height="1" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
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

//$a="<a href=\"bibliografia_insere2.php?".$parametro."=".$valor."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";
//
//$b="<a href=\"bibliografia_insere2.php?".$parametro."=".$valor."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";
//
//$c="<a href=\"bibliografia_insere2.php?".$parametro."=".$valor."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";
//
//$d="<a href=\"bibliografia_insere2.php?".$parametro."=".$valor."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
//
$a="<a href='#' onClick='obtem_valor($first)'><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href='#' onClick='obtem_valor($menos)'><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href='#' onClick='obtem_valor($mais)'><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href='#' onClick='obtem_valor($last)'><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";

$combo="";

 for($i=1;$i<=$numpages;$i++)
 {
 if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 } 
  $lista_combo="<select name=i value=$i onChange='obtem_valor(this.value)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }
$g= " Total de bibliografias encontradas: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='003366'>$g</font>";   
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
    </form>
	<tr>
       	<td colspan="2" class="texto_bold"><? echo "<a href=\"bibliografia_insere1.php?".$parametro."=".$valor."\"><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar' >"?></td>
	</tr>
  </tr>
</table>
<? } else{ ?>
	<script>alert('Preencha o parâmetro "nome da bibliografia"!'); location.href="bibliografia_insere1.php?<? echo $parametro; ?>=<? echo $valor; ?>";</script>
<? } ?>


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
          obtem_valor('<? echo $first; ?>');
          return;
	} 

       //End
	if(code == 35) {
          obtem_valor('<? echo $last; ?>');
          return;
	} 

       //PgDw
	if(code == 34) {
          obtem_valor('<? echo $mais; ?>');
          return;
	} 

	//PgUp
	if(code == 33) {
          obtem_valor('<? echo $menos; ?>');
          return;
	} 

   return;
}

</script>



</body>
</html>