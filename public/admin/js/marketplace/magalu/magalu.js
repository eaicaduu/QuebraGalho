document.addEventListener('DOMContentLoaded', function () {
  const checkboxMagalu = localStorage.getItem('mercadoLivreChecked') === 'true';
  const container = document.getElementById('produtos');

  checkboxMagalu.addEventListener('change', function () {
    this.checked = false;
    Swal.fire({
      icon: 'info',
      title: 'Aviso',
      text: 'A integração com Magalu ainda não foi configurada.',
      confirmButtonText: 'OK'
    });
  });
});
