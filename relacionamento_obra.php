<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script>


function abrepopRelacionamento(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-340)+',top='+((window.screen.height/2)-200)+',width=700,height=440, scrollbars=yes, resizable=yes');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}
function abrepop(janela,alt,larg) {
	var h=screen.height-100,w=screen.width-50;
	win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}

function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('relacionamento_obra.php?obra=<? echo $_REQUEST[obra] ?>&page='+ i);

}}
function abre_pagina(idobra,title)
{ 
  	win=window.open('consulta_obra_2.php?nosave=1&num_registro='+title+'&obra='+idobra,'PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-240)+',height=520,width=780,scrollbars=yes,status=no,toolbar=no,menubar=no,location=yes');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>

</head>
<?
        include("classes/classe_padrao.php");
        $db=new conexao();
        $db->conecta();
        $db1=new conexao();
        $db1->conecta();
        $db2=new conexao();
        $db2->conecta();
        $obra=$_REQUEST['obra'];
        $lista=$_REQUEST['lista'];
        $numlinhas=0;
	$sql="SELECT count(*) as total from obra AS a INNER JOIN  relacionamento_obra as b on (a.obra=b.obrarel) where b.obra='$_REQUEST[obra]'";
	$db->query($sql);
	$numlinhas=$db->dados();
        $totrel=$numlinhas[0];
        if ($totrel==0) $numlinhas=0;

 ?>
<body style="background-color: #;">

    <table align="center" width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
          <tr bgcolor="#ddddd5">
               <td width="95%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;"><div align="left"> Total de relacionamentos: <?echo $totrel;?></div>
              </td>
              
      <?if (($numlinhas>0) and ($_REQUEST[op_obra]=='update')){?>
           <td width="7%" align="center" >  
           <?
                  $comando="<a href=\"relacionamento_obra.php?obra=$obra&lista=1\";>";
                  echo $comando;
                   ?>
          <img src='imgs/icons/btn_listar.gif'  border='0' alt='Listar'></a>
          </td>

              <td width="7%" align="center" style=";">&nbsp;&nbsp;</td>

       <?}else{?>  
          <td width="7%" align="center" style=""><?$ref="relacionamento_obra1.php?lista=1&op=insert&obra=".$_REQUEST[obra]."&tipo=obra";?>
               <a href='javascript:;' onClick="abrepopRelacionamento('<?echo $ref;?>');"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Adicionar'></a>
         </td>
    <?}?>
   
           <td width="7%" align="center" style="border-right: 1px solid #121212;">&nbsp;&nbsp;</td>

    

      </tr>

       <tr bgcolor="#96ADBE">
          <td  height="2" width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>     

<?if (($_REQUEST['lista']=='1') or ($_REQUEST['op_obra']=='insert')){?>
<table width="100%"  border="0" align="center" colspan="5" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	 
	  /////////////////////
	  $sql2="SELECT a.num_registro,a.titulo,b.* FROM obra AS a INNER JOIN  relacionamento_obra as b on (a.obra=b.obrarel) where b.obra='$_REQUEST[obra]' order by b.obra";
	  $db->query($sql2);
	  ////////////////////
	   ?>
       
         <table width="100%" height="100%"  border="0" colspan="5" cellpadding="0" cellspacing="2" >
		<? while($row=$db->dados()) {

                 $sql9="select nome from relacionamento where relacionamento=$row[relacionamento]";
                 $db1->query($sql9);
                 $rel=$db1->dados();

                 $sql9="select titulo from obra where obra=$row[obrarel]";
                 $db1->query($sql9);
                 $resp=$db1->dados();
                 $tituloContra=$resp[titulo]; 

                 $sqlautor="SELECT a.autor,b.autor,b.nomeetiqueta FROM autor_obra as a INNER JOIN autor as b on (a.autor=b.autor) where a.obra=$row[obrarel]";     
	         $db2->query($sqlautor);
                 $resp3=$db2->dados();
                 $autor=$resp3[nomeetiqueta];
	  ?>
        <tr class="texto">
          <td  width="7%"></td>
          <td  width=90%"></td>
          <td  width="3%"></td>
       </tr>
        <tr class="texto" id="cor_fundo<? echo $row['obrarel'] ?>">



         <td onClick="abre_pagina(<? echo $row['obrarel'] ?>,
            '<? echo htmlentities(str_replace("'","`",$row[num_registro]), ENT_QUOTES); ?>');

            " style="cursor:pointer;"
            " onMouseOver="this.style.textDecoration='underline';">


         


              <? echo "<b>".$row['num_registro']."</b>"?>
         </td>
  
       <td 
            <? echo htmlentities(str_replace("'","`",$row[num_registro]), ENT_QUOTES); ?>');"><?echo $autor;?>&nbsp;&nbsp;<?echo "<b>".$row['titulo']."</b>"?>
                     
       </td>

               <td  align="center"><div align="center"><? echo "<a href=\"relacionamento_obra1.php?op=del&obrarel=".$row['obrarel']."&obra=".$_REQUEST[obra]."&relacionamento=".$row[relacionamento]."\"
						onClick='return confirm(".'"O item será removido da lista. Confirma Remoção ?"'.")'>
                                                                                   <img src='imgs/icons/ic_remover.gif' border='0' alt='Remover da lista' 
						onMouseOver='document.getElementById(\"cor_fundo".$row['obrarel']."\").style.backgroundColor=\"#ddddd5\";' 
						onMouseOut='document.getElementById(\"cor_fundo".$row['obrarel']."\").style.backgroundColor=\"\";'>";?>
	   </div></td>

     



<? }?>
		  </td>
</tr>
        <tr class="texto" style="border-left: 1px solid #121212;">
          <td colspan="5" >&nbsp;</td>
          <td></td>
         </tr>
          <tr class="texto">
          <td colspan="5" height="20"><? 
		   


$g= " ";
echo"&nbsp";
echo"<font color='003366'>$g</font>";   
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#003366" ><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
          <input name="bibliografia" type="hidden" id="bibliografia" value="<? echo $bibliografia ?>">
          <input name="op" type="hidden" id="op" value="<? echo $op ?>">
          <input name="id" type="hidden" id="id" value="<? echo $_REQUEST[id] ?>">
    </form>
    <p></p></td>
  </tr>
</table>
<?}?>
</body>
</html>
