

<html>
<head>
<title>MGR 1.0 - Migração Donato</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#CCCCFF">
<table align="center" cellpadding="4" cellspacing="2" width="90%" border="1">
	<tr>
		<td bgcolor="#FFFFFF" align="center"> MAnutenção na tabela de PARTES </td>
	</tr>
	<tr>
		<td align="center" style="border-width: 0px;">
		<?php
			include("duracao.php");
			include("conexao.php");
			include("../classes/funcoes_extras.php");
        $db=new conexao();
        $db->conecta();
	$dbu=new conexao();
	$dbu->conecta();


   alert ("ATENÇÃO: Esse programa verifica em toda a base DONATO se na tabela de partes o campo Material_tecnica está nulo enquanto em obra está preenchido. Nesse caso o campo em parte é atualizado com a informação do campo Material_tecnica de obra.");


$sql="SELECT count(*) as total from  obra as o where (o.material_tecnica='')";
$db->query($sql);
$total_obra=$row[total];

if ( $total_obra > 0 )
   alert ("ATENÇÃO: apenas ".$total_obra." obra sem o campo MATERIAL_TECNICA preenchido!");

if ( $total_obra > 1 )
   alert ("ATENÇÃO: são ".$total_obra." obras sem o campo MATERIAL_TECNICA preenchido!");


$sql="SELECT count(*) as total from  obra as o inner join parte as p on(o.obra=p.obra)where ((o.material_tecnica<>'') and (p.material_tecnica=''))";
$db->query($sql);

if ( $row[total] > 0 ) 
{   $sql="Select o.material_tecnica as mat_obra, p.material_tecnica as mat_parte from obra as o inner join parte as p on (o.obra=p.obra) where (o.material_tecnica<>'') and (p.material_tecnica='')";
    $db->query($sql);
    $row=$db->dados();
    while($row=$db->dados()) 
    {

     $sqlup="UPDATE parte set material_tecnica='$row[mat_obra]'where obra=$row[obra] and parte=$row[parte]";
     $rowup=$dbu->dados();
     }
alert('Fim da atualização.');

}else{

alert('Não existe parte com o campo Material_Tecnica vazio para obras com Material_Tecnica preenchido.');

}


?>
</td>
</tr>
</table>
</body>
</html>
