<?php
namespace App\Models;

use CodeIgniter\Model;

class PriorityModel extends Model
{
	protected $table = 'priority';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'remark',
		'priority_name',
		'priority_status',
		'created_by',
		'created_at',
		'updated_at'

	];
	protected $searchField = [
			'priority_name',
			'priority_status'


	];
	protected $returnType = 'App\Entities\PriorityEntity';
	protected $useTimestamps = true;


	public function __construct()
	{
		parent::__construct();
		// $this->load->database();
		$db = \Config\Database::connect();
		$priority = $db->table('priority');
	}

	public function login($username, $password)
	{
		$priority = $this->where([
			'username' => $username,
			'password' => $password
		])->first();

		return $priority;
	}

	public function get_all_priority($limit, $offset)
	{
		$rows = $this->table($this->table)->limit($limit)->offset($offset)->get();
// 		$priority = $rows->getResult('App\Entities\priority');
		$priority = $rows->getResult();

		return $priority;
	}

	public function get_priority($limit, $offset, $value)
	{
		$rows = $this->table($this->table);



		if(!is_null($value)) {
			foreach ($this->searchField as $field) {
				$rows = $rows->orLike($field ,$value);
			}
		}

		$rows = $rows->limit($limit)->offset($offset);

		$rows = $rows->get();
		// 		$priority = $rows->getResult('App\Entities\priority');
		$priority = $rows->getResult();

		return $priority;
	}

	public function show($id)
	{
		$query = $this->db->where("id", $id);

		return $query->getResult();
	}

	public function priority_add($data)
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

	public function priority_update($id)
	{
		return $this->db->where('id', $id)->update('priority', $data);
	}

	public function hashPassword($password)
	{
		$hash = password_hash($password, PASSWORD_BCRYPT, [
			"cost=>8"
		]);

		return $hash;
	}






}
