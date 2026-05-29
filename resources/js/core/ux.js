App.setButtonLoading = function(button, isLoading, loadingText = 'Processando...') {
    if (!button) {
        return;
    }

    if (isLoading) {
        if (!button.dataset.originalHtml) {
            button.dataset.originalHtml = button.innerHTML;
        }

        button.disabled = true;
        button.classList.add('is-loading');
        button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText}`;
        return;
    }

    button.disabled = false;
    button.classList.remove('is-loading');

    if (button.dataset.originalHtml) {
        button.innerHTML = button.dataset.originalHtml;
    }
};

App.showModalLoading = function(containerId = 'modal-default-sistema') {
    const container = document.getElementById(containerId);

    if (!container) {
        return;
    }

    container.innerHTML = `
        <div class="fabrux-modal-loading" role="status" aria-live="polite">
            <span class="spinner-border text-primary" aria-hidden="true"></span>
            <span class="fabrux-modal-loading-text">Carregando formulário...</span>
        </div>
    `;
};

App.initUx = function() {
    App.initFormVisuals(document);
    App.normalizeFormStructure(document);
    App.initDataTableUx(document);
    App.applyEntranceAnimations(document);
    App.enableKeyboardA11y(document);
};

App.initFormVisuals = function(root = document) {
    const forms = root.querySelectorAll('form');

    forms.forEach((form) => {
        form.classList.add('fabrux-form');
    });
};

App.normalizeFormStructure = function(root = document) {
    const forms = root.querySelectorAll('form.fabrux-form, form');

    forms.forEach((form) => {
        if (form.dataset.structureNormalized === '1') {
            return;
        }

        form.dataset.structureNormalized = '1';

        form.querySelectorAll('.form-group').forEach((group) => {
            group.classList.add('fabrux-form-group');
        });

        form.querySelectorAll('.row').forEach((row) => {
            const className = row.className || '';

            if (className.includes('mb-')) {
                row.classList.add('fabrux-form-row');
            }
        });

        form.querySelectorAll('.invalid-feedback').forEach((feedback) => {
            feedback.classList.add('d-block');

            if (feedback.style && feedback.style.display === 'block') {
                feedback.style.removeProperty('display');
            }
        });

        const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');

        submitButtons.forEach((button) => {
            button.classList.add('fabrux-submit-btn');

            const footer = button.closest('.card-footer');

            if (footer) {
                footer.classList.add('fabrux-form-actions');
            }
        });
    });
};

App.initDataTableUx = function(root = document) {
    const tables = root.querySelectorAll('table[data-toggle]');

    tables.forEach((table) => {
        if (table.dataset.uxInitialized === '1') {
            return;
        }

        table.dataset.uxInitialized = '1';
        table.classList.add('fabrux-data-table');

        const refreshEmptyState = function() {
            App.refreshBootstrapTableEmptyState(table);
        };

        if (window.$) {
            window.$(table).on('post-body.bs.table page-change.bs.table load-error.bs.table', refreshEmptyState);
        }

        setTimeout(refreshEmptyState, 250);
    });
};

App.refreshBootstrapTableEmptyState = function(table) {
    if (!table) {
        return;
    }

    const wrapper = table.closest('.bootstrap-table') || table.parentElement;

    if (!wrapper) {
        return;
    }

    const body = wrapper.querySelector('.fixed-table-body');

    if (!body) {
        return;
    }

    const rows = body.querySelectorAll('tbody > tr');
    const hasRows = rows.length > 0 && !body.querySelector('.no-records-found');
    let emptyState = wrapper.querySelector('.fabrux-empty-state');

    if (hasRows) {
        if (emptyState) {
            emptyState.remove();
        }
        return;
    }

    if (!emptyState) {
        emptyState = document.createElement('div');
        emptyState.className = 'fabrux-empty-state';
        emptyState.innerHTML = `
            <i class="bi bi-inbox"></i>
            <p>Nenhum registro encontrado</p>
            <small>Quando houver dados, eles aparecerão aqui.</small>
        `;
        body.appendChild(emptyState);
    }
};

App.applyEntranceAnimations = function(root = document) {
    const targets = root.querySelectorAll('.card, .app-content-header .container-fluid, .alert, .small-box');

    targets.forEach((target, index) => {
        if (target.dataset.enterAnimated === '1') {
            return;
        }

        target.dataset.enterAnimated = '1';
        target.classList.add('fabrux-enter');
        target.style.setProperty('--fabrux-enter-delay', `${Math.min(index, 8) * 45}ms`);
    });
};

App.enableKeyboardA11y = function(root = document) {
    const interactive = root.querySelectorAll('a, button, input, select, textarea, [tabindex]');

    interactive.forEach((item) => {
        if (item.dataset.focusReady === '1') {
            return;
        }

        item.dataset.focusReady = '1';

        item.addEventListener('keyup', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                item.classList.add('fabrux-keyboard-focus');
            }
        });

        item.addEventListener('blur', function() {
            item.classList.remove('fabrux-keyboard-focus');
        });
    });
};