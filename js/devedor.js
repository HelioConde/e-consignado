var saldoD = [];
var saldoL = [];
var saldoT = [];
var valorP = [];
var parcel = [];
var Rtaxa = [];
var porcen = [];
var objd = 0;

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

var dropBar = false
function dropSelect() {
    if (dropBar == false) {
        $(".dropdownOption-content").css({
            "display": "block"
        })
        $(".fa-active").css({
            "transform": "rotate(180deg)",
            "filter": "invert(100%) sepia(79%) saturate(2476%) hue-rotate(86deg) brightness(118%) contrast(119%)"
        })
        dropBar = true;
    } else {
        $(".dropdownOption-content").css({
            "display": "none"
        })
        $(".fa-active").css({
            "transform": "rotate(0)",
            "filter": "invert(100%)"
        })
        dropBar = false;
    }
}

function dropSelectSend(valor) {
    $(".dropBox p").html(valor + "%")
    dropSelect()
}

function valor() {
    document.getElementById("valor").value = document.getElementById("valor").value.replace('.', '');
}
function valorS() {
    document.getElementById("devedor").value = document.getElementById("devedor").value.replace('.', '');
}

function calcular() {
    var valor = document.getElementById("valor").value;
    if (valor == ""){
        return;
    }
    valor = parseFloat(valor.replace(',', '.'));
    var parcela = document.getElementById("parcela").value;
    if (parcela == ""){
        return;
    }
    var porcentagem = $(".dropBox p").html().replace('%', '');
    var Rdtaxa = "";

    var valor1 = parseFloat(valor * parcela);
    var valor2 = parseFloat(porcentagem / 100);
    var valor3 = parseFloat(valor2 * valor1);
    var saldoDevedor = parseFloat(valor1 - valor3);


    saldoDevedor = '' + saldoDevedor + '';
    saldoDevedor = saldoDevedor.replace('.', ',');
    console.log(saldoDevedor);
    console.log("Saldo devedor: " + saldoDevedor);
    if (porcentagem == "35") {
        Rtaxa.push(Rdtaxa);
    } else {
        Rtaxa.push("-");
    }

    valorP.push(valor);
    parcel.push(parcela);
    saldoD.push(saldoDevedor);
    porcen.push(porcentagem);
    var data = "";

    for (obj in saldoD) {
        if (Rtaxa[obj] == "-") {
            resulTa = "-";
        } else {
            resulTa = parseFloat(valorP[obj] - Rtaxa[obj]).toFixed(2);
            console.log(valorP[obj]);
        }
        if (objd == 0) {
            data = `<tr><td>` + obj + `</td>
                    <td>` + valorP[obj] + `</td>
                    <td>` + parcel[obj] + `</td>
                    <td>` + saldoD[obj] + `</td>
                    <td>` + porcen[obj] + `%</td></tr>` + data;
            objd++;
        } else {
            data = `<tr class="active-row"><td>` + obj + `</td>
                    <td>` + valorP[obj] + `</td>
                    <td>` + parcel[obj] + `</td>
                    <td>` + saldoD[obj] + `</td>
                    <td>` + porcen[obj] + `%</td></tr>` + data;
            objd = 0;
        }
    }
    document.getElementById("resultado").innerHTML = `
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>VALOR DAS PARCELAS</th>
                <th>PARCELAS</th>
                <th>SALDO DEVEDOR</th>
                <th>%</th>
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
    saldoT = [];
    valorP = [];
    parcel = [];
    Rtaxa = [];
    porcen = [];
    document.getElementById("resultado").innerHTML = "";
    valor = document.getElementById("valor").value = "";
    parcela = document.getElementById("parcela").value = "";
}