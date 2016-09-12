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

</script>  


</head>

<body>
<table width="100%"  border="1" align="left" cellpadding="0" cellspacing="0" bgcolor=#f2f2f2>
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
        $autoria=$_REQUEST['autoria'];
        $idbibliografia=$_REQUEST['idbibliografia']; 
        $op=$_REQUEST[op]; 
        $acao=$_REQUEST[acao];
        if ($acao==1) {
		$nome=$_SESSION[par1];
                $selecao=$_SESSION[par2];
                $idbibliografia=$_SESSION[par3];
	} else {
		$_SESSION[par1]=$_REQUEST[nome];
                $_SESSION[par2]=$_REQUEST[selecao];
		$_SESSION[par3]=$_REQUEST[idbibliografia];
        }	
        if ($selecao=='') {$selecao='2';}           
        ?>
 
<script>
function abrepopBibliografia(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-200)+',top='+((window.screen.height/2)-200)+',width=550,height=300, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
  }
return true;
}


</script>  
        <?
         /////Paginando
        $pagesize=5;
        $page=1;
        if(!empty($_GET['page']))
            $page=$_GET['page'];
        $page--;
	$registroinicial=$page* $pagesize;

         $wheregeral='';
        // filtra pela string digitada no campo referência - campo na tabela referencia 
     
         if ( strtoupper(trim($autoria)) <>'' ) 
        { 
	   $autoria = "".trim($autoria).""; 
           $autoria1= $autoria;            
           $whereAutoria="a.autoria like '%$autoria%' and ";
           $whereAutoriaCount="autoria like '%$autoria%' and ";
        }else {
	   $whereAutoria="";
           $whereAutoriaCount="";
	} 

