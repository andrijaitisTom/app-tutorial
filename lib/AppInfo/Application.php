<?php

namespace OCA\DmsApp\AppInfo;

use OCP\AppFramework\App;

class Application extends App {
	public const APP_ID = 'dmsapp';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}
}
