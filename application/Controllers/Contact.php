<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\ContactModel;
use App\Models\EquipmentModel;
use App\Models\UserModel;

class Contact extends Controller {
	protected $helpers = [
			'url',
			'form'
	];
	private $validationRules = [
			'contact_name' => [
					'label' => 'Name',
					'rules' => 'required'
			],
			'contact_phone' => [
					'label' => 'Phone Number',
					'rules' => 'required|integer'
			],
			'contact_email' => [
					'label' => 'Email',
					'rules' => 'required|valid_email'
			],
			'contact_address' => [
					'label' => 'Address',
					'rules' => 'required'
			],
			'contact_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			]
	];
	private $validationRulesOnUpdate = [
			'contact_name' => [
					'label' => 'Name',
					'rules' => 'required|'
			],
			'contact_phone' => [
					'label' => 'Phone Number',
					'rules' => 'required|integer'
			],
			'contact_email' => [
					'label' => 'Email',
					'rules' => 'required|valid_email'
			],
			'contact_address' => [
					'label' => 'Address',
					'rules' => 'required'
			],
			'contact_detail' => [
					'label' => 'Detail',
					'rules' => 'required'
			]
	];
	public function __construct() {
	}
	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		// printf($this->request->getDefaultLocale()) ;

		$data ['content'] = lang ( 'content.contact_view', [
				3
		] );
		return view ( 'contact/list_contact_message', $data );
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
				$data ['content'] = view ( 'contact/success_contact_message' );
			}
		}

		$contactModel = new ContactModel ();

		$elements_per_page = 5;
		$contact = $contactModel->get_all_contact ( $elements_per_page, 0 );
		$rows = $contactModel->countAllResults ( 'contact' );
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
		$query_limit = $contactModel->get ( $elements_per_page, $start_element )->getResult ();

		$data ['content'] = view ( 'contact/list_contact_message', [
				'validation' => $validation,
				'contact' => $contact,
				'rows' => $rows,
				'rows_limit' => $query_limit,
				'number_of_page' => $number_of_page,
				'page' => $page
		] );

		return view ( 'welcome_message', $data );
	}

	public function listProcessing() {
		if ($this->request->getMethod () == 'post') {
			$elements_per_page = $this->request->getVar ( 'length' );
			$elements_start = $this->request->getVar ( 'start' );

			if ($elements_per_page == null || $elements_start == null) {
				return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
			}

			$search_value = $this->request->getVar ( 'search[value]' );

			$contact = new App\Entities\ContactEntity ();
			$contactModel = new ContactModel ();
			$contact = $contactModel->get_contact ( $elements_per_page, $elements_start, $search_value );

			$recordsTotal = $contactModel->countAllResults ( 'contact' );

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $contact;

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
		$contactModel = new ContactModel ();

		$data ['nav'] = view ( 'nav_message' );

		$userModel = new UserModel ();

		if ($this->request->getMethod ( true ) == "POST") {
			$val = array (
					'contact_name' => $this->request->getPost ( 'contact_name' ),
					'contact_phone' => $this->request->getPost ( 'contact_phone' ),
					'contact_email' => $this->request->getPost ( 'contact_email' ),
					'contact_address' => $this->request->getPost ( 'contact_address' ),
					'contact_detail' => $this->request->getPost ( 'contact_detail' )
			);

			if (! empty ( $this->request->getPost ( 'user_id' ) )) {
				$val ['user_id'] = $this->request->getPost ( 'user_id' );
			}

			$validation->setRules ( $this->validationRules );

			$validation->withRequest ( $this->request )->run ();

			if ($validation->getErrors () == null) {

				$contactModel->insert ( $val );

				$data ['content'] = view ( 'contact/success_contact_message', [
						'message' => "inserted data successfully"
				] );

				return view ( 'welcome_message', $data );
			} else {
				$data ['content'] = view ( 'contact/add_contact_message', [
						'errors' => $validation->getErrors (),
						'user' => $userModel->findAll ()
				] );

				return view ( "welcome_message", $data );
			}
		}

		$data ['content'] = view ( 'contact/add_contact_message', [
				'validation' => $validation,
				'user' => $userModel->findAll ()
		] );

		return view ( 'welcome_message', $data );
	}

	public function deleteForm($id = null) {
		if ($id != null || $id != '') {
			$contactModel = new ContactModel ();

			$contact = $contactModel->find ( [
					$id
			] );

			$data = [
					'contact' => $contact
			];

			return view ( 'contact/view_contact_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}

	public function delete() {
		if (! $this->request->isSecure ()) {
			$id = array (
					'id' => $this->request->getPost ( 'id' )
			);
			$contact = new ContactModel ();
			$contact->where ( 'id', $id );
			$contact->delete ();
		}
	}

	public function updateForm($id = null) {
		if ($id != null || $id != '') {
			$contactModel = new ContactModel ();
			$userModel = new UserModel ();
			$contact = $contactModel->find ( [
					$id
			] );

			$data = [
					'contact' => $contact[0],
					'user' => $userModel->findAll ()
			];

			return view ( 'contact/update_contact_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function UpdateProcess() {
		if (! $this->request->isSecure ()) {
			$userModel = new UserModel ();
			$contactModel = new ContactModel ();
			$validation = \Config\Services::validation ();

			$id = $this->request->getPost ( 'id' );

			if ($this->request->getMethod ( true ) == "POST") {
				$val = array (
						'contact_name' => $this->request->getPost ( 'contact_name' ),
						'contact_phone' => $this->request->getPost ( 'contact_phone' ),
						'contact_email' => $this->request->getPost ( 'contact_email' ),
						'contact_address' => $this->request->getPost ( 'contact_address' ),
						'contact_detail' => $this->request->getPost ( 'contact_detail' )
				);

				if (! empty ( $this->request->getPost ( 'user_id' ) )) {
					$val ['user_id'] = $this->request->getPost ( 'user_id' );

					$this->validationRulesOnUpdate['user_id'] = [
							'label' => 'User',
							'rules' => 'required|is_unique[contact.user_id]',
							'errors' => [
									'required' => 'All accounts must have {field} provided'
							]
					];
				}

				$validation->setRules ( $this->validationRulesOnUpdate );

				$validation->withRequest ( $this->request )->run ();

				if ($validation->getErrors () == null) {

					$contactModel->update ( $id, $val );

					return view ( 'contact/success_update_contact_message', [
							'message' => "update data successfully"
					] );
					return view ( "welcome_message", $data );
				} else {

					$contact = $contactModel->find ( [
							$id
					] );

					$data = [
							'contact' => $contact[0],
							'user' => $userModel->findAll (),
							'errors' => $validation->getErrors ()
					];

					return view ( 'contact/update_contact_message', $data );
				}
			}
		}
	}
}
