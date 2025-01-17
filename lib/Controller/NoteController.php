<?php

namespace OCA\DmsApp\Controller;

use OCA\DmsApp\AppInfo\Application;
use OCA\DmsApp\Service\NoteService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class NoteController extends Controller {
	/** @var NoteService */
	private $service;

	/** @var string */
	private $userId;

	use Errors;

	public function __construct(IRequest $request,
								NoteService $service,
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
	public function create(string $title, string $content, string $physical, string $namelt, string $idfile): DataResponse {
		return new DataResponse($this->service->create($title, $content,
			$this->userId, $physical, $namelt, $idfile));
	}

	/**
	 * @NoAdminRequired
	 */
	public function update(int $id, string $title,
						   string $content, string $physical, string $namelt, string $idfile): DataResponse {
		return $this->handleNotFound(function () use ($id, $title, $content, $physical, $namelt, $idfile) {
			return $this->service->update($id, $title, $content, $this->userId, $physical, $namelt, $idfile);
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
