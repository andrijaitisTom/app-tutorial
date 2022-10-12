<?php

namespace OCA\DmsApp\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Agreement extends Entity implements JsonSerializable {
	
	protected $title;
	protected $content;
	protected $userId;
	protected $physical;
	protected $namelt;
	protected $idfile;
	protected $description;
	protected $comments;
	protected $outsourcing;
	protected $it;
	protected $validSince;
	protected $validUntil;
	protected $form;
	protected $firstParty;
	protected $secondParty;
	protected $physicalLocation;
	protected $materiality;
	protected $lastRiskAssessmentDate;
	protected $relation;
	protected $date;
	protected $company;


	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'title' => $this->title,
			'content' => $this->content,
			'physical' => $this->physical,
			'namelt' => $this->namelt,
			'idfile' => $this->idfile,

			'description' => $this->	description,
			'comments' => $this->	comments,
			'outsourcing' => $this->	outsourcing,
			'it' => $this->	it,
			'validSince' => $this->	validSince,
			'validUntil' => $this->	validUntil,
			'form' => $this->	form,
			'firstParty' => $this->	firstParty,
			'secondParty' => $this->	secondParty,
			'physicalLocation' => $this->	physicalLocation,
			'materiality' => $this->	materiality,
			'lastRiskAssessmentDate' => $this->	lastRiskAssessmentDate,
			'relation' => $this->	relation,
			'date' => $this->	date,
			'userId' => $this->	userId,
			'company' => $this-> company,


		];
	}
}
