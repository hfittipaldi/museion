<?
class linha_cor{ 
    var $cores, $linha; 

    function linha_cor(){ 
        $this->linha = 0;     
    } 

    function adicionar_cor($cor){ 
        $this->cores[] = $cor; 
    } 

    function exibir_cor(){ 
        $cor = $this->linha%count($this->cores); 
        $this->linha++; 
        return $this->cores[$cor]; 
    } 
}
function template_off($tem_txt)
{
    $resposta = "";

	    if(file_exists($tem_txt))
		//echo $GLOBALS["path_modulo_templates"]."/".$tem_txt;
        {
                $HTML = file($tem_txt);
                $counter = 0;
                $counter = count($HTML);
                        for($i = 0;$i < $counter;$i++)
        {
                $linha = $HTML[$i];
            while(ereg("troca##",$linha))
            {
            $var = split("##",$linha,3);
                            if(!isset($GLOBALS[$var[1]]))
                                                                                {
                                                                                $v = " ";
                                                                                }
                                                                else
                                                                                {
                                                                                $v = $GLOBALS[$var[1]];
                                                                                $v = str_replace("#","?%29",$v);
                                                                                }
                                  $linha = ereg_replace("troca##".$var[1]."##",$v,$linha);
                                        }
                $resposta .= $linha;
        }
        }
return(str_replace("?%29","#",$resposta));
}
?>