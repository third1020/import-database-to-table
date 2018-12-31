<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\NewsEntity;
use App\Entities\MessageEntity;

class MessageModel extends Model {
	protected $table = 'message';
	protected $primaryKey = 'id';
	protected $allowedFields = [ 
			'remark',
			'message_title',
			'message_message',
			'message_from',
			'message_to',
			'created_at',
			'updated_at',
			'status'
	];
	protected $searchField = [ 
			'message_title'
	];
	protected $returnType = 'App\Entities\MessageEntity';
	protected $useTimestamps = true;
	protected $validationRules = [ ];
	protected $validationMessages = [ ];
	protected $skipValidation = false;
	public function __construct() {
		parent::__construct ();
		// $this->load->database();
		$db = \Config\Database::connect ();
		$db->table ( $this->table );
	}
	public function insertNewMessage($message_title, $message_message, $message_from, $message_to) {
		$mes = new MessageEntity ();

		$mes->setMessage_title ( $message_title );
		$mes->setMessage_message ( $message_message );
		$mes->setCreated_at ( date ( 'Y-m-d H:i:s' ) );
		$mes->setUpdated_at ( date ( 'Y-m-d H:i:s' ) );
		$mes->setMessage_from ( $message_from );
		$mes->setMessage_to ( $message_to );
		$mes->setStatus ( 0 );
		$mes->setRemark ( "" );

		return $this->insert ( $mes );
	}
	public function get_message($limit, $offset, $value) {
		$rows = $this->table ( $this->table );
		$rows->select ( [ 
				"$this->table.*",
				'user_from.username as username_from',
				'user_to.username as username_to'
		] );
		$rows->join ( 'user as user_from',  "$this->table.message_from = user_from.id" );
		$rows->join ( 'user as user_to',  "$this->table.message_to = user_to.id" );
		
		if (! is_null ( $value )) {
			foreach ( $this->searchField as $field ) {
				$rows = $rows->orLike ( $field, $value );
			}
		}

		$rows->limit ( $limit )->offset ( $offset );
		$rows = $rows->get ();
		$user = $rows->getResult ();

		return $user;
	}
	
	public function get_messageByUser($limit, $offset, $value, $id) {
		$rows = $this->table ( $this->table );
		$rows->select ( [
				"$this->table.*",
				'user_from.username as username_from',
				'user_to.username as username_to'
		] );
		$rows->where('message_to', $id);
		$rows->join ( 'user as user_from',  "$this->table.message_from = user_from.id" );
		$rows->join ( 'user as user_to',  "$this->table.message_to = user_to.id" );
		
		if (! is_null ( $value )) {
			foreach ( $this->searchField as $field ) {
				$rows = $rows->orLike ( $field, $value );
			}
		}
		
		$rows->limit ( $limit )->offset ( $offset );
		$rows = $rows->get ();
		$user = $rows->getResult ();
		
		return $user;
	}
	
	public function updateMessage($id, $message_title, $message_message) {
		$mes = [ 
				'message_title' => $message_title,
				'message_message' => $message_message,
				'updated_at' => date ( 'Y-m-d H:i:s' )
		];

		return $this->update ( $id, $mes );
	}
	public function updateStatus($id, $status) {
		$mes = [ 
				'status' => $status,
				'updated_at' => date ( 'Y-m-d H:i:s' )
		];
		
		return $this->update($id, $mes);
	}
}
