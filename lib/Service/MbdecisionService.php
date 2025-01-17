<?php

namespace OCA\DmsApp\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\DmsApp\Db\Mbdecision;
use OCA\DmsApp\Db\MbdecisionMapper;

class MbdecisionService {

	/** @var MbdecisionMapper */
	private $mapper;

	public function __construct(MbdecisionMapper $mapper) {
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
	$title,
	$physicalLocation,
 	$dateOfTheDocument,
	$validity,
	$form,
	$documentStatus,
	$participants,
	$decisionType,
	$registrationNumberCdrmbd,
	$relation,
	$namelt,
	$company,

	) {
		$mbdecision = new Mbdecision();
		$mbdecision->setUserId($userId);
		$mbdecision->setIdfile($idfile);
		$mbdecision->setTitle($title);
		$mbdecision->setPhysicalLocation($physicalLocation);
		$mbdecision->setdateOfTheDocument($dateOfTheDocument);
		$mbdecision->setValidity($validity);
		$mbdecision->setForm($form);
		$mbdecision->setDocumentStatus($documentStatus);
		$mbdecision->setParticipants($participants);
		$mbdecision->setDecisionType($decisionType);
		$mbdecision->setRegistrationNumberCdrmbd($registrationNumberCdrmbd);
		$mbdecision->setRelation($relation);
		$mbdecision->setNamelt($namelt);		
		$mbdecision-> setCompany($company);

		return $this->mapper->insert($mbdecision);
	}

	public function update($id, $userId, $idfile, 
	$title,
	$physicalLocation,
 	$dateOfTheDocument,
	$validity,
	$form,
	$documentStatus,
	$participants,
	$decisionType,
	$registrationNumberCdrmbd,
	$relation,
	$namelt,
	$company,

	) {
		try {
			$mbdecision = $this->mapper->find($id, $userId);
			$mbdecision->setIdfile($idfile);
			$mbdecision->setTitle($title);
			$mbdecision->setPhysicalLocation($physicalLocation);
			$mbdecision->setdateOfTheDocument($dateOfTheDocument);
			$mbdecision->setValidity($validity);
			$mbdecision->setForm($form);
			$mbdecision->setDocumentStatus($documentStatus);
			$mbdecision->setParticipants($participants);
			$mbdecision->setDecisionType($decisionType);
			$mbdecision->setRegistrationNumberCdrmbd($registrationNumberCdrmbd);
			$mbdecision->setRelation($relation);
			$mbdecision->setNamelt($namelt);	
			$mbdecision-> setCompany($company);

	
			return $this->mapper->update($mbdecision);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$mbdecision = $this->mapper->find($id, $userId);
			$this->mapper->delete($mbdecision);
			return $mbdecision;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
