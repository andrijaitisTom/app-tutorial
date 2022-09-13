<?php

namespace OCA\NotesTutorial\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\NotesTutorial\Db\Contract;
use OCA\NotesTutorial\Db\ContractMapper;

class ContractService {

	/** @var ContractMapper */
	private $mapper;

	public function __construct(ContractMapper $mapper) {
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
$registrationNumberContract,
$description,
$date,
$inForceUntil,
$counterparties,
$corporateOwner,
$personalOwner,
$it,
$outsourcing,
$materiality,
$lastRiskAssessmentDate,
$documentType,
$physicalLocation,
$comments,
$relation,
$namelt,
	) {
		$contract = new Contract();
		$contract->setUserId($userId);
		$contract->setIdfile($idfile);
$contract->setName($name);
$contract->setTitle($title);
$contract->setRegistrationNumberContract($registrationNumberContract);
$contract->setDescription($description);
$contract->setDate($date);
$contract->setInForceUntil($inForceUntil);
$contract->setCounterparties($counterparties);
$contract->setCorporateOwner($corporateOwner);
$contract->setPersonalOwner($personalOwner);
$contract->setIt($it);
$contract->setOutsourcing($outsourcing);
$contract->setMateriality($materiality);
$contract->setLastRiskAssessmentDate($lastRiskAssessmentDate);
$contract->setDocumentType($documentType);
$contract->setPhysicalLocation($physicalLocation);
$contract->setComments($comments);
$contract->setRelation($relation);
$contract->setNamelt($namelt);
		

		return $this->mapper->insert($contract);
	}

	public function update($id, $userId, $idfile, 
	$name,
$title,
$registrationNumberContract,
$description,
$date,
$inForceUntil,
$counterparties,
$corporateOwner,
$personalOwner,
$it,
$outsourcing,
$materiality,
$lastRiskAssessmentDate,
$documentType,
$physicalLocation,
$comments,
$relation,
$namelt,
	) {
		try {
			$contract = $this->mapper->find($id, $userId);
			$contract->setIdfile($idfile);
$contract->setName($name);
$contract->setTitle($title);
$contract->setRegistrationNumberContract($registrationNumberContract);
$contract->setDescription($description);
$contract->setDate($date);
$contract->setInForceUntil($inForceUntil);
$contract->setCounterparties($counterparties);
$contract->setCorporateOwner($corporateOwner);
$contract->setPersonalOwner($personalOwner);
$contract->setIt($it);
$contract->setOutsourcing($outsourcing);
$contract->setMateriality($materiality);
$contract->setLastRiskAssessmentDate($lastRiskAssessmentDate);
$contract->setDocumentType($documentType);
$contract->setPhysicalLocation($physicalLocation);
$contract->setComments($comments);
$contract->setRelation($relation);
$contract->setNamelt($namelt);

			return $this->mapper->update($contract);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$contract = $this->mapper->find($id, $userId);
			$this->mapper->delete($contract);
			return $contract;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