if  ($whereAutoria<>'') $wheregeral=$wheregeral. $whereAutoria;
  
          if ( strtoupper(trim($nome)) <>'' ) 
          { 
           $nome = "".trim($nome).""; 
           $nome1= $nome;            
           $whereNome="a.referencia like '%$nome%' and ";
           $whereNomeCount="referencia like '%$nome%' and ";
           }else {
	   $whereNome="";
           $whereNomeCount="";
	} 

            if ( $whereNome <> '') $wheregeral=$wheregeral.$WhereNome;

 	if ( strtoupper(trim($idbibliografia)) <>'' ) 
        { 
	   $idbibliografia = "".trim($idbibliografia).""; 
           $idbibliografia1=$idbibliografia;             
           $wherebibliografia="a.bibliografia=".$idbibliografia." and ";
           $wherebibliografiacount="bibliografia=".$idbibliografia." and ";
        }else {
	   $wherebibliografia="";
           $wherebibliografiacount="";
	} 

        if ( $wherebibliografia <> '') $wheregeral=$wheregeral.$wherebibliografia;

                $wheregeral='';
                $autoria1= " autoria like '%".$autoria."%' AND";
                $nome1= " referencia like '%".$nome."%' AND";
                $idbibliografia1= " bibliografia like '%".$idbibliografia."%' AND";
                
                $wheregeral=$autoria1.$nome1.$idbibliografia1; 
 

      
        if ($selecao == 1) {
		$sql="SELECT count(*) as total 
                        FROM bibliografia 
                        WHERE ".$wheregeral."(bibliografia not in (select bibliografia from obra_bibliografia) and
                                                bibliografia not in (select bibliografia from autor_bibliografia))";

        }       
        if ($selecao == 2) {
                $sql="SELECT count(*) as total 
                      FROM bibliografia 
                      WHERE ".$wheregeral."(bibliografia in (select bibliografia from obra_bibliografia) or
                                              bibliografia in (select bibliografia from autor_bibliografia))";

        }
               
 	if ($selecao == 3) {
    
                $wheregeral='';
                $autoria1= " autoria like '%".$autoria."%' AND";
                $nome1= " referencia like '%".$nome."%' AND";
                $idbibliografia1= " bibliografia like '%".$idbibliografia."%'";
                
                $wheregeral=' Where '.$autoria1.$nome1.$idbibliografia1; 


                $sql="SELECT count(*) as total FROM bibliografia ".$wheregeral;

        }

       

	$db->query($sql);
	$numlinhas=$db->dados();
        $numlinhas=$numlinhas[0];
	 
                 $wheregeral='';
                $autoria1= " autoria like '%".$autoria."%' AND";
                $nome1= " referencia like '%".$nome."%' AND";
                $idbibliografia1= " bibliografia like '%".$idbibliografia."%' AND";
                
                $wheregeral=$autoria1.$nome1.$idbibliografia1; 
	 
        if ($selecao == 1) {

  
                $sql2="SELECT a.bibliografia as expid, a.referencia, a.sub_titulo, a.local, a.editora, a.ano, a.autoria, a.notas
                         FROM bibliografia as a  
                        WHERE ".$wheregeral."(bibliografia not in (select bibliografia from obra_bibliografia) and
                                            bibliografia not in (select bibliografia from autor_bibliografia))               
                     ORDER BY bibliografia, referencia LIMIT $registroinicial,$pagesize";
    
        }
        if ($selecao == 2) {
   
  
                $sql2="SELECT a.bibliografia as expid,a.referencia, a.ano, a.autoria, a.sub_titulo, a.local, a.editora, a.notas
                         FROM bibliografia as a 
                        WHERE ".$wheregeral."(bibliografia in (select bibliografia from obra_bibliografia) or
                                            bibliografia in (select bibliografia from autor_bibliografia))
                     ORDER BY bibliografia, referencia LIMIT $registroinicial,$pagesize";
             
        }
        if ($selecao == 3) {

                $wheregeral='';
                $autoria1= " autoria like '%".$autoria."%' AND";
                $nome1= " referencia like '%".$nome."%' AND";
                $idbibliografia1= " bibliografia like '%".$idbibliografia."%'";
                
                $wheregeral=' Where '.$autoria1.$nome1.$idbibliografia1; 

                $sql2="SELECT a.bibliografia as expid,a.referencia, a.ano, a.autoria, a.sub_titulo, a.local, a.editora, a.notas
                         FROM bibliografia as a  ".$wheregeral." 
                   ORDER BY bibliografia, referencia LIMIT $registroinicial,$pagesize";
                
         }
       $db->query($sql2);

        ?>	



<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {     
var i = qual.value;
document.location=('bibliografia_manut.php?page='+ i+ '&autoria=<? $autoria?>&nome=<?echo $nome?>&selecao=<?echo $selecao?>&idbibliografia=<?echo $idbibliografia?>');


}}

function posiciona(valor) {
var i = valor;
document.location=('bibliografia_manut.php?page='+ i+ '&autoria=<?echo $autoria?>&nome=<?echo $nome?>&selecao=<?echo $selecao?>&idbibliografia=<?echo $idbibliografia?>');
}

</script>

