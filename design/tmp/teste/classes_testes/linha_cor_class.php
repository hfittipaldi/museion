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
?>