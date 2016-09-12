<? 
    include_once("seguranca.php")


?>

<html>
<head>
<title>Impressão de obras</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<style>
@media print {
	.noprint {
		display: none;
	}
}
@media screen {
	.noscreen {
		display: none;
	}
}
</style>
</head>

<script language="JavaScript">

function abrepop1(janela,alt,larg) {
        
	win=window.open(janela,'impressao','left='+((window.screen.width/2)-100)+',top='+((window.screen.height/2)-100)+',width=470,height=200,menubar=no, toolbar=no, scrollbars=no, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
 }
function abrepop2(janela,alt,larg) {
	
	win=window.open(janela,'impressao','left=4000,top=4000,width=1,height=5, menubar=none, toolbar=none, scrollbars=none, resizable=true');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
 }
function abrepop3(janela,alt,larg) {
	janela=janela+"&de="+document.getElementById('de').value+"&ate="+document.getElementById('ate').value;
	win=window.open(janela,'impressao','left=4000,top=4000,width=1,height=5, menubar=none, toolbar=none, scrollbars=none, resizable=true');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
 }
</script>
<? 
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");

	$db=new conexao();
	$db->conecta();
	$db2=new conexao();
	$db2->conecta();
	$db3=new conexao();
	$db3->conecta();
	$db4=new conexao();
	$db4->conecta();
	$db9=new conexao();
	$db9->conecta();
	$dbdir=new conexao();
	$dbdir->conecta();
        $dbAutor = new conexao();
        $dbAutor->conecta();

            $confirma=false;
 	         $dir = diretorio_fisico();
         $dir_virtual = diretorio_virtual();
         $form_ativo = $_REQUEST[form_ativo];
        $txtpesquisa = $_REQUEST[pesquisa];
                $num = $_REQUEST[num];
            $usuario = $_REQUEST[usuario];
                 $tf = $_REQUEST[tf];
                $tfa = $_REQUEST[tfa];
                 $de = $_REQUEST[de];
                $ate = $_REQUEST[ate];
    $txtpesquisa_rel = $_REQUEST[txtpesquisa_rel];
          $porpagina = $_REQUEST[porpagina];
                 $de = $_REQUEST[de];
                $ate = $_REQUEST[ate];
             $rodape = $_REQUEST[rodape];
     $tridimencional = $_REQUEST[tridimencional];
           $traducao = $_REQUEST[traducao];
              $total = $_REQUEST[total];
          $comimagem = $_REQUEST[comimagem];
    $txtpesquisa_rel = $_REQUEST[txtpesquisa_rel];
        $info_filtro = $_REQUEST[info_filtro];
           $download = $_REQUEST[usuario];
            $usuario = $_REQUEST[usuario];                
          $distancia = 1;
              $count = $iniciar-1;           
            $modeloR = $_REQUEST[modelo];
              
 
     
   //echo "Modelo: ".$modeloR;



function formata_ing($valor)
{
 $valor=str_replace(",", ".", $valor);
 return $valor;
}
function exibeDataNegativa($valor) {
	if ($valor < 0)
		return substr($valor,1) . " aC";
	else
		return $valor;
}
function ret_colecao_obra($obrid)
{
 global $db2;
 $sql="SELECT nome from colecao as a, obra as b where a.colecao=b.colecao AND b.obra='$obrid'";
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0];
}
function ret_data_obra($obrid)
{
 global $db2;
 $sql="SELECT dt_parte_ano1,dt_parte_ano2,dt_parte_tp,transc_assinatura from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0]."|".$res[1]."|".$res[2]."|".$res[3];
}
function ret_dim_parte($obrid)
{
 global $db2;
 $sql="SELECT dim_mold_possui,dim_base_possui,dim_mold_altura,dim_mold_largura,dim_base_altura,dim_base_largura 
		from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 if ($res['dim_base_possui'] == 'S') {
	$altura= $res['dim_base_altura'];
	$largura= $res['dim_base_largura'];
	$tipo= "base";
 }
 else {
	$altura= $res['dim_mold_altura'];
	$largura= $res['dim_mold_largura'];
	$tipo= "moldura";
 }
 return formata_valor_3($altura) . " x " . formata_valor_3($largura,1) . " cm (".$tipo.")";
}

