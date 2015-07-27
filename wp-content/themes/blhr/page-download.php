<?php
/*
Template Name: Download
*/
$filename = $_GET['file'];
if ($filename && file_exists($filename)) {
    $file = file_get_contents($filename);
    $size = filesize($filename);
    header('Content-Disposition: attachment; filename=' . basename($filename));
    header('Content-type: application/force-download');
    header('Content-Length: ' . $size);
    header('Content-type: application/octetstream');
    echo $file;
} else {
    header("HTTP/1.0 404 Not Found");
    global $wp_query;
    $wp_query->set_404();
    require TEMPLATEPATH . '/404.php';
}
