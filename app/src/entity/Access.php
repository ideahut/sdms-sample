<?php
namespace App\entity;

use \Doctrine\ORM\Mapping as ORM;

use \Ideahut\sdms\entity\EntityTime;

/**
 * @ORM\Entity
 * @ORM\Table(name = "t_access")
 * @FORMAT(show_null=false)
 */
class Access extends EntityTime
{

    /**
     * @ORM\Column(name="KEY_", type = "string", nullable = false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "UUID")
     * @FORMAT     
     */
    public $key;

	/**
     * @ORM\ManyToOne(targetEntity = "User", fetch = "EAGER")
     * @ORM\JoinColumn(name = "f_user", referencedColumnName = "ID_", unique = false, nullable = true, onDelete="CASCADE")
     * @FORMAT(type=\App\project\entity\User)
     */ 
    public $user;

    /**
     * @ORM\Column(name = "validation", type = "string", length = 2048, nullable = false)
     * @FORMAT     
     */
    public $validation;

    /**
     * @ORM\Column(name = "expiration", type = "bigint", nullable = false, options = {"unsigned":true, "default":0})
     * @FORMAT     
     */
	public $expiration;
    
    
    public function hasExpired() {        
		$now = round(microtime(true) * 1000);
		return $now > $this->expiration;
	}
        
}