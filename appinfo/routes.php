<?php

return [
	'resources' => [
		'note' => ['url' => '/notes'],
		'note_api' => ['url' => '/api/0.1/notes'],
		
		'agreement' => ['url' => '/agreements'],
		'agreement_api' => ['url' => '/api/0.1/agreements'],

		'contract' => ['url' => '/contracts'],
		'contract_api' => ['url' => '/api/0.1/contracts'],

		'mbdecision' => ['url' => '/mbdecisions'],
		'mbdecision_api' => ['url' => '/api/0.1/mbdecisions'],

		'ceoresolution' => ['url' => '/ceoresolutions'],
		'ceoresolution_api' => ['url' => '/api/0.1/ceoresolutions'],

		'sbdecision' => ['url' => '/sbdecisions'],
		'sbdecision_api' => ['url' => '/api/0.1/sbdecisions'],

		'outsourcingagreement' => ['url' => '/outsourcingagreements'],
		'outsourcingagreement_api' => ['url' => '/api/0.1/outsourcingagreements'],

		'plciesninstrctns' => ['url' => '/plciesninstrctns'],
		'plciesninstrctns_api' => ['url' => '/api/0.1/plciesninstrctns'],

		'sntorrcvddoc' => ['url' => '/sntorrcvddocs'],
		'sntorrcvddoc_api' => ['url' => '/api/0.1/sntorrcvddocs'],

		'directory' => ['url' => '/directories']

		
	],
	'routes' => [
		['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'upload#checkChunk', 'url' => '/upload', 'verb' => 'GET'],
		['name' => 'upload#upload', 'url' => '/upload', 'verb' => 'POST'],
		['name' => 'note_api#preflighted_cors', 'url' => '/api/0.1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
		['name' => 'agreement_api#preflighted_cors', 'url' => '/api/0.1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
		['name' => 'contract_api#preflighted_cors', 'url' => '/api/0.1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
		['name' => 'mbdecision_api#preflighted_cors', 'url' => '/api/0.1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
		['name' => 'ceoresolution_api#preflighted_cors', 'url' => '/api/0.1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
		['name' => 'sbdecision_api#preflighted_cors', 'url' => '/api/0.1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
		['name' => 'outsourcingagreement_api#preflighted_cors', 'url' => '/api/0.1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
		['name' => 'plciesninstrctns_api#preflighted_cors', 'url' => '/api/0.1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
		['name' => 'sntorrcvddoc_api#preflighted_cors', 'url' => '/api/0.1/{path}',
			'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
			['name' => 'page#index', 'url' => '/files', 'verb' => 'GET', 'postfix' => 'files'],
			['name' => 'page#index', 'url' => '/filters', 'verb' => 'GET', 'postfix' => 'filters'],
			['name' => 'file#index', 'url' => '/nodelist', 'verb' => 'GET'],
			['name' => 'file#content', 'url' => '/nodelist/{dir}', 'verb' => 'GET', 'requirements' => ['dir' => '.+']],
			['name' => 'filter#search', 'url' => '/search', 'verb' => 'POST'],


	]


	
];
