<?

	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");

        $db = new conexao();
        $db->conecta();

        $sql = "select * from usuario";
        $db->query($sql);
        $numlinhas=$db->contalinhas();

?>

        <table border=1>      

<?

        while($linha=$db->dados()) {

?>

                 <tr>
                    <td>
                        <img src="imagens/monitor.bmp">
                    </td>

<?
                    echo "<td>".$linha[nome]."</td>";
                    echo "<td>".$linha[login]."</td>";
                    echo "<td>".$linha[senha]."</td>";

?>
                 </tr>

<?

         }

         echo "<tr><td>Total: ".$numlinhas."</td></tr>";
?>

         </table>