function parte_ass_ing($obrid)
{
 global $db2;
 $sql="SELECT assinada,transc_assinatura from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 if ($res['assinada'] == 'S') {
        $assing="signed <em>".$res['transc_assinatura']."</em>";
 }
 else {
        $assing= "no signature";
 }
 return $assing;
}

function ret_aquisicao_ing($sigla)
{
 global $db2;
 $sql="SELECT nome_ing from forma_aquisicao where forma_aquisicao = '$sigla'";
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0];
}
function ret_aquisicao($sigla)
{
 global $db2;
 $sql="SELECT nome from forma_aquisicao where forma_aquisicao = '$sigla'";
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0];
}
function percente_obras($marcadas)
{
 global $db;
 $sql="SELECT count(*) from obra where status = 'P'";
 $db->query($sql);
 $res=$db->dados();
 $tot= $res[0];
 $percent= ($marcadas * 100) / $tot;
 return number_format($percent,2,",",".");
}        
        
   $id_obras= $_SESSION['s_impressao'];
   $id_obras= substr($id_obras,1,-1); // colocado o parametro ,-1 para desprezar a ultima virgula da string (PBL - 10/09/2008)
   if ($id_obras == '')$id_obras= 0;


    if ($tridimencional=='true')  
    {           
       $id_obras_t='';
       $sql= "SELECT * from obra where obra in ($id_obras) order by num_registro + 0";
        $db->query($sql);
       while($row=$db->dados())
       { 
          if (($row[dim_obra_altura] <> '0.00') and ($row[dim_obra_profund] <> '0.00') and ($row[dim_obra_largura] <> '0.00'))
          {
              if ($id_obras_t=='') { $id_obras_t=$row[obra]; }else{$id_obras_t=$id_obras_t.",".$row[obra]; }
            }
        }
        $id_obras=$id_obras_t;
      }



      if (trim($id_obras)==''){
          echo"<script>alert('Não existe obra tridimencional na seleção relaizada.');</script>";
          echo "<script>self.close();</script>";
       }

        
        if ($id_obras == '')
	$id_obras= 0;
        $sql= "SELECT count(*) from obra where obra in ($id_obras) order by num_registro + 0";
        $db->query($sql);
        $numlinhas=$db->dados();
        $numlinhas=$numlinhas[0];
        $sql= "SELECT * from obra where obra in ($id_obras) order by num_registro + 0";
        $db->query($sql);
        $row=$db->dados();
        $id_obras=$row[0];
        $sql= "SELECT * from obra where obra in ($id_obras) order by num_registro + 0";
        $db->query($sql);


?>
<script>

function obtem_valor(qual) {
	if (qual.selectedIndex.selected != '') {     
		var i = qual.value;
		document.location=('pre_impressao_obras.php?page='+ i+ '&porpagina=<?echo $porpagina?>&iniciar=<?echo $iniciar?>&de=<?echo $de?>&rodape=<?echo $rodape?>&comimagem=<?echo $comimagem?>&de=<?echo $de;?>&ate=<?echo $ate;?>');
	}
}

function download(qual) {
                document.location=('download_relatorio.php?txtpesquisa_rel=<?echo $txtpesquisa_rel?>&modelo=<?echo $modeloR?>&totpag=<?echo $_SESSION[paginas]?>&ultpag=0&info_filtro=<?echo $info_filtro?>&total=<?echo $total?>&rodape=<?echo $rodape?>&modelo2=false&comimagem=<?echo $comimagem?>&traducao=<?echo $traducao?>&tridimencional=<?echo $tridimencional;?>&tfa=<?echo $tfa;?>&tf=<?echo $tf;?>&distancia=2&de=<?echo $de;?>&ate=<?echo $ate;?>');
	
}

</script>
<body>


<table width="100%" height="100%" border="1" bgcolor="#f2f2f2" >
<tr>
 <td >
  <? $totalImagem=$_SESSION['s_temimagem'];
     if ($_SESSION['s_temimagem']>100)
    {
     $total_img=($total/100);
   

    }
  ?>

