<? include_once("seguranca.php") ?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 

 include("classes/classe_padrao.php");
 include("classes/funcoes_extras.php");
 $db=new conexao();
 $db->conecta();
 $db2=new conexao();
 $db2->conecta();
 $db3=new conexao();
 $db3->conecta();

               $dir= diretorio_fisico();
     $dir_virtual= diretorio_virtual();
    $dir_donato=diretorio_donato();

     $fotografia=$_REQUEST['fotografia'];
       $exibicao=$_REQUEST['exibicao'];
      $principal=$_REQUEST['principal'];
         $altura=$_REQUEST['altura'];
        $largura=$_REQUEST['largura'];
       $diametro=$_REQUEST['diametro'];
   $profundidade=$_REQUEST['profundidade'];



?>

<script>

function ajustaTamanho(zoom) {
	valor= (altura * 20) / 100;
	if (zoom == 'mais') {
		document.getElementById('foto').style.height= altura+valor;
		altura= altura+valor;
	} else if (zoom == 'menos') {
		if (altura > valor) {
			document.getElementById('foto').style.height= altura-valor;
			altura= altura-valor;
		}
	} else if (zoom == 'normal') {
		document.getElementById('foto').style.height= alt_normal;
		altura= alt_normal;
	}
}

   h=screen.height-200,w=screen.width-150;
   function abrepop(janela)
   {
     win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
    if(parseInt(navigator.appVersion)>=4)
       {
         win.window.focus();
       }
     return true;
    }
</script>

         <?

	    $sql1="SELECT diretorio_imagem from fotografia where (fotografia = '$fotografia')";
            $db->query($sql1);
            $row=$db->dados();
            $diretorio_imagem=$row['diretorio_imagem'];

            $sql3="SELECT caminho,url from diretorio_imagem where diretorio_imagem = '$diretorio_imagem'";
            $db3->query($sql3);
            $row=$db3->dados();
            $local=$row['url'];
            $caminho=$row[caminho];


	    $sql1="SELECT * from fotografia where (fotografia = '$fotografia')";
            $db->query($sql1);
            $row=$db->dados();
            $nomearquivo=$row['nome_arquivo'];
    	    $cor= "";


	    //284 é a altura max da área de exibição da imagem; 500 é a largura máxima.//
	    $cA= $Ao / 284;
	    $cL= $Lo / 500;

         if (file_exists($dir.$local.'\\'.$nomearquivo)) {
	    list($width, $height, $type, $attr)= getimagesize($dir_virtual.$local.'/'.$nomearquivo);
	    $Ao= $height;
	    $Lo= $width;
	    $cA= $Ao / 284;
	    $cL= $Lo / 500;
	    if ($Ao > 284 || $Lo > 500) {
	       if (cL < cA) {
	          $percent= (500 * 100) / $Lo;
		  $Lo= 500;
		  $Ao= ($Ao * $percent) / 100;
		  if ($Ao > 284) {
		     $percent= (284 * 100) / $Ao;
		     $Ao= 284;
		     $Lo= ($Lo * $percent) / 100;
		   }

		} else {
		   $percent= (284 * 100) / $Ao;
		   $Ao= 284;
		   $Lo= ($Lo * $percent) / 100;
		   if ($Lo > 500) {
		      $percent= (500 * 100) / $Lo;
		      $Lo= 500;
		      $Ao= ($Ao * $percent) / 100;
		    }
	        }
	   }
       }

        ?>


<table width="100%" bgcolor="#FFFFFF"  height="2%" border="1" bordercolor="#cccccc"  cellpadding="0" cellspacing="0">

  <tr align="left">
    <td align="left" colspan="8" height="20%" class="texto_bold" nowrap valign="top" style="border-right: 1px solid #A1B2BB;"> 
         <div  align="left" class="texto_bold">
               <a style="color:green "href="javascript: window.close();">&nbsp;FECHAR</a>
	 &nbsp;&nbsp;<font color="green">|</font>
               &nbsp;&nbsp;&nbsp;<a style="color:green "href="javascript: abrepop('pop_imagem.php?fotografia=<?echo $fotografia;?>&exibicao=<? echo $exibicao; ?>&principal=<? echo $principal; ?>&imagem=<? echo rawurlencode($_REQUEST['imagem']); ?>&altura=<? echo $_REQUEST['altura']; ?>&largura=<? echo $_REQUEST['largura']; ?>&diametro=<? echo $_REQUEST['diametro']; ?>&profundidade=<? echo $_REQUEST['profundidade']; ?>');">VISUALIZAÇÃO</a>
          </div>
      </td>
   </tr>
<tr>
    <td colspan="8" height="20%" nowrap class="texto"> 
      <div align="left" class="texto"><a style="color:green ">&nbsp;Posicione o ponteiro do mouse sobre as caixas coloridas abaixo para alterar a cor do fundo</a>
	</div></td>
