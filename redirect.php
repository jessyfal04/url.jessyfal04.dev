<?php

$jsonData = file_get_contents('data/urls.json');
$urlData = json_decode($jsonData, true);

$requestedUrl = trim($_SERVER['REQUEST_URI'], '/');

if (array_key_exists($requestedUrl, $urlData)) {
    // Add 1 to count
    $urlData[$requestedUrl]["count"] = $urlData[$requestedUrl]["count"] + 1;
    $updatedJsonData = json_encode($urlData, JSON_PRETTY_PRINT);
    file_put_contents('data/urls.json', $updatedJsonData);

    // Redirect to the original URL
    header('Location: ' . $urlData[$requestedUrl]["url"]);
    exit();
} else {
    // Handle 404 - Not Found
	header('Location: ' . "/?error=No redirection found with the code : " . $requestedUrl);
    exit();
}