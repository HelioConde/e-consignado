<?php
$cookies = 'f9c9fca3a0551fad74a821f2d589a3ac';
$filtro = $_POST['filtro'];
$filtro2 = '0001';
$filtro3 = '0002';
$filtro4 = '0003';
$filtro5 = '0004';


$url_path = 'https://econtact.tech/grid_tbl_rubrica_servidor/';

$dados = array('
    parms'=>'',
    'nmgp_url_saida'=>'/ConsultaServidor/',
    'script_case_init'=>'6204
');

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

$search = 'false';
$banco = "";
$id = 0;
for ($i = 1; $i <= substr_count($resposta,'id_sc_field_nom_rubrica_'); $i++){
    $str1 = strpos($resposta,'id="id_sc_field_nom_rubrica_'.$i) + 31;
    $str2 = strpos($resposta,'id="id_sc_field_seq_rubrica_'.$i) - 142;
    $str3 = $str2 -$str1;
    $str4 = str_replace('>','',substr($resposta,$str1,$str3));
    $str5 = str_replace('<','',$str4);
    if ($filtro == $str5 || $filtro2 == $str5 || $filtro3 == $str5 || $filtro4 == $str5 || $filtro5 == $str5){
            $banco = $banco.'"'.$id.'": [';
            $banco =  $banco.'"'.$str5.'",';
            $str1 = strpos($resposta,'id="id_sc_field_num_prazo_'.$i) + 29;
            $str2 = strpos($resposta,'id="id_sc_field_val_rubrica_'.$i) - 148;
            $str3 = $str2 -$str1;
            $str4 = str_replace('>','',substr($resposta,$str1,$str3));
            $str5 = str_replace('<','',$str4);
            $banco =  $banco.'"'.$str5.'",';
            $str1 = strpos($resposta,'id="id_sc_field_val_rubrica_'.$i) + 31;
            $str11 = substr($resposta,$str1);
            $str2 = strpos($str11,'</span>');
            $str4 = str_replace('>','',substr($resposta,$str1,$str2));
            $str5 = str_replace('<','',$str4);
            $parcela = $str5;
            $banco =  $banco.'"'. $parcela.'"';
            $search = 'true';
            $banco = $banco.'],';
            $id++;
    }
}

$banco = '{'.$banco.'}';
echo str_replace('],}', ']}', $banco);
