<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\UserModel;
use App\Models\PermissionModel;
use App\Models\ImagesModel;
use App\Models\EquipmentTypeModel;
use App\Entities\EquipmentTypeEntity;

class EquipmentType extends Controller {
	protected $helpers = [
			'url',
			'form'
	];

	private $validationsetRules = [
			'type_name' => [
					'label' => 'Type name',
					'rules' => 'required',
					'errors' => [
							'required' => 'All accounts must have {field} provided'
					]
			]
	];

	private $validationsetRulesOnUpdate = [
			'type_name' => [
					'label' => 'Type name',
					'rules' => 'required',
					'errors' => [
							'required' => 'All accounts must have {field} provided'
					]
			],
			'news_type_id' => [
					'label' => 'ID',
					'rules' => 'required',
					'errors' => [
							'required' => 'All accounts must have {field} provided'
					]
			]
	];

	public function index()
	{
		$data = array();
		$data['nav'] = view('nav_message');

		$data['content'] = "";
		return view('welcome_message', $data);
	}

	public function List() {
		$data = array();
		$data['nav'] = view('nav_message');
		$data ['content'] = view ( 'equipment_type/list_equipment_type_message' );
		return view('welcome_message', $data);
	}

	public function ListProcessing() {
		if ($this->request->getMethod () == 'post') {
			$elements_per_page = $this->request->getVar ( 'length' );
			$elements_start = $this->request->getVar ( 'start' );

			if ($elements_per_page == null || $elements_start == null) {
				return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
			}

			$search_value = $this->request->getVar ( 'search[value]' );

			$equipmentType = new EquipmentTypeEntity();
			$equipmentTypeModel = new EquipmentTypeModel();
			$equipmentType = $equipmentTypeModel->get_equipment_type ( $elements_per_page, $elements_start, $search_value );
			$recordsTotal = $equipmentTypeModel->countAllResults ();

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $equipmentType;

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
		$data = array();
		$data['nav'] = view('nav_message');
		$validation = \Config\Services::validation ();
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ($this->validationsetRules);
			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {
				$type_name = $this->request->getPost('type_name');
				$equipmentTypeModel = new EquipmentTypeModel();

				try {
					$equipmentTypeModel->insertEquipmentType($type_name);
				} catch (\Exception $e) {
					$data['content'] = view('equipment_type/result_equipment_type_message', [
							'result' => lang('equipment.equipment_type_insert_fail')
					]);
				}

				$data['content'] = view('equipment_type/result_equipment_type_message', [
						'result' => lang('equipment.equipment_type_insert_success')
				]);

			}else{
				$data['content'] = view('equipment_type/add_equipment_type_message', [
						'validation' => $validation
				]);
			}
		}else {
			$data['content'] = view('equipment_type/add_equipment_type_message', [
					'validation' => $validation
			]);
		}
		return view('welcome_message', $data);
	}

	public function updateForm($id) {
		$validation = \Config\Services::validation ();

		try {
			$equipmentTypeModel = new EquipmentTypeModel();
			$equipmentType = $equipmentTypeModel->find($id);
		} catch (\Exception $e) {
			$equipmentType = null;
		}

		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ($this->validationsetRulesOnUpdate);
			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {
				$type_name = $this->request->getPost('type_name');
				try {
					$equipmentTypeModel->updateEquipmentType($id, $type_name);
				} catch (\Exception $e) {
					return view ( 'equipment_type/fail_equipment_type_message', [
							'message' => lang ( 'equipment.equipment_update_fail' )
					] );
				}

				return view ( 'equipment_type/success_equipment_type_message', [
						'message' => lang ( 'equipment.equipment_update_success' )
				] );
			}
		}

		return view('equipment_type/update_equipment_type_message', [
				'equipmentType' => $equipmentType,
				'validation' => $validation
		]);
		;
	}
}

?>
