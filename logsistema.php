<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;

document.location=('logsistema.php?page='+ i+ '&dt_ini=<? echo $_REQUEST[dt_ini] ?>&dt_fim=<? echo $_REQUEST[dt_fim] ?>&nome=<? echo trim($_REQUEST[nome]) ?>&num_registro=<? echo trim($_REQUEST[num_registro])?>&operacao=<? echo trim($_REQUEST[operacao])?>' );
}}


function posiciona(valor) {
var i = valor;
document.location=('logsistema.php?page='+ i+ '&titulo=<? echo $_REQUEST[titulo] ?>&vinculo=<? echo $_REQUEST[vinculo] ?>&funcao=<? echo $_REQUEST[funcao] ?>&cor=<? echo $_REQUEST[cor] ?>');
}
<!--Incluido função de abrir o pop de consulta de autor abrepopAutor() e chkCombo()-->

function abrepopAutor(janela) 
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-230)+',top='+((window.screen.height/2)-200)+',width=460,height=400, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}

var txtCombo = '';

	function chkCombo(pEvent,obj) {
         var evt = new PrepEvent(pEvent);
         var aux = txtCombo;
         switch(evt.keyCode) {
            case 0:
               break;
            case 8: // Backspace
               txtCombo='';
               break;
            case 33: // Page Up
               txtCombo='';
               return 0;
               break;
            case 34: // Page Down
               txtCombo='';
               return 0;
               break;
            case 35: // End
               txtCombo='';
               return 0;
               break;
            case 36: // Home
               txtCombo='';
               return 0;
               break;
            case 38: // Cima
               txtCombo='';
               return 0;
               break;
            case 40: // Baixo
               txtCombo='';
               return 0;
               break;
            case 46: // Del
               txtCombo='';
               break;
            default:
//               if ((evt.charCode > 48 && evt.charCode < 91) || (evt.keyCode == 32)) {
               if (evt.keyCode > 31) {
                  txtCombo+=String.fromCharCode(evt.keyCode);
               } else {
                  return 1;
               }
               break;
            }
            encontrou=false;
            for (x = 0;x < obj.options.length;x++) {
               if (obj.options[x].text.toUpperCase().substring(0,txtCombo.length) == txtCombo) {
                  obj.value=obj.options[x].value;
                  encontrou=true;
                  break;
               }
            }
            return obj.value;
         }


function valida(){
    var mensagem = "";
    var form  = document.form2;
    var campo = "";
    var num_elementos =  form.elements.length;
     for (var i = num_elementos-1; i >= 0 ; i--){	  	   
     var elemento = form.elements[i];
        if (elemento.name == "dt_ini"){
          if(IsEmpty(elemento))
		  {
		    campo = elemento;
            mensagem = "Informe a data inicial \n\n" + mensagem ;
		  }
	      if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data Inicial inválida (dd/mm/aaaa) \n\n" + mensagem;
          }
		  continue;
        }

        if (elemento.name == "dt_fim"){
		   if(IsEmpty(elemento))
		  {
		    campo = elemento;
            mensagem = "Informe a data final \n\n" + mensagem ;
		  }
          if (!Validar_Campo_Data(elemento,false) ){
             campo = elemento;
             mensagem = "Data Final inválida (dd/mm/aaaa) \n\n" + mensagem;
          }
		  continue;
        }
     }	  
    
	 if (mensagem != ""){
        alert(mensagem);
        campo.focus();
        return false;
     } else return true;
}

</script>

</head>

<body>
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
<? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db2=new conexao();
$db2->conecta();
$db3=new conexao();
$db3->conecta();
$db4=new conexao();// conexão ao banco para a pesq. de autor PBL
$db4->conecta();
$_REQUEST[num_registro]=str_replace(".", "",$_REQUEST[num_registro]);
$val=$_REQUEST['log_atualizacao'];
$op=$_REQUEST['op'];
$autor=$_REQUEST['autor'];
$nome=$_REQUEST['nome'];
$operacao=$_REQUEST['operacao'];
$numregistro=$_REQUEST['num_registro'];
montalinks();
$_SESSION['lnk']=$link;
?>
    </div></th>
  </tr>
      <?
      $condicao= '';
	  /////Paginando
	  $pagesize=9;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