<table width="100%" height="10%" border="0" bgcolor="FFFFFF" >
     <tr width="100%" height="100%">
         <td width="80%" height="10%">
          <table width="100%" height="10%" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2"> 
               <tr width="100%" height="100%" >
	      <td width="80%"  align="left" style="border-bottom: 1px solid #34689A;border-top: 1px solid #34689A;border-left: 1px solid #34689A;">                                        
                        <font bgcolor='#c7c7c7' style='font-family:arial,times new roman;color:blue; font-weight:normal; font-size:12px;'>&nbsp;Exemplo da formatação do relatório</span>&nbsp;
              </td> 
	      <td width="20%"  align="right" style="border-bottom: 1px solid #34689A;border-top: 1px solid #34689A;border-right: 1px solid #34689A;">                                          
                        <a href="javascript:;" style="text-decoration: none;" onmousemove="hint(2);" onClick="window.close();"><sub><img src="imgs/icons/ic_sair.gif" border="0" title=""></sub></a>&nbsp; 
                    </td>
               </tr>
           </table>
         </td>
      </tr> 
</table>
<table width="100%" height="2%" border="0"  bgcolor="#f2f2f2">
<tr  width="100%" height="1%">
  <td width="100%" style="border-top: 1px solid #34689A;"> &nbsp;
  <td>
</tr>
</table>
<table width="100%" height="10%" border="0"  bgcolor="#f2f2f2">
<tr>
  <td width="10%" style=""> 

<? if ($modeloR == 0) { ?>
<form name="pega_modelo" method="post" onSubmit='return valida()'>


	<input type="hidden" name="modelo" value="">
	<script>
		if (window.opener.document.getElementById('modelo1').checked)
			document.pega_modelo.modelo.value= '1';
		else if (window.opener.document.getElementById('modelo2').checked)
			document.pega_modelo.modelo.value= '2';
		else if (window.opener.document.getElementById('modelo3').checked)
			document.pega_modelo.modelo.value= '3';
		else if (window.opener.document.getElementById('modelo4').checked)
			document.pega_modelo.modelo.value= '4';
		else if (window.opener.document.getElementById('modelo5').checked)
			document.pega_modelo.modelo.value= '5';

		document.pega_modelo.submit();
	</script>

<? } 

if ($rodape=='true'){ ?>

    <p align="left">
  	<font style="font-family:times new roman,arial; font-size:32px;"><em>S</em></font><font style="font-family:times new roman,arial; font-size:18px;">imba</font>
        
  <?}?>



  <?if ($info_filtro=='true'){ ?>

<tr>
  <td  align=right>  
     <?
     $txtpesquisa="<tr><td align='left' class='texto'>".$txtpesquisa_rel;
     $txtpesquisa=str_replace("-","</td></tr><tr><td align='left' width='10%' class='texto'><b>",$txtpesquisa);
     $txtpesquisa=str_replace(":",":</b></td><td width='90%' class='texto'><font style='font-family:arial;font-weight:normal; font-size:12px;'>&nbsp;",$txtpesquisa);
     $txtpesquisa=$txtpesquisa."</font></td>";
      echo $txtpesquisa;

   ?>
  </td>

</tr>



<?}?>


