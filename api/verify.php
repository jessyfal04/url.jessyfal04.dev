<?php

header('Content-Type: application/json');

function isValidCode($input) {
    // Use a regular expression to check if the string contains only allowed characters
    return preg_match('/^[a-zA-Z0-9_-]+$/', $input) === 1;
}

$jsonData = file_get_contents('../data/urls.json');
$urlData = json_decode($jsonData, true);

$code = strip_tags($_GET['code']);

if (empty($code)) {
	$response = [
		'status' => 'error',
		'message' => 'Code is required',
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


if (array_key_exists($code, $urlData)) {
	$response = [
		'status' => 'success',
		'message' => 'Code exists',
		'data' => [
			"exists" => 1,
			'visits' => $urlData[$code]['count'],
			'url' => $urlData[$code]['url']
		]
	];
} else {
	$response = [
		'status' => 'success',
		'message' => 'Code does not exist',
		'data' => [
			"exists" => 0,
		]
	];
}

echo json_encode($response);
exit;