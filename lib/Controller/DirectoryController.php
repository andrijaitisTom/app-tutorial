<?php

namespace OCA\NotesTutorial\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\NotesTutorial\Service\NoteNotFound;
use OCA\NotesTutorial\Service\DirectoryService;

class DirectoryController extends Controller {
    /** @var DirectoryService */
    private $service;

    /** @var string */
    private $userId;

    use Errors;

    public function __construct($appName,
                                IRequest $request,
                                DirectoryService $service,
                                $userId) {
        parent::__construct($appName, $request);
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
    public function create(string $path): DataResponse {
        return new DataResponse($this->service->create($this->userId, $path));
    }

    /**
     * @NoAdminRequired
     */
    public function update(int $id, string $path): DataResponse {
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
