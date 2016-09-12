<? include_once("seguranca.php") ?>
<html>

<head>



<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>

<script>
function valida() {
	for (i=0; i<document.form1.length; i++) {
		var tempobj= document.form1.elements[i];
		if (tempobj.type=='text' && tempobj.value!='') {
			return true;
		}
	}
	if (document.form1.prazo.checked || document.form1.ausente.checked)
		return true;
	alert('Informe pelo menos um parâmetro.');
	return false;
}

function abrepopExposicao(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-200)+',top='+((window.screen.height/2)-200)+',width=550,height=350, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
  }
return true;
}


</script>  

</head>

<body>
<table width="100%"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="100%" scope="col"><div align="left" class="tit_interno">


       <?
	include("classes/classe_padrao.php");
        include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();
        $db1=new conexao();
        $db1->conecta();
        $db2=new conexao();
        $db2->conecta();
        montalinks();
        $_SESSION['lnk']=$link;
        $id=$_REQUEST['expid'];
        $tipo="obra";
        $selecao=$_REQUEST['selecao']; 
        $nome=$_REQUEST['nome'];
        $instituicao=$_REQUEST['instituicao'];
        $idexposicao=$_REQUEST['idexposicao'];
        $op=$_REQUEST['op']; 
        $acao=$_REQUEST[acao];
        if ($acao==1) {
		$nome=$_SESSION[par1];
                $selecao=$_SESSION[par2];
                $idexposicao=$_SESSION[par3];
	} else {
		$_SESSION[par1]=$_REQUEST[nome];
                $_SESSION[par2]=$_REQUEST[selecao];
                $_SESSION[par3]=$_REQUEST[idexposicao];
        }	
        if ($selecao=='') {$selecao='2';}           
        ?>
 

        <?
	/////Paginando
	$pagesize=5;
        $page=1;

        if(!empty($_GET['page']))
            $page=$_GET['page'];
        $page--;

	$registroinicial=$page* $pagesize;


        // filtra pela string digitada no campo referência - campo na tabela nome 
       

          if ( strtoupper(trim($instituicao)) <>'' )
          {
	   $instituicao = "".trim($instituicao).""; 
           $instituicao1=$instituicao;             
           $whereinstituicao="a.instituicao like '%$instituicao%' and ";
           $whereinstituicaoCount="instituicao like '%$instituicao%' and ";
          } else {
           $whereInstituicao="";
           $whereInstituicaoCount="";
          }
        


 	if ( strtoupper(trim($nome)) <>'' ) 
        { 
	   $nome = "".trim($nome).""; 
           $nome1=$nome;             
           $whereNome="a.nome like '%$nome%' and ";
           $whereNomeCount="nome like '%$nome%' and ";
        }else {
	      $whereNome="";
              $whereNomeCount="";
          }
	
  
 	if ( strtoupper(trim($idexposicao)) <>'' ) 
        { 
	   $idexposicao = "".trim($idexposicao).""; 
           $idexposicao1=$idexposicao;             
           $whereExposicao="a.exposicao=".$idexposicao." and ";
           $whereExposicaoCount="exposicao=".$idexposicao." and ";
        }else {
	   $whereExposicao="";
           $whereExposicaoCount="";
	} 


        if ($selecao == 1) {
		$sql="SELECT count(*) as total 
                        FROM exposicao 
                        WHERE ".$whereNomeCount.$whereExposicaoCount.$whereinstituicaoCount."(exposicao not in (select exposicao from obra_exposicao) and
                                                exposicao not in (select exposicao from autor_exposicao) and exposicao not in (select exposicao from movimentacao_exposicao))";
        }       
        if ($selecao == 2) {
                $sql="SELECT count(*) as total 
                      FROM exposicao 
                      WHERE ".$whereNomeCount.$whereExposicaoCount.$whereinstituicaoCount."(exposicao in (select exposicao from obra_exposicao) or
                                              exposicao in (select exposicao from autor_exposicao) or exposicao in (select exposicao from movimentacao_exposicao))";
        }
 	if ($selecao == 3) {
                $sql="SELECT count(*) as total 
                        FROM exposicao where ".$whereNomeCount.$whereExposicaoCount.$whereinstituicaoCount." 1=1";
      
        
        }

        

	$db->query($sql);
	$numlinhas=$db->dados();
        $numlinhas=$numlinhas[0];
	 
 	 
        if ($selecao == 1) {
                $sql2="SELECT DISTINCT substring(a.dt_inicial,1,4) as datainicial, a.exposicao as expid,a.tipo,a.nome,a.instituicao,a.periodo,a.cidade,a.estado,a.pais 
                         FROM exposicao as a  
                        WHERE ".$whereNome.$whereExposicao.$whereinstituicao."(exposicao not in (select exposicao from obra_exposicao) and
                                            exposicao not in (select exposicao from autor_exposicao) and exposicao not in (select exposicao from movimentacao_exposicao))               
                     ORDER BY dt_inicial LIMIT $registroinicial,$pagesize";
        }
        if ($selecao == 2) {
                $sql2="SELECT DISTINCT substring(a.dt_inicial,1,4) as datainicial, a.exposicao as expid,a.tipo,a.nome,a.instituicao,a.periodo,a.cidade,a.estado,a.pais 
                         FROM exposicao as a 
                        WHERE ".$whereNome.$whereExposicao.$whereinstituicao."(exposicao in (select exposicao from obra_exposicao) or
                                            exposicao in (select exposicao from autor_exposicao) or exposicao in (select exposicao from movimentacao_exposicao))
                     ORDER BY dt_inicial LIMIT $registroinicial,$pagesize";


        }
        if ($selecao == 3) {
                $sql2="SELECT DISTINCT substring(a.dt_inicial,1,4) as datainicial, a.exposicao as expid,a.tipo,a.nome,a.instituicao,a.periodo,a.cidade,a.estado,a.pais 
                         FROM exposicao as a Where ".$whereNome.$whereExposicao.$whereinstituicao." 1=1 ORDER BY dt_inicial LIMIT $registroinicial,$pagesize";
    }
	$db->query($sql2);
   
        ?>	



