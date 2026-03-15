var G_FLAG = { '1': 'Sim', '0': 'Não'};

var _flgGrid = function (value) {
    var ativo = '<span style="color:#dc3545;font-weight: bold;">Não</span>';
    if(value == 1){
        ativo = '<span  style="color:#28a745;font-weight: bold;">Sim</span>';
    }
    return [
        ativo
    ].join("");
}