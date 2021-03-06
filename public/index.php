<?php

$config = include __DIR__ . '/../config.php';

date_default_timezone_set($config['dateTimezone']);

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => $config['displayErrors'],
	],
]);

$container = $app->getContainer();

require_once __DIR__ . '/../container.php';

require_once __DIR__ . '/../app/routes.php';

$app->run();