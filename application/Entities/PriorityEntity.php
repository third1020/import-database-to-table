<?php namespace App\Entities;

use CodeIgniter\Entity;

class PriorityEntity extends Entity
{
    protected $id;
    protected $remark;
    protected $priority_name;
    protected $priority_status;
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
    public function getPriority_name()
    {
        return $this->priority_name;
    }

    /**
     * @return mixed
     */
    public function getPriority_status()
    {
        return $this->priority_status;
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
     * @param mixed $equipment_detail
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    /**
     * @param mixed $equipment_name
     */
    public function setPriority_name($priority_name)
    {
        $this->priority_name = $priority_name;
    }

    /**
     * @param mixed $equipment_name
     */
    public function setPriority_status($priority_status)
    {
        $this->priority_status = $priority_status;
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


}
