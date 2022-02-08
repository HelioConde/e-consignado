<style>
    table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table td,
    table th {
        border: 1px solid #ddd;
        padding: 0 8px;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #ddd;
    }

    table th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
        text-align: center;
    }
</style>
<?php

$cookies = '469c113a94cf431af915b9c742f69c02';
$CPF = $_GET['cpf'];


if (strlen($CPF) >= 11) {

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
    $str1 = strpos($resposta, '<form name="Fseg"') - 63;
    $str11 = substr($resposta, $str1);
    $str2 = strpos($str11, '<form name="Fseg"') - 39;
    $str3 = substr($resposta, $str1, $str2);
    $resultado = str_replace('<', '', $str3);
    $send = 0;
    if ($resultado == 'Usuário não autorizado') {
        if ($send == 0) {
            $send++;
        }
    }
    $str1 = strpos($resposta, 'Sua sessão expirou.');
    if ($str1 == 911) {
        if ($send == 0) {
            $send++;
        }
    }


    $str1 = strpos($resposta, 'id="SC_cod_cpf"') + 38;
    $str11 = substr($resposta, $str1);
    $str2 = strpos($str11, $CPF) + 11;
    $str3 = substr($resposta, $str1, $str2);
    $resultado = str_replace('<', '', $str3);

    if ($resultado == $CPF) {
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

        $resposta = file_get_contents('https://econtact.tech/ConsultaPensionista/', true, $contexto);
        echo "<h3 style='text-align:center;margin:auto;'>DADOS PENSIONISTA</h3>";

        $str1 = strpos($resposta, '<form name="Fseg"') - 63;
        $str11 = substr($resposta, $str1);
        $str2 = strpos($str11, '<form name="Fseg"') - 39;
        $str3 = substr($resposta, $str1, $str2);
        $resultado = str_replace('<', '', $str3);

        if ($resultado == 'Usuário não autorizado') {
            if ($send == 0) {
                echo "<script>window.open('https://econtact.tech/app_Login/', '_blank')</script>";
                $send++;
                echo '<script>setTimeout(function(){ window.location.reload() }, 2000)</script>';
            }
        }
        $str1 = strpos($resposta, 'Sua sessão expirou.');
        if ($str1 == 911) {
            if ($send == 0) {
                echo "<script>window.open('https://econtact.tech/app_Login/', '_blank')</script>";
                $send++;
            }
        }


        $str1 = strpos($resposta, 'id="SC_cod_cpf"') + 38;
        $str11 = substr($resposta, $str1);
        $str2 = strpos($str11, $CPF) + 11;
        $str3 = substr($resposta, $str1, $str2);
        $resultado = str_replace('<', '', $str3);


        if ($resultado == $CPF) {
            echo "<h3 style='text-align:center;margin:auto;'>CPF NÃO LOCALIZADO</h3>";
        } else {
            $dados = http_build_query(array(
                'nmgp_parms'        => '',
                'nmgp_url_saida'    => '',
                'script_case_init'  => ''
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

            $resposta = file_get_contents('https://econtact.tech/DadosPensionista/', true, $contexto);

            $str1 = strpos($resposta, 'id="id_read_on_nom_pensionista') + 105;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $str5 = str_replace('<', '', $str3);
            $nome = $str5;
            $data = substr($resposta, strpos($resposta, 'id="id_label_dta_nascimento"') + 185, 10);
            $data1 = substr($resposta, strpos($resposta, 'id="id_label_dta_nascimento"') + 185, 2);
            $data2 = substr($resposta, strpos($resposta, 'id="id_label_dta_nascimento"') + 188, 2);
            $data3 = substr($resposta, strpos($resposta, 'id="id_label_dta_nascimento"') + 191, 4);
            $str1 = strpos($resposta, 'id="id_read_on_oid_orgao"')+62;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $situação = str_replace('<', '', $str3);

            $str1 = strpos($resposta, 'id="id_read_on_cod_matricula_pensionista"')+135;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $matricula = str_replace('<', '', $str3);
            $str1 = strpos($resposta, 'id="id_read_on_cod_matricula_instituidor"')+135;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $matricula2 = str_replace('<', '', $str3);
            $idade = substr($resposta, strpos($resposta, 'id="id_sc_field_dta_nascimento"') + 77, 4);
            $idades = 2021 - $idade;
            echo '<table style="width: 80%;margin: auto; text-align: center;border: 1px solid black;">
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>';
            if (substr($data, 3) == 'size=10') {
                echo '<tr>';
                echo "<td>NOME: " . $nome . '</td>';
                echo '<td>CPF: ' . $CPF . '</td>';
                echo '<td>DATA DE NASCIMENTO: Null</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>IDADE: Null</td>';
                echo "<td>SITUAÇÂO: " . $situação . '</td>';
                echo "<td>Matricula: " . $matricula . '</td>';
                echo '</tr>';
            } else {
                echo '<tr>';
                echo "<td>NOME: " . $nome . '</td>';
                echo '<td>CPF: ' . $CPF . '</td>';
                echo "<td>DATA DE NASCIMENTO: " . $data1 . '/' . $data2 . '/' . $data3 . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>IDADE: ' . $idades . '</td>';
                echo "<td>ÓRGÃO: " . $situação . '</td>';
                echo "<td>MATRÍCULA PENSIONISTA: " . $matricula . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td></td>';
                echo '<td>MATRÍCULA INSTITUIDOR: ' . $matricula2 . '</td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<br>';
            
            $url_path = 'https://econtact.tech/grid_tbl_margem_pensionista/';
            
            $dados = array(
                'parms' => '',
                'nmgp_url_saida' => '/ConsultaPensionista/',
                'script_case_init' => '6204'
            );

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
            $resposta = file_get_contents($url_path, true, $contexto);
            $str1 = strpos($resposta, 'id="id_sc_field_val_margem_5_1"') + 32;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $margin5 = str_replace('<', '', $str3);
            $str1 = strpos($resposta, 'id="id_sc_field_val_margem_30_1"') + 33;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $margin35 = str_replace('<', '', $str3);
            
            echo '<table style="width: 80%;margin: auto; text-align: center;border: 1px solid black;">
            <tr>
                <th>MARGEM 5%</th>
                <th>MARGEM 35%</th>
            </tr>';
            echo '<tr>';
            echo "<td>" . $margin5 . '</td>';
            echo '<td>' . $margin35 . '</td>';
            echo '</tr>';
            echo '</table><br>';
            
            
            $url_path = 'https://econtact.tech/grid_tbl_rubrica_pensionista/';

            $dados = array(
                'parms' => '',
                'nmgp_url_saida' => '/ConsultaPensionista/',
                'script_case_init' => '6204'
            );

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
            $resposta = file_get_contents($url_path, true, $contexto);

            $search = 'false';
            $banco = "";
            $id = 0;

            echo '<table style="width: 80%;margin: auto; text-align: center;border: 1px solid black;">
        <tr>
            <th>Banco</th>
            <th>Parcela</th>
            <th>Valor</th>
        </tr>';
            for ($i = 1; $i <= substr_count($resposta, 'id_sc_field_nom_rubrica_'); $i++) {
                if ($i >= 10){
                    echo '<tr>';
                    $str1 = strpos($resposta, 'id="id_sc_field_nom_rubrica_' . $i .'">') + 32;
                    $str2 = substr($resposta, $str1);
                    $str3 = strpos($str2, '</span>');
                    $str4 = substr($str2,0, $str3);
                    echo '<td>' . $str4 . '</td>';
                    
                    $str1 = strpos($resposta, 'id="id_sc_field_num_prazo_' . $i .'">') + 30;
                    $str2 = substr($resposta, $str1);
                    $str3 = strpos($str2, '</span>');
                    $str4 = substr($str2,0, $str3);
                    echo '<td>' . $str4 . '</td>';
                    
                    $str1 = strpos($resposta, 'id="id_sc_field_val_rubrica_' . $i . '">') + 32;
                    $str2 = substr($resposta, $str1);
                    $str3 = strpos($str2, '</span>');
                    $str4 = substr($str2,0, $str3);
                    echo '<td>' . $str4 . '</td>';
                    $search = 'true';
                    echo '</tr>';
                } else {
                    echo '<tr>';
                    $str1 = strpos($resposta, 'id="id_sc_field_nom_rubrica_' . $i .'">') + 31;
                    $str2 = substr($resposta, $str1);
                    $str3 = strpos($str2, '</span>');
                    $str4 = substr($str2,0, $str3);
                    echo '<td>' . $str4 . '</td>';
                    
                    $str1 = strpos($resposta, 'id="id_sc_field_num_prazo_' . $i .'">') + 29;
                    $str2 = substr($resposta, $str1);
                    $str3 = strpos($str2, '</span>');
                    $str4 = substr($str2,0, $str3);
                    echo '<td>' . $str4 . '</td>';
                    
                    $str1 = strpos($resposta, 'id="id_sc_field_val_rubrica_' . $i . '">') + 31;
                    $str2 = substr($resposta, $str1);
                    $str3 = strpos($str2, '</span>');
                    $str4 = substr($str2,0, $str3);
                    echo '<td>' . $str4 . '</td>';
                    $search = 'true';
                    echo '</tr>';
                }
            }
            echo '</table><br>';

            $url_path = 'https://econtact.tech/grid_tbl_totalizador_pensionista/';

            $contexto = stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
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
            $resposta = file_get_contents($url_path, true, $contexto);
            $str1 = strpos($resposta, 'id="id_sc_field_val_total_rendimento_1"') + 40;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $rendimento = str_replace('<', '', $str3);
            
            $str1 = strpos($resposta, 'id="id_sc_field_val_total_desconto_1"') + 38;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $desconto = str_replace('<', '', $str3);
            
            $str1 = strpos($resposta, 'id="id_sc_field_val_total_liquido_1"') + 37;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $liquido = str_replace('<', '', $str3);
            
            
            echo '<table style="width: 80%;margin: auto; text-align: center;border: 1px solid black;">
            <tr>
                <th>TOTAL RENDIMENTOS</th>
                <th>TOTAL DESCONTOS</th>
                <th>TOTAL LÍQUIDO</th>
            </tr>';
            echo '<tr>';
            echo '<td>'.$rendimento.'</td>';
            echo '<td>'.$desconto.'</td>';
            echo '<td>'.$liquido.'</td>';
            echo '</tr>';
            echo '</table><br>';
            
            $url_path = 'https://econtact.tech/grid_tbl_telefone_servidor/';

            $dados = http_build_query(array(
                'nmgp_parms' => 'under_dashboard*scin1*scoutSC_glo_par_cod_cpf*scincod_cpf*scout'
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

            echo '<table style="width: 80%;margin: auto; text-align: center;">
        <tr>
            <th>Telefones</th>
        </tr>';
            $resposta = file_get_contents($url_path, true, $contexto);
            $telefone = "";
            for ($i = 1; $i <= substr_count($resposta, 'id_sc_field_num_ddd_'); $i++) {
                echo '<tr>';
                $str1 = strpos($resposta, 'id="id_sc_field_num_ddd_' . $i) + 27;
                $str11 = substr($resposta, $str1);
                $str2 = strpos($str11, '</span>');
                $str4 = str_replace('<span id="id_sc_field_num_telefone_' . $i . '">', '', substr($resposta, $str1, $str2));
                $str5 = str_replace('<', '', $str4);
                $str1 = strpos($resposta, 'id="id_sc_field_num_telefone_' . $i) + 32;
                $str11 = substr($resposta, $str1);
                $str2 = strpos($str11, '</span>');
                $str4 = str_replace('<span id="id_sc_field_num_telefone_' . $i . '">', '', substr($resposta, $str1, $str2));
                $str55 = str_replace('<', '', $str4);
                echo '<td>' . $str5 . $str55 . '</td>';
                echo '</tr>';
            }
            echo '</table><br>';
        } 
    } else {

        $dados = http_build_query(array(
            'nmgp_parms'        => '',
            'nmgp_url_saida'    => '',
            'script_case_init'  => ''
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

        $resposta = file_get_contents('https://econtact.tech/DadosServidor/', true, $contexto);
        echo "<h3 style='text-align:center;margin:auto;'>DADOS SERVIDOR</h3>";
        $str1 = strpos($resposta, 'id="id_read_on_nom_servidor') + 96;
        $str11 = substr($resposta, $str1);
        $str2 = strpos($str11, '</span>');
        $str3 = substr($resposta, $str1, $str2);
        $str5 = str_replace('<', '', $str3);
        $nome = $str5;
        $data = substr($resposta, strpos($resposta, 'id="id_sc_field_dta_nascimento"') + 71, 10);
        $data1 = substr($resposta, strpos($resposta, 'id="id_sc_field_dta_nascimento"') + 71, 2);
        $data2 = substr($resposta, strpos($resposta, 'id="id_sc_field_dta_nascimento"') + 74, 2);
        $data3 = substr($resposta, strpos($resposta, 'id="id_sc_field_dta_nascimento"') + 77, 4);
        $str1 = strpos($resposta, 'id="id_read_on_des_situacao_servidor"') + 123;
        $str11 = substr($resposta, $str1);
        $str2 = strpos($str11, '</span>');
        $str3 = substr($resposta, $str1, $str2);
        $situação = str_replace('<', '', $str3);

        $str1 = strpos($resposta, 'id="id_read_on_cod_matricula"') + 99;
        $str11 = substr($resposta, $str1);
        $str2 = strpos($str11, '</span>');
        $str3 = substr($resposta, $str1, $str2);
        $matricula = str_replace('<', '', $str3);
        $idade = substr($resposta, strpos($resposta, 'id="id_sc_field_dta_nascimento"') + 77, 4);
        $idades = 2021 - $idade;
        echo '<table style="width: 80%;margin: auto; text-align: center;border: 1px solid black;">
    <tr>
        <th></th>
        <th></th>
        <th></th>
    </tr>';
        if (substr($data, 3) == 'size=10') {
            echo '<tr>';
            echo '<td>NOME: ' . $nome . '</td>';
            echo '<td>CPF: ' . $CPF . '</td>';
            echo '<td>DATA DE NASCIMENTO: Null</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>IDADE: Null</td>';
            echo "<td>SITUAÇÂO: " . $situação . '</td>';
            echo "<td>Matricula: " . $matricula . '</td>';
            echo '</tr>';
        } else {
            echo '<tr>';
            echo "<td>NOME: " . $nome . '</td>';
            echo '<td>CPF: ' . $CPF . '</td>';
            echo "<td>DATA DE NASCIMENTO: " . $data1 . '/' . $data2 . '/' . $data3 . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>IDADE: ' . $idades . '</td>';
            echo "<td>SITUAÇÂO: " . $situação . '</td>';
            echo "<td>Matricula: " . $matricula . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<br>';
        
        $url_path = 'https://econtact.tech/grid_tbl_margem_servidor/';
            
            $dados = array(
                'parms' => '',
                'nmgp_url_saida' => '/ConsultaPensionista/',
                'script_case_init' => '6204'
            );

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
            $resposta = file_get_contents($url_path, true, $contexto);
            $str1 = strpos($resposta, 'id="id_sc_field_val_margem_5_1"') + 32;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $margin5 = str_replace('<', '', $str3);
            $str1 = strpos($resposta, 'id="id_sc_field_val_margem_30_1"') + 33;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $margin35 = str_replace('<', '', $str3);
            
            echo '<table style="width: 80%;margin: auto; text-align: center;border: 1px solid black;">
            <tr>
                <th>MARGEM 5%</th>
                <th>MARGEM 35%</th>
            </tr>';
            echo '<tr>';
            echo "<td>" . $margin5 . '</td>';
            echo '<td>' . $margin35 . '</td>';
            echo '</tr>';
            echo '</table><br>';
        
        $url_path = 'https://econtact.tech/grid_tbl_rubrica_servidor/';

        $dados = array(
            'parms' => '',
            'nmgp_url_saida' => '/ConsultaServidor/',
            'script_case_init' => '6204'
        );

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
        $resposta = file_get_contents($url_path, true, $contexto);

        $search = 'false';
        $banco = "";
        $id = 0;

        echo '<table style="width: 80%;margin: auto; text-align: center;border: 1px solid black;">
    <tr>
        <th>Banco</th>
        <th>Parcela</th>
        <th>Valor</th>
    </tr>';
        for ($i = 1; $i <= substr_count($resposta, 'id_sc_field_nom_rubrica_'); $i++) {
            echo '<tr>';
            $str1 = strpos($resposta, 'id="id_sc_field_nom_rubrica_' . $i) + 31;
            $str2 = strpos($resposta, 'id="id_sc_field_seq_rubrica_' . $i) - 142;
            $str3 = $str2 - $str1;
            $str4 = str_replace('>', '', substr($resposta, $str1, $str3));
            $str5 = str_replace('<', '', $str4);
            echo '<td>' . $str5 . '</td>';
            $str1 = strpos($resposta, 'id="id_sc_field_num_prazo_' . $i) + 29;
            $str2 = strpos($resposta, 'id="id_sc_field_val_rubrica_' . $i) - 148;
            $str3 = $str2 - $str1;
            $str4 = str_replace('>', '', substr($resposta, $str1, $str3));
            $str5 = str_replace('<', '', $str4);
            echo '<td>' . $str5 . '</td>';
            $str1 = strpos($resposta, 'id="id_sc_field_val_rubrica_' . $i) + 31;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str4 = str_replace('>', '', substr($resposta, $str1, $str2));
            $str5 = str_replace('<', '', $str4);
            $parcela = $str5;
            echo '<td>' . $parcela . '</td>';
            $search = 'true';
            echo '</tr>';
        }
        echo '</table><br>';


            $url_path = 'https://econtact.tech/grid_tbl_totalizador_servidor/';

            $contexto = stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
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
            $resposta = file_get_contents($url_path, true, $contexto);
            $str1 = strpos($resposta, 'id="id_sc_field_val_total_rendimento_1"') + 40;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $rendimento = str_replace('<', '', $str3);
            
            $str1 = strpos($resposta, 'id="id_sc_field_val_total_desconto_1"') + 38;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $desconto = str_replace('<', '', $str3);
            
            $str1 = strpos($resposta, 'id="id_sc_field_val_total_liquido_1"') + 37;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str3 = substr($resposta, $str1, $str2);
            $liquido = str_replace('<', '', $str3);
            
            
            echo '<table style="width: 80%;margin: auto; text-align: center;border: 1px solid black;">
            <tr>
                <th>TOTAL RENDIMENTOS</th>
                <th>TOTAL DESCONTOS</th>
                <th>TOTAL LÍQUIDO</th>
            </tr>';
            echo '<tr>';
            echo '<td>'.$rendimento.'</td>';
            echo '<td>'.$desconto.'</td>';
            echo '<td>'.$liquido.'</td>';
            echo '</tr>';
            echo '</table><br>';
            
        $url_path = 'https://econtact.tech/grid_tbl_telefone_servidor/';

        $dados = http_build_query(array(
            'nmgp_parms' => 'under_dashboard*scin1*scoutSC_glo_par_cod_cpf*scincod_cpf*scout'
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

        echo '<table style="width: 80%;margin: auto; text-align: center;">
    <tr>
        <th>Telefones</th>
    </tr>';
        $resposta = file_get_contents($url_path, true, $contexto);
        $telefone = "";
        for ($i = 1; $i <= substr_count($resposta, 'id_sc_field_num_ddd_'); $i++) {
            echo '<tr>';
            $str1 = strpos($resposta, 'id="id_sc_field_num_ddd_' . $i) + 27;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str4 = str_replace('<span id="id_sc_field_num_telefone_' . $i . '">', '', substr($resposta, $str1, $str2));
            $str5 = str_replace('<', '', $str4);
            $str1 = strpos($resposta, 'id="id_sc_field_num_telefone_' . $i) + 32;
            $str11 = substr($resposta, $str1);
            $str2 = strpos($str11, '</span>');
            $str4 = str_replace('<span id="id_sc_field_num_telefone_' . $i . '">', '', substr($resposta, $str1, $str2));
            $str55 = str_replace('<', '', $str4);
            echo '<td>' . $str5 . $str55 . '</td>';
            echo '</tr>';
        }
        echo '</table><br>';
    }
} else {
    echo "<h3 style='text-align:center;margin:auto;'>CPF NÃO LOCALIZADO</h3>";
}
