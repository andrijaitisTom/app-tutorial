<?php

namespace OCA\NotesTutorial\Controller;

use OCA\NotesTutorial\AppInfo\Application;
use OCA\NotesTutorial\Service\PoliciesandinstructionsService;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class PoliciesandinstructionsApiController extends ApiController {
	/** @var PoliciesandinstructionsService */
	private $service;

	/** @var string */
	private $userId;

	use Errors;

	public function __construct(IRequest $request,
							PoliciesandinstructionsService $service,
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
	string $typePi,
	string $approvalDate,
	string $responsibleUnit,
	string $validity,
	string $owner,
	string $relation,
	string $namelt,
	string $area,
	): DataResponse {
		return new DataResponse($this->service->create($this->userId, $idfile, 
		$name,
		$title,
		$typePi,
		$approvalDate,
		$responsibleUnit,
		$validity,
		$owner,
		$relation,
		$namelt,
		$area,
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
	string $typePi,
	string $approvalDate,
	string $responsibleUnit,
	string $validity,
	string $owner,
	string $relation,
	string $namelt,
	string $area,
						   ): DataResponse {
		return $this->handleNotFound(function () use ($id, $idfile, 
		$name,
		$title,
		$typePi,
		$approvalDate,
		$responsibleUnit,
		$validity,
		$owner,
		$relation,
		$namelt,
		$area,
		) {
			return $this->service->update($id, $this->userId, $idfile,
			$name,
			$title,
			$typePi,
			$approvalDate,
			$responsibleUnit,
			$validity,
			$owner,
			$relation,
			$namelt,
			$area,
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
