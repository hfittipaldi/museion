<?
//Header para evitar cache
header("Content-type: text/html; charset=iso-8859-1");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db1=new conexao();
$db1->conecta();
echo "<span class='texto_bold'>Objeto:</span>";
echo "<select name=\"parte\" class=combo_cadastro onchange=ativacao(this.options[this.selectedIndex].value)>";
$sql="SELECT nome_objeto,parte,dim_mold_possui FROM parte AS a, obra AS b
    WHERE (a.obra = b.obra) AND b.num_registro = '$_GET[ID]'";

$db->query($sql);
echo "<option value=\"#\"></option>";
while($row=$db->dados())
{
 $sql1="select num_registro from moldura where parte='".$row[1]."'";
 $db1->query($sql1);
 $linha=$db1->dados();
 $moldura=$linha[0];
 $chave=$moldura.".".$row[2].".".$row[1];
 echo "<option value=\"$chave\">$row[0]</option>";
}
echo "</select>";
?>
