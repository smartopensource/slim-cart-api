<?php
namespace App\Lib;

class UserModel extends Model {

	protected $user_id = null;
	protected $user_details = null;

	public function init($user_id) {
		$this->user_id = $user_id;
	}

	public function initWithToken($token) {
        $statement = $this->db->prepare("select id from users where token = :token");
        $result = $statement->execute(['token' => $token]);
        $user_details = $result ? $statement->fetch() : [];

        if(!empty($user_details['id'])) {
            $this->user_id = $user_details['id'];
        }
    }

	public function getDetails() {
		if(!$this->user_details) {
			$user_id = (int)$this->user_id;
			$statement = $this->db->prepare("select name, address from users where id = :user_id");
			$result = $statement->execute(['user_id' => $user_id]);
			$user_details = $result ? $statement->fetch() : [];

			$this->user_details = $user_details;
		}

		return $this->user_details;
	}

}
