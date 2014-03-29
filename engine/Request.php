<?php

/**
 * Classe responsável por obter os segments da URL informada
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace engine;

class Request {

    private $_module;
    private $_controller;
    private $_method;
    private $_args = array();

    /**
     * Método construtor
     * @access public
     * @return void
     */
    public function __construct() {
        $this->_url = isset($_GET["url"]) ? $_GET["url"] : 'site/index/index';
        $segments = explode('/', strtolower($this->_url));

        $this->_module = ($mo = array_shift($segments)) ? $mo : "site";
        $this->_controller = ($c = array_shift($segments)) ? $c : "index";
        $this->_method = ($me = array_shift($segments)) ? $me : "index";
        $this->_args = (isset($segments[0])) ? $segments : array();
    }

    /**
     * Retorna o nome do modulo
     * @access public
     * @return String
     */
    public function getModule() {
        return $this->_module;
    }

    /**
     * Retorna o nome do controlador
     * @access public
     * @return String
     */
    public function getController() {
        return $this->_controller;
    }

    /**
     * Retorna o nome do método
     * @access public
     * @return String
     */
    public function getMethod() {
        return $this->_method;
    }

    /**
     * Retorna os segmentos adicionais (argumentos)
     * @access public
     * @return Array
     */
    public function getArgs() {
        return $this->_args;
    }

}