////////////
		if ($_REQUEST['op'] == 'del') {
		  $sql="DELETE FROM log_atualizacao WHERE data < DATE_SUB(CURDATE(),INTERVAL 90 DAY)";
		  $db->query($sql);
		  echo "<script>alert('Exclusão realizada com sucesso.');</script>";
		  echo "<script>location.href='logsistema.php';</script>";
		  exit();
		}
		// consulta operacao PRD20 PBL
		if ($_REQUEST[operacao]<>''){
		   $whereOperacao="a.operacao like '".trim($_REQUEST['operacao'])."'and ";
                   $whereOperCount="operacao like '".trim($_REQUEST['operacao'])."'and ";
		} else {
		   $WhereOperacao="";
		   $WhereOperCont="";
		}
                // Consulta autor PRD20 PBL 
 		if ( strtoupper(trim($_REQUEST['nome'])) <>'' ) 
                 { 
		    $NumAutorObra = "{%".str_replace(".", "",trim($_REQUEST['nome']))."%}";    
	            $whereAutor="a.obs like '%$NumAutorObra%' and ";
                    $whereAutorCount="obs like '%$NumAutorObra%' and ";
		} else {
			$whereAutor="";
                        $whereAutorCount="";
		}
                // Consulta Obra PBL
		
		if ($_REQUEST[num_registro]<>'') {
			$NumRegObra = "{".str_replace(".", "",trim($_REQUEST['num_registro']))."}";    
			$whereObra="a.obs like '%$NumRegObra%' and ";
		     $whereObraCount="obs like '%$NumRegObra%' and ";
		} else {
			$whereObra="";
                        $whereObraCount="";
		}

		if ($_REQUEST['dt_ini']=='' && $_REQUEST['dt_fim']=='') {
		  $sql="SELECT count(*) as total from log_atualizacao where ".$whereOperCount.$whereAutorCount.$whereObraCount." data between DATE_SUB(CURDATE(),INTERVAL 90 DAY) and now()";
		  $sql2="SELECT a.*, b.nome FROM log_atualizacao AS a LEFT JOIN usuario AS b on (a.usuario = b.usuario) 
			WHERE ".$whereOperacao.$whereAutor.$whereObra." a.data between DATE_SUB(CURDATE(),INTERVAL 90 DAY) and now() order by data desc , log_atualizacao desc LIMIT $registroinicial,$pagesize";
		  $dt_ini= date("d/m/Y", mktime(0, 0, 0, date("m"), date("d")-90, date("Y")));
		  $dt_fim= date("d/m/Y");
		}
		else {
		  $sql="SELECT count(*) as total from log_atualizacao where ".$whereOperCount.$whereAutorCount.$whereObraCount." data between '".seta_data($_REQUEST[dt_ini])."' and '".seta_data($_REQUEST[dt_fim])."'";
		  $sql2="SELECT a.*, b.nome FROM log_atualizacao AS a LEFT JOIN usuario AS b on (a.usuario = b.usuario) 
			WHERE ".$whereOperacao.$whereAutor.$whereObra." a.data between '".seta_data($_REQUEST[dt_ini])."' and '".seta_data($_REQUEST[dt_fim])."' order by data desc , log_atualizacao desc LIMIT $registroinicial,$pagesize";
		}                 
 
		  $db->query($sql);
		  $numlinhas=$db->dados();
                  $numlinhas=$numlinhas[0];
		  $db->query($sql2);
	   ?>
  <tr>
    <td valign="top" class="texto"><form name="form2" method="get" action="logsistema.php">
      <div align="left">&nbsp Per&iacute;odo de busca: de

          <input name="dt_ini" type="text" class="combo_texto" id="dt_ini" maxlength="10" size="10" value="<? if ($_REQUEST['dt_ini']=='' && $_REQUEST['dt_fim']=='') echo $dt_ini; else echo $_REQUEST['dt_ini']; ?>"> 
        at&eacute; 
        <input name="dt_fim" type="text" class="combo_texto" id="dt_fim" maxlength="10" size="10" value="<? if ($_REQUEST['dt_ini']=='' && $_REQUEST['dt_fim']=='') echo $dt_fim; else echo $_REQUEST['dt_fim']; ?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nº Registro:&nbsp; 
        <input name="num_registro" type="text" class="combo_texto" id="obra" size="7,9" value="<? echo $_REQUEST['num_registro']; ?>">         
        &nbsp;&nbsp;<input name="submit" type="submit" class="combo_cadastro" value=" Ok " style="cursor: pointer; border-width: 1px;">  
        &nbsp;&nbsp;Operação:&nbsp;
        <select name="operacao" class="combo_cadastro" id "operacao" value="<?$_REQUEST['operacao'];?>">
	  <option value=""></option>
	  <option value="I"<?if ($operacao==I) echo "selected";?>>Inclusão</option>
          <option value="A"<?if ($operacao==A) echo "selected";?>>Alteração</option>
          <option value="E"<?if ($operacao==E) echo "selected";?>>Exclusão</option>
        </select>

        &nbsp;Autor ou Titulo da obra:&nbsp;
	<input name="nome" type="text" class="combo_texto" size="36" value="<?echo $_REQUEST['nome'];?>">

      </div>
    </form></td>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="5" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>

<!-- PRD10
     Incluido no cabecalho a Coluna Autor/Obra
     Demais elementos (colspan) passados de 4 para 5 (header e footer)
