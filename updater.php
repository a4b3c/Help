<?php
// Fetch data from https://c26.sub-v2.workers.dev/frag and save it to custom.txt
file_put_contents('custom.txt', file_get_contents('https://c26.sub-v2.workers.dev/frag'));

// Fetch data from https://c26.sub-v2.workers.dev/sub and save it to normal.txt
file_put_contents('normal.txt', file_get_contents('https://c26.sub-v2.workers.dev/sub'));
?>
