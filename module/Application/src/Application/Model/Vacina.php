<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vacina
 *
 * @ORM\Table(name="VACINA", indexes={@ORM\Index(name="fk_VACINA_DOENCA1_idx", columns={"doenca_id"})})
 * @ORM\Entity
 */
class Vacina
{
    /**
     * @var integer
     *
     * @ORM\Column(name="vacina_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $vacinaId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validade", type="date", nullable=false)
     */
    private $validade;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var \Application\Model\Doenca
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Doenca")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="doenca_id", referencedColumnName="doenca_id")
     * })
     */
    private $doenca;
    public function __set($name, $value) {
    	$this->$name = $value;
    }
    public function __get($name) {
    	return $this->$name;
    }

}

