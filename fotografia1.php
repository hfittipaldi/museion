<?php include_once("seguranca.php") ?>
<style type="text/css">
<!--
#abas a {
	font-size: 12px;
	font-weight: bold;
	color: #34689A;
	text-decoration: none;
}
.divi1 {	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
	background-color: #f2f2f2;
}
.short_combo
{
	width:300px;
}
select {
  behavior: url("js/select_keydown.htc");
}
-->
</style>
<script language="javascript" src="js/ajax_autor.js" type="text/javascript"></script>
<script src="js/funcoes_extra.js"></script>
<script language="JavaScript">
function ajustaAbas(index) {
	numAbas= 5;

	if (index == 1)
		document.getElementById("aba1").style.borderLeftColor= "#34689A";
	else
		document.getElementById("aba1").style.borderLeftColor= "#34689A";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("link"+i).style.color= "#34689A";
	}
	document.getElementById("link"+index).style.color= "blue";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("aba"+i).style.borderBottomColor= "#34689A";
		document.getElementById("aba"+i).style.verticalAlign= "bottom";
		document.getElementById("aba"+i).style.backgroundColor= "";
	}
	document.getElementById("aba"+index).style.borderBottomColor= "#f2f2f2";
	document.getElementById("aba"+index).style.verticalAlign= "middle";
	document.getElementById("aba"+index).style.backgroundColor= "#f2f2f2";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("quadro"+i).style.display= "none";
	}
	document.getElementById("quadro"+index).style.display= "";

	if (index == 5)
		document.getElementById("rodape").style.display= 'none';
	else
		document.getElementById("rodape").style.display= '';
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
<?php $aba=1; ?>
<link href="css/home.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>

