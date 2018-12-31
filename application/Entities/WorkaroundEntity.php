<?php


namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\UserModel;

class WorkaroundEntity extends Entity {
	protected $id;
	protected $remark;
	protected $wr_title;
	protected $wr_detail;
	protected $created_by;
	protected $created_at;
	protected $updated_at;
}
