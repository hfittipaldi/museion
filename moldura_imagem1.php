<? include_once("seguranca.php") ?>
<html>
<head>

<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>

<body  onload='document.form1.descricao.focus()'>      
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <td width="519" valign="top"><form method="post" enctype="multipart/form-data" name="form1" onSubmit="return valida()" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$id=$_REQUEST['id']; // id do autor corrente
$op=$_REQUEST['op'];
 if(isset($_REQUEST[id]))
 {
  if($op=='update')
   {
    $sql="SELECT a.* from restauro_fotografia as a where a.restauro=$_REQUEST[id] and a.restauro_fotografia=$_REQUEST[rest]";
	$db->query($sql);
    $res=$db->dados();
	$fotografia_id = $res['fotografia'];
	}
  elseif($op=='del')
   {
    $sql="SELECT a.* from restauro_fotografia as a where a.restauro=$_REQUEST[id] and a.restauro_fotografia=$_REQUEST[rest]";
	$db->query($sql);
    $res=$db->dados();
	$fotografia_id = $res['fotografia'];
	//
    $sql="DELETE from restauro_fotografia where restauro=$_REQUEST[id] and restauro_fotografia=$_REQUEST[rest]";
	$db->query($sql);
    $res=$db->dados();
    $sql="DELETE from fotografia where fotografia = '$fotografia_id'";
	$db->query($sql);
    $res=$db->dados();
	echo"<script>alert('Exclusão realizada com sucesso.')</script>";
	echo"<script>location.href='restauro_imagem.php?id=$_REQUEST[id]'</script>";
	}
 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr class="texto_bold">
          <td width="13%"><div align="right">Descri&ccedil;&atilde;o:</div></td>
          <td width="71%"><input name="descricao" type="text" class="combo_cadastro" id="descricao" value="<? echo htmlentities($res['descricao'], ENT_QUOTES); ?>" size="65" maxlength="255"></td>
          <td width="16%">&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Tipo:</div></td>
          <td>
			<select class="combo_cadastro" name="tipo" id="tipo">
				<option value="">  </option>
				<option value="1">Antes</option>
				<option value="2">Intermediária</option>
				<option value="3">Depois</option>
			</select>
			<script>document.getElementById("tipo").value= '<? echo $res[tipo] ?>';</script>
		  </td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Ordem:</div></td>
          <td><input name="ordem" type="text" class="combo_cadastro"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" id="ordem" value="<? echo $res[ordem] ?>" size="2">
            <input name="ordem_no_banco" type="hidden" id="ordem_no_banco" value="<? echo $res[ordem] ?>"></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="texto_bold">
          <td><div align="right">Arquivo:</div></td>
          <td><input type="hidden" name="MAX_FILE_SIZE" value="16000000">
		  	<input class="combo_cadastro" type="file" name="arquivo" size="45">
			<?
				if ($fotografia_id <> 0) {
				     $sql="SELECT a.nome_arquivo from fotografia as a INNER JOIN restauro_fotografia as b on (a.fotografia = b.fotografia) 
						where a.fotografia = $fotografia_id";
				 	 $db->query($sql);
					 $nome_arq_foto= $db->dados();
					 $nome_arq_foto= $nome_arq_foto['nome_arquivo'];
					 if ($nome_arq_foto <> '')
						echo "<br><font style='font-weight:normal;'>" . $nome_arq_foto . "</font>";
				}
			?>
 	    </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><div align="right"><span class="texto_bold">
              <input name="enviar" type="submit" class="botao" id="enviar" value="Gravar">
          </span></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">
            <div align="left"><? echo "<a href=\"restauro_imagem.php?id=$_REQUEST[id]\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br>
      <?
//$dir= diretorio_fisico() . "restauro\\";
$dir= diretorio_fisico();

function monta_titulo() {
 global $db;
 $sql="SELECT obra,parte,seq_restauro from restauro where restauro='$_REQUEST[id]'";
 $db->query($sql);
 $tit=$db->dados();
 $seq=$tit['seq_restauro'];
 $parte=$tit['parte'];

 $sql="SELECT num_registro from obra where obra='$tit[obra]'";
 $db->query($sql);
 $tit=$db->dados();
 $obra=strtoupper($tit['num_registro']);

 $sql="SELECT nome_objeto from parte where parte='$parte'";
 $db->query($sql);
 $tit=$db->dados();
 $parte=strtoupper($tit['nome_objeto']);

 $titulo= "OBRA " . $obra . " - " . $parte . " Restauração " . $seq;
 return $titulo;
}
function obtem_tipo() {
 global $db;
 // 1=papel | 2=pintura \\
 $sql="SELECT tipo from restauro where restauro='$_REQUEST[id]'";
 $db->query($sql);
 $tipo=$db->dados();
 return $tipo['tipo'];
}
function obtem_dir_imagem() {
 global $db;
 $sql="SELECT tipo from restauro where restauro='$_REQUEST[id]'";
 $db->query($sql);
 $tipo=$db->dados();
 if ($tipo['tipo'] == 2)
	$dir_img= 5;	//pintura
 else
	$dir_img= 4;	//papel
 return $dir_img;
}
function remove_foto()
{
 global $db;
 $sql="SELECT ext from restauro_fotografia where restauro_fotografia=$_REQUEST[rest] and restauro='$_REQUEST[id]'";
 $db->query($sql);
 $res=$db->dados();
 $ext=$res[0];
 $arq=$_REQUEST[rest].'.'.$ext;
 $tipo= obtem_tipo();
 if ($tipo == 2)
	 $arq_rem= diretorio_fisico() . "pintura\\$arq";
 else
	 $arq_rem= diretorio_fisico() . "papel\\$arq";
 unlink($arq_rem);
}
function foto_ordem(){ // verifica se ja existe uma foto com a ordem desejada.
global $db;
 $sql="SELECT ordem from restauro_fotografia where ordem='$_REQUEST[ordem]' and tipo='$_REQUEST[tipo]' and restauro='$_REQUEST[id]'";
 $db->query($sql);
 $res=$db->dados();
 if($res==''){
  return $_REQUEST['ordem']; }
 else{
  $valor=$res[1];
  echo "<script>alert('Já existe uma imagem cadastrada com a ordem:$tipo$_REQUEST[ordem]\\n\\Selecione outra!')</script>"; 
  exit;
  }
}
function compara($a,$b){ // verifica o valor da ordem passado no form com o existente do banco
 global $db;
/*if($a==$b){
   return 1;
}
else{*/
 $sql="SELECT ordem from restauro_fotografia where ordem='$_REQUEST[ordem]' and tipo='$_REQUEST[tipo]' and restauro='$_REQUEST[id]' and restauro_fotografia<>'$_REQUEST[rest]'";
 $db->query($sql);
 $res=$db->dados();
 if($res=='')
 {
    return 1;}
 else{
  echo "<script>alert('Já existe uma imagem cadastrada com a ordem:$_REQUEST[ordem]\\n\\Selecione outra!')</script>"; 
  exit;}
}
//}
function verifica_arquivo($arq_atual)
{
if ($arq_atual<>'' && $_FILES[arquivo][size]==0) {
	return 'arquivo ja carregado';
	exit();
}

 if(!$_FILES['arquivo']['size']>0)
 {
  echo "<script>alert('Tamanho de Arquivo inválido')</script>";
  exit;
 }
else{
    $arq_upload=explode('.',$_FILES['arquivo']['name']);
    $nome_arq_upload=strtolower($arq_upload[1]);
       if($nome_arq_upload=='gif' || $nome_arq_upload=='jpg' || $nome_arq_upload=='jpeg') { 
   		   $ext=$nome_arq_upload;
		   return $ext;
		   exit;}
		   
       else{
    echo"<script>alert('Formato inválido de imagem!\\n\\Use apenas gif, jpg ou jpeg.') </script>";
	exit();} 
 }
}
//
if($_REQUEST['enviar']<>'')
{
  if($_REQUEST[op]=='update')
   {
    compara($_REQUEST['ordem'],$_REQUEST['ordem_no_banco']);
    $ext=verifica_arquivo($nome_arq_foto);
    $nome_arquivo=$_FILES['arquivo']['name'];
	$tamanho_arquivo=$_FILES['arquivo']['size'];
	$tamanho_arquivo= ($tamanho_arquivo/1024);
	if ($ext <> 'arquivo ja carregado') {
	    remove_foto();
	}
     $sql="UPDATE restauro_fotografia set descricao='$_REQUEST[descricao]',ordem='$_REQUEST[ordem]',tipo='$_REQUEST[tipo]' where restauro='$_REQUEST[id]' and
	 restauro_fotografia='$_REQUEST[rest]'";
	 $db->query($sql);
	 ////
	if ($ext <> 'arquivo ja carregado') {
		 $dir_img= obtem_dir_imagem();
		 if ($dir_img == 4)
			$vinculo= "P";
		 else
			$vinculo= "R";
	}
	//
	if ($ext == 'arquivo ja carregado') {
     $sql="UPDATE fotografia set descricao='$_REQUEST[descricao]' where fotografia='$fotografia_id'";
	} else {
     $sql="UPDATE fotografia set formato='$ext',diretorio_imagem='$dir_img',nome_arquivo='$nome_arquivo',nome_arq_upload='$nome_arquivo', 
			tamanho_arquivo='$tamanho_arquivo',descricao='$_REQUEST[descricao]',vinculo='$vinculo' where fotografia='$fotografia_id'";
	}
	 $db->query($sql);
	 /////////Upload da Imagem///////
	if ($ext <> 'arquivo ja carregado') {
		 $tipo= obtem_tipo();
		 if ($tipo == 2)
			 $dir= diretorio_fisico() . "pintura\\";
		 else
			 $dir= diretorio_fisico() . "papel\\";
		set_time_limit(0);
	       move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $nome_arquivo);
		   $sql2="UPDATE restauro_fotografia set ext='$ext' where restauro_fotografia='$_REQUEST[rest]'";
		   $db->query($sql2);
	}
	//////////////////////////////////////////////////////////
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 echo"<script>location.href='restauro_imagem.php?id=$_REQUEST[id]'</script>";
	 exit();
	}
  elseif($_REQUEST[op]=='insert')
  {
    foto_ordem();
	$ext=verifica_arquivo('');

	$sql= "INSERT INTO restauro_fotografia(restauro,ordem,descricao,tipo) values('$_REQUEST[id]','$_REQUEST[ordem]','$_REQUEST[descricao]','$_REQUEST[tipo]')";
    $db->query($sql);
     $idfotorestauro= $db->lastid();

        //$nome_arquivo=$_FILES['arquivo']['name'];
        $nome=explode('.',$_FILES['arquivo']['name']);
        $nome_arquivo=$nome[0]."(".$idfotorestauro.")".".".$nome[1];
	$tamanho_arquivo=$_FILES['arquivo']['size'];
	$tamanho_arquivo= ($tamanho_arquivo/1024);
	////
	 $dir_img= obtem_dir_imagem();
	 if ($dir_img == 4)
		$vinculo= "P";
	 else
		$vinculo= "R";
	 $descri= monta_titulo();
     $sql="INSERT INTO fotografia(formato,titulo,diretorio_imagem,nome_arquivo,nome_arq_upload,tamanho_arquivo,descricao,vinculo,data_criacao) 
			values('$ext','$_REQUEST[descricao]','$dir_img','$nome_arquivo','$nome_arquivo','$tamanho_arquivo','$descri','$vinculo',now())";
	 $db->query($sql);
     $fotografia_id= $db->lastid();
		/////////Upload da Imagem///////
		 $tipo= obtem_tipo();
		 if ($tipo == 2)
			 $dir= diretorio_fisico() . "pintura\\";
		 else
			 $dir= diretorio_fisico() . "papel\\";
		set_time_limit(0);
	    //$nome_arquivo=$idfotorestauro.'_'.$_FILES['arquivo']['name'];
	    //$nome_arquivo=$_FILES['arquivo']['name'];

	    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $nome_arquivo);
	   
	   $sql2="UPDATE restauro_fotografia set ext='$ext', fotografia='$fotografia_id' where restauro_fotografia=$idfotorestauro";
	   $db->query($sql2);  
	
	echo"<script>alert('Inclusão realizada com sucesso.')</script>";
	echo"<script>location.href='restauro_imagem.php?id=$_REQUEST[id]'</script>";
 }
}
?>
    </form>
	</td>
  </tr>
</table>
</body>
<script>
function valida()
{
 with(document.form1)
 {
    if(descricao.value==''){
	  alert('É necessário preencher com a descrição!');
	  descricao.focus();
	  return false;}
    if(tipo.value==''){
	  alert('É necessário selecionar o tipo!');
	  tipo.focus();
	  return false;}
   if(ordem.value=='')
    {
	 alert('Informe o número para ordem de inclusão da foto!');
	 ordem.focus();
	 return false; }
    if(ordem.value==0 || ordem.value<0) {
	  alert('Informe um valor > 0 ');
	  ordem.focus();
	  return false; 
    }
	if(arquivo.value=='' && '<? echo $nome_arq_foto ?>' == ''){
	alert('Selecione uma imagem.');
	arquivo.focus();
	return false;}
  }
}

</script>  
</html>