<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {     
var i = qual.value;
document.location=('exposicao_manut.php?page='+ i+ '&nome=<?echo $nome?>&selecao=<?echo $selecao?>&idexposicao=<?echo $idexposicao?>&instituicao=<?echo $instituicao?>');


}}
function posiciona(valor) {
var i = valor;
document.location=('exposicao_manut.php?page='+ i+ '&nome=<?echo $nome?>&selecao=<?echo $selecao?>&idexposicao=<?echo $idexposicao?>&instituicao=<?echo $instituicao?>');
}

</script>

<body>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="8">
       <tr>
         <td valign="top"><form name="form1" method="get" onSubmit='true' action="exposicao_manut.php">

                 <tr>
                     <td colspan="0" class="texto_bold" nowrap>Seleção 
                        <select name="selecao" class="combo_cadastro" id="selecao" value="<?$_REQUEST['selecao'];?>">
                          <option value="1"<?if ($selecao==1) echo "selected";?>>sem associação</option>
                          <option value="2"<?if ($selecao==2) echo "selected";?>>com associação</option>
                          <option value="3"<?if ($selecao==3) echo "selected";?>>todos</option>
                         </select>
                      </td>


                         <td class="texto_bold">Instituição:&nbsp;<input name="instituicao" type="text" class="combo_texto" size="43" value="<?echo $instituicao;?>"> 
                         </td>

                      <tr>
                         <td 
                            class="texto_bold">Nº exposição:&nbsp;<input name="idexposicao" type="text" class="combo_texto" size="5" value="<?echo $idexposicao;?>"> 
                         </td>

                         <td class="texto_bold">Nome:&nbsp;<input name="nome" type="text" class="combo_texto" size="43" value="<?echo $nome;?>"> 
                            &nbsp;<input name="submit" type="submit" class="combo_cadastro" value=" Ok " style="cursor: pointer; border-width: 1px;">  
                         </td>
                     </tr>

                     <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">

                       <tr bgcolor="#96ADBE">
                          <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
                       </tr>
                       <tr whidth=100% bgcolor="#ddddd5">
                          <td width="80%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Exposições </div></td>
		       </tr>
                       <tr>
                          <td colspan="3" whidth=100% height="2" bgcolor="#000000" ><img src="imgs/transp.gif" width="100" height="1"></td>
                       </tr>

                    </table>  
                      
                    <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >   


	               <? if ($selecao == "")
                           $selecao='1';
                        ?>
                 
			 <? while($row=$db->dados())
	                    {                          
	                     $sql3="select nome from pais where pais='".$row[pais]."'";
                             $db1->query($sql3);
	                     $pais=$db1->dados();
                             $nome_pais=$pais[nome];

	                     $sql4="select uf from estado where estado='".$row[estado]."'";
	                     $db1->query($sql4);
	                     $estado=$db1->dados();
                             $nome_estado=$estado[uf];

			     $sql5="SELECT count(*) as totobra FROM exposicao as a INNER JOIN  obra_exposicao as b on (a.exposicao=b.exposicao) INNER JOIN obra as c on (b.obra=c.obra) where a.exposicao='".$row['expid']."' order by a.periodo, a.nome";
	             
                                  $db2->query($sql5);
	                     $totobra=$db2->dados();
                             $tobra=$totobra[totobra];

			     $sql6="SELECT count(*) as totautor FROM exposicao as a INNER JOIN  autor_exposicao as b on (a.exposicao=b.exposicao) INNER JOIN autor as c on (b.autor=c.autor) where a.exposicao='".$row['expid']."' order by a.periodo, a.nome";
	       
                                      $db2->query($sql6);
	                     $totautor=$db2->dados();
                             $tautor=$totautor[totautor];

			     $sql6="SELECT count(*) as totmovimento FROM exposicao as a INNER JOIN  movimentacao_exposicao as b on (a.exposicao=b.exposicao) INNER JOIN movimentacao as c on (b.movimentacao=c.movimentacao) where a.exposicao='".$row['expid']."' order by a.periodo, a.nome";
	       
                                      $db2->query($sql6);
	                     $totmovimento=$db2->dados();
                             $tmovimento=$totmovimento[totmovimento];
 	                 ?>
                         <tr class="texto">
                            <td width="100%"></td>
                            <td width="10%"></td>
                            <td width="5%"></td>
                            <td width="5%"></td>
                        </tr>
   
                                    
                          <tr class="texto" id="cor_fundo">
                            <td whith="100%">
		               <b><? echo "(".$row['expid'].") - ";?></b><?

                                  if ( $row['datainicial'] == '0000') {  echo "<b>s/d</b>";}else{echo "<b>".$row['datainicial']."</b>";}            

 		                  echo "<b>"." - ". $row['nome'].", "."</b>".$row['instituicao'].", ".$row['cidade'].", ";
		                  if (strtoupper($nome_pais)=="BRASIL") {
			          echo $nome_estado.", ";
                                   }
		                  echo $nome_pais.", ".$row['periodo'].". "."<em>";
                                  echo  "<font color='brown'>".$row['premio']; 
                                   $explist=$row['expid'];
                                   $frase1='Editar&nbsp;exposição&nbsp;';
                                   $pageID=$page+1;
				?>
                                   

                                <td align="left"><? echo "<a href=\"exposicao_manut_exibe.php?id=".$row[expid]."&page".$pageID."\">
			           <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt=$frase1$explist 
				   onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
				   onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		                 </td>
                               
                              <td 
                                 <?  
                                    if($tobra>1)  {$frase='&nbsp;obras&nbsp;relacionadas';} 
                                    if ($tobra==1){$frase='&nbsp;obra&nbsp;relacionada';}
                                    if($tobra<1)  {$tobra='';$frase='nenhuma&nbsp;obra&nbsp;relacionada';} 
										
                                 ?>

                                 align="left"><? echo "<a href=\"exposicao_manut_detobra.php?id=".$row[expid]."\">
			        <img src='imgs/icons/lista_obra.gif' width='17' height='20'border='0' alt=$tobra$frase 
				onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
				onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		             </td>

                            <td
                                <?  
                                    if ($tautor>1) {$frase='&nbsp;autores&nbsp;relacionados';} 
                                    if ($tautor==1) {$frase='&nbsp;autor&nbsp;relacionado';}
                                    if ($tautor<1)  {$tautor='';$frase='nenhum&nbsp;autor&nbsp;relacionado';}

                                 ?>

                                align="center"><? echo "<a href=\"exposicao_manut_detautor.php?id=".$row[expid]."\">
			        <img src='imgs/icons/lista_autor.gif' width='17' height='20'border='0' alt=$tautor$frase 
				onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
				onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		             </td>
                              </td>
                            <td
                                <?  
                                    if ($tmovimento>1) {$frase='&nbsp;movimentacoes&nbsp;relacionados';} 
                                    if ($tmovimento==1) {$frase='&nbsp;movimento&nbsp;relacionado';}
                                    if ($tmovimento<1)  {$movimento='';$frase='nenhum&nbsp;movimento&nbsp;relacionado';$tmovimento="";}

                                 ?>

                                align="center"><? echo "<a href=\"exposicao_manut_detmov.php?id=".$row[expid]."\">
			        <img src='imgs/icons/lista_mov.gif' width='17' height='20'border='0' alt=$tmovimento$frase 
				onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
				onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		             </td>
                              </td>
                             
                             <?if ($selecao=="1") { ?>
                                <td colspan=0 align="center"><? echo "<a href=\"exposicao_manut1.php?op=delexp&id=".$row[expid]."\"
				   onClick='return confirm(".'"a exposição será excluída definitivamente. Confirma a exclusão ?"'.")'><img src='imgs/icons/ic_excluir.gif' border='0' alt='exclusão' 
				   onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
				   onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		                </td> <?}?>


                         </tr>
		      <? } ?>
                      <tr class="texto">
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                         <td align="center">&nbsp;</td>
                      </tr>

                      <tr class="texto">
 
                         <?if ($selecao=="1") { ?>
                            <td colspan="2"><? echo "<a href=\"exposicao_manut1.php?op=del&nome=".$nome1."\" onClick='return confirm(".'"Confirma Exclusão dos Registros ?"'.")'>
	         	    <img src='imgs/icons/ic_excluir.gif' width='20' height='20' border='0' alt='Excluir todas as exposiçoes sem associação relacionadas acima'>";?></td>
                            <td></td>
                            <td align="center">&nbsp;</td>
                         <?}?>
                            <td align="center">&nbsp;</td>

                      </tr>
   




                      <tr>
                         <td height="1" colspan="6" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
                      </tr>
                      <tr whidth="100%" class="texto">
                         <td align="left" whidth="100%" border="0" colspan="5" height="10">
                         		  

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

                          
                         $a="<a href=\"exposicao_manut.php?page=".$first."&exposicao=".$id."&selecao=".$selecao."&nome=".$nome."&idexposicao=".$idexposicao."&instituicao=".$instituicao."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";
                         $b="<a href=\"exposicao_manut.php?page=".$menos."&exposicao=".$id."&selecao=".$selecao."&nome=".$nome."&idexposicao=".$idexposicao."&instituicao=".$instituicao."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";
                         $c="<a href=\"exposicao_manut.php?page=".$mais."&exposicao=".$id."&selecao=".$selecao."&nome=".$nome."&idexposicao=".$idexposicao."&instituicao=".$instituicao."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";
                         $d="<a href=\"exposicao_manut.php?page=".$last."&exposicao=".$id."&selecao=".$selecao."&nome=".$nome."&idexposicao=".$idexposicao."&instituicao=".$instituicao."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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

		            $g= " Total de registros encontrados: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
			    ".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
			    echo"&nbsp";

                            echo"<font color='003366'>$g</font>";   
                           ?>
                       <div align="center"></div></td>
                           
                   </tr>
                   <tr>
                      <td height="2" colspan="6" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
                   </tr>
                   <tr>
                      <td colspan="4"></td>
                   </tr>
              </table>
             </form>
          </td>
        </tr>
     </table>
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