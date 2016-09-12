<?php
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db1=new conexao();
$db1->conecta();
$db2=new conexao();
$db2->conecta();
?>
//Criacao de Formulario
<form name=teste method=post>
	<table border=1>
	<tr>
		<td>Codigo</td><td><input type=text name=codigo></td>
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

echo "Incluir: ".$_REQUEST['inclui']."<br>";
echo "Alterar: ".$_REQUEST['altera']."<br>";
echo "Excluir: ".$_REQUEST['deleta']."<br>";

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
{
	$db->query($sql);
}

echo "<br><table border=1>";
echo "<tr><td>C&oacute;digo</td><td>Nome da Pessoa</td><td>Sexo</td></tr>";
$sql1="select * from tabela order by codigo";
$db1->query($sql1);
while($linha=$db1->dados()) 
{
	echo "<tr>";
	echo "<td>";
	echo "<a href=http://127.0.0.1/donato/grava.php?codigo=".$linha['codigo'].">".$linha['codigo']."</a>";
	echo "</td>";
	echo "<td>".$linha['nome']."</td>";
	$sqlSexo="select descricao from sexo where codigo='".$linha['sexo']."'";
	$db2->query($sqlSexo);
	$sexo=$db2->dados();
	echo "<td>".$sexo['descricao']."</td>";
	echo "</tr>";
}
echo "</table>";

?>
