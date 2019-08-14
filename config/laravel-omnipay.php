<?php

return [

	// The default gateway to use
	'default' => 'paypal',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
            'username'  => 'mohamed.yahya-facilitator_api1.emeriocorp.com',
            'password'  => '3UTMG9XGD989PEB4',
            'signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AMJw9Q3l-gQhgDEdO9AXYyyt4E0D',
            'solutionType' => '',
            'landingPage'    => '',
            'headerImageUrl' => '',
            'brandName' =>  'Your app name',
            'testMode' => true
			]
		]
	]

];