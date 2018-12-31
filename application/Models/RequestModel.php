<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestModel extends Model {
	protected $table = 'request';
	protected $primaryKey = 'id';
	protected $allowedFields = [
			'remark',
			'request_tital',
			'request_detail',
			'request_status',
			'equipment_id',
			'created_by',
			'created_at',
			'updated_at'
	];
	protected $searchField = [
			'request_tital',
			'request_detail',
			'request_status',
			'equipment_name'
	];
	protected $returnType = 'App\Entities\requestEntity';
	protected $useTimestamps = true;
	public function __construct() {
		parent::__construct ();
		// $this->load->database();
		$db = \Config\Database::connect ();
	}
	public function get_all_request($limit, $offset) {
		$rows = $this->table ( $this->table )->limit ( $limit )->offset ( $offset )->get ();
		// $request = $rows->getResult('App\Entities\request');
		$request = $rows->getResult ();

		return $request;
	}

	
	public function get_request($limit, $offset, $value) {
		$rows = $this->table ( 'request' );
		$this->select ( 'request.*, equipment.id AS equipment, equipment.equipment_name' );

		$this->join ( 'equipment', 'equipment.id = request.equipment_id' );

		if (! is_null ( $value )) {
			foreach ( $this->searchField as $field ) {
				$rows = $rows->orLike ( $field, $value );
			}
		}

		$rows = $rows->limit ( $limit )->offset ( $offset );

		$rows = $rows->get ();
		// $request = $rows->getResult('App\Entities\request');
		$request = $rows->getResult ();

		return $request;
	}
	public function show($id) {
		$query = $this->db->where ( "id", $id );

		return $query->getResult ();
	}
	public function request_add($data) {
		$query = $this->db->table ( $this->table )->insert ( $data );

		return $this->db->insertID ();
	}
	public function delete_by_id($id) {
		$this->db->table ( $this->table )->delete ( array (
				'id' => $id
		) );
	}
	public function request_update($id) {
		return $this->db->where ( 'id', $id )->update ( 'Request', $data );
	}
	public function hashPassword($password) {
		$hash = password_hash ( $password, PASSWORD_BCRYPT, [
				"cost=>8"
		] );

		return $hash;
	}
	public function jointable($id, $table1) {
		$join = $this->table ( $this->table );
		$this->select ( $this->table . '.*,' . $table1 . ".id" . ' AS ' . $table1 . ',' . $table1 . '.' . $table1 . '_name' );

		$this->join ( $table1, $table1 . ".id" . ' = ' . $this->table . '.' . $table1 . '_id' );

		$this->where ( array (
				$this->table . ".id" => $id
		) );

		return $join;
	}
	function form_insert($data) {
		$this->insert ( $this->table, $data );
	}
	function updateStatus($id, $status) {
		$this->update($id, ['request_status' => $status]);
	}

	public function get_max()
	{
    $query = $this->query("SELECT id FROM request ORDER BY id DESC LIMIT 0,1;");

		return $query->getResult();


	}

	public function get_min()
	{
    $query = $this->query("SELECT id FROM request ORDER BY id ASC LIMIT 0,1;");

		return $query->getResult();


	}

}
