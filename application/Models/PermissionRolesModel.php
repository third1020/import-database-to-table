<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\PermissionEntity;
use App\Entities\PermissionRolesEntity;


class PermissionRolesModel extends Model
{
    protected $table         = 'permission_roles';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'remark', 'permission_id', 'permission_key', 'created_by', 'created_at', 'updated_at'
    ];
    
    protected $returnType    = 'App\Entities\PermissionRolesEntity';
    protected $useTimestamps = true;
    
    public function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $db = \Config\Database::connect();
        $permission = $db->table('permission_roles');
    }
    
    public function savePermissionRoles($permission_id, $permission_key = []) {
        
//         $perrmissionRoles = [];
        foreach ($permission_key as $val) {
            $roles = new PermissionRolesEntity();
            $roles->setPermission_id($permission_id);
            $roles->setPermission_key($val);
            $roles->setCreated_at(date('Y-m-d H:i:s'));
            $roles->setUpdated_at(date('Y-m-d H:i:s'));
            $roles->setCreated_by('');
            
            $this->save($roles);
//             $perrmissionRoles[] = $roles;
        }
       
        return null;
    }
    
    public function getRolesByPermissionId($id) {
    	$permission = $this->where ( [
    			'permission_id' => $id
    	] )->findAll();
    	
    	return $permission;
    	;
    }
    
    public function delRolesByPermissionId($id) {
    	$permission = $this->where('permission_id', $id)->delete();
    }
}
