<?php

namespace OCA\DmsApp\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\DmsApp\Db\Plciesninstrctns;
use OCA\DmsApp\Db\PlciesninstrctnsMapper;

class PlciesninstrctnsService {

	/** @var PlciesninstrctnsMapper */
	private $mapper;

	public function __construct(PlciesninstrctnsMapper $mapper) {
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
	$company,

	) {
		$plciesninstrctns = new Plciesninstrctns();
		$plciesninstrctns->setUserId($userId);
		$plciesninstrctns->setIdfile($idfile);
$plciesninstrctns->setName($name);
$plciesninstrctns->setTitle($title);
$plciesninstrctns->setTypePi($typePi);
$plciesninstrctns->setApprovalDate($approvalDate);
$plciesninstrctns->setResponsibleUnit($responsibleUnit);
$plciesninstrctns->setValidity($validity);
$plciesninstrctns->setOwner($owner);
$plciesninstrctns->setRelation($relation);
$plciesninstrctns->setNamelt($namelt);
$plciesninstrctns->setArea($area);
$plciesninstrctns-> setCompany($company);

		return $this->mapper->insert($plciesninstrctns);
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
	$company,

	) {
		try {
			$plciesninstrctns = $this->mapper->find($id, $userId);
			$plciesninstrctns->setIdfile($idfile);
			$plciesninstrctns->setName($name);
$plciesninstrctns->setTitle($title);
$plciesninstrctns->setTypePi($typePi);
$plciesninstrctns->setApprovalDate($approvalDate);
$plciesninstrctns->setResponsibleUnit($responsibleUnit);
$plciesninstrctns->setValidity($validity);
$plciesninstrctns->setOwner($owner);
$plciesninstrctns->setRelation($relation);
$plciesninstrctns->setNamelt($namelt);
$plciesninstrctns->setArea($area);
$plciesninstrctns-> setCompany($company);

			return $this->mapper->update($plciesninstrctns);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$plciesninstrctns = $this->mapper->find($id, $userId);
			$this->mapper->delete($plciesninstrctns);
			return $plciesninstrctns;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
