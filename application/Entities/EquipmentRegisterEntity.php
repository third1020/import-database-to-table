<?php namespace App\Entities;

use CodeIgniter\Entity;

class EquipmentRegisterEntity extends Entity
{
    protected $id;
    protected $remark;
    protected $equipment_name;
    protected $department;
    protected $username;
    protected $history;
    protected $detail;
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
    public function getEquipment_name()
    {
        return $this->equipment_name;
    }

    /**
     * @return mixed
     */
    public function getdetail()
    {
        return $this->detail;
    }

    /**
     * @return mixed
     */
    public function getdepartment()
    {
        return $this->department;
    }

    /**
     * @return mixed
     */
    public function getusername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function gethistory()
    {
        return $this->history;
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

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $id
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    /**
     * @param mixed $equipment_name
     */
    public function setEquipment_name($equipment_name)
    {
        $this->equipment_name = $equipment_name;
    }


    /**
     * @param mixed $equipment_detail
     */
    public function setdetail($detail)
    {
        $this->detail = $detail;
    }

    /**
     * @param mixed $equipment_image
     */
    public function setdepartment($department)
    {
        $this->department = $department;
    }
    /**
     * @param mixed $equipment_image
     */
    public function setusername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $equipment_image
     */
    public function sethistory($history)
    {
        $this->history = $history;
    }

    /**
     * @param mixed $created_by
     */
    public function setCreated_by($created_by)
    {
        $this->created_by = $created_by;
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
