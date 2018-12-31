<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\impactModel;
use App\Models\EquipmentModel;


class impact extends Controller {
	protected $helpers = [
			'url',
			'form'
	];
	private $validationRules = [    'impact_name'  =>       [ 'label' => 'Name'          ,'rules' => 'required'],
                                  'impact_value' =>       [ 'label' => 'Value'  ,'rules' => 'required']

														 ];


  private $validationRulesOnUpdate = [    'impact_name'  =>       [ 'label' => 'Name'          ,'rules' => 'required'],
                                          'impact_value' =>       [ 'label' => 'Value'  ,'rules' => 'required']

														         ];



	public function __construct() {
	}
	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		// printf($this->request->getDefaultLocale()) ;

		$data ['content'] = lang ( 'content.impact_view', [
				3
		] );
		return view ( 'impact/list_impact_message', $data );
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
				$data ['content'] = view ( 'impact/success_impact_message' );
			}
		}
		$impactModel = new impactModel ();

		$elements_per_page = 5;
		$impact = $impactModel->get_all_impact ( $elements_per_page, 0 );
		$rows = $impactModel->countAllResults ( 'impact' );
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
		$query_limit = $impactModel->get ( $elements_per_page, $start_element )->getResult ();

		$data ['content'] = view ( 'impact/list_impact_message', [
				'validation' => $validation,
				'impact' => $impact,
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
		$impactModel = new impactModel();


		$data = array (
				'impact_name' => $this->request->getPost ( 'impact_name' ),
        'impact_value' => $this->request->getPost ( 'impact_value' )

		);

     $data ['nav'] = view ( 'nav_message' );

		if ($this->request->getMethod ( true ) == "POST") {


			$validation->setRules ($this->validationRules);

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {


        $impactModel->insert($data);

				$data ['content'] = view ( 'impact/success_impact_message',[
					'message' => "inserted data successfully"
					] );


				return view ( 'welcome_message', $data );

		} else  {
			$data['content'] = view('impact/add_impact_message', [
			'errors' => $validation->getErrors()


			]);

			return view("welcome_message",$data);

			}
		}

		$data ['content'] = view ( 'impact/add_impact_message', [
				'validation' => $validation
		] );

		return view ( 'welcome_message', $data );
	}
	public function AddProcess() {
		$validation = \Config\Services::validation ();

		$data ['nav'] = view ( 'nav_message' );
		$equipmentID = $this->request->getPost ( 'equipment_id' );

		$impactModel = new impactModel ();
		$EquipmentModel = new EquipmentModel();
		$equipment = new App\Entities\EquipmentEntity ();

		$equipmentName = $EquipmentModel->find ( $equipmentID )->getEquipment_name ();

		if (! $this->request->isSecure ()) {

			if ($impactModel->insert($data) === false) //error
			{


			$data['content'] = view('impact/add_impact_message', [
			'errors' => $impactModel->errors(),
			'nav' => view('nav_message'),
			'equipment' => $EquipmentModel->findAll()
			]);

			return view("welcome_message",$data);


			}

			$data = array (
        'impact_name' => $this->request->getPost ( 'impact_name' ),
        'impact_phone' => $this->request->getPost ( 'impact_phone' ),
				'impact_email' => $this->request->getPost ( 'impact_email' ),
				'impact_address' => $this->request->getPost ( 'impact_address' ),
        'impact_detail' => $this->request->getPost ( 'impact_detail' )
			);

			//

			// if($RequestModel->save($data) == null){
			$data ['content'] = view ( 'impact/preview_impact_message', [
					'nav' => view ( 'nav_message' ),
					'confirm' => $data
			] );
			return view ( "welcome_message", $data );

			if ($impactModel->insert ( $data )->protect ( false )) // error
			{

				$data ['content'] = view ( 'impact/add_impact_message', [
						'errors' => $impactModel->errors (),
						'nav' => view ( 'nav_message' ),
						'equipment' => $EquipmentModel->findAll ()
				] );

				return view ( "welcome_message", $data );
			}

			// }
		}
	}
	public function AddProcessPreview() {
		$impactModel = new impactModel ();
		$equipmentModel = new EquipmentModel ();



		$data = array (
      'impact_name' => $this->request->getPost ( 'impact_name' ),
      'impact_phone' => $this->request->getPost ( 'impact_phone' ),
      'impact_email' => $this->request->getPost ( 'impact_email' ),
      'impact_address' => $this->request->getPost ( 'impact_address' ),
      'impact_detail' => $this->request->getPost ( 'impact_detail' )
		);

		if($RequestModel->errors() == true) {
			$data ['content'] = view ( 'impact/success_impact_message', [
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
			$impact = new impactModel ();
			$impact->where ( 'id', $id );
			$impact->delete ();
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

			$impact = new App\Entities\impactEntity ();
			$impactModel = new impactModel ();
			$impact = $impactModel->get_impact ( $elements_per_page, $elements_start, $search_value );

			$recordsTotal = $impactModel->countAllResults ( 'impact' );

			// $search_regex = $this->request->getVar('search[regex]');
			// $columns = $this->request->getVar('columns');

			// $order_column = $this->request->getVar('order[0][column]');
			// $order_dir = $this->request->getVar('order[0][dir]');

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $impact;

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
	// 	$impactModel = new impactModel ();
	// 	$impact = $impactModel->find ( $id );
	//
	// 	$data ['content'] = view ( 'impact/update_impact_message', [
	// 			'validation' => $validation,
	// 			'impact' => $impact
	// 	] );
	//
	// 	return view ( 'welcome_message', $data );
	// }
	public function updateForm($id = null) {
		if ($id != null || $id != '') {
			$impactModel = new impactModel ();

      $impact = $impactModel->find($id);

      $data = [
        'impact' => $impact
              ];


			return view ( 'impact/update_impact_message',$data);
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function deleteForm($id = null) {
		if ($id != null || $id != '') {
			$impactModel = new impactModel ();

			$impact = $impactModel->find([$id]);

			$data =[
				      'impact'=> $impact
			];


			return view ( 'impact/view_impact_message',$data);
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function UpdateProcess() {
		if (! $this->request->isSecure()) {


				$impactModel = new impactModel();
				$validation = \Config\Services::validation();


				$id = $this->request->getPost('id');

				$data = array(
          'impact_name' => $this->request->getPost ( 'impact_name' ),
          'impact_value' => $this->request->getPost ( 'impact_value' ),



				);

				if ($this->request->getMethod(true) == "POST") {

          $validation->setRules ($this->validationRulesOnUpdate);

          $validation->withRequest ( $this->request )->run ();

          if ($validation->getErrors () == null) {

					$impactModel->update($id,$data);

					return view('impact/success_update_impact_message', [
							 'message' => "update data successfully"
										 ]);
										 return view("welcome_message",$data);
				} else {

					$impact = $impactModel->find($id);

					$data = [
							'impact'=> $impact,
							'errors' => $validation->getErrors()



					];

					return view('impact/update_impact_message', $data);

			  }
		  }
	  }
  }
}