-->
        <tr bgcolor="#ddddd5">
          <td width="20%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Usu&aacute;rio</div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="left">Operação /</div></td><! mudei de 22% para 13%!>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="left"> Data</div></td>
          <td width="40%" bgcolor="#ddddd5" class="texto_bold"><div align="left">Autor/Obra</div></td>
          <td width="10%" bgcolor="#ddddd5" class="texto_bold"><div align="center">Detalhes</div></td>
        </tr>
        <tr>
          <td colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados())
	  {
	     $dt=substr($row[data],0,10);
		 $data=explode('-',$dt);
		 $x='/';
		 $data1=$data[2].$x.$data[1].$x.$data[0]; 
	  ?>
        <tr id="cor_fundo<? echo $row['log_atualizacao'] ?>" class="texto">
          <td align="left" width='20%'><? if ($row[nome] == NULL) {echo "<font style='color:maroon'>Usuário excluído do sistema: <em>Id ".$row[usuario]."</em></font>";} else {echo substr($row['nome'],0,15);} ?></td>
          <td width='10%' align="left"> <! mudei(operação) de 15% para 10%  e (USUARIO)  de 35% para 20% e substr trunquei o nome- PRD10!>
		  <? 
		  if($row[operacao]=='A'){echo "Alteração /";}
		  if($row[operacao]=='I'){echo "Inclusão /";}
		  if($row[operacao]=='E'){echo "Exclusão /";}
		   ?>
                  <div align="left"></div></td>
                  <td align="left" width='15%'> 
                  <div align="left"><? echo $data1 ?></div></td>
                  <td width='40%'><! mudei (autor) de 20% para 40% e substr trunquei o nome - PRD10!>
                  <? 
 
  
                 if ($row[obra]<>"0") 
               { 			
                  $resp1 = "(".$row[obs].")";
		  list($ob1,$ob2,$ob3) = explode("}", $resp1);
                  if ($ob2<>"")
                  { list($ob4,$ob5) = explode("=",$ob2);
                    echo "obra:".$ob5."}";
                    }
                }
		else                  
		{
                  $resp1 = "(".$row[obs].")";
		  list($ob1,$ob2) = explode("}", $resp1);
                  if ($ob2<>"")
                  { list($ob4,$ob5) = explode("=",$ob2);
                    echo "autor:".$ob5."}";
                    }
                   }
              ?>
          </td>

<!--
          PRD10 - Colocada na chamada de logsistema1.php a passagem de $row[obs] (Observacao)
-->

          <td align="center" width='10%'><div align="center"> <! mudei (detalhes) de 15% para 10%!>
            <? echo "<a href=\"logsistema1.php?user=$row[nome]&op=$row[operacao]&obra=$row[obra]&autor=$row[autor]&obs=$row[obs]&nome=$row[nome]&data=".$row[data]."\">
		<img src='imgs/icons/relat.gif' width='20' height='20' border='0' alt='Informa&ccedil;&otilde;es' 
		onMouseOver='document.getElementById(\"cor_fundo".$row[log_atualizacao]."\").style.backgroundColor=\"#ddddd5\";' 
		onMouseOut='document.getElementById(\"cor_fundo".$row[log_atualizacao]."\").style.backgroundColor=\"\";'>";?>
            <? } ?>
          </div></td>
        </tr>
        <tr class="texto">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="texto">
          <td colspan="2"><? echo "<a href=\"logsistema.php?op=del\" onClick='return confirm(".'"Confirma Exclusão dos Registros ?"'.")'>
		<img src='imgs/icons/ic_excluir.gif' width='20' height='20' border='0' alt='Excluir os registros com mais de 90 dias'>";?></td>
          <td></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="5" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"logsistema.php?page=".$first."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."&nome=".$_REQUEST[nome]."&num_registro=".$_REQUEST[num_registro]."&operacao=".$_REQUEST[operacao]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"logsistema.php?page=".$menos."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."&nome=".$_REQUEST[nome]."&num_registro=".$_REQUEST[num_registro]."&operacao=".$_REQUEST[operacao]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"logsistema.php?page=".$mais."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."&nome=".$_REQUEST[nome]."&num_registro=".$_REQUEST[num_registro]."&operacao=".$_REQUEST[operacao]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"logsistema.php?page=".$last."&dt_ini=".$_REQUEST[dt_ini]."&dt_fim=".$_REQUEST[dt_fim]."&nome=".$_REQUEST[nome]."&num_registro=".$_REQUEST[num_registro]."&operacao=".$_REQUEST[operacao]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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

echo"<font color='000000'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>
       <p>
          <input name="log_atualizacao" type="hidden" id="log_atualizacao" value="<? echo $log_atualizacao ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
        </p>
    </form>
    <p></p></td>
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
