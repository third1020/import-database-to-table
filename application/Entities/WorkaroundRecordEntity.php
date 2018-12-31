<?php


namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\UserModel;

class WorkaroundRecordEntity extends Entity {
	protected $id;
	protected $remark;
	protected $wr_id;
	protected $wr_detail;
	protected $created_by;
	protected $created_at;
	protected $updated_at;
}