<table width="100%" height="40%" valign="top" border="0" bgcolor="#f2f2f2" >


          <tr> 
          <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>

      <? 

	   while($row=$db->dados()) { 

 			set_time_limit(60);


                        echo '<tr><td width="10%" align="right" valign="top"><ol>';
                        echo '<font face="Arial, Helvetica, sans-serif" size="+1">'."1. ".'</td><td width="57%" valign="top">';    
			
 
			$obraID=$row[obra];
                        $seguro=$row[val_seguro];




                          $sqlAutor="SELECT a.*,b.atribuido from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) 
					where b.obra='$row[obra]' order by b.hierarquia";

                        $dbAutor->query($sqlAutor);
                        $titulo_etiq_ing='';
                        $medidas_ing=''; 
                        while($autor=$dbAutor->dados()) 
                        {

                            $atribuido="";
                            if ($autor[atribuido]=="S") { $atribuido=" (atribuído)";}
                                echo "<font style='font-family:arial,Helvetica, sans-serif; font-weight:normal; font-size:$tfa;'>$autor[nomeetiqueta]</font><font style='font-family:arial,Helvetica, sans-serif; font-weight:normal; font-size:$tf;'><i>$atribuido</i></font><br>";
		    		$nasc='';
                            
			    $sql= "SELECT nome from pais where pais = '$autor[pais_nasc]'";
			    $db2->query($sql);
			    $pais= $db2->dados();
			    $pais= $pais['nome'];
			    if (strtoupper($pais) == 'BRASIL') {
	                       $sql= "SELECT uf from estado where estado = '$autor[estado_nasc]'";
			       $db2->query($sql);
			       $estado= $db2->dados();
			       $estado= ", ".$estado['uf'];
			       $nasc.= $autor[cidade_nasc].$estado." ";
			    }else {
			      if ($autor[cidade_nasc]=='?' && $pais=='?')
			         $nasc.= "? ";
			      elseif ($row[cidade_nasc]==''&& $pais=='')
				     $nasc.= "";
				   else
				     $nasc.= $autor[cidade_nasc].", ".$pais." ";
			       }
                               if ($autor[dt_nasc_tp] == 'circa')$nasc.= " circa ";
			       if ($autor[dt_nasc_ano1] <> '0') {
			           $nasc.= $autor[dt_nasc_ano1];
			        }
				if ($autor[dt_nasc_ano2] <> '0') {
				   if ($autor[dt_nasc_ano2] <> $autor[dt_nasc_ano1])
				      $nasc.= " / ".$autor[dt_nasc_ano2];
				 }
				if ($autor[dt_nasc_tp] == '?')$nasc.=" (?) ";
				echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'><em>".$nasc."</em></font>";
			        $mort='';
				if ($autor[cidade_nasc] <> $autor[cidade_morte]) {
				   $sql= "SELECT nome from pais where pais = '$autor[pais_morte]'";
				   $db2->query($sql);
				   $pais= $db2->dados();
				   $pais= $pais['nome'];
				   if (strtoupper($pais) == 'BRASIL') {
				      $sql= "SELECT uf from estado where estado = '$autor[estado_morte]'";
				      $db2->query($sql);
				      $estado= $db2->dados();
				      $estado= ", ".$estado['uf'];
				      $mort.= $autor[cidade_morte].$estado." ";
				    }else {
				       if ($autor[cidade_morte]=='?' && $pais=='?')
				          $mort.= "? ";
					else
					  $mort.= $autor[cidade_morte].", ".$pais." ";
					}
				     }

				     if ($autor[dt_morte_tp] == 'circa') $mort.= " circa ";
				     if ($autor[dt_morte_ano1] <> '0') {
					$mort.= $autor[dt_morte_ano1];
				       }
				     if ($autor[dt_morte_ano2] <> '0') {
				        if ($autor[dt_morte_ano2] <> $autor[dt_morte_ano1])
					   $mort.= " / ".$autor[dt_morte_ano2];
					 }
				    	if ($autor[dt_morte_tp] == '?')$mort.=" (?) ";
					if (strlen($mort) > 3)
					   echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'> - <em>" . $mort . "</em></font>";
                                       
                                   }
				?>
        			<font style="font-size:10px;"><br><br><br>
        			</font><font style="font-family:times new roman,arial; font-weight:normal; font-size:$tf;"><em><? echo ret_colecao_obra($row[obra]); ?></em></font>
                                         </font>
        			<br>
        			<? echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>" ?><b><? echo $row[num_registro]; ?>
        			<? if ($row['eh_destaque_acervo'] == 'S') echo "<b><font style='color:maroon;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(destaque do acervo)</font>"; ?></b> <font style="font-size:8px;">
                                <br>
        			</font>
                                <font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'><b><? echo $row[titulo_etiq];?></b>
                                <?$titulo_etiq_ing=$row[titulo_ingles];
                                   $aquisicao_ing='';
                                   $dat_ing.= " circa "; 


                                      if ( trim($row[titulo_ingles])=='') {  $titulo_etiq_ing=$row[titulo_etiq];}

					$dataqui='';
                                                                      $dat_ing='';
                                                                      $aquisicao_ing='';
					if ($row['dt_aquisicao_tp'] == 'circa')
						$dataqui.= " circa ";

					if ($row['dt_aquisicao_ano1'] <> '0') {
						$dataqui.= $row['dt_aquisicao_ano1'];
					}
					if ($row['dt_aquisicao_ano2'] <> '0') {
						if ($row['dt_aquisicao_ano2'] <> $row['dt_aquisicao_ano1'])
							$dataqui.= " / ".$row['dt_aquisicao_ano2'];
					}

					if ($row['dt_aquisicao_tp'] == '?')
						$dataqui.=" (?) ";

					$aquisicao= strtolower(ret_aquisicao($row[forma_aquisicao]));
                                                                      $aquisicao_ing= strtolower(ret_aquisicao_ing($row[forma_aquisicao]));

					if ($row[periodo] <> '')
						echo ', '.$row[periodo];
					else
					$p_datas= ret_data_obra($row['obra']);
					$p_datas= explode("|",$p_datas);
					$p_data= $p_datas[0];
					$p_data_extra1= $p_datas[1];
					$p_data_extra2= $p_datas[2];
					$p_assinatura= $p_datas[3];

					$dat= '';
					if ($p_data_extra2 == 'circa')
						$dat.= " circa ";

					if ($p_data <> '0') {
						$dat.= $p_data;
					}
					if ($p_data_extra1 <> '0') {
						if ($p_data_extra1 <> $p_data)
							$dat.= " / ".$p_data_extra1;
					}

					if ($p_data_extra2 == '?')
						$dat.=" (?) ";

					if (strlen($dat) > 3)
						echo ", " . $dat;
                                                                    if ($traducao)$dat_ing =", ". $dat;

				?>
        			<br>
        <? if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0){
		echo $row[material_tecnica].", " . formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']). " x " . formata_valor_3($row['dim_obra_profund']) . " cm"; 
                            $material=$row[material_tecnica].", ";
                             $medidas_ing= formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']). " x " . formata_valor_3($row['dim_obra_profund']) . " cm"; 
                            
                 } else{
                      if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0){
		echo $row[material_tecnica].", ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm ; " . formata_valor_3($row['dim_obra_profund']) . " cm (profundidade)"; 
                            $material=$row[material_tecnica].", ";
                             $medidas_ing= "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm ; " . formata_valor_3($row['dim_obra_profund']) . " cm (profundidade)"; 
                       } else{
                            if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0){
		   echo $row[material_tecnica].", " . "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm";
                               $material=$row[material_tecnica].", " ;
                                $medidas_ing="&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm";
                            } else{
                                   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0){
		            echo $row[material_tecnica].", " . formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']). " cm"; 
                                        $material=$row[material_tecnica].", ";
                                         $medidas_ing= formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']). " cm"; 
                                    }else{
                                      if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0){
		                 echo $row[material_tecnica].", " . formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)";
                                             $material=$row[material_tecnica].", ";
                                              $medidas_ing= formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)";
                                       }else{
                                            if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0){
		                    echo $row[material_tecnica].", " . "&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)"; 
                                                $material=$row[material_tecnica].", " ;
                                                 $medidas_ing="&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)"; 
                                             } else{
                                               if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0){
		                      echo $row[material_tecnica].", " . "&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)"; 
                                                  $material=$row[material_tecnica].", ";
                                                  $medidas_ing= "&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)"; 
                                               } else{
                                                   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0){
		                         echo $row[material_tecnica].", " . formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)" ; 
                                                     $material=$row[material_tecnica].", ";
                                                      $medidas_ing= formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)" ; 
                                                   }else{
		                          echo $row[material_tecnica].", (ERRO - verificar dimensões na ficha técnica)"; 
                                                      $material=$row[material_tecnica].", ";
                                                       $medidas_ing="(ERRO - verificar dimensões na ficha técnica)"; 
                                                    }
                                                 }
                                             }
                                           }
                                         }
                                     }
                                }
                            
}
                                   
	?>
        <!--<br>fotografia, <? /*echo number_format($row['aimp_obra_altura'],1,",",".") . " x " . number_format($row['aimp_obra_largura'],1,",",".") . " cm(área impressa); " . ret_dim_parte($row['obra']); */ ?>-->
        <br>
        <?     

	


		if (trim($p_assinatura) == '') { echo "sem assinatura"; } else { echo "assinada <em>".$p_assinatura."</em>"; } 

			
		if ($aquisicao == ''){
			$aquisicao= 'procedência desconhecida';
                                          $aquisicao_ing= 'Origin unknown';
                               }
			echo "<br>".$aquisicao . ", " . $row['doador'];
                                          $aquisicao_ing=$aquisicao_ing . ", " . $row['doador'];		
                                         
		if (strlen($dataqui) > 3){
			echo ", " . $dataqui;
                                          $aquisicao_ing=$aquisicao_ing.", " .$dataqui;
                            }

	?>
        <br>














 <?
   
	$sql2="SELECT b.nome_arquivo,b.diretorio_imagem from fotografia_obra as a, fotografia as b where a.fotografia = b.fotografia
		AND a.obra = ".$obraID."  order by  a.eh_mini desc, a.eh_principal desc";
	$db4->query($sql2);
	$imagem=$db4->dados();
	$arquivo= $imagem['nome_arquivo'];
	$dir_img= $imagem['diretorio_imagem'];
        
        $noimage='';
	
	//
	// Para o teste - $arquivo vira lixo
	//

	//$arquivo="lixo.zzz";

	if ($arquivo == '')
		$arquivo= 'não tem imagem';

	if ($dir_img <> '') {
		$sql2="SELECT url from diretorio_imagem where diretorio_imagem = '$dir_img'";
		$db4->query($sql2);
		$url=$db4->dados();
		$url= $url['url'];
	}
	if (file_exists($dir.$url.'\\'.$arquivo)) {
		list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url.'/'.$arquivo);
		$Ao= $height;
		$Lo= $width;
		//100 é a altura max da área de exibição da imagem pequena; 150 é a largura máxima.//
		$num_alt= 150;
		$num_lar= 200;
		$cA= $Ao / $num_alt;
		$cL= $Lo / $num_lar;

		if ($Ao > $num_alt || $Lo > $num_lar) {
			if (cL < cA) {
				$percent= ($num_lar * 100) / $Lo;
				$Lo= $num_lar;
				$Ao= ($Ao * $percent) / 100;
				if ($Ao > $num_alt) {
					$percent= ($num_alt * 100) / $Ao;
					$Ao= $num_alt;
					$Lo= ($Lo * $percent) / 100;
				}
			} else {
				$percent= ($num_alt * 100) / $Ao;
				$Ao= $num_alt;
				$Lo= ($Lo * $percent) / 100;
				if ($Lo > $num_lar) {
					$percent= ($num_lar * 100) / $Lo;
					$Lo= $num_lar;
					$Ao= ($Ao * $percent) / 100;
				}
			}
		}

		$Ao2= $height;
		$Lo2= $width;
		//390 é a altura max da área de exibição da imagem grande; 520 é a largura máxima.//
		$num_alt= 390;
		$num_lar= 520;
		$cA= $Ao2 / $num_alt;
		$cL= $Lo2 / $num_lar;

		if ($Ao2 > $num_alt || $Lo2 > $num_lar) {
			if (cL < cA) {
				$percent= ($num_lar * 100) / $Lo2;
				$Lo2= $num_lar;
				$Ao2= ($Ao2 * $percent) / 100;
				if ($Ao2 > $num_alt) {
					$percent= ($num_alt * 100) / $Ao2;
					$Ao2= $num_alt;
					$Lo2= ($Lo2 * $percent) / 100;
				}
			} else {
				$percent= ($num_alt * 100) / $Ao2;
				$Ao2= $num_alt;
				$Lo2= ($Lo2 * $percent) / 100;
				if ($Lo2 > $num_lar) {
					$percent= ($num_lar * 100) / $Lo2;
					$Lo2= $num_lar;
					$Ao2= ($Ao2 * $percent) / 100;
				}
			}
		}

	} else {
		// imagem não disponível
		$Ao= 0;
		$Lo= 0;
		$Ao2= 0;
		$Lo2= 0;
	}



