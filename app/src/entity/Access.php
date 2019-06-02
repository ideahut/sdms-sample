<?php
namespace App\entity;

use \Doctrine\ORM\Mapping as ORM;

use \Ideahut\sdms\annotation as IDH;
use \Ideahut\sdms\entity\EntityTime;

/**
 * @ORM\Entity
 * @ORM\Table(name = "t_access")
 * @IDH\Format
 */
class Access extends EntityTime
{

    /**
     * @ORM\Column(name="KEY_", type = "string", nullable = false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "UUID")  
     * @IDH\Document  
     */
    public $key;

	/**
     * @ORM\ManyToOne(targetEntity = "User", fetch = "EAGER")
     * @ORM\JoinColumn(name = "f_user", referencedColumnName = "ID_", unique = false, nullable = true, onDelete="CASCADE")
     * @IDH\Document(type = User::class)
     * @IDH\Format(type = User::class)
     */ 
    public $user;

    /**
     * @ORM\Column(name = "validation", type = "string", length = 2048, nullable = false)
     * @IDH\Document
     */
    public $validation;

    /**
     * @ORM\Column(name = "expiration", type = "bigint", nullable = false, options = {"unsigned":true, "default":0})
     * @IDH\Document
     */
	public $expiration;
    
    
    public function hasExpired() {        
		$now = round(microtime(true) * 1000);
		return $now > $this->expiration;
	}
        
}