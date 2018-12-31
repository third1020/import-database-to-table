<?php

namespace App\Models;

use CodeIgniter\Model;

class IncidentWorkaroundModel extends Model {
	protected $table = 'incident_workaround';
	protected $primaryKey = 'id';
	protected $allowedFields = [ 
			'remark',
			'incident_id',
			'wr_id',
			'incident_solutions',
			'action_start',
			'action_end',
			'created_by',
			'created_at',
			'updated_at',
	];
	protected $searchField = [ 
	];
	protected $returnType = 'App\Entities\IncidentWorkaroundEntity';
	protected $useTimestamps = true;
	public function __construct() {
		parent::__construct ();
		// $this->load->database();
		$db = \Config\Database::connect ();
	}
}
