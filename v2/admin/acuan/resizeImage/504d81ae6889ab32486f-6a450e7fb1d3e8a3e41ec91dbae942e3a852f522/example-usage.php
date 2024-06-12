<?php

// Resize Exact Size
$resize = new ResizeImage('images/Be-Original.jpg');
$resize->resizeTo(100, 100, 'exact');
$resize->saveImage('images/be-original-exact.jpg');

// Resize Max Width Size
$resize = new ResizeImage('images/Be-Original.jpg');
$resize->resizeTo(100, 100, 'maxWidth');
$resize->saveImage('images/be-original-maxWidth.jpg');

// Resize Max Height Size
$resize = new ResizeImage('images/Be-Original.jpg');
$resize->resizeTo(100, 100, 'maxHeight');
$resize->saveImage('images/be-original-maxHeight.jpg');

// Resize Auto Size From Given Width And Height
$resize = new ResizeImage('images/Be-Original.jpg');
$resize->resizeTo(100, 100);
$resize->saveImage('images/be-original-default.jpg');

// Download The Resized Image
$resize = new ResizeImage('images/Be-Original.jpg');
$resize->resizeTo(100, 100, 'exact');
$resize->saveImage('images/be-original-exact.jpg', "100", true);

?>