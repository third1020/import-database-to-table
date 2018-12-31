<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\UserModel;
use App\Models\PermissionModel;
use App\Models\ImagesModel;

class User extends Controller {
	protected $helpers = [
			'url',
			'form',
			'session'
	];
	private $validationsetRules = [
			'username' => [
					'label' => 'Username',
					'rules' => 'required|is_unique[user.username]',
					'errors' => [
							'required' => 'All accounts must have {field} provided'
					]
			],
			'password' => [
					'label' => 'Password',
					'rules' => 'required'
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
					'label' => 'Phone number|decimal',
					'rules' => 'required'
			],
			'email' => [
					'label' => 'E-mail',
					'rules' => 'required|valid_email'
			],
			'permission_id' => [
					'label' => 'Permission',
					'rules' => 'required'
			]
	];

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
					'label' => 'Phone number|decimal',
					'rules' => 'required'
			],
			'email' => [
					'label' => 'E-mail',
					'rules' => 'required|valid_email'
			],
			'permission_id' => [
					'label' => 'Permission',
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

	public function __construct() {
	}
	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		// printf($this->request->getDefaultLocale()) ;

		$data ['content'] = lang ( 'content.user_view', [
				3
		] );
		return view ( 'user/list_user_message', $data );
	}
	public function List() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$data ['content'] = view ( 'user/list_user_message' );

		return view ( 'welcome_message', $data );
	}
	public function DataProcessing() {
		if ($this->request->getMethod () == 'post') {
			$elements_per_page = $this->request->getVar ( 'length' );
			$elements_start = $this->request->getVar ( 'start' );

			if ($elements_per_page == null || $elements_start == null) {
				return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
			}

			$search_value = $this->request->getVar ( 'search[value]' );

			$user = new App\Entities\UserEntity ();
			$userModel = new UserModel ();
			$user = $userModel->get_user ( $elements_per_page, $elements_start, $search_value );

			$recordsTotal = $userModel->countAllResults ( 'user' );

			// $search_regex = $this->request->getVar('search[regex]');
			// $columns = $this->request->getVar('columns');

			// $order_column = $this->request->getVar('order[0][column]');
			// $order_dir = $this->request->getVar('order[0][dir]');

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $user;

			$this->response->setCache ( [
					'max-age' => 300,
					's-max-age' => 900,
					'etag' => 'foo'
			] );

			return $this->response->setContentType ( 'application/json' )->setJSON ( $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function Add() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$validation = \Config\Services::validation ();
		$permissionModel = new PermissionModel ();
		$session = session ();
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ( $this->validationsetRules );

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {
				$session = session ();
				$session->setTempdata ( 'user_register', $this->request->getPost (), 150 );

				return redirect ( site_url ( 'User/AddProcessPriview' ) );
			} else {
				$data ['content'] = view ( 'user/add_user_message', [
						'validation' => $validation,
						'input' => $this->request->getPost (),
						'per' => $permissionModel->findAll ()
				] );
			}
		} else {
			$data ['content'] = view ( 'user/add_user_message', [
					'validation' => $validation,
					'per' => $permissionModel->findAll ()
			] );
		}

		return view ( 'welcome_message', $data );
	}
	public function AddProcessPriview() {
		$session = session ();
		if (! empty ( $session->getTempdata ( 'user_register' ) )) {
			$preData = [
					'preData' => $session->getTempdata ( 'user_register' )
			];

			$data = [ ];
			$data ['nav'] = view ( 'nav_message' );
			$data ['content'] = view ( 'user/preview_user_message', $preData );

			return view ( 'welcome_message', $data );
		} else {
			$data = [
					'message' => lang ( 'content.invalid_parameter' )
			];
			return view ( 'errors/html/error_503', $data );
		}
		return;
	}
	public function AddProcess() {
		$session = session ();
		$data = [ ];
		$data ['nav'] = view ( 'nav_message' );
		if (! empty ( $session->getTempdata ( 'user_register' ) )) {
			$preData = $session->getTempdata ( 'user_register' );

			$password = password_hash ( $preData ['password'], PASSWORD_BCRYPT, [
					"cost=>8"
			] );

			try {
				$userModel = new UserModel ();

				$userModel->user_insert ( $preData ['username'], $password, $preData ['name'], $preData ['id_card'], $preData ['phone_number'], $preData ['email'], $preData ['permission_id'] );
			} catch ( \Exception $e ) {
				die ( $e->getMessage () );
			}
			$message = [
					'result' => lang ( 'user.insert_success' )
			];
			$data ['content'] = view ( 'user/result_user_message', $message );
		} else {
			$message = [
					'result' => lang ( 'user.empty_data' )
			];
			$data ['content'] = view ( 'user/result_user_message', $message );
		}

		return view ( 'welcome_message', $data );
		// return redirect('http://localhost/service/public/index.php/User/add');
	}
	public function UpdateForm($id = null) {
		if ($id != null || $id != '') {
			$userModel = new UserModel ();
			$permissionModel = new permissionModel ();
			$userModel->table ( 'user' );
			$userModel->select ( 'user.*, permission.id AS permission, permission.permission_name' );
			$userModel->join ( 'permission', 'permission.id = user.permission_id' );
			$userModel->where ( array (
					'user.id' => $id
			) );

			$user = $userModel->get ()->getResult ();

			$data = [
					// 'validation' => $validation,
					'user' => $user,
					'per' => $permissionModel->findAll ()
			];

			return view ( 'user/update_user_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function UpdateProcess() {
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		if ($this->request->getMethod ( true ) == "POST") {
			$userModel = new UserModel ();

			$permissionModel = new permissionModel ();
			$validation->setRules ( $this->validationsetRulesUpdate );

			$validation->withRequest ( $this->request )->run ();
			if ($validation->getErrors () == null) {
				$id = $this->request->getPost ( 'user_id' );
				$name = $this->request->getPost ( 'name' );
				$id_card = $this->request->getPost ( 'id_card' );
				$phone_number = $this->request->getPost ( 'phone_number' );
				$email = $this->request->getPost ( 'email' );
				$permission_id = $this->request->getPost ( 'permission_id' );
				$image = null;

				try {
					if (! empty ( $img = $this->request->getFile ( 'user_img' ) )) {
						if(! empty ( $img->getTempName())) {
						$imageResize = new ImagesModel ();
						$image = base64_encode ( $imageResize->resize ( $img, 350 ) );
						}
					}

					if (! empty ( $this->request->getPost ( 'password' ) )) {
						$password = password_hash ( $this->request->getPost ( 'password' ), PASSWORD_BCRYPT, [
								"cost=>8"
						] );
						$userModel->user_update ( $id, $password, $name, $id_card, $phone_number, $email, $permission_id, $image );
					} else {
						$userModel->user_update ( $id, null, $name, $id_card, $phone_number, $email, $permission_id, $image );
					}
				} catch ( \Exception $e ) {
					return view ( 'user/fail_user_message', [
							'message' => lang ( 'user.user_update_fail' )
					] );
				}

				return view ( 'user/success_user_message', [
						'message' => lang ( 'user.user_update_success' )
				] );
			}
		}

		$user = [
				0 => $userModel->find ( $this->request->getPost ( 'user_id' ) )
		];

		return view ( 'user/update_user_message', [
				'validation' => $validation,
				'user' => $user,
				'per' => $permissionModel->findAll ()
		] );
	}
	public function DeleteForm($id = null) {
		if ($id != null || $id != '') {

			$userModel = new UserModel ();
			$userModel->table ( 'user' );
			$userModel->select ( 'user.*, permission.id AS permission, permission.permission_name,permission.created_by' );
			$userModel->join ( 'permission', 'permission.id = user.permission_id' );
			$userModel->where ( array (
					'user.id' => $id
			) );

			$user = $userModel->get ();
			$user = $user->getResult ();

			$data = [
					'user' => $user
			];

			return view ( 'user/view_user_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function Delete() {
		if (! $this->request->isSecure ()) {
			$id = array (
					'id' => $this->request->getPost ( 'id' )
			);

			try {
				$user = new UserModel ();
				$user->where ( 'id', $id );
				$user->delete ();

				return view ( 'user/fail_user_message.php', [
						'message' => lang('user.user_delete_success')
				]);
			} catch ( \Exception $e ) {
				return view ( 'user/fail_user_message', [
						'message' => lang('ser.user_delete_fail')
				]);
			}
		}
	}
}
