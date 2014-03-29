<?php
/**
 * Bootstrap da aplicação
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace engine;

use Doctrine\Common\ClassLoader,
    application\site\controllers\Error as ErrorController;

final class Bootstrap {

    /**
     * Carrega app.
     * @access public
     * @return void
     */
    public static function run() { 
        
        require_once '../engine/vendor/autoload.php';
        
        setlocale(LC_ALL, "pt_BR.utf-8", "pt_BR", 'portuguese-brazil', 'ptb', "pt_BR.iso-8859-1", "portuguese");
        header("Content-Type: text/html; charset=utf-8", true);
        
        define('NAME_PROJECT', 'simp');
        define('SITE_URL', 'http://localhost/' . NAME_PROJECT . '/');
        define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']);
        define('APPLICATION_PATH', SITE_ROOT . NAME_PROJECT . '/application/');
        
        $classLoader = new ClassLoader();
        $classLoader->setIncludePath('../');
        $classLoader->register();

        try {
            Router::run(new Request());
        } catch (\Exception $e) {
            new ErrorController($e->getMessage());
        }
    }
}

Bootstrap::run();