<?php

namespace application\escola\models;

use engine\Model;

/**
 * @Entity
 * @Table(name="historico")
 *
 */
class Historico extends Model {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="text") */
    private $observacoes;

    public function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    public function getObservacoes() {
        return $this->observacoes;
    }

}
