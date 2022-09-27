<?php

namespace OCA\DmsApp\Controller;

use OCA\DmsApp\AppInfo\Application;
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
		Util::addScript(Application::APP_ID, 'dmsapp-main');
		\OCP\Util::addScript('dmsapp', 'dmsapp-main');
		\OCP\Util::addStyle('dmsapp', 'style');

		$response = new TemplateResponse('dmsapp', 'main');

		$csp = new ContentSecurityPolicy();
        $csp->allowEvalScript(true);
        $response->setContentSecurityPolicy($csp);

		return $response;
	}
}
