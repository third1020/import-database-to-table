<?php
namespace App\Models;

use CodeIgniter\Model;

class EquipmentRegisterModel extends Model
{
	protected $table = 'equipment_register';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'remark',
    'equipment_name',
    'equipment_type',
		'username',
		'detail',
		'department',
		'history',
		'created_by',
		'created_at',
		'updated_at'
	];
	protected $searchField = [
    'equipment_name',
		'username',
		'detail',
		'department',
		'history',
		'created_by'
	];
	protected $returnType = 'App\Entities\EquipmentEntity';
	protected $useTimestamps = true;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;

	public function __construct()
	{
		parent::__construct();
		// $this->load->database();
		$db = \Config\Database::connect();
	}

	public function login($username, $password)
	{
		$equipment = $this->where([
			'username' => $username,
			'password' => $password
		])->first();

		return $equipment;
	}

	public function get_all_equipment($limit, $offset)
	{
		$rows = $this->table($this->table)->limit($limit)->offset($offset)->get();
// 		$equipment = $rows->getResult('App\Entities\equipment');
		$equipment = $rows->getResult();

		return $equipment;
	}

	public function get_equipment($limit, $offset, $value)
	{
		$rows = $this->table($this->table);


		if(!is_null($value)) {
			foreach ($this->searchField as $field) {
				$rows = $rows->orLike($field ,$value);
			}
		}

		$rows = $rows->limit($limit)->offset($offset);

		$rows = $rows->get();
		// 		$equipment = $rows->getResult('App\Entities\equipment');
		$equipment = $rows->getResult();

		return $equipment;
	}

	public function show($id)
	{
		$query = $this->where("id", $id);

		return $query->getResult();
	}

	public function equipment_add($data)
	{
		$query = $this->db->table($this->table)->insert($data);

		return $this->db->insertID();
	}

	public function delete_by_id($id)
	{
		$this->db->table($this->table)->delete(array(
			'id' => $id
		));
	}

	public function equipment_update($id)
	{
		return $this->db->where('id', $id)->update('equipment', $data);
	}

	public function hashPassword($password)
	{
		$hash = password_hash($password, PASSWORD_BCRYPT, [
			"cost=>8"
		]);

		return $hash;
	}

	public function get_max()
	{
    $query = $this->query("SELECT id FROM equipment ORDER BY id DESC LIMIT 0,1;");

		return $query->getResult();


	}

	public function get_min()
	{
    $query = $this->query("SELECT id FROM equipment ORDER BY id ASC LIMIT 0,1;");

		return $query->getResult();


	}



	function save_upload($title,$image){
        $data = array(
                'title'     => $title,
                'file_name' => $image
            );
        $result= $this->db->insert('gallery',$data);
        return $result;
    }




}
