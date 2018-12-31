<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\NewsTypeModel;
use App\Models\EquipmentModel;
use App\Models\RequestModel;
use App\Models\MessageModel;
use App\Entities\MessageEntity;
use App\Models\ProblemsModel;
use App\Models\ContactModel;
use App\Models\ImpactModel;
use App\Models\PriorityModel;
use App\Models\WorkaroundModel;
use App\Models\ProblemsWorkaroundModel;
use App\Models\IncidentModel;
use App\Models\IncidentWorkaroundModel;

class Petition extends Controller {
	protected $helpers = [ 
			'url',
			'form',
			'session'
	];
	private $validationRulesRequest = [ 
			'request_tital' => [ 
					'label' => 'Tital',
					'rules' => 'required|min_length[8]'
			],
			'request_detail' => [ 
					'label' => 'Detail',
					'rules' => 'required|max_length[200]'
			],
			'equipment_id' => [ 
					'label' => 'Equipment ID',
					'rules' => 'required'
			]
	];
	private $validationRulesProblems = [ 
			'problems_tital' => [ 
					'label' => 'Tital',
					'rules' => 'required'
			],
			'problems_detail' => [ 
					'label' => 'Detail',
					'rules' => 'required'
			],
			'equipment_id' => [ 
					'label' => 'Equipment ID',
					'rules' => 'required'
			]
	];
	private $validationRulesConfirmProblems = [ 
			'problems_status' => [ 
					'label' => 'problems status',
					'rules' => 'required'
			]
	];
	private $validationRulesConfirmCheckoutProblems = [ 
			'confirm' => [ 
					'label' => 'check confirm',
					'rules' => 'required'
			]
	];
	private $validationRulesConfirmWorkaroundProblems = [
			'action_start' => [
					'label' => 'action start',
					'rules' => 'required'
			],
			'action_end' => [
					'label' => 'action end',
					'rules' => 'required'
			],
			'wr_title' => [
					'label' => 'Workaround Title',
					'rules' => 'required'
			],
			'wr_detail' => [
					'label' => 'Workaround Detail',
					'rules' => 'required'
			]
	];
	
