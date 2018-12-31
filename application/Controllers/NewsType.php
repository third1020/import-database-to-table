<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\UserModel;
use App\Models\PermissionModel;
use App\Models\ImagesModel;
use App\Models\NewsTypeModel;
use App\Entities\NewsTypeEntity;

class NewsType extends Controller {
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
		$data ['content'] = view ( 'news_type/list_news_type_message' );
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
			
			$newsType = new NewsTypeEntity();
			$newsTypeModel = new NewsTypeModel();
			$newsType = $newsTypeModel->get_news_type ( $elements_per_page, $elements_start, $search_value );
			$recordsTotal = $newsTypeModel->countAllResults ();
			
			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $newsType;
			
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
				$newsTypeModel = new NewsTypeModel();
				
				try {
					$newsTypeModel->insertNewsType($type_name);
				} catch (\Exception $e) {
					$data['content'] = view('news_type/result_news_type_message', [
							'result' => lang('news.news_type_insert_fail')
					]);
				}
				
				$data['content'] = view('news_type/result_news_type_message', [
						'result' => lang('news.news_type_insert_success')
				]);
				
			}else{
				$data['content'] = view('news_type/add_news_type_message', [
						'validation' => $validation
				]);
			}
		}else {
			$data['content'] = view('news_type/add_news_type_message', [
					'validation' => $validation
			]);
		}
		return view('welcome_message', $data);
	}
	
	public function updateForm($id) {
		$validation = \Config\Services::validation ();
		
		try {
			$newsTypeModel = new NewsTypeModel();
			$newsType = $newsTypeModel->find($id);
		} catch (\Exception $e) {
			$newsType = null;
		}
		
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ($this->validationsetRulesOnUpdate);
			$validation->withRequest ( $this->request )->run ();
			
			if ($validation->getErrors () == null) {
				$type_name = $this->request->getPost('type_name');
				try {
					$newsTypeModel->updateNewsType($id, $type_name);
				} catch (\Exception $e) {
					return view ( 'news_type/fail_news_type_message', [
							'message' => lang ( 'news.news_update_fail' )
					] );
				}
				
				return view ( 'news_type/success_news_type_message', [
						'message' => lang ( 'news.news_update_success' )
				] );
			}
		}
		
		return view('news_type/update_news_type_message', [
				'newsType' => $newsType,
				'validation' => $validation
		]);
		;
	}
}

?>
