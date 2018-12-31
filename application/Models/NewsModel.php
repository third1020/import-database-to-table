<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\NewsEntity;

class NewsModel extends Model {
	protected $table = 'news';
	protected $primaryKey = 'id';
	protected $allowedFields = [ 
			'remark',
			'news_title',
			'news_detail',
			'news_type',
			'created_by',
			'created_at',
			'updated_at'
	];
	protected $searchField = [ 
			'news_title'
	];
	protected $returnType = 'App\Entities\NewsEntity';
	protected $useTimestamps = true;
	protected $validationRules = [ ];
	protected $validationMessages = [ ];
	protected $skipValidation = false;
	public function __construct() {
		parent::__construct ();
		// $this->load->database();
		$db = \Config\Database::connect ();
		$db->table ( $this->table );
	}
	public function insertNews($news_title, $news_detail, $news_type) {
		$news = new NewsEntity ();

		$news->setNews_title ( $news_title );
		$news->setNews_detail ( $news_detail );
		$news->setNews_type ( $news_type );
		$news->setCreated_at ( date ( 'Y-m-d H:i:s' ) );
		$news->setUpdated_at ( date ( 'Y-m-d H:i:s' ) );
		$news->setCreated_by ( "" );
		$news->setRemark ( "" );

		return $this->insert ( $news );
	}
	public function get_news($limit, $offset, $value) {
		$rows = $this->table ( $this->table );
		$rows->select( "$this->table.*, news_type.type_name" );
		$rows->join ( 'news_type', $this->table.'.news_type = news_type.id' );
		if (! is_null ( $value )) {
			foreach ( $this->searchField as $field ) {
				$rows = $rows->orLike ( $field, $value );
			}
		}

		$rows->limit ( $limit )->offset ( $offset );
		$rows = $rows->get ();
		$user = $rows->getResult ();

		return $user;
	}
	public function updateNews($id, $news_title, $news_detail, $news_type) {
		$news = [ 
				'news_title' => $news_title,
				'news_detail' => $news_detail,
				'news_type' => $news_type,
				'updated_at' => date ( 'Y-m-d H:i:s' )
		];

		return $this->update($id, $news);
	}
}
