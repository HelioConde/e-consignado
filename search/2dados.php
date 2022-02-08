<?php
$cookies = 'f9c9fca3a0551fad74a821f2d589a3ac';

$dados = http_build_query(array(
    'nmgp_parms'        => '',
    'nmgp_url_saida'    => '',
    'script_case_init'  => ''
));

$contexto = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'content' => $dados,
        'User-agent'=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36',
        'header' => "Cookie: PHPSESSID=$cookies\r\n" .
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\r\n" .
        "Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7\r\n" .
        "Content-Type: application/x-www-form-urlencoded\r\n" . 
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36\r\n" . 
        "Referer: https://econtact.tech\r\n",
        "Origin: https://econtact.tech\r\n"
    )
));

$resposta = file_get_contents('https://econtact.tech/DadosServidor/', true, $contexto);

$str1 = strpos($resposta,'id="id_read_on_nom_servidor') + 96;
$str11 = substr($resposta,$str1);
$str2 = strpos($str11,'</span>') ;
$str3 = substr($resposta,$str1,$str2);
$str5 = str_replace('<','',$str3);
$nome = $str5;
$data = substr($resposta,strpos($resposta,'id="id_sc_field_dta_nascimento"') + 71,10);

if (substr($data, 3) == 'size=10'){
    $data = '10/10/1010';
}

echo '{
    "nome": "'.$nome.'",
    "data": "'.$data.'"
}';
