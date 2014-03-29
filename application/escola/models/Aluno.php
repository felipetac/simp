<?php

namespace application\escola\models;

use engine\Model,
    application\escola\models\Historico,
    application\escola\models\Turma,
    Pagerfanta\Pagerfanta,
    Respect\Validation\Validator as v;

/**
 * @Entity
 * @Table(name="aluno")
 */
class Aluno extends Model {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", nullable=false) */
    private $nome;

    /** @Column(type="date", nullable=true) */
    private $aniversario;

    /**
     * @OnetoOne(cascade={"remove"}, targetEntity="Historico")
     * @JoinColumn(name="id_historico", referencedColumnName="id")
     */
    private $historico;

    /**
     * @ManyToOne(targetEntity="Turma")
     * @JoinColumn(name="id_turma", referencedColumnName="id")
     */
    private $turma;

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setAniversario($aniversario) {
        $this->aniversario = $this->setDate($aniversario);
    }

    public function getAniversario() {
        return $this->getDate($this->aniversario);
    }

    public function setHistorico(Historico $historico) {
        $this->historico = $historico;
    }

    public function getHistorico() {
        return $this->historico;
    }

    public function setTurma(Turma $turma) {
        $this->turma = $turma;
    }

    public function getTurma() {
        return $this->turma;
    }

    public function validate() {
        try {
            $validator = v::attribute('nome', v::allOf(
                                    v::string()->setName("NomeIsString"), v::notEmpty()->setName("NomeIsEmpty")
                            )->setName("NomeError")
                    )->attribute('aniversario', v::allOf(
                            v::date()->setName("NiverIsDate"), v::minimumAge(18)->setName("NiverMinimumAge"), v::notEmpty()->setName("NiverIsEmpty")
                    )->setName("AniversarioError"));
            $validator->assert($this);
        } catch (\InvalidArgumentException $e) {
            $this->errors = $e->findMessages(array(
                'NomeError' => 'Erro(s) no campo "Nome":',
                'NomeIsString' => '-- O "Nome" não é uma String',
                'NomeIsEmpty' => '-- O "Nome" é de preenchimento obrigatório',
                'AniversarioError' => 'Erro(s) no campo "Aniversário":',
                'NiverIsDate' => '-- O "Aniversário" não é uma data válida!',
                'NiverMinimumAge' => '-- O "Aniversário" precisa ser preenchido com uma data igual ou superior a 18 anos',
                'NiverIsEmpty' => '-- O "Aniversário" é de preenchimento obrigatório'
            ));
            return $this->errors;
        }
        return true;
    }

    public function setParams($params, $entityManager = null) {
        $this->em = isset($entityManager) ? $entityManager : $this->em;
        $this->setNome(empty($params['nome']) ? null : $params['nome']);
        $this->setAniversario(empty($params['aniversario']) ? null : $params['aniversario']);
        $idTurma = empty($params['turma']) ? 0 : $params['turma'];
        $this->turma = $this->em->find('\\application\\escola\\models\\Turma', $idTurma);
        $obs = empty($params['observacao']) ? '' : $params['observacao'];

        if (empty($this->id)) {
            $historico = new Historico();
            $historico->setObservacoes($obs);
            $this->em->persist($historico);
            $this->historico = $historico;
        } else {
            $historico = $this->getHistorico();
            $historico->setObservacoes($obs);
            $this->historico = $historico;
        }
    }

    public function findByName($nome, $currentPage = 1, $maxPerPage = 4) {
        $dql = "SELECT a FROM " . get_class($this) . " a WHERE UPPER(a.nome) LIKE UPPER(:nome) ORDER BY a.nome ASC";
        $query = $this->em->createQuery($dql)->setParameter("nome", "%" . $nome . "%");
        $pager = new Pagerfanta(new \Pagerfanta\Adapter\DoctrineORMAdapter($query));
        $pager->setMaxPerPage($maxPerPage);
        $pager->setCurrentPage($currentPage);
        return $pager;
    }

}