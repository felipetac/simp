<?php

/**
 * Roteador. Responsável por incluir o controlador e executar o seu respectivo método informado
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace engine;

//use \Exception as Exception;

class Router {

    /**
     * Método responsável por obter o nome do controlador e do método e executá-los.
     * @access public
     * @return void
     */
    public static function run(Request $request) {
        $module = $request->getModule();
        $controller = $request->getController();
        $method = $request->getMethod();
        $args = $request->getArgs();
        
        /*
        var_dump($module);
        var_dump($controller);
        var_dump($method);
        var_dump($args);
         */

        $file = APPLICATION_PATH . $module . "/controllers/" .
                ucfirst($controller) . ".php";

        if (file_exists($file)) {
            define("MODULE_NAME", $module);
            define("ENTITY_NAME", ucfirst($controller));
            define("MODULE_PATH", APPLICATION_PATH . MODULE_NAME);
            define("MODEL_PATH", MODULE_PATH . "/models");
            define("VIEW_PATH", MODULE_PATH . "/views");
            define("DATABASE_INI", MODULE_PATH . "/database.ini");
            define("NSS", "\\");
            define("CONTROLLER_NAMESPACE", "application". NSS . 
                                           MODULE_NAME . NSS . "controllers" . 
                                           NSS . ENTITY_NAME);
            
            define("MODEL_NAMESPACE", "application". NSS . 
                                           MODULE_NAME . NSS . "models" . 
                                           NSS . ENTITY_NAME);
            
            $class = CONTROLLER_NAMESPACE;
            $obj = new $class();
            if (method_exists($obj, $method)) {
                if (!empty($args)) {
                    call_user_func_array(array($obj, $method), $args);
                } else {
                    if ($_POST) {
                        call_user_func(array($obj, $method), $_POST);
                    } else {
                        call_user_func(array($obj, $method));
                    }
                }
            } else {
                throw new \Exception("O método requisitado não existe");
            }
        } else {
            throw new \Exception("O controlador requisitado não existe");
        }
    }
}