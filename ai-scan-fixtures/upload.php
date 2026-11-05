<?php

header('Content-Type: text/plain; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
    http_response_code(400);
    exit("Upload a file using the file field.\n");
}

if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    exit("Upload failed with error ".$_FILES['file']['error'].".\n");
}

$directory = __DIR__.'/uploads';
if (!is_dir($directory) && !mkdir($directory, 0700)) {
    http_response_code(500);
    exit("Could not create the upload directory.\n");
}

$filename = basename($_FILES['file']['name']);
if ($filename === '' || $filename === '.' || $filename === '..') {
    http_response_code(400);
    exit("Invalid filename.\n");
}

$destination = $directory.'/'.$filename;
if (file_exists($destination)) {
    http_response_code(409);
    exit("A file with that name already exists.\n");
}

if (!move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
    http_response_code(500);
    exit("Could not save the upload.\n");
}

http_response_code(201);
echo "Uploaded to /uploads/".rawurlencode($filename)."\n";
