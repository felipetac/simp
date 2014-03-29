<?php

namespace application\escola\controllers;

use application\escola\models\Turma,
    engine\Controller;

class Professor extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->set("mainNavItem", "Professores");
    }

    public function index() {
        $this->buscar();
    }

    public function buscar($params = null) {
        $this->view->set("title", "Professor");
        $this->model->setParams($params);
        $nome = $this->model->getNome();
        $page = empty($params['page']) ? 1 : $params['page'];
        $result = $this->model->findByName($nome, $page);
        $result = empty($result) ? null : $result;
        $this->view->set("resultado", $result);        
        $this->view->set("nome", $nome);
        
        $this->view->render("professor/index");
    }

    public function novo() {
        $this->view->set("title", "Novo Professor");
        $turma = new Turma();
        $this->view->set("turmas", $turma->findAll("nome"));
        $this->view->set("turmasAll", $this->model->getAllOptions());
        $this->view->render("professor/gravar");
    }

    public function editar($id) {
        $this->view->set("title", "Editar Professor");
        $turma = new Turma();
        $this->view->set("turmas", $turma->findAll("nome"));
        $model = $this->model->find((int) $id);
        $this->view->set("id", $id);
        $this->view->set("nome", $model->getNome());
        $this->view->set("turmasSelected", $model->getSelectedTurmas());
        $this->view->set("turmasUnselected", $model->getUnselectedTurmas());
        $this->view->set("turmasAll", $model->getAllOptions());
        $this->view->render("professor/gravar");
    }

    public function excluir($id) {
        if ($this->model->delete((int) $id)) {
            $this->msg("success", "Item excluído com sucesso!");
        } else {
            $this->msg("error", "Item não encontrado ou já excluido(s)!");
        }
        $this->redirect("escola/professor");
    }

    public function gravar($params) {
        if ($this->model->save($params)) {
            $this->msg("success", "Item salvo com sucesso!");
        } else {
            $this->msg("error", "Item não pode ser salvo!");
        }
        $this->redirect("escola/professor");
    }

}