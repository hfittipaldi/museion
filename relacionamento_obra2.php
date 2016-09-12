<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
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
        $obra=$_REQUEST[obra];
 ?>
<body>
<table width="100%"  border="0" align="center" colspan="5" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
      <?
	  /////Paginando
	  $pagesize=10;
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	 $sql="SELECT count(*) as total from relacionamento_obra where obra='$_REQUEST[obra]'";
	 $db->query($sql);
	 $numlinhas=$db->dados();
         $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.num_registro,a.titulo,b.* FROM obra AS a INNER JOIN  relacionamento_obra as b on (a.obra=b.obrarel) where b.obra='$_REQUEST[obra]' order by b.obra asc LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	   ?>
         <table width="100%" height="20"  border="0" colspan="5" cellpadding="0" cellspacing="0">
            <tr bgcolor="#96ADBE">
               <td colspan="5" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
            </tr>
            <tr bgcolor="#ddddd5">
               <td width="7%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left"> &nbsp;Obra</div></td>
               <td width="39%" bgcolor="#ddddd5" class="texto_bold"><div align="left">Autor</div></td>
               <td width="42%" bgcolor="#ddddd5" class="texto_bold"><div align="left">Titulo</div></td>
               <td width="4%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
               <td width="4%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
            </tr>
           <tr>
              <td height="2" colspan="5" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
           </tr>
         </table>       
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
          <td width="7%"></td>
          <td width="39%"></td>
          <td width="42%"></td>
          <td width="4%"></td>
          <td width="4%"></td>
        </tr>
        <tr class="texto" id="cor_fundo<? echo $row['obrarel'] ?>">

         <td onClick="abre_pagina(<? echo $row['obrarel'] ?>,
            '<? echo htmlentities(str_replace("'","`",$row[num_registro]), ENT_QUOTES); ?>');
            " style="cursor:pointer;" onMouseOut="this.style.textDecoration='';
            " onMouseOver="this.style.textDecoration='underline';">
            <? echo "<b>".$row['num_registro']."</b>"?>
         </td>
         <td><?echo $autor;?></td>
         <td><?echo $row['titulo'];?></td>





<? }?>
		  </td>
</tr>
        <tr class="texto">
          <td colspan="5">&nbsp;</td>
          <td></td>
         </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
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

$a="<a href=\"relacionamento_obra.php?obra=$_REQUEST[obra]&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"relacionamento_obra.php?obra=$_REQUEST[obra]&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"relacionamento_obra.php?obra=$_REQUEST[obra]&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"relacionamento_obra.php?obra=$_REQUEST[obra]&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
//echo"$lista_combo";
$g= " Total de relacionamentos para a obra: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='003366'>$g</font>";   
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="5" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
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
</body>
</html>
