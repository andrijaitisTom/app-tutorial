<?php

namespace OCA\NotesTutorial\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\NotesTutorial\Db\Ceoresolution;
use OCA\NotesTutorial\Db\CeoresolutionMapper;

class CeoresolutionService {

	/** @var CeoresolutionMapper */
	private $mapper;

	public function __construct(CeoresolutionMapper $mapper) {
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
	$registrationNumberCdro,
	$participants,
	$orderType,
	$relation,
	$namelt,
	) {
		$ceoresolutions = new Ceoresolution();
		$ceoresolutions->setUserId($userId);
		$ceoresolutions->setIdfile($idfile);
		$ceoresolutions->setName($name);
		$ceoresolutions->setTitle($title);
		$ceoresolutions->setDateOfTheDocument($dateOfTheDocument);
		$ceoresolutions->setPhysicalLocation($physicalLocation);
		$ceoresolutions->setValidity($validity);
		$ceoresolutions->setForm($form);
		$ceoresolutions->setDocumentStatus($documentStatus);
		$ceoresolutions->setRegistrationNumberCdro($registrationNumberCdro);
		$ceoresolutions->setParticipants($participants);
		$ceoresolutions->setOrderType($orderType);
		$ceoresolutions->setRelation($relation);
		$ceoresolutions->setNamelt($namelt);

		return $this->mapper->insert($ceoresolutions);
	}

	public function update($id, $userId, $idfile, 
	$name,
	$title,
	$dateOfTheDocument,
	$physicalLocation,
	$validity,
	$form,
	$documentStatus,
	$registrationNumberCdro,
	$participants,
	$orderType,
	$relation,
	$namelt,
	) {
		try {
			$ceoresolutions = $this->mapper->find($id, $userId);
			$ceoresolutions->setIdfile($idfile);
			$ceoresolutions->setName($name);
			$ceoresolutions->setTitle($title);
			$ceoresolutions->setDateOfTheDocument($dateOfTheDocument);
			$ceoresolutions->setPhysicalLocation($physicalLocation);
			$ceoresolutions->setValidity($validity);
			$ceoresolutions->setForm($form);
			$ceoresolutions->setDocumentStatus($documentStatus);
			$ceoresolutions->setRegistrationNumberCdro($registrationNumberCdro);
			$ceoresolutions->setParticipants($participants);
			$ceoresolutions->setOrderType($orderType);
			$ceoresolutions->setRelation($relation);
			$ceoresolutions->setNamelt($namelt);	
	
			return $this->mapper->update($ceoresolutions);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$ceoresolutions = $this->mapper->find($id, $userId);
			$this->mapper->delete($ceoresolutions);
			return $ceoresolutions;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
