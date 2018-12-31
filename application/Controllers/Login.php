<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\PermissionModel;

class Login extends Controller
{
    protected $helpers = ['url', 'form'];
    protected $userModel;
    
    public function __construct() {
    }
    
	public function index()
	{
	    return view('login_message');
	}
	
	public function process() {
	    if (! $this->request->isSecure()){
	        //$user = new User();
	        $userModel = new UserModel();
	        $permissionModel = new PermissionModel();
	        $username = $this->request->getVar('username');
	        $password = $this->request->getVar('password');
	        
	        $user = $userModel->login($username);
	        
	        if($user != null) {
	        	if(password_verify($password, $user->password)) {
	        		$permission = $permissionModel->find($user->permission_id);
	        		$newData = array(
	        				'id' => $user->id,
	        				'username' => $user->username,
	        				'name' => $user->user_name,
	        				'permission_name' => $permission->permission_name,
	        				'permissionRoles' => $permission->getPermission_roles()
	        		);
	        		$session = session();
	        		$session->set($newData);
	        		
	        		return redirect(site_url('home'));
	        	}else{
	        		return redirect(site_url('login/login_fail'));
	        	}
	        	
	        }else{
	        	return redirect(site_url('login/login_fail'));
	        }
	    }else {
	    	return redirect(site_url('login/login_fail'));
	    }
	}
	
	public function login_fail() {
		$data = [
				'message' => lang('login.login_fail')
		];
		return view('login_message', $data);
	}
	
	public function logout() {
	    $session = session();
	    $session->destroy();
	    
	    return redirect(site_url('login/index'));
	}

	//--------------------------------------------------------------------

}
