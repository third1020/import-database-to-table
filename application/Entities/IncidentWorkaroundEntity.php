<?php


namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\UserModel;

class IncidentWorkaroundEntity extends Entity {
	protected $id;
	protected $remark;
	protected $incident_id;
	protected $wr_id;
	protected $incident_solutions;
	protected $action_start;
	protected $action_end;
	protected $created_by;
	protected $created_at;
	protected $updated_at;
}
