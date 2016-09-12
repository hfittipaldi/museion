<?

// Delimitado por barras, pontos ou traços
$data = "2.2.%:?&,/1";
$i=0;
$valor= split ('[/.,%*&?};:-]', $data);
while($i<count($valor))
{
echo "$valor[$i]";
$i++;
}

?>
