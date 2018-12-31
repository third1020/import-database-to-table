<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkaroundRecordModel extends Model {
	protected $table = 'workaround_record';
	protected $primaryKey = 'id';
	protected $allowedFields = [ 
			'remark',
			'wr_id',
			'wr_detail',
			'created_by',
			'created_at',
			'updated_at',
	];
	protected $searchField = [ 
	];
	protected $returnType = 'App\Entities\WorkaroundRecordEntity';
	protected $useTimestamps = true;
	public function __construct() {
		parent::__construct ();
		// $this->load->database();
		$db = \Config\Database::connect ();
	}
}
