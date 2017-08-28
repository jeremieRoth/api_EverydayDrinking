<?php

namespace everydayDrinking\BDD\DAO;

use everydayDrinking\BDD\Entity\User;

use Doctrine\DBAL\Connection;

class UserDAO
{
	private $db;

	public function __construct(Connection $db)
	{
		$this->db = $db;
	}

	protected function getDb()
	{
		return $this->db;
	}

	public function findAll()
	{
		$sql = "SELECT * FROM user";
		$result = $this->getDb()->fetchAll($sql);

		$entities = array();
		foreach ( $result as $row ) {
			$id = $row['id'];
			$entities[$id] = $this->buildDomainObjects($row);
		}

		return $entities;
	}

	public function find($id)
	{
		$sql = "SELECT * FROM user WHERE id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row) {
			return $this->buildDomainObjects($row);
		} else {
			throw new \Exception("No user matching id ".$id);
		}
	}
	public function findByNameAndPassword($login, $password)
	{	
		$sql = "SELECT * FROM user WHERE login=? AND password=?";
		$row = $this->getDb()->fetchAssoc($sql, array($login,$password));

		if ($row) {
			return $this->buildDomainObjects($row);
		} else {
			throw new \Exception("No user matching id ".$login.' : '.$password);
		}
	}

	public function save(User $user)
	{
		$userData = array(
			'login' => $user->getLogin(),
			'password' => $user->getPassword(),
			'user_name' => $user->getUserName()
		);

		// TODO CHECK
		if ($user->getId()) {
			$this->getDb()->update('user', $userData, array('id' => $user->getId()));
		} else {
			$this->getDb()->insert('user', $userData);
			$id = $this->getDb()->lastInsertId();
			$user->setId($id);
		}
	}

	public function delete($id)
	{
		$this->getDb()->delete('user', array('id' => $id));
	}

	protected function buildDomainObjects($row)
	{
		$user = new User();
		$user->setId($row['id']);
		$user->setLogin($row['login']);
		$user->setPassword($row['password']);
		$user->setUserName($row['user_name']);

		return $user;
	}
}