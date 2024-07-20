<?php

header('Content-Type: application/json');

// Read the JSON file
$jsonData = file_get_contents('../data/urls.json');
$urlData = json_decode($jsonData, true);

// Get the URL and code from the request
$code = strip_tags($_GET['code']);
$passphrase = strip_tags($_GET['passphrase']);

// Check if the inputs are legal, url filter for url and only sting for code
if (empty($code)) {
	$response = [
		'status' => 'error',
		'message' => 'Code are required',
		'data' => null
	];
	echo json_encode($response);
	exit;
}

// Check if the code is already used
if (!array_key_exists($code, $urlData)) {
	$response = [
		'status' => 'error',
		'message' => 'Code not used',
		'data' => null
	];
	echo json_encode($response);
	exit;
}

// Verify passphrase
if (!password_verify($passphrase, $urlData[$code]["passphrase"])) {
	$response = [
		"status"=> "error",
		"message"=> "Invalid passphrase",
		"data"=> null
		];
		echo json_encode($response);
		exit;
}

// Delete code
unset($urlData[$code]);

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
	'message' => 'URL deleted successfully',
	'data' => null
];

echo json_encode($response);
