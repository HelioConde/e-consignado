
var saldoD = [];
var saldoL = [];
var saldoT = [];
var valorP = [];
var parcel = [];
var Rtaxa = [];
var porcen = [];
var objd = 0;

var momentoAtual = new Date();

var dia = momentoAtual.getDate();

dia2 = dia - 4;

c1 = 0.0000080916 * dia2;

var c2 = 0.0189190062 - c1;

banco = c2;

banco = banco.toString().substring(0, 7);

console.log(banco);

function valor() {
    document.getElementById("valor").value = document.getElementById("valor").value.replace('.', '');
}
function valorS() {
    document.getElementById("devedor").value = document.getElementById("devedor").value.replace('.', '');
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
    if (valor == ""){
        return;
    }
    valor = parseFloat(valor.replace(',', '.'));
    var devedor = document.getElementById("devedor").value;
    if (devedor == ""){
        return;
    }
    devedor = parseFloat(devedor.replace(',', '.'));

    var result1 = valor / banco;
    var result2 = 4.55 / 100;
    var result3 = result2 * result1;
    var result4 = result1 + result3;
    var result5 = result4 - devedor;
    var result6 = 4.55 / 100;
    var result7 = result6 * result5;
    console.log(result7);
    console.log(result5);
    var valorLiberado = result5 - result7;

    saldoL.push(valorLiberado);
    valorP.push(valor);
    saldoD.push(devedor);

    var data = "";
    for (obj in saldoL) {
        if (objd == 0) {
            data = `<tr><td>` + obj + `</td>
                    <td>` + valorP[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoD[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoL[obj].toFixed(2).toString().replace('.', ',') + `</td></tr>` + data;
            objd++;
        } else {
            data = `<tr class="active-row"><td>` + obj + `</td>
                    <td>` + valorP[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoD[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoL[obj].toFixed(2).toString().replace('.', ',') + `</td></tr>` + data;

        }
    }
    document.getElementById("resultado").innerHTML = `
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>VALOR DAS PARCELAS</th>
                        <th>SALDO DEVEDOR</th>
                        <th>VALOR LIBERADO</th>
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