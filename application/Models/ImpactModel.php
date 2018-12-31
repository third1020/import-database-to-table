<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\ImpactEntity;

class ImpactModel extends Model
{
	protected $table = 'impact';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'remark',
		'impact_name',
		'impact_value',
		'created_by',
		'created_at',
		'updated_at',

	];
	protected $searchField = [
			'impact_name',
			'impact_value'


	];
	protected $returnType = 'App\Entities\ImpactEntity';
	protected $useTimestamps = true;


	public function __construct()
	{
		parent::__construct();
		// $this->load->database();
		$db = \Config\Database::connect();
		$impact = $db->table('impact');
	}

	public function get_all_impact($limit, $offset)
	{
		$rows = $this->table($this->table)->limit($limit)->offset($offset)->get();
// 		$impact = $rows->getResult('App\Entities\impact');
		$impact = $rows->getResult();

		return $impact;
	}

	public function get_impact($limit, $offset, $value)
	{
		$rows = $this->table($this->table);



		if(!is_null($value)) {
			foreach ($this->searchField as $field) {
				$rows = $rows->orLike($field ,$value);
			}
		}

		$rows = $rows->limit($limit)->offset($offset);

		$rows = $rows->get();
		// 		$impact = $rows->getResult('App\Entities\impact');
		$impact = $rows->getResult();

		return $impact;
	}

	public function show($id)
	{
		$query = $this->db->where("id", $id);

		return $query->getResult();
	}

	public function impact_add($data)
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

	public function impact_update($id)
	{
		return $this->db->where('id', $id)->update('impact', $data);
	}

}
