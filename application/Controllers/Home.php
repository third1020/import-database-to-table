<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Entities\UserEntity;
use App\Models\NewsTypeModel;
use App\Entities\MessageEntity;
use App\Models\MessageModel;

class Home extends Controller
{
    protected $helpers = ['url', 'form', 'session'];
    
	public function index()
	{
		$session = session();
		if(!$session->has('username'))  {
			return redirect(site_url('Login'));
		}
		
	    $data = array();
	    $data['nav'] = view('nav_message');
	    
	    $userModel = new UserModel();
	    $user = $userModel->getUserByUsername($session->get('username'));
	    
	    $newsTypeModel = new NewsTypeModel();
	    $newsType = $newsTypeModel->findAll();
	    
	    $data['content'] = view('home/profile_message', [
	    		'user' => $user,
	    		'newsType' => $newsType,
	    ]);
	    
		return view('welcome_message', $data);
	}
	
	public function ListMessage() {
		$session = session();
		if(!$session->has('username'))  {
			return redirect(site_url('Login'));
		}
		
		$data = array ();
		$data ['nav'] = view ( 'nav_message' );
		$data ['content'] = view ( 'home/list_message' );
		
		return view ( 'welcome_message', $data );
	}
	
	public function ListProcessMessage() {
		$session = session();
		if(!$session->has('username'))  {
			return redirect(site_url('Login'));
		}
		
		if ($this->request->getMethod () == 'post') {
			$elements_per_page = $this->request->getVar ( 'length' );
			$elements_start = $this->request->getVar ( 'start' );
			
			if ($elements_per_page == null || $elements_start == null) {
				return $this->response->setStatusCode ( 404 )->setBody ( 'error 404 [invalid parameter]' );
			}
			
			$search_value = $this->request->getVar ( 'search[value]' );
			
			$mes = new MessageEntity();
			$mesModel = new MessageModel();
			$mes = $mesModel->get_messageByUser( 
					$elements_per_page, 
					$elements_start, 
					$search_value,
					$session->get('id'));
			
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

	//--------------------------------------------------------------------

}
