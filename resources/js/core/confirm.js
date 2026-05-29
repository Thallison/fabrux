App.confirm = function(options = {}) {

    const config = {
        title: options.title || "Confirmação",
        message: options.message || "Deseja realmente executar esta ação?",
        url: options.url || null,
        method: options.method || "DELETE",
        table: options.table || null,
        reload: options.reload || false
    };

    const modalHtml = `
        <div class="modal fade" id="appConfirmModal" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">${config.title}</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        ${config.message}
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-danger" id="confirmYes">Sim</button>
                    </div>

                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML("beforeend", modalHtml);

    const modalEl = document.getElementById("appConfirmModal");
    const modal = new bootstrap.Modal(modalEl);

    modal.show();

    document.getElementById("confirmYes").addEventListener("click", function(){
        const confirmButton = document.getElementById("confirmYes");
        App.setButtonLoading(confirmButton, true, 'Processando...');

        if(config.url){
            App.fetch({
                url: config.url,
                method: config.method,
                success: function(response){
                    App.setButtonLoading(confirmButton, false);

                    if(config.reload){
                        App.flash(response.message, response.type);
                        location.reload();
                    }
                    if(response.message){
                        App.message(response.message, response.type || "success");
                    }

                    if(config.table){
                        $('#'+config.table).bootstrapTable('refresh');
                    }

                    modal.hide();
                    modalEl.remove();
                },
                error: function(err){
                    App.setButtonLoading(confirmButton, false);

                    if(err && err.data && err.data.message){
                        App.message(err.data.message, 'danger');
                        return;
                    }

                    App.message('Não foi possível concluir a ação.', 'danger');
                }
            });

            return;
        }

        modal.hide();
        modalEl.remove();

    });

};