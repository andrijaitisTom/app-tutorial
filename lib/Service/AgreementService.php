<?php

namespace OCA\NotesTutorial\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\NotesTutorial\Db\Agreement;
use OCA\NotesTutorial\Db\AgreementMapper;

class AgreementService {

	/** @var AgreementMapper */
	private $mapper;

	public function __construct(AgreementMapper $mapper) {
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


	public function create($title, $content, $userId, $physical, $namelt, $idfile,$description,
	$comments,
	$outsourcing,
	$it,
	$validSince,
	$validUntil,
	$form,
	$firstParty,
	$secondParty,
	$physicalLocation,
	$materiality,
	$lastRiskAssessmentDate,
	$relation,
	$date,
	) {
		$agreement = new Agreement();
		$agreement->setTitle($title);
		$agreement->setContent($content);
		$agreement->setUserId($userId);
		$agreement->setIdfile($idfile);
		$agreement->setPhysical($physical);
		$agreement->setNamelt($namelt);
		$agreement->setDescription($description);
	$agreement-> setComments(	$comments);
	$agreement-> setOutsourcing(	$outsourcing);
	$agreement-> setIt(	$it);
	$agreement-> setValidSince(	$validSince);
	$agreement-> setValidUntil(	$validUntil);
	$agreement-> setForm(	$form);
	$agreement-> setFirstParty(	$firstParty);
	$agreement-> setSecondParty(	$secondParty);
	$agreement-> setPhysicalLocation(	$physicalLocation);
	$agreement-> setMateriality(	$materiality);
	$agreement-> setLastRiskAssessmentDate(	$lastRiskAssessmentDate);
	$agreement-> setRelation(	$relation);
	$agreement-> setDate(	$date);


		return $this->mapper->insert($agreement);
	}

	public function update($id, $title, $content, $userId, $physical, $namelt, $idfile, $description,
	$comments,
	$outsourcing,
	$it,
	$validSince,
	$validUntil,
	$form,
	$firstParty,
	$secondParty,
	$physicalLocation,
	$materiality,
	$lastRiskAssessmentDate,
	$relation,
	$date,
	) {
		try {
			$agreement = $this->mapper->find($id, $userId);
			$agreement->setTitle($title);
			$agreement->setContent($content);
			$agreement->setPhysical($physical);
			$agreement->setNamelt($namelt);
			$agreement->setIdfile($idfile);
			$agreement->setDescription($description);
			$agreement-> setDate(	$date);
	
	$agreement-> setComments(	$comments);
	$agreement-> setOutsourcing(	$outsourcing);
	$agreement-> setIt(	$it);
	$agreement-> setValidSince(	$validSince);
	$agreement-> setValidUntil(	$validUntil);
	$agreement-> setForm(	$form);
	$agreement-> setFirstParty(	$firstParty);
	$agreement-> setSecondParty(	$secondParty);
	$agreement-> setPhysicalLocation(	$physicalLocation);
	$agreement-> setMateriality(	$materiality);
	$agreement-> setLastRiskAssessmentDate(	$lastRiskAssessmentDate);
	$agreement-> setRelation(	$relation);
			return $this->mapper->update($agreement);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$agreement = $this->mapper->find($id, $userId);
			$this->mapper->delete($agreement);
			return $agreement;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
