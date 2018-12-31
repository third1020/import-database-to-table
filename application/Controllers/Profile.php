<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Entities\UserEntity;
use App\Models\ImagesModel;

class Profile extends Controller
{
	protected $helpers = ['url', 'form', 'session'];
	
	private $validationsetRulesUpdate = [
			'password' => [
					'label' => 'Password',
					'rules' => 'permit_empty|min_length[6]',
					'errors' => [
							'min_length' => 'Your {field} is too short. min 6 characters'
					]
			],
			'name' => [
					'label' => 'Name',
					'rules' => 'required'
			],
			'id_card' => [
					'label' => 'Id card',
					'rules' => 'required'
			],
			'phone_number' => [
					'label' => 'Phone number',
					'rules' => 'required'
			],
			'email' => [
					'label' => 'E-mail',
					'rules' => 'required'
			],
			'user_id' => [
					'label' => 'User id',
					'rules' => 'required'
			],
			'user_img' => [
					'rules' => 'permit_empty',
					'uploaded[user_img]',
					'mime_in[user_img,image/jpg,image/jpeg,image/gif,image/png]',
					'max_size[user_img,4096]'
			]
	];
	
	public function index()
	{
		$session = session();
		if(!$session->has('username'))  {
			return redirect(site_url('Login'));
		}
		
		$data = array();
		$data['nav'] = view('nav_message');
		
		$session = session();
		
		$userModel = new UserModel();
		$user = $userModel->getUserByUsername($session->get('username'));
		$data['content'] = view ( 'user/profile_user_message', ['user' => $user] );
		
		return view('welcome_message', $data);
	}
	
	
	public function UpdateProcess() {
		$data = array();
		$data['nav'] = view('nav_message');
		
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		if ($this->request->getMethod ( true ) == "POST") {
			$userModel = new UserModel ();
			$validation->setRules ($this->validationsetRulesUpdate);
			$validation->withRequest ( $this->request )->run ();
			if ($validation->getErrors () == null) {
				$id = $this->request->getPost ( 'user_id' );
				$name = $this->request->getPost ( 'name' );
				$id_card = $this->request->getPost ( 'id_card' );
				$phone_number = $this->request->getPost ( 'phone_number' );
				$email = $this->request->getPost ( 'email' );
				$image = null;
				
				try {
					if (! empty ( $img = $this->request->getFile ( 'user_img' ) )) {
						if(! empty ( $img->getTempName())) {
							$imageResize = new ImagesModel();
							$image = base64_encode ( $imageResize->resize ( $img, 350 ) );
						}
					}
					
					if (! empty ( $this->request->getPost ( 'password' ) )) {
						$password = password_hash ( $this->request->getPost ( 'password' ), PASSWORD_BCRYPT, [
								"cost=>8"
						] );
						
						$userModel->user_update ( $id, $password, $name, $id_card, $phone_number, $email, null, $image );
					
						$data['content'] = view ( 'user/result_user_message', [
								'result' => lang ( 'user.user_update_success' )
						] );
					} else {
						$userModel->user_update ( $id, null, $name, $id_card, $phone_number, $email, null, $image );
						
						$data['content'] = view ( 'user/result_user_message', [
								'result' => lang ( 'user.user_update_success' )
						] );
					}
				} catch ( \Exception $e ) {
					$data['content'] =  view ( 'user/result_user_message', [
							'result' => lang ( 'user.user_update_fail'. $e )
					] );
				}
			}else {
				$user = $userModel->find ( $this->request->getPost ( 'user_id' ) );
				$data['content'] = view ( 'user/profile_user_message', [
						'validation' => $validation,
						'user' => $user,
				] );
			}
		}else {
			$user = $userModel->find ( $this->request->getPost ( 'user_id' ) );
			$data['content'] = view ( 'user/profile_user_message', [
					'validation' => $validation,
					'user' => $user,
			] );
		}
		return view('welcome_message', $data);
	}
	//--------------------------------------------------------------------
	
}


?>