<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AutoLoad
 *
 * @author Gabriel
 */

function __autoload($classe) 
{ 

    include_once "classes/{$classe}.class.php"; 
}

?>
