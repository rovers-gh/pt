<?php

namespace Modules\Frontend\Models\Entities;

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email;

class Users extends \Phalcon\Mvc\Model
{
	const DELETED = '1';	
	const NOT_DELETED = '0';
	
	private $id;
	private $email;
	private $password;
	private $name;
	private $role;
	private $active;
	private $del_flg;
	private $regist_url;
	private $last_login;
	private $created;
	private $modified;
	
	public function initialize()
	{
		$this->setSource('users');
		$this->useDynamicUpdate(true);
		$this->addBehavior(new SoftDelete(
				array(
						'field' => 'del_flg',
						'value' => self::DELETED
				)
		));
	}
	public function beforeCreate()
	{
		$this->created = new \Phalcon\Db\RawValue('now()');
	}
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
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
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
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
	 * @return the $del_flg
	 */
	public function getDel_flg() {
		return $this->del_flg;
	}

	/**
	 * @param field_type $del_flg
	 */
	public function setDel_flg($del_flg) {
		$this->del_flg = $del_flg;
	}

	/**
	 * @return the $regist_url
	 */
	public function getRegist_url() {
		return $this->regist_url;
	}

	/**
	 * @param field_type $regist_url
	 */
	public function setRegist_url($regist_url) {
		$this->regist_url = $regist_url;
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