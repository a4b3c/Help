<?php
// File paths
$ipsFile = 'ips.txt';
$domainsFile = 'domains.txt';
$outputFile = 'normal';

// Read the content of the ips.txt and domains.txt
$ips = file($ipsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$domains = file($domainsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Check if both files are not empty
if (empty($ips) || empty($domains)) {
    die("Error: Either ips.txt or domains.txt is empty.\n");
}

// Template text with placeholders
$template = 'vless://d342d11e-d424-4583-b36e-524ab1f0afa4@$ips:443?path=%2F7ghW%3Fed%3D2048&security=tls&encryption=none&alpn=http/1.1&host=$domains&fp=randomized&type=ws&sni=$domains#Server+-+$serverNumber';

// Open the output file for writing
$output = fopen($outputFile, 'w');

if (!$output) {
    die("Error: Unable to open output file for writing.\n");
}

// Counter for the server number
$serverNumber = 1;

// Loop through the domains and replace placeholders in the template
foreach ($domains as $domainIndex => $domain) {
    // Get the corresponding IP (use modulo to loop around IPs if they run out)
    $ip = $ips[$domainIndex % count($ips)];
    
    // Replace placeholders in the template
    $entry = str_replace(
        ['$ips', '$domains', '$serverNumber'], 
        [$ip, $domain, $serverNumber], 
        $template
    );

    // Write the entry to the output file
    fwrite($output, $entry . PHP_EOL);

    // Increment the server number for the next entry
    $serverNumber++;
}

// Close the output file
fclose($output);

echo "Finished writing to $outputFile\n";
