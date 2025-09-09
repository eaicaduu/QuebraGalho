document.addEventListener('DOMContentLoaded', function () {
  const checkboxAmazon = document.getElementById('switchAmazon');
  const container = document.getElementById('produtos');

  checkboxAmazon.addEventListener('change', function () {
    this.checked = false;
    Swal.fire({
      icon: 'info',
      title: 'Aviso',
      text: 'A integração com Amazon ainda não foi configurada.',
      confirmButtonText: 'OK'
    });
  });
});
