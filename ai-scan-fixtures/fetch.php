<?php

header('Content-Type: text/plain; charset=UTF-8');

if (!isset($_GET['url'])) {
    http_response_code(400);
    exit("A url parameter is required.\n");
}

$request = curl_init($_GET['url']);
curl_setopt($request, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 3);
curl_setopt($request, CURLOPT_TIMEOUT, 5);
$response = curl_exec($request);

if ($response === false) {
    http_response_code(502);
    exit("Upstream request failed: ".curl_error($request)."\n");
}

echo $response;
