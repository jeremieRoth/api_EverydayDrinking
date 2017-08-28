<?php

namespace everydayDrinking\BDD\DAO;

use everydayDrinking\BDD\Entity\Event;

use Doctrine\DBAL\Connection;

class EventDAO
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
		$sql = "SELECT * FROM event";
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
		$sql = "SELECT * FROM event WHERE id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row) {
			return $this->buildDomainObjects($row);
		} else {
			throw new \Exception("No comment matching id ".$id);
		}
	}

	public function save(Event $event)
	{
		$commentData = array(
			'name' => $event->getName(),
            'establishment_id' => $event->getEstablishment()

		);

		// TODO CHECK
		if ($event->getId()) {
			$this->getDb()->update('event', $eventData, array('id' => $event->getId()));
		} else {
			$this->getDb()->insert('event', $eventData);
			$id = $this->getDb()->lastInsertId();
			$event->setId($id);
		}
	}

	public function delete($id)
	{
		$this->getDb()->delete('event', array('id' => $id));
	}

	protected function buildDomainObjects($row)
	{
		$event = new Event();
		$event->setId($row['id']);
		$event->setName($row['name']);
        $event->setEstablishment($row['establishment_id']);

		return $event;
	}
}