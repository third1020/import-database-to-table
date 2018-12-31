<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\priorityModel;
use App\Models\EquipmentModel;


class priority extends Controller {
	protected $helpers = [
			'url',
			'form'
	];
	private $validationRules = [    'priority_name'  =>       [ 'label' => 'Name'          ,'rules' => 'required'],
                                  'priority_status' =>       [ 'label' => 'Value'  ,'rules' => 'required']

														 ];


  private $validationRulesOnUpdate = [    'priority_name'  =>       [ 'label' => 'Name'          ,'rules' => 'required'],
                                          'priority_status' =>       [ 'label' => 'Value'  ,'rules' => 'required']

														         ];



	public function __construct() {
	}
	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		// printf($this->request->getDefaultLocale()) ;

		$data ['content'] = lang ( 'content.priority_view', [
				3
		] );
		return view ( 'priority/list_priority_message', $data );
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
				$data ['content'] = view ( 'priority/success_priority_message' );
			}
		}
		$priorityModel = new priorityModel ();

		$elements_per_page = 5;
		$priority = $priorityModel->get_all_priority ( $elements_per_page, 0 );
		$rows = $priorityModel->countAllResults ( 'priority' );
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
		$query_limit = $priorityModel->get ( $elements_per_page, $start_element )->getResult ();

		$data ['content'] = view ( 'priority/list_priority_message', [
				'validation' => $validation,
				'priority' => $priority,
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
		$priorityModel = new priorityModel();


		$data = array (
				'priority_name' => $this->request->getPost ( 'priority_name' ),
        'priority_status' => $this->request->getPost ( 'priority_status' )



		);


     $data ['nav'] = view ( 'nav_message' );

		if ($this->request->getMethod ( true ) == "POST") {


			$validation->setRules ($this->validationRules);

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {


        $priorityModel->insert($data);

				$data ['content'] = view ( 'priority/success_priority_message',[
					'message' => "inserted data successfully"
					] );


				return view ( 'welcome_message', $data );

		} else  {
			$data['content'] = view('priority/add_priority_message', [
			'errors' => $validation->getErrors()


			]);

			return view("welcome_message",$data);

			}
		}

		$data ['content'] = view ( 'priority/add_priority_message', [
				'validation' => $validation
		] );

		return view ( 'welcome_message', $data );
	}
	public function AddProcess() {
		$validation = \Config\Services::validation ();

		$data ['nav'] = view ( 'nav_message' );
		$equipmentID = $this->request->getPost ( 'equipment_id' );

		$priorityModel = new priorityModel ();
		$EquipmentModel = new EquipmentModel();
		$equipment = new App\Entities\EquipmentEntity ();

		$equipmentName = $EquipmentModel->find ( $equipmentID )->getEquipment_name ();

		if (! $this->request->isSecure ()) {

			if ($priorityModel->insert($data) === false) //error
			{


			$data['content'] = view('priority/add_priority_message', [
			'errors' => $priorityModel->errors(),
			'nav' => view('nav_message'),
			'equipment' => $EquipmentModel->findAll()
			]);

			return view("welcome_message",$data);


			}

			$data = array (
        'priority_name' => $this->request->getPost ( 'priority_name' ),
        'priority_phone' => $this->request->getPost ( 'priority_phone' ),
				'priority_email' => $this->request->getPost ( 'priority_email' ),
				'priority_address' => $this->request->getPost ( 'priority_address' ),
        'priority_detail' => $this->request->getPost ( 'priority_detail' )
			);

			//

			// if($RequestModel->save($data) == null){
			$data ['content'] = view ( 'priority/preview_priority_message', [
					'nav' => view ( 'nav_message' ),
					'confirm' => $data
			] );
			return view ( "welcome_message", $data );

			if ($priorityModel->insert ( $data )->protect ( false )) // error
			{

				$data ['content'] = view ( 'priority/add_priority_message', [
						'errors' => $priorityModel->errors (),
						'nav' => view ( 'nav_message' ),
						'equipment' => $EquipmentModel->findAll ()
				] );

				return view ( "welcome_message", $data );
			}

			// }
		}
	}
	public function AddProcessPreview() {
		$priorityModel = new priorityModel ();
		$equipmentModel = new EquipmentModel ();



		$data = array (
      'priority_name' => $this->request->getPost ( 'priority_name' ),
      'priority_phone' => $this->request->getPost ( 'priority_phone' ),
      'priority_email' => $this->request->getPost ( 'priority_email' ),
      'priority_address' => $this->request->getPost ( 'priority_address' ),
      'priority_detail' => $this->request->getPost ( 'priority_detail' )
		);

		if($RequestModel->errors() == true) {
			$data ['content'] = view ( 'priority/success_priority_message', [
					'message' => "inserted data successfully",
					'nav' => view ( 'nav_message' )
			] );
			return view ( "welcome_message", $data );
		}


	}
	public function delete() {
		if (! $this->request->isSecure ()) {
			$id = array (
					'id' => $this->request->getPost ( 'id' )
			);
			$priority = new priorityModel ();
			$priority->where ( 'id', $id );
			$priority->delete ();
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

			$priority = new App\Entities\priorityEntity ();
			$priorityModel = new priorityModel ();
			$priority = $priorityModel->get_priority ( $elements_per_page, $elements_start, $search_value );

			$recordsTotal = $priorityModel->countAllResults ( 'priority' );

			// $search_regex = $this->request->getVar('search[regex]');
			// $columns = $this->request->getVar('columns');

			// $order_column = $this->request->getVar('order[0][column]');
			// $order_dir = $this->request->getVar('order[0][dir]');

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $priority;

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
	// public function update() {
	// 	$data = array ();
	// 	$id = array (
	// 			'id' => $this->request->getPost ( 'id' )
	// 	);
	// 	$data ['nav'] = view ( 'nav_message' );
	// 	$data ['content'] = " 5555 ";
	//
	// 	$this->request->isSecure ();
	// 	$validation = \Config\Services::validation ();
	// 	if ($this->request->getMethod ( true ) == "POST") {
	// 		if (! $this->validate ( [ ] )) {
	//
	// 			$validation->withRequest ( $this->request )->run ();
	// 		} else {
	// 			$data ['content'] = view ( 'request/success_request_message' );
	// 		}
	// 	}
	//
	// 	$priorityModel = new priorityModel ();
	// 	$priority = $priorityModel->find ( $id );
	//
	// 	$data ['content'] = view ( 'priority/update_priority_message', [
	// 			'validation' => $validation,
	// 			'priority' => $priority
	// 	] );
	//
	// 	return view ( 'welcome_message', $data );
	// }
	public function updateForm($id = null) {
		if ($id != null || $id != '') {
			$priorityModel = new priorityModel ();

      $priority = $priorityModel->find($id);

      $data = [
        'priority' => $priority
              ];


			return view ( 'priority/update_priority_message',$data);
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function deleteForm($id = null) {
		if ($id != null || $id != '') {
			$priorityModel = new priorityModel ();

			$priority = $priorityModel->find($id);
		

			$data =[
				      'priority'=> $priority
			];


			return view ( 'priority/view_priority_message',$data);
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function UpdateProcess() {
		if (! $this->request->isSecure()) {


				$priorityModel = new priorityModel();
				$validation = \Config\Services::validation();


				$id = $this->request->getPost('id');

				$data = array(
          'priority_name' => $this->request->getPost ( 'priority_name' ),
          'priority_status' => $this->request->getPost ( 'priority_status' ),



				);

				if ($this->request->getMethod(true) == "POST") {

          $validation->setRules ($this->validationRulesOnUpdate);

          $validation->withRequest ( $this->request )->run ();

          if ($validation->getErrors () == null) {

					$priorityModel->update($id,$data);

					return view('priority/success_update_priority_message', [
							 'message' => "update data successfully"
										 ]);
										 return view("welcome_message",$data);
				} else {

					$priority = $priorityModel->find($id);

					$data = [
							'priority'=> $priority,
							'errors' => $validation->getErrors()



					];

					return view('priority/update_priority_message', $data);

			  }
		  }
	  }
  }
}