	private $validationRulesIncident = [
			'incident_tital' => [
					'label' => 'Tital',
					'rules' => 'required'
			],
			'incident_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'equipment_id' => [
					'label' => 'Equipment ID',
					'rules' => 'required'
			]
	];
	private $validationRulesConfirmIncident = [
			'incident_status' => [
					'label' => 'problems status',
					'rules' => 'required'
			]
	];
	private $validationRulesConfirmCheckoutIncident = [
			'confirm' => [
					'label' => 'check confirm',
					'rules' => 'required'
			]
	];
	private $validationRulesConfirmWorkaroundIncident = [
			'action_start' => [
					'label' => 'action start',
					'rules' => 'required'
			],
			'action_end' => [
					'label' => 'action end',
					'rules' => 'required'
			],
			'wr_title' => [
					'label' => 'Workaround Title',
					'rules' => 'required'
			],
			'wr_detail' => [
					'label' => 'Workaround Detail',
					'rules' => 'required'
			]
	];
	
	public function __construct() {
	}
	public function index() {
		$session = session ();
		if (! $session->has ( 'username' )) {
			return redirect ( site_url ( 'Login' ) );
		}

		$data = array ();
		$data ['nav'] = view ( 'nav_message' );

		$userModel = new UserModel ();
		$user = $userModel->getUserByUsername ( $session->get ( 'username' ) );

		$newsTypeModel = new NewsTypeModel ();
		$newsType = $newsTypeModel->findAll ();

		$data ['content'] = view ( 'home/profile_message', [ 
				'user' => $user,
				'newsType' => $newsType
		] );

		return view ( 'welcome_message', $data );
	}
	public function Request() {
		$session = session ();
		if (! $session->has ( 'username' )) {
			return redirect ( site_url ( 'Login' ) );
		}
		$data = array ();

		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$equipmentModel = new EquipmentModel ();
		$RequestModel = new RequestModel ();

		$data ['nav'] = view ( 'nav_message' );

		if ($this->request->getMethod ( true ) == "POST") {
			$val = array (
					'request_tital' => $this->request->getPost ( 'request_tital' ),
					'request_detail' => $this->request->getPost ( 'request_detail' ),
					'request_status' => 0,
					'equipment_id' => $this->request->getPost ( 'equipment_id' ),
					'created_by' => $session->get ( 'id' )
			);

			$validation->setRules ( $this->validationRulesRequest );
			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {

				try {
					$request_id = $RequestModel->insert ( $val );

					$equipment = $equipmentModel->find ( $val ['equipment_id'] );

					$userModel = new UserModel ();
					$users_manager = $userModel->where ( 'permission_id', 3 )->findAll ();

					try {
						foreach ( $users_manager as $user_manager ) {
							$mes = [ 
									"name_to" => $user_manager->username,
									"name_from" => $session->get ( 'name' ),
									"to_id" => $user_manager->id,
									"from_id" => $session->get ( 'id' ),
									"equipment_name" => $equipment->equipment_name,
									"equipment_id" => $equipment->id,
									"url_confirm" => site_url ( "Petition/Request_confirm/$request_id" )
							];

							$messageModel = new MessageModel ();
							$message_title = "Request " . $this->request->getPost ( 'request_tital' );
							$message_message = view ( 'petition/message/request/request_message-0', $mes );
							$message_from = $session->get ( 'id' );
							$message_to = $user_manager->id;
							$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
						}

						$data ['content'] = view ( 'request/success_request_message', [ 
								'message' => "inserted data successfully"
						] );
					} catch ( \Exception $e ) {
						$data ['content'] = view ( 'request/success_request_message', [ 
								'status' => "alert-danger",
								'message' => "inserted data message fail" . $e
						] );
					}
				} catch ( \Exception $e ) {
					$data ['content'] = view ( 'request/success_request_message', [ 
							'status' => "alert-danger",
							'message' => "inserted data request fail" . $e
					] );
				}

				return view ( 'welcome_message', $data );
			} else {

				$data ['content'] = view ( 'petition/add_request_message', [ 
						'errors' => $validation->getErrors (),
						'equipment' => $equipmentModel->findAll ()
				] );

				return view ( "welcome_message", $data );
			}
		}

		$data ['content'] = view ( 'petition/add_request_message', [ 
				'validation' => $validation,
				'equipment' => $equipmentModel->findAll ()
		] );

		return view ( 'welcome_message', $data );
	}
	public function Request_confirm($id) {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );

		$session = session ();

		$requestModel = new RequestModel ();
		$request = $requestModel->find ( $id );

		if ($this->request->getMethod ( true ) == "POST") {
			$status = $this->request->getPost ( 'request_status' );
			try {
				$requestModel->updateStatus ( $id, $status );

				$userModel = new UserModel ();
				$user = $userModel->find ( $request->created_by );

				if (! empty ( $user )) {
					$equipment = $request->getEquipment ();

					$mes = [ 
							"name_to" => $user->username,
							"name_from" => $session->get ( 'name' ),
							"to_id" => $user->id,
							"from_id" => $session->get ( 'id' ),
							"equipment_name" => $equipment->equipment_name,
							"equipment_id" => $equipment->id,
							"status" => $status
					];

					$messageModel = new MessageModel ();
					$message_title = "Problems " . $this->request->getPost ( 'problems_tital' );
					$message_message = view ( 'petition/message/request/request_message-1', $mes );
					$message_from = $session->get ( 'id' );
					$message_to = $user->id;
					$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
				}

				$data ['content'] = view ( 'problems/success_problems_message', [ 
						'message' => "update data successfully"
				] );

				return view ( 'welcome_message', $data );
			} catch ( \Exception $e ) {
				$data ['content'] = view ( 'request/success_request_message', [ 
						'status' => "alert-danger",
						'message' => "update data message fail" . $e
				] );

				return view ( 'welcome_message', $data );
			}
		}

		if (! empty ( $request )) {
			$data ['content'] = view ( 'petition/confirm/manager/confirm_request', [ 
					'request' => $request
			] );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}

		return view ( 'welcome_message', $data );
	}
	public function Problems() {
		$session = session ();
		if (! $session->has ( 'username' )) {
			return redirect ( site_url ( 'Login' ) );
		}
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$problemsModel = new ProblemsModel ();
		$equipmentModel = new EquipmentModel ();

		if ($this->request->getMethod ( true ) == "POST") {
			$val = array (
					'problems_tital' => $this->request->getPost ( 'problems_tital' ),
					'problems_detail' => $this->request->getPost ( 'problems_detail' ),
					'problems_status' => 0,
					'equipment_id' => $this->request->getPost ( 'equipment_id' ),
					'contact_id' => null,
					'impact_id' => null,
					'priority_id' => null,
					'created_by' => $session->get ( 'id' )
			);

			$validation->setRules ( $this->validationRulesProblems );
			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {

				try {
					$problems_id = $problemsModel->insert ( $val );
					$equipment = $equipmentModel->find ( $val ['equipment_id'] );

					$userModel = new UserModel ();
					$users_manager = $userModel->where ( 'permission_id', 3 )->findAll ();

					foreach ( $users_manager as $user_manager ) {
						$mes = [ 
								"name_to" => $user_manager->username,
								"name_from" => $session->get ( 'name' ),
								"to_id" => $user_manager->id,
								"from_id" => $session->get ( 'id' ),
								"equipment_name" => $equipment->equipment_name,
								"equipment_id" => $equipment->id,
								"url_confirm" => site_url ( "Petition/Problems_confirm/$problems_id" )
						];

						$messageModel = new MessageModel ();
						$message_title = "Problems " . $this->request->getPost ( 'problems_tital' );
						$message_message = view ( 'petition/message/problems/problems_message-0', $mes );
						$message_from = $session->get ( 'id' );
						$message_to = $user_manager->id;
						$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
					}

					$data ['content'] = view ( 'problems/success_problems_message', [ 
							'message' => "inserted data successfully"
					] );
				} catch ( \Exception $e ) {
					$data ['content'] = view ( 'request/success_request_message', [ 
							'status' => "alert-danger",
							'message' => "inserted data message fail" . $e
					] );
				}

				return view ( 'welcome_message', $data );
			} else {

				$data ['content'] = view ( 'petition/add_problems_message', [ 
						'errors' => $validation->getErrors (),
						'equipment' => $equipmentModel->findAll (),
						'input' => $val
				] );

				return view ( "welcome_message", $data );
			}
		}

		$data ['content'] = view ( 'petition/add_problems_message', [ 
				'validation' => $validation,
				'equipment' => $equipmentModel->findAll ()
		] );

		return view ( 'welcome_message', $data );
	}
	public function Problems_confirm($id) {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );

		$session = session ();
		$validation = \Config\Services::validation ();
		$problemsModel = new ProblemsModel ();
		$problems = $problemsModel->find ( $id );

		if ($this->request->getMethod ( true ) == "POST") {

			if ($this->request->getPost ( 'problems_status' ) == 2) {
				$this->validationRulesConfirmProblems ['contact_id'] = [ 
						'label' => 'contact choose',
						'rules' => 'required'
				];
				$this->validationRulesConfirmProblems ['impact_id'] = [ 
						'label' => 'impact choose',
						'rules' => 'required'
				];
				$this->validationRulesConfirmProblems ['priority_id'] = [ 
						'label' => 'priority choose',
						'rules' => 'required'
				];
			}
			$validation->setRules ( $this->validationRulesConfirmProblems );
			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {
				$val = [ 
						'contact_id' => empty ( $this->request->getPost ( 'contact_id' ) ) ? null : $this->request->getPost ( 'contact_id' ),
						'impact_id' => empty ( $this->request->getPost ( 'impact_id' ) ) ? null : $this->request->getPost ( 'impact_id' ),
						'priority_id' => empty ( $this->request->getPost ( 'priority_id' ) ) ? null : $this->request->getPost ( 'priority_id' ),
						'problems_status' => $this->request->getPost ( 'problems_status' ),
						'accept_id' => $session->get('id')
				];

				try {
					$problemsModel->update ( $id, $val );

					$userModel = new UserModel ();
					$user = $userModel->find ( $problems->created_by );

					if (! empty ( $user )) {
						$equipment = $problems->getEquipment ();

						$mes = [ 
								"name_to" => $user->username,
								"name_from" => $session->get ( 'name' ),
								"to_id" => $user->id,
								"from_id" => $session->get ( 'id' ),
								"equipment_name" => $equipment->equipment_name,
								"equipment_id" => $equipment->id,
								"status" => $val ['problems_status'],
								"url_confirm" => site_url ( "Petition/Problems_checkout/$problems->id" )
						];

						$messageModel = new MessageModel ();
						$message_title = "Problems " . $problems->problems_tital . "#" . $problems->id;
						$message_message = view ( 'petition/message/problems/problems_message-1', $mes );
						$message_from = $session->get ( 'id' );
						$message_to = $user->id;
						$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
					}

					$data ['content'] = view ( 'problems/success_problems_message', [ 
							'status' => "alert-success",
							'message' => "update data successfully"
					] );

					return view ( 'welcome_message', $data );
				} catch ( \Exception $e ) {
					$data ['content'] = view ( 'request/success_request_message', [ 
							'status' => "alert-danger",
							'message' => "update data message fail" . $e
					] );

					return view ( 'welcome_message', $data );
				}
			} else {
				$contactModel = new ContactModel ();
				$impactModel = new ImpactModel ();
				$priorityModel = new PriorityModel ();

				$data ['content'] = view ( 'petition/confirm/manager/confirm_problems', [ 
						'validation' => $validation,
						'problems' => $problems,
						'contact' => $contactModel->findAll (),
						'impact' => $impactModel->findAll (),
						'priority' => $priorityModel->findAll ()
				] );
			}
		}

		if (! empty ( $problems )) {
			$contactModel = new ContactModel ();
			$impactModel = new ImpactModel ();
			$priorityModel = new PriorityModel ();

			$data ['content'] = view ( 'petition/confirm/manager/confirm_problems', [ 
					'problems' => $problems,
					'contact' => $contactModel->findAll (),
					'impact' => $impactModel->findAll (),
					'priority' => $priorityModel->findAll ()
			] );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}

		return view ( 'welcome_message', $data );
	}
	public function Problems_checkout($id) {
		$session = session ();
		if (! $session->has ( 'username' )) {
			return redirect ( site_url ( 'Login' ) );
		}
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$problemsModel = new ProblemsModel ();
		$problems = $problemsModel->find ( $id );
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ( $this->validationRulesConfirmCheckoutProblems );
			$validation->withRequest ( $this->request )->run ();
			if ($validation->getErrors () == null) {
				if ($problems->problems_status != 2) {
					$data ['content'] = view ( 'problems/success_problems_message', [ 
							'status' => "alert-danger",
							'message' => "inserted data message fail. Status has not been confirmed."
					] );

					return view ( 'welcome_message', $data );
				}

				if ($problems->problems_status == 3 || $problems->problems_status == 4) {
					$data ['content'] = view ( 'problems/success_problems_message', [ 
							'status' => "alert-danger",
							'message' => "inserted data message fail. You have confirmed the maintenance."
					] );

					return view ( 'welcome_message', $data );
				}

				$accept_user = $problems->getAccept ();
				if (! empty ( $accept_user )) {
					$equipment = $problems->getEquipment ();
					$mes = [ 
							"name_to" => $accept_user->username,
							"name_from" => $session->get ( 'name' ),
							"to_id" => $accept_user->id,
							"from_id" => $session->get ( 'id' ),
							"equipment_name" => $equipment->equipment_name,
							"equipment_id" => $equipment->id,
							"status" => '3',
							"url_confirm" => site_url ( "Petition/Problems_workaround/$problems->id" )
					];

					$messageModel = new MessageModel ();
					$message_title = "Problems " . $this->request->getPost ( 'problems_tital' );
					$message_message = view ( 'petition/message/problems/problems_message-2', $mes );
					$message_from = $session->get ( 'id' );
					$message_to = $accept_user->id;
					$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
				}

				$contact = $problems->getContact ()->getUser ();

				if (! empty ( $contact )) {
					$equipment = $problems->getEquipment ();
					$mes = [ 
							"name_to" => $contact->username,
							"name_from" => $session->get ( 'name' ),
							"to_id" => $contact->id,
							"from_id" => $session->get ( 'id' ),
							"equipment_name" => $equipment->equipment_name,
							"equipment_id" => $equipment->id,
							"status" => '5',
							"url_confirm" => site_url ( "Petition/Problems_workaround/$problems->id" )
					];

					$messageModel = new MessageModel ();
					$message_title = "Problems " . $this->request->getPost ( 'problems_tital' );
					$message_message = view ( 'petition/message/problems/problems_message-2', $mes );
					$message_from = $session->get ( 'id' );
					$message_to = $contact->id;
					$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
				}

				$val = [ 
						'problems_status' => 3
				];

				$problemsModel->update ( $problems->id, $val );

				$data ['content'] = view ( 'problems/success_problems_message', [
						'status' => "alert-success",
						'message' => "update data successfully"
				] );

				return view ( 'welcome_message', $data );
			} else {
				$data ['content'] = view ( 'petition/confirm/user/confirm_problems_checkout', [ 
						'validation' => $validation,
						'problems' => $problems
				] );

				return view ( 'welcome_message', $data );
			}
		}

		if (! empty ( $problems )) {
			$data ['content'] = view ( 'petition/confirm/user/confirm_problems_checkout', [ 
					'problems' => $problems
			] );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}

		return view ( 'welcome_message', $data );
	}
	public function Problems_workaround($id) {
		$session = session ();
		if (! $session->has ( 'username' )) {
			return redirect ( site_url ( 'Login' ) );
		}
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$problemsModel = new ProblemsModel ();
		$problems = $problemsModel->find ( $id );
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ( $this->validationRulesConfirmWorkaroundProblems );
			$validation->withRequest ( $this->request )->run ();
			if ($validation->getErrors () == null) {
				$problemsWorkaroundModel = new ProblemsWorkaroundModel();
				$checkpwa = $problemsWorkaroundModel->where([
						'problems_id' => $id
				])->find();
				
				if(!empty($checkpwa)) {
					$data ['content'] = view ( 'problems/success_problems_message', [
							'status' => "alert-danger",
							'message' => "There is information in the system. can not add data overlap."
					] );
					
					return view ( 'welcome_message', $data );
				}
				
				if($problems->problems_status != 3) {
					$data ['content'] = view ( 'problems/success_problems_message', [
							'status' => "alert-danger",
							'message' => "invalid status."
					] );
					
					return view ( 'welcome_message', $data );
				}
				
				$val = [
						'problems_status' => 4
				];
				
				$problemsModel->update ( $problems->id, $val );
				
				try {
					$wr = [
							'remark' => '',
							'wr_title' => $this->request->getPost('wr_title'),
							'wr_detail' =>  $this->request->getPost('wr_title'),
							'created_by' =>  $session->get('id'),
							'created_at' =>  date ( 'Y-m-d H:i:s' ),
							'updated_at' =>  date ( 'Y-m-d H:i:s' ),
					];
					
					$workaroundModel = new WorkaroundModel();
					$workaround = $workaroundModel->insert($wr);
					
					$action_start = date_create_from_format('d/m/Y', $this->request->getPost('action_start'));
					$action_end = date_create_from_format('d/m/Y', $this->request->getPost('action_end'));
					
					$pwr = [
							'remark' => '',
							'problems_id' => $problems->id,
							'wr_id' =>  $workaround,
							'action_start' =>  $action_start->format('Y-m-d 00:00:00'),
							'action_end' =>  $action_end->format('Y-m-d 23:59:59'),
							'created_by' =>  $session->get('id'),
							'created_at' =>  date ( 'Y-m-d H:i:s' ),
					];
					
					
					$problemsWorkaroundModel->insert($pwr);
					
					$data ['content'] = view ( 'problems/success_problems_message', [
							'status' => "alert-success",
							'message' => "update data successfully"
					] );
					
					return view ( 'welcome_message', $data );
				} catch (\Exception $e) {
					$data ['content'] = view ( 'problems/success_problems_message', [
							'status' => "alert-danger",
							'message' => "inserted data message fail. ". $e
					] );
					
					return view ( 'welcome_message', $data );
				}
			}else {
				$data ['content'] = view ( 'petition/confirm/manager/confirm_problems_workaround', [
						'input' => $this->request->getPost(),
						'validation' => $validation,
						'problems' => $problems
				] );
			}
			
		}

		if (! empty ( $problems )) {
			$data ['content'] = view ( 'petition/confirm/manager/confirm_problems_workaround', [ 
					'problems' => $problems
			] );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}

		return view ( 'welcome_message', $data );
	}
	public function Incident() {
		$session = session ();
		if (! $session->has ( 'username' )) {
			return redirect ( site_url ( 'Login' ) );
		}
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$incidentModel = new IncidentModel();
		$equipmentModel = new EquipmentModel ();
		
		if ($this->request->getMethod ( true ) == "POST") {
			$val = array (
					'incident_tital' => $this->request->getPost ( 'incident_tital' ),
					'incident_detail' => $this->request->getPost ( 'incident_detail' ),
					'incident_status' => 0,
					'equipment_id' => $this->request->getPost ( 'equipment_id' ),
					'contact_id' => null,
					'impact_id' => null,
					'priority_id' => null,
					'created_by' => $session->get ( 'id' )
			);
			
			$validation->setRules ( $this->validationRulesIncident );
			$validation->withRequest ( $this->request )->run ();
			
			if ($validation->getErrors () == null) {
				try {
					$incident_id = $incidentModel->insert ( $val );
					$equipment = $equipmentModel->find ( $val ['equipment_id'] );
					
					$userModel = new UserModel ();
					$users_manager = $userModel->where ( 'permission_id', 3 )->findAll ();
					
					if(empty($incident_id)) {
						$data ['content'] = view ( 'request/success_request_message', [
								'status' => "alert-danger",
								'message' => "inserted data message fail"
						] );
						
						return view ( 'welcome_message', $data );
					}
					
					
					foreach ( $users_manager as $user_manager ) {
						$mes = [
								"name_to" => $user_manager->username,
								"name_from" => $session->get ( 'name' ),
								"to_id" => $user_manager->id,
								"from_id" => $session->get ( 'id' ),
								"equipment_name" => $equipment->equipment_name,
								"equipment_id" => $equipment->id,
								"url_confirm" => site_url ( "Petition/incident_confirm/$incident_id" )
						];
						
						$messageModel = new MessageModel ();
						$message_title = "incident " . $this->request->getPost ( 'incident_tital' );
						$message_message = view ( 'petition/message/incident/incident_message-0', $mes );
						$message_from = $session->get ( 'id' );
						$message_to = $user_manager->id;
						$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
					}
					
					$data ['content'] = view ( 'incident/success_incident_message', [
							'status' => "alert-success",
							'message' => "inserted data successfully"
					] );
				} catch ( \Exception $e ) {
					$data ['content'] = view ( 'request/success_request_message', [
							'status' => "alert-danger",
							'message' => "inserted data message fail" . $e
					] );
				}
				
				return view ( 'welcome_message', $data );
			} else {
				
				$data ['content'] = view ( 'petition/add_incident_message', [
						'errors' => $validation->getErrors (),
						'equipment' => $equipmentModel->findAll (),
						'input' => $val
				] );
				
				return view ( "welcome_message", $data );
			}
		}
		
		$data ['content'] = view ( 'petition/add_incident_message', [
				'validation' => $validation,
				'equipment' => $equipmentModel->findAll ()
		] );
		
		return view ( 'welcome_message', $data );
	}
	public function Incident_confirm($id) {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		
		$session = session ();
		$validation = \Config\Services::validation ();
		$incidentModel = new IncidentModel();
		$incident = $incidentModel->find ( $id );
		
		if ($this->request->getMethod ( true ) == "POST") {
			
			if ($this->request->getPost ( 'incident_status' ) == 2) {
				$this->validationRulesConfirmProblems ['contact_id'] = [
						'label' => 'contact choose',
						'rules' => 'required'
				];
				$this->validationRulesConfirmProblems ['impact_id'] = [
						'label' => 'impact choose',
						'rules' => 'required'
				];
				$this->validationRulesConfirmProblems ['priority_id'] = [
						'label' => 'priority choose',
						'rules' => 'required'
				];
			}
			
			if($incident->incident_status != 0) {
				$data ['content'] = view ( 'request/success_request_message', [
						'status' => "alert-danger",
						'message' => "update data message fail"
				] );
				
				return view ( 'welcome_message', $data );
			}
			
			$validation->setRules ( $this->validationRulesConfirmIncident );
			$validation->withRequest ( $this->request )->run ();
			
			if ($validation->getErrors () == null) {
				$val = [
						'contact_id' => empty ( $this->request->getPost ( 'contact_id' ) ) ? null : $this->request->getPost ( 'contact_id' ),
						'impact_id' => empty ( $this->request->getPost ( 'impact_id' ) ) ? null : $this->request->getPost ( 'impact_id' ),
						'priority_id' => empty ( $this->request->getPost ( 'priority_id' ) ) ? null : $this->request->getPost ( 'priority_id' ),
						'incident_status' => $this->request->getPost ( 'incident_status' ),
						'accept_id' => $session->get('id')
				];
				
				try {
					$incidentModel->update ( $id, $val );
					
					$userModel = new UserModel ();
					$user = $userModel->find ( $incident->created_by );
					
					if (! empty ( $user )) {
						$equipment = $incident->getEquipment ();
						
						$mes = [
								"name_to" => $user->username,
								"name_from" => $session->get ( 'name' ),
								"to_id" => $user->id,
								"from_id" => $session->get ( 'id' ),
								"equipment_name" => $equipment->equipment_name,
								"equipment_id" => $equipment->id,
								"status" => $val ['incident_status'],
								"url_confirm" => site_url ( "Petition/Incident_checkout/$incident->id" )
						];
						
						$messageModel = new MessageModel ();
						$message_title = "Incident " . $incident->incident_tital . "#" . $incident->id;
						$message_message = view ( 'petition/message/incident/incident_message-1', $mes );
						$message_from = $session->get ( 'id' );
						$message_to = $user->id;
						$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
					}
					
					$data ['content'] = view ( 'incident/success_incident_message', [
							'status' => "alert-success",
							'message' => "update data successfully"
					] );
					
					return view ( 'welcome_message', $data );
				} catch ( \Exception $e ) {
					$data ['content'] = view ( 'request/success_request_message', [
							'status' => "alert-danger",
							'message' => "update data message fail" . $e
					] );
					
					return view ( 'welcome_message', $data );
				}
			} else {
				$contactModel = new ContactModel ();
				$impactModel = new ImpactModel ();
				$priorityModel = new PriorityModel ();
				
				$data ['content'] = view ( 'petition/confirm/manager/confirm_problems', [
						'validation' => $validation,
						'incident' => $incident,
						'contact' => $contactModel->findAll (),
						'impact' => $impactModel->findAll (),
						'priority' => $priorityModel->findAll ()
				] );
			}
		}
		
		if (! empty ( $incident )) {
			$contactModel = new ContactModel ();
			$impactModel = new ImpactModel ();
			$priorityModel = new PriorityModel ();
			
			$data ['content'] = view ( 'petition/confirm/manager/confirm_incident', [
					'incident' => $incident,
					'contact' => $contactModel->findAll (),
					'impact' => $impactModel->findAll (),
					'priority' => $priorityModel->findAll ()
			] );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
		
		return view ( 'welcome_message', $data );
	}
	
	public function Incident_checkout($id) {
		$session = session ();
		if (! $session->has ( 'username' )) {
			return redirect ( site_url ( 'Login' ) );
		}
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$incidentModel = new IncidentModel();
		$incident = $incidentModel->find ( $id );
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ( $this->validationRulesConfirmCheckoutProblems );
			$validation->withRequest ( $this->request )->run ();
			if ($validation->getErrors () == null) {
				if ($incident->incident_status != 2) {
					$data ['content'] = view ( 'incident/success_incident_message', [
							'status' => "alert-danger",
							'message' => "inserted data message fail. Status has not been confirmed."
					] );
					
					return view ( 'welcome_message', $data );
				}
				
				if ($incident->incident_status == 3 || $incident->incident_status == 4) {
					$data ['content'] = view ( 'incident/success_incident_message', [
							'status' => "alert-danger",
							'message' => "inserted data message fail. You have confirmed the maintenance."
					] );
					
					return view ( 'welcome_message', $data );
				}
				
				$accept_user = $incident->getAccept ();
				if (! empty ( $accept_user )) {
					$equipment = $incident->getEquipment ();
					$mes = [
							"name_to" => $accept_user->username,
							"name_from" => $session->get ( 'name' ),
							"to_id" => $accept_user->id,
							"from_id" => $session->get ( 'id' ),
							"equipment_name" => $equipment->equipment_name,
							"equipment_id" => $equipment->id,
							"status" => '3',
							"url_confirm" => site_url ( "Petition/Incident_workaround/$incident->id" )
					];
					
					$messageModel = new MessageModel ();
					$message_title = "Incident " . $this->request->getPost ( 'incident_tital' );
					$message_message = view ( 'petition/message/incident/incident_message-2', $mes );
					$message_from = $session->get ( 'id' );
					$message_to = $accept_user->id;
					$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
				}
				
				$contact = $incident->getContact ()->getUser ();
				
				if (! empty ( $contact )) {
					$equipment = $incident->getEquipment ();
					$mes = [
							"name_to" => $contact->username,
							"name_from" => $session->get ( 'name' ),
							"to_id" => $contact->id,
							"from_id" => $session->get ( 'id' ),
							"equipment_name" => $equipment->equipment_name,
							"equipment_id" => $equipment->id,
							"status" => '5',
							"url_confirm" => site_url ( "Petition/Incident_workaround/$incident->id" )
					];
					
					$messageModel = new MessageModel ();
					$message_title = "Incident " . $this->request->getPost ( 'incident_tital' );
					$message_message = view ( 'petition/message/incident/incident_message-2', $mes );
					$message_from = $session->get ( 'id' );
					$message_to = $contact->id;
					$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );
				}
				
				$val = [
						'incident_status' => 3
				];
				
				$incidentModel->update ( $incident->id, $val );
				
				$data ['content'] = view ( 'incident/success_incident_message', [
						'status' => "alert-success",
						'message' => "update data successfully"
				] );
				
				return view ( 'welcome_message', $data );
			} else {
				$data ['content'] = view ( 'petition/confirm/user/confirm_incident_checkout', [
						'validation' => $validation,
						'incident' => $incident
				] );
				
				return view ( 'welcome_message', $data );
			}
		}
		
		if (! empty ( $incident )) {
			$data ['content'] = view ( 'petition/confirm/user/confirm_incident_checkout', [
					'incident' => $incident
			] );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
		
		return view ( 'welcome_message', $data );
	}
	
	public function Incident_workaround($id) {
		$session = session ();
		if (! $session->has ( 'username' )) {
			return redirect ( site_url ( 'Login' ) );
		}
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$incidentModel = new IncidentModel();
		$incident = $incidentModel->find ( $id );
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ( $this->validationRulesConfirmWorkaroundProblems );
			$validation->withRequest ( $this->request )->run ();
			if ($validation->getErrors () == null) {
				$incidentWorkaroundModel = new IncidentWorkaroundModel();
				$checkpwa = $incidentWorkaroundModel->where([
						'incident_id' => $id
				])->find();
				
				if(!empty($checkpwa)) {
					$data ['content'] = view ( 'incident/success_incident_message', [
							'status' => "alert-danger",
							'message' => "There is information in the system. can not add data overlap."
					] );
					
					return view ( 'welcome_message', $data );
				}
				
				if($incident->incident_status != 3) {
					$data ['content'] = view ( 'incident/success_incident_message', [
							'status' => "alert-danger",
							'message' => "invalid status."
					] );
					
					return view ( 'welcome_message', $data );
				}
				
				$val = [
						'incident_status' => 4
				];
				
				$incidentModel->update ( $incident->id, $val );
				
				try {
					$wr = [
							'remark' => '',
							'wr_title' => $this->request->getPost('wr_title'),
							'wr_detail' =>  $this->request->getPost('wr_title'),
							'created_by' =>  $session->get('id'),
							'created_at' =>  date ( 'Y-m-d H:i:s' ),
							'updated_at' =>  date ( 'Y-m-d H:i:s' ),
					];
					
					$workaroundModel = new WorkaroundModel();
					$workaround = $workaroundModel->insert($wr);
					
					$action_start = date_create_from_format('d/m/Y', $this->request->getPost('action_start'));
					$action_end = date_create_from_format('d/m/Y', $this->request->getPost('action_end'));
					
					$pwr = [
							'remark' => '',
							'incident_id' => $incident->id,
							'wr_id' =>  $workaround,
							'action_start' =>  $action_start->format('Y-m-d 00:00:00'),
							'action_end' =>  $action_end->format('Y-m-d 23:59:59'),
							'created_by' =>  $session->get('id'),
							'created_at' =>  date ( 'Y-m-d H:i:s' ),
					];
					
					
					$incidentWorkaroundModel->insert($pwr);
					
					$data ['content'] = view ( 'incident/success_incident_message', [
							'status' => "alert-success",
							'message' => "update data successfully"
					] );
					
					return view ( 'welcome_message', $data );
				} catch (\Exception $e) {
					$data ['content'] = view ( 'incident/success_incident_message', [
							'status' => "alert-danger",
							'message' => "inserted data message fail. ". $e
					] );
					
					return view ( 'welcome_message', $data );
				}
			}else {
				$data ['content'] = view ( 'petition/confirm/manager/confirm_problems_workaround', [
						'input' => $this->request->getPost(),
						'validation' => $validation,
						'incident' => $incident
				] );
			}
			
		}
		
		if (! empty ( $incident )) {
			$data ['content'] = view ( 'petition/confirm/manager/confirm_incident_workaround', [
					'incident' => $incident
			] );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
		
		return view ( 'welcome_message', $data );
	}

	// --------------------------------------------------------------------
}
