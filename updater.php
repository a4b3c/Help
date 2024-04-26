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

$custom = get_data_from_url("https://raw.githubusercontent.com/IranianCypherpunks/Xray/main/Sub");
$normal = get_data_from_url("https://c26.sub-v2.workers.dev/sub");
$domains = explode("\n", get_data_from_url("https://raw.githubusercontent.com/Msyagop/cf-clean-domain/main/iran.txt"));

$additional_data = get_data_from_url("https://raw.githubusercontent.com/a4b3c/Help/main/manual");

if ($additional_data !== null) {
    foreach ($additional_data as $item) {
        $custom .= $item; 
    }
} else {
    echo "Failed to decode additional data JSON.";
}

replace_and_save($custom, $domains, 'custom');
replace_and_save($normal, $domains, 'normal');

?>
