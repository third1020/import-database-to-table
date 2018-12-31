<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\NewsTypeEntity;

class NewsTypeModel extends Model
{
	protected $table = 'news_type';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'remark',
		'type_name',
		'created_by',
		'created_at',
		'updated_at'
	];
	protected $searchField = [
		'type_name'
	];
	protected $returnType = 'App\Entities\NewsTypeEntity';
	protected $useTimestamps = true;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;

	public function __construct()
	{
		parent::__construct();
		// $this->load->database();
		$db = \Config\Database::connect();
		$db->table($this->table);
	}
	
	public function insertNewsType($type_name) {
		$news_type = new NewsTypeEntity();
		
		$news_type->setType_name($type_name);
		$news_type->setCreated_at(date('Y-m-d H:i:s'));
		$news_type->setUpdated_at(date('Y-m-d H:i:s'));
		$news_type->setCreated_by("");
		$news_type->setRemark("");
		
		return $this->insert($news_type);
	}
	
	public function get_news_type($limit, $offset, $value) {
		$rows = $this->table ($this->table);
		
		if (! is_null ( $value )) {
			foreach ( $this->searchField as $field ) {
				$rows = $rows->orLike ( $field, $value );
			}
		}
		
		$rows = $rows->limit ( $limit )->offset ( $offset );
		
		$rows = $rows->get ();
		// $user = $rows->getResult('App\Entities\User');
		$user = $rows->getResult ();
		
		return $user;
	}
	
	public function updateNewsType($id, $type_name) {
		$news_type = [
				'type_name' => $type_name,
				'updated_at' => date ( 'Y-m-d H:i:s' )
		];
		
		return $this->update ( $id, $news_type );
	}

}
