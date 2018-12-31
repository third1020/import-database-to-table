<?php


namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\UserModel;

class ContactEntity extends Entity {
	protected $id;
	protected $remark;
	protected $contact_name;
	protected $contact_phone;
	protected $contact_email;
	protected $contact_address;
	protected $contact_detail;
	protected $created_by;
	protected $created_at;
	protected $updated_at;
	protected $user_id;
	
	/**
	 * @return mixed
	 */
	public function getUser_id() {
		return $this->user_id;
	}
	
	/**
	 * @return mixed
	 */
	public function getUser() {
	    $userModel = new UserModel();
	    
	    $user = null;
	    if(!empty($this->user_id))
	    $user = $userModel->find($this->user_id);
	    
	    return $user;
	}

	/**
	 * @param mixed $user_id
	 */
	public function setUser_id($user_id) {
		$this->user_id = $user_id;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getRemark() {
		return $this->remark;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getContact_name() {
		return $this->contact_name;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getContact_phone() {
		return $this->contact_phone;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getContact_email() {
		return $this->contact_email;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getContact_address() {
		return $this->contact_address;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getContact_detail() {
		return $this->contact_detail;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getCreated_by() {
		return $this->created_by;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getCreated_at() {
		return $this->created_at;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUpdated_at() {
		return $this->updated_at;
	}

	/**
	 *
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 *
	 * @param mixed $equipment_detail
	 */
	public function setRemark($remark) {
		$this->remark = $remark;
	}

	/**
	 *
	 * @param mixed $equipment_name
	 */
	public function setContact_name($contact_name) {
		$this->contact_name = $contact_name;
	}

	/**
	 *
	 * @param mixed $equipment_name
	 */
	public function setContact_phone($contact_phone) {
		$this->contact_phone = $contact_phone;
	}

	/**
	 *
	 * @param mixed $equipment_name
	 */
	public function setContact_email($contact_email) {
		$this->contact_name = $contact_name;
	}

	/**
	 *
	 * @param mixed $equipment_name
	 */
	public function setContact_address($contact_address) {
		$this->contact_address = $contact_address;
	}

	/**
	 *
	 * @param mixed $equipment_name
	 */
	public function setContact_detail($contact_detail) {
		$this->contact_detail = $contact_detail;
	}

	/**
	 *
	 * @param mixed $created_by
	 */
	public function setCreated_by($created_by) {
		$this->created_by = $created_by;
	}

	/**
	 *
	 * @param mixed $created_at
	 */
	public function setCreated_at($created_at) {
		$this->created_at = $created_at;
	}

	/**
	 *
	 * @param mixed $updated_at
	 */
	public function setUpdated_at($updated_at) {
		$this->updated_at = $updated_at;
	}
}
