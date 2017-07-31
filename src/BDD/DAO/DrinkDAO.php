<?php

namespace everydayDrinking\BDD\DAO;

use everydayDrinking\BDD\Entity\Establishment;

use Doctrine\DBAL\Connection;

class DrinkDAO
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
		$sql = "SELECT * FROM drink";
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
		$sql = "SELECT * FROM drink WHERE id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row) {
			return $this->buildDomainObjects($row);
		} else {
			throw new \Exception("No drink matching id ".$id);
		}
	}

	public function save(Drink $drink)
	{
		$drinkData = array(
			'name' => $drink->getName(),
			'price' => $drink->getPrice(),
			'establishment' => $drink->getEstablishment()
			
		);

		// TODO CHECK
		if ($drink->getId()) {
			$this->getDb()->update('drink', $drinkData, array('id' => $drink->getId()));
		} else {
			$this->getDb()->insert('drink', $drinkData);
			$id = $this->getDb()->lastInsertId();
			$drink->setId($id);
		}
	}

	public function delete($id)
	{
		$this->getDb()->delete('drink', array('id' => $id));
	}

	protected function buildDomainObjects($row)
	{
		$drink = new Drink();
		$drink->setId($row['id']);
		$drink->setName($row['name']);
		$drink->setPrice($row['price']);
		$drink->setEstablishment($row['establishment_id']);
		

		return $drink;
	}
}