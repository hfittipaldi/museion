<? include_once("seguranca.php") ?>
<html>
<head>
<title>Pesquisa de Imagem</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style>
@media print {
	.noprint {
		display: none;
	}
}
</style>
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('foto_ocorrencia_pesq.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}}

function posiciona(valor) {
var i = valor;
document.location=('foto_ocorrencia_pesq.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}

function abrepop(janela,alt,larg)
{
 var h=screen.height-100,w=screen.width-50;
 
  win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
 if(parseInt(navigator.appVersion)>=4)
{
   win.window.focus();
 }
 return true;
}
</script>

</head>

<body>
<table width="100%"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2 >
  <tr>
	<td class="tit_interno">
<?
if ($_REQUEST[pagesize] < 999) {
echo $_SESSION['lnk'];
}
?>
	</td>
  </tr>
  <tr>
    <td width="100%" valign="top"><form name="form1" method="post">
      <span class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db2=new conexao();
$db2->conecta();

$dir= diretorio_fisico();
$dir_virtual= diretorio_virtual();
?>
      </span>
      <?
	  /////Paginando
	  $pagesize=1;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT count(*) as total from fotografia where (titulo like '%$_REQUEST[titulo]%' or '$_REQUEST[titulo]'='') AND 
			(vinculo='$_REQUEST[vinculo]' or '$_REQUEST[vinculo]'='T') AND (funcao='$_REQUEST[funcao]' or '$_REQUEST[funcao]'='0') AND 
			(tipo='$_REQUEST[cor]' or '$_REQUEST[cor]'='0')";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT * from fotografia where (titulo like '%$_REQUEST[titulo]%' or '$_REQUEST[titulo]'='') AND 
			(vinculo='$_REQUEST[vinculo]' or '$_REQUEST[vinculo]'='T') AND (funcao='$_REQUEST[funcao]' or '$_REQUEST[funcao]'='0') AND 
			(tipo='$_REQUEST[cor]' or '$_REQUEST[cor]'='0') order by titulo asc LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);

	  $txtoco= '';
	  if ($_REQUEST[vinculo] == 'A')
		$txtoco= 'Vínculo: Autor<br>';
	  elseif ($_REQUEST[vinculo] == 'O')
		$txtoco= 'Vínculo: Obra<br>';
	  elseif ($_REQUEST[vinculo] == 'T')
		$txtoco= 'Vínculo: Todos<br>';
	  elseif ($_REQUEST[vinculo] == 'S')
		$txtoco= 'Sem vínculo<br>';
	  elseif ($_REQUEST[vinculo] == 'I')
		$txtoco= 'Vínculo: Instituição<br>';
	  elseif ($_REQUEST[vinculo] == 'P')
		$txtoco= 'Vínculo: Restauro de Papel<br>';
	  elseif ($_REQUEST[vinculo] == 'R')
		$txtoco= 'Vínculo: Restauro de Pintura<br>';
		//
	  if ($_REQUEST[titulo] <> '')
		$txtoco.= 'Título: '.$_REQUEST[titulo].'<br>';
		//
	  if ($_REQUEST[funcao] == 'M')
		$txtoco.= 'Função: Master<br>';
	  elseif ($_REQUEST[funcao] == 'R')
		$txtoco.= 'Função: Referência<br>';
	  elseif ($_REQUEST[funcao] == 'T')
		$txtoco.= 'Função: Thumbnail<br>';
		//
	  if ($_REQUEST[cor] == 'PB')
		$txtoco.= 'Tipo: P &amp; B<br>';
	  elseif ($_REQUEST[cor] == 'COR')
		$txtoco.= 'Tipo: Colorido<br>';
	  ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ddddd5">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100%" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td height="24" bgcolor="#ddddd5" class="texto">
             <div align="left"><em>Ocorr&ecirc;ncias encontradas para:</em><br><b><?  echo " ".$txtoco; ?> </b></div> 
             <div align="left"></div>            
             <div align="center"></div>           
             <div align="center"></div>
          </td>
          <td  height="24" bgcolor="#ddddd5" class="texto_bold"><? if ($_REQUEST[pagesize] < 999) echo "<a href='foto_pesquisa.php'><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'></a>"?></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
        <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="4" >
          <tr class="texto"> 
            <td colspan="0">&nbsp;</td>
            

            <td align="center">&nbsp;</td>
          </tr>
          <? while($row=$db->dados()) {
				$noimage= '';
				if ($row['nome_arquivo'] <> '') {
					$imagem= $row['nome_arquivo'];
					$diretorio_imagem=$row['diretorio_imagem'];
					 $sql="SELECT url,caminho from diretorio_imagem where diretorio_imagem = '$diretorio_imagem'";
					 $db2->query($sql);
					 $url=$db2->dados();
                                         $localurl=$url[0];
                                         $local=$url[1];
					 //if (file_exists($dir.$url[0].'\\'.$imagem)) {
					if (file_get_contents($dir.$url[0].'/'.$imagem)) {
						list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url[0].'/'.$imagem);
						$Ao= $height;
						$Lo= $width;

						//124 é a altura max da área de exibição da imagem; 220 é a largura máxima.//
						$cA= $Ao / 124;
						$cL= $Lo / 220;

						if ($Ao > 124 || $Lo > 220) {
							if (cL < cA) {
								$percent= (220 * 100) / $Lo;
								$Lo= 220;
								$Ao= ($Ao * $percent) / 100;
								if ($Ao > 124) {
									$percent= (124 * 100) / $Ao;
									$Ao= 124;
									$Lo= ($Lo * $percent) / 100;
								}

							} else {
								$percent= (124 * 100) / $Ao;
								$Ao= 124;
								$Lo= ($Lo * $percent) / 100;
								if ($Lo > 220) {
									$percent= (220 * 100) / $Lo;
									$Lo= 220;
									$Ao= ($Ao * $percent) / 100;
								}
							}
						}
					} else
						$noimage= "<br>Arquivo não encontrado no servidor";
				}
				else {
					$noimage= "<br>Imagem não disponível";
				}
	  ?>
          <tr class="texto" id="cor_fundo<? echo $row['fotografia'] ?>"> 
            <td width="25%" colspan="0" rowspan="3" align="center" valign="middle">
                 <a href="javascript:;" onClick="abrepop('pop_imagem.php?imagem=<? echo $url[0].'/'.$imagem; ?>');"><img src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0'></a><? echo $noimage; ?>
            </td>
            <td colspan="0" width="57%" valign="top"><b>Título: </b><? echo $row[titulo] ?><br>&nbsp;</td>
            <td width='6%' rowspan="3" align="center"></td>
            <td width='6%' rowspan="3" align="center"> <div align="center"><? if ($_REQUEST[pagesize] < 999) echo "<a href=\"fotografia_pesq.php?op=update&id=".$row[fotografia]."\">
	 <img src='imgs/icons/relat.gif' width='20' height='20'border='0' alt='Informações' 
	 onMouseOver='document.getElementById(\"cor_fundo".$row[fotografia]."\").style.backgroundColor=\"\"; 
				document.getElementById(\"cor_fundo2".$row[fotografia]."\").style.backgroundColor=\"\";
				document.getElementById(\"cor_fundo3".$row[fotografia]."\").style.backgroundColor=\"\";' 
	 onMouseOut='document.getElementById(\"cor_fundo".$row[fotografia]."\").style.backgroundColor=\"\";
				document.getElementById(\"cor_fundo2".$row[fotografia]."\").style.backgroundColor=\"\";
				document.getElementById(\"cor_fundo3".$row[fotografia]."\").style.backgroundColor=\"\";'>";?></div></td>
			</td>
          </tr>
		<?
			$vinculo= "<em>sem vínculo</em>";
			if ($row[vinculo] == 'A') {
				 $sql="SELECT nomeetiqueta from autor as a inner join fotografia_autor as b on (a.autor=b.autor) 
						where b.fotografia = $row[fotografia]";
				 $db2->query($sql);
				 $vinculo= $db2->dados();
				 $vinculo= "Autor "."<br>".$vinculo['nomeetiqueta'];
			}
			elseif ($row[vinculo] == 'O') {
			      //echo $row[vinculo];
				 $sql="SELECT a.obra,a.titulo_etiq,a.dt_aquisicao_ano1,a.dt_aquisicao_ano2,a.dt_aquisicao_tp,a.num_registro,a.colecao 
						from obra as a inner join fotografia_obra as b on (a.obra=b.obra) where b.fotografia = $row[fotografia]";
			      //echo $sql;
				 $db2->query($sql);
				 $vinculo= $db2->dados();

				$dat= "";


				 //
				 $sql="SELECT nomeetiqueta from autor as a inner join autor_obra as b on (a.autor=b.autor) 
						where b.obra = $vinculo[obra]";
				 $db2->query($sql);
				 $nome_aut= $db2->dados();
				 //
				 $sql="SELECT nome from colecao where colecao = $vinculo[colecao]";
				 $db2->query($sql);
				 $nome_col= $db2->dados();
				 //
				 $vinculo= "Obra "."<br>".$nome_aut['nomeetiqueta'] . "<br>" . $vinculo['titulo_etiq'] . $dat . "<br>Nº de registro: " . $vinculo['num_registro'] . "<br>" . $nome_col['nome'];
			}
			elseif ($row[vinculo]=='P' || $row[vinculo]=='R') {
				 $sql="SELECT a.ir,a.autor,a.titulo,a.tombo,a.nome_objeto from restauro as a inner join restauro_fotografia as b on (a.restauro=b.restauro) 
						where b.fotografia = $row[fotografia]";
				 $db2->query($sql);
				 $vinculo= $db2->dados();
				 $objeto= "";
				 if ($vinculo['nome_objeto'] <> '')
					$objeto= " / " . $vinculo['nome_objeto'];
				 if ($row[vinculo]=="P")
					$vinculo= "Restauração de Papel "."<br>".$vinculo['autor'] . "<br>" . $vinculo['titulo'] . $objeto . "<br>Nº de registro: " . $vinculo['tombo'] . "<br>IR: " . $vinculo['ir'];
				 if ($row[vinculo]=="R")
					$vinculo= "Restauração de Pintura "."<br>".$vinculo['autor'] . "<br>" . $vinculo['titulo'] . $objeto . "<br>Nº de registro: " . $vinculo['tombo'] . "<br>IR: " . $vinculo['ir'];

			}
			elseif ($row[vinculo] == 'I') {
				 $vinculo= "Instituição";
			}
		?>
          <tr class="texto" id="cor_fundo2<? echo $row['fotografia'] ?>">
            <td colspan="1" width="52%" valign="bottom"><b>Vínculo: </b><? echo $vinculo ?><br>&nbsp;</td>
          </tr>
		<?
			$cor= "";
			if ($row[tipo] == 'COR') {
				$cor= "Cor";
			}
			elseif ($row[tipo] == 'PB') {
				$cor= "P/B";
			}

			$funcao= "";
			if ($row[funcao] == 'M') {
				$funcao= "Master";
			}
			elseif ($row[funcao] == 'R') {
				$funcao= "Referência";
			}
			elseif ($row[funcao] == 'T') {
				$funcao= "Thumbnail";
			}
		?>
          <tr class="texto" id="cor_fundo3<? echo $row['fotografia'] ?>">
            <td colspan="1" width="52%" valign="bottom"><b>Função: </b><? echo $funcao ?><br><b>Tipo: </b><? echo $cor ?><br><b>Local: </b><?if ($diretorio_imagem <> "0") { echo $dir; }?></td>
          </tr>
        <tr class="texto" id="cor_fundo3<? echo $row['fotografia'] ?>">
           <td colspan="1" width="50%" align="hight" heigth="20">&nbsp;</td>
           <td colspan="1" width="50%" align="hight" heigth="20"><font size="2"><? if ($diretorio_imagem <> "0") {echo $localurl."\\".$imagem;}else{}?><font></td>
           </tr>

		<? if ($_REQUEST[pagesize] >= 999) { ?>
          <tr class="texto">
            <td colspan="4" valign="bottom" style="border-top:1px solid #96ADBE;"><br>&nbsp;</td>
          </tr>
		<? } ?>
          <? } ?>
          <tr class="texto"> 
            <td colspan="2">&nbsp;</td>
            <td></td>
            <td align="center" class="noprint"><? if ($_REQUEST[pagesize] < 999) echo "<a target='_blank' href=\"foto_ocorrencia_pesq.php?pagesize=999999&page=1&titulo=".$_REQUEST[titulo]."&vinculo=".$_REQUEST[vinculo]."&funcao=".$_REQUEST[funcao]."&cor=".$_REQUEST[cor]."\"><img src='imgs/icons/ic_salvar_impressao.gif'  border='0'  alt='Versão para impressão'></a>" ?></td>
          </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
          <tr class="texto"> 
            <td colspan="5" height="20"  bgcolor="#ddddd5">
              <? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"foto_ocorrencia_pesq.php?page=".$first."&titulo=".$_REQUEST[titulo]."&vinculo=".$_REQUEST[vinculo]."&funcao=".$_REQUEST[funcao]."&cor=".$_REQUEST[cor]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"foto_ocorrencia_pesq?page=".$menos."&titulo=".$_REQUEST[titulo]."&vinculo=".$_REQUEST[vinculo]."&funcao=".$_REQUEST[funcao]."&cor=".$_REQUEST[cor]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"foto_ocorrencia_pesq?page=".$mais."&titulo=".$_REQUEST[titulo]."&vinculo=".$_REQUEST[vinculo]."&funcao=".$_REQUEST[funcao]."&cor=".$_REQUEST[cor]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"foto_ocorrencia_pesq?page=".$last."&titulo=".$_REQUEST[titulo]."&vinculo=".$_REQUEST[vinculo]."&funcao=".$_REQUEST[funcao]."&cor=".$_REQUEST[cor]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$txtpagina= "";
if ($_REQUEST[pagesize] < 999) {
	$txtpagina= "- P&aacute;gina: $page_atual de $numpages &nbsp $lista_combo &nbsp;";
}
$g= " Total de ocorr&ecirc;ncias: $numlinhas ".$txtpagina.$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>
            </td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="110" height="1"></td>
        </tr>
        </table>
    </form>
    </td>
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