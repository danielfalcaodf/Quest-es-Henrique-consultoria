<?php
// site config
define("SITE", [

    "nome" => "Teste Prático Henrique Consultoria Tributária",
    "desc" => "Processo seletivo para a vaga de Analista de Sistemas na empresa Henrique Consultoria Tributária",
    "domain" => "localauth.com",
    "locale" => "pt_BR",
    "root" => "https://localhost/TestePratico-Henrique-consultoria/LP-hct/LP-composer"

]);
// site minify
if ($_SERVER['SERVER_NAME'] == "localhost") {
    require __DIR__ . "/Minify.php";
}

// database criado
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "",
    "port" => "",
    "dbname" => "",
    "username" => "",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);