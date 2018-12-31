<?php namespace App\Entities;

use CodeIgniter\Entity;

class PermissionRolesEntity extends Entity
{
    protected $id;
    protected $permission_id;
    protected $permission_key;
    protected $created_by;
    protected $created_at;
    protected $updated_at;
    
    /**
     * @return mixed
     */
    public function getCreated_by()
    {
        return $this->created_by;
    }

    /**
     * @param mixed $created_by
     */
    public function setCreated_by($created_by)
    {
        $this->created_by = $created_by;
    }

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
    public function getPermission_id()
    {
        return $this->permission_id;
    }

    /**
     * @return mixed
     */
    public function getPermission_key()
    {
        return $this->permission_key;
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
     * @param mixed $permission_id
     */
    public function setPermission_id($permission_id)
    {
        $this->permission_id = $permission_id;
    }

    /**
     * @param mixed $permission_key
     */
    public function setPermission_key($permission_key)
    {
        $this->permission_key = $permission_key;
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