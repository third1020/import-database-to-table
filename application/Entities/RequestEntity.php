<?php namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\EquipmentModel;

class RequestEntity extends Entity
{
    protected $id;
    protected $remark;
    protected $request_tital;
    protected $request_detail;
    protected $request_status;
    protected $equipment_id;
    protected $created_by;
    protected $created_at;
    protected $updated_at;

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
  	public function getTital()
  	{
  		return $this->request_tital;
  	}

  	/**
  	 * @return mixed
  	 */
  	public function getDetail()
  	{
  		return $this->request_detail;
  	}

  	/**
  	 * @return mixed
  	 */
  	public function getStatus()
  	{
  		return $this->request_status;
  	}

  	/**
  	 * @return mixed
  	 */
  	public function getEquipment_id()
  	{
  		return $this->equipment_id;
  	}
  	
  	/**
  	 * @return mixed
  	 */
  	public function getEquipment()
  	{
  		$equipmentModel = new EquipmentModel();
  		$equipment = $equipmentModel->find($this->equipment_id);
  		
  		return $equipment;
  	}

  	/**
  	 * @return mixed
  	 */
  	public function getContact_id()
  	{
  		return $this->contact_id;
  	}

  	/**
  	 * @return mixed
  	 */
  	public function getImpact_id()
  	{
  		return $this->impact_id;
  	}

  	/**
  	 * @return mixed
  	 */
  	public function getPriority_id()
  	{
  		return $this->priority_id;
  	}

  	/**
  	 * @return mixed
  	 */
  	public function getCreated_by()
  	{
  		return $this->created_by;
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










    // set-----------------------------------------------------

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
  	public function setrequest_tital($request_tital)
  	{
  		$this->request_tital = $request_tital;
  	}

  	/**
  	 * @param mixed $password
  	 */
  	public function setrequest_detail($request_detail)
  	{
  		$this->request_detail = $request_detail;
  	}

  	/**
  	 * @param mixed $permission_id
  	 */
  	public function setrequest_status($request_status)
  	{
  		$this->request_status = $request_status;
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
  	public function setEquipment_id($equipment_id)
  	{
  		$this->equipment_id = $equipment_id;
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
