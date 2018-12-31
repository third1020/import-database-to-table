<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\PermissionEntity;


class PermissionModel extends Model
{
    protected $table         = 'permission';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'remark', 'permission_name', 'created_by', 'created_at', 'updated_at'
    ];
    protected $returnType    = 'App\Entities\PermissionEntity';
    protected $useTimestamps = true;
    
    public function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $db = \Config\Database::connect();
        $permission = $db->table('permission');
    }
    
    public function findByname($permission_name) {
        $permission = $this->where([
            'permission_name' => $permission_name
        ])->first();
        
        return $permission;
    }
    
    public function savePermissionName($permission_name) {
        $permissionEnitity = new PermissionEntity();
        $permissionEnitity->setPermission_name($permission_name);
        $permissionEnitity->setCreated_by('');
        $permissionEnitity->setCreated_at(date('Y-m-d H:i:s'));
        $permissionEnitity->setUpdated_at(date('Y-m-d H:i:s'));
       
//         $this->save($permissionEnitity);

        return $this->insert($permissionEnitity);
    }
    
    public function updatePermissionName($id, $permission_name) {
    	$permission = [
    			'permission_name' => $permission_name,
    			'updated_at' => date('Y-m-d H:i:s')
    	];
    	
    	
    	return $this->update($id, $permission);
    }
    
    public function get_permission($limit, $offset, $value) {
        $rows = $this->table($this->table);
        
        if(!is_null($value)) {
            foreach ($this->searchField as $field) {
                $rows = $rows->orLike($field ,$value);
            }
        }
        
        $rows = $rows->limit($limit)->offset($offset);
        
        $rows = $rows->get();
        // 		$user = $rows->getResult('App\Entities\User');
        $user = $rows->getResult();
        
        return $user;
    }
}
