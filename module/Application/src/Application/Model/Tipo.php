<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipo
 *
 * @ORM\Table(name="TIPO", indexes={@ORM\Index(name="fk_TIPO_VACINA1_idx", columns={"vacina_id"})})
 * @ORM\Entity
 */
class Tipo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tipoId;

    /**
     * @var string
     *
     * @ORM\Column(name="nome_tipo", type="string", length=45, nullable=false)
     */
    private $nomeTipo;

    /**
     * @var \Application\Model\Vacina
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Vacina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vacina_id", referencedColumnName="vacina_id")
     * })
     */
    private $vacina;
    public function __set($name, $value) {
    	$this->$name = $value;
    }
    public function __get($name) {
    	return $this->$name;
    }

}

