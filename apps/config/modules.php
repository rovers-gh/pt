<?php

/**
 * Register application modules
 */
$application->registerModules(array (
		'frontend' => array (
				'className' => 'Modules\Frontend\Module',
				'path' => APP_PATH . '/frontend/Module.php' 
		) 
));
