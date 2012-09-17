<?php

include_once "classes/AutoLoad.php";

$sessao = new Sessoes();
$sessao->deslogar();

header("location: index.php");

?>
