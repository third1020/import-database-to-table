<?php namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\NewsModel;

class NewsTypeEntity extends Entity
{
    protected $id;
    protected $remark;
    protected $type_name;
    protected $created_by;
    protected $created_at;
    protected $updated_at;
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
	public function getType_name() {
		return $this->type_name;
	}

	/**
	 * @return mixed
	 */
	public function getCreated_by() {
		return $this->created_by;
	}

	/**
	 * @return mixed
	 */
	public function getCreated_at() {
		return $this->created_at;
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
	public function getNews() {
		$newsModel = new NewsModel();
		$news = $newsModel->where('news_type', $this->id)
			->orderBy('id', 'desc')
			->findAll(5, 0);
		
		return $news;
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
	 * @param mixed $type_name
	 */
	public function setType_name($type_name) {
		$this->type_name = $type_name;
	}

	/**
	 * @param mixed $created_by
	 */
	public function setCreated_by($created_by) {
		$this->created_by = $created_by;
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

	
    
}
