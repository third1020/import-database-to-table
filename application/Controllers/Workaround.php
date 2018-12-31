<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Entities\WorkaroundEntity;
use App\Models\WorkaroundModel;
use App\Models\WorkaroundRecordModel;
use App\Models\IncidentWorkaroundModel;
use App\Models\ProblemsWorkaroundModel;

class Workaround extends Controller {
	protected $helpers = [
			'url',
			'form',
			'session'
	];
	
	public function __construct() {
	}
	
	public function index() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		
		$data ['content'] = '';
		
		return view ( 'welcome_message', $data );
	}
	
	public function List() {
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$data['content'] =  view('workaround/list_workaround_message');
		
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
			
			$workaround = new WorkaroundEntity();
			$workaroundModel = new WorkaroundModel();
			$workaround = $workaroundModel->get_workaround ( $elements_per_page, $elements_start, $search_value );
			
			$recordsTotal = $workaroundModel->countAllResults ();
			
			$data = array ();
			$data ['draw'] = $this->request->getVar ( 'draw' );
			$data ['recordsTotal'] = $recordsTotal;
			$data ['recordsFiltered'] = $recordsTotal;
			$data ['data'] = $workaround;
			
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
	
	public function ViewForm($id) {
		$validation = \Config\Services::validation ();
		
		try {
			$workaroundModel = new WorkaroundModel();
			$workaround = $workaroundModel->find($id);
		} catch (\Exception $e) {
			$workaround = null;
		}
		
		if(empty($workaround))
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
		
		if ($this->request->getMethod ( true ) == "POST") {
			$validation->setRules ($this->validationsetRulesOnUpdate);
			$validation->withRequest ( $this->request )->run ();
			
			if ($validation->getErrors () == null) {
				try {
				} catch (\Exception $e) {
					return view ( 'news/fail_news_message', [
							'message' => lang ( 'workaround.workaround_update_fail' )
					] );
				}
				
				return view ( 'news/success_news_message', [
						'message' => lang ( 'workaround.workaround_update_success' )
				] );
			}
		}
		
		return view('workaround/view_workaround_message', [
				'workaround' => $workaround,
				'validation' => $validation
		]);
		;
	}
	
	public function DeleteForm($id) {
		$validation = \Config\Services::validation ();
		
		try {
			$workaroundModel = new WorkaroundModel();
			$workaround = $workaroundModel->find($id);
		} catch (\Exception $e) {
			$workaround = null;
		}
		
		if(empty($workaround))
			return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
			
			if ($this->request->getMethod ( true ) == "POST") {
				$validation->setRules ($this->validationsetRulesOnUpdate);
				$validation->withRequest ( $this->request )->run ();
				
				if ($validation->getErrors () == null) {
					try {
					} catch (\Exception $e) {
						return view ( 'news/fail_news_message', [
								'message' => lang ( 'workaround.workaround_update_fail' )
						] );
					}
					
					return view ( 'news/success_news_message', [
							'message' => lang ( 'workaround.workaround_update_success' )
					] );
				}
			}
			
			return view('workaround/delete_workaround_message', [
					'workaround' => $workaround,
					'validation' => $validation
			]);
			;
	}
	
	public function Delete() {
		if (! $this->request->isSecure ()) {
			$id = array (
					'id' => $this->request->getPost ( 'workaround_type_id' )
			);
			
			try {
				$workaroundRecrodModel = new WorkaroundRecordModel();
				$workaroundRecrodModel->where ( 'wr_id', $id );
				$workaroundRecrodModel->delete ();
				
				$incidentWorkaround = new IncidentWorkaroundModel();
				$incidentWorkaround->where ( 'wr_id', $id );
				$incidentWorkaround->delete ();
				
				$problemsWorkaround = new ProblemsWorkaroundModel();
				$problemsWorkaround->where ( 'wr_id', $id );
				$problemsWorkaround->delete ();
				
				$workaroundModel = new WorkaroundModel();
				$workaroundModel->where ( 'id', $id );
				$workaroundModel->delete ();
				
				return view ( 'workaround/success_workaround_message', [
						'message' => lang ( 'workaround.message_success' )
				] );
			} catch ( \Exception $e ) {
				return view ( 'workaround/fail_workaround_message', [
						'message' => lang('workaround.message_fail')
				]);
			}
		}
	}
}