</tr>
  <tr>
    <td width="10%" height="10" valign="center" bgcolor="#FFFFFF" onmouseover="document.getElementById('fundo').style.backgroundColor='#FFFFFF'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#F4ECD0" onmouseover="document.getElementById('fundo').style.backgroundColor='#F4ECD0'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#CCCCCC" onmouseover="document.getElementById('fundo').style.backgroundColor='#CCCCCC'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#999999" onmouseover="document.getElementById('fundo').style.backgroundColor='#999999'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#87AA87" onmouseover="document.getElementById('fundo').style.backgroundColor='#87AA87'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#802F04" onmouseover="document.getElementById('fundo').style.backgroundColor='#802F04'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#443300" onmouseover="document.getElementById('fundo').style.backgroundColor='#443300'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#000000" onmouseover="document.getElementById('fundo').style.backgroundColor='#000000'" ></td>
  </tr>


</table>
<table width="100%" id=fundo bgcolor="#FFFFFF"  height="100%" border="0" align="left" cellpadding="5" cellspacing="0">
   <tr height="80%" >
  
           <?         	
	     $cor= "";if ($row[tipo] == 'COR') {$cor= "Cor";}
	     elseif ($row[tipo] == 'PB') {$cor= "P/B";}

	     $funcao= "";if ($row[funcao] == 'M') {$funcao= "Master";}elseif ($row[funcao] == 'R') {$funcao= "Referência";}
	     elseif ($row[funcao] == 'T') {$funcao= "Thumbnail";}
				    
	     $vinculo= "<em>sem vínculo</em>";
	     if ($row[vinculo] == 'A') {
	        $sql="SELECT nomeetiqueta from autor as a inner join fotografia_autor as b on (a.autor=b.autor) where b.fotografia = $row[fotografia]";
		$db2->query($sql);
		$vinculo= $db2->dados();
		$vinculo= $vinculo['nomeetiqueta'];
	      }
	      elseif ($row[vinculo] == 'O') {
	         $sql="SELECT a.obra,a.titulo_etiq,a.dt_aquisicao_ano1,a.dt_aquisicao_ano2,a.dt_aquisicao_tp,a.num_registro,a.colecao from obra as a inner join fotografia_obra as b on (a.obra=b.obra) where b.fotografia = $row[fotografia]";
		 $db2->query($sql);
		 $vinculo= $db2->dados();
		 $dat= "";
		 if ($vinculo['dt_aquisicao_tp'] == 'circa') $dat.= " circa ";
		 if ($vinculo['dt_aquisicao_ano1'] <> '0') {$dat.= $vinculo['dt_aquisicao_ano1'];}
		 if ($vinculo['dt_aquisicao_ano2'] <> '0') {if ($vinculo['dt_aquisicao_ano2'] <> $vinculo['dt_aquisicao_ano1'])$dat.= " / ".$vinculo['dt_aquisicao_ano2'];}
		 if ($vinculo['dt_aquisicao_tp'] == '?') $dat.=" (?) ";
		 if (strlen($dat) > 3)$dat= ", " . $dat;
		 $sql="SELECT nomeetiqueta from autor as a inner join autor_obra as b on (a.autor=b.autor) where b.obra = $vinculo[obra]";
		 $db2->query($sql);
		 $nome_aut= $db2->dados();				
		 $sql="SELECT nome from colecao where colecao = $vinculo[colecao]";
		 $db2->query($sql);
		 $nome_col= $db2->dados();
		 $vinculo= $nome_aut['nomeetiqueta'] . "<br>" . $vinculo['titulo_etiq'] . $dat . "<br>Nº de registro: " . $vinculo['num_registro'] . "<br>" . $nome_col['nome'];
	       }
	       elseif ($row[vinculo]=='P' || $row[vinculo]=='R') {
	         $sql="SELECT a.ir,a.autor,a.titulo,a.tombo,a.nome_objeto from restauro as a inner join restauro_fotografia as b on (a.restauro=b.restauro) where b.fotografia = $row[fotografia]";
		 $db2->query($sql);
		 $vinculo= $db2->dados();
		 $objeto= "";
		 if ($vinculo['nome_objeto'] <> '')$objeto= " / " . $vinculo['nome_objeto'];
		    $vinculo= $vinculo['autor'] . "<br>" . $vinculo['titulo'] . $objeto . "<br>Nº de registro: " . $vinculo['tombo'] . "<br>IR: " . $vinculo['ir'];
		 }
	         elseif ($row[vinculo] == 'I') {$vinculo= "Instituição";
		 }
	       ?>
        


      <td height="70%" width="150%" id=fundo colspan="5" valign="center" align="center">
         <img id="obra" src="<? echo $dir_virtual.combarra_encode($_REQUEST['imagem']); ?>"width="<?echo $Lo;?> " height="<? echo $Ao; ?>">
         </img>
         </td>
   </tr>
    <tr height="60%"  valign="center" >
       <td height="100%" width="100%" id=fundo colspan="5" nowrap class="texto" celspaning="10" border="0" valign="top" align="left">
           <b>Título: </b><? echo $row[titulo] ?><br>
           <b>Vínculo: </b><? echo $vinculo ?><br>	            
           <b>Função: </b><? echo $funcao ?><br>
           <b>cor: </b><? echo $cor ?><br>
           <b>Local: </b><i><? echo $dir_donato.$caminho.$nomearquivo?></i>
      </td>
           
     </tr>
   </tr>
   </td>
 </table>


</body>
</html>
