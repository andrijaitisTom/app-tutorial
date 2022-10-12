<?php

namespace OCA\DmsApp\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Sbdecision extends Entity implements JsonSerializable {
	

	protected $userId;
	protected $idfile;
	protected $name;
	protected $title;
	protected $dateOfTheDocument;
	protected $physicalLocation;
	protected $validity;
	protected $form;
	protected $documentStatus;
	protected $participants;
	protected $registrationNumberCdrsbd;
	protected $decisionType;
	protected $relation;
	protected $namelt;
	protected $company;

	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'idfile' => $this->idfile,
			'name' => $this->			name,
			'title' => $this->			title,
			'dateOfTheDocument' => $this->			dateOfTheDocument,
			'physicalLocation' => $this->			physicalLocation,
			'validity' => $this->			validity,
			'form' => $this->			form,
			'documentStatus' => $this->			documentStatus,
			'participants' => $this->			participants,
			'registrationNumberCdrsbd' => $this->			registrationNumberCdrsbd,
			'decisionType' => $this->			decisionType,
			'relation' => $this->			relation,
			'namelt' => $this->			namelt,
			'userId' => $this->	userId,
			'company' => $this-> company,

		];
	}
}
