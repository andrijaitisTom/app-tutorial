<?php

namespace OCA\DmsApp\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Sntorrcvddoc extends Entity implements JsonSerializable {
	

	protected $userId;
	protected $idfile;
	protected $name;
	protected $title;
	protected $dateReceiptDate;
	protected $sender;
	protected $recipient;
	protected $recipientEmployee;
	protected $documentForm;
	protected $documentType;
	protected $deliveryMethod;
	protected $dateOfTheDocument ;
	protected $physicalLocation;
	protected $registrationNumberTd;
	protected $documentOrganizer;
	protected $direction;
	protected $relation;
	protected $namelt;
	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'idfile' => $this->idfile,
			'name' => $this->name,
			'title' => $this->title,
			'dateReceiptDate' => $this->dateReceiptDate,
			'sender' => $this->sender,
			'recipient' => $this->recipient,
			'recipientEmployee' => $this->recipientEmployee,
			'documentForm' => $this->documentForm,
			'documentType' => $this->documentType,
			'deliveryMethod' => $this->deliveryMethod,
			'dateOfTheDocument' => $this->dateOfTheDocument ,
			'physicalLocation' => $this->physicalLocation,
			'registrationNumberTd' => $this->registrationNumberTd,
			'documentOrganizer' => $this->documentOrganizer,
			'direction' => $this->direction,
			'relation' => $this->relation,
			'namelt' => $this->namelt,
			'userId' => $this->	userId,

		];
	}
}


