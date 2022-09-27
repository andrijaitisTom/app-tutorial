<?php

namespace OCA\DmsApp\Db;

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
	protected $auditDate;
	protected $partiesRelated;
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
	protected $bankLtApprovalDate;
	protected $bankLtNotifDate;
	protected $relatedToPervesk;
	protected $agreementApprovedBy;
	protected $governingLawOfTheAgreement;
	protected $subcontractors;
	protected $serviceProviderAddress;
	protected $providerEntCode;
	protected $serviceProviderName;
	protected $providerPrntCompany;
	protected $providerResult;
	protected $alternativeServiceProviders;
	protected $fnSupCritical;
	protected $priceOfAgreement;
	protected $outsrcdFnNotProvided;
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
'auditDate' => $this->auditDate,
'partiesRelated' => $this->partiesRelated,
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
'bankLtApprovalDate' => $this->bankLtApprovalDate,
'bankLtNotifDate' => $this->bankLtNotifDate,
'relatedToPervesk' => $this->relatedToPervesk,
'agreementApprovedBy' => $this->agreementApprovedBy,
'governingLawOfTheAgreement' => $this->governingLawOfTheAgreement,
'subcontractors' => $this->subcontractors,
'serviceProviderAddress' => $this->serviceProviderAddress,
'providerEntCode' => $this->providerEntCode,
'serviceProviderName' => $this->serviceProviderName,
'providerPrntCompany' => $this->providerPrntCompany,
'providerResult' => $this->providerResult,
'alternativeServiceProviders' => $this->alternativeServiceProviders,
'fnSupCritical' => $this->fnSupCritical,
'priceOfAgreement' => $this->priceOfAgreement,
'outsrcdFnNotProvided' => $this->outsrcdFnNotProvided,
'userId' => $this->	userId,

		];
	}
}
