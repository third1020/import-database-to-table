<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\PermissionModel;

class UserEntity extends Entity
{
	protected $id;
	protected $remark;
	protected $username;
	protected $password;
	protected $permission_id;
	protected $created_at;
	protected $updated_at;
	protected $name;
	protected $id_card;
	protected $phone_number;
	protected $email;
	
	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getRemark()
	{
		return $this->remark;
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return mixed
	 */
	public function getPermission_id()
	{
		return $this->permission_id;
	}

	/**
	 * @return mixed
	 */
	public function getCreated_at()
	{
		return $this->created_at;
	}

	/**
	 * @return mixed
	 */
	public function getUpdated_at()
	{
		return $this->updated_at;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getId_card()
	{
		return $this->id_card;
	}

	/**
	 * @return mixed
	 */
	public function getPhone_number()
	{
		return $this->phone_number;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}
	
	/**
	 * @return mixed
	 */
	public function getPermissionName()
	{
		$permissionModel = new PermissionModel();
		$per = $permissionModel->find($this->permission_id);
		$per->permission_name;
		
		return $per->permission_name;;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param mixed $remark
	 */
	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @param mixed $permission_id
	 */
	public function setPermission_id($permission_id)
	{
		$this->permission_id = $permission_id;
	}

	/**
	 * @param mixed $created_at
	 */
	public function setCreated_at($created_at)
	{
		$this->created_at = $created_at;
	}

	/**
	 * @param mixed $updated_at
	 */
	public function setUpdated_at($updated_at)
	{
		$this->updated_at = $updated_at;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param mixed $id_card
	 */
	public function setId_card($id_card)
	{
		$this->id_card = $id_card;
	}

	/**
	 * @param mixed $phone_number
	 */
	public function setPhone_number($phone_number)
	{
		$this->phone_number = $phone_number;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function expose() {
		$var = get_object_vars($this);
		foreach ($var as &$value) {
			if (is_object($value) && method_exists($value,'getJsonData')) {
				$value = $value->getJsonData();
			}
		}
		return $var;
	}
}