<?php

/**
 * Description of Alertas
 *
 * @author Gabriel
 */
class Alerta {

    private static $arrayMensagens;
    private static $posicaoAtual = 0;

    public static function alertarUsuario($msg, $status = 0) {
        /*
         * Classe utilizada para setar alertas para o usuario
         * 
         */

        self::$arrayMensagens[self::$posicaoAtual]['mensagem'] = $msg;
        self::$arrayMensagens[self::$posicaoAtual]['status'] = $status;
        self::$posicaoAtual += 1;
    }

    public static function alertaMostrar() {
        /*
         * Classe utilizada para mostrar o alerta na tela para o usuario
         * Caso o status 1: Sucesso
         * Caso o status 0(padrão): Error
         *  
         */

        /* Variavel responsavel pela aspas simples */
        $a = "'";
        if (is_array(self::$arrayMensagens)):
            foreach (self::$arrayMensagens as $value):
                if ($value['status'] != 0):
                    echo '<script>$("#alerta").append(' . $a . '<div class="alerta sucesso">' . $value['mensagem'] . '</div>' . $a . ');</script>';

                else:
                    if ($value['mensagem'] != "")
                        echo '<script>$("#alerta").append(' . $a . '<div class="alerta erro">' . $value['mensagem'] . '</div>' . $a . ');</script>';
                endif;
            endforeach;
            //Resetamos as variaveis
            self::$posicaoAtual = 0;
        endif;
    }

}

?>
