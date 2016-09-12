<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
</head>

<script>


function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {     
var i = qual.value;
document.location=('exposicao_insere2.php?page='+ i+ '&<? echo $parametro?>=<?echo $valor?>&nomep=<?echo htmlentities($nomep, ENT_QUOTES)?>&instituicaop=<?echo htmlentities($instituicaop, ENT_QUOTES)?>');


}}

function posiciona(i) {

   document.location=('exposicao_insere2.php?page='+ i+ '&<? echo $parametro; ?>=<? echo $valor; ?>&nomep=<?echo htmlentities($nomep, ENT_QUOTES)?>&instituicaop=<?echo htmlentities($instituicaop, ENT_QUOTES)?>');


}
function cancela()
{
window.opener.location.reload();

document.form1.cancelar.submit=window.close();


  return true;
}

</script>
<?
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();
	$dbp=new conexao();
	$dbp->conecta();
	$dbreg=new conexao();
	$dbreg->conecta();
	$dbdl=new conexao();
	$dbdl->conecta();
              $pageID=$_REQUEST['pageID'];
	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
	$nomep= $_REQUEST['nomep'];
        $op= $_REQUEST['op'];
        $instituicaop= $_REQUEST['instituicaop'];
        $id=$_REQUEST['id'];
        $nomep=$_REQUEST['nomep'];
        $instituicaop=$_REQUEST['instituicaop'];

	if ($movid <> '') {
		$tipo= 'movimentacao';
		$valor= $movid;
		$parametro= 'movid';
	}
	elseif ($obrid <> '') {
		$tipo= 'obra';
		$valor= $obrid;
		$parametro= 'obrid';
	}
	elseif ($autid <> '') {
		$tipo= 'autor';
		$valor= $autid;
		$parametro= 'autid';
	}

        if ($tipo == 'autor') $href='exposicao_lista';
        if ($tipo == 'obra')  $href='exposicao_obra';

	$expid= $_REQUEST['id'];
        $nomeid= $_REQUEST['nome'];


if($op=='del') {

	$sql= "select exposicao from ".$tipo."_exposicao where exposicao = '$id' and ".$tipo."=".$valor;
	$dbdl->query($sql);
        $row=$dbdl->dados();
       if ($row[exposicao]<>'')
        {
	$sql= "DELETE from ".$tipo."_exposicao where exposicao = '$id' and ".$tipo."=".$valor;
	$dbdl->query($sql);
         //
        //////////////////////////////Tabela Log_atualizacao/////////////////////////////
       
        if ($tipo=='obra') 
         {
           $sqlreg="SELECT num_registro, titulo_etiq FROM obra WHERE obra='$valor'";
           $dbreg->query($sqlreg);
           $registro=$dbreg->dados();
           $obs1="Alteração ".$tipo." ID={".$valor."}  Registro={".$registro[num_registro]."}  Titulo="."{".trim($registro[titulo_etiq])."}";
           $obs1=$obs1. "Ação={Excluída da obra a Exposição:".$valor."}";
           $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data, obs)values('A','$_SESSION[susuario]','0','$valor',now(),'$obs1')";
           $dbdl->query($sql);
        }
       if ($tipo=='autor') 
         {
        $sqlreg="SELECT nomeetiqueta FROM autor WHERE autor='$valor'";
        $dbreg->query($sqlreg);
        $registro=$dbreg->dados(); 
        $obs1="Alteração autor ID={".$valor."}";
        $obs1=$obs1. "Ação={Exclusão exposição:".$id."}";
        $sql="insert into log_atualizacao(operacao,usuario,autor,obra,data,obs)values('A','$_SESSION[susuario]','$valor','0',now(),'$obs1')";
        $dbdl->query($sql);
        }
        $_REQUEST['op']='insert';$op='insert';
   }}


                    
     
        
        if ($_REQUEST['instituicaop'] <>'' )
          {
             $whereinstituicao=" instituicao like '%$instituicaop%'  ";
           $whereinstituicaoCount=" instituicao like '%$instituicaop%'  ";
  
          } else {
           $whereInstituicao="";
           $whereInstituicaoCount="";
          }

        if ($_REQUEST['nomep'] <>'' )
          {
            $wherenome=" nome like '%$nomep%'  ";
           $wherenomeCount=" nome like '%$nomep%'";
  
          } else {
           $wherenome="";
           $wherenomeCount="";
          }

           $end='';$where='';$tipoCI=""; 
           if (($wherenome<>'') and ($whereinstituicao<>''))  $end=" and ";

	if (($nomep<>'') or ($instituicaop <>'' ))
        {        
            $where=" where ";    
            $sql= "SELECT count(*) from exposicao".$where.$whereinstituicaoCount.$end.$wherenomeCount;
	    $db->query($sql);
	    $numlinhas=$db->dados();
            $numlinhas=$numlinhas[0];
             
        }

	/////Paginando
	$pagesize=7;
       

        if(!empty($_GET['page']))
            $page=$_GET['page'];
        
        if ($_REQUEST['find']=="Avançar") {
	    $page=1;
        }

        //echo $numlinhas."-".$pagesize."-".($numlinhas/$pagesize)."-".$page;

	if(ceil($numlinhas/$pagesize)<$page) {
 	    $page=1;
        }

        $page--;
        $registroinicial=$page* $pagesize;


                 	
	$sql2= "SELECT *, tipo as tipoCI from exposicao".$where.$whereinstituicao.$end.$wherenome. " order by tipo, dt_inicial LIMIT $registroinicial,$pagesize";
	$db->query($sql2);
             
	
       ?>



