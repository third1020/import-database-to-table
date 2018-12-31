<?php
namespace App\Models;

use CodeIgniter\Model;

class ProblemsModel extends Model
{
	protected $table = 'problems';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'remark',
		'problems_tital',
		'problems_detail',
		'problems_status',
		'equipment_id',
		'contact_id',
		'impact_id',
		'priority_id',
	    'accept_id',
		'created_by',
		'created_at',
		'updated_at'
	];
	protected $searchField = [
			'problems_tital',
			'problems_detail',
			'problems_status',
			'equipment_name'

	];
	protected $returnType = 'App\Entities\ProblemsEntity';
	protected $useTimestamps = true;


	public function __construct()
	{
		parent::__construct();
		// $this->load->database();
		$db = \Config\Database::connect();
		$problems = $db->table('problems');
	}

	public function login($username, $password)
	{
		$problems = $this->where([
			'username' => $username,
			'password' => $password
		])->first();

		return $problems;
	}

	public function get_all_problems($limit, $offset)
	{
		$rows = $this->table($this->table)->limit($limit)->offset($offset)->get();
// 		$problems = $rows->getResult('App\Entities\problems');
		$problems = $rows->getResult();

		return $problems;
	}

	public function get_problems($limit, $offset, $value)
	{
		$rows = $this->table('problems');
		$this->select('problems.*, equipment.id AS equipment, equipment.equipment_name');

		$this->join('equipment', 'equipment.id = problems.equipment_id');


		if(!is_null($value)) {
			foreach ($this->searchField as $field) {
				$rows = $rows->orLike($field ,$value);
			}
		}

		$rows = $rows->limit($limit)->offset($offset);

		$rows = $rows->get();
		// 		$problems = $rows->getResult('App\Entities\problems');
		$problems = $rows->getResult();

		return $problems;
	}

	public function show($id)
	{
		$query = $this->db->where("id", $id);

		return $query->getResult();
	}

	public function problems_add($data)
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

	public function problems_update($id)
	{
		return $this->db->where('id', $id)->update('problems', $data);
	}

	public function hashPassword($password)
	{
		$hash = password_hash($password, PASSWORD_BCRYPT, [
			"cost=>8"
		]);

		return $hash;
	}

	public function jointable($id,$table1,$table2,$table3,$table4)
	{

		$join = $this->table($this->table);
		        $this->select($this->table.'.*,'.$table1.".id".' AS '.$table1.','.$table1.'.'.$table1.'_name'.','.
																		         $table2.".id".' AS '.$table2.','. $table2.'.'.$table2.'_name'.','.
																	       	   $table3.".id".' AS '.$table3.','. $table3.'.'.$table3.'_name'.','.
																		         $table4.".id".' AS '.$table4.','. $table4.'.'.$table4.'_name');

		        $this->join($table1, $table1.".id".' = '.$this->table.'.'.$table1.'_id');
		        $this->join($table2, $table2.".id".' = '.$this->table.'.'.$table2.'_id');
		        $this->join($table3, $table3.".id".' = '.$this->table.'.'.$table3.'_id');
		        $this->join($table4, $table4.".id".' = '.$this->table.'.'.$table4.'_id');
		        $this->where(array($this->table.".id" => $id));



					             // $ProblemsModel->table('problems');
					             // $ProblemsModel->select('problems.*, equipment.id AS equipment, equipment.equipment_name,
					             //                                 contact.id AS contact, contact.contact_name,
					             //                                 impact.id AS 	impact, impact.impact_name,
					             //                                 priority.id AS priority, priority.priority_name');
											 //
					             // $ProblemsModel->join('equipment', 'equipment.id = problems.equipment_id');
					             // $ProblemsModel->join('contact', 'contact.id = problems.contact_id');
					             // $ProblemsModel->join('impact', 'impact.id = problems.impact_id');
					             // $ProblemsModel->join('priority', 'priority.id = problems.priority_id');
					             // $ProblemsModel->where(array('problems.id' => $id));



		 return 	$join;

	}

	public function get_max()
	{
		$query = $this->query("SELECT id FROM problems ORDER BY id DESC LIMIT 0,1;");

		return $query->getResult();


	}

	public function get_min()
	{
		$query = $this->query("SELECT id FROM problems ORDER BY id ASC LIMIT 0,1;");

		return $query->getResult();


	}


}
