<?php

namespace OCA\DmsApp\Controller;

use OCA\DmsApp\AppInfo\Application;
use OCA\DmsApp\Service\OutsourcingagreementService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class OutsourcingagreementController extends Controller {
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
	 * @NoAdminRequired
	 */
	public function index(): DataResponse {
		return new DataResponse($this->service->findAll($this->userId));
	}

	/**
	 * @NoAdminRequired
	 */
	public function show(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->find($id, $this->userId);
		});
	}

	/**
	 * @NoAdminRequired
	 */
	public function create(string $idfile, 
	string $name,
	string $title,
	string $date,
	string $description,
	string $comments,
	string $outsourcing,
	string $auditDate,
	string $partiesRelated,
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
	string $bankLtApprovalDate,
	string $bankLtNotifDate,
	string $relatedToPervesk,
	string $agreementApprovedBy,
	string $governingLawOfTheAgreement,
	string $subcontractors,
	string $serviceProviderAddress,
	string $providerEntCode,
	string $serviceProviderName,
	string $providerPrntCompany,
	string $providerResult,
	string $alternativeServiceProviders,
	string $fnSupCritical,
	string $priceOfAgreement,
	string $outsrcdFnNotProvided,
	string $company,

	): DataResponse {
		return new DataResponse($this->service->create($this->userId, $idfile,
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

		));
	}

	/**
	 * @NoAdminRequired
	 */
	public function update(int $id, string $idfile, 
	string $name,
	string $title,
	string $date,
	string $description,
	string $comments,
	string $outsourcing,
	string $auditDate,
	string $partiesRelated,
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
	string $bankLtApprovalDate,
	string $bankLtNotifDate,
	string $relatedToPervesk,
	string $agreementApprovedBy,
	string $governingLawOfTheAgreement,
	string $subcontractors,
	string $serviceProviderAddress,
	string $providerEntCode,
	string $serviceProviderName,
	string $providerPrntCompany,
	string $providerResult,
	string $alternativeServiceProviders,
	string $fnSupCritical,
	string $priceOfAgreement,
	string $outsrcdFnNotProvided,
	string $company,

						   ): DataResponse {
		return $this->handleNotFound(function () use ($id, $idfile,
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
			return $this->service->update($id, $this->userId, $idfile,
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

		);
		});
	}

	/**
	 * @NoAdminRequired
	 */
	public function destroy(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->delete($id, $this->userId);
		});
	}
}
