<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Controller;
use App;
use App\Models\EquipmentModel;
use App\Models\EquipmentTypeModel;
use App\Models\ImagesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once APPPATH . "../vendor/autoload.php";
class Equipment extends Controller {
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
			'equipment_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'equipment_type' => [
					'label' => 'Type',
					'rules' => 'required'
			],
			'equipment_number' => [
					'label' => 'Number',
					'rules' => 'required'
			],
			'equipment_image' => [

					'uploaded[equipment_image]',
					'mime_in[equipment_image,image/jpg,image/jpeg,image/gif,image/png]',
					'max_size[equipment_image,4096]'
			]
	];
	private $validationRulesOnUpdate = [
			'equipment_name' => [
					'label' => 'Name',
					'rules' => 'required'
			],
			'equipment_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			],
			'equipment_type' => [
					'label' => 'Type',
					'rules' => 'required'
			],
			'equipment_number' => [
					'label' => 'Number',
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
		return view ( 'equipment/list_equipment_message', $data );
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
				$data ['content'] = view ( 'equipment/success_equipment_message' );
			}
		}
		$equipmentModel = new equipmentModel ();

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

		$data ['content'] = view ( 'equipment/list_equipment_message', [
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
		$equipment = new EquipmentModel ();
		$equipmentTypeModel = new EquipmentTypeModel();
		$equipment_type = $equipmentTypeModel->findAll();
		$validation = \Config\Services::validation ();

		$this->request->isSecure ();

		if ($this->request->getMethod ( true ) == "POST") {

			$validation->setRules ( $this->validationRules );

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {

				$imageResize = new ImagesModel ();
				$equipmentimg = $this->request->getFile ( 'equipment_image' );
				$image = base64_encode ( $imageResize->resize ( $equipmentimg, 500 ) );

				$dataEquipment = array (
						'equipment_image' => $image,
						'equipment_name' => $this->request->getPost ( 'equipment_name' ),
						'equipment_detail' => $this->request->getPost ( 'equipment_detail' ),
						'equipment_number' => $this->request->getPost ( 'equipment_number' ),
						'equipment_type' => $this->request->getPost('equipment_type')
				);

				$equipment->insert ( $dataEquipment );

				$data ['content'] = view ( 'equipment/success_equipment_message', [
						'validation' => $validation,
						'message' => "inserted data successfully"
				] );

				return view ( 'welcome_message', $data );
			} else {
				$data ['content'] = view ( 'equipment/add_equipment_message', [
						'validation' => $validation,
						'errors' => $validation->getErrors (),
						'equipment_type'=>$equipment_type
				] );

				return view ( "welcome_message", $data );
			}
		}

		$data ['content'] = view ( 'equipment/add_equipment_message', [
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
			$equipment = new equipmentModel ();
			$equipment->where ( 'id', $id );
			$equipment->delete ();
		}
	}
	public function import() {

		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$equipment = new EquipmentModel ();
		$validation = \Config\Services::validation ();
		$eq = new App\Entities\EquipmentEntity ();



      $equipment_excel = $this->request->getFile('file');

  //readfile excel
      $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = end($arr_file);

    if('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }

    $spreadsheet = $reader->load($_FILES['file']['tmp_name']);

    $sheetData = $spreadsheet->getActiveSheet()->toArray();


     //chack last row excell
		 $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();

    }

    //import to database


    if(!empty($sheetData)){

      for ($i=1; $i < $highestRow; $i++) {
				if(empty($sheetData[$i][1]) || empty($sheetData[$i][2])){
				 continue;

			 }


  $datainsert = [

                    'equipment_name' => $sheetData[$i][1],
                    'equipment_detail'  => $sheetData[$i][2],

          ];

            $equipment->setremark("");
            $equipment->setCreated_at(date('Y-m-d H:i:s'));
            $equipment->setUpdated_at(date('Y-m-d H:i:s'));
            $equipment->insert($datainsert);

      }

			$data ['content'] = view ( 'equipment/list_equipment_message', [
				  'success' => "inserted data excel successfully",
					'validation' => $validation
			] );
			return view ( 'welcome_message', $data );
    }else{
			$data ['content'] = view ( 'equipment/list_equipment_message', [
				  'errors' => "Data invalid",
					'validation' => $validation
			] );
			return view ( 'welcome_message', $data );

		}


}
	public function export() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$equipment = new EquipmentModel ();
		$validation = \Config\Services::validation ();
		$eq = new App\Entities\EquipmentEntity ();

		$equipment = $equipment->findAll();

		$data ['content'] = view ( 'equipment/export_equipment_message', [
        'equipment' =>$equipment,
				'validation' => $validation
		] );

		return view ( 'welcome_message', $data );


		// $equipment_excel = $this->request->getFile ( 'equipment_excel' );
		// // $path = $equipment_excel->getRealpath();
		//
		// foreach ( $equipment->get_max () as $key ) {
		//
		// 	$max = $key->id;
		// 	// code...
		// }
		//
		// foreach ( $equipment->get_min () as $key ) {
		//
		// 	$min = $key->id;
		// 	// code...
		// }
		//
		//
		//
		// $spreadsheet = new Spreadsheet ();
		// $sheet = $spreadsheet->getActiveSheet ();
		//
		// for($i = $min; $i <= $max; $i ++) {
		//
		// 	if (! empty ( $equipment->find ( $i ) )) {
		//
		// 		$name = $equipment->find ( $i )->getEquipment_name ();
		// 		$detail = $equipment->find ( $i )->getEquipment_detail ();
		// 		$create_by = $equipment->find ( $i )->getCreated_by ();
		// 		$create_at = $equipment->find ( $i )->getCreated_at ();
		// 		$update_at = $equipment->find ( $i )->getUpdated_at ();
		//
		// 		$sheet->setCellValue ( 'A1', 'ชื่ออุปกรณ์' )
		// 		->setCellValue ( 'A' . $i, $name )
		// 		->setCellValue ( 'B1', 'รายละเอียด' )
		// 		->setCellValue ( 'B' . $i, $detail )
		// 		->setCellValue ( 'C1', 'สร้างโดย' )
		// 		->setCellValue ( 'C' . $i, $create_by )
		// 		->setCellValue ( 'D1', 'สร้างเมื่อไหร่' )
		// 		->setCellValue ( 'D' . $i, $create_at )
		// 		->setCellValue ( 'E1', 'อัพเดตเมื่อไหร่' )
		// 		->setCellValue ( 'E' . $i, $update_at );
		// 	}
		//
		// 	if (empty ( $equipment->find ( $i ) )) {
		// 		$rowempty = 0;
		// 		$x = 0;
		//
		// 		$x = $x + $i;
		// 		$rowempty = $x;
		//
		// 		break;
		// 	}
		// }

		// $writer = new Xlsx ( $spreadsheet );
		// $writer->save ( 'equipment.xlsx' );

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
			$equipmentModel = new equipmentModel ();
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
				$data ['content'] = view ( 'equipment/success_equipment_message' );
			}
		}

		$equipmentModel = new equipmentModel ();
		$equipment = $equipmentModel->find ( $id );

		$data ['content'] = view ( 'equipment/update_equipment_message', [
				'validation' => $validation,
				'equipment' => $equipment
		] );

		return view ( 'welcome_message', $data );
	}
	public function updateForm($id = null) {
		if ($id != null || $id != '') {

			$equipmentModel = new EquipmentModel ();
			$equipmentTypeModel = new EquipmentTypeModel();
			$equipment_type = $equipmentTypeModel->findAll();

			$equipment = $equipmentModel->find ( $id );

			$data = [
					// 'validation' => $validation,
					'equipment' => $equipment,
					'equipment_type' => $equipment_type
			];

			return view ( 'equipment/update_equipment_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function deleteForm($id = null) {
		if ($id != null || $id != '') {
			$equipmentModel = new equipmentModel ();
			$equipmentModel->table ( 'equipment' );

			$equipmentModel->where ( array (
					'equipment.id' => $id
			) );

			$equipment = $equipmentModel->get ();
			$equipment = $equipment->getResult ();

			$data = [
					// 'validation' => $validation,
					'equipment' => $equipment
			];

			return view ( 'equipment/view_equipment_message', $data );
		}

	}
	public function UpdateProcess() {
		$equipment = new EquipmentModel ();
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

				$imageResize = new ImagesModel ();
				$id = $this->request->getPost ( 'id' );
				$equipmentimg = $this->request->getFile ( 'equipment_image' );

				if (! empty ( $equipmentimg )) {
					$image = base64_encode ( $imageResize->resize ( $equipmentimg, 500 ) );

					$dataEquipment = array (
							'equipment_image' => $image,
							'equipment_name' => $this->request->getPost ( 'equipment_name' ),
							'equipment_detail' => $this->request->getPost ( 'equipment_detail' ),
							'equipment_number' => $this->request->getPost ( 'equipment_number' ),
							'equipment_type' => $this->request->getPost('equipment_type')
					);

					$equipment->update ( $id, $dataEquipment );
				} else if (empty ( $equipmentimg )) {

					$dataEquipment = array (
							'equipment_name' => $this->request->getPost ( 'equipment_name' ),
							'equipment_detail' => $this->request->getPost ( 'equipment_detail' ),
							'equipment_number' => $this->request->getPost ( 'equipment_number' ),
							'equipment_type' => $this->request->getPost('equipment_type')
					);

					$equipment->update ( $id, $dataEquipment );
				}

				return view ( 'equipment/success_update_equipment_message', [
						'validation' => $validation,
						'message' => "update data successfully"
				] );

				return view ( 'welcome_message', $data );

      }else{
      return view('equipment/update_equipment_message', [
      'validation' => $validation,
      'equipment' => $equipment1,
      'errors' => $validation->getErrors(),
			'equipment_type' => $equipment_type
      ]);


       }

     }

    }



}