<body>
      <table  width="100%" height="20"  border="0" cellpadding="0" cellspacing="8">
        <tr bgcolor="#ddddd5">
          <td  whidth="100%" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="195%"  height="1"></td>
        </tr>  

       <tr>
         <td width="100%" valign="top">
            <form name="form1" method="get" onSubmit='true' action="bibliografia_manut.php">
              <tr width="100%">
                 <td  width="100%" class="texto_bold" nowrap>&nbsp;Seleção 
                        <select name="selecao" class="combo_cadastro" id="selecao" value="<?$_REQUEST['selecao'];?>">
                          <option value="1"<?if ($selecao==1) echo "selected";?>>sem associação</option>
                          <option value="2"<?if ($selecao==2) echo "selected";?>>com associação</option>
                          <option value="3"<?if ($selecao==3) echo "selected";?>>todos</option>
                         </select>
                  </td>

                      <td class="texto_bold">Autoria:&nbsp;<input name="autoria" type="text" class="combo_texto" size="34" value="<?echo $autoria;?>"> 
                      </td> 
               </tr>
               <tr>
                     <td  class="texto_bold">&nbsp;Nº da bibliografia:&nbsp;<input name="idbibliografia" type="text" class="combo_texto" size="7" value="<?echo $idbibliografia;?>"> 
                      </td>
                       
                       <td class="texto_bold">Referência:&nbsp;<input name="nome" type="text" class="combo_texto" size="22" value="<?echo $nome;?>"> &nbsp;<input name="submit" type="submit" class="combo_cadastro" value=" Ok " style="cursor: pointer; border-width: 1px;">  
                       </td>
                 </tr>
                     <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">

                       <tr bgcolor="#96ADBE">
                          <td whidth=100%   bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="200%" height="1"></td>
                       </tr>
                       <tr whidth=100% bgcolor="#ddddd5">
                          <td width="50%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Bibliografia </div></td>
		       </tr>
                       <tr>
                          <td  whidth=100% height="2" bgcolor="#000000" ><img src="imgs/transp.gif" width="200%" height="1"></td>
                       </tr>

                    </table>  
                      
                    <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" >   
                        <tr bgcolor="#ddddd5">
                          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
                          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
                          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
                          </tr>


	               <? if ($selecao == "")
                           $selecao='1';
                        ?>
                 
			 <? while($row=$db->dados())
	                    {                          
			     $sql5="SELECT count(*) as totobra FROM bibliografia as a INNER JOIN  obra_bibliografia as b on (a.bibliografia=b.bibliografia) INNER JOIN obra as c on (b.obra=c.obra) where a.bibliografia='".$row['expid']."' order by a.bibliografia, a.referencia";
	                     $db2->query($sql5);
	                     $totobra=$db2->dados();
                             $tobra=$totobra[totobra];

			     $sql6="SELECT count(*) as totautor FROM bibliografia as a INNER JOIN  autor_bibliografia as b on (a.bibliografia=b.bibliografia) INNER JOIN autor as c on (b.autor=c.autor) where a.bibliografia='".$row['expid']."' order by a.bibliografia, a.referencia";
	                     $db2->query($sql6);
	                     $totautor=$db2->dados();
                             $tautor=$totautor[totautor];
                             
	                 ?>
 

                        <tr class="texto">
                            <td width="70%"></td>
                            <td width="20%"></td>
                            <td width="5%"></td>
                            <td width="5%"></td>
                        </tr>


            <tr class="texto" id="cor_fundo<? echo $row['expid']  ?>">
               <td align="left"><? 
                             echo "&nbsp;<b>(".$row['expid'] .") - </b>".$row[autoria].".&nbsp;<em><b>".htmlentities($row['referencia'], ENT_QUOTES)."</b></em>.";
			     if ($row[sub_titulo]!='') echo "&nbsp;" . $row[sub_titulo].".";
			     if ($row[local]!='') echo "&nbsp;" .$row[local].":&nbsp;";
			     if ($row[editora]!='') echo "&nbsp;" .$row[editora].",&nbsp;";
			     if ($row[ano]!='0'){
					echo $row[ano].".&nbsp;";}
			     else {
					echo "s/d".".&nbsp;";}
                                               if ($row[observacao]!=''){
			     if ($row[notas]!='') echo "&nbsp;" .$row[notas].".&nbsp;";
			        echo $row[observacao].".";}
       
                  if($tobra>1)  {$frase='&nbsp;obras&nbsp;relacionadas';} 
                  if ($tobra==1){$frase='&nbsp;obra&nbsp;relacionada';}
                  if($tobra<1)  {$tobra='';$frase='nenhuma&nbsp;obra&nbsp;relacionada';} 
                ?>
                <td align="left"><? echo "<a href=\"bibliografia_manut_exibe.php?id=".$row[expid]."\">
		    <img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' 
		    onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
		    onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		</td>
                <td align="left"><? echo "<a href=\"bibliografia_manut_detobra.php?id=".$row[expid]."\">
	            <img src='imgs/icons/lista_obra.gif' width='17' height='20'border='0' alt=$tobra$frase
		    onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
		    onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
                </td>   
                <?  
                    if ($tautor>1) {$frase='&nbsp;autores&nbsp;relacionados';} 
                    if ($tautor==1) {$frase='&nbsp;autor&nbsp;relacionado';}
                    if ($tautor<1)  {$tautor='';$frase='nenhum&nbsp;autor&nbsp;relacionado';}
                 ?>
                 <td  align="center"><? echo "<a href=\"bibliografia_manut_detautor.php?id=".$row[expid]."\">
		    <img src='imgs/icons/lista_autor.gif' width='17' height='20'border='0' alt=$tautor$frase 
		    onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
		    onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		 </td>
                              
                             
                 <?if ($selecao=="1") { ?>
                    <td  align="center"><? echo "<a href=\"bibliografia_manut1.php?op=delbib&id=".$row[expid]."\"
		       onClick='return confirm(".'"A bibliografia será excluída definitivamente. Confirma a exclusão ?"'.")'><img src='imgs/icons/ic_excluir.gif' border='0' alt='exclusão' 
		       onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
		       onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
		    </td> <?}?>
                  </td>   
                 </tr>
		      <? } ?>
                 <tr class="texto">
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td align="center">&nbsp;</td>
                 </tr>

                      <tr class="texto">
 
                             <td>
                              <?if ($selecao=="1"){  echo "<a href=\"bibliografia_manut1.php?op=del&nome=".$nome1."\" onClick='return confirm(".'"Confirma Exclusão dos Registros ?"'.")'>
	         	    <img src='imgs/icons/ic_excluir.gif' width='20' height='20' border='0' alt='Excluir todas as bibliografias sem associação relacionadas acima'>";}?></td>
                            <td></td>
                            <td align="center">&nbsp;</td>

                           <td align="center">
			

                           <? $ref="bibliografia_insere2.php;"?>

                               <a href="javascript:;" style="text-decoration: none;" onClick="abrepopBibliografia('bibliografia_nova.php?<?echo "num=".$_SESSION['s_imp_total'];?><?echo "&usuario=".$usu['usuario']."&modelo=0";?>');"><sub><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' title="Nova bibliografia"></sub></a>
			   </td>

   
                       </tr>


                      <tr>
                         <td whidth="100%" height="1"  bgcolor="#003366"><img src="imgs/transp.gif" width="200%" height="1"></td>
                      </tr>
                      <tr whidth="100%" class="texto">
                         <td align="left" whidth="100%" border="0"  height="10">
                         		  

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

                          
                         $a="<a href=\"bibliografia_manut.php?page=".$first."&bibliografia=".$id."&autoria=".$autoria."&selecao=".$selecao."&nome=".$nome."&idbibliografia=".$idbibliografia."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";
                         $b="<a href=\"bibliografia_manut.php?page=".$menos."&bibliografia=".$id."&autoria=".$autoria."&selecao=".$selecao."&nome=".$nome."&idbibliografia=".$idbibliografia."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";
                         $c="<a href=\"bibliografia_manut.php?page=".$mais."&bibliografia=".$id."&autoria=".$autoria."&selecao=".$selecao."&nome=".$nome."&idbibliografia=".$idbibliografia."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";
                         $d="<a href=\"bibliografia_manut.php?page=".$last."&bibliografia=".$id."&autoria=".$autoria."&selecao=".$selecao."&nome=".$nome."&idbibliografia=".$idbibliografia."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
                      <td width="100%" height="2"  bgcolor="#003366"><img src="imgs/transp.gif" width="200%" height="1"></td>
                   </tr>
                   <tr>
                      <td></td>
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