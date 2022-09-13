<?php

namespace OCA\NotesTutorial\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Outsourcingagreement extends Entity implements JsonSerializable {
	

	protected $userId;
	protected $idfile;
	protected $name;
	protected $title;
	protected $date;
	protected $description;
	protected $comments;
	protected $outsourcing;
	protected $outsourcingFunctionAuditDate;
	protected $partiesRelatedToTheCompanyWhoAlsoUseThisService;
	protected $validSince;
	protected $validUntil;
	protected $form;
	protected $physicalLocation;
	protected $materiality;
	protected $natureOfFunction;
	protected $lastRiskAssessmentDate;
	protected $lastRiskAssessmentResult;
	protected $namelt;
	protected $basisForMateriality;
	protected $locationOfData;
	protected $locationOfServices;
	protected $transferOfData;
	protected $bankOfLithuaniaApprovalDate;
	protected $bankOfLithuaniaNotificationDate;
	protected $isTheServiceProviderRelatedToUabPervesk;
	protected $agreementApprovedBy;
	protected $governingLawOfTheAgreement;
	protected $subcontractors;
	protected $serviceProviderAddress;
	protected $serviceProviderLegalEntityCode;
	protected $serviceProviderName;
	protected $serviceProviderParentCompany;
	protected $serviceProviderSubstitutabilityAssessmentResult;
	protected $alternativeServiceProviders;
	protected $doesThisFunctionSupportBusinessOperationsCritical;
	protected $priceOfAgreement;
	protected $eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel;
	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'idfile' => $this->idfile,
			'name' => $this->name,
'title' => $this->title,
'date' => $this->date,
'description' => $this->description,
'comments' => $this->comments,
'outsourcing' => $this->outsourcing,
'outsourcingFunctionAuditDate' => $this->outsourcingFunctionAuditDate,
'partiesRelatedToTheCompanyWhoAlsoUseThisService' => $this->partiesRelatedToTheCompanyWhoAlsoUseThisService,
'validSince' => $this->validSince,
'validUntil' => $this->validUntil,
'form' => $this->form,
'physicalLocation' => $this->physicalLocation,
'materiality' => $this->materiality,
'natureOfFunction' => $this->natureOfFunction,
'lastRiskAssessmentDate' => $this->lastRiskAssessmentDate,
'lastRiskAssessmentResult' => $this->lastRiskAssessmentResult,
'namelt' => $this->namelt,
'basisForMateriality' => $this->basisForMateriality,
'locationOfData' => $this->locationOfData,
'locationOfServices' => $this->locationOfServices,
'transferOfData' => $this->transferOfData,
'bankOfLithuaniaApprovalDate' => $this->bankOfLithuaniaApprovalDate,
'bankOfLithuaniaNotificationDate' => $this->bankOfLithuaniaNotificationDate,
'isTheServiceProviderRelatedToUabPervesk' => $this->isTheServiceProviderRelatedToUabPervesk,
'agreementApprovedBy' => $this->agreementApprovedBy,
'governingLawOfTheAgreement' => $this->governingLawOfTheAgreement,
'subcontractors' => $this->subcontractors,
'serviceProviderAddress' => $this->serviceProviderAddress,
'serviceProviderLegalEntityCode' => $this->serviceProviderLegalEntityCode,
'serviceProviderName' => $this->serviceProviderName,
'serviceProviderParentCompany' => $this->serviceProviderParentCompany,
'serviceProviderSubstitutabilityAssessmentResult' => $this->serviceProviderSubstitutabilityAssessmentResult,
'alternativeServiceProviders' => $this->alternativeServiceProviders,
'doesThisFunctionSupportBusinessOperationsCritical' => $this->doesThisFunctionSupportBusinessOperationsCritical,
'priceOfAgreement' => $this->priceOfAgreement,
'eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel' => $this->eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel,
		];
	}
}
