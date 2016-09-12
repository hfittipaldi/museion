<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/ajax.js" type="text/javascript"></script>

<script>
function valida()
{
 with(document.form1)
 {
   if (document.form1.tipo[3].checked) {
   }

    if(!tipo[0].checked && !tipo[1].checked&& !tipo[2].checked&& !tipo[3].checked){
return true;
     alert ('Selecione entre papel, pintura ou obra.');
	  return false;} 
	 if(tipo2.value==0){
	 alert('Selecione entre interna ou externa');
	  return false;}
	 if(tipo2.value=='I')
	 {
	   if(numregistro.value=='' and moldura.value=='')
	   {
	     alert('Informe o Nº de registro da Obra ou o número da moldura');
		 numregistro.focus();
	     return false;
	   }
	 }
  }
}
function desabilita()
{
 document.form1.moldura.style.display='none';  
 document.getElementById('rotulo_moldura').style.display='none';
 document.getElementById('rotulo_ou').style.display='none';
 document.getElementById('rotulo_registro').style.display='';
 document.form1.numregistro.style.display='';
 document.getElementById('submit_moldura').style.display='none';


 } 

</script>  
</head>
<body onLoad="desabilita()">      
<table width="497" height="50%"  border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="481" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$op=$_REQUEST['op'];
montalinks();
$_SESSION['lnk']=$link;
$tipo2=$_REQUEST[tipo2];
$tipo=$_REQUEST[tipo];
$numregistro=$_REQUEST[numregistro];
$moldura=$_REQUEST[moldura];
  


?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" onsubmit="return valida();this.focus();" >
     <table width="100%"  border="0" cellpadding="0" cellspacing="8" >
        <tr>
          <td colspan="4">
          </span></td>
        </tr>
        <tr>
          <td width="8%" class="texto_bold">&nbsp;</td>
          <td colspan="3" class="texto"><div align="left"><em>Informe inicialmente
              os par&acirc;metro abaixo: </em></div><br></td>
        </tr>
        <tr>
          <td class="texto_bold"><div align="right">1)</div></td>
          <td colspan="3"><div align="left"><span class="texto_bold">
                <input name="tipo" type="radio" value="1" onclick="document.getElementById('submit_moldura').style.display='none';document.getElementById('rotulo_ou').style.display='none';document.getElementById('rotulo_moldura').style.display='none';document.getElementById('moldura').style.display='none';">
                Papel &nbsp;
                <input name="tipo" type="radio" value="2" onclick="document.getElementById('submit_moldura').style.display='none';document.getElementById('rotulo_ou').style.display='none';document.getElementById('rotulo_moldura').style.display='none';document.getElementById('moldura').style.display='none';">
                  Pintura&nbsp;
                <input name="tipo" type="radio" value="3" onclick="document.getElementById('submit_moldura').style.display='none';document.getElementById('rotulo_ou').style.display='none';document.getElementById('rotulo_moldura').style.display='none';document.getElementById('moldura').style.display='none';">
                  Objeto 3D
                <input name="tipo" type="radio" value="4" onclick="document.getElementById('submit_moldura').style.display='';document.getElementById('rotulo_ou').style.display='';document.getElementById('rotulo_moldura').style.display='';document.getElementById('moldura').style.display='';">
                  Moldura
              </span></div>
           </td> 
      
          </tr>
        <tr>
          <td class="texto_bold"><div align="right">2)</div></td>
          <td nowrap>
              <select name="tipo2" class="combo_cadastro" id="tipo2" 
			   onChange="
                            if (this.options[this.selectedIndex].value=='E' || this.options[this.selectedIndex].value=='0')
                            { 
			       document.getElementById('numregistro').style.display='none';
                                document.getElementById('rotulo_registro').style.display='none';

			      if (!document.form1.tipo[3].checked)
                              { 
                                  document.getElementById('rotulo_moldura').style.display='none';
                                  document.getElementById('moldura').style.display='none';
			          document.getElementById('rotulo_ou').style.display='none';
                               }else{
			          document.getElementById('rotulo_ou').style.display='none';
                                  document.getElementById('moldura').style.display='';
                                  document.getElementById('rotulo_moldura').style.display='';
                                }

				document.form1.submit.disabled=false;
                           }else {
			    document.getElementById('numregistro').style.display='';
                            document.getElementById('rotulo_registro').style.display='';
                            document.getElementById('rotulo_ou').style.display='none';

                            if (document.form1.tipo[3].checked)
                              {
 	                        document.getElementById('rotulo_ou').style.display='';
                                document.getElementById('moldura').style.display='';
				document.getElementById('rotulo_moldura').style.display='';
  
                               }else{
	                        document.getElementById('rotulo_ou').style.display='none';
                                document.getElementById('moldura').style.display='none';
				document.getElementById('rotulo_moldura').style.display='none';


                               }
				document.form1.submit.disabled=false;
     
                              };">
                              onChange="">
			      <option value="0" selected></option>
			      <option value="I" >Pertence ao Museu</option>
                              <option value="E" >não pertence ao Museu</option>



              </select>
	  </td>
          <td nowrap class="texto_bold" align="right" colspan="2">
            <label id="rotulo_registro" class="texto_bold"align="right" style="display:<?  echo ""; ?>;">N&ordm; de registro da obra:</label>
            <input name="numregistro" type="text" class="combo_cadastro" style="display:<? echo ""; ?>; id="numregistro"  value="<? echo $numregistro ?>" size="15"></div>
          </td>
        </tr>
         <tr><td nowrap class="texto_bold" align="center" colspan="2">&nbsp;</td>

         <td nowrap class="texto_bold" align="right" colspan="2">                 
                 <label id="rotulo_ou" class="texto_bold" align="center" style="display:<?  echo "none"; ?>;">ou</label>
         </td>

        </tr> 
        <tr>
           <td nowrap class="texto_bold" align="right" colspan="2">&nbsp;</td>
           <td nowrap class="texto_bold" align="right" colspan="2">                 
                 <label id="rotulo_moldura" class="texto_bold"align="right" style="display:<?  echo "none"; ?>;">N&ordm; de registro da moldura:</label>
                 <input name="moldura" type="text" class="combo_cadastro" style="display:<?  echo "none"; ?>;"id="moldura"  value="<? echo $moldura ?>" size="15"></div>
           </td>

        </tr>

        <tr>
          <td colspan="2" class="texto_bold"><div id='label' align="right"></div></td>
            </tr>
        <tr>
             <td>&nbsp;</td>
          <td width="20%">
              <div align="left">
                <input type="text" name="textfield" style="display:none" >
              </div></td>
 
          </tr>
      </table>

      <table width="100%" align="center" border="0">
       <tr align="center">
          <td width="50%" align="center"><input name="submit" id="submit" type="submit" class="botao" value="Incluir restauro"></td>
          <td width="50%" align="center"><input name="submit_moldura"  id="submit_moldura"  style="display:<?  echo "none"; ?>;" type="submit" class="botao" value="Incluir/editar moldura"></td>
       </tr>
      </table>

      <br>
    </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>

