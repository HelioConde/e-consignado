let selectedFile;
console.log(window.XLSX);
document.getElementById('input').addEventListener("change", (event) => {
    selectedFile = event.target.files[0];
})

let data = [{
    "name": "jayanth",
    "data": "scd",
    "abc": "sdef"
}]

var parar = "";
var log = "";
document.getElementById('stop').addEventListener("click", () => {
    parar = "stop";
});
document.getElementById('start').addEventListener("click", () => {
    parar = "";
    loop(log);
});

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
    $(".dropBox p").html(valor)
    dropSelect()
}

document.getElementById('button').addEventListener("click", () => {
    XLSX.utils.json_to_sheet(data, 'out.xlsx');
    if (selectedFile) {
        let fileReader = new FileReader();
        fileReader.readAsBinaryString(selectedFile);
        fileReader.onload = (event) => {
            let data = event.target.result;
            let workbook = XLSX.read(data, { type: "binary" });
            console.log(workbook);
            workbook.SheetNames.forEach(sheet => {
                let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                log = rowObject;
                loop(log)
            });
        }
    }
});
var valor = "";
var soma = 0;
function loop(log) {
    $(".inicio").css({
        'display': 'none'
    })
    $(".start").css({
        'display': 'none'
    })
    $(".stop").css({
        'display': 'inline-block'
    })
    $(".upload-btn-wrapper").css({
        'display': 'none'
    })
    rowObject = log;
    if (valor == "") {
        valor = rowObject.length;
        console.log(valor);
    }
    console.log(soma);
    console.log(parar);
    if (parar == "stop") {
        $(".inicio").css({
            'display': 'none'
        })
        $(".start").css({
            'display': 'inline-block'
        })
        $(".stop").css({
            'display': 'none'
        })
    } else {
        document.getElementById("quantidade").innerHTML = 'Quantidade :' + valor;
        document.getElementById("valor").innerHTML = 'Atual :' + soma;
        let cpf = Object.values(rowObject[soma])[0];
        var nome = "";
        let data = "";
        var banco = "";
        let telefones = "";
        console.log(cpf);
        $.ajax({
            url: "1enviar.php",
            data: {
                "cpf": cpf
            },
            type: "POST",
            success: function (response) {
                if (response == "sucess") {
                    $.ajax({
                        url: "2dados.php",
                        type: "POST",
                        success: function (response) {
                            console.log(response);
                            if (JSON.parse(response).nome == nome) {
                                loop();
                            } else {
                                nome = JSON.parse(response).nome;
                                data = JSON.parse(response).data;
                            }
                            $.ajax({
                                url: "3banco.php",
                                data: {
                                    "filtro": $(".dropBox p").html()
                                },
                                type: "POST",
                                success: function (response) {
                                    console.log(JSON.parse(response));
                                    if (JSON.parse(response)[0] == undefined) {
                                        setTimeout(() => {
                                            soma++;
                                            loop(log);
                                        }, 500);
                                    } else {
                                        if (JSON.stringify(response) == JSON.stringify(banco)) {
                                            loop(log);
                                        } else {
                                            if (banco == response){
                                                loop(log);
                                            } else {
                                                banco = response;
                                            }
                                            $.ajax({
                                                url: "4telefone.php",
                                                type: "POST",
                                                success: function (response) {
                                                    telefones = response;
                                                    $("#result").html(
                                                        '<div>CPF :' + cpf +
                                                        '<br><br>NOME :' + nome +
                                                        '<br><br>IDADE :' + data +
                                                        '<br><br>BANCO :' + banco +
                                                        '<br><br>TELEFONE :' + telefones + '</div>'
                                                    )
                                                    $.ajax({
                                                        url: "save.php",
                                                        data: {
                                                            "cpf": cpf,
                                                            "nome": nome,
                                                            "nascimento": data,
                                                            "banco": banco,
                                                            "telefone": telefones
                                                        },
                                                        type: "POST",
                                                        success: function (response) {
                                                            console.log(response);
                                                            setTimeout(() => {
                                                                banco = "";
                                                                soma++;
                                                                loop(log);
                                                            }, 500);
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    }
                                }
                            });
                        }
                    });
                } else {
                    setTimeout(() => {
                        soma++;
                        loop(log);
                    }, 500);
                }
            }
        });
    }
}