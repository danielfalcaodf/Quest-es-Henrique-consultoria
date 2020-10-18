<?php
// css


$minCSS = new \MatthiasMullie\Minify\CSS();
$minCSS->add(dirname(__DIR__, 1) . "/vendor/twbs/bootstrap/dist/css/bootstrap.min.css");
$minCSS->add(dirname(__DIR__, 1) . "/vendor/fortawesome/font-awesome/css/all.min.css");
$minCSS->add(dirname(__DIR__, 1) . "/views/assets/css/styles.css");
$minCSS->minify(dirname(__DIR__, 1) . "/views/assets/css/styles.min.css");

// // js

$minJS = new MatthiasMullie\Minify\JS();

$minJS->add(dirname(__DIR__, 1) . "/vendor/components/jquery/jquery.min.js");
$minJS->add(dirname(__DIR__, 1) . "/vendor/components/jqueryui/jquery-ui.min.js");
$minJS->add(dirname(__DIR__, 1) . "/vendor/igorescobar/jquery-mask-plugin/dist/jquery.mask.min.js");
$minJS->add(dirname(__DIR__, 1) . "/vendor/twbs/bootstrap/dist/js/bootstrap.min.js");
$minJS->minify(dirname(__DIR__, 1) . "/views/assets/js/scripts.min.js");