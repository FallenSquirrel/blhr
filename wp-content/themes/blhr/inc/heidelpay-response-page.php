<?php
$parameterNameProcessingResult = 'PROCESSING_RESULT';
$processingResult = '';
if (isset($_POST[$parameterNameProcessingResult])) {
    $processingResult = $_POST[$parameterNameProcessingResult];
}

if ($processingResult && isset($_GET['token']) && isset($_GET['forward']))
{
    $token = $_GET['token'];
    $forwardUrl = $_GET['forward'];

	if ( $processingResult == 'ACK' )
	{
        echo $forwardUrl . (parse_url($forwardUrl, PHP_URL_QUERY) ? '&' : '?') . 'payment_token=' . $token;
	}
	else
	{
		// Error, just return to article page
        echo $forwardUrl;
	}
} else {
    // Error, return to front page
    // This page is addressed directly, so we cannot use WP functions here
    $url = $_SERVER['HTTP_HOST'] . '/';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
        $url = 'https://' . $url;
    } else {
        $url = 'http://' . $url;
    }
    echo $url;
}
