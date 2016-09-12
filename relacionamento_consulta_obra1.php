<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<style type="text/css">
select {
  behavior: url("js/select_keydown.htc");
}
</style>
<script>
function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-230)+',top='+((window.screen.height/2)-200)+',width=460,height=400, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}

function valida()
{
 with(document.form1)
 {
    if(obra.value==''){
	  alert('Selecione a obra!');
	  return false;}
	if(relacionamento.value==''){
	alert('Informe o relacionamento');
	return false;}
	
  }
}
function abre_manual(parametro)
{
  	win=window.open('manual_catalog.php?corfundo=cccccc&parametro='+parametro,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-130)+',height=450,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>  
</head>

<body>      
<table width="100%" height="10%"  border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <td width="100%" height="100%" valign="top"><form name="form1" method="post" onSubmit="return valida()" >
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");

$db=new conexao();
$db->conecta();
$db1=new conexao();
$db1->conecta();
$op=$_REQUEST['op'];
$db2=new conexao();
$db2->conecta();
$db3=new conexao();
$db3->conecta();
$op=$_REQUEST[op];

$obra=$_REQUEST[obra];
$obrarelORI=$_REQUEST['obrarelORI'];

$obrarel=$_REQUEST['obrarel'];
$obranome=$_REQUEST['obranome'];

$obraSel=$_REQUEST[obraSel];
$nomeSel=$_REQUEST[nomeSel];
if ($obraSel<>"") {
   $obrarel=$obraSel;
   $obraSel="";
   $obranome=$nomeSel;
   $nomeSel="";
}


    $sql2="SELECT relacionamento FROM relacionamento r";
    $db2->query($sql2);
    $res2=$db2->dados();
    $_REQUEST[relacionamento]=$res2[relacionamento];

 if(isset($_REQUEST[obra]))
 {
  
  if($op=='update')
  {
    $sql="SELECT a.titulo,a.num_registro,b.* FROM obra AS a INNER JOIN relacionamento_obra as b on (a.obra=b.obrarel) where b.obra='$_REQUEST[obra]' and b.relacionamento='$_REQUEST[relacionamento]'";
    $db->query($sql);
    $res=$db->dados();



    $sql="select nome,relacionamento from relacionamento where relacionamento='$res[relacionamento]'";
    $db->query($sql);
    $resp=$db->dados();


    //
    // Salva os parametros de entrada para UPDATE
    //

    echo "<input type=hidden name=obrarelORI value='$_REQUEST[obrarelORI]'>";
    echo "<input type=hidden name=relacionamentoORI value='$_REQUEST[relacionamento]'>";
 
  }

 }	 
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr class="texto_bold">

         <td><div align="right">Nº de registro:</div></td>
         <td><input name="obrarel" type="text" class="combo_cadastro" id="obrarel" style="text-align:center;"tabindex="-1" <?if (obraSel<>""){?>value="<?echo $obrarel;$obraSel="";?>"<?} ?> size="6" maxlength="10"></td>

          <td><div align="right">Titulo obra:</div></td>
          <td><input name="obranome"type="text" class="combo_cadastro" id="obranome" style="text-align:center;"tabindex="-1" <?if (NomeSel<>""){?>value="<?echo $obranome;$NomeSel="";?>"<?} ?> size="30" maxlength="200"></td>

           <td>
              <div align="right" tabindex="-1">
                <span class="texto_bold">
                   <input name="consultar" type="submit" class="botao" id="consultar" value="Consultar">
                </span>
              </div>
           </td>
   
           
        <table width="100%" height="10"  border="0" colspan="5" cellpadding="0" cellspacing="0">
            <tr bgcolor="#96ADBE">
               <td colspan="5" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
            </tr>
            <tr bgcolor="#96ADBE">
               <td width="10%"  bgcolor="#96ADBE" class="texto_bold"><div align="left"> &nbsp;Obra</div></td>
               <td width="20%" bgcolor="#96ADBE" class="texto_bold"><div align="left">Autor</div></td>
               <td width="30%" bgcolor="#96ADBE" class="texto_bold"><div align="left">Titulo</div></td>
               <td width="40%" bgcolor="#96ADBE" class="texto_bold"><div align="left">Coleção</div></td>
            </tr>
           <tr>
              <td height="2" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
           </tr>
         </table>       

         <table width="100%" height="10"  border="0" colspan="5" cellpadding="0" cellspacing="2" >
          <tr class="texto">
            <td width="10%"></td>
            <td width="20%"></td>
            <td width="30%"></td>
            <td width="40%"></td>
          </tr>

          <?
             if($_REQUEST['consultar']<>'')
             {
                if (($_REQUEST[obrarel]!='')and($_REQUEST[obranome]=='')) 
                {
                   $whereconsulta= "where num_registro='$_REQUEST[obrarel]'";                  
                }
                if (($_REQUEST[obranome]!= '') and ($_REQUEST[obrarel]== '')) 
                {
                   $whereconsulta= "where titulo_etiq like '%".$_REQUEST['obranome']."%'";
                }
                if (($_REQUEST[obrarel]!= '')  and ($_REQUEST[obranome]!='')) 
                {
                   $whereconsulta= "where (num_registro='$_REQUEST[obrarel]') and (titulo_etiq like '%".$_REQUEST['obranome']."%')";
                } 
                
               if (($obrarel!='')or($obranome!=''))
                {
                   $sql="select obra,titulo_etiq,num_registro,colecao from obra ".$whereconsulta;      
                   $db->query($sql);
                   while ($resp=$db->dados())
                   {
                      $titObraDest=$resp[titulo_etiq];
                      $sqlautob="select autor from autor_obra where obra='$resp[obra]'";
                      $db3->query($sqlautob);            
                      $resautob=$db3->dados();
  

                      $sqlautor="select nomeetiqueta from autor where autor='$resautob[autor]'";  
                      $db3->query($sqlautor);          
                      $resautor=$db3->dados();
                      $autor=$resautor[nomeetiqueta];     

                      $sqlcolecao="select nome from colecao where colecao='$resp[colecao]'";  
                      $db3->query($sqlcolecao);          
                      $respcolecao=$db3->dados();
                 
           ?>

                   <tr class="texto" id="cor_fundo<? echo $resp['obra'] ?>">
                     <td><? echo "<a href=\"relacionamento_consulta_obra1.php?obra"."=".$_REQUEST[obra]."&op"."=".$_REQUEST[op]."&obraSel"."=".$resp[num_registro]."&nomeSel"."=".$resp[titulo_etiq]."\"'>".$resp['num_registro']."</a>"?></td>
                     <td><?echo $autor;?></td>
                     <td><?echo $titObraDest;?></td>
                     <td><?echo $respcolecao[nome];?></td>
                   </tr>          
	          <?}
                }
           }?>



           <tr class="texto">
              <td colspan="5">&nbsp;</td>
              <td></td>                    
           </tr>

           <tr><td height="1" colspan="5" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td></tr>

           <tr class="texto">
              <td colspan="5" height="20"><div align="center"></div></td>
           </tr>

           <tr><td height="2" colspan="5" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td></tr>

           <tr><td colspan="4"></td></tr>

      </table>

      </table>
      <br>      
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>

</table>


</body>
</html>
