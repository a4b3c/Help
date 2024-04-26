<?php

function get_data_from_url($url) {
    $response = file_get_contents($url);
    if ($response !== false) {
        return $response;
    } else {
        echo "Failed to fetch data from $url";
        return false;
    }
}

function replace_and_save($text, $domains, $filename) {
    $content = preg_replace_callback('/speedtest\.net/', function($matches) use ($domains) {
        return $domains[array_rand($domains)];
    }, $text);
    file_put_contents($filename, $content);
    echo "Data saved to $filename";
}

$custom_data = [];

$custom_json = get_data_from_url("https://raw.githubusercontent.com/IranianCypherpunks/Xray/main/Sub");
$custom_data[] = json_decode($custom_json, true);

$normal = get_data_from_url("https://c26.sub-v2.workers.dev/sub");
$domains = explode("\n", get_data_from_url("https://raw.githubusercontent.com/Msyagop/cf-clean-domain/main/iran.txt"));

// Fetching additional data from the URL and appending it to the custom data array
$additional_json = get_data_from_url("https://raw.githubusercontent.com/a4b3c/Help/main/manual");
$additional_data = json_decode($additional_json, true);

if ($additional_data !== null) {
    foreach ($additional_data as $item) {
        $custom_data[] = $item;
    }
} else {
    echo "Failed to decode additional data JSON.";
}

file_put_contents('custom', json_encode($custom_data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

replace_and_save($normal, $domains, 'normal');

?>