<?
///////////////
//1: para papel
//2:  "   pintura
//num: " numero do registro.
//nao sera mais chamado o controle e sim  o objeto associado a sua chave(parte).
/////////////////
global $db;
if($_REQUEST[tipo2]=='E'){$tipo_2=2;}else{$tipo_2=1;}


   if ($_REQUEST[submit]<>'' or $_REQUEST[submit_moldura]<>'')
   {  

   if ($_REQUEST[tipo]=='') 
        {
          echo"<script> alert('Informe primeiro se é papel, pintura, obra3D ou moldura!')</script>";
             echo "<script>location.href='inclusao_restauro.php?';</script>";       

        }

     if ($_REQUEST[tipo2]=='0')
        {
          echo"<script> alert('Informe se pertence ou não ao Museu!')</script>";
             echo "<script>location.href='inclusao_restauro.php?';</script>";       

        }

   }
//////////////////////////////////////////////////////////////
/////////////// INCLUSÃO DE MOLDURA /////////////////////////
////////////////////////////////////////////////////////////

if ($_REQUEST[submit_moldura]<>'')
{
//################## informando a obra e a moldura ou informando a obra e sem informar a moldura ##############


  if($_REQUEST[numregistro]<>'') 
        {
         echo "<script>location.href='parte_ocorrencia.php?tipo2=$_REQUEST[tipo2]&tipo=$_REQUEST[tipo]&numregistro=$_REQUEST[numregistro]';</script>";
        }

//################# Sem informar a obra informando a moldura ################
 
   if ( $_REQUEST[moldura]<>'')
   {
      global $db;
      $sql="SELECT a.moldura, a.mold_registro, a.parte, a.obra from moldura as a where  a.mold_registro='".trim($_REQUEST[moldura])."'";
      $db->query($sql);
      $conta=$db->dados();
      $parte=$conta['parte'];
      $obra=$conta['obra'];
      $mold_registro=$conta['mold_registro'];
      $moldura=$conta['moldura'];
      if ($parte>0){$tipo_2=1;}else{$tipo_2=2;}

      if($mold_registro=='')
      { 
         echo"<script>var ok=confirm('Moldura disponível para inclusão.Continua?')
	 if(ok)
	 window.location='cadastro_moldura.php?op=insert&mold_registro=$_REQUEST[moldura]&tipo=$_REQUEST[tipo]&tipo2=$tipo_2&form=restauro';
	 </script>";
      }

      if($obra<1 and $conta!=0) //######## moldura externa já cadastrada ##################
      {
         
         echo"<script>var ok=confirm('Moldura:$mold_registro já se encontra cadastrado. Deseja visualizar?')
	 if(ok)
	     window.location='cadastro_moldura.php?op=update&obra=$obra&moldura=$moldura&mold_registro=$mold_registro&tipo=$_REQUEST[tipo]&tipo2=$tipo_2&form=restauro';
	  </script>";

       }  

       if($obra>0 and $conta!=0)//########moldrua interna já cadastrada ##################
       {  
          echo"<script>var ok=confirm('Moldura:$mold_registro já se encontra cadastrado. Deseja visualizar?')
	  if(ok)
	     window.location='cadastro_moldura.php?op=update&obra=$obra&moldura=$moldura&mold_registro=$mold_registro&tipo=$_REQUEST[tipo]&tipo2=$tipo_2&form=restauro';
          </script>";
       }
           

   }

//################# sem informar a obra e a moldura #########################

  if ( $_REQUEST[numregistro]=='')
   {
      echo"<script>var ok=confirm('Deseja incluir uma nova moldura. Continua?')
      if(ok)
         window.location='cadastro_moldura.php?op=insert&tipo=$_REQUEST[tipo]&tipo2=$tipo_2&form=restauro'; 
       </script>";

   }
   echo "<script>location.href='inclusao_restauro.php?tipo2=$_REQUEST[tipo2]&tipo=$_REQUEST[tipo]&numregistro=$_REQUEST[numregistro]&moldura=$_REQUEST[moldura]';</script>";   


} 
//////////////////////////////////////////////////////////////
/////////////// INCLUSÃO DE RESTAURO/////////////////////////
////////////////////////////////////////////////////////////


