App.dynamicFields = function(options = {}) {

    const config = {
        addButton: options.addButton,
        container: options.container,
        template: options.template,
        removeAction: options.removeAction || "remove-item",

        // hooks
        beforeAdd: options.beforeAdd || null,
        afterAdd: options.afterAdd || null,
        beforeRemove: options.beforeRemove || null,
        afterRemove: options.afterRemove || null,
    };

    const btnAdd = document.querySelector(config.addButton);
    const container = document.querySelector(config.container);

    if (!btnAdd || !container) return;

    // ADD
    btnAdd.addEventListener("click", function(e){
        e.preventDefault();

        const index = container.children.length + 1;

        // hook beforeAdd (pode cancelar)
        if (config.beforeAdd) {
            const allow = config.beforeAdd({ index, container });
            if (allow === false) return;
        }

        const html = config.template(index);

        if (!html) return;

        container.insertAdjacentHTML("beforeend", html);

        const addedElement = container.lastElementChild;

        // hook afterAdd
        if (config.afterAdd) {
            config.afterAdd({ element: addedElement, index });
        }
    });

    // REMOVE (delegação)
    document.addEventListener("click", function(e){

        const btn = e.target.closest(`[data-action="${config.removeAction}"]`);
        if (!btn) return;

        e.preventDefault();

        const row = btn.closest(".dynamic-item");
        if (!row) return;

        // hook beforeRemove
        if (config.beforeRemove) {
            const allow = config.beforeRemove({ element: row, button: btn });
            if (allow === false) return;
        }

        row.remove();

        // hook afterRemove
        if (config.afterRemove) {
            config.afterRemove({ element: row, button: btn });
        }

    });
};