<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr >
  
    <td valign="top"><form name="form1" method="post" action="">
 
        <br>
        <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
            
          <tr bgcolor="#96ADBE">
             <td colspan="10" width="100%" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100%" height="1"></td>
          </tr>
         <?$pageID=$page + 1;?>
          <tr width="100%" bgcolor="#96ADBE">
             <td width="95%" colspan="0" height="24" bgcolor="#96ADBE" class="texto_bold" style="color: white;"><div align="left"> &nbsp;Pesquisa exposição a vincular</div></td>
             <td width="5%"><? echo "<a href=\"exposicao_insere.php?nomep=".htmlentities($nomep, ENT_QUOTES)."&op=insert&"."instituicaop=".htmlentities($instituicaop, ENT_QUOTES)."&".$parametro."=".$valor."&page=".$pageID."\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Nova exposição'>"?></td>
          </tr>

            <tr bgcolor="#96ADBE">
             <td colspan="10" width="100%" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100%" height="1"></td>
          </tr>
                           
        </table>
        <br>

        <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
          
        
	  <tr width="100%">

	     <td width="80%" class="texto" valign="top"><div align="center">
                       &nbsp;&nbsp;<b>Nome da exposição:</b>&nbsp;<input type="text" name="nomep" value="<?htmlentities($nomep, ENT_QUOTES);echo htmlentities(str_replace("\\","",$_REQUEST[nomep]), ENT_QUOTES); ?>" size="60" class="combo_cadastro">
                      <br>&nbsp;&nbsp;<em>ou</em>
			<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Instituição:&nbsp;</b><input type="text" name="instituicaop" value="<?htmlentities($instituicaop, ENT_QUOTES);echo htmlentities(str_replace("\\","",$_REQUEST[instituicaop]), ENT_QUOTES); ?>" size="60" class="combo_cadastro">
                      </td>
			<td width="20%"><div align="center"><input type="submit" name="find" value="Procurar" class="botao" onClick="">
              </td>   
	  </tr>
	  <tr width="100%">
            <td><br></td>
 	  </tr>
          
          <tr bgcolor="#96ADBE">
             <td colspan="3" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
          </tr>
          <tr bgcolor="#ddddd5">
             <td colspan="3" height="24"  bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Exposição</div></td>
          </tr>
          <tr>
             <td colspan="3" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
          </tr>              
        </table>
        
       
        <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados())
	  {

        $sql3="select nome from pais where pais='".$row[pais]."'";
        $dbp->query($sql3);
        $pais=$dbp->dados();
        $nome_pais=$pais[nome];   


        $sqlp="SELECT count(*) as total FROM ".$tipo."_exposicao where ".$tipo."='$valor' and exposicao='$row[exposicao]'";
	$dbp->query($sqlp);
        $rowp=$dbp->dados();
         
   
 if (($nomep<> '') or ($instituicaop<>'') ){ ?>
 <tr>

        <?if ($rowp[total]=="0")
        {?>
         
          <td class="texto" width="90%" valign="top">
	   <b><?if (substr($row['dt_inicial'],0,4)=="0000") {echo "s/d ";}else{echo substr($row['dt_inicial'],0,4);}?></b><?echo "-<b>".$row['nome'].", "."</b>".$row['instituicao'].", ".$row['cidade'].", ";
               if (strtoupper($nome_pais)=="BRASIL") {echo $nome_estado.", ";}
	       echo $nome_pais.", ".$row['periodo'].". "."<em>";
               echo  "<font color='brown'>".$row['premio']; ?>
          </td> 
          <?$pageID=$page + 1;?>
          <td width="10%" align="center"><? echo "<a href=\"exposicao_".$tipo."_alterar.php?nomep=".htmlentities($nomep, ENT_QUOTES)."&instituicaop=".htmlentities($instituicaop, ENT_QUOTES)."&tipo=".$tipo."&op=update&".$parametro."=".$valor."&id=".$row['exposicao']."&page=".$pageID."\">
	      <img src='imgs/icons/ic_adicionar.gif' border='0' alt='Adicionar à lista' 
	      onMouseOver='document.getElementById(\"cor_fundo".$row[exposicao]."\").style.backgroundColor=\"#ddddd5\";' 
              onMouseOut='document.getElementById(\"cor_fundo".$row[exposicao]."\").style.backgroundColor=\"\";'>";?>
          </td>

       <?}else {?>

           <td class="texto" width="90%" valign="top">
	      <font style="color:#9B9B9B"><?if (substr($row['dt_inicial'],0,4)=="0000") {echo "s/d ";}else{echo substr($row['dt_inicial'],0,4);}?><?echo "-".$row['nome'].", ".$row['instituicao'].", ".$row['cidade'].", ";
                 if (strtoupper($nome_pais)=="BRASIL") {echo $nome_estado.", ";}
	         echo $nome_pais.", ".$row['periodo'].". "."<em>";
                 echo  "<font color='brown'>".$row['premio']; ?>
              </font>
           </td>

             <?$pageID=$page+1;?>
  
          <td width="5%" align="center"><? echo "<a href=\"exposicao_insere2.php?tipo=".$tipo."&nomep=".htmlentities(str_replace("\\","",$_REQUEST[nomep]), ENT_QUOTES)."&instituicaop=".htmlentities(str_replace("\\","",$_REQUEST[instituicaop]), ENT_QUOTES)."&op=del&".$parametro."=".$valor."&id=".$row[exposicao]."&page=".$pageID."\"
						onClick='return confirm(".'"O item será removido da lista. Confirma Remoção ?"'.")'><img src='imgs/icons/ic_remover.gif' border='0' alt='Remover da lista' 
						onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
						onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
	   </td>
 
  





      <?}?>
   </tr>
</tr>


   
      <?} }?>

        <tr class="texto">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td height="1" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>


        <tr class="texto">
          <td colspan="4" height="20">
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
                     
			 $a="<a href=\"exposicao_insere2.php?page=".$first."&".$parametro."=".$valor."&nomep=".htmlentities(str_replace("\\","",$nomep), ENT_QUOTES)."&instituicaop=".htmlentities(str_replace("\\","",$instituicaop), ENT_QUOTES)."\"><img src='imgs/icons/btn_inicio.gif'    border='0'  alt='Registro Inicial' ></a>";
			 $b="<a href=\"exposicao_insere2.php?page=".$menos."&".$parametro."=".$valor."&nomep=".htmlentities(str_replace("\\","",$nomep), ENT_QUOTES)."&instituicaop=".htmlentities(str_replace("\\","",$instituicaop), ENT_QUOTES)."\"><img src='imgs/icons/btn_anterior.gif'  border='0'  alt='Registro Anterior' ></a>";
			 $c="<a href=\"exposicao_insere2.php?page=".$mais."&".$parametro."=".$valor."&nomep=".htmlentities(str_replace("\\","",$nomep), ENT_QUOTES)."&instituicaop=".htmlentities(str_replace("\\","",$instituicaop), ENT_QUOTES)."\"><img src='imgs/icons/btn_proximo.gif'    border='0'  alt='Proximo Registro' ></a> ";
			 $d="<a href=\"exposicao_insere2.php?page=".$last."&".$parametro."=".$valor."&nomep=".htmlentities(str_replace("\\","",$nomep), ENT_QUOTES)."&instituicaop=".htmlentities(str_replace("\\","",$instituicaop), ENT_QUOTES)."\"><img src='imgs/icons/btn_ultimo.gif'     border='0'  alt='Ultimo Registro' ></a>";

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
             <div align="center"></div>
             </td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>

        </tr>
        <tr width="100%">
       <td colspan="4" align="center" class="texto">
            <div align="center">
              <input name="cancelar" type="submit" class="botao" id="cancelar" value="Fechar" onClick="cancela()">

            </div></td>

        </tr>
      </table>
    </form>
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