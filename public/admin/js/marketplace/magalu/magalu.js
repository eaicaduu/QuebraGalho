document.addEventListener('DOMContentLoaded', function () {
  const checkboxMagalu = document.getElementById('switchMagalu');
  
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
