<?php

namespace OCA\NotesTutorial\Controller;

use OCA\NotesTutorial\AppInfo\Application;
use OCA\NotesTutorial\Service\SbdecisionService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class SbdecisionController extends Controller {
	/** @var SbdecisionService */
	private $service;

	/** @var string */
	private $userId;

	use Errors;

	public function __construct(IRequest $request,
						SbdecisionService $service,
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
	string $dateOfTheDocument,
	string $physicalLocation,
	string $validity,
	string $form,
	string $documentStatus,
	string $participants,
	string $registrationNumberCdrsbd,
	string $decisionType,
	string $relation,
	string $namelt,
	): DataResponse {
		return new DataResponse($this->service->create($this->userId, $idfile,
		$name,
		$title,
		$dateOfTheDocument,
		$physicalLocation,
		$validity,
		$form,
		$documentStatus,
		$participants,
		$registrationNumberCdrsbd,
		$decisionType,
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
	string $dateOfTheDocument,
	string $physicalLocation,
	string $validity,
	string $form,
	string $documentStatus,
	string $participants,
	string $registrationNumberCdrsbd,
	string $decisionType,
	string $relation,
	string $namelt,
						   ): DataResponse {
		return $this->handleNotFound(function () use ($id, $idfile,
		$name,
		$title,
		$dateOfTheDocument,
		$physicalLocation,
		$validity,
		$form,
		$documentStatus,
		$participants,
		$registrationNumberCdrsbd,
		$decisionType,
		$relation,
		$namelt,
		) {
			return $this->service->update($id, $this->userId, $idfile,
			$name,
			$title,
			$dateOfTheDocument,
			$physicalLocation,
			$validity,
			$form,
			$documentStatus,
			$participants,
			$registrationNumberCdrsbd,
			$decisionType,
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
