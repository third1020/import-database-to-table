<?php

namespace App\Models;

use CodeIgniter\Model;

class ProblemsWorkaroundModel extends Model {
	protected $table = 'problems_workaround';
	protected $primaryKey = 'id';
	protected $allowedFields = [ 
			'remark',
			'problems_id',
			'wr_id',
			'action_start',
			'action_end',
			'created_by',
			'created_at',
			'updated_at',
	];
	protected $searchField = [ 
	];
	protected $returnType = 'App\Entities\ProblemsWorkaroundEntity';
	protected $useTimestamps = true;
	public function __construct() {
		parent::__construct ();
		// $this->load->database();
		$db = \Config\Database::connect ();
	}
}
