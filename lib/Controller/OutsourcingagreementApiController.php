<?php

namespace OCA\NotesTutorial\Controller;

use OCA\NotesTutorial\AppInfo\Application;
use OCA\NotesTutorial\Service\OutsourcingagreementService;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class OutsourcingagreementApiController extends ApiController {
	/** @var OutsourcingagreementService */
	private $service;

	/** @var string */
	private $userId;

	use Errors;

	public function __construct(IRequest $request,
							OutsourcingagreementService $service,
								$userId) {
		parent::__construct(Application::APP_ID, $request);
		$this->service = $service;
		$this->userId = $userId;
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function index(): DataResponse {
		return new DataResponse($this->service->findAll($this->userId));
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function show(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->find($id, $this->userId);
		});
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function create(string $idfile, 
	string $name,
string $title,
string $date,
string $description,
string $comments,
string $outsourcing,
string $outsourcingFunctionAuditDate,
string $partiesRelatedToTheCompanyWhoAlsoUseThisService,
string $validSince,
string $validUntil,
string $form,
string $physicalLocation,
string $materiality,
string $natureOfFunction,
string $lastRiskAssessmentDate,
string $lastRiskAssessmentResult,
string $namelt,
string $basisForMateriality,
string $locationOfData,
string $locationOfServices,
string $transferOfData,
string $bankOfLithuaniaApprovalDate,
string $bankOfLithuaniaNotificationDate,
string $isTheServiceProviderRelatedToUabPervesk,
string $agreementApprovedBy,
string $governingLawOfTheAgreement,
string $subcontractors,
string $serviceProviderAddress,
string $serviceProviderLegalEntityCode,
string $serviceProviderName,
string $serviceProviderParentCompany,
string $serviceProviderSubstitutabilityAssessmentResult,
string $alternativeServiceProviders,
string $doesThisFunctionSupportBusinessOperationsCritical,
string $priceOfAgreement,
string $eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel,
	): DataResponse {
		return new DataResponse($this->service->create($this->userId, $idfile, 
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
		));
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function update(int $id, string $idfile, 
	string $name,
	string $title,
	string $date,
	string $description,
	string $comments,
	string $outsourcing,
	string $outsourcingFunctionAuditDate,
	string $partiesRelatedToTheCompanyWhoAlsoUseThisService,
	string $validSince,
	string $validUntil,
	string $form,
	string $physicalLocation,
	string $materiality,
	string $natureOfFunction,
	string $lastRiskAssessmentDate,
	string $lastRiskAssessmentResult,
	string $namelt,
	string $basisForMateriality,
	string $locationOfData,
	string $locationOfServices,
	string $transferOfData,
	string $bankOfLithuaniaApprovalDate,
	string $bankOfLithuaniaNotificationDate,
	string $isTheServiceProviderRelatedToUabPervesk,
	string $agreementApprovedBy,
	string $governingLawOfTheAgreement,
	string $subcontractors,
	string $serviceProviderAddress,
	string $serviceProviderLegalEntityCode,
	string $serviceProviderName,
	string $serviceProviderParentCompany,
	string $serviceProviderSubstitutabilityAssessmentResult,
	string $alternativeServiceProviders,
	string $doesThisFunctionSupportBusinessOperationsCritical,
	string $priceOfAgreement,
	string $eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel,
						   ): DataResponse {
		return $this->handleNotFound(function () use ($id, $idfile, 
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
			return $this->service->update($id, $this->userId, $idfile,
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
		);
		});
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function destroy(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->delete($id, $this->userId);
		});
	}
}
