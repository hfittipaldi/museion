<?php
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");

$db=new conexao();
$db->conecta();
$db1=new conexao();
$db1->conecta();
$db2=new conexao();
$db2->conecta();
$teste='teste123';
?>
//Criacao de Formulario
<form name=teste method=post>
	<table border=1>
	<tr>
		<td>Codigo</td><td><input type=text name=codigo value='teste'></td>
               
 	</tr>
	<tr>
		<td>Nome</td><td><input type=text name=nome></td>
	</tr>
	<tr>
		<td>Sexo</td>
		<td><select name=sexo>
			<?php
			$sqlSexo="select * from sexo";
			$db2->query($sqlSexo);
			while ($sexo=$db2->dados())
			{
				echo "<option value=".$sexo['codigo'].">".$sexo['descricao']."</option>";
			}
			?>
		</select>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<input type=submit name=inclui value="Grava">
                	<input type=submit name=altera value="Altera">
			<input type=submit name=deleta value="Exclui">
		</td>
	</tr>
	</table>
</form>
</body>


<?php

$sql='';
$codigo=$_REQUEST['codigo'];
$nome=$_REQUEST['nome'];
$sexo=$_REQUEST['sexo'];

if($_REQUEST['inclui']<>'')
{
	$sql="insert into tabela (codigo, nome, sexo) values (".$codigo.", '".$nome."', '".$sexo."')";
}

if($_REQUEST['altera']<>'')
{
	$sql="update tabela set nome='".$nome."', sexo='".$sexo."' where codigo=".$codigo;
}


if($_REQUEST['deleta']<>'')
{

	$sql="delete from tabela where codigo=".$codigo;
}

echo "<br>".$sql."<br>";
if ($sql<>'')



?>
