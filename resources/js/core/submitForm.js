App.submitForm = function(options = {}) {

    const form = document.querySelector(options.form);

    if (!form) return;

    const formData = new FormData(form);

    App.fetch({
        url: form.action,
        method: form.method || "POST",
        data: formData,

        success: function(response){

            if(response.type === "success"){
                if(options.reload){
                    App.flash(response.message, response.type);
                    location.reload();
                }
                // fechar modal
                if(options.modal){
                    const modal = document.querySelector(options.modal);
                    if(modal){
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                }

                // atualizar tabela
                if(options.table){
                    $('#'+options.table).bootstrapTable('refresh');
                }
            }

        }
    });

}