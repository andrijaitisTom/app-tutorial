<?php

namespace OCA\DmsApp\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Plciesninstrctns extends Entity implements JsonSerializable {
	

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
	protected $company;

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
			'userId' => $this->	userId,
			'company' => $this-> company,

		];
	}
}
