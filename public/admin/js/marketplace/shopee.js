document.addEventListener('DOMContentLoaded', function () {
  const checkboxShopee = document.getElementById('switchShopee');
  const container = document.getElementById('produtos');

  checkboxShopee.addEventListener('change', function () {
    this.checked = false;
    Swal.fire({
      icon: 'info',
      title: 'Aviso',
      text: 'A integração com Shopee ainda não foi configurada.',
      confirmButtonText: 'OK'
    });
  });
});
