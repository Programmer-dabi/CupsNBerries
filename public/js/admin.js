document.addEventListener('DOMContentLoaded', () => {
  const modal = document.querySelector('[data-admin-modal]');
  if (!modal) return;

  if (typeof modal.showModal === 'function') {
    modal.removeAttribute('open');
    modal.showModal();
  }
  modal.addEventListener('cancel', (event) => {
    event.preventDefault();
    window.location.assign('/admin');
  });

  const form = modal.querySelector('[data-admin-stock-form]');
  if (form) {
    const variant = form.querySelector('[data-stock-variant]');
    variant.addEventListener('change', () => {
      const stock = variant.selectedOptions[0].dataset.stock;
      form.querySelector('[data-expected-stock]').value = stock;
      form.querySelector('[data-current-stock]').textContent = stock;
      form.querySelector('[data-new-stock]').value = stock;
    });
  }
});
