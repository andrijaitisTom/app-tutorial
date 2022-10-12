<?php

namespace OCA\DmsApp\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\DmsApp\Db\Outsourcingagreement;
use OCA\DmsApp\Db\OutsourcingagreementMapper;

class OutsourcingagreementService {

	/** @var OutsourcingagreementMapper */
	private $mapper;

	public function __construct(OutsourcingagreementMapper $mapper) {
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
	$date,
	$description,
	$comments,
	$outsourcing,
	$auditDate,
	$partiesRelated,
	$validSince,
	$validUntil,
	$form,
	$physicalLocation,
	$materiality,
	$natureOfFunction,
	$lastRiskAssessmentDate,
	$lastRiskAssessmentResult,
	$namelt,
	$basisForMateriality,
	$locationOfData,
	$locationOfServices,
	$transferOfData,
	$bankLtApprovalDate,
	$bankLtNotifDate,
	$relatedToPervesk,
	$agreementApprovedBy,
	$governingLawOfTheAgreement,
	$subcontractors,
	$serviceProviderAddress,
	$providerEntCode,
	$serviceProviderName,
	$providerPrntCompany,
	$providerResult,
	$alternativeServiceProviders,
	$fnSupCritical,
	$priceOfAgreement,
	$outsrcdFnNotProvided,
	$company,

	) {
		$outsourcingagreement = new Outsourcingagreement();
		$outsourcingagreement->setUserId($userId);
		$outsourcingagreement->setIdfile($idfile);
		$outsourcingagreement->setName($name);
		$outsourcingagreement->setTitle($title);
		$outsourcingagreement->setDate($date);
		$outsourcingagreement->setDescription($description);
		$outsourcingagreement->setComments($comments);
		$outsourcingagreement->setOutsourcing($outsourcing);
		$outsourcingagreement->setAuditDate($auditDate);
		$outsourcingagreement->setPartiesRelated($partiesRelated);
		$outsourcingagreement->setValidSince($validSince);
		$outsourcingagreement->setValidUntil($validUntil);
		$outsourcingagreement->setForm($form);
		$outsourcingagreement->setPhysicalLocation($physicalLocation);
		$outsourcingagreement->setMateriality($materiality);
		$outsourcingagreement->setNatureOfFunction($natureOfFunction);
		$outsourcingagreement->setLastRiskAssessmentDate($lastRiskAssessmentDate);
		$outsourcingagreement->setLastRiskAssessmentResult($lastRiskAssessmentResult);
		$outsourcingagreement->setNamelt($namelt);
		$outsourcingagreement->setBasisForMateriality($basisForMateriality);
		$outsourcingagreement->setLocationOfData($locationOfData);
		$outsourcingagreement->setLocationOfServices($locationOfServices);
		$outsourcingagreement->setTransferOfData($transferOfData);
		$outsourcingagreement->setBankLtApprovalDate($bankLtApprovalDate);
		$outsourcingagreement->setBankLtNotifDate($bankLtNotifDate);
		$outsourcingagreement->setRelatedToPervesk($relatedToPervesk);
		$outsourcingagreement->setAgreementApprovedBy($agreementApprovedBy);
		$outsourcingagreement->setGoverningLawOfTheAgreement($governingLawOfTheAgreement);
		$outsourcingagreement->setSubcontractors($subcontractors);
		$outsourcingagreement->setServiceProviderAddress($serviceProviderAddress);
		$outsourcingagreement->setProviderEntCode($providerEntCode);
		$outsourcingagreement->setServiceProviderName($serviceProviderName);
		$outsourcingagreement->setProviderPrntCompany($providerPrntCompany);
		$outsourcingagreement->setProviderResult($providerResult);
		$outsourcingagreement->setAlternativeServiceProviders($alternativeServiceProviders);
		$outsourcingagreement->setFnSupCritical($fnSupCritical);
		$outsourcingagreement->setPriceOfAgreement($priceOfAgreement);
		$outsourcingagreement->setOutsrcdFnNotProvided($outsrcdFnNotProvided);
		$outsourcingagreement-> setCompany($company);

		return $this->mapper->insert($outsourcingagreement);
	}

