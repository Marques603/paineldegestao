// Third party packages
import '@fortawesome/fontawesome-free/js/all';
import feather from 'feather-icons';
import ResizeObserver from 'resize-observer-polyfill';
import 'simplebar';
import './bootstrap';

// Utilitário para carregar scripts dinamicamente baseado na rota
function loadScriptForRoute(route, path) {
    if (window.currentRoute === route) {
        import(path).catch(error => console.error(`Error loading ${path}:`, error));
    }
}

// Scripts dinâmicos por rota
const routeScripts = {
    'ecommerce.report': './custom/ecommerce.js',
    'dashboard': './custom/analytics.js',
    'calendar': './custom/calendar.js',
    'chat': './custom/chat.js',
    'email': './custom/email.js',
    'invoice.create': './custom/invoice-create.js',
    'table.data': './custom/data-table.js',
    'chart.index': './custom/apex-charts.js',
    'form.datepicker': './custom/datepicker.js',
    'form.editor': './custom/editor.js',
    'form.uploader': './custom/uploader.js',
    'form.validation': './custom/form-validation.js',
    'common.toast': './custom/toast.js',
    'common.modal': './custom/modal.js',
    'common.drawer': './custom/drawer.js',
    'common.carousel': './custom/carousel.js',
};

if (window.currentRoute && routeScripts[window.currentRoute]) {
    loadScriptForRoute(window.currentRoute, routeScripts[window.currentRoute]);
}

// Core components (importados e inicializados diretamente)
import accordion from './components/accordion';
import alert from './components/alert';
import carousel from './components/carousel';
import checkAll from './components/check-all';
import codeViewer from './components/code-viewer';
import datepicker from './components/datepicker';
import drawer from './components/drawer';
import dropdown from './components/dropdown';
import editor from './components/editor';
import modal from './components/modal';
import searchModal from './components/search-modal';
import select from './components/select';
import sidebar from './components/sidebar';
import tabs from './components/tabs';
import themeSwitcher from './components/theme-switcher';
import tooltip from './components/tooltip';
import uploader from './components/uploader';

// Inicialização global dos componentes
searchModal.init();
themeSwitcher.init();
codeViewer.init();
alert.init();
accordion.init();
dropdown.init();
modal.init();
sidebar.init();
tabs.init();
tooltip.init();
carousel.init();
editor.init();
select.init();
uploader.init();
datepicker.init();
drawer.init();
checkAll.init();

// Inicialização de feather icons (deve vir por último)
feather.replace();

// Polyfill para ResizeObserver
window.ResizeObserver = ResizeObserver;

// Inicialização do toats
// Verifica se o elemento existe antes de adicionar o evento
// Adiciona evento de clique para fechar o toast
// Remover toast manualmente ao clicar nele
document.addEventListener('click', function(event) {
    const toast = event.target.closest('.toast');
    if (toast) {
        toast.remove();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const selectItem = document.getElementById('item_id');
    const newItemFields = document.getElementById('new-item-fields');

    function toggleNewItemFields() {
        if (selectItem.value === 'new') {
            newItemFields.style.display = 'block';
        } else {
            newItemFields.style.display = 'none';
        }
    }

    // Chama ao carregar para manter estado correto se houve erro na validação
    toggleNewItemFields();

    // Chama quando o usuário muda a seleção
    selectItem.addEventListener('change', toggleNewItemFields);
});

document.addEventListener('DOMContentLoaded', function () {
    // Remover toast automaticamente após 2 segundos
    const toast = document.getElementById('toast');
    if (toast) {
        setTimeout(function () {
            toast.remove();
        }, 2000);
    }

    // Abrir/fechar modal de ícones
    const openBtn = document.getElementById('openIconPicker');
    const closeBtn = document.getElementById('closeIconPicker');
    const modal = document.getElementById('iconModal');
    const iconButtons = document.querySelectorAll('.icon-button');
    const iconInput = document.getElementById('iconeInput');

    if (openBtn && modal) {
        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    }

    if (closeBtn && modal) {
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    }

    iconButtons.forEach(button => {
        button.addEventListener('click', function () {
            const selectedIcon = this.getAttribute('data-icon');
            iconInput.value = selectedIcon;
            modal.classList.add('hidden');
            feather.replace(); // Atualiza os ícones
        });
    });
});
