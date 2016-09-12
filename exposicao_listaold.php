<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
              $db1=new conexao();
              $db1->conecta();
              $db3=new conexao();
              $db3->conecta();
              $db4=new conexao();
              $db4->conecta();
              $db5=new conexao();
              $db5->conecta();

             
                       


	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
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
	else
		echo "<script>alert('Tipo não informado!'); history.back();</script>";
 ?>
<script>
function abrepopExposicao(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-340)+',top='+((window.screen.height/2)-200)+',width=700,height=440, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}
</script>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
  
       <? $numlinhas=0;
         if ($tipo == 'obra')  $sql="SELECT count(*) as total from obra_exposicao as a inner join exposicao as b on(a.exposicao=b.exposicao) where a.obra=".$obrid;
        if ($tipo == 'autor')  $sql="SELECT count(*) as total from autor_exposicao as a inner join exposicao as b on(a.exposicao=b.exposicao) where a.autor=".$autid;

	  $db->query($sql);
	  $numlinhas=$db->dados();
                 $numlinhas=$numlinhas[0];
	

          $sql4="SELECT DISTINCT substring(dt_inicial,1,4) as datainicial, a.tipo as intext,a.exposicao
                     FROM exposicao as a  INNER JOIN  ".$tipo."_exposicao as b on (a.exposicao=b.exposicao)  
                        where $tipo='$valor'order by a.tipo,a.dt_inicial,a.nome";
           $db4->query($sql4);
        ?>



   <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td  width="100%" colspan="8" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="93%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;" ><div align="left"> &nbsp;Exposições </div>
             </td>

          <td width="7%" align="center" style="border-right: 1px solid #121212;"><? $ref="exposicao_insere2.php?op=insert&".$parametro."=".$valor;?>
         <a href='javascript:;' onClick="abrepopExposicao('<?echo $ref;?>');"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Adicionar exposição'></a>
           

        </tr>


         <tr>
          <td height="2" colspan="8" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>      

<?

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
         ////////////////Lista as exposições referenta a obra por ano /////////////////////////////////////////////
         /////////////////////////////////////////////////////////////////////////////////////////////////////////	 
	  
       
       while($row4=$db4->dados())
       {
          $datainicial=$row4[datainicial];   
          $tot="0";
           
	  $sql2="SELECT a.exposicao as expid,a.nome,a.instituicao,a.periodo,a.cidade,a.estado,a.pais,a.tipo,b.* 
                    FROM exposicao as a INNER JOIN  ".$tipo."_exposicao as b on (a.exposicao=b.exposicao) 
                       where ($tipo='$valor')and(substring(dt_inicial,1,4)='$datainicial') order by a.tipo, a.dt_inicial, a.nome";
	  $db->query($sql2);
            
	   ?>


      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" >


                               <?  if (($intext=='0') and ($row4[intext]=='')){?>
                                   <tr class="texto_bold"><td width="20%"><font color="#96ADBE"><b><?echo "não especificadas";?></b></font></td></tr> 
                               <?}else{ 
                                 if ($intext<>$row4[intext]) {?>
                                 <?if ($row4[intext]=='C') {?>
                                    <tr class="texto_bold"><td width="20%"><font color="#96ADBE"><b><?echo "coletivas";?></b></font</td></tr>
                                 <?}else{?>
                                    <tr  class="texto_bold"><td width="20%"><font color="#96ADBE"><b><?echo "Individuais";?></b></font</td></tr>
                               <?  } 
			     }}
                               $intext=$row4['intext'];?>


          <tr class="texto" id="cor_fundo<? echo $datainicial ?>">
         <?if ($tot==0) {?>
              <td valign="top" class="texto" width="5%">
             <? if ( $datainicial == '0000') {  echo "<b>s/d</b>";}else{echo "<b>".$datainicial."</b>";}?>            
             </td>
           <?}?>
 
		
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
           ?>   
            

           <?if ($tot>0) {?>     
             <td valign="top" width="5%">         
                  <?echo "";?>
             
           <?}?>
              <? $tot=$tot+1;?>

          
	     <?echo "<b>- ".$row['nome'].", "."</b>".$row['instituicao'].", ".$row['cidade'].", ";
               if (strtoupper($nome_pais)=="BRASIL") {echo $nome_estado.", ";}
	       echo $nome_pais.", ".$row['periodo'].". "."<em>";
               echo "<font color='blue'>".$row['premio']; ?>              
           </td> 
           <?if ($tot>0) {?>
           <td width="5%" align="center"><? echo "<a href=\"exposicao_insere.php?op=del&".$parametro."=".$valor."&id=".$row[($tipo.'_exposicao')]."\"
						onClick='return confirm(".'"O item será removido da lista. Confirma Remoção ?"'.")'><img src='imgs/icons/ic_remover.gif' border='0' alt='Remover da lista' 
						onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
						onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>
	   </td>
           <td width="5%" align="center"><? echo "<a href=\"exposicao_insere.php?op=update&".$parametro."=".$valor."&id=".$row['expid']."\">
						<img src='imgs/icons/ic_alterar.gif' width='20' height='20'border='0' alt='Alterar' 
					              onMouseOver='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"#ddddd5\";' 
                 			                            onMouseOut='document.getElementById(\"cor_fundo".$row[expid]."\").style.backgroundColor=\"\";'>";?>

	 </td>
        <?}?>
         </tr>      
           
       <?}
      }?>

        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
         </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      <tr class="texto">
          <td colspan="4" height="20"><? 
		   
  

$g= " Total de exposições: $numlinhas";
echo"&nbsp";
echo"<font color='003366'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
    </form>
	</td>
  </tr>
</table>
</body>
</html>