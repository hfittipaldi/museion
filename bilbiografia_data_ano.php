<?

?>
<html>
<head>
<title>MGR 1.0 - Este programa varre toda a tabela de Bibliografia verificando  se o campo ANO esta nulo. Caso esteja sera atualizado com o conteudo do campo DATA.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#CCCCFF">
<table align="center" cellpadding="4" cellspacing="2" width="90%" border="1">
	<tr>
		<td bgcolor="#FFFFFF" align="center"> Atualizando ...  </td>
	</tr>
	<tr>
		<td align="center" style="border-width: 0px;">
		<?php

                               include("classes/classe_padrao.php");
                               include("classes/funcoes_extras.php");


			$db=new conexao();
			$db->conecta();
			$db1=new conexao();
			$db1->conecta();?>

                   <table border="0" cellpadding="0" cellspacing="0"> 
                  <tr>
                     <td>
	          <? $sql="select a.bibliografia, a.data, a.ano from bibliografia as a where (a.data='') and (a.ano<>'')";
	              $db->query($sql);
                             echo $sql;
                            while($res=$db->dados())
                             {  
                                     $sql1="update bibliografia set data='$res[ano]'";
                                     $db1->query($sql1);
                                     $res1=$db1->dados();     ?>         
                                  <tr> <td>
                                   <?echo "Bibliografia:".$res[bibliografia]."  ANO:".$res[ano];?>
                                   </td></tr>                               
                                <? $tot++;
                           } ?>
                        <tr><td><?echo "Fim da atualizacao.:";?> </td></tr>			      		   
                        <tr><td><?echo "Total de ".$tot." registros atualizados.";?></td></tr> 
                        <tr><td><?echo "_______________________________________________________________";?></td></tr>  
                   </td></tr>  
                    </table>                     
 
   </table>
</body>
</html>