?>	
	
	
 	 <? if ($comimagem=='true'){
             if ($imagem<>'' && $noimage=='') { ?>
	  <td width="33%" valign="bottom" align="right"><img src="<? echo 'http://'.$_SERVER[SERVER_ADDR].'/donato/'.$dir_virtual.$url.'/'.combarra_encode($arquivo); ?>" height="<? echo $Ao; ?>" width="<? echo $Lo; ?>"></img></td>
            <? } else { 
			echo "<td width='33%' class='texto_bold' align='center' valign='middle' nowrap style='border: 1px dashed #ABABAB; color:#444444;'><sup>Imagem não disponível</sup></td>";
		   } }?> 
    
      <?

       $linhas=$linhas+$altCab;



if ($traducao=='true'){?>
     <tr><td width="10%">&nbsp</td><td width="85%">&nbsp</td></tr>
       <tr><td width="10%" valign="top"></td>
            <td width="85%" valign="top">
          <?$medidas_ing=formata_ing($medidas_ing);
              $parteass_ing=parte_ass_ing($row['obra']);?>

              <?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'><b>$titulo_etiq_ing</b>$dat_ing</font>"?><br>
              <?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$material</font>"?>                
              <?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$medidas_ing</font>"?><br>              
              <?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$parteass_ing<br></font>"?>
              <?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$aquisicao_ing<br><br></font>"?>

        </td></tr>

<?}?>


      <? if ($modeloR<>'1') {                   
          if ($modeloR=='2'  || $modeloR=='4'){
             if ($row['desc_conteudo'] <> '')  {
   		   echo "<tr><td width='10%'></td><td width='90%'><font style='font-family:arial; font-weight:normal; font-size:$tf;'><br><em><b>DESCRIÇÃO:<br></em></b>" . $row['desc_conteudo'] . "<br></em></font></td></tr>";
                   if ($linhas + ((strlen($row['desc_conteudo'])/100)+2)>70) {
			$linhas=((strlen($row['desc_conteudo'])/100)+2)-(70-$linhas);
			if ($linhas<1) {
				$linhas=1;
			}
                   } else {
			$linhas=$linhas + ((strlen($row['desc_conteudo'])/100)+1);
                   }
	     }
	  }
          if ($modeloR=='4'){ 
               
             $sqlex="SELECT b.exposicao, a.premio,b.* from obra_exposicao as a inner join exposicao as b on (a.exposicao=b.exposicao)   where a.obra=$row[obra] order by a.exposicao asc";
	     $db2->query($sqlex);
	     $exposicao= "";
	     $linhas=$linhas+2;
	     echo "<tr><td width='10%'></td><td width='90%' align='left'><font style='font-family:arial; font-weight:normal; font-size:$tf;'><br><em><b>EXPOSIÇÕES:<br></em></b></font></td></tr>";
	     while ($exp=$db2->dados()){
                if ($exp['exposicao']<>''){  
                   $pais=$exp['pais'];
	           $sqlPais="select nome from pais where pais=$pais";
	           $db3->query($sqlPais);
	           $dados=$db3->dados();
	           $pais=$dados['nome'];
	           $exposicao = "<b>"."- ".$exp['nome']."</b>". ",&nbsp;" . $exp['instituicao'] . ",&nbsp;" .$exp['cidade'].$estado.", &nbsp;". $pais.". &nbsp;".$exp['periodo'] . ".&nbsp;" ."<em>".$exp['premio']. "</em><br>";
		   echo "<tr><td width='10%'></td><td width='90%' align='left'><font style='font-family:arial; font-weight:normal; font-size:$tf;'>".$exposicao."</font></td></tr>";
	         }
              }
	      //if ($exposicao <> '')  echo "<font style='font-family:arial; font-weight:normal; font-size:$tf;'><br><em><b>EXPOSIÇÕES:<br></em></b>" . $exposicao . "</font>";	       
           }       
           if ($modeloR=='3'  || $modeloR=='4'){ 
                 
              $sql="SELECT b.bibliografia, b.referencia,b.autoria,b.sub_titulo,b.local,b.editora,b.notas,a.observacao,b.ano from obra_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
	            where a.obra=$row[obra] order by b.ano asc";
	      $db2->query($sql);
	      $bibliografia= "";
	      $linhas=$linhas+2;
	      echo "<tr><td width='10%'></td><td width='90%' align='left'><font style='font-family:arial; font-weight:normal; font-size:$tf;'><em><b><br>REFERÊNCIAS BIBLIOGRÁFICAS:<br></b></em></font></td></tr>";
	      while ($bib=$db2->dados()){
                 if ($bib['bibliografia'] <>'' ){
                   $ano_bib= $bib['ano'];
	            if ($ano_bib == 0)
	               $ano_bib= 's/d';
                   $sub_tit_bib= $bib['sub_titulo'];
	            if ($sub_tit_bib != '')
	               $sub_tit_bib= $bib['sub_titulo'].". ";
                   $notas_bib= $bib['notas'];
	            if ($notas_bib != '')
	               $notas_bib= $bib['notas'].". ";
		    $bibliografia = "- ".$bib['autoria'].". <b><em>".$bib['referencia'] ."</em></b>. ".$sub_tit_bib .$bib['local'].": ".$bib['editora'].", ".$ano_bib.". ".$notas_bib.$bib['observacao'].  ". <br>";
                    echo "<tr><td width='10%'></td><td width='90%' align='left'><font style='font-family:arial; font-weight:normal; font-size:$tf;'>".$bibliografia."</font></td></tr>";
	          }
	      }
 	      echo "</font>";
	      //if ($bibliografia <> '') echo "<font style='font-family:arial; font-weight:normal; font-size:$tf;'><em><b><br>REFERÊNCIAS BIBLIOGRÁFICAS:<br></b></em>" . $bibliografia . "</font>";

              if ($row['texto_etiq'] <> '') {
			echo "<tr><td width='10%'></td><td width='90%' align='left'><font style='font-size:8px;'><br><br></font><font style='font-family:times new roman,arial; font-weight:normal; font-size:14px;'><em>" . $row['texto_etiq'] . "<br></em></font></td></tr>";
	      }
            

            }
            if ($modeloR=='5'){                     
	       if ($seguro <> ''){
                  	echo "<tr><td width='10%'></td><td width='90%' align='left'><font style='font-family:arial; font-weight:normal; font-size:$tf;'><em>Valor do Seguro:" ."&nbsp;". $seguro . "</em></font></td></tr>";

	        }
            }
         }
                      
          ?>
         </font>
    </td>
  </tr>
<tr><td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;">&nbsp;</tr>

  <? } ?>
</table>
<?


  if ($rodape=='true'){ ?>
        <table width="95%"  border="0" bgcolor="#f2f2f2" >
           <tr width="95%">
            <td  width="30%" align="right"> <font style='font-family:arial,times new roman; font-weight:bold; font-size:10px;'><? echo $total;?> obra(s)</font></td>
            <td width="35%" align="center"><font style='font-family:arial,times new roman; font-weight:bold; font-size:10px;'><? echo percente_obras($total); ?> % do acervo</font></td>
            <td  width="30%" align="left">  <font style='font-family:arial,times new roman; font-weight:bold; font-size:10px;'>Final de relatório</font></td>
          </tr>
        </table>
        <table width="95%"  border="0" bgcolor="#f2f2f2" >
         <tr width="95%">
          <td width="95%" align="center"><font style='font-family:arial,times new roman; font-weight:normal; font-size:10px;'><em>Impresso por <? echo $_SESSION['snome']; ?> em <? echo date("d/m/Y"); ?> </em></font></td>
         </tr>
       </table>
   <?} ?>
    </form>
   </td>
   </tr>
  </table>

</td>
</tr>
</table>
</body>

 