<?php namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\PermissionRolesModel;

class PermissionEntity extends Entity
{
    protected $id;
    protected $permission_name;
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
    public function getPermission_name()
    {
        return $this->permission_name;
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
     * @return mixed
     */
    public function getPermission_roles()
    {
    	$perRolesModel = new PermissionRolesModel();
    	$perRoles = $perRolesModel
    		->select ( 'permission_roles.permission_key')
    		->where('permission_id', $this->id)
    		->get ()->getResultArray ();
    	
    		$data = [];
    		foreach ($perRoles as $val) {
    			$data[] = $val['permission_key'];
    		}
    	
    		return $data;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $permission_name
     */
    public function setPermission_name($permission_name)
    {
        $this->permission_name = $permission_name;
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