	public function update($id, $userId, $idfile, 
	$name,
	$title,
	$date,
	$description,
	$comments,
	$outsourcing,
	$auditDate,
	$partiesRelated,
	$validSince,
	$validUntil,
	$form,
	$physicalLocation,
	$materiality,
	$natureOfFunction,
	$lastRiskAssessmentDate,
	$lastRiskAssessmentResult,
	$namelt,
	$basisForMateriality,
	$locationOfData,
	$locationOfServices,
	$transferOfData,
	$bankLtApprovalDate,
	$bankLtNotifDate,
	$relatedToPervesk,
	$agreementApprovedBy,
	$governingLawOfTheAgreement,
	$subcontractors,
	$serviceProviderAddress,
	$providerEntCode,
	$serviceProviderName,
	$providerPrntCompany,
	$providerResult,
	$alternativeServiceProviders,
	$fnSupCritical,
	$priceOfAgreement,
	$outsrcdFnNotProvided,
	$company,

	) {
		try {
			
			$outsourcingagreement = $this->mapper->find($id, $userId);
			$outsourcingagreement->setIdfile($idfile);
			$outsourcingagreement->setName($name);
			$outsourcingagreement->setTitle($title);
			$outsourcingagreement->setDate($date);
			$outsourcingagreement->setDescription($description);
			$outsourcingagreement->setComments($comments);
			$outsourcingagreement->setOutsourcing($outsourcing);
			$outsourcingagreement->setAuditDate($auditDate);
			$outsourcingagreement->setPartiesRelated($partiesRelated);
			$outsourcingagreement->setValidSince($validSince);
			$outsourcingagreement->setValidUntil($validUntil);
			$outsourcingagreement->setForm($form);
			$outsourcingagreement->setPhysicalLocation($physicalLocation);
			$outsourcingagreement->setMateriality($materiality);
			$outsourcingagreement->setNatureOfFunction($natureOfFunction);
			$outsourcingagreement->setLastRiskAssessmentDate($lastRiskAssessmentDate);
			$outsourcingagreement->setLastRiskAssessmentResult($lastRiskAssessmentResult);
			$outsourcingagreement->setNamelt($namelt);
			$outsourcingagreement->setBasisForMateriality($basisForMateriality);
			$outsourcingagreement->setLocationOfData($locationOfData);
			$outsourcingagreement->setLocationOfServices($locationOfServices);
			$outsourcingagreement->setTransferOfData($transferOfData);
			$outsourcingagreement->setBankLtApprovalDate($bankLtApprovalDate);
			$outsourcingagreement->setBankLtNotifDate($bankLtNotifDate);
			$outsourcingagreement->setRelatedToPervesk($relatedToPervesk);
			$outsourcingagreement->setAgreementApprovedBy($agreementApprovedBy);
			$outsourcingagreement->setGoverningLawOfTheAgreement($governingLawOfTheAgreement);
			$outsourcingagreement->setSubcontractors($subcontractors);
			$outsourcingagreement->setServiceProviderAddress($serviceProviderAddress);
			$outsourcingagreement->setProviderEntCode($providerEntCode);
			$outsourcingagreement->setServiceProviderName($serviceProviderName);
			$outsourcingagreement->setProviderPrntCompany($providerPrntCompany);
			$outsourcingagreement->setProviderResult($providerResult);
			$outsourcingagreement->setAlternativeServiceProviders($alternativeServiceProviders);
			$outsourcingagreement->setFnSupCritical($fnSupCritical);
			$outsourcingagreement->setPriceOfAgreement($priceOfAgreement);
			$outsourcingagreement->setOutsrcdFnNotProvided($outsrcdFnNotProvided);
			$outsourcingagreement-> setCompany($company);

	
			return $this->mapper->update($outsourcingagreement);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$outsourcingagreement = $this->mapper->find($id, $userId);
			$this->mapper->delete($outsourcingagreement);
			return $outsourcingagreement;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
