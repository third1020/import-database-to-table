<?php namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\EquipmentModel;
use App\Models\ContactModel;
use App\Models\ImpactModel;
use App\Models\PriorityModel;
use App\Models\UserModel;

class IncidentEntity extends Entity
{
    protected $id;
    protected $remark;
    protected $Incident_tital;
    protected $Incident_detail;
    protected $Incident_status;
    protected $equipment_id;
    protected $contact_id;
    protected $impact_id;
    protected $priority_id;
    protected $accept_id;
    protected $created_by;
    protected $created_at;
    protected $updated_at;


  	 /**
     *
     * @return mixed
     */
    public function getAccept_id()
    {
        return $this->accept_id;
    }

    /**
     *
     * @return mixed
     */
    public function getAccept()
    {
        $userModel = new UserModel();
        $user = null;

        if (! empty($this->accept_id))
            $user = $userModel->find($this->accept_id);
        return $user;
    }

    /**
     *
     * @param mixed $accept_id
     */
    public function setAccept_id($accept_id)
    {
        $this->accept_id = $accept_id;
    }

    /**
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     *
     * @return mixed
     */
    public function getTital()
    {
        return $this->problems_tital;
    }

    /**
     *
     * @return mixed
     */
    public function getDetail()
    {
        return $this->problems_detail;
    }

    /**
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->problems_status;
    }

    /**
     *
     * @return mixed
     */
    public function getEquipment_id()
    {
        return $this->equipment_id;
    }

    /**
     *
     * @return mixed
     */
    public function getEquipment()
    {
        $equipmentModel = new EquipmentModel();
        $equipment = null;

        if (! empty($this->equipment_id))
            $equipment = $equipmentModel->find($this->equipment_id);

        return $equipment;
    }

    /**
     *
     * @return mixed
     */
    public function getContact_id()
    {
        return $this->contact_id;
    }

    /**
     *
     * @return mixed
     */
    public function getContact()
    {
        $contactModel = new ContactModel();
        $contact = null;

        if (! empty($this->contact_id))
            $contact = $contactModel->find($this->contact_id);
        return $contact;
    }

    /**
     *
     * @return mixed
     */
    public function getImpact_id()
    {
        return $this->impact_id;
    }

    /**
     *
     * @return mixed
     */
    public function getImpact()
    {
        $impactModel = new ImpactModel();
        $impact = null;
        if (! empty($this->impact_id))
            $impact = $impactModel->find($this->impact_id);
        return $impact;
    }

    /**
     *
     * @return mixed
     */
    public function getPriority_id()
    {
        return $this->priority_id;
    }

    /**
     *
     * @return mixed
     */
    public function getPriority()
    {
        $priorityModel = new PriorityModel();
        $priority = null;

        if (! empty($this->priority_id))
            $priority = $priorityModel->find($this->priority_id);
        return $priority;
    }

    /**
     *
     * @return mixed
     */
    public function getCreated_by()
    {
        return $this->created_by;
    }

    /**
     *
     * @return mixed
     */
    public function getCreated()
    {
        $userModel = new UserModel();
        $user = null;
        if (! empty($this->created_by))
            $user = $userModel->find($this->created_by);
        return $user;
    }

    /**
     *
     * @return mixed
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     *
     * @return mixed
     */
    public function getUpdated_at()
    {
        return $this->updated_at;
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
  	public function setIncident_tital($Incident_tital)
  	{
  		$this->Incident_tital = $Incident_tital;
  	}

  	/**
  	 * @param mixed $password
  	 */
  	public function setIncident_detail($Incident_detail)
  	{
  		$this->Incident_detail = $Incident_detail;
  	}

  	/**
  	 * @param mixed $permission_id
  	 */
  	public function setIncident_status($Incident_status)
  	{
  		$this->Incident_status = $Incident_status;
  	}

    /**
  	 * @param mixed $permission_id
  	 */
  	public function setEquipment_id($Equipment_id)
  	{
  		$this->Equipment_id = $Equipment_id;
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
