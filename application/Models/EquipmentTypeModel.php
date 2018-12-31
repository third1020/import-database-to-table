<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\EquipmentTypeEntity;

class EquipmentTypeModel extends Model
{
	protected $table = 'equipment_type';
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
	protected $returnType = 'App\Entities\EquipmentTypeEntity';
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

	public function insertEquipmentType($type_name) {
		$equipment_type = new EquipmentTypeEntity();

		$equipment_type->setType_name($type_name);
		$equipment_type->setCreated_at(date('Y-m-d H:i:s'));
		$equipment_type->setUpdated_at(date('Y-m-d H:i:s'));
		$equipment_type->setCreated_by("");
		$equipment_type->setRemark("");

		return $this->insert($equipment_type);
	}

	public function get_equipment_type($limit, $offset, $value) {
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

	public function updateEquipmentType($id, $type_name) {
		$equipment_type = [
				'type_name' => $type_name,
				'updated_at' => date ( 'Y-m-d H:i:s' )
		];

		return $this->update ( $id, $equipment_type );
	}

}
