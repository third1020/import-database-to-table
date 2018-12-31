<?php namespace App\Entities;

use CodeIgniter\Entity;

class NewsEntity extends Entity
{
    protected $id;
    protected $remark;
    protected $news_title;
    protected $news_detail;
    protected $news_type;
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
	public function getNews_title() {
		return $this->news_title;
	}

	/**
	 * @return mixed
	 */
	public function getNews_detail() {
		return $this->news_detail;
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
		$date=date_create($this->created_at);
		
		return date_format($date,"Y/m/d");
	}

	/**
	 * @return mixed
	 */
	public function getUpdated_at() {
		$date=date_create($this->updated_at);
				
		return date_format($date,"Y/m/d");
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
	 * @param mixed $news_title
	 */
	public function setNews_title($news_title) {
		$this->news_title = $news_title;
	}

	/**
	 * @param mixed $news_detail
	 */
	public function setNews_detail($news_detail) {
		$this->news_detail = $news_detail;
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
	/**
	 * @return mixed
	 */
	public function getNews_type() {
		return $this->news_type;
	}

	/**
	 * @param mixed $news_type
	 */
	public function setNews_type($news_type) {
		$this->news_type = $news_type;
	}

	
	
}
