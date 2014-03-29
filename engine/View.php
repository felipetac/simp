<?php

namespace engine;
use engine\Session;

class View extends \PHPTAL {

    public $session;
    
    public function __construct() {
        parent::__construct();
        $this->setEncoding("UTF-8");
        $this->set("title", "Principal");
        $this->set("mainNavItem", "Principal");
        $this->set("base", SITE_URL);
        
        $this->session = new Session();
        $this->session->start();        
    }

    public function render($template) {
        $this->setSessions();
        parent::setTemplate(VIEW_PATH . "/" . $template . ".xhtml");
        echo parent::execute();
        exit;
    }
    
    private function setSessions() {
        if ($this->session->get("success")) {
            $this->set("success", $this->session->get("success"));
            $this->session->destroy("success");
        }
        if ($this->session->get("error")) {
            $this->set("error", $this->session->get("error"));
            $this->session->destroy("error");
        }
        if ($this->session->get("warning")) {
            $this->set("warning", $this->session->get("warning"));
            $this->session->destroy("warning");
        }
    }

}