<?php
$cookies = 'f9c9fca3a0551fad74a821f2d589a3ac';

$url_path = 'https://econtact.tech/grid_tbl_telefone_servidor/';

$dados = http_build_query(array(
    'nmgp_parms'=>'under_dashboard*scin1*scoutSC_glo_par_cod_cpf*scincod_cpf*scout'
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

$resposta = file_get_contents($url_path, true, $contexto);
$telefone = "";
for ($i = 1; $i <= substr_count($resposta,'id_sc_field_num_ddd_'); $i++){
    $telefone = $telefone.'"'.$i.'": [';
    $str1 = strpos($resposta,'id="id_sc_field_num_ddd_'.$i) + 27;
    $str11 = substr($resposta,$str1);
    $str2 = strpos($str11,'</span>') ;
    $str4 = str_replace('<span id="id_sc_field_num_telefone_'.$i.'">','',substr($resposta,$str1,$str2));
    $str5 = str_replace('<','',$str4);
    $str1 = strpos($resposta,'id="id_sc_field_num_telefone_'.$i) + 32;
    $str11 = substr($resposta,$str1);
    $str2 = strpos($str11,'</span>');
    $str4 = str_replace('<span id="id_sc_field_num_telefone_'.$i.'">','',substr($resposta,$str1,$str2));
    $str55 = str_replace('<','',$str4);
    $telefone =  $telefone.'"'.$str5.$str55.'"';
    $telefone = $telefone.'],';
}

$telefone = '{'.$telefone.'}';
echo str_replace('],}', ']}', $telefone);
