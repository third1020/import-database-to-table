<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\ProblemsModel;
use App\Models\EquipmentModel;
use App\Models\ContactModel;
use App\Models\ImpactModel;
use App\Models\PriorityModel;

class Problems extends Controller {
	protected $helpers = [
			'url',
			'form'
	];
	private $validationRules = [
			'problems_tital' => [
					'label' => 'Tital',
					'rules' => 'required'
			],
			'problems_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'problems_status' => [
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
			]
	];
	private $validationRulesOnUpdate = [
			'problems_tital' => [
					'label' => 'Tital',
					'rules' => 'required'
			],
			'problems_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'problems_status' => [
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
			]
	];
	public function __construct() {
	}
	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		// printf($this->request->getDefaultLocale()) ;

		$data ['content'] = lang ( 'content.problems_view', [
				3
		] );
		return view ( 'problems/list_problems_message', $data );
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
				$data ['content'] = view ( 'problems/success_problems_message' );
			}
		}
		$ProblemsModel = new ProblemsModel ();

		$elements_per_page = 5;
		$problems = $ProblemsModel->get_all_problems ( $elements_per_page, 0 );
		$rows = $ProblemsModel->countAllResults ( 'problems' );
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
		$query_limit = $ProblemsModel->get ( $elements_per_page, $start_element )->getResult ();

		$data ['content'] = view ( 'problems/list_problems_message', [
				'validation' => $validation,
				'problems' => $problems,
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
		$problemsModel = new ProblemsModel ();
		$equipmentModel = new EquipmentModel ();
		$contactModel = new ContactModel ();
		$impactModel = new ImpactModel ();
		$priorityModel = new PriorityModel ();

		$data = array (
				'problems_tital' => $this->request->getPost ( 'problems_tital' ),
				'problems_detail' => $this->request->getPost ( 'problems_detail' ),
				'problems_status' => $this->request->getPost ( 'problems_status' ),
				'equipment_id' => $this->request->getPost ( 'equipment_id' ),
				'contact_id' => $this->request->getPost ( 'contact_id' ),
				'impact_id' => $this->request->getPost ( 'impact_id' ),
				'priority_id' => $this->request->getPost ( 'priority_id' )
		);
		$data ['nav'] = view ( 'nav_message' );

		if ($this->request->getMethod ( true ) == "POST") {

			$validation->setRules ( $this->validationRules );

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {

				$problemsModel->insert ( $data );
				$data ['content'] = view ( 'problems/success_problems_message', [
						'message' => "inserted data successfully"
				] );

				return view ( 'welcome_message', $data );
			} else {

				$data ['content'] = view ( 'problems/add_problems_message', [
						'errors' => $validation->getErrors (),
						'equipment' => $equipmentModel->findAll (),
						'contact' => $contactModel->findAll (),
						'impact' => $impactModel->findAll (),
						'priority' => $priorityModel->findAll ()
				] );

				return view ( "welcome_message", $data );
			}
		}

		$data ['content'] = view ( 'problems/add_problems_message', [
				'validation' => $validation,
				'equipment' => $equipmentModel->findAll (),
				'contact' => $contactModel->findAll (),
				'impact' => $impactModel->findAll (),
				'priority' => $priorityModel->findAll ()
		] );

		return view ( 'welcome_message', $data );
	}
	public function AddProcess() {
		if (! $this->request->isSecure ()) {

			$ProblemsModel = new ProblemsModel ();

			$data = array (
					'problems_tital' => $this->request->getPost ( 'problems_tital' ),
					'problems_detail' => $this->request->getPost ( 'problems_detail' ),
					'problems_status' => $this->request->getPost ( 'problems_status' ),
					'equipment_id' => $this->request->getPost ( 'equipment_id' ),
					'contact_id' => $this->request->getPost ( 'contact_id' ),
					'impact_id' => $this->request->getPost ( 'impact_id' ),
					'priority_id' => $this->request->getPost ( 'priority_id' )
			);

			// $problems = new App\Entities\UserEntity();
			//
			//
			// $problems->setremark("");
			// $problems->setCreated_at(date('Y-m-d H:i:s'));
			// $problems->setUpdated_at(date('Y-m-d H:i:s'));
			//
			// $ProblemsModel->insert($data);
			$data ['content'] = view ( 'Problems/preview_problems_message', [
					'nav' => view ( 'nav_message' ),
					'confirm' => $data
			] );
			return view ( "welcome_message", $data );
		}
	}
	public function AddProcessPreview() {
		$problemsModel = new ProblemsModel ();
		$equipmentModel = new EquipmentModel ();
		$contactModel = new ContactModel ();
		$impactModel = new ImpactModel ();
		$priorityModel = new PriorityModel ();

		$data = array (
				'problems_tital' => $this->request->getPost ( 'problems_tital' ),
				'problems_detail' => $this->request->getPost ( 'problems_detail' ),
				'problems_status' => $this->request->getPost ( 'problems_status' ),
				'equipment_id' => $this->request->getPost ( 'equipment_id' ),
				'contact_id' => $this->request->getPost ( 'contact_id' ),
				'impact_id' => $this->request->getPost ( 'impact_id' ),
				'priority_id' => $this->request->getPost ( 'priority_id' )
		);

		if ($problemsModel->save ( $data ) == true) {
			$data ['content'] = view ( 'problems/success_problems_message', [
					'message' => "inserted data successfully"
			] );
			return view ( "welcome_message", $data );
		} else if ($problemsModel->save ( $data ) == false) // error
		{

			$data ['content'] = view ( 'Problems/add_problems_message', [
					'errors' => $problemsModel->errors (),
					'equipment' => $equipmentModel->findAll (),
					'contact' => $contactModel->findAll (),
					'impact' => $impactModel->findAll (),
					'priority' => $priorityModel->findAll ()
			] );

			return view ( "welcome_message", $data );
		}
	}
	public function delete() {
		if (! $this->request->isSecure ()) {
			$id = array (
					'id' => $this->request->getPost ( 'id' )
			);
			$problems = new ProblemsModel ();
			$problems->where ( 'id', $id );
			$problems->delete ();
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

			$problems = new App\Entities\UserEntity ();
			$ProblemsModel = new ProblemsModel ();
			$problems = $ProblemsModel->get_problems ( $elements_per_page, $elements_start, $search_value );

			$recordsTotal = $ProblemsModel->countAllResults ( 'problems' );

			// $search_regex = $this->request->getVar('search[regex]');
			// $columns = $this->request->getVar('columns');

			// $order_column = $this->request->getVar('order[0][column]');
			// $order_dir = $this->request->getVar('order[0][dir]');

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $problems;

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
				$data ['content'] = view ( 'Problems/success_problems_message' );
			}
		}

		$ProblemsModel = new ProblemsModel ();
		$problems = $ProblemsModel->find ( $id );

		$data ['content'] = view ( 'problems/update_problems_message', [
				'validation' => $validation,
				'problems' => $problems
		] );

		return view ( 'welcome_message', $data );
	}
	public function updateForm($id = null) {
		if ($id != null || $id != '') {
			$ProblemsModel = new ProblemsModel ();
			$EquipmentModel = new EquipmentModel ();
			$ContactModel = new ContactModel ();
			$ImpactModel = new ImpactModel ();
			$PriorityModel = new PriorityModel ();

			$ProblemsModel->jointable ( $id, "equipment", "contact", "impact", "priority", "user" );
			$old_data = $ProblemsModel->get ();
			$old_data = $old_data->getResult ();

			$problems = $ProblemsModel->find ( $id );

			$data = [
					// 'validation' => $validation,
					'problems' => $problems,

					'equipment_old' => $old_data,
					'equipment_new' => $EquipmentModel->findAll (),

					'contact_old' => $old_data,
					'contact_new' => $ContactModel->findAll (),

					'impact_old' => $old_data,
					'impact_new' => $ImpactModel->findAll (),

					'priority_old' => $old_data,
					'priority_new' => $PriorityModel->findAll ()
			];

			return view ( 'problems/update_problems_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function deleteForm($id = null) {
		if ($id != null || $id != '') {
			$ProblemsModel = new ProblemsModel ();
			$problems = $ProblemsModel->jointable ( $id, "equipment", "contact", "impact", "priority" );
			$problems = $ProblemsModel->get ();
			$problems = $problems->getResult ();

			

			$data = [
					// 'validation' => $validation,
					'problems' => $problems
			];

			return view ( 'Problems/view_problems_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function UpdateProcess() {
		if (! $this->request->isSecure ()) {

			$problemsModel = new ProblemsModel ();
			$EquipmentModel = new EquipmentModel ();
			$ContactModel = new ContactModel ();
			$ImpactModel = new ImpactModel ();
			$PriorityModel = new PriorityModel ();
			$validation = \Config\Services::validation ();

			$id = $this->request->getPost ( 'id' );

			$data = array (
					'problems_tital' => $this->request->getPost ( 'problems_tital' ),
					'problems_detail' => $this->request->getPost ( 'problems_detail' ),
					'problems_status' => $this->request->getPost ( 'problems_status' ),
					'equipment_id' => $this->request->getPost ( 'equipment_id' ),
					'contact_id' => $this->request->getPost ( 'contact_id' ),
					'impact_id' => $this->request->getPost ( 'impact_id' ),
					'priority_id' => $this->request->getPost ( 'priority_id' )
			);

			if ($this->request->getMethod ( true ) == "POST") {

				$validation->setRules ( $this->validationRulesOnUpdate );

				$validation->withRequest ( $this->request )->run ();

				if ($validation->getErrors () == null) {

					$problemsModel->update ( $id, $data );

					return view ( 'problems/success_update_problems_message', [
							'message' => "update data successfully"
					] );
				} else {

					$problemsModel->jointable ( $id, "equipment", "contact", "impact", "priority", "user" );

					$problems = $problemsModel->get ();
					$old_data = $problems->getResult ();

					$problems = $problemsModel->find ( $id );


					$data = [
							// 'validation' => $validation,
							'errors' => $validation->getErrors (),
							'problems' => $problems,

							'equipment_new' => $EquipmentModel->findAll (),

							'contact_new' => $ContactModel->findAll (),

							'impact_new' => $ImpactModel->findAll (),

							'priority_new' => $PriorityModel->findAll ()
					];

					return view ( 'Problems/update_problems_message', $data );
				}
			}
		}
	}
	public function UpdatePreviewProcess() {
		$problemsModel = new ProblemsModel ();
		$equipmentModel = new EquipmentModel ();
		$ContactModel = new ContactModel ();
		$ImpactModel = new ImpactModel ();
		$PriorityModel = new PriorityModel ();

		$equipment = new App\Entities\EquipmentEntity ();

		$id = $this->request->getPost ( 'id' );
		$data = array (
				'problems_tital' => $this->request->getPost ( 'problems_tital' ),
				'problems_detail' => $this->request->getPost ( 'problems_detail' ),
				'problems_status' => $this->request->getPost ( 'problems_status' ),
				'equipment_id' => $this->request->getPost ( 'equipment_id' ),
				'contact_id' => $this->request->getPost ( 'contact_id' ),
				'impact_id' => $this->request->getPost ( 'impact_id' ),
				'priority_id' => $this->request->getPost ( 'priority_id' )
		);
	}
	public function Report() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$ProblemsModel = new ProblemsModel ();
		$pb = new App\Entities\ProblemsEntity ();

		if (empty ( $ProblemsModel->get_max () )) {

			$data ['content'] = view ( 'problems/report_problems_message', [
					'validation' => $validation,
					'start_time' => null,
					'end_time' => null,
					'error' => "ข้อมูลProblems ว่างเปล่า"
			] );

			return view ( 'welcome_message', $data );
		}

		foreach ( $ProblemsModel->get_max () as $key ) {

			$max = $key->id;
		}

			$min = 0;


		$elements_per_page = $max;
		$problems = $ProblemsModel->get_all_problems ( $elements_per_page, 0 );

		if ($this->request->getMethod ( true ) == "POST") {

			$start_time = $this->request->getPost ( 'start_time' );
			$end_time = $this->request->getPost ( 'end_time' );

			$new_start_time = date ( "Y/m/d H:i:s", strtotime ( $start_time ) );
			// $create_at = date("Y/m/d H:i:s", strtotime($request[0]->created_at));
			$new_end_time = date ( "Y/m/d H:i:s", strtotime ( $end_time ) );

			// echo "$new_start_time</br>";
			// // echo "$create_at</br>";
			// echo "$new_end_time</br>";

			// echo "$min</br>";
			// echo "$max</br>";

			for($i = $min; $i <= $max; $i ++) {

				if (! empty ( $problems [$i] )) {
					$create_at [$i] = date ( "Y/m/d H:i:s", strtotime ( $problems [$i]->created_at ) );

					if (! empty ( $problems [$i]->created_at )) {

						if ($create_at [$i] > $new_start_time && $create_at [$i] < $new_end_time) {
							// if($create_at < $new_start_time || $create_at > $new_end_time){
							//
							// continue;
							//
							// }
							$temp [$i] = $problems [$i];
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

					if (! empty ( $temp [$i]->problems_status )) {
						if ($temp [$i]->problems_status == 1) {
							$cancel ++;
						}
						if ($temp [$i]->problems_status == 2) {
							$access ++;
						}
						if ($temp [$i]->problems_status == 3) {
							$comfirm ++;
						}
						if ($temp [$i]->problems_status == 4) {
							$workaround ++;
						}
					}
				}

				// echo $not_success;

				$data ['content'] = view ( 'problems/report_problems_message', [
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

				$data ['content'] = view ( 'problems/report_problems_message', [
						'validation' => $validation,
						'start_time' => $start_time,
						'end_time' => $end_time,
						'error' => "ไม่พบข้อมูลที่ต้องการ"
				] );

				return view ( 'welcome_message', $data );
			}
		}

		$data ['content'] = view ( 'problems/report_problems_message', [
				'validation' => $validation,
				'start_time' => null,
				'end_time' => null



		] );

		return view ( 'welcome_message', $data );

	}
}
