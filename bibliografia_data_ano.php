
<?
include("classes/classe_padrao.php");

include("classes/funcoes_extras.php");
			$db=new conexao();
			$db->conecta();
			$db1=new conexao();
			$db1->conecta();?>


<html>
<head>

<script type="text/javascript" src="sorttable.js"></script>
<style type="text/css">
th, td {
  padding: 3px !important;
}
/* Sortable tables */
table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
}
</style>


<title>MGR 1.0 - Este programa varre toda a tabela de Bibliografia verificando  se o campo ANO esta nulo. Caso esteja sera atualizado com o conteudo do campo DATA.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#CCCCFF">
<table align="center" cellpadding="4" cellspacing="2" width="90%" border="1">
	<tr>
		<td bgcolor="#FFFFFF" align="center"> Atualizando ...  </td>
	</tr>
                     <tr><td><?echo "_____________________________________________________________________________________________________________";?></td></tr>  
                        <tr><td align="center"><b><?echo " ########## Atualiza campo ANO em Bibliograifa usando campo DATA  se ANO='' ############ ";?> </b></td></tr>			      		                       
                        <tr><td><?echo "_____________________________________________________________________________________________________________";?></td></tr>  

	<tr>
		<td align="center" style="border-width: 0px;">
		<?php
  $pagesize=1;
      if(!empty($_REQUEST['pagesize']))
         $pagesize=$_REQUEST['pagesize'];
      $page=1;
      if(!empty($_REQUEST['page']))
         $page=$_REQUEST['page'];
      $page--;
	/*  $impressao = 0;
      if(!empty($_GET['impressao']))
         $impressao=$_GET['impressao'];

	  /////Paginando
      $page=1;
  
      if(!empty($_GET['page']))
         $page=$_GET['page'];
	  $pagesize=10;
      if($impressao!='') {
         $pagesize=999999;
		 $page=1;
	   }
      $page--;*/
	  $registroinicial=$page* $pagesize;
?>

                  <table class="sortable" border="1" > 
                  <tr>
                     <td>
  	          <?$sql="select bibliografia, data, ano from bibliografia where (((ano='0') or (ano='')) and (data<>'')) order by bibliografia";
	              $db->query($sql);
                            while ($row=$db->dados()) 
                             {
                              echo 'Bibliografia:'.$row[bibliografia].' DATA: '.$row[data].' ANO: '.$row[ano].'  atual ->  ANO: '.$row[data];?>

                               <? $sql1="update bibliografia set ano='$row[data]' where bibliografia='$row[bibliografia]' order by bibliografia";
                                    $db1->query($sql1);
                                  ?>                         
                              <br> 
                        <? } ?>
                   </td></tr>  
                   </table>                     
                        <tr><td><?echo "_____________________________________________________________________________________________________________";?></td></tr>  
                        <tr><td align="center"><b><?echo "                                   ########## FIM ############                      ";?> </b></td></tr>			      		                       
                       <tr><td><?echo "_____________________________________________________________________________________________________________";?></td></tr>  

   </table>
</body>
</html>