if ($_REQUEST[submit]<>'')
{
              
//########################### é moldura ###################################      
 
   if ($_REQUEST[tipo]=='4')
   {


         if ($_REQUEST[numregistro]=='' and $_REQUEST[moldura]=='')
          {
             echo"<script> alert('Informe ao menos o número da moldura!')</script>";
             echo "<script>location.href='inclusao_restauro.php?';</script>";       
           }


 
        // caso tenha informado somente a moldura: vai na tabela de moldura e verifica se é interna ou externa
        
         if ( $_REQUEST[moldura]<>'' and $_REQUEST[numregistro]=='')
          {
             global $db;
             $sql="SELECT a.moldura, a.mold_registro, a.parte, a.obra from moldura as a where  a.mold_registro='".trim($_REQUEST[moldura])."'";
             $db->query($sql);
             $conta=$db->dados();
             $num=$conta['mold_registro'];
             $moldura=$conta['moldura'];
             $obra=$conta['obra'];
 
             if ($obra<>''){
             global $db;
             $sql1="SELECT a.obra, a.controle, a.parte, b.num_registro from parte as a inner join obra as b where (a.obra=b.obra) and b.obra='".$obra."'";
             $db->query($sql1);
             $row=$db->dados();
             $numregistro=$row['num_registro'];
             $parte=$row['parte'];
             $obra=$row['obra'];
             $controle=$row['controle'];
             $_REQUEST[numregistro]=$row['num_registro'];  
            if ($parte<>''){$_REQUEST[tipo2]='I';}else{$_REQUEST[tipo2]='E';} 
             }
             if ($moldura<1) { 
              echo"<script> alert('Moldura não cadastrada!')</script>";
              echo "<script>location.href='inclusao_restauro.php?';</script>";       
             }else{
               if ($_REQUEST[tipo2]=='I' and $_REQUEST[numregistro]>0  and  $_REQUEST[moldura]>0)
               {
                  echo "<script>location.href='restauracao_moldura_interna.php?op=insert&tipo2=1&tipo=$_REQUEST[tipo]&pNum_registro=$_REQUEST[numregistro]&pId_parte=$parte&controle=$controle&moldura=$moldura&mold_registro=$num';</script>";       
                }
             }

          }



        if ( $_REQUEST[moldura]=='' and $_REQUEST[numregistro]<>'' )
        {
             global $db;
             $sql1="SELECT a.obra, a.controle, a.parte, b.num_registro, a.moldura from parte as a inner join obra as b where (a.obra=b.obra) and b.num_registro='".$_REQUEST[numregistro]."'";
             $db->query($sql1);
             $row=$db->dados();
             $numregistro=$row['num_registro'];
             $parte=$row['parte'];
             $obra=$conta['obra'];
             $controle=$row['controle'];
             $_REQUEST[numregistro]=$row['num_registro'];
             $moldura=$row['moldura'];
             if ($parte<>''){$_REQUEST[tipo2]='I';}else{$_REQUEST[tipo2]='E';} 
             if ($moldura<>''){
               global $db;
               $sql1="SELECT mold_registro,moldura from moldura where moldura='".$moldura."'";
               $db->query($sql1);
               $row=$db->dados();
               $_REQUEST[moldura]=$row['moldura'];
               $_REQUEST[mold_registro]=$row['mold_registro'];  
             }
      
           if ($moldura<1) { 
              echo "<script> alert('Não existe moldura cadastrada para a obra $_REQUEST[numregistro]!')</script>";
              echo "<script> location.href='inclusao_restauro.php?';</script>";       

           }
        }




 
      // (moldura interna com obra associada) no caso do usuário informar somente o número do registro da obra
      if ($_REQUEST[tipo2]=='I' and $_REQUEST[numregistro]< 1)
          {
            echo "<script>location.href='restauracao_moldura_interna.php?op=insert&tipo2=1&tipo=$_REQUEST[tipo]&pNum_registro=$_REQUEST[numregistro]&pId_parte=$parte&controle=$controle&moldura=$moldura&mold_registro=$num';</script>";       
            }
 
   
      if ($_REQUEST[tipo2]=='I' and $_REQUEST[numregistro]>0 )
          {
          echo "<script>location.href='parte_ocorrencia.php?tipo2=1&tipo=$_REQUEST[tipo]&numregistro=$_REQUEST[numregistro]&pId_parte=$parte&controle=$controle';</script>";
          }
 
      if  ($_REQUEST[tipo2]=='E')
          {
           echo "<script>location.href='restauracao_moldura_externa.php?tipo2=2&tipo=$_REQUEST[tipo]&pNum_registro=$_REQUEST[numregistro]';</script>";       
          }
   




      }



  
//##################### Não é moldura ###########################

  if ($_REQUEST[tipo]<>4)// pode ser papel, pintura ou obra
  {


// (papel, pintura ou obra sem informar o número do registro )
  
     if ($_REQUEST[numregistro]=='' and $_REQUEST[tipo2]=='I')
        {
          echo"<script> alert('Informe o número do registro!')</script>";
        }



     if($_REQUEST[tipo2]=='I' and $_REQUEST[numregistro]<>'') 
        {
         echo "<script>location.href='parte_ocorrencia.php?tipo2=$_REQUEST[tipo2]&tipo=$_REQUEST[tipo]&numregistro=$_REQUEST[numregistro]';</script>";
        }
       

// não pertence ao museu e não ´é moldura

          if($_REQUEST[tipo2]=='E')
          {
             if($_REQUEST[tipo]=='1')// papel externo
             {
               echo"<script>location.href='restauracao_papel_externa.php?tipo2=E';</script>";
             }

             if($_REQUEST[tipo]=='2')// pintura externa
             {
               echo"<script>location.href='restauracao_pintura_externa.php?tipo2=E'</script>";
             }

             if($_REQUEST[tipo]=='3')// obra externa
             {   
               echo"<script>location.href='restauracao_obra_externa.php?tipo2=E'</script>";
             }
           }
        }
   echo "<script>location.href='inclusao_restauro.php?tipo2=$tipo2&tipo=$tipo&numregistro=$numregistro&moldura=$moldura';</script>";   
}
 ?>