<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\incidentModel;
use App\Models\EquipmentModel;
use App\Models\ContactModel;
use App\Models\ImpactModel;
use App\Models\PriorityModel;
use App\Models\UserModel;

class incident extends Controller {
	protected $helpers = [
			'url',
			'form'
	];
	private $validationRules = [
			'incident_tital' => [
					'label' => 'Tital',
					'rules' => 'required'
			],
			'incident_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'incident_status' => [
					'label' => 'Status',
					'rules' => 'required'
			],
			'equipment_id' => [
					'label' => 'Equipment ID',
					'rules' => 'required'
			],
			'contact_id' => [
					'label' => 'Contact',
					'rules' => 'required'
			],
			'impact_id' => [
					'label' => 'Impact',
					'rules' => 'required'
			],
			'priority_id' => [
					'label' => 'Priority',
					'rules' => 'required'
			],
			'user_id' => [
					'label' => 'User',
					'rules' => 'required'
			]
	];
	private $validationRulesOnUpdate = [
			'incident_tital' => [
					'label' => 'Tital',
					'rules' => 'required'
			],
			'incident_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'incident_status' => [
					'label' => 'Status',
					'rules' => 'required'
			],
			'equipment_id' => [
					'label' => 'Equipment ID',
					'rules' => 'required'
			],
			'contact_id' => [
					'label' => 'Contact',
					'rules' => 'required'
			],
			'impact_id' => [
					'label' => 'Impact',
					'rules' => 'required'
			],
			'priority_id' => [
					'label' => 'Priority',
					'rules' => 'required'
			],
			'user_id' => [
					'label' => 'User',
					'rules' => 'required'
			]
	];
	public function __construct() {
	}
	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		// printf($this->request->getDefaultLocale()) ;

		$data ['content'] = lang ( 'content.incident_view', [
				3
		] );
		return view ( 'incident/list_incident_message', $data );
	}
	public function list() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		if ($this->request->getMethod ( true ) == "POST") {
			if (! $this->validate ( [ ] )) {
				$validation->withRequest ( $this->request )->run ();
			} else {
				$data ['content'] = view ( 'incident/success_incident_message' );
			}
		}
		$incidentModel = new incidentModel ();

		$elements_per_page = 5;
		$incident = $incidentModel->get_all_incident ( $elements_per_page, 0 );
		$rows = $incidentModel->countAllResults ( 'incident' );
		$number_of_page = ceil ( $rows / $elements_per_page );

		if (! isset ( $_GET ["page"] )) {
			$page = 1;
		} else {
			$page = $_GET ["page"];
			if ($page < 1 || $page > $number_of_page) {
				$page = 1;
			} else {
				$page = $_GET ["page"];
			}
		}

		$start_element = ($page - 1) * $elements_per_page;
		$query_limit = $incidentModel->get ( $elements_per_page, $start_element )->getResult ();

		$data ['content'] = view ( 'incident/list_incident_message', [
				'validation' => $validation,
				'incident' => $incident,
				'rows' => $rows,
				'rows_limit' => $query_limit,
				'number_of_page' => $number_of_page,
				'page' => $page
		] );

		return view ( 'welcome_message', $data );
	}
	public function Add() {
		$data = array ();

		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$incidentModel = new incidentModel ();
		$equipmentModel = new EquipmentModel ();
		$contactModel = new ContactModel ();
		$impactModel = new ImpactModel ();
		$priorityModel = new PriorityModel ();
		$userModel = new UserModel ();

		$data = array (
				'incident_tital' => $this->request->getPost ( 'incident_tital' ),
				'incident_detail' => $this->request->getPost ( 'incident_detail' ),
				'incident_status' => $this->request->getPost ( 'incident_status' ),
				'equipment_id' => $this->request->getPost ( 'equipment_id' ),
				'contact_id' => $this->request->getPost ( 'contact_id' ),
				'impact_id' => $this->request->getPost ( 'impact_id' ),
				'priority_id' => $this->request->getPost ( 'priority_id' ),
				'user_id' => $this->request->getPost ( 'user_id' )
		);

		$data ['nav'] = view ( 'nav_message' );

		if ($this->request->getMethod ( true ) == "POST") {

			$validation->setRules ( $this->validationRules );

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {

				$incidentModel->insert ( $data );

				$data ['content'] = view ( 'incident/success_incident_message', [
						'message' => "inserted data successfully"
				] );

				return view ( 'welcome_message', $data );
			} else {

				$data ['content'] = view ( 'incident/add_incident_message', [
						'errors' => $validation->getErrors (),
						'equipment' => $equipmentModel->findAll (),
						'contact' => $contactModel->findAll (),
						'impact' => $impactModel->findAll (),
						'priority' => $priorityModel->findAll (),
						'user' => $userModel->findAll ()
				] );

				return view ( "welcome_message", $data );
			}
		}

		$data ['content'] = view ( 'incident/add_incident_message', [
				'validation' => $validation,
				'equipment' => $equipmentModel->findAll (),
				'contact' => $contactModel->findAll (),
				'impact' => $impactModel->findAll (),
				'priority' => $priorityModel->findAll (),
				'user' => $userModel->findAll ()
		] );

		return view ( 'welcome_message', $data );
	}
	public function AddProcess() {
		if (! $this->request->isSecure ()) {

			$password = $this->request->getPost ( 'password' );
			$incidentModel = new incidentModel ();

			$hash = password_hash ( $password, PASSWORD_BCRYPT, [
					"cost=>8"
			] );

			$data = array (
					'incident_tital' => $this->request->getPost ( 'incident_tital' ),
					'incident_detail' => $this->request->getPost ( 'incident_detail' ),
					'incident_status' => $this->request->getPost ( 'incident_status' ),
					'equipment_id' => $this->request->getPost ( 'equipment_id' ),
					'contact_id' => $this->request->getPost ( 'contact_id' ),
					'impact_id' => $this->request->getPost ( 'impact_id' ),
					'priority_id' => $this->request->getPost ( 'priority_id' ),
					'user_id' => $this->request->getPost ( 'user_id' )
			);

			$incident = new App\Entities\incidentEntity ();

			$incident->setremark ( "" );
			$incident->setCreated_at ( date ( 'Y-m-d H:i:s' ) );
			$incident->setUpdated_at ( date ( 'Y-m-d H:i:s' ) );

			$incidentModel->insert ( $data );
		}
		return redirect ( 'http://localhost/service/public/index.php/incident/add' );
	}
	public function delete() {
		if (! $this->request->isSecure ()) {
			$id = array (
					'id' => $this->request->getPost ( 'id' )
			);
			$incident = new incidentModel ();
			$incident->where ( 'id', $id );
			$incident->delete ();
		}
	}
	public function dataProcessing() {
		if ($this->request->getMethod () == 'post') {
			$elements_per_page = $this->request->getVar ( 'length' );
			$elements_start = $this->request->getVar ( 'start' );

			if ($elements_per_page == null || $elements_start == null) {
				return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
			}

			$search_value = $this->request->getVar ( 'search[value]' );

			$incident = new App\Entities\incidentEntity ();
			$incidentModel = new incidentModel ();
			$incident = $incidentModel->get_incident ( $elements_per_page, $elements_start, $search_value );

			$recordsTotal = $incidentModel->countAllResults ( 'incident' );

			// $search_regex = $this->request->getVar('search[regex]');
			// $columns = $this->request->getVar('columns');

			// $order_column = $this->request->getVar('order[0][column]');
			// $order_dir = $this->request->getVar('order[0][dir]');

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $incident;

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
	public function update() {
		$data = array ();
		$id = array (
				'id' => $this->request->getPost ( 'id' )
		);
		$data ['nav'] = view ( 'nav_message' );
		$data ['content'] = " 5555 ";

		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		if ($this->request->getMethod ( true ) == "POST") {
			if (! $this->validate ( [ ] )) {

				$validation->withRequest ( $this->request )->run ();
			} else {
				$data ['content'] = view ( 'incident/success_incident_message' );
			}
		}

		$incidentModel = new incidentModel ();
		$incident = $incidentModel->find ( $id );

		$data ['content'] = view ( 'incident/update_incident_message', [
				'validation' => $validation,
				'incident' => $incident
		] );

		return view ( 'welcome_message', $data );
	}
	public function updateForm($id = null) {
		if ($id != null || $id != '') {
			$incidentModel = new IncidentModel ();
			$EquipmentModel = new EquipmentModel ();
			$ContactModel = new ContactModel ();
			$ImpactModel = new ImpactModel ();
			$PriorityModel = new PriorityModel ();
			$UserModel = new UserModel ();

			$incidentModel->jointable ( $id, "equipment", "contact", "impact", "priority", "user" );
			$old_data = $incidentModel->get ();
			$old_data = $old_data->getResult ();

			$incident = $incidentModel->find ( $id );

			$data = [
					// 'validation' => $validation,
					'incident' => $incident,

					'equipment_new' => $EquipmentModel->findAll (),

					'contact_new' => $ContactModel->findAll (),

					'impact_new' => $ImpactModel->findAll (),

					'priority_new' => $PriorityModel->findAll (),

					'user_new' => $UserModel->findAll ()
			];

			return view ( 'incident/update_incident_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function deleteForm($id = null) {
		if ($id != null || $id != '') {
			$incidentModel = new IncidentModel ();
			$incidentModel->table ( 'incident' );
			$incidentModel->select ( 'incident.*, equipment.id AS equipment, equipment.equipment_name,
                                            contact.id AS contact, contact.contact_name,
                                            impact.id AS 	impact, impact.impact_name,
                                            priority.id AS priority, priority.priority_name,
                                            user.id AS user, user.username' );

			$incidentModel->join ( 'equipment', 'equipment.id = incident.equipment_id' );
			$incidentModel->join ( 'contact', 'contact.id = incident.contact_id' );
			$incidentModel->join ( 'impact', 'impact.id = incident.impact_id' );
			$incidentModel->join ( 'priority', 'priority.id = incident.priority_id' );
			$incidentModel->join ( 'user', 'user.id = incident.user_id' );

			$incidentModel->where ( array (
					'incident.id' => $id
			) );

			$incident = $incidentModel->get ();
			$incident = $incident->getResult ();

			$data = [
					// 'validation' => $validation,
					'incident' => $incident
			];

			return view ( 'incident/view_incident_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function UpdateProcess() {
		if (! $this->request->isSecure ()) {

			$incidentModel = new incidentModel ();
			$EquipmentModel = new EquipmentModel ();
			$ContactModel = new ContactModel ();
			$ImpactModel = new ImpactModel ();
			$PriorityModel = new PriorityModel ();
			$UserModel = new UserModel ();
			$validation = \Config\Services::validation ();

			$id = $this->request->getPost ( 'id' );

			$data = array (
					'incident_tital' => $this->request->getPost ( 'incident_tital' ),
					'incident_detail' => $this->request->getPost ( 'incident_detail' ),
					'incident_status' => $this->request->getPost ( 'incident_status' ),
					'equipment_id' => $this->request->getPost ( 'equipment_id' ),
					'contact_id' => $this->request->getPost ( 'contact_id' ),
					'impact_id' => $this->request->getPost ( 'impact_id' ),
					'priority_id' => $this->request->getPost ( 'priority_id' ),
					'user_id' => $this->request->getPost ( 'user_id' )
			);

			if ($this->request->getMethod ( true ) == "POST") {

				$validation->setRules ( $this->validationRulesOnUpdate );

				$validation->withRequest ( $this->request )->run ();

				if ($validation->getErrors () == null) {

					$incidentModel->update ( $id, $data );

					return view ( 'incident/success_update_incident_message', [
							'message' => "update data successfully"
					] );
				} else {

					$incidentModel->jointable ( $id, "equipment", "contact", "impact", "priority", "user" );

					$incident = $incidentModel->get ();
					$old_data = $incident->getResult ();

					$incident = $incidentModel->find ( $id );

					$data = [
							// 'validation' => $validation,
							'errors' => $validation->getErrors (),
							'incident' => $incident,

							'equipment_new' => $EquipmentModel->findAll (),

							'contact_new' => $ContactModel->findAll (),

							'impact_new' => $ImpactModel->findAll (),

							'priority_new' => $PriorityModel->findAll (),

							'user_new' => $UserModel->findAll ()
					];

					return view ( 'incident/update_incident_message', $data );
				}
			}
		}
	}
	public function Report() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$incidentModel = new incidentModel ();
		$pb = new App\Entities\incidentEntity ();

		if (empty ( $incidentModel->get_max () )) {

			$data ['content'] = view ( 'incident/report_incident_message', [
					'validation' => $validation,
					'start_time' => null,
					'end_time' => null,
					'error' => "ข้อมูลIncident ว่างเปล่า"
			] );

			return view ( 'welcome_message', $data );
		}

		foreach ( $incidentModel->get_max () as $key ) {

			$max = $key->id;
		}

			$min = 0;


		$elements_per_page = $max;
		$incident = $incidentModel->get_all_incident ( $elements_per_page, 0 );

		if ($this->request->getMethod ( true ) == "POST") {

			$start_time = $this->request->getPost ( 'start_time' );
			$end_time = $this->request->getPost ( 'end_time' );

			$new_start_time = date ( "Y/m/d H:i:s", strtotime ( $start_time ) );
			// $create_at = date("Y/m/d H:i:s", strtotime($request[0]->created_at));
			$new_end_time = date ( "Y/m/d H:i:s", strtotime ( $end_time ) );

			for($i = $min; $i <= $max; $i ++) {

				if (! empty ( $incident [$i] )) {
					$create_at [$i] = date ( "Y/m/d H:i:s", strtotime ( $incident [$i]->created_at ) );

					if (! empty ( $incident [$i]->created_at )) {

						if ($create_at [$i] > $new_start_time && $create_at [$i] < $new_end_time) {
							// if($create_at < $new_start_time || $create_at > $new_end_time){
							//
							// continue;
							//
							// }
							$temp [$i] = $incident [$i];

						}
					}
				}
			}
		

			if (! empty ( $temp )) {
				$cancel = 0;
				$access = 0;
				$comfirm = 0;
				$workaround = 0;
				$total = 0;

				// check status
				for($i = $min; $i <= $max; $i ++) {
					if (! empty ( $temp [$i] )) {
						$total ++;
					}

					if (! empty ( $temp [$i]->incident_status )) {
						if ($temp [$i]->incident_status == 1) {
							$cancel ++;
						}
						if ($temp [$i]->incident_status == 2) {
							$access ++;
						}
						if ($temp [$i]->incident_status == 3) {
							$comfirm ++;
						}
						if ($temp [$i]->incident_status == 4) {
							$workaround ++;
						}
					}
				}
				// echo $cancel;
				// echo $access;
				// echo $comfirm;
				// echo $workaround;
				// echo $total;

				// echo $not_success;

				$data ['content'] = view ( 'incident/report_incident_message', [
						'validation' => $validation,
						'start_time' => $start_time,
						'end_time' => $end_time,
						'cancel' => $cancel,
						'access' => $access,
						'comfirm' => $comfirm,
						'workaround' => $workaround,
						'total' => $total
				] );

				return view ( 'welcome_message', $data );
			} elseif (empty ( $temp )) {

				$data ['content'] = view ( 'incident/report_incident_message', [
						'validation' => $validation,
						'start_time' => $start_time,
						'end_time' => $end_time,
						'error' => "ไม่พบข้อมูลที่ต้องการ"
				] );

				return view ( 'welcome_message', $data );
			}
		}

		$data ['content'] = view ( 'incident/report_incident_message', [
 				'validation' => $validation,
 				'start_time' => null,
 				'end_time' => null



 		] );

 		return view ( 'welcome_message', $data );

 	}



}
