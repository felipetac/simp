<?php

/**
 * Modelo base para os modelos da aplicação.
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace engine;

use engine\Database,
    Respect\Validation\Validator as v;

class Model {
    
    protected $em;

    /**
     * Método construtor
     * @access public
     * @return void
     */
    public function __construct() {
        $this->em = Database::getEntityManager();
    }

    public function delete($id) {
        $entity = $this->em->find(get_class($this), $id);
        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
            return true;
        }
    }
    
    public function save($params) {
        $id = empty($params['id']) ? 0 : $params['id'];
        $entity = $this->em->find(get_class($this), $id);
        if (empty($entity)) {
            $entity = $this;
        }
        $entity->setParams($params, $this->em);
        $entity->erros = $entity->validate();
        
        if (!is_array($entity->erros)){
            $this->em->persist($entity);
            $this->em->flush();
            return true;
        }
        return $entity;
    }
    
    /* Este método deve ser implementado nas classes filhas */
    protected function validate(){
        return true;
    }
    
    public function find($id, $entity = false) {
        if ($entity) {
            return $this->em->find($entity, $id);
        } else {
            return $this->em->find(get_class($this), $id);
        }
    }

    public function findAll($orderBy = null, $order = 'ASC') {
        if ($orderBy && $order) {
            if ($order == 'DESC')
                $dql = "SELECT e FROM " . get_class($this) . " e ORDER BY e." . $orderBy . " DESC";
            else
                $dql = "SELECT e FROM " . get_class($this) . " e ORDER BY e." . $orderBy . " ASC";
        }
        else {
            $dql = "SELECT e FROM " . get_class($this) . " e";
        }
        return $this->em->createQuery($dql)->getResult();
    }
    
    protected function setDate($date){
        $date = implode('-',array_reverse(explode('/', $date)));
        return $date && v::date()->validate($date) ? new \DateTime($date) : $date;
    }
    
    protected function getDate($date, $format='d/m/Y'){
        return $date && v::date()->validate($date) ? $date->format($format) : $date;
    }
}