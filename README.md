# Tropic Skincare API PHP Client Library (SDK)

## Description

This composer package allows you to communicate with the Tropic web services.



## Installation

In order to install this package via composer, you need to first add the private repository to your composer.json file:

	"repositories" : [
    	{
    		"type": "vcs",
    		"url" : "https://github.com/behindthedot/tropic-php-sdk.git"
    	}
    ]

You can then install this package in the usual way:

	composer require behindthedot/tropic-php-sdk


## User Authentication Using Tropic ID (Id)

To obtain an access token via user authentication, follow these examples


### Redirect to ID login page

The following example shows how to get the URL for redirection to the Tropic ID service to allow the user to enter their login details and authorise access.

	<?php

	use \TropicSkincare\Id\Service as TropicId;
	use \TropicSkincare\Id\Authenticator;


	// Setup the OAuth config properties
	TropicId::setCallbackUrl('<your_callback_url>');
	TropicId::setClientId('<the_oauth_client_id>');
	TropicId::setClientSecret('<the_oauth_client_secret>');


	// Generate a random state token to verify the response from the Oauth
	// system matches our request
	// (Hint, you'll need to store this is a session variable)
	$verificationToken = Authenticator::makeVerificationToken();


	// Get the redirect URL to start authentication
	// (By default the scope is '*', you can override that with 
	// a 2nd parameter to this method)
	$redirectUrl = Authenticator::getAuthUrl($verificationToken);

	header("Location: $redirectUrl");

	?>


### Authentication Callback

When the user authentication has completed, they will be redirected to your *callback* URL, the callback URL contains a `code` parameter which can be exchanged for a bearer token.

	<?php

	use \TropicSkincare\Id\Service as IdService;
	use \TropicSkincare\Id\Authenticator;


	// Setup the OAuth
	IdService::setCallbackUrl('<your_callback_url>');
	IdService::setClientId('<the_oauth_client_id>');
	IdService::setClientSecret('<the_oauth_client_secret>');


	// Get parameters
	$code = $_GET['code'];
	$state = $_GET['state'] // <the_state_token>;


	$bearerToken = Authenticator::convertAccessCodeToBearerToken($code, <the_state_token>);


	print_r($bearerToken);

	/**	
	 Output:
	 
	 stdClass Object
		(
    		[token_type] => Bearer
    		[expires_in] => 31536000
    		[access_token] => eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz[...]
		)
	 */

	?>

The access token can now be used with subsequent API requests as detailed below.


## Using a bearer token

If you follow the user access process above, or have a long-expiry access token, then you can use it with the SDK in the following way: 

	<?php

	use \TropicSkincare\Api\Service as ApiService;

	ApiService::setBearerToken('<bearer_access_token>');

	// Further API requests are now authorised

	?>


## Tropic Payments (Pay)

Example calls below. For full Pay API documentation go to http://api.pay.tropicskincare.local/docs


### Payment Demands

#### Get all payment demands

	<?php

	$demands = \TropicSkincare\Pay\Demand::all();

	?>

#### Get a single payment demand

	<?php

	$demand = \TropicSkincare\Pay\Demand::find('<payment_demand_id>');

	?>


#### Create a payment demand

	<?php

	$demand = \TropicSkincare\Pay\Demand::create([
		'vendor_id' => '01295728-4607-4873-b2bd-0d1e249b705d',
		'amount' => 65.00,
		'delivery_method' => 'email',
		'vendor_name' => 'Bob Flemming',
		'vendor_email' => 'bob@behindthedot.com',
		'recipient_name' => 'Ed Raynham',
		'recipient_email' => 'ed@behindthedot.com',
		'message' => 'Thanks for your order, Ed!'
	]);

	?>

## Tropic Stem (Stem)

*Coming soon*


## Development/Local Environment

You can override the default URLs and bearer tokens for individual web services, this allows you to use this client library with local development and production services

	<?php

	use \TropicSkincare\Api\Service as ApiService;

	// Set a service URL (Example 1 - Set for multiple services)
	ApiService::setServiceUrls([
		'<serviceName>' => '<URL>',
		'<serviceName>' => '<URL>',
	]);


	// Set a service URL (Example 2 - Set for one service)
	ApiService::setServiceUrl('<service_name>', '<url>');


	// Set the bearer token for the specific service
	ApiService::setBearerToken('<bearer_token>', '<url>');

	?>