<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NewsTypeModel;
use App\Models\NewsModel;
use App\Entities\NewsEntity;

class News extends Controller {
	protected $helpers = [
			'url',
			'form'
	];
	
	private $validationsetRules = [
			'nesw_title' => [
					'label' => 'Title',
					'rules' => 'required',
					'errors' => [
							'required' => 'All accounts must have {field} provided'
					]
			],
			'news_detail' => [
					'label' => 'Detail',
					'rules' => 'required',
					'errors' => [
							'required' => 'All accounts must have {field} provided'
					]
			],
			'type_id' => [
					'label' => 'Type name',
					'rules' => 'required',
					'errors' => [
							'required' => 'All accounts must have {field} provided'
					]
			]
	];
	
	private $validationsetRulesOnUpdate = [
			'news_title' => [
					'label' => 'Title',
					'rules' => 'required',
					'errors' => [
							'required' => 'All accounts must have {field} provided'
					]
			],
			'news_detail' => [
					'label' => 'Detail',
					'rules' => 'required',
					'errors' => [
							'required' => 'All accounts must have {field} provided'
					]
			],
			'type_id' => [
					'label' => 'Type name',
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
	
	public function Detail($id)
	{
		$data = array();
		$data['nav'] = view('nav_message');
		
		$newsModel = new NewsModel();
		$news = $newsModel->find($id);
		
		if(!empty($news)) {
			$data['content'] = view('news/view_news_message', [
					'news' => $news
			]);
		}else {
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		}
		
		
		return view('welcome_message', $data);
	}
	
	public function List() {
		$data = array();
		$data['nav'] = view('nav_message');
		
		$data['content'] =  view('news/list_news_message');
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
			
			$news = new NewsEntity();
			$newsModel = new NewsModel();
			$news = $newsModel->get_news ( $elements_per_page, $elements_start, $search_value );
			
			$recordsTotal = $newsModel->countAllResults ();
			
			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $news;
			
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
		
		$newsTypeModel = new NewsTypeModel();
		$news_type = $newsTypeModel->findAll();
		
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ($this->validationsetRules);
			$validation->withRequest ( $this->request )->run ();
			if ($validation->getErrors () == null) {
				$newsModel = new NewsModel();
				$news_title = $this->request->getPost('nesw_title');
				$news_detail = $this->request->getPost('news_detail');
				$news_type_id = $this->request->getPost('type_id');
				
				try {
					$newsModel->insertNews($news_title, $news_detail, $news_type_id);
					
					$data['content'] = view('news_type/result_news_type_message', [
							'result' => lang('news.news_insert_success')
					]);
				} catch (\Exception $e) {
					$data['content'] = view('news_type/result_news_type_message', [
							'result' => lang('news.news_type_insert_fail')
					]);
				}
			}else{
				$data['content'] = view('news/add_news_message', [
						'validation' => $validation,
						'news_type' => $news_type
				]);
			}
		}else{
			$data['content'] = view('news/add_news_message', [
					'validation' => $validation,
					'news_type' => $news_type
			]);
		}
		return view('welcome_message', $data);
	}
	
	public function UpdateForm($id) {
		$validation = \Config\Services::validation ();
		
		try {
			$newsModel = new NewsModel();
			$news = $newsModel->find($id);
		} catch (\Exception $e) {
			$news = null;
		}
		
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ($this->validationsetRulesOnUpdate);
			$validation->withRequest ( $this->request )->run ();
			
			if ($validation->getErrors () == null) {
				$news_title = $this->request->getPost('news_title');
				$news_detail = $this->request->getPost('news_detail');
				$news_type = $this->request->getPost('type_id');
				
				try {
					$newsModel->updateNews($id, $news_title, $news_detail, $news_type);
				} catch (\Exception $e) {
					return view ( 'news/fail_news_message', [
							'message' => lang ( 'news.news_update_fail' )
					] );
				}
				
				return view ( 'news/success_news_message', [
						'message' => lang ( 'news.news_update_success' )
				] );
			}
		}
		
		$newsTypeModel = new NewsTypeModel();
		$newsType = $newsTypeModel->findAll();
		
		return view('news/update_news_message', [
				'news_type' => $newsType,
				'news' => $news,
				'validation' => $validation
		]);
		;
	}
	
	public function DeleteForm($id = null) {
		if ($id != null || $id != '') {
			$newsModel = new NewsModel();
			$news = $newsModel->find ( $id );
			
			$data = [
					'news' => $news
			];
			
			return view ( 'news/delete_news_message', $data );
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
				$newsModel = new NewsModel();
				$newsModel->where ( 'id', $id );
				$newsModel->delete ();
				
				return view ( 'news/success_news_message', [
						'message' => lang ( 'news.message_success' )
				] );
			} catch ( \Exception $e ) {
				return view ( 'news/fail_news_message', [
						'message' => lang('news.message_fail')
				]);
			}
		}
	}
}

?>
