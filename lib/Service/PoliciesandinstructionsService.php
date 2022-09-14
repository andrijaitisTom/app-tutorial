<?php

namespace OCA\NotesTutorial\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\NotesTutorial\Db\Policiesandinstructions;
use OCA\NotesTutorial\Db\PoliciesandinstructionsMapper;

class PoliciesandinstructionsService {

	/** @var PoliciesandinstructionsMapper */
	private $mapper;

	public function __construct(PoliciesandinstructionsMapper $mapper) {
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
	$typePi,
	$approvalDate,
	$responsibleUnit,
	$validity,
	$owner,
	$relation,
	$namelt,
	$area,
	) {
		$policiesandinstructions = new Policiesandinstructions();
		$policiesandinstructions->setUserId($userId);
		$policiesandinstructions->setIdfile($idfile);
$policiesandinstructions->setName($name);
$policiesandinstructions->setTitle($title);
$policiesandinstructions->setTypePi($typePi);
$policiesandinstructions->setApprovalDate($approvalDate);
$policiesandinstructions->setResponsibleUnit($responsibleUnit);
$policiesandinstructions->setValidity($validity);
$policiesandinstructions->setOwner($owner);
$policiesandinstructions->setRelation($relation);
$policiesandinstructions->setNamelt($namelt);
$policiesandinstructions->setArea($area);

		return $this->mapper->insert($policiesandinstructions);
	}

	public function update($id, $userId, $idfile, 
	$name,
	$title,
	$typePi,
	$approvalDate,
	$responsibleUnit,
	$validity,
	$owner,
	$relation,
	$namelt,
	$area,
	) {
		try {
			$policiesandinstructions = $this->mapper->find($id, $userId);
			$policiesandinstructions->setIdfile($idfile);
			$policiesandinstructions->setName($name);
$policiesandinstructions->setTitle($title);
$policiesandinstructions->setTypePi($typePi);
$policiesandinstructions->setApprovalDate($approvalDate);
$policiesandinstructions->setResponsibleUnit($responsibleUnit);
$policiesandinstructions->setValidity($validity);
$policiesandinstructions->setOwner($owner);
$policiesandinstructions->setRelation($relation);
$policiesandinstructions->setNamelt($namelt);
$policiesandinstructions->setArea($area);
	
			return $this->mapper->update($policiesandinstructions);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$policiesandinstructions = $this->mapper->find($id, $userId);
			$this->mapper->delete($policiesandinstructions);
			return $policiesandinstructions;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
