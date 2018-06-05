<?php
/**
 * Load classes dynamically
 *
 * @param $classe
 */
function chargerClasse( $classe ) {

     require 'class/'.$classe.'.php';
}

spl_autoload_register('chargerClasse');		