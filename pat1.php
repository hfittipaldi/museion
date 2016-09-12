<?

	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");

        $db = new conexao();
        $db->conecta();

        $sql = "select * from usuario";
        $db->query($sql);
        $numlinhas=$db->contalinhas();

        echo "<table border=1>";      

        while($linha=$db->dados()) {
                 echo "<tr>";
                    echo "<td>";
                        echo "<img src='imagens/monitor.bmp'>";
                    echo "</td>";
                    echo "<td>";
                        echo $linha[nome];
                    echo "</td>";
                    echo "<td>";
                        echo $linha[login];
                    echo "</td>";
                    echo "<td>";
                        echo $linha[senha];
                    echo "</td>";
                 echo "</tr>";
         }

         echo "<tr><td>Total: ".$numlinhas."</td></tr>";
         echo "</table>";

?>
