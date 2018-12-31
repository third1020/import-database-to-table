<?php namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\UserModel;

class MessageEntity extends Entity
{
    protected $id;
    protected $remark;
    protected $message_title;
    protected $message_message;
    protected $message_from;
    protected $message_to;
    protected $created_at;
    protected $updated_at;
    protected $status;
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getRemark() {
		return $this->remark;
	}

	/**
	 * @return mixed
	 */
	public function getMessage_title() {
		return $this->message_title;
	}

	/**
	 * @return mixed
	 */
	public function getMessage_message() {
		return $this->message_message;
	}

	/**
	 * @return mixed
	 */
	public function getMessage_from() {
		$userModel = new UserModel();
		$user = $userModel->find($this->message_from);
		
		return $user->username;
	}

	/**
	 * @return mixed
	 */
	public function getMessage_to() {
		$userModel = new UserModel();
		$user = $userModel->find($this->message_to);
		
		return $user->username;
	}
	
	/**
	 * @return mixed
	 */
	public function getUser_from() {
		$userModel = new UserModel();
		$user = $userModel->find($this->message_from);
		
		return $user;
	}
	
	/**
	 * @return mixed
	 */
	public function getUser_to() {
		$userModel = new UserModel();
		$user = $userModel->find($this->message_to);
		
		return $user;
	}

	/**
	 * @return mixed
	 */
	public function getCreated_at() {
		$date=date_create($this->created_at);
		
		return date_format($date,"Y/m/d");
	}

	/**
	 * @return mixed
	 */
	public function getUpdated_at() {
		return $this->updated_at;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param mixed $remark
	 */
	public function setRemark($remark) {
		$this->remark = $remark;
	}

	/**
	 * @param mixed $message_title
	 */
	public function setMessage_title($message_title) {
		$this->message_title = $message_title;
	}

	/**
	 * @param mixed $message_message
	 */
	public function setMessage_message($message_message) {
		$this->message_message = $message_message;
	}

	/**
	 * @param mixed $message_from
	 */
	public function setMessage_from($message_from) {
		$this->message_from = $message_from;
	}

	/**
	 * @param mixed $message_to
	 */
	public function setMessage_to($message_to) {
		$this->message_to = $message_to;
	}

	/**
	 * @param mixed $created_at
	 */
	public function setCreated_at($created_at) {
		$this->created_at = $created_at;
	}

	/**
	 * @param mixed $updated_at
	 */
	public function setUpdated_at($updated_at) {
		$this->updated_at = $updated_at;
	}

	/**
	 * @param mixed $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}
}
