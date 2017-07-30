<?php

namespace everydayDrinking\BDD\DAO;

use everydayDrinking\BDD\Entity\Comment;

use Doctrine\DBAL\Connection;

class CommentDAO
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
		$sql = "SELECT * FROM comment";
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
		$sql = "SELECT * FROM comment WHERE id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row) {
			return $this->buildDomainObjects($row);
		} else {
			throw new \Exception("No comment matching id ".$id);
		}
	}

	public function save(Establishment $comment)
	{
		$commentData = array(
			'user' => $establishment->getName(),
			'comment' => $establishment->getLocation(),
            'score' => $establishment->getLocation(),
            'establishment' => $establishment->getLocation()

		);

		// TODO CHECK
		if ($comment->getId()) {
			$this->getDb()->update('comment', $commentData, array('id' => $comment->getId()));
		} else {
			$this->getDb()->insert('comment', $commentData);
			$id = $this->getDb()->lastInsertId();
			$comment->setId($id);
		}
	}

	public function delete($id)
	{
		$this->getDb()->delete('comment', array('id' => $id));
	}

	protected function buildDomainObjects($row)
	{
		$comment = new Comment();
		$comment->setId($row['id']);
		$comment->setName($row['name']);
		$comment->setComment($row['comment']);
        $comment->setScore($row['score']);
        $comment->setEstablishment($row['establishment_id']);

		return $comment;
	}
}