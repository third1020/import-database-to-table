<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PermissionModel;
use App\Models\PermissionRolesModel;
use App\Entities\PermissionEntity;

class Permission extends Controller
{

    protected $helpers = [
        'url',
        'form'
    ];

    public function index()
    {
        return ;
    }
    
    public function UpdateForm($id = null) {
    	if ($id != null || $id != '') {
    		
    		$permissionModel = new PermissionModel();
    		
    		$data = array();
    		$data['permission'] = $permissionModel->find($id);
    		
    		$permissionRolesModel = new PermissionRolesModel();
    		$data['permissionRoles'] = $permissionRolesModel->getRolesByPermissionId($id);
    		
    		$validation = \Config\Services::validation();
    		if ($this->request->getMethod(true) == "POST") {
    			$validation->setRules([
    					'permission_id' => [
    							'label' => 'Permission Id',
    							'rules' => 'required',
    							'errors' => [
    									'required' => 'All accounts must have {field} provided'
    							]
    					],
    					'permission_name' => [
    							'label' => 'Permission name',
    							'rules' => 'required',
    							'errors' => [
    									'required' => 'All accounts must have {field} provided'
    							]
    					],
    					'permission_roles' => [
    							'label' => 'Permission roles',
    							'rules' => 'required'
    					]
    			]);
    			$validation->withRequest($this->request)->run();
    			
    			
    			if ($validation->getErrors() == null) {
    				try {
    					$permissionRolesModel->delRolesByPermissionId($id);
    				} catch (\Exception $e) {
    					return view('permission/fail_permission_message', ['message' => lang('permission.permission_delete_roles_fail')]);
    				}
    				
    				try {
    					$permissionRolesModel->savePermissionRoles($id, $this->request->getPost('permission_roles'));
    				} catch (\Exception $e) {
    					return view('permission/fail_permission_message', ['message' => lang('permission.permission_insert_roles_fail')]);
    				}
    				
    				try {
    					$permissionModel->updatePermissionName($id, $this->request->getPost('permission_name'));
    				} catch (\Exception $e) {
    					return view('permission/fail_permission_message', ['message' => lang('permission.permission_update_fail')]);
    				}
    				
    				return view('permission/success_permission_message', ['message' => lang('permission.permission_update_success')]);
    			} else {
    				return view('permission/update_permission_message', [
    						'validation' => $validation,
    						'input' => $this->request->getPost(),
    						'data' => $data
    				]);
    			}
    		}else {
    			return view('permission/update_permission_message', [
    					'validation' => $validation,
    					'input' => $this->request->getPost(),
    					'data' => $data
    			]);
    		}
    		
    	} else {
    		return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
    	}
    }

    public function Add()
    {
        $data = array();
        $data['nav'] = view('nav_message');

        $validation = \Config\Services::validation();
        if ($this->request->getMethod(true) == "POST") {
            $validation->setRules([
                'permission_name' => [
                    'label' => 'Permission name',
                    'rules' => 'required|is_unique[permission.permission_name]',
                    'errors' => [
                        'required' => 'All accounts must have {field} provided'
                    ] 
                ],
                'permission_roles' => [
                    'label' => 'Permission roles',
                    'rules' => 'required'
                ]
            ]);
            $validation->withRequest($this->request)->run();
            
            
            if ($validation->getErrors() == null) {
                $session = session();
                $session->setFlashdata('permission_register', $this->request->getPost());
                
                return redirect()->to(site_url('Permission/AddProcessPriview'));
            } else {
                $data['content'] = view('permission/add_permission_message', [
                    'validation' => $validation,
                    'input' => $this->request->getPost()
                ]);
            }
        }else {
            $data['content'] = view('permission/add_permission_message', [
                'validation' => $validation,
                'input' => $this->request->getPost()
            ]);
        }
        
        return view('welcome_message', $data);
    }
    
    public function AddProcessPriview()
    {
        $session = session();
        if (! empty($session->getFlashdata('permission_register')) ) {
//             $session->setFlashdata('permission_register', $session->getFlashdata('permission_register'));
            $session->keepFlashdata('permission_register');
            $preData = ['preData' => $session->getFlashdata('permission_register')];
            $data = [];
            $data['nav'] = view('nav_message');
            $data['content'] = view('permission/preview_permission_message', $preData);
            
            return view('welcome_message', $data);
        } else {
            $data = ['message' => lang('content.invalid_parameter')];
            return view('errors/html/error_503', $data);
        }
    }
    
    public function InsertProcess() {
        $session = session();
        $data = [];
        $data['nav'] = view('nav_message');
        if (! empty($session->getFlashdata('permission_register')) ) {
            $preData = $session->getFlashdata('permission_register');
            $permissionModel = new PermissionModel();
            try {
                $permission_id = $permissionModel->savePermissionName($preData['permission_name']);
                
                $permissionRolesModel = new PermissionRolesModel();
                $permissionRolesModel->savePermissionRoles($permission_id, $preData['permission_roles']);
            }catch (\Exception $e) {
                $permissionModel->delete($permission_id);
                die($e->getMessage());
            }
            
            $message = [
                'result' => lang('permission.insert_success')
            ];
            $data['content'] = view('permission/result_permission_message', $message);
        }else{
            $message = [
                'result' => lang('permission.empty_data')
            ];
            $data['content'] = view('permission/result_permission_message', $message);
        }
        
        return view('welcome_message', $data);
    }
    
    public function List() {
        $data = array();
        $data['nav'] = view('nav_message');
        $data['content'] = view('permission/list_permission_message');
        
        return view('welcome_message', $data);
    }
	
    public function DataProcessing() {
        if ($this->request->getMethod() == 'post') {
            $elements_per_page = $this->request->getVar('length');
            $elements_start = $this->request->getVar('start');
            
            if ($elements_per_page == null || $elements_start == null) {
                return $this->response->setStatusCode(404)->setBody('error 404 [invalid parameter]');
            }
            
            $search_value = $this->request->getVar('search[value]');
            
            $permission = new PermissionEntity();
            $permissionModel = new PermissionModel();
            $permission = $permissionModel->get_permission($elements_per_page, $elements_start, $search_value);
            
            $recordsTotal = $permissionModel->countAllResults('permission');
            
            $data = array();
            $data['draw'] = $this->request->getVar('draw');
            $data['recordsTotal'] = $recordsTotal;
            $data['recordsFiltered'] = $recordsTotal;
            $data['data'] = $permission;
            
            $this->response->setCache([
                'max-age' => 300,
                's-max-age' => 900,
                'etag' => 'foo'
            ]);
            
            return $this->response->setContentType('application/json')->setJSON($data);
        } else {
            return $this->response->setStatusCode(404)->setBody('error 404 [invalid parameter]');
        }
    }

	//--------------------------------------------------------------------

}
