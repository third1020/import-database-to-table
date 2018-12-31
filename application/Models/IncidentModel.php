<?php

namespace App\Models;

use CodeIgniter\Model;

class IncidentModel extends Model {
	protected $table = 'incident';
	protected $primaryKey = 'id';
	protected $allowedFields = [
			'remark',
			'incident_tital',
			'incident_detail',
			'incident_status',
			'equipment_id',
			'contact_id',
			'impact_id',
			'priority_id',
			'accept_id',
			'created_by'
	];
	protected $searchField = [
			'incident_tital',
			'incident_detail',
			'incident_status',
			'equipment_name'
	];
	protected $returnType = 'App\Entities\IncidentEntity';
	protected $useTimestamps = true;
// 	protected $validationRules = [
// 			'incident_tital' => 'required|max_length[8]',
// 			'incident_detail' => 'required|max_length[2000]',
// 			'incident_status' => 'required|max_length[11]',
// 			'equipment_id' => 'required',
// 			'contact_id' => 'required',
// 			'impact_id' => 'required',
// 			'priority_id' => 'required',
// 	];
	protected $validationMessages = [ ];
	protected $skipValidation = false;
	public function __construct() {
		parent::__construct ();
		// $this->load->database();
		$db = \Config\Database::connect ();
		$incident = $db->table ( 'incident' );
	}
	public function get_all_incident($limit, $offset) {
		$rows = $this->table ( $this->table )->limit ( $limit )->offset ( $offset )->get ();
		// $incident = $rows->getResult('App\Entities\incident');
		$incident = $rows->getResult ();

		return $incident;
	}
	public function get_incident($limit, $offset, $value) {
		$rows = $this->table ( 'incident' );
		$this->select ( 'incident.*, equipment.id AS equipment, equipment.equipment_name' );

		$this->join ( 'equipment', 'equipment.id = incident.equipment_id' );

		if (! is_null ( $value )) {
			foreach ( $this->searchField as $field ) {
				$rows = $rows->orLike ( $field, $value );
			}
		}

		$rows = $rows->limit ( $limit )->offset ( $offset );

		$rows = $rows->get ();
		// $incident = $rows->getResult('App\Entities\incident');
		$incident = $rows->getResult ();

		return $incident;
	}
	public function show($id) {
		$query = $this->db->where ( "id", $id );

		return $query->getResult ();
	}
	public function incident_add($data) {
		$query = $this->db->table ( $this->table )->insert ( $data );

		return $this->db->insertID ();
	}
	public function delete_by_id($id) {
		$this->db->table ( $this->table )->delete ( array (
				'id' => $id
		) );
	}
	public function incident_update($id) {
		return $this->db->where ( 'id', $id )->update ( $this->table, $data );
	}
	public function jointable($id, $table1, $table2, $table3, $table4, $table5) {
		$join = $this->table ( $this->table );
		$this->select ( $this->table . '.*,' . $table1 . ".id" . ' AS ' . $table1 . ',' . $table1 . '.' . $table1 . '_name' . ',' . $table2 . ".id" . ' AS ' . $table2 . ',' . $table2 . '.' . $table2 . '_name' . ',' . $table3 . ".id" . ' AS ' . $table3 . ',' . $table3 . '.' . $table3 . '_name' . ',' . $table4 . ".id" . ' AS ' . $table4 . ',' . $table4 . '.' . $table4 . '_name' . ',' . $table5 . ".id" . ' AS ' . $table5 . ',' . $table5 . '.' . $table5 . 'name' );

		$this->join ( $table1, $table1 . ".id" . ' = ' . $this->table . '.' . $table1 . '_id' );
		$this->join ( $table2, $table2 . ".id" . ' = ' . $this->table . '.' . $table2 . '_id' );
		$this->join ( $table3, $table3 . ".id" . ' = ' . $this->table . '.' . $table3 . '_id' );
		$this->join ( $table4, $table4 . ".id" . ' = ' . $this->table . '.' . $table4 . '_id' );
		$this->join ( $table5, $table5 . ".id" . ' = ' . $this->table . '.' . $table5 . '_id' );
		$this->where ( array (
				$this->table . ".id" => $id
		) );

		return $join;
	}

	public function get_max()
	{
    $query = $this->query("SELECT id FROM incident ORDER BY id DESC LIMIT 0,1;");

		return $query->getResult();


	}

	public function get_min()
	{
    $query = $this->query("SELECT id FROM incident ORDER BY id ASC LIMIT 0,1;");

		return $query->getResult();


	}
}
