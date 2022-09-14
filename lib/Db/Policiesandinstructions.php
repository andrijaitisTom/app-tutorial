<?php

namespace OCA\NotesTutorial\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Policiesandinstructions extends Entity implements JsonSerializable {
	

	protected $userId;
	protected $idfile;
	protected $name;
	protected $title;
	protected $typePi;
	protected $approvalDate;
	protected $responsibleUnit;
	protected $validity;
	protected $owner;
	protected $relation;
	protected $namelt;
	protected $area;
	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'idfile' => $this->idfile,
			'name' => $this->			name,
			'title' => $this->			title,
			'typePi' => $this->			typePi,
			'approvalDate' => $this->			approvalDate,
			'responsibleUnit' => $this->			responsibleUnit,
			'validity' => $this->			validity,
			'owner' => $this->			owner,
			'relation' => $this->			relation,
			'namelt' => $this->			namelt,
			'area' => $this->			area,
		];
	}
}
