<?php

namespace Modules\Frontend\Models\Entities;

use Phalcon\Mvc\Model\Validator\Email;

class Users extends \Phalcon\Mvc\Model
{
	private $id;
	private $email;
	private $password;
	private $role;
	private $active;
	private $last_login;
	private $created;
	private $modified;
	
	public function initialize()
	{
		$this->setSource('users');
	}
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param field_type $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param field_type $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @return the $role
	 */
	public function getRole() {
		return $this->role;
	}

	/**
	 * @param field_type $role
	 */
	public function setRole($role) {
		$this->role = $role;
	}

	/**
	 * @return the $active
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * @param field_type $active
	 */
	public function setActive($active) {
		$this->active = $active;
	}

	/**
	 * @return the $last_login
	 */
	public function getLast_login() {
		return $this->last_login;
	}

	/**
	 * @param field_type $last_login
	 */
	public function setLast_login($last_login) {
		$this->last_login = $last_login;
	}

	/**
	 * @return the $created
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @param field_type $created
	 */
	public function setCreated($created) {
		$this->created = $created;
	}

	/**
	 * @return the $modified
	 */
	public function getModified() {
		return $this->modified;
	}

	/**
	 * @param field_type $modified
	 */
	public function setModified($modified) {
		$this->modified = $modified;
	}

	

}