<?php

namespace application\escola\controllers;

use engine\Controller;

final class Turma extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->set("mainNavItem", "Turmas");
    }

    public function index() {
        $this->buscar();
    }

    public function buscar($params = null) {
        $this->view->set("title", "Turma");
        $this->model->setParams($params);
        $nome = $this->model->getNome();
        $result = $this->model->findByName($nome);
        $result = empty($result) ? null : $result;
        $this->view->set("resultado", $result);
        $this->view->set("nome", $nome);
        $this->view->render("turma/index");
    }

    public function novo() {
        $this->view->set("title", "Nova Turma");
        $this->view->render("turma/gravar");
    }

    public function editar($id) {
        $this->view->set("title", "Editar Turma");
        $model = $this->model->find($id);
        $this->view->set("id", $id);
        $this->view->set("nome", $model->getNome());
        $this->view->render("turma/gravar");
    }

    public function excluir($id) {
        if ($this->model->delete((int) $id)) {
            $this->msg("success", "Item excluído com sucesso!");
        } else {
            $this->msg("error", "Item não encontrado ou já excluido(s)!");
        }
        $this->redirect("escola/turma");
    }

    public function gravar($params) {
        if ($this->model->save($params)) {
            $this->msg("success", "A habilitação foi gravada com sucesso!");
        } else {
            $this->msg("error", "Não foi possível gravar a habilitação enviada!");
        }
        $this->redirect("escola/turma");
    }
}