<?php
// Enable error reporting
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ERROR | E_PARSE);

// Function to fetch data from URL and save it to a file
function fetchDataAndSave($url, $filename)
{
    $data = file_get_contents($url);
    if ($data !== false) {
        file_put_contents($filename, $data);
        echo "Data fetched from $url and saved to $filename\n";
    } else {
        echo "Failed to fetch data from $url\n";
    }
}

// Fetch and save data from https://c26.sub-v2.workers.dev/frag to custom.txt
fetchDataAndSave('https://c26.sub-v2.workers.dev/frag', 'custom.txt');

// Fetch and save data from https://c26.sub-v2.workers.dev/sub to normal.txt
fetchDataAndSave('https://c26.sub-v2.workers.dev/sub', 'normal.txt');
?>
