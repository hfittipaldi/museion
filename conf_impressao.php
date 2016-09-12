<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

<script language="JavaScript">

function abrepop2(janela,alt,larg) {
	
	win=window.open(janela,'impressao','left=4000,top=4000,width=1,height=5, menubar=none, toolbar=none, scrollbars=none, resizable=true');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
 }

function abrepop3(janela,alt,larg) {
	
	win=window.open(janela,'impressao','left=4000,top=4000,width=1,height=5, menubar=none, toolbar=none, scrollbars=none, resizable=none');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
 }


function abrepop4(janela,alt,larg) {
	
	win=window.open(janela,'impressao','left=4000,top=4000,width=1,height=5, menubar=none, toolbar=none, scrollbars=none, resizable=none');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
 }




function AtualizaAte(valor) {

   document.getElementById("ate").value=valor;
   return true;

}

</script>

</head>
<?
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");

	$db=new conexao();
	$db->conecta();   
	$dbdir=new conexao();
	$dbdir->conecta();   
	

        $dir_virtual = diretorio_virtual();
        $txtpesquisa = $_REQUEST[pesquisa];
                $num = $_REQUEST[num];
            $usuario = $_REQUEST[usuario];
              $tfont = $_REQUEST[tfont];
             $tfonta = $_REQUEST[tfonta];
                 $de = $_REQUEST[de];
                $ate = $_REQUEST[ate];
     $txtpesquisa_rel= $_REQUEST[txtpesquisa_rel];
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
?>

<body>
  <form name="form1" method="post" action="">              
     <table width="100%" border="0" height="100%" >  
        <tr>
           <td>
              <tr>
               <td width="100%" height="60%" valign="top" style="border-top: 1px solid #34689A;border-left: 1px solid #34689A;border-right: 1px solid #34689A;" >
                 <table width="100%" height="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                    <tr width="100%"><br><br>
                       <td width="43%" >
                          <div align="center">  <?if ($de=='')$de=1;?>                             
                            <span class="texto_bold">&nbsp;da página <input type="text" name="de" id="de" value="<?echo $de;?>" size="5"> até a página <input type="text" name="ate" id="ate" value="<?echo $ate;?>" size="5"><? echo " de ".$_SESSION['paginas']; ?></span>
                          </div>
                       </td>
                    </tr>
                 </table>
                </td>
             </tr>
             <tr>
                <td width="100%" height="40%" valign="top" style="border-bottom: 1px solid #34689A;border-left: 1px solid #34689A;border-right: 1px solid #34689A;" >
                   <table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#ffffff" >
                      <tr>
                         <td width="100%" height="50%" valign="top" align="center">
                            <input name="salvar" type="submit" class="botao" id="salvar" value="Salvar/Imprimir" onClick="imprime()">&nbsp;&nbsp;&nbsp;
                            <input name="cancelar" type="submit" class="botao" id="cancelar" value="Cancelar">
                          </td>
                      </tr>
                   </table>
                </td>
             </tr>
             <?if (isset($_SESSION['paginas'])) {echo "<script>AtualizaAte('".$_SESSION['paginas']."');</script>";}
	          if (!isset($_SESSION['paginas'])) {                   
		      echo "<script>abrepop2('pre_impressao_obras.php?txtpesquisa_rel=$txtpesquisa_rel&modelo=$modeloR&totpag=$_SESSION[paginas]&ultpag=1&info_filtro=$info_filtro&total=$total&de=$de&ate=$ate&traducao=$traducao&rodape=$rodape&modelo2=false&comimagem=$comimagem&distancia=2');</script>";		
	           } else {	
		     //echo "<script>AtualizaAte('".$_SESSION['paginas']."');</script>";	
                      if ($_SESSION['download']<>''){
                       //  echo "<script>abrepop2('pre_impressao_obras.php?txtpesquisa_rel=$txtpesquisa_rel&modelo=$modeloR&totpag=$_SESSION[paginas]&ultpag=1&info_filtro=$info_filtro&total=$total&de=$de&ate=$ate&traducao=$traducao&rodape=$rodape&modelo2=false&comimagem=$comimagem&distancia=2');</script>";		
                       }
	           }?>
                <tr><td width="100%" align="left" class="texto_bold" id="hint1"><font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;color:brown;'><i>Download do relatório em HTML gerado de acordo com a seleção acima.</i></font></td></tr>           
              </td>
            </tr>
         </table>
      </form>
   </body>
<?


if ($_REQUEST[salvar]<>''){

  // echo "<script>location.href='download_relatorio.php?num=$num&usuario=$usuario&txtpesquisa_rel=$txtpesquisa_rel&modelo=$modeloR&ultpag=0&info_filtro=$info_filtro&total=$total&de=$de&ate=$ate&rodape=$rodape&modelo2=false&comimagem=$comimagem&traducao=$traducao&tridimencional=$tridimencional&tfa=$tfonta&tf=$tfont&distancia=2'</script>";    

 }
?>

</html>

