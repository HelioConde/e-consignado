
var saldoD = [];
var saldoL = [];
var saldoT = [];
var valorP = [];
var parcel = [];
var Rtaxa = [];
var porcen = [];
var objd = 0;

function valor() {
    document.getElementById("valor").value = document.getElementById("valor").value.replace('.', '');
}
function valorS() {
    document.getElementById("devedor").value = document.getElementById("devedor").value.replace('.', '');
}
function valorN() {
    document.getElementById("parcela").value = document.getElementById("parcela").value.replace('.', '');
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
    var valor = document.getElementById("valor").value;
    if (valor == "") {
        return;
    }
    valor = parseFloat(valor.replace(',', '.'));
    var saldoDevedor = document.getElementById("devedor").value
    if (saldoDevedor == "") {
        return;
    }
    saldoDevedor = parseFloat(saldoDevedor.replace(',', '.'));
    var parcela = document.getElementById("parcela").value;
    if (parcela == "") {
        return;
    }

    montante_float = saldoDevedor;
    per_int = parcela;
    parcela_float = valor;

    juros_inicial = parseFloat("-1")
    juros_final = parseFloat("99999")
    suposto_juros = parseFloat("0")
    suposto_parcela = parseFloat("0")

    var cont = 1
    var achou = false
    while (true) {
        suposto_juros = (juros_final + juros_inicial) / 2
        suposto_parcela = (montante_float * suposto_juros) / (1 - Math.pow(1 / (1 + suposto_juros), per_int))
        suposta_diferenca = Math.abs(parcela_float - suposto_parcela)
        if (suposta_diferenca > 0.000000001) {
            if (suposto_parcela > parcela_float) {
                juros_final = suposto_juros
            }
            else {
                juros_inicial = suposto_juros
            }
        }
        else {
            achou = true
            break
        }
        if (cont > 5000) {
            break
        }
        cont++
    }
    if (achou == false) {
        document.form1.juros.value = "NaN"
    }
    else {
        if (suposto_juros != -100) {
            suposto_juros = suposto_juros * 100
        }
        juros_float = Math.round(suposto_juros * 100000) / 100000
        var s = String(juros_float)
        i = s.indexOf(".")
        if (i != -1) {
            s = s.substring(0, i) + "," + s.substring(i + 1, s.length)
        }
        taxa = s;
    }

    valorP.push(valor);
    saldoD.push(saldoDevedor);
    parcel.push(parcela);
    saldoT.push(taxa);

    var data = "";
    for (obj in saldoD) {
        if (objd == 0) {
            data = `<tr><td>` + obj + `</td>
                    <td>` + valorP[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoD[obj].toString().replace('.', ',') + `</td>
                    <td>` + parcel[obj] + `</td>
                    <td>` + saldoT[obj].toString().replace('.', ',') + `%</td></tr>` + data;
            objd++;
        } else {
            data = `<tr class="active-row"><td>` + obj + `</td>
                    <td>` + valorP[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoD[obj].toString().replace('.', ',') + `</td>
                    <td>` + parcel[obj] + `</td>
                    <td>` + saldoT[obj].toString().replace('.', ',') + `%</td></tr>` + data;
            objd = 0;
        }
    }

    document.getElementById("resultado").innerHTML = `
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>VALOR DAS PARCELAS</th>
                        <th>SALDO DEVEDOR</th>
                        <th>PARCELAS</th>  
                        <th>TAXA %</th>
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
