<?php

namespace OCA\DmsApp\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\DmsApp\Db\Sbdecision;
use OCA\DmsApp\Db\SbdecisionMapper;

class SbdecisionService {

	/** @var SbdecisionMapper */
	private $mapper;

	public function __construct(SbdecisionMapper $mapper) {
		$this->mapper = $mapper;
	}

	public function findAll(string $userId): array {
		return $this->mapper->findAll($userId);
	}

	private function handleException(Exception $e): void {
		if ($e instanceof DoesNotExistException ||
			$e instanceof MultipleObjectsReturnedException) {
			throw new NoteNotFound($e->getMessage());
		} else {
			throw $e;
		}
	}

	public function find($id, $userId) {
		try {
			return $this->mapper->find($id, $userId);

			// in order to be able to plug in different storage backends like files
		// for instance it is a good idea to turn storage related exceptions
		// into service related exceptions so controllers and service users
		// have to deal with only one type of exception
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}


	public function create($userId, $idfile,
	$name,
	$title,
	$dateOfTheDocument,
	$physicalLocation,
	$validity,
	$form,
	$documentStatus,
	$participants,
	$registrationNumberCdrsbd,
	$decisionType,
	$relation,
	$namelt,
	$company,

	) {
		$sbdecision = new Sbdecision();
		$sbdecision->setUserId($userId);
		$sbdecision->setIdfile($idfile);
$sbdecision->setName($name);
$sbdecision->setTitle($title);
$sbdecision->setDateOfTheDocument($dateOfTheDocument);
$sbdecision->setPhysicalLocation($physicalLocation);
$sbdecision->setValidity($validity);
$sbdecision->setForm($form);
$sbdecision->setDocumentStatus($documentStatus);
$sbdecision->setParticipants($participants);
$sbdecision->setRegistrationNumberCdrsbd($registrationNumberCdrsbd);
$sbdecision->setDecisionType($decisionType);
$sbdecision->setRelation($relation);
$sbdecision->setNamelt($namelt);
$sbdecision-> setCompany($company);

		return $this->mapper->insert($sbdecision);
	}

	public function update($id, $userId, $idfile, 
	$name,
	$title,
	$dateOfTheDocument,
	$physicalLocation,
	$validity,
	$form,
	$documentStatus,
	$participants,
	$registrationNumberCdrsbd,
	$decisionType,
	$relation,
	$namelt,
	$company,

	) {
		try {
			$sbdecision = $this->mapper->find($id, $userId);
			$sbdecision->setIdfile($idfile);
			$sbdecision->setName($name);
$sbdecision->setTitle($title);
$sbdecision->setDateOfTheDocument($dateOfTheDocument);
$sbdecision->setPhysicalLocation($physicalLocation);
$sbdecision->setValidity($validity);
$sbdecision->setForm($form);
$sbdecision->setDocumentStatus($documentStatus);
$sbdecision->setParticipants($participants);
$sbdecision->setRegistrationNumberCdrsbd($registrationNumberCdrsbd);
$sbdecision->setDecisionType($decisionType);
$sbdecision->setRelation($relation);
$sbdecision->setNamelt($namelt);
$sbdecision-> setCompany($company);

			return $this->mapper->update($sbdecision);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$sbdecision = $this->mapper->find($id, $userId);
			$this->mapper->delete($sbdecision);
			return $sbdecision;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
