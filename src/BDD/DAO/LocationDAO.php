<?php

namespace everydayDrinking\BDD\DAO;

use everydayDrinking\BDD\Entity\Location;

use Doctrine\DBAL\Connection;

class LocationDAO
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
		$sql = "SELECT * FROM location";
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
		$sql = "SELECT * FROM location WHERE id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row) {
			return $this->buildDomainObjects($row);
		} else {
			throw new \Exception("No location matching id ".$id);
		}
	}

	public function save(Location $location)
	{
		$locationData = array(
			'longitude' => $location->getLongitude(),
			'latitude' => $location->getLatitude()
		);

		// TODO CHECK
		if ($location->getId()) {
			$this->getDb()->update('location', $locationData, array('id' => $location->getId()));
		} else {
			$this->getDb()->insert('location', $locationData);
			$id = $this->getDb()->lastInsertId();
			$location->setId($id);
		}
	}

	public function delete($id)
	{
		$this->getDb()->delete('location', array('id' => $id));
	}

	protected function buildDomainObjects($row)
	{
		$location = new Location();
		$location->setId($row['id']);
		$location->setLongitude($row['longitude']);
		$location->setLatitude($row['latitude']);

		return $location;
	}
}