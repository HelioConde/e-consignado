var saldoD = [];
var saldoL = [];
var saldoT = [];
var valorP = [];
var parcel = [];
var Rtaxa = [];
var porcen = [];
var coefin = [];
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
    
    
    if (devedor >= 100000.00){
        banco = 0.01610;
    } else if (devedor >= 80000.00){
        banco = 0.01639;
    } else if (devedor >= 50000.00){
        banco = 0.01668;
    } else if (devedor >= 20000.00){
        banco = 0.01712;
    } else if (devedor >= 10000.00){
        banco = 0.01857;
    } else if (devedor >= 5000.00){
        banco = 0.02147;
    }


    var result1 = valor / banco;
    var result5 = result1 - devedor;
    var valorLiberado = result5;

    saldoL.push(valorLiberado);
    valorP.push(valor);
    saldoD.push(devedor);
    coefin.push(banco);

    var data = "";
    for (obj in saldoL) {
        if (objd == 0) {
            data = `<tr><td>` + obj + `</td>
                    <td>` + valorP[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoD[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoL[obj].toFixed(2).toString().replace('.', ',') + `</td>
                    <td>` + coefin[obj] + `</td>
                    </tr>` + data;
            objd++;
        } else {
            data = `<tr class="active-row"><td>` + obj + `</td>
                    <td>` + valorP[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoD[obj].toString().replace('.', ',') + `</td>
                    <td>` + saldoL[obj].toFixed(2).toString().replace('.', ',') + `</td>
                    <td>` + coefin[obj] + `</td>
                    </tr>` + data;

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
                        <th>COEFICIENTE</th>
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