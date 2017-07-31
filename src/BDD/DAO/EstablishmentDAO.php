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
		$sql = "SELECT * FROM establishment";
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
		$sql = "SELECT * FROM establishment WHERE id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row) {
			return $this->buildDomainObjects($row);
		} else {
			throw new \Exception("No establishment matching id ".$id);
		}
	}

	public function save(Establishment $establishment)
	{
		$$establishmentData = array(
			'name' => $$establishment->getName(),
			'location' => $establishment->getLocation()
		);

		// TODO CHECK
		if ($$establishment->getId()) {
			$this->getDb()->update('establishment', $establishmentData, array('id' => $establishment->getId()));
		} else {
			$this->getDb()->insert('establishment', $establishmentData);
			$id = $this->getDb()->lastInsertId();
			$establishment->setId($id);
		}
	}

	public function delete($id)
	{
		$this->getDb()->delete('establishment', array('id' => $id));
	}

	protected function buildDomainObjects($row)
	{
		$establishment = new Establishment();
		$establishment->setId($row['id']);
		$establishment->setName($row['name']);
		$establishment->setLocation($row['location_id']);

		return $establishment;
	}
}