<?php
namespace App\entity;

use \Doctrine\ORM\Mapping as ORM;

use \Ideahut\sdms\annotation as IDH;
use \Ideahut\sdms\entity\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name = "t_test")
 * @IDH\Format
 * @IDH\Document(ignore = true)
 */
class Test extends Entity {

	/**
     * @ORM\Column(name = "id", type = "bigint", nullable = false, options = {"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @IDH\Document
     */
	public $id;

	/**
     * @ORM\Column(name = "name", type = "string", length = 32, nullable = false)
     * @IDH\Document
     */
    public $name;    

}