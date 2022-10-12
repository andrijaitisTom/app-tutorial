<?php

namespace OCA\DmsApp\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Contract extends Entity implements JsonSerializable {
	

	protected $userId;
	protected $idfile;
protected $name;
protected $title;
protected $registrationNumberContract;
protected $description;
protected $date;
protected $inForceUntil;
protected $counterparties;
protected $corporateOwner;
protected $personalOwner;
protected $it;
protected $outsourcing;
protected $materiality;
protected $lastRiskAssessmentDate;
protected $documentType;
protected $physicalLocation;
protected $comments;
protected $relation;
protected $namelt;
protected $company;


	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'idfile' => $this->idfile,
			'name' => $this->name,
			'title' => $this->title,
			'registrationNumberContract' => $this->registrationNumberContract,
			'description' => $this->description,
			'date' => $this->date,
			'inForceUntil' => $this->inForceUntil,
			'counterparties' => $this->counterparties,
			'corporateOwner' => $this->corporateOwner,
			'personalOwner' => $this->personalOwner,
			'it' => $this->it,
			'outsourcing' => $this->outsourcing,
			'materiality' => $this->materiality,
			'lastRiskAssessmentDate' => $this->lastRiskAssessmentDate,
			'documentType' => $this->documentType,
			'physicalLocation' => $this->physicalLocation,
			'comments' => $this->comments,
			'relation' => $this->relation,
			'namelt' => $this->namelt,
			'userId' => $this->	userId,
			'company' => $this-> company,

		];
	}
}
