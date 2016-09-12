<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">


<script>

function obtem_valor(qual,expid) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
var id = expid;
var texto='exposicao_manut_detobra.php?page='+ i+ '&id='+ id;

document.location=('exposicao_manut_detobra.php?page='+ i+ '&id='+ id );



}}

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
<table width="542"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">


       <?
	include("classes/classe_padrao.php");
        include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();
        $db3=new conexao();
        $db3->conecta();
        $expid= $_REQUEST['id'];
        $tipo="obra";       
        ?>


        <?
	/////Paginando
	$pagesize=6;
        $page=1;
        if(!empty($_GET['page']))
            $page=$_GET['page'];
        $page--;
	$registroinicial=$page* $pagesize;

	$sql3="SELECT nome,periodo 
               FROM exposicao where exposicao=".$_REQUEST[id];
        //echo $sql3;
 	$db3->query($sql3);
        $row=$db3->dados();
        $exposel=$row[nome];
        $expoano=$row[periodo];
      
        //obra
        $sql="SELECT count(*) as total 
              FROM exposicao as a INNER JOIN  obra_exposicao as b on 
              (a.exposicao=b.exposicao) INNER JOIN obra as c on (b.obra=c.obra) 
              where a.exposicao=".$_REQUEST[id]." order by a.nome";
        //echo $sql;
	$db->query($sql);
	$numlinhas=$db->dados();
        $numlinhas=$numlinhas[0];

        //obra
	$sql2="SELECT a.exposicao as expid,a.nome,a.instituicao,a.periodo,a.cidade,a.estado,a.pais,b.obra,c.titulo, c.num_registro 
               FROM exposicao as a INNER JOIN  obra_exposicao as b on 
               (a.exposicao=b.exposicao) INNER JOIN obra as c on (b.obra=c.obra) 
               where a.exposicao=".$_REQUEST[id]. " order by a.nome LIMIT $registroinicial,$pagesize";
        //echo $sql2;
 	$db->query($sql2);
	?>

<body>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="10">
      <tr>
         <td valign="top"><form name="form1" method="get" onSubmit='true' action="exposicao_manut_detobra.php">
                 <tr>
                    <table width="100%" height="20"  border="0" cellspan="1" cellpadding="0" cellspacing="0">
 
                       <tr bgcolor="#96ADBE">
                       <td colspan="3" bgcolor="#000000" class="texto"><img src="imgs/transp.gif" width="100" height="1"></td>
                       </tr>
                      
                       <tr width="100%" bgcolor="#ddddd5">
                       <td  colspan="3" width="50%" height="25" class="texto_bold"><div align="left"> &nbsp;<?echo "Título da exposição"?> </div></td>
                       </tr> 

                       <tr>
                       <td  colspan="3" height="2" bgcolor="#000000" ><img src="imgs/transp.gif" width="100" height="1"></td>
                       </tr>
                       <tr><td width="100%" height="25" class="texto"><div align="left"> &nbsp;(<? echo $_REQUEST[id] ?>)  - <? echo $expoano ?> - <em><b><?echo $exposel?> </em></b></div></td></tr>
                       <tr bgcolor="#96ADBE">
                       <td colspan="3" bgcolor="#000000" class="texto"><img src="imgs/transp.gif" width="100" height="1"></td>
                       </tr>
 

                       <tr width="100%" bgcolor="#ddddd5">
                       <td width="45%" height="20" bgcolor="#ddddd5" class="texto"><div align="left"><b> &nbsp;Nº de registro </b>- Título da obra  </div></td>
                       <td width="100%" height="20" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;</div></td>
                       </tr> 

                       <tr>
                       <td   colspan="3" height="2" bgcolor="#000000" ><img src="imgs/transp.gif" width="100" height="1"></td>
                       </tr>

                        <?

                         while($row=$db->dados()) 
                         
                        {

               
		        ?>                  

                    </table>       
                    <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >
                        <tr width="100%" class="texto" id="cor_fundo<? echo $row['expid'] ?>">

                        <? if ($row['num_registro']!="") 
                           {?> 
                            <td width="100%"><?echo "<b>".$row['num_registro']."</b> - ".$row['titulo']."";?></td>
                         <?} else {?>
                            <td width="50%"><?echo "<b>";?></td>
                         <?}?>
                       </tr>
		       <? } ?>
                       <tr class="texto">
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                         <td align="center">&nbsp;</td>
                       </tr>
                       <tr>
                          <td  colspan="3" height="1" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
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


                          $a="<a href=\"exposicao_manut_detobra.php?page=".$first."&id=".$expid."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";
                          $b="<a href=\"exposicao_manut_detobra.php?page=".$menos."&id=".$expid."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";
                          $c="<a href=\"exposicao_manut_detobra.php?page=".$mais."&id=".$expid."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";
                          $d="<a href=\"exposicao_manut_detobra.php?page=".$last."&id=".$expid."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
                          $combo="";

                          for($i=1;$i<=$numpages;$i++)
                          {
                             if ($i==$page_atual) {
                                $combo = $combo . "<option value='$i' selected >$i</option>";}
                          else{
                             $combo.="<option value='$i'>$i</option>";}
                          } 
                          $lista_combo="<select name=i value=$i onChange='obtem_valor(this,".$expid.")'; >$combo</select>";  
                          if ($last < 2) {
	                     $lista_combo= "";
	                     $a= "";
	                     $b= "";
	                     $c= "";
	                     $d= "";
                           }
                          $g= " Total de exposições: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
                          ".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
                          echo"&nbsp";
                          echo"<font color='003366'>$g</font>";   
                       ?>               
                       <div align="center"></div></td>
                    </tr>
                    <tr>
                       <td  colspan="3" height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
                    </tr>
                    <tr>
                       <td colspan="4"></td>
                    </tr>
                 </table>
              </form>
	   </td>
           <div align="left"><? echo "<a href=\"javascript:history.back();\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
        </tr>
     </table>
  </table>
</body>
</html>