<?php 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
//$dir=diretorio_fisico()."acervo\\";
//$dir_virt=diretorio_virtual()."acervo/";
$raiz_imagem=raiz_imagem();
//$dir= diretorio_fisico();
$dir_virtual= diretorio_virtual();
$titulo_form=$_REQUEST[titulo_form];	
$arqimg=$_REQUEST[arqimg];
if ($_REQUEST['submit']<>'') {
	$dtavaliacao= explode("/", $_REQUEST['dtavaliacao']);
	$dia=$dtavaliacao[0]; $mes=$dtavaliacao[1]; $ano=$dtavaliacao[2];
	$dtavaliacao= $ano."-".$mes."-".$dia;
	if ($dtavaliacao == '--')
		$dtavaliacao= '0000-00-00';

	$vinculo= $_REQUEST['vinculo'];


	if ($vinculo == 'O') {  // letra "O" de Obra
		$sql= "SELECT obra from obra where num_registro = '$_REQUEST[txtvinculo]'";
		$db->query($sql);
		if ($db->contalinhas() == 0) {
			$vinculo= 'N';
			echo"<script> alert('Registro:$_REQUEST[txtvinculo], não encontrado!\\n\\nNenhum vínculo foi criado.')</script>";
		}
	}

	if ($_REQUEST['id']<>'') {
			$sql="UPDATE fotografia set 
			digital='$_REQUEST[digital]',
			diretorio_imagem='$_REQUEST[diretorio_imagem]',
			titulo = '$_REQUEST[titulo]',
			fotografo = '$_REQUEST[fotografo]',
			resolucao = '$_REQUEST[resolucao]',
			altura = '$_REQUEST[altura]',
			largura = '$_REQUEST[largura]',
			digitalizador = '$_REQUEST[digitalizador]',
			altura_original = '$_REQUEST[alt_original]',
			largura_original = '$_REQUEST[lar_original]',
			local_original = '$_REQUEST[local]',
			descricao = '$_REQUEST[descricao]',
			obs = '$_REQUEST[obs]',
			conservacao = '$_REQUEST[conservacao]',
			data_avaliacao = '$dtavaliacao',
			vinculo= '$vinculo',
			tipo= '$_REQUEST[tipo]',
			modo_cores= '$_REQUEST[modo_cor]',
			modo_captura= '$_REQUEST[modo_captura]',
			original= '$_REQUEST[original]',
			funcao= '$_REQUEST[funcao]',
			forma_exibicao= '$_REQUEST[exibicao]',
			restricoes= '$_REQUEST[restricao]'
			where fotografia = '$_REQUEST[id]'";
			
			//exit;
		$db->query($sql);
		//
		$sql="SELECT caminho from diretorio_imagem where diretorio_imagem='$_REQUEST[diretorio_imagem]'";
		$db->query($sql);
		$row=$db->dados();
		$dir=$raiz_imagem.$row['caminho'].'/';
		//
		/////////Upload da Imagem///////
		set_time_limit(0);
		$tamanho_arquivo=$_FILES['arquivo']['size'];
		if($tamanho_arquivo >0) {
			$nome_arq_upload=$_FILES['arquivo']['name'];
			$nome=explode('.',$nome_arq_upload);
			$nome[1]= strtolower($nome[1]);
			$nome_arquivo=$_REQUEST['id'].'_'.$nome_arq_upload;
			
			if ($nome[1]=='gif' || $nome[1]=='jpg' || $nome[1]=='jpeg') {

				 if(is_dir($dir)) {
		   		    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $nome_arquivo);
			     }
				$tamanho_arquivo=($tamanho_arquivo/1024);
		
				$sql="UPDATE fotografia set formato='$nome[1]',nome_arquivo='$nome_arquivo',nome_arq_upload='$nome_arquivo',tamanho_arquivo='$tamanho_arquivo' 
					where fotografia='$_REQUEST[id]'";
				$db->query($sql);
			}
			else {
				echo"<script> alert('A imagem não foi salva pois tem formato inválido!\\n\\nUse apenas GIF, JPG, JPEG.')</script>";
			    exit; 
			}
		}
		/////////////////////////////////

		$sql="DELETE from fotografia_obra where fotografia = '$_REQUEST[id]'";
		$db->query($sql);
		$sql="DELETE from fotografia_autor where fotografia = '$_REQUEST[id]'";
		$db->query($sql);
		$img_principal= $_REQUEST['principal'];if ($img_principal==''){$img_principal='0';}
		$img_laudo= $_REQUEST['laudo'];if ($img_laudo==''){$img_laudo='0';}
		$img_mini= $_REQUEST['mini'];if ($img_mini==''){$img_mini='0';}

		if ($vinculo == 'O') {
			$sql= "SELECT obra from obra where num_registro = '$_REQUEST[txtvinculo]'";
			$db->query($sql);
			$obra= $db->dados();
			if ($_REQUEST['principal']==1 || $_REQUEST['laudo']==1 || $_REQUEST[mini]) {
				$sql= "SELECT a.eh_principal, b.titulo from fotografia_obra as a, fotografia as b where a.obra=$obra[obra] AND a.fotografia=b.fotografia AND a.eh_principal = 1";
				$db->query($sql);
				$status_img= $db->dados();
				if ($_REQUEST['principal']==1 && $status_img['eh_principal']==1) {
					$img_principal= 0;
					echo "<script>alert('Não foi possível salvar a imagem como Principal!\\n\\nImagem \'".$status_img[titulo]."\' já consta como Principal.');</script>";
				}
				$sql= "SELECT a.eh_img_laudo, b.titulo from fotografia_obra as a, fotografia as b where a.obra=$obra[obra] AND a.fotografia=b.fotografia AND a.eh_img_laudo = 1";
				$db->query($sql);
				$status_img= $db->dados();
				if ($_REQUEST['laudo']==1 && $status_img['eh_img_laudo']==1) {
					$img_laudo= 0;
					echo "<script>alert('Não foi possível salvar a imagem como Laudo!\\n\\nImagem \'".$status_img[titulo]."\' já consta como Laudo.');</script>";
				}
				$sql= "SELECT a.eh_mini, b.titulo from fotografia_obra as a, fotografia as b where a.obra=$obra[obra] AND a.fotografia=b.fotografia AND a.eh_mini = 1";
				$db->query($sql);
				$status_img= $db->dados();
				if ($_REQUEST['mini']==1 && $status_img['eh_mini']==1) {
					$img_mini= 0;
					echo "<script>alert('Não foi possível salvar a imagem como Mini!\\n\\nImagem \'".$status_img[titulo]."\' já consta como Mini.');</script>";
				}
			}
			$sql= "INSERT into fotografia_obra(fotografia,obra,eh_principal,eh_img_laudo, eh_mini) values('$_REQUEST[id]','$obra[obra]','$img_principal','$img_laudo','$img_mini')";
			$db->query($sql);
		}
		if ($vinculo == 'A') {
			if ($_REQUEST['principal']==1) {
				$sql= "SELECT a.eh_principal, b.titulo from fotografia_autor as a, fotografia as b where a.autor='$_REQUEST[vinculo_autor]' AND a.fotografia=b.fotografia AND a.eh_principal = 1";
				$db->query($sql);
				$status_img= $db->dados();
				if ($_REQUEST['principal']==1 && $status_img['eh_principal']==1) {
					$img_principal= 0;
					echo "<script>alert('Não foi possível salvar a imagem como Principal!\\n\\nImagem \'".$status_img[titulo]."\' já consta como Principal.');</script>";
				}
			}
			$sql= "INSERT into fotografia_autor(fotografia,autor,eh_principal) values('$_REQUEST[id]','$_REQUEST[vinculo_autor]','$img_principal')";
			$db->query($sql);
		}
/*		if ($vinculo == 'O') {
			$sql= "SELECT obra from obra where num_registro = '$_REQUEST[txtvinculo]'";
			$db->query($sql);
			$obra= $db->dados();
			$sql= "SELECT fotografia from fotografia_obra where fotografia = '$_REQUEST[id]'";
			$db->query($sql);
			if ($db->contalinhas() == 0)
				$sql= "INSERT into fotografia_obra(fotografia,obra,eh_principal,eh_img_laudo,eh_mini) values('$_REQUEST[id]','$obra[obra]','$_REQUEST[principal]','$_REQUEST[laudo]','$_REQUEST[mini]')";
			else
				$sql= "UPDATE fotografia_obra set obra='$obra[obra]', eh_principal='$_REQUEST[principal]', eh_img_laudo='$_REQUEST[laudo]',eh_mini='$_REQUEST[mini]'  where fotografia = '$_REQUEST[id]'";
			$db->query($sql);
		} elseif ($vinculo == 'N') {
			$sql="DELETE from fotografia_obra where fotografia = '$_REQUEST[id]'";
			$db->query($sql);
		}	*/
		echo "<script>location.href='fotografia1.php?titulo_form=$titulo_form&arqimg=$arqimg&id=$_REQUEST[id]'</script>";

	} else {
	
	$sql="INSERT INTO fotografia(forma_exibicao,diretorio_imagem,restricoes,funcao,original,modo_captura,modo_cores,tipo,vinculo,data_criacao,digital,titulo,fotografo,resolucao,altura,largura,digitalizador,altura_original,largura_original,local_original,descricao,obs,conservacao,data_avaliacao)
			values('$_REQUEST[exibicao]','$_REQUEST[diretorio_imagem]','$_REQUEST[restricao]','$_REQUEST[funcao]','$_REQUEST[original]','$_REQUEST[modo_captura]','$_REQUEST[modo_cor]','$_REQUEST[tipo]','$vinculo',now(),'$_REQUEST[digital]','$_REQUEST[titulo]','$_REQUEST[fotografo]','$_REQUEST[resolucao]','$_REQUEST[altura]', 
			'$_REQUEST[largura]','$_REQUEST[digitalizador]','$_REQUEST[alt_original]','$_REQUEST[lar_original]','$_REQUEST[local]', 
			'$_REQUEST[descricao]','$_REQUEST[obs]','$_REQUEST[conservacao]','$dtavaliacao')";
		$db->query($sql);
		$idfotoatual=$db->lastid();
		//
		 $sql="SELECT caminho from diretorio_imagem where diretorio_imagem='$_REQUEST[diretorio_imagem]'";
		 $db->query($sql);
		 $row=$db->dados();
		 $dir=$raiz_imagem.$row[0].'/';
		 ////////Upload da Imagem///////
		$tamanho_arquivo=$_FILES['arquivo']['size'];
		if($tamanho_arquivo >0) {
			$nome_arq_upload=$_FILES['arquivo']['name'];
			$nome=explode('.',$nome_arq_upload);
			$nome[1]= strtolower($nome[1]);
			//$nome_arquivo=$idfotoatual.'_'.$nome_arq_upload;
		    //           $nome_arquivo=$nome[0]."(".$idfotoatual.")".".".$nome[1];
                        $nome_arquivo=$nome[0].".".$nome[1];
			if ($nome[1]=='gif' || $nome[1]=='jpg' || $nome[1]=='jpeg') {

				 if(is_dir($dir)) {
		   		    move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $nome_arquivo);
			     }
				$tamanho_arquivo=($tamanho_arquivo/1024);
		
				$sql="UPDATE fotografia set formato='$nome[1]',nome_arquivo='$nome_arquivo',nome_arq_upload='$nome_arquivo',tamanho_arquivo='$tamanho_arquivo' 
					where fotografia='$idfotoatual'";
				$db->query($sql);
			}
			else {
				echo"<script> alert('A imagem não foi salva pois possui formato inválido!\\n\\nUse apenas GIF, JPG, JPEG.')</script>";
			   }
		}
		/////////////////////////////////

                
                $img_principal= $_REQUEST['principal'];if ($img_principal==''){$img_principal='0';}
		$img_laudo= $_REQUEST['laudo'];if ($img_laudo==''){$img_laudo='0';}
		$img_mini= $_REQUEST['mini'];if ($img_mini==''){$img_mini='0';}


		if ($vinculo == 'O') {
			$sql= "SELECT obra from obra where num_registro = '$_REQUEST[txtvinculo]'";
			$db->query($sql);
			$obra= $db->dados();
			if ($_REQUEST['principal']==1 || $_REQUEST['laudo']==1 || $_REQUEST['mini']) {
				$sql= "SELECT a.eh_principal, b.titulo from fotografia_obra as a, fotografia as b where a.obra=$obra[obra] AND a.fotografia=b.fotografia AND a.eh_principal = 1";
				$db->query($sql);
				$status_img= $db->dados();
				if ($_REQUEST['principal']==1 && $status_img['eh_principal']==1) {
					$img_principal= 0;
					echo "<script>alert('Não foi possível salvar a imagem como Principal!\\n\\nImagem \'".$status_img[titulo]."\' já consta como Principal.');</script>";
				}
				$sql= "SELECT a.eh_img_laudo, b.titulo from fotografia_obra as a, fotografia as b where a.obra=$obra[obra] AND a.fotografia=b.fotografia AND a.eh_img_laudo = 1";
				$db->query($sql);
				$status_img= $db->dados();
				if ($_REQUEST['laudo']==1 && $status_img['eh_img_laudo']==1) {
					$img_laudo= 0;
					echo "<script>alert('Não foi possível salvar a imagem como Laudo!\\n\\nImagem \'".$status_img[titulo]."\' já consta como Laudo.');</script>";
				}
				$sql= "SELECT a.eh_mini, b.titulo from fotografia_obra as a, fotografia as b where a.obra=$obra[obra] AND a.fotografia=b.fotografia AND a.eh_mini = 1";
				$db->query($sql);
				$status_img= $db->dados();
				if ($_REQUEST['mini']==1 && $status_img['eh_mini']==1) {
					$img_mini= 0;
					echo "<script>alert('Não foi possível salvar a imagem como Mini!\\n\\nImagem \'".$status_img[titulo]."\' já consta como Mini.');</script>";
				}
			}
			$sql= "INSERT into fotografia_obra(fotografia,obra,eh_principal,eh_img_laudo,eh_mini) values('$idfotoatual','$obra[obra]','$img_principal','$img_laudo','$img_mini')";
			$db->query($sql);
		}
		if ($vinculo == 'A') {
			if ($_REQUEST['principal']==1) {
				$sql= "SELECT a.eh_principal, b.titulo from fotografia_autor as a, fotografia as b where a.autor='$_REQUEST[vinculo_autor]' AND a.fotografia=b.fotografia AND a.eh_principal = 1";
				$db->query($sql);
				$status_img= $db->dados();
				if ($_REQUEST['principal']==1 && $status_img['eh_principal']==1) {
					$img_principal= 0;
					echo "<script>alert('Não foi possível salvar a imagem como Principal!\\n\\nImagem \'".$status_img[titulo]."\' já consta como Principal.');</script>";
				}
			}
			$sql= "INSERT into fotografia_autor(fotografia,autor,eh_principal) values('$idfotoatual','$_REQUEST[vinculo_autor]','$img_principal')";
			$db->query($sql);
		}
