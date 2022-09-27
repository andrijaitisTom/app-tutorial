<?php

namespace OCA\DmsApp\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\DmsApp\Db\Sntorrcvddoc;
use OCA\DmsApp\Db\SntorrcvddocMapper;

class SntorrcvddocService {

	/** @var SntorrcvddocMapper */
	private $mapper;

	public function __construct(SntorrcvddocMapper $mapper) {
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
	$dateReceiptDate,
	$sender,
	$recipient,
	$recipientEmployee,
	$documentForm,
	$documentType,
	$deliveryMethod,
	$dateOfTheDocument ,
	$physicalLocation,
	$registrationNumberTd,
	$documentOrganizer,
	$direction,
	$relation,
	$namelt,
	) {
		$sntorrcvddoc = new Sntorrcvddoc();
		$sntorrcvddoc->setUserId($userId);
		$sntorrcvddoc->setIdfile($idfile);
		$sntorrcvddoc->setName($name);
		$sntorrcvddoc->setTitle($title);
		$sntorrcvddoc->setDateReceiptDate($dateReceiptDate);
		$sntorrcvddoc->setSender($sender);
		$sntorrcvddoc->setRecipient($recipient);
		$sntorrcvddoc->setRecipientEmployee($recipientEmployee);
		$sntorrcvddoc->setDocumentForm($documentForm);
		$sntorrcvddoc->setDocumentType($documentType);
		$sntorrcvddoc->setDeliveryMethod($deliveryMethod);
		$sntorrcvddoc->setDateOfTheDocument ($dateOfTheDocument );
		$sntorrcvddoc->setPhysicalLocation($physicalLocation);
		$sntorrcvddoc->setRegistrationNumberTd($registrationNumberTd);
		$sntorrcvddoc->setDocumentOrganizer($documentOrganizer);
		$sntorrcvddoc->setDirection($direction);
		$sntorrcvddoc->setRelation($relation);
		$sntorrcvddoc->setNamelt($namelt);
		return $this->mapper->insert($sntorrcvddoc);
	}

	public function update($id, $userId, $idfile, 
	$name,
	$title,
	$dateReceiptDate,
	$sender,
	$recipient,
	$recipientEmployee,
	$documentForm,
	$documentType,
	$deliveryMethod,
	$dateOfTheDocument ,
	$physicalLocation,
	$registrationNumberTd,
	$documentOrganizer,
	$direction,
	$relation,
	$namelt,
	) {
		try {
			$sntorrcvddoc = $this->mapper->find($id, $userId);
			$sntorrcvddoc->setIdfile($idfile);
			$sntorrcvddoc->setName($name);
			$sntorrcvddoc->setTitle($title);
			$sntorrcvddoc->setDateReceiptDate($dateReceiptDate);
			$sntorrcvddoc->setSender($sender);
			$sntorrcvddoc->setRecipient($recipient);
			$sntorrcvddoc->setRecipientEmployee($recipientEmployee);
			$sntorrcvddoc->setDocumentForm($documentForm);
			$sntorrcvddoc->setDocumentType($documentType);
			$sntorrcvddoc->setDeliveryMethod($deliveryMethod);
			$sntorrcvddoc->setDateOfTheDocument ($dateOfTheDocument );
			$sntorrcvddoc->setPhysicalLocation($physicalLocation);
			$sntorrcvddoc->setRegistrationNumberTd($registrationNumberTd);
			$sntorrcvddoc->setDocumentOrganizer($documentOrganizer);
			$sntorrcvddoc->setDirection($direction);
			$sntorrcvddoc->setRelation($relation);
			$sntorrcvddoc->setNamelt($namelt);

			return $this->mapper->update($sntorrcvddoc);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$sntorrcvddoc = $this->mapper->find($id, $userId);
			$this->mapper->delete($sntorrcvddoc);
			return $sntorrcvddoc;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
