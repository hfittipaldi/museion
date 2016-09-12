<html>
<head>
<title>MGR 1.0 - Migração Donato</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#CCCCFF">
<table align="center" cellpadding="4" cellspacing="2" width="90%" border="1">
	<tr>
		<td bgcolor="#FFFFFF" align="center"> Migrando Funcao </td>
	</tr>
	<tr>
		<td align="center" style="border-width: 0px;">
		<?php
			include("duracao.php");
			include("conexao.php");
			include("../classes/funcoes_extras.php");
			$db=new conexao();
			$db->conecta();
			$db1=new conexao();
			$db1->conecta();
			set_time_limit(0);
			// diretorio onde o .mdb deverá ficar: \Program Files\Apache Group\Apache\htdocs\donato\migracao\mdb\nome_arquivo.mdb //
			$dsn= "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=".str_replace("/","\\",$_SERVER["DOCUMENT_ROOT"])."\donato\migracao\mdb\acervo.mdb";
			$con= odbc_connect($dsn,'root','visao03') or die('<br>Erro na conexão com o banco de dados.');
			if (!$con) {
				exit("<br>Conexão Falhou: " . $con);
			}
			$recomeco=$_REQUEST['rec'];
			if ($recomeco == '') {
				$recomeco= 0;
			}
			$sql= "SELECT * from parte where parte > $recomeco order by parte";
                        $db->query($sql);
                        $tot=0;
			$babou=0;
			while ($resp=$db->dados()) {
                                $parte=$resp['parte'];
				$obra=$resp['obra'];
                                $controle=$resp['controle'];
                                echo "<br>".$obra."-".$parte;
				//
                                $sql1="select TOMBO from ACERVO where ID=".$obra;
				$rs= odbc_exec($con,$sql1);
				$tombo= trim(odbc_result($rs,"TOMBO"));
                                if ($tombo=='') {
					echo "<br>Este nao tem no Donato Antigo....";
				} else {
                                	echo "<br>SQL 1 = ".$sql1;
					//
                                	$sql2="select count(tombo) as TOTAL from acervo where tombo=".$tombo;
					$rs= odbc_exec($con,$sql2);
					$total= trim(odbc_result($rs,"TOTAL"));
					echo "<br>SQL 2 = ".$sql2;
					//
					if ($total>0) {
                                		if (($total==1) || ($controle=='')) {
							$sql3="select FOTO, NEGATIVO, DIAPOSITIV, RESTAURADO from ACERVO where ID=".$obra;
						} else {
							$sql3="select FOTO, NEGATIVO, DIAPOSITIV, RESTAURADO from ACERVO where ID=".$obra." and CONTROLE='".$controle."'";
                                		}
						//
						echo "<br>SQL 3 = ".$sql3;
						$rs= odbc_exec($con,$sql3);
						$f=trim(odbc_result($rs,"FOTO"));
						$n=trim(odbc_result($rs,"NEGATIVO"));
						$d=trim(odbc_result($rs,"DIAPOSITIV"));
						$r=trim(odbc_result($rs,"RESTAURADO"));
						//
 						$foto="N";
						$negativo="N";
						$diapositivo="N";
						$restauro="N";
						//
						if ($f==1) {
							$foto="S";
						}
						if ($n==1) {
							$negativo="S";
						}
						if ($d==1) {
							$diapositivo="S";
						}
						if ($r==1) {
							$restauro="S";
						}
                                		$sql="update parte set tem_foto='$foto', tem_negativo='$negativo', tem_diapositivo='$diapositivo', tem_restauro='$restauro' where parte='$parte'";
						$db1->query($sql);
                                        	echo "<br>Atualizado dados da Parte ".$parte; 
                                        	$tot++;
					} else {
						echo "<br>Babou. Nao achou a Parte ".$parte;
						$babou++;
					}

				}
                 	}
                        echo "<br>Total Acertado: ".$tot;
			echo "<br>Total Falhado: ".$babou;

?>

</body>
</html>