/*		if ($vinculo == 'O') {
			$sql= "SELECT obra from obra where num_registro = '$_REQUEST[txtvinculo]'";
			$db->query($sql);
			$obra= $db->dados();
			$sql= "INSERT into fotografia_obra(fotografia,obra,eh_principal,eh_img_laudo, eh_mini) values('$idfotoatual','$obra[obra]','$_REQUEST[principal]','$_REQUEST[laudo]','$_REQUEST[mini]')";
			$db->query($sql);
		}*/
		echo "<script>alert('Inclusao realizada com sucesso');</script>";
		echo "<script>location.href='fotografia1.php?titulo_form=".$titulo_form."&arqimg=".$arqimg."&id=".$idfotoatual."'</script>";
	}
}

	$digital= 1;
	if ($_REQUEST['id']<>'') {
		if ($_REQUEST['op'] == 'del') {
			$sql="DELETE from fotografia where fotografia = '$_REQUEST[id]'";
			$db->query($sql);
			$sql="DELETE from fotografia_obra where fotografia = '$_REQUEST[id]'";
			$db->query($sql);
			$sql="DELETE from fotografia_autor where fotografia = '$_REQUEST[id]'";
			$db->query($sql);
			$sql="DELETE from restauro_fotografia where fotografia = '$_REQUEST[id]'";
			$db->query($sql);
			echo "<script>alert('Exclusão realizada com sucesso');</script>";
			echo "<script>location.href='fotopre_altera.php'</script>";
		}
		else {
		$sql="SELECT * from fotografia where fotografia = '$_REQUEST[id]'";
		$db->query($sql);
		if ($row=$db->dados()) {
			$digital= $row['digital'];
			$diretorio_imagem=$row['diretorio_imagem'];
			$titulo = $row['titulo'];
			$formato = $row['formato'];
			$fotografo = $row['fotografo'];
			$tamanho = $row['tamanho_arquivo'];
			$resolucao = $row['resolucao'];
			$altura = $row['altura'];
			$largura = $row['largura'];
			$digitalizador = $row['digitalizador'];
			$altura_original = $row['altura_original'];
			$largura_original = $row['largura_original'];
			$local_original = $row['local_original'];
			$descricao = $row['descricao'];
			$obs = $row['obs'];
			$conservacao = $row['conservacao'];
			$tipo= $row['tipo'];
			$mcor= $row['modo_cores'];
			$mcap= $row['modo_captura'];
			$original= $row['original'];
			$funcao= $row['funcao'];
			$exibicao= $row['forma_exibicao'];
			$restricao= $row['restricoes'];
            $nome_arq_upload=$row['nome_arq_upload'];
			$imagem=$row['nome_arquivo'];
			 
			$vinculo= $row['vinculo'];

			if ($vinculo == 'O') {
				$sql="SELECT a.eh_principal,a.eh_img_laudo,eh_mini,b.num_registro,b.dim_obra_altura,b.dim_obra_largura,b.dim_obra_diametro,b.dim_obra_profund from fotografia_obra as a, obra as b 
						where a.obra=b.obra AND a.fotografia = '$_REQUEST[id]'";
				$db->query($sql);
				$txtvinculo= $db->dados();

				$principal= $txtvinculo['eh_principal'];
				$laudo= $txtvinculo['eh_img_laudo'];
                                $mini=$txtvinculo['eh_mini'];

				$altu= number_format($txtvinculo['dim_obra_altura'],1,",",".");
				$larg= number_format($txtvinculo['dim_obra_largura'],1,",",".");
				$diam= number_format($txtvinculo['dim_obra_diametro'],1,",",".");
				$prof= number_format($txtvinculo['dim_obra_profund'],1,",",".");
				if ($altu == '0,0')
					$altu= '';
				if ($larg == '0,0')
					$larg= '';
				if ($diam == '0,0')
					$diam= '';
				if ($prof == '0,0')
					$prof= '';
				$txtvinculo= $txtvinculo['num_registro'];
			}
			if ($vinculo == 'A') {
				$sql="SELECT autor,eh_principal from fotografia_autor where fotografia = '$_REQUEST[id]'";
				$db->query($sql);
				$dautor= $db->dados();
				$selautor= $dautor['autor'];
				$principal= $dautor['eh_principal'];
			}

			$data_avaliacao= explode("-", $row['data_avaliacao']);
			$dia=$data_avaliacao[2]; $mes=$data_avaliacao[1]; $ano=$data_avaliacao[0];
			$data_avaliacao= $dia."/".$mes."/".$ano;

			$tmp= explode(" ", $row['data_criacao']);
			$data_criacao= explode("-", $tmp[0]);
			$dia=$data_criacao[2]; $mes=$data_criacao[1]; $ano=$data_criacao[0];
			$data_criacao= $dia."/".$mes."/".$ano." - ".substr($tmp[1],0,5);

			if ($data_avaliacao == '00/00/0000')
				$data_avaliacao= '';
		}}
	}
