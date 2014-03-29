<?php
/**
 * Controlador 'index' da aplicação.
 */
namespace application\escola\controllers;

use engine\Controller;

class Index extends Controller
{
	public function index()
	{
            $this->view->render("index/index");
	}
}