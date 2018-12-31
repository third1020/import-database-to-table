<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\UserEntity;

class UserModel extends Model {
	protected $table = 'user';
	protected $primaryKey = 'id';
	protected $allowedFields = [ 
			'remark',
			'username',
			'password',
			'permission_id',
			'created_at',
			'updated_at',
			'name',
			'id_card',
			'phone_number',
			'email',
			'img'
	];
	protected $searchField = [ 
			'id',
			'username',
			'phone_number',
			'id_card',
			'email'
	];
	protected $returnType = 'App\Entities\UserEntity';
	protected $useTimestamps = true;
	protected $validationRules = [ ];
	protected $validationMessages = [ ];
	protected $skipValidation = false;
	public function __construct() {
		parent::__construct ();
		$db = \Config\Database::connect ();
	}
	public function login($username) {
		$user = $this->where ( [ 
				'username' => $username
		] )->first ();

		return $user;
	}
	public function get_all_user($limit, $offset) {
		$rows = $this->table ( $this->table )->limit ( $limit )->offset ( $offset )->get ();
		// $user = $rows->getResult('App\Entities\User');
		$user = $rows->getResult ();

		return $user;
	}
	public function get_user($limit, $offset, $value) {
		$rows = $this->table ( $this->table );

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
	public function show($id) {
		$query = $this->db->table ( $this->table )->where ( "id", $id );

		return $query->getResult ();
	}
	public function user_add($data) {
		$query = $this->db->table ( $this->table )->insert ( $data );

		return $this->db->insertID ();
	}
	public function delete_by_id($id) {
		$this->db->table ( $this->table )->delete ( array (
				'id' => $id
		) );
	}
	public function user_update($id, $password, $name, $id_card, $phone_number, $email, $permission_id, $image) {
		$user = [ 
				'name' => $name,
				'id_card' => $id_card,
				'phone_number' => $phone_number,
				'email' => $email,
				'updated_at' => date ( 'Y-m-d H:i:s' )
		];
		
		if (! empty ( $permission_id )) {
			$user ['permission_id'] = $permission_id;
		}

		if (! empty ( $password )) {
			$user ['password'] = $password;
		}

		if (! empty ( $image )) {
			$user ['img'] = $image;
		}
		return $this->update ( $id, $user );
	}
	public function hashPassword($password) {
		$hash = password_hash ( $password, PASSWORD_BCRYPT, [ 
				"cost=>8"
		] );

		return $hash;
	}
	public function user_insert($username, $password, $name, $id_card, $phone_number, $email, $permission_id) {
		$user = new UserEntity ();

		$user->setUsername ( $username );
		$user->setPassword ( $password );
		$user->setName ( $name );
		$user->setId_card ( $id_card );
		$user->setPhone_number ( $phone_number );
		$user->setEmail ( $email );
		$user->setPermission_id ( $permission_id );
		$user->setremark ( "" );
		$user->setCreated_at ( date ( 'Y-m-d H:i:s' ) );
		$user->setUpdated_at ( date ( 'Y-m-d H:i:s' ) );

		$this->insert ( $user );
	}
	public function getUserByUsername($username) {
		$query = $this->db->table ( $this->table )->where ( "username", $username );
		
		return $query->get ()->getCustomRowObject ( 0, $this->returnType);
	}
	
}
