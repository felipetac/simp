<?php

namespace application\escola\controllers;

use application\escola\models\Turma,
    engine\Controller;

class Aluno extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->set("mainNavItem", "Alunos");
        $turma = new Turma();
        $this->view->set("turmas", $turma->findAll("nome"));
    }

    public function index() {
        $this->buscar();
    }

    public function buscar($params = null) {
        $this->model->setParams($params);
        $nome = $this->model->getNome();
        $page = empty($params['page']) ? 1 : $params['page'];
        $result = $this->model->findByName($nome, $page);
        $result = empty($result) ? null : $result;
        $this->view->set("resultado", $result);
        $this->view->set("nome", $nome);
        $this->view->set("title", "Aluno");
        if ($page == 1)
            $this->view->render("aluno/index");
        else
            $this->view->render("aluno/listar-ajax");
    }

    public function novo() {
        $this->view->set("title", "Novo Aluno");
        $this->view->render("aluno/gravar");
    }

    public function editar($id) {
        $this->view->set("title", "Editar Aluno");
        $turma = new Turma();
        $this->view->set("turmas", $turma->findAll("nome"));
        $model = $this->model->find($id);        
        $this->view->set("aluno", $model);
        $this->view->render("aluno/gravar");
    }

    public function excluir($id) {
        if ($this->model->delete((int) $id)) {
            $this->msg("success", "Item excluído com sucesso!");
        } else {
            $this->msg("error", "Item não encontrado ou já excluido(s)!");
        }
        $this->redirect("escola/aluno");
    }

    public function gravar($params) {
        $entity = $this->model->save($params);
        if (!is_object($entity)) {
            $this->msg("success", "Item salvo com sucesso!");
            $this->redirect("escola/aluno");
        } else {
            $this->msg("warning", $entity->erros);
            $this->view->set("title", "Editar Aluno");
            $this->view->set("aluno", $entity);
            $this->view->render("aluno/gravar");
        }     
    }

}