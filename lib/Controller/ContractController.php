<?php

namespace OCA\NotesTutorial\Controller;

use OCA\NotesTutorial\AppInfo\Application;
use OCA\NotesTutorial\Service\ContractService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class ContractController extends Controller {
	/** @var ContractService */
	private $service;

	/** @var string */
	private $userId;

	use Errors;

	public function __construct(IRequest $request,
						ContractService $service,
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
string $registrationNumberContract,
string $description,
string $date,
string $inForceUntil,
string $counterparties,
string $corporateOwner,
string $personalOwner,
string $it,
string $outsourcing,
string $materiality,
string $lastRiskAssessmentDate,
string $documentType,
string $physicalLocation,
string $comments,
string $relation,
string $namelt,
	): DataResponse {
		return new DataResponse($this->service->create($this->userId, $idfile,
		$name,
$title,
$registrationNumberContract,
$description,
$date,
$inForceUntil,
$counterparties,
$corporateOwner,
$personalOwner,
$it,
$outsourcing,
$materiality,
$lastRiskAssessmentDate,
$documentType,
$physicalLocation,
$comments,
$relation,
$namelt,
		));
	}

	/**
	 * @NoAdminRequired
	 */
	public function update(int $id, string $idfile, 
	string $name,
string $title,
string $registrationNumberContract,
string $description,
string $date,
string $inForceUntil,
string $counterparties,
string $corporateOwner,
string $personalOwner,
string $it,
string $outsourcing,
string $materiality,
string $lastRiskAssessmentDate,
string $documentType,
string $physicalLocation,
string $comments,
string $relation,
string $namelt,
						   ): DataResponse {
		return $this->handleNotFound(function () use ($id, $idfile,
		$name,
$title,
$registrationNumberContract,
$description,
$date,
$inForceUntil,
$counterparties,
$corporateOwner,
$personalOwner,
$it,
$outsourcing,
$materiality,
$lastRiskAssessmentDate,
$documentType,
$physicalLocation,
$comments,
$relation,
$namelt,
		) {
			return $this->service->update($id, $this->userId, $idfile,
			$name,
$title,
$registrationNumberContract,
$description,
$date,
$inForceUntil,
$counterparties,
$corporateOwner,
$personalOwner,
$it,
$outsourcing,
$materiality,
$lastRiskAssessmentDate,
$documentType,
$physicalLocation,
$comments,
$relation,
$namelt,
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
