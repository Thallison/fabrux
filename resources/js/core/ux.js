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

        App.bindBootstrapTableFullscreen(table);

        setTimeout(refreshEmptyState, 250);
    });
};

App.bindBootstrapTableFullscreen = function(table) {
    if (!table || table.dataset.fullscreenBound === '1') {
        return;
    }

    table.dataset.fullscreenBound = '1';

    const cleanupStyles = function(wrapper, touchedAncestors) {
        document.body.classList.remove('fabrux-table-fullscreen-open');

        if (wrapper) {
            wrapper.style.removeProperty('position');
            wrapper.style.removeProperty('inset');
            wrapper.style.removeProperty('z-index');
            wrapper.style.removeProperty('width');
            wrapper.style.removeProperty('height');
            wrapper.style.removeProperty('margin');
            wrapper.style.removeProperty('padding');
            wrapper.style.removeProperty('background');
            wrapper.style.removeProperty('overflow');
        }

        touchedAncestors.forEach((item) => {
            if (!item || !item.element) {
                return;
            }

            if (item.transform === null) {
                item.element.style.removeProperty('transform');
            } else {
                item.element.style.setProperty('transform', item.transform, 'important');
            }
        });

        touchedAncestors.length = 0;
    };

    const startBinding = function() {
        const wrapper = table.closest('.bootstrap-table') || table.parentElement;

        if (!wrapper || wrapper.dataset.fullscreenObserverReady === '1') {
            return;
        }

        wrapper.dataset.fullscreenObserverReady = '1';
        const touchedAncestors = [];

        const applyFullscreen = function() {
            const isFullscreen = wrapper.classList.contains('fullscreen');

            if (!isFullscreen) {
                cleanupStyles(wrapper, touchedAncestors);
                return;
            }

            document.body.classList.add('fabrux-table-fullscreen-open');
            wrapper.style.setProperty('position', 'fixed', 'important');
            wrapper.style.setProperty('inset', '0', 'important');
            wrapper.style.setProperty('z-index', '3000', 'important');
            wrapper.style.setProperty('width', '100vw', 'important');
            wrapper.style.setProperty('height', '100vh', 'important');
            wrapper.style.setProperty('margin', '0', 'important');
            wrapper.style.setProperty('padding', '1rem', 'important');
            wrapper.style.setProperty('background', '#ffffff', 'important');
            wrapper.style.setProperty('overflow', 'auto', 'important');

            if (touchedAncestors.length === 0) {
                let ancestor = wrapper.parentElement;

                while (ancestor && ancestor !== document.body) {
                    const computedStyle = window.getComputedStyle(ancestor);

                    if (computedStyle.transform && computedStyle.transform !== 'none') {
                        touchedAncestors.push({
                            element: ancestor,
                            transform: ancestor.style.transform || null,
                        });
                        ancestor.style.setProperty('transform', 'none', 'important');
                    }

                    ancestor = ancestor.parentElement;
                }
            }

            if (window.$) {
                window.$(table).bootstrapTable('resetView');
            }
        };

        const toggleNativeFullscreen = function() {
            const supportsNativeFullscreen = document.fullscreenEnabled && typeof wrapper.requestFullscreen === 'function';

            if (!supportsNativeFullscreen) {
                return false;
            }

            if (document.fullscreenElement === wrapper) {
                document.exitFullscreen();
                return true;
            }

            if (document.fullscreenElement) {
                return false;
            }

            wrapper.requestFullscreen();
            return true;
        };

        const observer = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    applyFullscreen();
                    break;
                }
            }
        });

        observer.observe(wrapper, {
            attributes: true,
            attributeFilter: ['class'],
        });

        wrapper.addEventListener('click', function(event) {
            const trigger = event.target.closest('button[name="fullscreen"], .btn[name="fullscreen"]');

            if (!trigger) {
                return;
            }

            if (toggleNativeFullscreen()) {
                event.preventDefault();
                event.stopPropagation();
            }

            setTimeout(applyFullscreen, 0);
        }, true);

        document.addEventListener('fullscreenchange', function() {
            const isNativeFullscreen = document.fullscreenElement === wrapper;

            if (!isNativeFullscreen) {
                cleanupStyles(wrapper, touchedAncestors);
            }

            if (window.$) {
                window.$(table).bootstrapTable('resetView');
            }
        });

        window.addEventListener('resize', function() {
            if (!wrapper.classList.contains('fullscreen') && document.fullscreenElement !== wrapper) {
                return;
            }

            if (window.$) {
                window.$(table).bootstrapTable('resetView');
            }
        });
    };

    setTimeout(startBinding, 150);
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