<?php

namespace OCA\NotesTutorial\Controller;

use OCA\NotesTutorial\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\Util;
use OCP\AppFramework\Http\ContentSecurityPolicy;


class PageController extends Controller {
	public function __construct(string $AppName, IRequest $request) {
		parent::__construct($AppName, $request);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * Render default template
	 */
	public function index() {
		Util::addScript(Application::APP_ID, 'notestutorial-main');
		\OCP\Util::addScript('notestutorial', 'notestutorial-main');
		\OCP\Util::addStyle('notestutorial', 'style');

		$response = new TemplateResponse('notestutorial', 'main');

		$csp = new ContentSecurityPolicy();
        $csp->allowEvalScript(true);
        $response->setContentSecurityPolicy($csp);

		return $response;
	}
}
