<?php

namespace OCA\DmsApp\Controller;

use OCA\DmsApp\AppInfo\Application;
use OCA\DmsApp\Service\AgreementService;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class AgreementApiController extends ApiController {
	/** @var AgreementService */
	private $service;

	/** @var string */
	private $userId;

	use Errors;

	public function __construct(IRequest $request,
							AgreementService $service,
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
	public function create(string $title, string $content, string $physical, string $namelt, string $idfile, string $description,
	string $date,
	string $comments,
	string $outsourcing,
	string $it,
	string $validSince,
	string $validUntil,
	string $form,
	string $firstParty,
	string $secondParty,
	string $physicalLocation,
	string $materiality,
	string $lastRiskAssessmentDate,
	string $relation,
	string $company,
	): DataResponse {
		return new DataResponse($this->service->create($title, $content,
			$this->userId, $physical, $namelt, $idfile	, $description,	
			 $date,

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
			$company,
		));
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function update(int $id, string $title,
						   string $content, string $physical,  string $namelt, string $idfile,  $description,
						   	string $date,

						   string $comments,
						   string $outsourcing,
						   string $it,
						   string $validSince,
						   string $validUntil,
						   string $form,
						   string $firstParty,
						   string $secondParty,
						   string $physicalLocation,
						   string $materiality,
						   string $lastRiskAssessmentDate,
						   string $relation,
						   string $company,

						   ): DataResponse {
		return $this->handleNotFound(function () use ($id, $title, $content, $physical, $namelt, $idfile, $description,
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
			$company,

		) {
			return $this->service->update($id, $title, $content, $this->userId, $physical, $namelt, $idfile, $description,
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
			$company,

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
