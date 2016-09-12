<?
include_once("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
?>

<html>
   <head>

      <? 
         $db=new conexao();
         $db->conecta();
 	 $sql= "SELECT CODIGO from info a";
 	 $db->query($sql);
         $codigo=$_REQUEST['codigo'];
      ?>

      <title><? echo  nome_instituicao() ?></title>

      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2"> <! entrada de dados >
         <tr><! #### - ENTRADA DE DADOS - #### >
		<! #### - CÓDIGO - #### >
            <td class="texto_bold"><div>Código:
               <input 
                  name="codigo" id="codigo" class="combo_cadastro" 
                  size=10 rows="1"><? echo $codigo; ?>
               </input> 
	    </td>

            <td> <! #### - STATUS - #### >
               Status:
               <select name="status" class="combo_cadastro" id "status" value="<?$_REQUEST['status'];?>">
	          <option value=""></option>
	          <option value="I"<?if ($operacao==P) echo "selected";?>>Pendente</option>
                  <option value="A"<?if ($operacao==L) echo "selected";?>>Liberado</option>
                  <option value="E"<?if ($operacao==M) echo "selected";?>>em manutenção</option>
                  <option value="E"<?if ($operacao==A) echo "selected";?>>Aguardando</option>
               </select>
	    </td>

		<! #### - DESCRIÇÃO - #### >         
            <td class="texto_bold"><div align="left">Descri&ccedil;&atilde;o:
               <textarea 
                  name="descricao" id="descricao" class="combo_cadastro roll" 
                   cols="45" rows="6"><? echo $descricao; ?>
               </textarea>
            </td>
  
		<! #### - OBSERVAÇÃO - #### >
            <td class="texto_bold"><div align="left">Observa&ccedil;&atilde;o:
               <textarea 
                  name="observacao" id="observacao" class="combo_cadastro roll" <? if ($tipo=='2' && $op=='update') { echo "readonly"; } ?> cols="45" rows="6"> <? echo $observacao; ?>
               </textarea>
             </td>

		<! #### - GRAVAR - #### >
            <td width="10%">&nbsp;<br><br></td>
            <td><input align='middle' name="submit" type="submit" class="botao" value="Gravar">
            <input name="info" type="hidden" id="info" value="<? echo $_REQUEST[info] ?>"><br><br></td>     
         </tr> <! #### - ENTRADA DE DADOS - #### >





         $sql="UPDATE info set info='$_POST[assunto]', texto='$_POST[notas]', data_aviso='$Data', eh_lida='$lida' where agenda='$notid'";
	 $db->query($sql);
	 echo"<script>alert('Alteração efetuada com sucesso.')</script>";
	 $hoje= date("Y-m-d");
	 $sql= "SELECT count(*) as total from agenda where usuario = '$_SESSION[susuario]' AND eh_lida = '0' AND data_aviso = '$hoje'";
	 $db->query($sql);
	 $totMSG= $db->dados();




         <! #### - lista de dados - #### >
         <table id="rodape" width="100%" border="0" bgcolor="#96ADBE"> 
            <tr>
               <td width="10%" align=center>
                  <?echo"CÓDIGO";?> 
               </td>
               <td width="5%" align=center>
                  <?echo "STATUS";?>  
               </td>
               <td width="60%" align=center>
                  <?echo "DESCRIÇÃO";?>  
               </td>
               <td width="25%" align=center>
                  <?echo "OBS";?> 
               </td>
               <form>
                  <imput type=checkbox >
	       </form>
            </tr>
         </table> <! lista de dados >

      </table> <! entrada de dados >
   </head>
</html>