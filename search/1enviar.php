<?php
$cookies = 'f9c9fca3a0551fad74a821f2d589a3ac';
$CPF = $_POST['cpf'];

$dados = http_build_query(array(

    'nmgp_opcao'            => 'busca',
    'cod_matricula_cond'    => 'eq',
    'cod_matricula'         => '',
    'nom_servidor_cond'     => 'qp',
    'nom_servidor'          => '',
    'cod_cpf_cond'          => 'eq',
    'cod_cpf'               => "$CPF",
    'NM_operador'           => 'or',
    'nmgp_tab_label'        => 'cod_matricula%3F%23%3FMATR%C3%8DCULA%3F%40%3Fnom_servidor%3F%23%3FNOME%3F%40%3Fcod_cpf%3F%23%3FCPF%3F%40%3F',
    'bprocessa'             => 'pesq',
    'nmgp_save_name_bot'    => '',
    'NM_filters_del_bot'    => '',
    'form_condicao'         => '3'
));

$contexto = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'content' => $dados,
        'User-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36',
        'header' => "Cookie: PHPSESSID=$cookies\r\n" .
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\r\n" .
            "Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7\r\n" .
            "Content-Type: application/x-www-form-urlencoded\r\n" .
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36\r\n" .
            "Referer: https://econtact.tech\r\n",
        "Origin: https://econtact.tech\r\n"
    )
));

$resposta = file_get_contents('https://econtact.tech/ConsultaServidor/', true, $contexto);

$dados = substr($resposta, 0); 
$str1 = strpos($resposta,'class="scFilterHeaderFont') + 76;
$str11 = substr($resposta,$str1);
$str2 = strpos($str11,'<div class="scFilterHeaderFont" style="float: right;"></div>') - 11;
$str3 = substr($resposta,$str1,$str2);

if ($str3 == "ESQUISA SERVIDOR") {
    echo 'erro';
} else {
    echo 'sucess';
}
