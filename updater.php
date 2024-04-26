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

$frag_data = get_data_from_url("https://raw.githubusercontent.com/IranianCypherpunks/Xray/main/Sub");
$manual_data = get_data_from_url("https://raw.githubusercontent.com/a4b3c/Help/main/manual");
$normal = get_data_from_url("https://c26.sub-v2.workers.dev/sub");
$domains = explode("\n", get_data_from_url("https://raw.githubusercontent.com/Msyagop/cf-clean-domain/main/iran.txt"));

$custom_data = array();

$custom_data[] = json_decode($frag_data, true); // Assuming data from "frag" is JSON
$custom_data[] = json_decode($manual_data, true); // Assuming data from "manual" is JSON

// Merge additional data to the custom data array
// $custom_data = array_merge($custom_data, json_decode($additional_data, true)); // Assuming additional data is JSON

// Convert the custom data array to JSON format
$custom_json = json_encode($custom_data);

replace_and_save($custom_json, $domains, 'custom');

replace_and_save($normal, $domains, 'normal');

?>
