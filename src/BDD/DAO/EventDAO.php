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

	public function save(Comment $comment)
	{
		$commentData = array(
			'name' => $comment->getComment(),
            'establishment_id' => $comment->getEstablishment()

		);

		// TODO CHECK
		if ($comment->getId()) {
			$this->getDb()->update('event', $commentData, array('id' => $comment->getId()));
		} else {
			$this->getDb()->insert('event', $commentData);
			$id = $this->getDb()->lastInsertId();
			$comment->setId($id);
		}
	}

	public function delete($id)
	{
		$this->getDb()->delete('event', array('id' => $id));
	}

	protected function buildDomainObjects($row)
	{
		$comment = new Comment();
		$comment->setId($row['id']);
		$comment->setName($row['name']);
        $comment->setEstablishment($row['establishment_id']);

		return $comment;
	}
}