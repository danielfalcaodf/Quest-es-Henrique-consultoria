<?php
    include './config.php';
    include './database.php';
 
    $db = new Banco();
    $log = $db->getLog();
    $log['Insert'] = $db->insertDB('cadastro', ['nome' => 'Teste Teste','email'=>'teste@teste.com','estado' => 'SP', 'comentarios'=> 'Desativado']);
    $log['Questao 2'] = $db->selectDB('cadastro');
    $log['Questao 3'] = $db->selectDB('cadastro', ['estado' => 'SP']);
    $log['Questao 5'] = $db->selectQueryDB("SELECT distinct email FROM cadastro");
    $log['Questao 6'] = $db->updateDB('cadastro', ['nome'=> 'XX'],['estado'=>'SP']);
    $log['Questao 4'] = $db->forceDeleteWhereDB('cadastro', ['estado' => 'SP', 'comentarios'=> 'Desativado']);
    echo json_encode($log);
?>