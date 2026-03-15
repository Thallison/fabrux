App.dynamicFields = function(options = {}) {

    const config = {
        addButton: options.addButton,
        container: options.container,
        template: options.template,
        removeAction: options.removeAction || "remove-item"
    };

    const btnAdd = document.querySelector(config.addButton);
    const container = document.querySelector(config.container);

    if(!btnAdd || !container) return;

    btnAdd.addEventListener("click", function(e){
        e.preventDefault();

        const index = container.children.length + 1;

        const html = config.template(index);

        container.insertAdjacentHTML("beforeend", html);
    });

    document.addEventListener("click", function(e){

        const remove = e.target.closest(`[data-action="${config.removeAction}"]`);
        if(!remove) return;

        e.preventDefault();

        const row = remove.closest(".dynamic-item");
        if(row){
            row.remove();
        }

    });
};