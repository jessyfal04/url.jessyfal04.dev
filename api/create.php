<?php

header('Content-Type: application/json');

function ensureHttps($url) {
    // Check if the URL already starts with 'https://'
    if (substr($url, 0, 8) !== 'https://') {
        // Remove 'http://' if it exists
        if (substr($url, 0, 7) === 'http://') {
            $url = substr($url, 7);
        }
        // Prepend 'https://'
        $url = 'https://' . $url;
    }
    return $url;
}

function isValidCode($input) {
    // Use a regular expression to check if the string contains only allowed characters
    return preg_match('/^[a-zA-Z0-9_-]+$/', $input) === 1;
}

// Read the JSON file
$jsonData = file_get_contents('../data/urls.json');
$urlData = json_decode($jsonData, true);

// Get the URL and code from the request
$url = ensureHttps(strip_tags($_GET['url']));
$code = strip_tags($_GET['code']);
$passphrase = strip_tags($_GET['passphrase']);

// Check if the inputs are legal, url filter for url and only sting for code
if (empty($url) || empty($code)) {
	$response = [
		'status' => 'error',
		'message' => 'URL and code are required',
		'data' => null
	];
	echo json_encode($response);
	exit;
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
	$response = [
		'status' => 'error',
		'message' => 'URL invalid',
		'data' => null
	];
	echo json_encode($response);
	exit;
}

if (!isValidCode($code)) {
	$response = [
		'status' => 'error',
		'message' => 'Code invalid',
		'data' => null
	];
	echo json_encode($response);
	exit;
}

// Check if the code is protected
$protectedCodes = ['data', 'api', 'res']; // Add your protected codes here
if (in_array($code, $protectedCodes)) {
	$response = [
		'status' => 'error',
		'message' => 'Code is protected',
		'data' => null
	];
	echo json_encode($response);
	exit;
} 

// Check if the code is already used
if (array_key_exists($code, $urlData)) {
	$response = [
		'status' => 'error',
		'message' => 'Code already used',
		'data' => null
	];
	echo json_encode($response);
	exit;
}


// Create a new entry in the URL data
$urlData[$code] = [
	'url' => $url,
	'passphrase' => password_hash($passphrase, PASSWORD_BCRYPT),
	'count' => 0
];

// Encode the updated URL data back to JSON
$updatedJsonData = json_encode($urlData, JSON_PRETTY_PRINT);

// Write the updated JSON data back to the file
$writted = file_put_contents('../data/urls.json', $updatedJsonData);
if (!$writted) {
	$response = [
		'status' => 'error',
		'message' => 'Impossible to write',
		'data' => null
	];
	echo json_encode($response);
	exit;
}

$response = [
	'status' => 'success',
	'message' => 'Redirection created successfully',
	'data' => null
];

echo json_encode($response);
