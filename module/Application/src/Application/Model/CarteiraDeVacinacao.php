<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * CarteiraDeVacinacao
 *
 * @ORM\Table(name="CARTEIRA_DE_VACINACAO", indexes={@ORM\Index(name="fk_CARTEIRA_DE_VACINACAO_USUARIO1_idx", columns={"usuario_id"}), @ORM\Index(name="fk_CARTEIRA_DE_VACINACAO_VACINA1_idx", columns={"vacina_id"})})
 * @ORM\Entity
 */
class CarteiraDeVacinacao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="carteira_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $carteiraId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_vacinacao", type="date", nullable=false)
     */
    private $dataVacinacao;

    /**
     * @var \Application\Model\Usuario
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="usuario_id")
     * })
     */
    private $usuario;

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

