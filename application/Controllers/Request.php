<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\RequestModel;
use App\Models\EquipmentModel;

class request extends Controller {
	protected $temp1 = [ ];
	protected $helpers = [
			'url',
			'form',
			'session'
	];
	private $validationRules = [
			'request_tital' => [
					'label' => 'Tital',
					'rules' => 'required'
			],
			'request_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'request_status' => [
					'label' => 'Status',
					'rules' => 'required'
			],
			'equipment_id' => [
					'label' => 'Equipment ID',
					'rules' => 'required'
			]
	];
	private $validationRulesOnUpdate = [
			'request_tital' => [
					'label' => 'Tital',
					'rules' => 'required'
			],
			'request_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'request_status' => [
					'label' => 'Status',
					'rules' => 'required'
			],
			'equipment_id' => [
					'label' => 'Equipment ID',
					'rules' => 'required'
			]
	];
	public function __construct() {
	}

	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		// printf($this->request->getDefaultLocale()) ;

		$data ['content'] = lang ( 'content.request_view', [
				3
		] );
		return view ( 'request/list_request_message', $data );
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
				$data ['content'] = view ( 'request/success_request_message' );
			}
		}
		$RequestModel = new RequestModel ();

		$elements_per_page = 5;
		$request = $RequestModel->get_all_request ( $elements_per_page, 0 );
		$rows = $RequestModel->countAllResults ( 'request' );
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
		$query_limit = $RequestModel->get ( $elements_per_page, $start_element )->getResult ();

		$data ['content'] = view ( 'request/list_request_message', [
				'validation' => $validation,
				'request' => $request,
				'rows' => $rows,
				'rows_limit' => $query_limit,
				'number_of_page' => $number_of_page,
				'page' => $page
		] );

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

			$request = new App\Entities\RequestEntity ();
			$RequestModel = new RequestModel ();
			$request = $RequestModel->get_request ( $elements_per_page, $elements_start, $search_value );

			$recordsTotal = $RequestModel->countAllResults ( 'request' );

			// $search_regex = $this->request->getVar('search[regex]');
			// $columns = $this->request->getVar('columns');

			// $order_column = $this->request->getVar('order[0][column]');
			// $order_dir = $this->request->getVar('order[0][dir]');

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $request;

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

		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$equipmentModel = new EquipmentModel ();
		$RequestModel = new RequestModel ();

		$data = array (
				'request_tital' => $this->request->getPost ( 'request_tital' ),
				'request_detail' => $this->request->getPost ( 'request_detail' ),
				'request_status' => $this->request->getPost ( 'request_status' ),
				'equipment_id' => $this->request->getPost ( 'equipment_id' )
		);

		$data ['nav'] = view ( 'nav_message' );

		if ($this->request->getMethod ( true ) == "POST") {

			$validation->setRules ( $this->validationRules );

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {

				$RequestModel->insert ( $data );

				$data ['content'] = view ( 'request/success_request_message', [
						'message' => "inserted data successfully"
				] );

				return view ( 'welcome_message', $data );
			} else {

				$data ['content'] = view ( 'request/add_request_message', [
						'errors' => $validation->getErrors (),
						'equipment' => $equipmentModel->findAll ()
				] );

				return view ( "welcome_message", $data );
			}
		}

		$data ['content'] = view ( 'request/add_request_message', [
				'validation' => $validation,
				'equipment' => $equipmentModel->findAll ()
		] );

		return view ( 'welcome_message', $data );
	}
	public function AddProcess() {
		$validation = \Config\Services::validation ();

		$data ['nav'] = view ( 'nav_message' );
		$equipmentID = $this->request->getPost ( 'equipment_id' );

		$RequestModel = new RequestModel ();
		$EquipmentModel = new EquipmentModel ();
		$equipment = new App\Entities\EquipmentEntity ();

		$equipmentName = $EquipmentModel->find ( $equipmentID )->getEquipment_name ();

		if (! $this->request->isSecure ()) {

			if ($RequestModel->insert ( $data ) === false) // error
			{

				$data ['content'] = view ( 'request/add_request_message', [
						'errors' => $RequestModel->errors (),
						'equipment' => $EquipmentModel->findAll ()
				] );

				return view ( "welcome_message", $data );
			}

			$data = array (
					'request_tital' => $this->request->getPost ( 'request_tital' ),
					'request_detail' => $this->request->getPost ( 'request_detail' ),
					'request_status' => $this->request->getPost ( 'request_status' ),
					'equipment_id' => $this->request->getPost ( 'equipment_id' ),
					'equipment_name' => $equipmentName
			);

			//

			// if($RequestModel->save($data) == null){
			$data ['content'] = view ( 'request/preview_request_message', [
					'confirm' => $data
			] );
			return view ( "welcome_message", $data );

			if ($RequestModel->insert ( $data )->protect ( false )) // error
			{

				$data ['content'] = view ( 'request/add_request_message', [
						'errors' => $RequestModel->errors (),
						'equipment' => $EquipmentModel->findAll ()
				] );

				return view ( "welcome_message", $data );
			}

			// }
		}
	}
	public function AddProcessPreview() {
		$RequestModel = new RequestModel ();
		$equipmentModel = new EquipmentModel ();

		$data = array (
				'request_tital' => $this->request->getPost ( 'request_tital' ),
				'request_detail' => $this->request->getPost ( 'request_detail' ),
				'request_status' => $this->request->getPost ( 'request_status' ),
				'equipment_id' => $this->request->getPost ( 'equipment_id' )
		);

		if ($RequestModel->errors () == true) {
			$data ['content'] = view ( 'request/success_request_message', [
					'message' => "inserted data successfully"
			] );
			return view ( "welcome_message", $data );
		}
	}
	public function Update() {
		$data = array ();
		$id = array (
				'id' => $this->request->getPost ( 'id' )
		);
		$data ['nav'] = view ( 'nav_message' );

		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		if ($this->request->getMethod ( true ) == "POST") {
			if (! $this->validate ( [ ] )) {

				$validation->withRequest ( $this->request )->run ();
			} else {
				$data ['content'] = view ( 'request/success_request_message' );
			}
		}

		$RequestModel = new RequestModel ();
		$request = $RequestModel->find ( $id );

		$data ['content'] = view ( 'request/update_request_message', [
				'validation' => $validation,
				'request' => $request
		] );

		return view ( 'welcome_message', $data );
	}
	public function UpdateForm($id = null) {
		if ($id != null || $id != '') {
			$RequestModel = new RequestModel ();
			$EquipmentModel = new EquipmentModel ();

			$RequestModel->jointable ( $id, "equipment" );

			$request = $RequestModel->find ( $id );

			$data = [
					// 'validation' => $validation,
					'request' => $request,
					'equipment_old' => $request,
					'equipment_new' => $EquipmentModel->findAll ()
			];

			return view ( 'request/update_request_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function UpdateProcess() {
		if (! $this->request->isSecure ()) {

			$requestModel = new RequestModel ();
			$EquipmentModel = new EquipmentModel ();
			$request = new App\Entities\RequestEntity ();

			$validation = \Config\Services::validation ();

			$id = $this->request->getPost ( 'id' );

			$data = array (
					'request_tital' => $this->request->getPost ( 'request_tital' ),
					'request_detail' => $this->request->getPost ( 'request_detail' ),
					'request_status' => $this->request->getPost ( 'request_status' ),
					'equipment_id' => $this->request->getPost ( 'equipment_id' )
			);

			if ($this->request->getMethod ( true ) == "POST") {

				$validation->setRules ( $this->validationRulesOnUpdate );

				$validation->withRequest ( $this->request )->run ();

				if ($validation->getErrors () == null) {

					$requestModel->update ( $id, $data );

					return view ( 'request/success_update_request_message', [

							'message' => "update data successfully"
					] );
					return view ( "welcome_message", $data );
				} else {

					$requestModel->jointable ( $id, "equipment" );

					$request = $requestModel->get ();
					$old_data = $request->getResult ();

					$request = $requestModel->find ( $id );

					$data = [
							// 'validation' => $validation,
							'errors' => $validation->getErrors (),
							'request' => $request,

							'equipment_old' => $old_data,
							'equipment_new' => $EquipmentModel->findAll ()
					];

					return view ( 'request/update_request_message', $data );
				}
			}
		}
	}
	public function DeleteForm($id = null) {
		if ($id != null || $id != '') {
			$RequestModel = new RequestModel ();
			$RequestModel->jointable ( $id, "equipment" );

			$request = $RequestModel->get ();
			$request = $request->getResult ();

			$data = [
					// 'validation' => $validation,
					'request' => $request
			];

			return view ( 'request/view_request_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function Delete() {
		if (! $this->request->isSecure ()) {
			$id = array (
					'id' => $this->request->getPost ( 'id' )
			);
			$request = new RequestModel ();
			$request->where ( 'id', $id );
			$request->delete ();
		}
	}
	public function Report() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$this->request->isSecure ();
		$validation = \Config\Services::validation ();
		$RequestModel = new RequestModel ();
		$eq = new App\Entities\RequestEntity ();

		if (empty ( $RequestModel->get_max () )) {

			$data ['content'] = view ( 'request/report_request_message', [
					'validation' => $validation,
					'start_time' => null,
					'end_time' => null,
					'error' => "ข้อมูลRequest ว่างเปล่า"
			] );

			return view ( 'welcome_message', $data );
		}

		foreach ( $RequestModel->get_max () as $key ) {

			$max = $key->id;
		}

			$min = 0;


		$elements_per_page = $max;
		$request = $RequestModel->get_all_request ( $elements_per_page, 0 );

		if ($this->request->getMethod ( true ) == "POST") {

			$start_time = $this->request->getPost ( 'start_time' );
			$end_time = $this->request->getPost ( 'end_time' );

			$new_start_time = date ( "Y/m/d H:i:s", strtotime ( $start_time ) );
			// $create_at = date("Y/m/d H:i:s", strtotime($request[0]->created_at));
			$new_end_time = date ( "Y/m/d H:i:s", strtotime ( $end_time ) );
		
			for($i = $min; $i <= $max; $i ++) {

				if (! empty ( $request [$i] )) {
					$create_at [$i] = date ( "Y/m/d H:i:s", strtotime ( $request [$i]->created_at ) );

					if (! empty ( $request [$i]->created_at )) {

						if ($create_at [$i] > $new_start_time && $create_at [$i] < $new_end_time) {
							// if($create_at < $new_start_time || $create_at > $new_end_time){
							//
							// continue;
							//
							// }
							$temp [$i] = $request [$i];

						}
					}
				}
			}

			if (! empty ( $temp )) {
				$success = 0;
				$not_success = 0;
				$total = 0;

				// check status
				for($i = $min; $i <= $max; $i ++) {
					if (! empty ( $temp [$i] )) {
						$total ++;
					}

					if (! empty ( $temp [$i]->request_status )) {
						if ($temp [$i]->request_status == 1) {
							$success ++;
						}
					}
				}

				$not_success = $total - $success;

				$data ['content'] = view ( 'request/report_request_message', [
						'validation' => $validation,
						'start_time' => $start_time,
						'end_time' => $end_time,
						'success' => $success,
						'not_success' => $not_success
				] );

				return view ( 'welcome_message', $data );
			} elseif (empty ( $temp )) {

				$data ['content'] = view ( 'request/report_request_message', [
						'validation' => $validation,
						'start_time' => $start_time,
						'end_time' => $end_time,
						'error' => "ไม่พบข้อมูลที่ต้องการ"
				] );

				return view ( 'welcome_message', $data );
			}
		}

		$data ['content'] = view ( 'request/report_request_message', [
				'validation' => $validation,
				'start_time' => null,
				'end_time' => null



		] );

		return view ( 'welcome_message', $data );

	}

}
