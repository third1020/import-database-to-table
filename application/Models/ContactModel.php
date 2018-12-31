<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model {
	protected $table = 'contact';
	protected $primaryKey = 'id';
	protected $allowedFields = [ 
			'remark',
			'contact_name',
			'contact_phone',
			'contact_email',
			'contact_address',
			'contact_detail',
			'created_by',
			'created_at',
			'updated_at',
			'user_id'
	];
	protected $searchField = [ 
			'contact_name',
			'contact_phone',
			'contact_email',
			'contact_address',
			'contact_detail'
	];
	protected $returnType = 'App\Entities\ContactEntity';
	protected $useTimestamps = true;
	public function __construct() {
		parent::__construct ();
		// $this->load->database();
		$db = \Config\Database::connect ();
		$contact = $db->table ( 'contact' );
	}
	public function login($username, $password) {
		$contact = $this->where ( [ 
				'username' => $username,
				'password' => $password
		] )->first ();

		return $contact;
	}
	public function get_all_contact($limit, $offset) {
		$rows = $this->table ( $this->table )->limit ( $limit )->offset ( $offset )->get ();
		// $contact = $rows->getResult('App\Entities\contact');
		$contact = $rows->getResult ();

		return $contact;
	}
	public function get_contact($limit, $offset, $value) {
		$rows = $this->table ( $this->table );

		if (! is_null ( $value )) {
			foreach ( $this->searchField as $field ) {
				$rows = $rows->orLike ( $field, $value );
			}
		}

		$rows = $rows->limit ( $limit )->offset ( $offset );

		$rows = $rows->get ();
		// $contact = $rows->getResult('App\Entities\contact');
		$contact = $rows->getResult ();

		return $contact;
	}
	public function show($id) {
		$query = $this->db->where ( "id", $id );

		return $query->getResult ();
	}
	public function contact_add($data) {
		$query = $this->db->table ( $this->table )->insert ( $data );

		return $this->db->insertID ();
	}
	public function delete_by_id($id) {
		$this->db->table ( $this->table )->delete ( array (
				'id' => $id
		) );
	}
	public function contact_update($id) {
		return $this->db->where ( 'id', $id )->update ( 'contact', $data );
	}
	public function hashPassword($password) {
		$hash = password_hash ( $password, PASSWORD_BCRYPT, [ 
				"cost=>8"
		] );

		return $hash;
	}
}
