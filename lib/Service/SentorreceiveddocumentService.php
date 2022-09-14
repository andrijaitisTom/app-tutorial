<?php

namespace OCA\NotesTutorial\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\NotesTutorial\Db\Sentorreceiveddocument;
use OCA\NotesTutorial\Db\SentorreceiveddocumentMapper;

class SentorreceiveddocumentService {

	/** @var SentorreceiveddocumentMapper */
	private $mapper;

	public function __construct(SentorreceiveddocumentMapper $mapper) {
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
		$sentorreceiveddocument = new Sentorreceiveddocument();
		$sentorreceiveddocument->setUserId($userId);
		$sentorreceiveddocument->setIdfile($idfile);
		$sentorreceiveddocument->setName($name);
		$sentorreceiveddocument->setTitle($title);
		$sentorreceiveddocument->setDateReceiptDate($dateReceiptDate);
		$sentorreceiveddocument->setSender($sender);
		$sentorreceiveddocument->setRecipient($recipient);
		$sentorreceiveddocument->setRecipientEmployee($recipientEmployee);
		$sentorreceiveddocument->setDocumentForm($documentForm);
		$sentorreceiveddocument->setDocumentType($documentType);
		$sentorreceiveddocument->setDeliveryMethod($deliveryMethod);
		$sentorreceiveddocument->setDateOfTheDocument ($dateOfTheDocument );
		$sentorreceiveddocument->setPhysicalLocation($physicalLocation);
		$sentorreceiveddocument->setRegistrationNumberTd($registrationNumberTd);
		$sentorreceiveddocument->setDocumentOrganizer($documentOrganizer);
		$sentorreceiveddocument->setDirection($direction);
		$sentorreceiveddocument->setRelation($relation);
		$sentorreceiveddocument->setNamelt($namelt);
		return $this->mapper->insert($sentorreceiveddocument);
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
			$sentorreceiveddocument = $this->mapper->find($id, $userId);
			$sentorreceiveddocument->setIdfile($idfile);
			$sentorreceiveddocument->setName($name);
			$sentorreceiveddocument->setTitle($title);
			$sentorreceiveddocument->setDateReceiptDate($dateReceiptDate);
			$sentorreceiveddocument->setSender($sender);
			$sentorreceiveddocument->setRecipient($recipient);
			$sentorreceiveddocument->setRecipientEmployee($recipientEmployee);
			$sentorreceiveddocument->setDocumentForm($documentForm);
			$sentorreceiveddocument->setDocumentType($documentType);
			$sentorreceiveddocument->setDeliveryMethod($deliveryMethod);
			$sentorreceiveddocument->setDateOfTheDocument ($dateOfTheDocument );
			$sentorreceiveddocument->setPhysicalLocation($physicalLocation);
			$sentorreceiveddocument->setRegistrationNumberTd($registrationNumberTd);
			$sentorreceiveddocument->setDocumentOrganizer($documentOrganizer);
			$sentorreceiveddocument->setDirection($direction);
			$sentorreceiveddocument->setRelation($relation);
			$sentorreceiveddocument->setNamelt($namelt);

			return $this->mapper->update($sentorreceiveddocument);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$sentorreceiveddocument = $this->mapper->find($id, $userId);
			$this->mapper->delete($sentorreceiveddocument);
			return $sentorreceiveddocument;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
