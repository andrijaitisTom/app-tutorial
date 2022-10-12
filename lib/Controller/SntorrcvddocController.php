<?php

namespace OCA\DmsApp\Controller;

use OCA\DmsApp\AppInfo\Application;
use OCA\DmsApp\Service\SntorrcvddocService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class SntorrcvddocController extends Controller {
	/** @var SntorrcvddocService */
	private $service;

	/** @var string */
	private $userId;

	use Errors;

	public function __construct(IRequest $request,
						SntorrcvddocService $service,
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
	string $dateReceiptDate,
	string $sender,
	string $recipient,
	string $recipientEmployee,
	string $documentForm,
	string $documentType,
	string $deliveryMethod,
	string $dateOfTheDocument ,
	string $physicalLocation,
	string $registrationNumberTd,
	string $documentOrganizer,
	string $direction,
	string $relation,
	string $namelt,
	string $company,

	): DataResponse {
		return new DataResponse($this->service->create($this->userId, $idfile,
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
		$company,

		));
	}

	/**
	 * @NoAdminRequired
	 */
	public function update(int $id, string $idfile, 
	string $name,
	string $title,
	string $dateReceiptDate,
	string $sender,
	string $recipient,
	string $recipientEmployee,
	string $documentForm,
	string $documentType,
	string $deliveryMethod,
	string $dateOfTheDocument ,
	string $physicalLocation,
	string $registrationNumberTd,
	string $documentOrganizer,
	string $direction,
	string $relation,
	string $namelt,
	string $company,

						   ): DataResponse {
		return $this->handleNotFound(function () use ($id, $idfile,
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
		$company,

		) {
			return $this->service->update($id, $this->userId, $idfile,
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
