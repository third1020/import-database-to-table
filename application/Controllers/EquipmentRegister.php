<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Controller;
use App;
use App\Models\EquipmentRegisterModel;
use App\Models\EquipmentTypeModel;
use App\Models\ImagesModel;

class EquipmentRegister extends Controller {
	protected $helpers = [
			'url',
			'form',
			'html'
	];
	private $validationRules = [
			'equipment_name' => [
					'label' => 'Name',
					'rules' => 'required'
			],
			'detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'department' => [
					'label' => 'Department',
					'rules' => 'required'
			],
			'username ' => [
					'label' => 'Username',
					'rules' => 'required'
			],
			'history' => [
        'label' => 'History',
        'rules' => 'required'
			]
	];
	private $validationRulesOnUpdate = [
			'equipment_name' => [
					'label' => 'Name',
					'rules' => 'required'
			],
      'detail' => [
          'label' => 'Detail',
          'rules' => 'required'
      ],
      'department' => [
          'label' => 'Department',
          'rules' => 'required'
      ],
      'username ' => [
          'label' => 'Username',
          'rules' => 'required'
      ],
      'history' => [
        'label' => 'History',
        'rules' => 'required'
      ]
	];
	public function __construct() {
	}
	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		// printf($this->request->getDefaultLocale()) ;

		$data ['content'] = lang ( 'content.equipment_view', [
				3
		] );
		return view ( 'equipment_register/list_equipment_register_message', $data );
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
				$data ['content'] = view ( 'equipment_register/success_equipment_register_message' );
			}
		}
		$equipmentModel = new EquipmentRegisterModel ();

		$elements_per_page = 5;
		$equipment = $equipmentModel->get_all_equipment ( $elements_per_page, 0 );
		$rows = $equipmentModel->countAllResults ( 'equipment' );
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
		$query_limit = $equipmentModel->get ( $elements_per_page, $start_element )->getResult ();

		$data ['content'] = view ( 'equipment_register/list_equipment_register_message', [
				'validation' => $validation,
				'equipment' => $equipment,
				'rows' => $rows,
				'rows_limit' => $query_limit,
				'number_of_page' => $number_of_page,
				'page' => $page
		] );

		return view ( 'welcome_message', $data );
	}
	public function Add() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$equipment = new EquipmentRegisterModel ();
		$equipmentTypeModel = new EquipmentTypeModel();
		$equipment_type = $equipmentTypeModel->findAll();
		$validation = \Config\Services::validation ();

		$this->request->isSecure ();

		if ($this->request->getMethod ( true ) == "POST") {

			$validation->setRules ( $this->validationRules );

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {

				$dataEquipment = array (
          'equipment_type' => $this->request->getPost ( 'equipment_type' ),
						'equipment_name' => $this->request->getPost ( 'equipment_name' ),
            'detail' => $this->request->getPost ( 'detail' ),
						'department' => $this->request->getPost ( 'department' ),
						'username' => $this->request->getPost ( 'username' ),
						'history' => $this->request->getPost('history')
				);

				$equipment->insert ( $dataEquipment );

				$data ['content'] = view ( 'equipment_register/success_equipment_register_message', [
						'validation' => $validation,
						'message' => "inserted data successfully"
				] );

				return view ( 'welcome_message', $data );
			} else {
				$data ['content'] = view ( 'equipment_register/add_equipment_register_message', [
						'validation' => $validation,
						'errors' => $validation->getErrors (),
						'equipment_type'=>$equipment_type
				] );

				return view ( "welcome_message", $data );
			}
		}

		$data ['content'] = view ( 'equipment_register/add_equipment_register_message', [
				'validation' => $validation,
				'equipment_type' => $equipment_type
		] );

		return view ( 'welcome_message', $data );
	}
	public function delete() {
		if (! $this->request->isSecure ()) {
			$id = array (
					'id' => $this->request->getPost ( 'id' )
			);
			$equipment = new EquipmentRegisterModel ();
			$equipment->where ( 'id', $id );
			$equipment->delete ();
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

			$equipment = new App\Entities\EquipmentEntity ();
			$equipmentModel = new EquipmentRegisterModel ();
			$equipment = $equipmentModel->get_equipment ( $elements_per_page, $elements_start, $search_value );

			$recordsTotal = $equipmentModel->countAllResults ( 'equipment' );

			// $search_regex = $this->request->getVar('search[regex]');
			// $columns = $this->request->getVar('columns');

			// $order_column = $this->request->getVar('order[0][column]');
			// $order_dir = $this->request->getVar('order[0][dir]');

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $equipment;

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
				$data ['content'] = view ( 'equipment_register/success_equipment_register_message' );
			}
		}

		$equipmentModel = new EquipmentRegisterModel ();
		$equipment = $equipmentModel->find ( $id );

		$data ['content'] = view ( 'equipment_register/update_equipment_register_message', [
				'validation' => $validation,
				'equipment' => $equipment
		] );

		return view ( 'welcome_message', $data );
	}
	public function updateForm($id = null) {
		if ($id != null || $id != '') {

			$equipmentModel = new EquipmentRegisterModel ();
			$equipmentTypeModel = new EquipmentTypeModel();
			$equipment_type = $equipmentTypeModel->findAll();

			$equipment = $equipmentModel->find ( $id );

			$data = [
					// 'validation' => $validation,
					'equipment' => $equipment,
					'equipment_type' => $equipment_type
			];

			return view ( 'equipment_register/update_equipment_register_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function deleteForm($id = null) {
		if ($id != null || $id != '') {
			$equipmentModel = new EquipmentRegisterModel ();
			$equipmentModel->table ( 'equipment_register' );

			$equipmentModel->where ( array (
					'equipment_register.id' => $id
			) );

			$equipment = $equipmentModel->get ();
			$equipment = $equipment->getResult ();

			$data = [
					// 'validation' => $validation,
					'equipment' => $equipment
			];

			return view ( 'equipment_register/view_equipment_register_message', $data );
		}

	}
	public function UpdateProcess() {
		$equipment = new EquipmentRegisterModel ();
		$validation = \Config\Services::validation ();
		$equipmentTypeModel = new EquipmentTypeModel();
		$equipment_type = $equipmentTypeModel->findAll();

		$this->request->isSecure ();

		$id = $this->request->getPost ( 'id' );

		$equipment1 = $equipment->find ( $id );

		if ($this->request->getMethod ( true ) == "POST") {

			$validation->setRules ( $this->validationRulesOnUpdate );

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {

					$dataEquipment = array (
            'equipment_type' => $this->request->getPost ( 'equipment_type' ),
            'equipment_name' => $this->request->getPost ( 'equipment_name' ),
            'detail' => $this->request->getPost ( 'detail' ),
            'department' => $this->request->getPost ( 'department' ),
            'username' => $this->request->getPost ( 'username' ),
            'history' => $this->request->getPost('history')
					);

					$equipment->update ( $id, $dataEquipment );


				return view ( 'equipment_register/success_update_equipment_register_message', [
						'validation' => $validation,
						'message' => "update data successfully"
				] );

				return view ( 'welcome_message', $data );

      }else{
      return view('equipment_register/update_equipment_register_message', [
      'validation' => $validation,
      'equipment' => $equipment1,
      'errors' => $validation->getErrors(),
			'equipment_type' => $equipment_type
      ]);


       }

     }

    }



}
