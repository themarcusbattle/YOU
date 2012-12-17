<?php

class db_local extends Db {

	// CHUCHES OBJECT
	
	public function getChurches($params = array()) {
		$sql = "
			SELECT 
				churches.*, COUNT(church_users.user_id) AS members, stripe_accts.access_token
			FROM churches
			LEFT JOIN church_users ON church_users.church_id = churches.church_id
			LEFT JOIN stripe_accts ON stripe_accts.church_id = churches.church_id
			GROUP BY
				churches.church_id
		"; 
		$stmt = $this->db->query($sql);
		return $stmt->fetchAll();
	}
	
	public function getChurch($params = array()) {
		$sql = "
			SELECT churches.*, COUNT(church_users.user_id) AS members, stripe_accts.access_token
			FROM churches
			LEFT JOIN church_users ON church_users.church_id = churches.church_id
			LEFT JOIN stripe_accts ON stripe_accts.church_id = churches.church_id
			WHERE churches.church_id = :id
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			'id' => $params['church_id']
		));
		return $stmt->fetch();
	}
	
	public function addChurch($params = array()) {
		$sql = "
			INSERT INTO churches
			(church_token,name,state,city,zip,address,phone_main)
			VALUES (:church_token,:name,:state,:city,:zip,:address,:phone_main)
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			':church_token' => $params['church_token'],
			':name' => $params['name'],
			':state' => $params['state'],
			':city' => $params['city'],
			':zip' => $params['zip'],
			':address' => $params['address'],
			':phone_main' => $params['phone_main']
		));
		
		return $this->db->lastInsertID();
	}
	
	public function updateChurch($params = array()) {
		$sql = "
			UPDATE churches SET
				name = :name,
				state = :state,
				city = :city,
				zip = :zip,
				address = :address,
				phone_main = :phone_main,
				date_modified = NOW()
			WHERE
				church_id = :id
		";
		$stmt = $this->db->prepare($sql);
		$response = $stmt->execute(array(
			':name' => $params['name'],
			':state' => $params['state'],
			':city' => $params['city'],
			':zip' => $params['zip'],
			':address' => $params['address'],
			':phone_main' => $params['phone_main'],
			':id' => $params['church_id']
		));
		
		return $response;
	}
	
	// END CHURCHES OBJECT

	// USERS OBJECT
	
	public function getUsers($params = array()) {
		$sql = "
			SELECT 
				users.*, 
				churches.name AS church, 
				SUM(contributions.amount) AS total_giving,
				church_users.user_type
			FROM users 
			LEFT JOIN church_users ON church_users.user_id = users.user_id
			LEFT JOIN churches ON churches.church_id = church_users.church_id
			LEFT JOIN contributions ON contributions.user_id = users.user_id
			GROUP BY users.user_id
		";
		$stmt = $this->db->query($sql);
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function getUser($params = array()) {
		$sql = "
			SELECT 
				users.*, 
				churches.name AS church,
				churches.church_id,
				church_users.user_type
			FROM users 
			LEFT JOIN church_users ON church_users.user_id = users.user_id
			LEFT JOIN churches ON churches.church_id = church_users.church_id
			WHERE users.user_id = :id
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			'id' => $params['user_id']
		));
		return $stmt->fetch();
	}

	public function addUser($params = array()) {
		$sql = "
			INSERT INTO users
			(user_token,stripe_id,first_name,last_name,email,password,zip)
			VALUES (:user_token,:stripe_id,:first_name,:last_name,:email,:password,:zip)
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			':user_token' => $params['user_token'],
			':stripe_id' => $params['stripe_id'],
			':first_name' => $params['first_name'],
			':last_name' => $params['last_name'],
			':email' => $params['email'],
			':password' => $params['password'],
			':zip' => $params['zip']
		));
		
		if(isset($params['church_id'])) {
			$params['user_id'] = $this->db->lastInsertID();
			return self::addChurchUser($params);
		} else {
			return $this->db->lastInsertID();	
		}
	}
	
	public function addChurchUser($params = array()) {
		$sql = "
			INSERT INTO church_users
			(church_id,user_id)
			VALUES (:church_id,:user_id)
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			':church_id' => $params['church_id'],
			':user_id' => $params['user_id']
		));
		
		return $params['user_id'];
	}
	
	public function updateUser($params = array()) {
		$sql = "
			UPDATE users SET
				first_name = :first_name,
				last_name = :last_name,
				email = :email,
				zip = :zip,
				date_modified = NOW()
			WHERE
				user_id = :id
		";
		$stmt = $this->db->prepare($sql);
		$response = $stmt->execute(array(
			':first_name' => $params['first_name'],
			':last_name' => $params['last_name'],
			':email' => $params['email'],
			':zip' => $params['zip'],
			':id' => $params['user_id']
		));
		
		return $response;
	}
	
	public function updateLast4($params = array()) {
		$sql = "
			UPDATE users SET
				last4 = :last4,
				card_type = :card_type
			WHERE
				stripe_id = :stripe_id
		";
		$stmt = $this->db->prepare($sql);
		$response = $stmt->execute(array(
			'last4' => $params['active_card']['last4'],
			'card_type' => $params['active_card']['type'],
			'stripe_id' => $params['id']
		));
		
		return $response;
	}
	
	// END USERS OBJECT

	// STATES OBJECT
	
	public function getStates($param = array()) {
		$sql = "SELECT * FROM states";
		$stmt = $this->db->query($sql);
		$result = $stmt->fetchAll();
		return $result;
	}
	
	// END STATES OBJECT
	
	// MEDIA OBJECT
	
	public function getAllMedia($params = array()) {
		$sql = "
			SELECT media.*, churches.name AS church, churches.church_id FROM media 
			LEFT JOIN churches ON churches.church_id = media.church_id
		";
		$stmt = $this->db->query($sql);
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function getMedia($params = array()) {
		$sql = "
			SELECT media.*, churches.name AS church, churches.church_id FROM media 
			LEFT JOIN churches ON churches.church_id = media.church_id
			WHERE media_id = :id
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			'id' => $params['media_id']
		));
		return $stmt->fetch();
	}
	
	public function addMedia($params = array()) {
		$sql = "
			INSERT INTO media
			(title,path,thumbnail,media_type,author,church_id,description)
			VALUES (:title,:path,:thumbnail,:media_type,:author,:church_id,:description)
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			':title' => $params['title'],
			':path' => $params['path'],
			':thumbnail' => $params['thumbnail'],
			':media_type' => $params['media_type'],
			':author' => $params['author'],
			':church_id' => $params['church_id'],
			':description' => $params['description']
		));
		
		return $this->db->lastInsertID();
	}
	
	public function updateMedia($params = array()) {
		$sql = "
			UPDATE media SET
				title = :title,
				path = :path,
				description = :description,
				thumbnail = :thumbnail,
				media_type = :media_type,
				author = :author,
				church_id = :church_id,
				date_modified = NOW()
			WHERE
				media_id = :id
		";
		$stmt = $this->db->prepare($sql);
		$response = $stmt->execute(array(
			':title' => $params['title'],
			':path' => $params['path'],
			':description' => $params['description'],
			':thumbnail' => $params['thumbnail'],
			':media_type' => $params['media_type'],
			':author' => $params['author'],
			':church_id' => $params['church_id'],
			':id' => $params['media_id']
		));
		
		return $response;
	}
	
	// END MEDIA OBJECT
	
	// NOTIFICATIONS OBJECT
	
	public function getNotificationTypes($params = array()) {
		$sql = "SELECT * FROM notification_types";
		$stmt = $this->db->query($sql);
		return $stmt->fetchAll();
	}
	
	public function getNotifications($params = array()) {
		$sql = "
			SELECT * FROM notifications
		";
		$stmt = $this->db->query($sql);
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function getNotification($params = array()) {
		$sql = "SELECT * FROM notifications WHERE notification_id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			'id' => $params['notification_id']
		));
		return $stmt->fetch();
	}
	
	// END NOTIFICATIONS OBJECT
	
	// CONTRIBUTIONS OBJECT
	
	public function addContribution($params = array()) {
		$sql = "
			INSERT INTO contributions
			(user_id,church_id,amount,payment_method)
			VALUES (:user_id,:church_id,:amount,:payment_method)
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			':user_id' => $params['user_id'],
			':church_id' => $params['church_id'],
			':amount' => $params['amount'],
			':payment_method' => $params['payment_method']
		));
		
		return $this->db->lastInsertID();
	}
	
	public function getUserContributions($params = array()) {
		$sql = "SELECT * FROM contributions WHERE church_id = :church_id AND user_id = :user_id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			'church_id' => $params['church_id'],
			'user_id' => $params['user_id']
		));
		return $stmt->fetchAll();
	}
	
	// END CONTRIBUTIONS OBJECT
	
	// STRIPE OBJECT 
	
	public function findStripeAcct($params = array()) {
		$sql = "
			SELECT * FROM stripe_accts WHERE church_id = :church_id
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			'church_id' => $params['church_id']
		));
		
		return $stmt->fetch();
	}
	
	public function addStripeAcct($params = array()) {
		
		$sql = "
			INSERT INTO stripe_accts
			(church_id,access_token)
			VALUES (:church_id,:access_token)
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			':church_id' => $params['church_id'],
			':access_token' => $params['access_token']
		));
		
		return $this->db->lastInsertID();
		
	}
	
	// END STRIPE OBJECT
	
	// GROUPS OBJECT
	public function getGroups($params = array()) {
		$sql = "
			SELECT groups.*, churches.name FROM groups
			LEFT JOIN churches ON churches.church_id = groups.church_id
		"; 
		$stmt = $this->db->query($sql);
		return $stmt->fetchAll();
	}
	
	public function getGroup($params = array()) {
		$sql = "
			SELECT *
			FROM groups
			WHERE groups.group_id = :id
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			'id' => $params['group_id']
		));
		return $stmt->fetch();
	}
	
	public function addGroup($params = array()) {
		$sql = "
			INSERT INTO groups
			(label,church_id)
			VALUES (:label,:church_id)
		";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
			':label' => $params['label'],
			':church_id' => $params['church_id']
		));
		
		return $this->db->lastInsertID();
	}
	// END GROUPS OBJECT
}


?>