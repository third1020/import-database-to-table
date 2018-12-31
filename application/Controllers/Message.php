<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\MessageModel;
use App\Entities\MessageEntity;

class Message extends Controller {
	protected $helpers = [ 
			'url',
			'form'
	];
	private $validationsetRules = [ 
			'message_title' => [ 
					'label' => 'Title',
					'rules' => 'required',
					'errors' => [ 
							'required' => 'All accounts must have {field} provided'
					]
			],
			'message_message' => [ 
					'label' => 'Detail',
					'rules' => 'required',
					'errors' => [ 
							'required' => 'All accounts must have {field} provided'
					]
			],
			'message_to' => [ 
					'label' => 'Type name',
					'rules' => 'required',
					'errors' => [ 
							'required' => 'All accounts must have {field} provided'
					]
			]
	];
	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );

		$data ['content'] = "";
		return view ( 'welcome_message', $data );
	}
	public function List() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );

		$data ['content'] = view ( 'message/list_message_message' );
		return view ( 'welcome_message', $data );
	}
	public function ListProcessing() {
		if ($this->request->getMethod () == 'post') {
			$elements_per_page = $this->request->getVar ( 'length' );
			$elements_start = $this->request->getVar ( 'start' );

			if ($elements_per_page == null || $elements_start == null) {
				return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
			}

			$search_value = $this->request->getVar ( 'search[value]' );

			$mes = new MessageEntity ();
			$mesModel = new MessageModel ();
			$mes = $mesModel->get_message ( $elements_per_page, $elements_start, $search_value );

			$recordsTotal = $mesModel->countAllResults ();

			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $mes;

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
		$data ['nav'] = view ( 'nav_message' );
		$validation = \Config\Services::validation ();

		$userModel = new UserModel ();
		$user = $userModel->findAll ();

		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ( $this->validationsetRules );
			$validation->withRequest ( $this->request )->run ();
			if ($validation->getErrors () == null) {
				$messageModel = new MessageModel ();
				$message_title = $this->request->getPost ( 'message_title' );
				$message_message = $this->request->getPost ( 'message_message' );
				$message_to = $this->request->getPost ( 'message_to' );
				$message_from = 1;
				try {
					$messageModel->insertNewMessage ( $message_title, $message_message, $message_from, $message_to );

					$data ['content'] = view ( 'message/result_message_message', [ 
							'result' => lang ( 'message.news_insert_success' )
					] );
				} catch ( \Exception $e ) {
					$data ['content'] = view ( 'message/result_message_message', [ 
							'result' => lang ( 'message.news_type_insert_fail' ) . " <br>" . $e
					] );
				}
			} else {
				$data ['content'] = view ( 'message/add_message_message', [ 
						'input' => $this->request->getPost (),
						'user' => $user,
						'validation' => $validation
				] );
			}
		} else {
			$data ['content'] = view ( 'message/add_message_message', [ 
					'input' => $this->request->getPost (),
					'user' => $user,
					'validation' => $validation
			] );
		}

		return view ( 'welcome_message', $data );
	}
	public function viewForm($id = null) {
		if ($id != null || $id != '') {
			$messageModel = new MessageModel ();
			$mes = $messageModel->find ( $id );

			$data = [ 
					'mes' => $mes
			];

			return view ( 'message/view_message_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	
	public function viewDetail($id = null) {
		if ($id != null || $id != '') {
			$messageModel = new MessageModel ();
			$mes = $messageModel->find ( $id );
			
			$data = [
					'mes' => $mes
			];
			
			$data ['nav'] = view ( 'nav_message' );
			
			$data ['content'] = view ( 'message/view_message' , $data);
			return view ( 'welcome_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	
	public function DeleteForm($id = null) {
		if ($id != null || $id != '') {
			$messageModel = new MessageModel ();
			$mes = $messageModel->find ( $id );

			$data = [ 
					'mes' => $mes
			];

			return view ( 'message/delete_message_message', $data );
		} else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
	}
	public function Delete() {
		if (! $this->request->isSecure ()) {
			$id = array (
					'id' => $this->request->getPost ( 'id' )
			);

			try {
				$messageModel = new MessageModel ();
				$messageModel->where ( 'id', $id );
				$messageModel->delete ();

				return view ( 'message/success_message', [ 
						'message' => lang ( 'message.message_success' )
				] );
			} catch ( \Exception $e ) {
				return view ( 'message/fail_message', [
						'message' => lang('message.message_fail')
				]);
			}
		}
	}
	
	public function nav_menu() {
		$session = session();
		$data = [];
		
		$messageModel = new MessageModel();
		$data['message'] =  $messageModel = $messageModel->where('message_to', $session->get('id'))
		->orderBy('id', 'desc')
		->findAll(5, 0);
		
		return view('message/dropdown_message', $data);
		;
	}
}

?>