?>

<body onLoad='document.getElementById("wait").style.display="none"; ajustaAbas(<?php echo $aba ?>); muda_vinculo("<?php echo $vinculo; ?>");exibe_dir(<?php echo $diretorio_imagem; ?>)'>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
/// validacao do form
function valida()
{
  if (document.getElementById('comvinculo').style.display == '') {
	if (document.form.principal[0].checked==false && document.form.principal[1].checked==false 
                     && document.form.mini[0].checked==false && document.form.mini[1].checked==false &&
                          document.form.laudo[0].checked==false && document.form.laudo[1].checked==false) {

	   alert('Informe se a fotografia é principal, se é para laudo ou mini.');

	  return false;
        }

  }
  with(document.form)
  {
    if(titulo.value=='')
	{
	  alert('Entre com o título da fotografia');
	  return false;
	}
	if(arquivo.value=='' && '<?php echo $nome_arq_upload; ?>'=='')
	{
	  alert('Selecione uma imagem');
	  return false;
	}
   return true;
 }
}

function exibe_dir(valor){

          document.getElementById('rotulo1').style.display='none';
   	if (valor == '0') {
           document.getElementById('rotulo1').style.display='';
        }

}


var carrega_lista_autor=true;
function muda_vinculo1(valor) {

	if (valor == '1') {
		document.getElementById('comvinculo1').style.display='';
		document.form.laudo[0].disabled=true;
		document.form.laudo[1].disabled=true;
		document.form.principal[0].disabled=true;
		document.form.principal[1].disabled=true;

		document.form.principal[0].checked=false;
		document.form.principal[1].checked=false;
		document.form.laudo[0].checked=false;
		document.form.laudo[1].checked=false;


       }else if (valor == '0') {
		document.getElementById('comvinculo1').style.display='none';
		document.form.laudo[0].disabled=false;
		document.form.laudo[1].disabled=false;
		document.form.principal[0].disabled=false;
		document.form.principal[1].disabled=false;

       }
}
function muda_vinculo(valor) {
	document.getElementById('rotulo').style.display='none'; document.getElementById('comvinculo').style.display='none';
	document.getElementById('rautor').style.display='none'; document.getElementById('rpapel').style.display='none';
	document.getElementById('rpintura').style.display='none';
		if (document.form.principal[0].checked==false) {document.form.principal[1].checked=true;}
		if (document.form.laudo[0].checked==false) {document.form.laudo[1].checked=true;}
		if (document.form.mini[0].checked==false) {document.form.mini[1].checked=true;}

	if (valor == 'O') {
		document.getElementById('rotulo').style.display=''; document.getElementById('comvinculo').style.display='';
		document.form.laudo[0].disabled=false;
		document.form.laudo[1].disabled=false;
		document.form.principal[0].disabled=false;
		document.form.principal[1].disabled=false;
                document.form.mini[0].disabled=false;
                document.form.mini[1].disabled=false;
	} else if (valor == 'A') {
		document.getElementById('rautor').style.display='';
		document.getElementById('comvinculo').style.display='';
		document.form.principal[0].disabled=false;
		document.form.principal[1].disabled=false;
		document.form.laudo[0].disabled=true;
		document.form.laudo[0].checked=false;
		document.form.laudo[1].disabled=true;
		document.form.laudo[1].checked=false;
		document.form.mini[0].disabled=true;
		document.form.mini[0].checked=false;
		document.form.mini[1].disabled=true;
		document.form.mini[1].checked=false;


		if (carrega_lista_autor) {
			carrega_lista_autor=false;
			atualiza_autor('<?php echo $selautor; ?>');
		}
	} else if (valor == 'P') {
		document.getElementById('rpapel').style.display='';

	} else if (valor == 'M') {
		document.getElementById('rmoldura').style.display='';


	} else if (valor == 'R') {
		document.getElementById('rpintura').style.display='';

	} else if (valor == 'I') {
		document.getElementById('rpintura').style.display='';
		document.form.laudo[0].disabled=true;
		document.form.laudo[0].checked=false;
		document.form.laudo[1].disabled=true;
		document.form.laudo[1].checked=false;
		document.form.principal[0].disabled=true;
		document.form.principal[0].checked=false;
		document.form.principal[1].disabled=true;
		document.form.principal[1].checked=false;
		document.form.mini[0].disabled=true;
		document.form.mini[0].checked=false;
		document.form.mini[1].disabled=true;
		document.form.mini[1].checked=false;
       } else if (valor == 'N') {
		document.getElementById('rpintura').style.display='';
		document.form.laudo[0].disabled=true;
		document.form.laudo[0].checked=false;
		document.form.laudo[1].disabled=true;
		document.form.laudo[1].checked=false;
		document.form.principal[0].disabled=true;
		document.form.principal[0].checked=false;
		document.form.principal[1].disabled=true;
		document.form.principal[1].checked=false;
		document.form.minil[0].disabled=true;
		document.form.mini[0].checked=false;
		document.form.mini[1].disabled=true;
		document.form.mini[1].checked=false;

       }
}
</script>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <?php 
//montalinks();
echo "<br>";
?>
    </div>
  <div id="wait" align="center" class="texto" style="width:450px; height:380px; font-size:12px; font-weight:bold;">
		<br><br><br><br><br>
		&nbsp;&nbsp;<img src="imgs/icons/clock.gif"> &nbsp;&nbsp;Carregando...
  </div>
	</th>
  </tr>
