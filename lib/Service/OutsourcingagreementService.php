<?php

namespace OCA\NotesTutorial\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\NotesTutorial\Db\Outsourcingagreement;
use OCA\NotesTutorial\Db\OutsourcingagreementMapper;

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
	$outsourcingFunctionAuditDate,
	$partiesRelatedToTheCompanyWhoAlsoUseThisService,
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
	$bankOfLithuaniaApprovalDate,
	$bankOfLithuaniaNotificationDate,
	$isTheServiceProviderRelatedToUabPervesk,
	$agreementApprovedBy,
	$governingLawOfTheAgreement,
	$subcontractors,
	$serviceProviderAddress,
	$serviceProviderLegalEntityCode,
	$serviceProviderName,
	$serviceProviderParentCompany,
	$serviceProviderSubstitutabilityAssessmentResult,
	$alternativeServiceProviders,
	$doesThisFunctionSupportBusinessOperationsCritical,
	$priceOfAgreement,
	$eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel,
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
		$outsourcingagreement->setOutsourcingFunctionAuditDate($outsourcingFunctionAuditDate);
		$outsourcingagreement->setPartiesRelatedToTheCompanyWhoAlsoUseThisService($partiesRelatedToTheCompanyWhoAlsoUseThisService);
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
		$outsourcingagreement->setBankOfLithuaniaApprovalDate($bankOfLithuaniaApprovalDate);
		$outsourcingagreement->setBankOfLithuaniaNotificationDate($bankOfLithuaniaNotificationDate);
		$outsourcingagreement->setIsTheServiceProviderRelatedToUabPervesk($isTheServiceProviderRelatedToUabPervesk);
		$outsourcingagreement->setAgreementApprovedBy($agreementApprovedBy);
		$outsourcingagreement->setGoverningLawOfTheAgreement($governingLawOfTheAgreement);
		$outsourcingagreement->setSubcontractors($subcontractors);
		$outsourcingagreement->setServiceProviderAddress($serviceProviderAddress);
		$outsourcingagreement->setServiceProviderLegalEntityCode($serviceProviderLegalEntityCode);
		$outsourcingagreement->setServiceProviderName($serviceProviderName);
		$outsourcingagreement->setServiceProviderParentCompany($serviceProviderParentCompany);
		$outsourcingagreement->setServiceProviderSubstitutabilityAssessmentResult($serviceProviderSubstitutabilityAssessmentResult);
		$outsourcingagreement->setAlternativeServiceProviders($alternativeServiceProviders);
		$outsourcingagreement->setDoesThisFunctionSupportBusinessOperationsCritical($doesThisFunctionSupportBusinessOperationsCritical);
		$outsourcingagreement->setPriceOfAgreement($priceOfAgreement);
		$outsourcingagreement->setEventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel($eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel);

		return $this->mapper->insert($outsourcingagreement);
	}

	public function update($id, $userId, $idfile, 
	$name,
	$title,
	$date,
	$description,
	$comments,
	$outsourcing,
	$outsourcingFunctionAuditDate,
	$partiesRelatedToTheCompanyWhoAlsoUseThisService,
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
	$bankOfLithuaniaApprovalDate,
	$bankOfLithuaniaNotificationDate,
	$isTheServiceProviderRelatedToUabPervesk,
	$agreementApprovedBy,
	$governingLawOfTheAgreement,
	$subcontractors,
	$serviceProviderAddress,
	$serviceProviderLegalEntityCode,
	$serviceProviderName,
	$serviceProviderParentCompany,
	$serviceProviderSubstitutabilityAssessmentResult,
	$alternativeServiceProviders,
	$doesThisFunctionSupportBusinessOperationsCritical,
	$priceOfAgreement,
	$eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel,
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
			$outsourcingagreement->setOutsourcingFunctionAuditDate($outsourcingFunctionAuditDate);
			$outsourcingagreement->setPartiesRelatedToTheCompanyWhoAlsoUseThisService($partiesRelatedToTheCompanyWhoAlsoUseThisService);
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
			$outsourcingagreement->setBankOfLithuaniaApprovalDate($bankOfLithuaniaApprovalDate);
			$outsourcingagreement->setBankOfLithuaniaNotificationDate($bankOfLithuaniaNotificationDate);
			$outsourcingagreement->setIsTheServiceProviderRelatedToUabPervesk($isTheServiceProviderRelatedToUabPervesk);
			$outsourcingagreement->setAgreementApprovedBy($agreementApprovedBy);
			$outsourcingagreement->setGoverningLawOfTheAgreement($governingLawOfTheAgreement);
			$outsourcingagreement->setSubcontractors($subcontractors);
			$outsourcingagreement->setServiceProviderAddress($serviceProviderAddress);
			$outsourcingagreement->setServiceProviderLegalEntityCode($serviceProviderLegalEntityCode);
			$outsourcingagreement->setServiceProviderName($serviceProviderName);
			$outsourcingagreement->setServiceProviderParentCompany($serviceProviderParentCompany);
			$outsourcingagreement->setServiceProviderSubstitutabilityAssessmentResult($serviceProviderSubstitutabilityAssessmentResult);
			$outsourcingagreement->setAlternativeServiceProviders($alternativeServiceProviders);
			$outsourcingagreement->setDoesThisFunctionSupportBusinessOperationsCritical($doesThisFunctionSupportBusinessOperationsCritical);
			$outsourcingagreement->setPriceOfAgreement($priceOfAgreement);
			$outsourcingagreement->setEventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel($eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel);
			
	
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
