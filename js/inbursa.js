
var saldoD = [];
var saldoL = [];
var saldoT = [];
var valorP = [];
var parcel = [];
var Rtaxa = [];
var porcen = [];
var objd = 0;


function valor() {
    document.getElementById("devedor").value = document.getElementById("devedor").value.replace('.', '');
}
function valorS() {
    document.getElementById("parcelas").value = document.getElementById("parcelas").value.replace('.', '');
}

function onlynumber(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    //var regex = /^[0-9.]+$/;
    var regex = /^[0-9,]+$/;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

function calcular() {
    var saldoDevedor = document.getElementById("devedor").value;
    if (saldoDevedor == ""){
        return;
    }
    saldoDevedor = saldoDevedor.replace(',', '.')
    var parcela = document.getElementById("parcelas").value;
    if (parcela == ""){
        return;
    }
    if (parcela == "95") {
        banco = saldoDevedor * 0.017198
    } else if (parcela == "94") {
        banco = saldoDevedor * 0.017301
    } else if (parcela == "93") {
        banco = saldoDevedor * 0.017408
    } else if (parcela == "92") {
        banco = saldoDevedor * 0.017503
    } else if (parcela == "91") {
        banco = saldoDevedor * 0.017628
    } else if (parcela == "90") {
        banco = saldoDevedor * 0.017742
    } else if (parcela == "89") {
        banco = saldoDevedor * 0.017859
    } else if (parcela == "88") {
        banco = saldoDevedor * 0.017979
    } else if (parcela == "87") {
        banco = saldoDevedor * 0.018101
    } else if (parcela == "86") {
        banco = saldoDevedor * 0.018227
    } else if (parcela == "85") {
        banco = saldoDevedor * 0.018355
    } else if (parcela == "84") {
        banco = saldoDevedor * 0.018488
    } else if (parcela == "83") {
        banco = saldoDevedor * 0.018623
    } else if (parcela == "82") {
        banco = saldoDevedor * 0.018762
    } else if (parcela == "81") {
        banco = saldoDevedor * 0.018905
    } else if (parcela == "80") {
        banco = saldoDevedor * 0.019052
    } else if (parcela == "79") {
        banco = saldoDevedor * 0.019202
    } else if (parcela == "78") {
        banco = saldoDevedor * 0.019201
    } else if (parcela == "77") {
        banco = saldoDevedor * 0.019516
    } else if (parcela == "76") {
        banco = saldoDevedor * 0.019679
    } else if (parcela == "75") {
        banco = saldoDevedor * 0.019847
    } else if (parcela == "74") {
        banco = saldoDevedor * 0.020021
    } else if (parcela == "73") {
        banco = saldoDevedor * 0.020198
    } else if (parcela == "72") {
        banco = saldoDevedor * 0.020381
    } else if (parcela == "71") {
        banco = saldoDevedor * 0.020569
    } else if (parcela == "70") {
        banco = saldoDevedor * 0.020763
    } else if (parcela == "69") {
        banco = saldoDevedor * 0.020963
    } else if (parcela == "68") {
        banco = saldoDevedor * 0.021169
    } else if (parcela == "67") {
        banco = saldoDevedor * 0.021382
    } else if (parcela == "66") {
        banco = saldoDevedor * 0.021601
    } else if (parcela == "65") {
        banco = saldoDevedor * 0.021827
    } else if (parcela == "64") {
        banco = saldoDevedor * 0.022061
    } else if (parcela == "63") {
        banco = saldoDevedor * 0.022303
    } else if (parcela == "62") {
        banco = saldoDevedor * 0.022552
    } else if (parcela == "61") {
        banco = saldoDevedor * 0.022811
    } else if (parcela == "60") {
        banco = saldoDevedor * 0.023077
    } else if (parcela == "59") {
        banco = saldoDevedor * 0.023353
    } else if (parcela == "58") {
        banco = saldoDevedor * 0.023641
    } else if (parcela == "57") {
        banco = saldoDevedor * 0.023936
    } else if (parcela == "56") {
        banco = saldoDevedor * 0.024244
    } else if (parcela == "55") {
        banco = saldoDevedor * 0.024563
    } else if (parcela == "54") {
        banco = saldoDevedor * 0.024894
    } else if (parcela == "53") {
        banco = saldoDevedor * 0.025238
    } else if (parcela == "52") {
        banco = saldoDevedor * 0.025596
    } else if (parcela == "51") {
        banco = saldoDevedor * 0.025969
    } else if (parcela == "50") {
        banco = saldoDevedor * 0.026356
    } else if (parcela == "49") {
        banco = saldoDevedor * 0.026759
    } else if (parcela == "48") {
        banco = saldoDevedor * 0.027181
    } else if (parcela >= "36") {
        banco = saldoDevedor * 0.034097
    } else if (parcela >= "24") {
        banco = saldoDevedor * 0.048052
    } else if (parcela >= "12") {
        banco = saldoDevedor * 0.090166
    } else {
        document.getElementById("resultado").innerHTML = "<div style='color: red; font-size: 25px;'>Coeficiente não encontrado, entrar em contato com o SUPERVISOR</div>";
        return;
    }

    valorLiberado = banco;

    saldoD.push(saldoDevedor);
    saldoL.push(valorLiberado);
    parcel.push(parcela);

    var data = "";
    for (obj in saldoL) {
        if (objd == 0) {
            data = `<tr><td>` + obj + `</td>
                    <td>` + saldoD[obj].toString().replace('.', ',') + `</td>
                    <td>` + parcel[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoL[obj].toFixed(2).toString().replace('.', ',') + `</td></tr>` + data;
            objd++;
        } else {
            data = `<tr><td>` + obj + `</td>
                    <td>` + saldoD[obj].toString().replace('.', ',') + `</td>
                    <td>` + parcel[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoL[obj].toFixed(2).toString().replace('.', ',') + `</td></tr>` + data;
            objd = 0;
        }
    }

    document.getElementById("resultado").innerHTML = `
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>SALDO DEVEDOR</th>
                        <th>PARCELA</th>          
                        <th>PARCELA NOVA</th> 
                    </tr>
                </thead>
                <tbody>
                ` + data + `
                </tbody>
            </table>
            `;

}

function limpar() {
    saldoD = [];
    saldoL = [];
    valorP = [];
    document.getElementById("resultado").innerHTML = "";
}
