<?php
namespace App\entity;

use \Doctrine\ORM\Mapping as ORM;

use \Ideahut\sdms\annotation as IDH;
use \Ideahut\sdms\entity\EntityBigIntIdTimeVersion;


/**
 * @ORM\Entity
 * @ORM\Table(name = "t_user", indexes={@ORM\Index(name="login_idx", columns={"username", "password"})})
 * @IDH\Format
 */
class User extends EntityBigIntIdTimeVersion
{
	
	const ROLE_ADMIN			= 0;
	const ROLE_USER 			= 1;	

	const STATUS_REGISTERED		= 0;
	const STATUS_ACTIVE			= 1;
	const STATUS_INACTIVE		= 2;
	const STATUS_SUSPENDED		= 3;


	/**
     * @ORM\Column(name = "username", type = "string", length = 64, nullable = false, unique = true)
     * @IDH\Document
     */
    public $username;

	/**
     * @ORM\Column(name = "password", type = "string", length = 128, nullable = false)
     * @IDH\Document
     * @IDH\Format(ignore = true)
     */
    public $password;

    /**
     * @ORM\Column(name = "fullname", type = "string", length = 128, nullable = false)
     * @IDH\Document
     */
    public $fullname;

	/**
     * @ORM\Column(name = "phone", type = "string", length = 128, nullable = true)
     * @IDH\Document
     */
    public $phone;

	/**
     * @ORM\Column(name = "email", type = "string", length = 255, nullable = true)
     * @IDH\Document
     */
    public $email;
	
	/**
     * @ORM\Column(name = "address", type = "string", length = 255, nullable = true)
     * @IDH\Document
     */
	public $address;
	
	/**
     * @ORM\Column(name = "status", type = "smallint", nullable = false, options = {"default":1})
     * @IDH\Document
     */
	public $status;
	
	/**
     * @ORM\Column(name = "role", type = "smallint", nullable = false, options = {"unsigned":true, "default":1}) 
     * @IDH\Document
     */
	public $role;

	/**
     * @ORM\Column(name = "photo", type = "string", nullable = true, length = 1024)
     * @IDH\Document
     */
	public $photo;	
	
}