App.formatters = {
    boolean(value){
        return value == 1
            ? '<span class="text-success fw-bold">Sim</span>'
            : '<span class="text-danger fw-bold">Não</span>';
    }
};