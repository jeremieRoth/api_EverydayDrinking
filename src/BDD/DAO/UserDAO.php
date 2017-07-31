<?php

namespace everydayDrinking\BDD\DAO;

use everydayDrinking\BDD\Entity\Establishment;

use Doctrine\DBAL\Connection;

class EstablishmentDAO
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

	public function save(User $user)
	{
		$userData = array(
			'login' => $user->getName(),
			'passowrd' => $user->getLocation(),
			'user_name' => $user->getLocation()
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
		$user->setName($row['login']);
		$user->setPassword($row['password']);
		$user->setUserName($row['user_name']);

		return $user;
	}
}