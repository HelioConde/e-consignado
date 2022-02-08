<?php

$dados = http_build_query(array(
'script_case_init'      => '5667',
'nmgp_opcao'            => 'busca',
'cod_matricula_cond'    => 'eq',
'cod_matricula'         => '',
'nom_servidor_cond'     => 'qp',
'nom_servidor'          => '',
'cod_cpf_cond'          => 'eq',
'cod_cpf'               => '009.889.694-67',
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
        'header' => "Cookie: PHPSESSID=4372cda3a6f16ef611c91d28f76880fc\n" .
        "Content-type: application/x-www-form-urlencoded\r\n"
        . "Content-Length: " . strlen($dados) . "\r\n",
    )
));
/*
    'method' => "POST",
    'header' => "Cookie: PHPSESSID=cbb4d82973dda2101878a6fd734531e3\n" .
    "Authorization: Bearer sdf541gs6df51gsd1bsb16etb16teg1etr1ge61g\n" .
    "Content-Type: application/x-www-form-urlencoded",
    'content' => $data*/
    
$resposta = file_get_contents('https://econtact.tech/ConsultaServidor/', true, $contexto);
$resposta = str_replace('document.Fredir.action = "/DadosServidor/"','document.Fredir.action = "https://econtact.tech/DadosServidor/"',$resposta);

echo $resposta;

?>