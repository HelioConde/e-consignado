<?php
$cookies = '469c113a94cf431af915b9c742f69c02';

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

    $resposta = file_get_contents('https://econtact.tech/app_Login/index.php?nm_form_submit=1&nmgp_idioma_novo=&nmgp_schema_f=&nmgp_url_saida=&bok=OK&nmgp_opcao=&nmgp_ancora=&nmgp_num_form=&nmgp_parms=&script_case_init=3073&NM_cancel_return_new=&csrf_token=K9zQ5%2C%28S%295%5DbHj7%296%7BotI46l_HbIpGnP%7BX00Gg%7D95OLk7g6%402GssGy%28IfD%5D%5DavIz&login=hugo.taurus&pswd=taurus2021', true, $contexto);

    echo $resposta;