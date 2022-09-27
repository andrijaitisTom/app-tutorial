<?php

namespace OCA\DmsApp\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Mbdecision extends Entity implements JsonSerializable {
	

	protected $userId;
	protected $idfile;
	protected $title;
	protected $physicalLocation;
 	protected $dateOfTheDocument;
	protected $validity;
	protected $form;
	protected $documentStatus;
	protected $participants;
	protected $decisionType;
	protected $registrationNumberCdrmbd;
	protected $relation;
	protected $namelt;
	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'idfile' => $this->idfile,
			'title' => $this-> 	title,
			'physicalLocation' => $this->physicalLocation,
			 'dateOfTheDocument' => $this->dateOfTheDocument,
			'validity' => $this->validity,
			'form' => $this->	form,
			'documentStatus' => $this->documentStatus,
			'participants' => $this->participants,
			'decisionType' => $this->decisionType,
			'registrationNumberCdrmbd' => $this->registrationNumberCdrmbd,
			'relation' => $this->relation,
			'namelt' => $this->namelt,
			'userId' => $this->	userId,

		];
	}
}
