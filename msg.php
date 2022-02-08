<?php
date_default_timezone_set('America/Sao_Paulo');
// CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
$hr = date('H', time());

echo $hr;
if($hr >= 12 && $hr<18) {
$resp = "Boa tarde!";}
else if ($hr >= 0 && $hr <12 ){
$resp = "Bom dia!";}
else {
$resp = "Boa noite!";}

echo '<script>window.location = "https://web.whatsapp.com/send?phone='.$_GET['telefone'].'&text='.$resp.'%0DMeu nome é '.$_GET['nome'].', o correspondente Bancario do Banco BRB.%0D%0DEntrei em contato recente com voce referente as parcelas do seu contracheque.%0DPoderia me encaminhar o EXTRATO DE CONSIGNACAO e o CONTRACHEQUE ATUALIZADOS*, por gentileza%0D(Com essa documentacao eu posso inserir no meu sistema e consigo ver o que consigo lhe oferecer hoje).%0D%0DFicarei no aguardo!"</script>';
?>