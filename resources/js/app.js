import.meta.glob([
    '../images/**',
    '../fonts/**'
]);

import $ from "jquery";
window.$ = window.jQuery = $;

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.bootstrap5.min.css';
window.TomSelect = TomSelect;

import 'admin-lte';
import 'bootstrap-table';

import 'bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js';
import 'bootstrap-table/dist/Locale/bootstrap-table-pt-BR.min.js';
        
import './core/app';
import './core/fetch';
import './core/modal';
import './core/submitForm';
import './core/message';
import './core/confirm';
import './core/global';
import './core/dynamicFields';
import './core/formatters';
import './core/flashMessage';
import './core/ux';

function initTomSelectFields(root = document) {
    if (!window.TomSelect) {
        return;
    }

    const selects = root.querySelectorAll('select[data-tom-select="true"]');

    selects.forEach((select) => {
        if (select.tomselect) {
            return;
        }

        const placeholder = select.dataset.tomSelectPlaceholder || 'Selecione...';
        const maxOptions = Number(select.dataset.tomSelectMaxOptions || 500);

        new window.TomSelect(select, {
            create: false,
            persist: false,
            closeAfterSelect: true,
            allowEmptyOption: true,
            placeholder,
            maxOptions,
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    App.init();
    App.initFlash();
    App.initUx();
    initTomSelectFields(document);
});

document.addEventListener('modal:loaded', function (event) {
    const root = event?.detail?.modal || document;
    App.initFormVisuals(root);
    App.normalizeFormStructure(root);
    App.initDataTableUx(root);
    App.applyEntranceAnimations(root);
    App.enableKeyboardA11y(root);
    initTomSelectFields(root);
});