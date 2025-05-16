import TomSelect from 'tom-select';

const select = {
  init() {
    const tomSelects = document.querySelectorAll('.tom-select');

    function setContainerHeightAuto(s) {
      const container = select.control.$dropdown_content;
      container.style.height = 'auto';
    }

    if (tomSelects.length) {
      [...tomSelects].forEach((select) => {
        new TomSelect(select, {
          plugins: ['dropdown_input', 'remove_button'], // <- importante aqui
          highlight: false,
        });
      });
    }
  },
};

export default select;
