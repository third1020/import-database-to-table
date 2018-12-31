<?php
namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\EquipmentModel;
use App\Models\ContactModel;
use App\Models\ProblemsModel;
use App\Models\PriorityModel;
use App\Models\ImpactModel;
use App\Models\UserModel;

class ProblemsEntity extends Entity
{

    protected $id;

    protected $remark;

    protected $problems_tital;

    protected $problems_detail;

    protected $problems_status;

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

    // set-----------------------------------------------------

    /**
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param mixed $remark
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    /**
     *
     * @param mixed $username
     */
    public function setProblems_tital($problems_tital)
    {
        $this->problems_tital = $problems_tital;
    }

    /**
     *
     * @param mixed $password
     */
    public function setProblems_detail($Problems_detail)
    {
        $this->problems_detail = $Problems_detail;
    }

    /**
     *
     * @param mixed $permission_id
     */
    public function setProblems_status($problems_status)
    {
        $this->problems_status = $problems_status;
    }

    /**
     *
     * @param mixed $created_at
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     *
     * @param mixed $updated_at
     */
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     *
     * @param mixed $name
     */
    public function setEquipment_id($equipment_id)
    {
        $this->equipment_id = $equipment_id;
    }

    /**
     *
     * @param mixed $id_card
     */
    public function setContact_id($contact_id)
    {
        $this->contact_id = $contact_id;
    }

    /**
     *
     * @param mixed $phone_number
     */
    public function setImpact_id($impact_id)
    {
        $this->impact_id = $impact_id;
    }

    /**
     *
     * @param mixed $email
     */
    public function setPriority_id($priority_id)
    {
        $this->priority_id = $priority_id;
    }

    public function expose()
    {
        $var = get_object_vars($this);
        foreach ($var as &$value) {
            if (is_object($value) && method_exists($value, 'getJsonData')) {
                $value = $value->getJsonData();
            }
        }
        return $var;
    }
}
