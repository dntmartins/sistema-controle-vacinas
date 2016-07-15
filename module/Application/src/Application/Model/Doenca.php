<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Doenca
 *
 * @ORM\Table(name="DOENCA")
 * @ORM\Entity
 */
class Doenca
{
    /**
     * @var integer
     *
     * @ORM\Column(name="doenca_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $doencaId;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;
    public function __set($name, $value) {
    	$this->$name = $value;
    }
    public function __get($name) {
    	return $this->$name;
    }

}

