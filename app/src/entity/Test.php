<?php
namespace App\entity;

use \Doctrine\ORM\Mapping as ORM;
use \Ideahut\sdms\entity\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name = "t_test")
 * @FORMAT(show_null=false) 
 */
class Test extends Entity {

	/**
     * @ORM\Column(name = "id", type = "bigint", nullable = false, options = {"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @FORMAT
	 */
	public $id;

	/**
     * @ORM\Column(name = "name", type = "string", length = 32, nullable = false)
     * @FORMAT
     */
    public $name;    

}