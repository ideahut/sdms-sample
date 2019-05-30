<?php
namespace App\repository;

use \Ideahut\sdms\repository\CrudRepository;

interface UserRepository extends CrudRepository 
{
	public function countByStatusAndRole($status, $role);


	public function getByUsername($username);

	public function findByFullname($fullname);

	public function findAllByFullname($fullname);

	public function findAllById($id);

	public function findById($id);


	public function deleteById($id);	

	
	public function mapUsername();

	public function mapUsernameByFullname($fullname);

	public function mapByFullname($fullname);

}