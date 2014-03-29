<?php

/**
 * Classe para trabalhar com dados de sessão
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace engine;

class Session {

    /**
     * Inicializa a sessão
     * @access public
     * @return void
     */
    public static function start() {
        if (!isset($_SESSION)) {
            session_start();
            session_regenerate_id();
        }
    }

    /**
     * Grava uma informação na sessão
     * @access public
     * @param String $key
     * @param String $value
     * @return void
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Retorna um dado da sessão
     * @access public
     * @param String $key
     * @return String
     */
    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    /**
     * Destrói um ou todos os dados da sessão
     * @access public
     * @return void
     */
    public static function destroy($key = null) {
        if ($key) {
            unset($_SESSION[$key]);
        } else {
            session_destroy();
        }
    }

}