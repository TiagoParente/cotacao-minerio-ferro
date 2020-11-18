<?php

use DOMDocument;

$context = stream_context_create(
    array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
    )
);

$content = file_get_contents("https://w.sinajs.cn/?_=0.7529720317265459&list=nf_I0,nf_I0_i", false, $context);

libxml_use_internal_errors(true);
$dom = new domDocument();
$dom->loadHTML($content);
$dados = explode(',', $dom->textContent);

$ultimo = $dados[7];
$abertura = $dados[10];
$variacao = round(100 - ($abertura / $ultimo * 100), 2);

//Insere o sinal de + no inicio, caso a variação seja positiva
if($variacao > 0){
    $variacao = '+' . $variacao;
}

echo json_encode([
    'ativo' => 'Minerio de Ferro',
    'ultima_atualizacao' => date('d/m/Y H:i:s'),
    'ultimo' => $ultimo,
    'abertura' => $abertura,
    'variacao' => $variacao . '%'
]);