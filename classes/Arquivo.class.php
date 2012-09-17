<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Arquivo
 *
 * @author Gabriel
 */
class Arquivo {

    //put your code here
    public $nome_arquivo;
    public $caminho;
    public $diretorio;
    public $bd;

    function __construct($arquivo) {
        $this->nome_arquivo = $arquivo['name'];
        $this->caminho = $arquivo['tmp_name'];
        $this->diretorio = "arquivos/";
        $this->bd = Banco::instanciarBanco();
    }

    function uploadArquivo() {
        $this->verificarNomeArquivo();

        $arquivo = $this->diretorio . $this->nome_arquivo;
        if (move_uploaded_file($this->caminho, $arquivo)) {
            return true;
        } else {
            return false;
        }
    }

    function verificarNomeArquivo() {
        for ($x = 1; $this->bd->teveRetorno($this->bd->executarQuery("SELECT id_atividade FROM atividades WHERE nome_arquivo LIKE '" . $this->nome_arquivo . "'")); $x++):
            $array_nome = explode('.', $this->nome_arquivo);
            $this->nome_arquivo = $array_nome[0] . date('s');
            $this->nome_arquivo .= "." . $array_nome[1];
        endfor;
    }

}

?>