<form name="form" method="post"  enctype="multipart/form-data" onSubmit="return valida();">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Fotografia</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>(Pág.2)</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>(Pág.3)</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Notas</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba5" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(5);"><div class="texto" id="abas"><a href="javascript:;" id="link5" onClick="ajustaAbas(5);" onMouseDown="this.click();"><span>Visualização</span></a></div></td>
	  <td width="40" style="border-bottom: 1px solid #34689A;" align="center">&nbsp;<?



     
                       
                                             echo "<a href=\"foto_ocorrencia_altera.php?titulo=$titulo_form&arqimg=$arqimg\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";





       ?></td>
    </tr>
      <td colspan="6" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="280" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td valign="top">
				<!-- ABA 1 : Pagina 1 -->
                <div id="quadro1" class="divi1" style="display:none; width:540px; overflow: auto;">
                  <table border="0" cellpadding="4" cellspacing="3" bgcolor="#f2f2f2">

                   <tr>
 					<td class="texto_bold" colspan="2">
                                                        Digital? <input type="radio" name="digital" value="1" <?php if ($digital == '1') echo "checked"; ?>>Sim 
                                                                 <input type="radio" name="digital" value="0" <?php if ($digital == '0') echo "checked"; ?>>Não 
							         <label id="comvinculo"></label>
                                                                                                                                      
						</td>

                   </tr>


                     <tr>
						<td height="40" class="texto_bold">Vínculo: </td>
						<td class="texto_bold">
						<?php if ($vinculo=='R' || $vinculo=='P') { ?>
						<select name="vinculo" class="combo_cadastro">
							<?php if ($vinculo == 'P') { echo '<option value="P" selected>Restauro de Papel</option>'; }
							   if ($vinculo == 'R') { echo '<option value="R" selected>Restauro de Pintura</option>'; }
							   if ($vinculo == 'M') { echo '<option value="R" selected>Restauro de Moldura</option>'; }	?>
						</select> &nbsp;&nbsp;&nbsp;&nbsp;<label id="rotulo"><input type="text" name="txtvinculo" value=""></label><label id="rautor"></label><label id="rpapel"></label><label id="rpintura"></label><label id="rmoldura"></label>
						<?php } else { ?>
						<select name="vinculo" class="combo_cadastro" onChange="muda_vinculo(this.value)">
							<option value="N" <?php if ($vinculo=='' || $vinculo=='N') echo "selected"; ?>>Sem vínculo</option>
							<option value="O" <?php if ($vinculo == 'O') echo "selected"; ?>>Obra</option>
							<option value="A" <?php if ($vinculo == 'A') echo "selected"; ?>>Autor</option>
							<option value="I" <?php if ($vinculo == 'I') echo "selected"; ?>>Instituição</option>
						</select> &nbsp;&nbsp;&nbsp;&nbsp;<label id="rotulo">Nº de registro da obra: &nbsp;&nbsp;&nbsp;<input type="text" name="txtvinculo" value="<?php echo htmlentities($txtvinculo, ENT_QUOTES); ?>" class="combo_cadastro" size="18" style="text-align: center;"></label><label id="rautor"></label><label id="rpapel"></label><label id="rpintura"></label><label id="rmoldura"></label>
						<?php } ?>
						</td>
                    </tr>

                   <tr>
						<td class="texto_bold" colspan="2">
                                                                                                                              
                                                                Principal?<input type="radio" name="principal" value="1" <?php if ($principal == '1') echo "checked"; ?>>Sim 
                                                                                <input type="radio" name="principal" value="0" <?php if ($principal == '0') echo "checked"; ?>>Não 

							                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                Laudo?<input type="radio" name="laudo" value="1" <?php if ($laudo == '1') echo "checked"; ?>>Sim 
                                                                            <input type="radio" name="laudo" value="0" <?php if ($laudo == '0') echo "checked"; ?>>Não

								             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                 Mini? <input type="radio" name="mini" value="1" <?php if ($mini == '1') echo "checked"; ?> onClick="muda_vinculo1('1');<?php if ($mini == '1') echo "checked"; ?>">Sim 
                                                                       <input type="radio" name="mini" value="0" <?php if ($mini == '0') echo "checked"; ?> onClick="muda_vinculo1('0');<?php if ($mini == '0') echo "checked"; ?>">Não 
							               <label id="comvinculo1"></label>

                                                                 
						</td>
                    </tr>

                    <tr>
						<td class="texto_bold">Título: </td>
						<td class="texto_bold"><input class="combo_cadastro" type="text" name="titulo" size="75" maxlength="255" value="<?php echo htmlentities($titulo, ENT_QUOTES); ?>"></td>
                    </tr>
                    <tr>
						<td class="texto_bold">Fotógrafo: &nbsp;&nbsp;&nbsp;</td>
						<td class="texto_bold"><input class="combo_cadastro" type="text" name="fotografo" size="75" maxlength="255" value="<?php echo htmlentities($fotografo, ENT_QUOTES); ?>"></td>
                    </tr>
                    <tr>
						<td class="texto_bold">Arquivo: </td>
					  <td class="texto_bold" nowrap><input type="hidden" name="MAX_FILE_SIZE" value="16000000">
					  	<input class="combo_cadastro" type="file" name="arquivo" size="53">
					    <?php if($nome_arq_upload<>''){
						       echo "<br>";
							   echo "<span class='texto'>$nome_arq_upload</span>";
						 } ?>
						</td>
                    </tr>
					<tr>
					   <td colspan="2" class="texto_bold">Destino da fotografia: 
                                              <select name="diretorio_imagem" class="combo_cadastro" onChange="exibe_dir(this.value)" >
                                              <?php 
					          $sql="SELECT distinct diretorio_imagem,url from diretorio_imagem order by url asc"; 
					          $db->query($sql);
					          echo "<option value='0' ></option>";
					          while($res=$db->dados())
					          {
					       ?>
                                               <option value="<?php echo $res[0]; ?>" <?php if($diretorio_imagem==$res[0]) echo "Selected" ?>><?php echo $res[1]; ?></option>
                                               <?php } ?>
                                               </select>
					       <label id="rotulo1">Localização: <input type="text" name="local" value="<?php echo htmlentities($local_original, ENT_QUOTES); ?>"class="combo_cadastro"   size="30" maxlength="100"></label>
                                              
                                              </td>
                                         </tr>



					<tr>
						<td class="texto_bold"><font style="color:#9B9B9B">Tamanho: </td>
						<td class="texto_bold"><font style="color:#9B9B9B"><input type="text" name="tamanho" size="22" style="text-align:right" class="combo_cadastro" value="<?php echo number_format($tamanho,2,',','.'); ?>"> Kb
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Formato: 
							<input type="text" name="formato" size="6"  class="combo_cadastro" readonly value="<?php echo $formato; ?>"> </td>
					</tr>
                    <tr>
						<td class="texto_bold">Coloração: </td>
						<td class="texto_bold"><select class="combo_cadastro" name="tipo">
							<option value="0" selected>&nbsp;</option>
							<option value="PB" <?php if ($tipo == 'PB') echo "selected"; ?>>P&amp;B</option>
							<option value="COR" <?php if ($tipo == 'COR') echo "selected"; ?>>Colorido</option>
						</select><font style="color:#9B9B9B">&nbsp;&nbsp;&nbsp;&nbsp;
						Data de criação: <input class="combo_cadastro" type="text" name="dtcriacao" size="16" readonly value="<?php echo $data_criacao; ?>"></td>
                    </tr>
                  </table>
              </div>
                <!-- ABA 2 : Pagina 2 -->
              <div id="quadro2" class="divi1" style="display:none; width:540px; overflow: auto;">
                  <table border="0" cellpadding="6" cellspacing="3" class="texto_bold">
                    <tr>
						<td class="texto_bold">Resolução: </td>
						<td class="texto_bold"><input class="combo_cadastro" type="text" name="resolucao" size="20" maxlength="20" value="<?php echo htmlentities($resolucao, ENT_QUOTES); ?>"> pixel/polegada</td>
                    </tr>
                    <tr>
						<td class="texto_bold">Modo de cores: </td>
						<td class="texto_bold"><select class="combo_cadastro" name="modo_cor">
							<option value="0" selected>&nbsp;</option>
							<option value="bitmap" <?php if ($mcor == 'bitmap') echo "selected"; ?>>Bitmap</option>
							<option value="bitonal" <?php if ($mcor == 'bitonal') echo "selected"; ?>>Bitonal</option>
							<option value="cmyk" <?php if ($mcor == 'cmyk') echo "selected"; ?>>CMYK</option>
							<option value="grayscale" <?php if ($mcor == 'grayscale') echo "selected"; ?>>Gray scale</option>
							<option value="index" <?php if ($mcor == 'index') echo "selected"; ?>>Indexada</option>
							<option value="rgb" <?php if ($mcor == 'rgb') echo "selected"; ?>>RGB</option>
						</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Modo de captura: <select class="combo_cadastro" name="modo_captura">
							<option value="0" selected>&nbsp;</option>
							<option value="CA" <?php if ($mcap == 'CA') echo "selected"; ?>>Câmera</option>
							<option value="CO" <?php if ($mcap == 'CO') echo "selected"; ?>>Computador</option>
							<option value="SC" <?php if ($mcap == 'SC') echo "selected"; ?>>Scanner</option>
						</select></td>
                    </tr>
                    <tr>
						<td class="texto_bold">Altura: </td>
						<td class="texto_bold" nowrap><input class="combo_cadastro" type="text" name="altura" size="14" value="<?php echo number_format($altura,2,",","."); ?>"> cm
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Largura: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="combo_cadastro" type="text" name="largura" size="14" value="<?php echo number_format($largura,2,",","."); ?>"> cm</td>
                    </tr>
                    <tr>
						<td class="texto_bold">Digitalizador: </td>
						<td class="texto_bold" nowrap><input class="combo_cadastro" type="text" name="digitalizador" size="63" maxlength="100" value="<?php echo htmlentities($digitalizador, ENT_QUOTES); ?>"></td>
                    </tr>
                    <tr>
						<td class="texto_bold">Original: </td>
						<td class="texto_bold" nowrap><input class="combo_cadastro" type="text" name="original" size="63" maxlength="50" value="<?php echo htmlentities($original, ENT_QUOTES); ?>"></td>
                    </tr>
                    <tr>
						<td class="texto_bold">Alt. do original: </td>
						<td class="texto_bold" nowrap><input class="combo_cadastro" type="text" name="alt_original" size="14" value="<?php echo number_format($altura_original,2,",","."); ?>"> cm
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Larg. do original: <input class="combo_cadastro" type="text" name="lar_original" size="14" value="<?php echo number_format($largura_original,2,",","."); ?>"> cm</td>
                    </tr>
                 </table>
  		      </div>                
			  <!-- ABA 3 : Pagina 3 -->
			  <div id="quadro3" class="divi1" style="display:none; width:540px; overflow: auto;">
			    <table border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
						<td class="texto_bold"><br>Forma de exibição: </td>
						<td class="texto_bold"><br><select class="combo_cadastro" name="exibicao">
							<option value="0" selected>&nbsp;</option>
							<option value="olhos" <?php if ($exibicao == 'olhos') echo "selected"; ?>>Altura dos olhos</option>
							<option value="nchao" <?php if ($exibicao == 'nchao') echo "selected"; ?>>No chão</option>
						</select></td>
					</tr>
                    <tr>
						<td class="texto_bold">Função: </td>
						<td class="texto_bold"><select class="combo_cadastro" name="funcao">
							<option value="0" selected>&nbsp;</option>
							<option value="M" <?php if ($funcao == 'M') echo "selected"; ?>>Master</option>
							<option value="R" <?php if ($funcao == 'R') echo "selected"; ?>>Referência</option>
							<option value="T" <?php if ($funcao == 'T') echo "selected"; ?>>Thumbnail</option>
						</select></td>
					</tr>
                    <tr>
						<td class="texto_bold">Restrições: </td>
						<td class="texto_bold"><select class="combo_cadastro" name="restricao">
							<option value="0" selected>&nbsp;</option>
							<option value="N" <?php if ($restricao == 'N') echo "selected"; ?>>Sem restrições</option>
							<option value="A" <?php if ($restricao == 'A') echo "selected"; ?>>Autorização do autor</option>
							<option value="I" <?php if ($restricao == 'I') echo "selected"; ?>>Autorização da instituição</option>
							<option value="T" <?php if ($restricao == 'T') echo "selected"; ?>>Autorização do autor e da instituição</option>
							<option value="P" <?php if ($restricao == 'P') echo "selected"; ?>>Uso proibido</option>
						</select></td>
					</tr>
                    <tr>
						<td class="texto_bold">Conservação: </td>
						<td class="texto_bold" nowrap><input class="combo_cadastro" type="text" name="conservacao" size="60" maxlength="50" value="<?php echo htmlentities($conservacao, ENT_QUOTES); ?>"></td>
                    </tr>
                    <tr>
						<td class="texto_bold">Data avaliação: </td>
						<td class="texto_bold" nowrap><input class="combo_cadastro" type="text" name="dtavaliacao" size="10" maxlength="10" value="<?php echo $data_avaliacao; ?>"></td>
                    </tr>
				</table>
              </div>
			  <!-- ABA 4 : Notas -->  
				 <div id="quadro4" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
						<td class="texto_bold" valign="top">Descrição: </td>
						<td class="texto_bold"><textarea class="combo_cadastro" name="descricao" rows="8" cols="70"><?php echo $descricao; ?></textarea></td>
                    </tr>
                    <tr>
						<td class="texto_bold" valign="top">Observação: </td>
						<td class="texto_bold"><textarea class="combo_cadastro" name="obs" rows="8" cols="70"><?php echo $obs; ?></textarea></td>
                    </tr>
                </table>
              </div>
			  <!-- ABA 5 : Visualização -->  
				 <div id="quadro5" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table border="0" cellpadding="0" cellspacing="10" bgcolor="f2f2f2" class="texto_bold" align="center">
                    <tr>
					  <?php if ($nome_arq_upload <> '') { ?>
						<td class="texto_bold">
							<?php 
							$sql="SELECT url,caminho from diretorio_imagem where diretorio_imagem={$diretorio_imagem}";
							$db->query($sql);
							$url = $db->dados();
							$dir=$raiz_imagem.$url[1].'/';
							//if (file_exists($dir.$imagem)) {
							if (file_get_contents($dir . $imagem)) {
								list($width, $height, $type, $attr) = getimagesize($dir_virtual.$url[0].'/'.$imagem);
								$Ao= $height;
								$Lo= $width;

								//300 é a altura max da área de exibição da imagem; 500 é a largura máxima.//
								$cA= $Ao / 300;
								$cL= $Lo / 500;

								if ($Ao > 300 || $Lo > 500) {
									if (cL < cA) {
										$percent= (500 * 100) / $Lo;
										$Lo= 500;
										$Ao= ($Ao * $percent) / 100;
										if ($Ao > 300) {
											$percent= (300 * 100) / $Ao;
											$Ao= 300;
											$Lo= ($Lo * $percent) / 100;
										}

									} else {
										$percent= (300 * 100) / $Ao;
										$Ao= 300;
										$Lo= ($Lo * $percent) / 100;
										if ($Lo > 500) {
											$percent= (500 * 100) / $Lo;
											$Lo= 500;
											$Ao= ($Ao * $percent) / 100;
										}
									}
								}
								?>
                                                                <?php if ($vinculo == 'A') {$ID=$selautor;}else{$ID=$obra['obra'];}?>
								<br><a href="javascript:;" onClick="abrepop('pop_imagem.php?fotografia=<?php echo $_REQUEST['id'];?>&obra=<?php echo $obraimg;?>&exibicao=<?php echo $row2[forma_exibicao]; ?>&principal=<?php echo $principal; ?>&imagem=<?php echo $url[0].'/'.$imagem; ?>&altura=<?php echo $altu; ?>&largura=<?php echo $larg; ?>&diametro=<?php echo $diam; ?>&profundidade=<?php echo $prof; ?>','<?php echo $height ?>','<?php echo $width ?>'); return false;"><img src='<?php echo $dir_virtual.$url[0].'/'.combarra_encode($imagem) ?>?<?php echo time() ?>' height="<?php echo $Ao; ?>" width="<?php echo $Lo; ?>" border='0'></a>
							<?php } else { ?>
								<br><br><br>Arquivo não encontrado no servidor: <br><br>&gt; <font style="font-weight: normal;"><?php echo $dir.$imagem; ?></font> &lt;
							<?php } ?>
						</td>
					  <?php } ?>
                    </tr>
                </table>
              </div>
			</td>
		  </tr>
		</table>
          <table width="540" border="0" style="background-color: #f2f2f2;" id="rodape">
            <tr>
              <td align="center"><input align='middle' name="submit" type="submit" class="botao" value="Gravar">&nbsp;&nbsp;&nbsp;&nbsp;
                <br></td>
            </tr>
          </table>
  </table>
</form>
</body>
