<html>
<head>
<title>MGR 1.0 - Atualiza o menu de todos os usuarios de nivel administrador</title>
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
			$db1->conecta();
			$db2=new conexao();
			$db2->conecta();

			set_time_limit(0);
			//$dsn= "donato";// "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=".str_replace("/","\\",$_SERVER["DOCUMENT_ROOT"])."\donato\migracao\mdb\acervo.mdb";
			//$con= odbc_connect($dsn,'root','visao03') or die('<br>Erro na conexão com o banco de dados.');
			//if (!$con) {
			//	exit("<br>Conexão Falhou: " . $con);
			//}

	                $sql="UPDATE usuario set nivel='A' where nome='ADMINISTRADOR'";
	                $db->query($sql);


                        $sql1="SELECT max(usuario_menu_item) FROM usuario_menu_item b;";
                        $db->query($sql1);
                        $res=$db->dados();
                        $count=$res[0];
                        $tot=1;
                        
                        $sql2="delete from usuario_menu_item where ((item='117')or(item='4323')or(item='4313')or(item='63')or(item='631')or(item='632'))";
                        $db1->query($sql2);
 

                        $sql2="select count(*) from usuario  where nivel='A'";
                        $db1->query($sql2);
                        $res1=$db1->dados();
                        $usu=$res1[0];

			$sql2="select usuario from usuario a where a.nivel='A'";
			$db1->query($sql2);
			while($res1=$db1->dados())
                        {



                          $count++;
                          $sql2="insert usuario_menu_item set usuario_menu_item='".$count."', usuario='".$res1[0]."', item='117'";
			  $db2->query($sql2);
 
                          $count++;
                          $sql2="insert usuario_menu_item set usuario_menu_item='".$count."', usuario='".$res1[0]."', item='4323'";
			  $db2->query($sql2);
 
                          $count++;
                          $sql2="insert usuario_menu_item set usuario_menu_item='".$count."', usuario='".$res1[0]."', item='4324'";
			  $db2->query($sql2);

                          $count++;
			  $sql2="insert usuario_menu_item set usuario_menu_item='".$count."', usuario='".$res1[0]."', item='4313'";
			  $db2->query($sql2);

                          $count++;
			  $sql2="insert usuario_menu_item set usuario_menu_item='".$count."', usuario='".$res1[0]."', item='63'";
			  $db2->query($sql2);

                          $count++;
			  $sql2="insert usuario_menu_item set usuario_menu_item='".$count."', usuario='".$res1[0]."', item='631'";
			  $db2->query($sql2);

                          $count++;
			  $sql2="insert usuario_menu_item set usuario_menu_item='".$count."', usuario='".$res1[0]."', item='632'";
			  $db2->query($sql2);
                          
                          $tot++;

    
                           }
                     ?>

                           <table border="0" cellpadding="0" cellspacing="0"> 
                              <tr>
                                 <td><?echo "Incluindo novos menus para usuarios com status ADMINISTRATIVO, sao eles:";?> </td></tr>
			         <tr><td><?echo "Obras / Incluir com publicacao";?></td></tr>
			         <tr><td><?echo "Consultas / estatistica / acervo / %doador";?></td></tr>
			         <tr><td><?echo "Consultas / estatistica / acervo / %consulta autor";?></td></tr> 
			         <tr><td><?echo "Consultas / estatistica / acervo / %por obra";?></td></tr>
 			         <tr><td><?echo "Estrutura / manutencao / bibliografia";?></td></tr>			   
                                 <tr><td><?echo "Estrutura / manutencao / exposicao";?></td></tr> 
                                 <tr><td><?echo "_______________________________________________________________";?></td></tr> 
  
                                 <tr><td><?echo "O ADMINISTRADOR ( PERFIL_1) passou para o nivel ADMINISTRADOR.";?></td></tr> 

                           </table>                     
 
	<tr>
		<td bgcolor="#FFFFFF" align="center"> Fim da atuazacao.  </td>
	</tr>

   </table>
</body>
</html>
