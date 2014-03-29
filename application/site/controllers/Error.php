<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Error
 *
 * @author Felipe
 */
namespace application\site\controllers;

class Error {
    
    /**
     * Método construtor
     * @access public
     * @return void
     */
    public function __construct($msg) {
        echo  $msg;
    }
}

?>
