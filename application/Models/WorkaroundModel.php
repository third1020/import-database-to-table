<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkaroundModel extends Model {
	protected $table = 'workaround';
	protected $primaryKey = 'id';
	protected $allowedFields = [ 
			'remark',
			'wr_title',
			'wr_detail',
			'created_by',
			'created_at',
			'updated_at',
	];
	protected $searchField = [ 
			'wr_title',
	];
	protected $returnType = 'App\Entities\WorkaroundEntity';
	protected $useTimestamps = true;
	public function __construct() {
		parent::__construct ();
		// $this->load->database();
		$db = \Config\Database::connect ();
	}
	public function get_workaround($limit, $offset, $value) {
		$rows = $this->table ( $this->table );
		$rows->select( "$this->table.*, user.username" );
		$rows->join ( 'user', $this->table.'.created_by = user.id' );
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
}
